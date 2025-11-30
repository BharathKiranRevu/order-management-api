<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Order extends ResourceController
{
    use ResponseTrait;

   
    public function index()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return $this->failUnauthorized('Login required');
        }

        $orderModel = new \App\Models\OrderModel();

        $orders = $orderModel
            ->select('orders.*, users.name as user_name')
            ->join('users', 'users.id = orders.user_id')
            ->where('orders.user_id', $userId)
            ->orderBy('orders.id', 'DESC')
            ->findAll();

        foreach ($orders as &$order) {
            $items = (new \App\Models\OrderItemModel())
                ->select('order_items.*, products.name as product_name')
                ->join('products', 'products.id = order_items.product_id')
                ->where('order_id', $order['id'])
                ->findAll();
            $order['items'] = $items;
        }

        return $this->respond($orders);
    }

    // POST /api/orders → create order
    public function create()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return $this->failUnauthorized('Login required');
        }

        $json  = $this->request->getJSON(true);
        $items = $json['items'] ?? [];

        if (empty($items)) {
            return $this->failValidationErrors('Items array is required');
        }

        $db             = \Config\Database::connect();
        $orderModel     = new \App\Models\OrderModel();
        $orderItemModel = new \App\Models\OrderItemModel();
        $productModel   = new \App\Models\ProductModel();

        $db->transStart();

        $total          = 0;
        $orderItemsData = [];

        foreach ($items as $item) {
            $productId = $item['product_id'] ?? 0;
            $quantity  = $item['quantity'] ?? 0;

            $product = $productModel->find($productId);
            if (!$product) {
                $db->transRollback();
                return $this->failNotFound("Product ID $productId not found");
            }
            if ($product['stock'] < $quantity) {
                $db->transRollback();
                return $this->fail("Insufficient stock for {$product['name']}", 400);
            }

            $total += $product['price'] * $quantity;

            $orderItemsData[] = [
                'product_id' => $productId,
                'quantity'   => $quantity,
                'price'      => $product['price'],
            ];

            // Reduce stock
            $productModel->decrement('stock', $quantity, ['id' => $productId]);
        }

        // Create order
        $orderId = $orderModel->insert([
            'user_id'      => $userId,
            'total_amount'  => $total,
            'status'       => 'pending',
        ]);

        // Save order items
        foreach ($orderItemsData as &$oi) {
            $oi['order_id'] = $orderId;
        }
        $orderItemModel->insertBatch($orderItemsData);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->failServerError('Order creation failed');
        }

        return $this->respondCreated([
            'status'   => 'success',
            'message'  => 'Order created successfully',
            'order_id' => $orderId,
            'total'    => $total,
        ]);
    }

    // POST /api/orders/{id}/cancel → bonus
   public function cancel($id = null)
{
    $userId = session()->get('user_id');
    if (!$userId) return $this->failUnauthorized('Login required');

    $orderModel = new \App\Models\OrderModel();
    $order = $orderModel->find($id);

    if (!$order) 
        return $this->failNotFound('Order not found');

    if ($order['user_id'] != $userId)
        return $this->failForbidden('You are not allowed to cancel this order');

    if ($order['status'] !== 'pending')
        return $this->fail('Only pending orders can be cancelled', 400);

    $db = \Config\Database::connect();
    $db->transStart();

    $items = (new \App\Models\OrderItemModel())->where('order_id', $id)->findAll();
    foreach ($items as $item) {
        $qty = (int)$item['quantity'];
        (new \App\Models\ProductModel())->increment('stock', $qty, ['id' => $item['product_id']]);
    }

    $orderModel->update($id, ['status' => 'cancelled']);
    $db->transComplete();

    return $this->respond([
        'status'  => 'success',
        'message' => 'Order cancelled and stock restored'
    ]);
}

}