<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class ProductModel extends Database {
    public function createProduct($product)
    {
        $query = $this->makeQueryForCreate($product);
        return $this->insert($query);  

    }

    public function getAllProducts()
    {

        $products = $this->selectAllProducts();

        foreach ($products as $key => $value) {

          if ($value['sizes']!== null) {
            $temp = explode('-',$value['sizes']); 
            $value['sizes'] = $temp;
          }
        }
        return $products;
    }

    public function editProduct($product)
    {
        
        $query = $this->makeQueryForEdit($product);


        return $this->edit($query);
    }

    protected function makeQueryForEdit($product)
    {
      $query = "update products set ";
      $count = 0;
      if (isset($product->name)) {
        $query .= "name = \"{$product->name}\" ";
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
      if (isset($product->slug)) {
          if ($count>=1) {
            $query .= ", slug = \"{$product->slug} \"";
          }
          else {
            $query .= "slug = \"{$product->slug} \"";
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
      if (isset($product->discount_price)) {
        if ($count>=1) {
          $query .= ", discount_price = {$product->discount_price} ";
        }
        else {
          $query .= "discount_price = {$product->discount_price} ";
        }
        $count++;
      }
      if (isset($product->color)) {
        if ($count>=1) {
          $query .= ", color = \"{$product->color}\" ";
        }
        else {
          $query .= "color = \"{$product->color}\" ";
        }
        $count++;
      }
      if (isset($product->sizes)) {
        if ($count>=1) {
          $query .= ", sizes = \"{$product->sizes}\"";
        }
        else {
          $query .= "sizes = \"{$product->sizes}\"";
        }
        $count++;
      }
      if (isset($product->sale)) {
        if ($count>=1) {
          $query .= ", sale = \"{$product->sale}\"";
        }
        else {
          $query .= "sale = \"{$product->sale}\"";
        }
        $count++;
      }
      if (isset($product->shipped_from_abroad)) {
        if ($count>=1) {
          $query .= ", shipped_from_abroad = \"{$product->shipped_from_abroad}\"";
        }
        else {
          $query .= "shipped_from_abroad = \"{$product->shipped_from_abroad}\"";
        }
        $count++;
      }
      if (isset($product->quantity)) {
        if ($count>=1) {
          $query .= ", quantity = \"{$product->quantity}\"";
        }
        else {
          $query .= "quantity = \"{$product->quantity}\"";
        }
        $count++;
      }
      if (isset($product->star_ratings)) {
        if ($count>=1) {
          $query .= ", star_ratings = \"{$product->star_ratings}\"";
        }
        else {
          $query .= "star_ratings = \"{$product->star_ratings}\"";
        }
        $count++;
      }
      if (isset($product->votes)) {
        if ($count>=1) {
          $query .= ", votes = \"{$product->votes}\"";
        }
        else {
          $query .= "votes = \"{$product->votes}\"";
        }
        $count++;
      }
      if (isset($product->img)) {
        if ($count>=1) {
          $query .= ", img = \"{$product->img}\"";
        }
        else {
          $query .= "img = \"{$product->img}\"";
        }
        $count++;
      }
      $query .= " where id = {$product->id};
      select * from products where id = {$product->id}";

      return $query;
    }

    protected function makeQueryForCreate($product)
    {
      $query = "insert into products (name, slug, price, discount_price, category ";
      $value = " values (\"{$product->name}\", \"{$product->slug}\", \"{$product->price}\", 
      \"{$product->discount_price}\", \"{$product->category}\"  ";
      $count =0;
      if (isset($product->color)) {
        $query .= ", color";
        $value .= ", \"{$product->color}\"";
      }
      if (isset($product->sizes)) {
        $query .= ", sizes";
        $value .= ", \"{$product->sizes}\"";
      }
      if (isset($product->sale)) {
        $query .= ", sale";
        $value .= ", \"{$product->sale}\"";
      }
      if (isset($product->shipped_from_abroad)) {
        $query .= ", shipped_from_abroad";
        $value .= ", \"{$product->shipped_from_abroad}\"";
      }
      if (isset($product->quantity)) {
        $query .= ", quantity";
        $value .= ", \"{$product->quantity}\"";
      }
      if (isset($product->star_ratings)) {
        $query .= ", star_ratings";
        $value .= ", \"{$product->star_ratings}\"";
      }
      if (isset($product->votes)) {
        $query .= ", votes";
        $value .= ", \"{$product->votes}\"";
      }
      if (isset($product->img)) {
        $query .= ", img";
        $value .= ", \"{$product->img}\"";
      }
      $query .= ")";
      $value .= ")";
      $query .= $value;
      return $query;
    }

    public function adminAuth($jwt)
    {
      if (!$jwt) {
        return null;
      }
      
      $query = "select * from users where jwt = \"{$jwt}\" and admin = 1";
      return $this->selectOne($query);
      
    }
}