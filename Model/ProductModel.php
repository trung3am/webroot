<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class ProductModel extends Database {
    public function createProduct($product)
    {
        $query = "insert into products (product_name, category, brand, price)
        values ( \"{$product->product_name}\", \"{$product->category}\", \"{$product->brand}\", \"{$product->price}\" )";
        return $this->insert($query);  

    }

    public function getAllProducts()
    {
        return $this->selectAllProducts();
    }

    public function editProduct($product)
    {
        $query = "update products set ";
        $count = 0;
        if (isset($product->product_name)) {
          $query .= "product_name = \"{$product->product_name}\" ";
          $count++;
        }
        if (isset($product->category)) {
            if ($count>=1) {
              $query .= ", category = \"{$product->category} \"";
            }
            else {
              $query .= "category = \"{$product->category} \"";
            }
            $count++;
          }
        if (isset($product->brand)) {
            if ($count>=1) {
              $query .= ", brand = \"{$product->brand} \"";
            }
            else {
              $query .= "brand = \"{$product->brand} \"";
            }
            $count++;
          }
        if (isset($product->price)) {
            if ($count>=1) {
              $query .= ", price = {$product->price} ";
            }
            else {
              $query .= "price = {$product->price} ";
            }
            $count++;
          }
        if (isset($product->status)) {
            if ($count>=1) {
              $query .= ", status = {$product->status} ";
            }
            else {
              $query .= "status = {$product->status} ";
            }
            $count++;
          }
        if (isset($product->instock)) {
            if ($count>=1) {
              $query .= ", instock = {$product->instock} ";
            }
            else {
              $query .= "instock = {$product->instock} ";
            }
            $count++;
          }
        if (isset($product->imgurl)) {
            if ($count>=1) {
              $query .= ", imgurl = \"{$product->imgurl} \"";
            }
            else {
              $query .= "imgurl = \"{$product->imgurl} \"";
            }
            $count++;
          }
        $query .= " where product_id = {$product->product_id};
        select * from products where product_id = {$product->product_id}";

        return $this->edit($query);
    }

    public function adminAuth($jwt)
    {
      if (!$jwt) {
        return null;
      }
      
      $query = "select * from users where jwt = \"{$jwt}\" and admin = 1";
      echo $query;
      return $this->selectOne($query);
      
    }
}