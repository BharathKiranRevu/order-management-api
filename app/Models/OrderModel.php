<?php
namespace App\Models;
use CodeIgniter\Model;


class OrderModel extends Model
{
protected $table = 'orders';
protected $primaryKey = 'id';
protected $allowedFields = ['user_id','total_amount','status'];
protected $useTimestamps = true;


public function items()
{
return $this->hasMany(OrderItemModel::class, 'order_id', 'id');
}
}