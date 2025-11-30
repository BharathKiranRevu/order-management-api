<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
use App\Models\ProductModel;
use App\Models\UserModel;


class TestSeeder extends Seeder
{
public function run()
{
$userModel = new UserModel();
$userModel->insert([
'name' => 'Test User',
'email' => 'test@example.com',
'password' => password_hash('password123', PASSWORD_DEFAULT),
]);


$productModel = new ProductModel();
$productModel->insertBatch([
['name'=>'Product A','sku'=>'SKU-A-001','price'=>199.99,'stock'=>10],
['name'=>'Product B','sku'=>'SKU-B-001','price'=>49.50,'stock'=>20],
['name'=>'Product C','sku'=>'SKU-C-001','price'=>9.99,'stock'=>100],
]);
}
}