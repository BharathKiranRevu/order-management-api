<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;



class Products extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\ProductModel';
    protected $format    = 'json';

    private function requireLogin()
    {
        if (!session()->has('is_logged')) {
            return $this->respond(['error' => 'Unauthorized. Please login first.'], 401);
        }
    }

    public function index()
    {
        $model = $this->model;

        // Optional search
        $search = $this->request->getGet('search');
        if ($search) {
            $model->like('name', $search)->orLike('sku', $search);
        }

        $perPage = $this->request->getGet('per_page') ?? 10;
        $products = $model->paginate($perPage);

        return $this->respond([
            'data' => $products,
            'pagination' => [
                'current_page' => $model->pager->getCurrentPage(),
                'total_pages'  => $model->pager->getPageCount(),
                'total_items'  => $model->pager->getTotal(),
                'per_page'     => $perPage
            ]
        ]);
    }

    // GET /api/products/{id}
    public function show($id = null)
    {
        $product = $this->model->find($id);

        if (!$product) {
            return $this->failNotFound('Product not found');
        }

        return $this->respond($product);
    }

    // POST /api/products → Create
    public function create()
    {
        $this->requireLogin();

        $json = $this->request->getJSON(true);

        $rules = [
            'name'  => 'required|min_length[3]|max_length[100]',
            'sku'   => 'required|min_length[3]|is_unique[products.sku]',
            'price' => 'required|decimal',
            'stock' => 'required|integer|greater_than_equal_to[0]'
        ];

        if (!$this->validate($rules, $json)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $id = $this->model->insert($json);

        return $this->respondCreated([
            'message' => 'Product created successfully',
            'product_id' => $id
        ]);
    }

    // PUT /api/products/{id} → Update
    public function update($id = null)
    {
        $this->requireLogin();
        $json = $this->request->getJSON(true);

        // Check if product exists first
        if (!$this->model->find($id)) {
            return $this->failNotFound('Product not found');
        }

        $rules = [
            'name'  => 'permit_empty|min_length[3]|max_length[100]',
            'sku'   => "permit_empty|min_length[3]|is_unique[products.sku,id,$id]",
            'price' => 'permit_empty|decimal',
            'stock' => 'permit_empty|integer|greater_than_equal_to[0]'
        ];

        if (!$this->validate($rules, $json)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $this->model->update($id, $json);

        return $this->respond([
            'message' => 'Product updated successfully'
        ]);
    }

    // DELETE /api/products/{id}
    public function delete($id = null)
    {
        $this->requireLogin();
        $product = $this->model->find($id);

        if (!$product) {
            return $this->failNotFound('Product not found');
        }

        $this->model->delete($id);

        return $this->respondDeleted([
            'message' => 'Product deleted successfully'
        ]);
    }
}