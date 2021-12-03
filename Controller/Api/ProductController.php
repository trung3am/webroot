<?php

class ProductController extends BaseController 
{
    public function createProduct()
    {
        $token = $this->getToken();
        $product = $this->getRequestBody();
        if (!isset($product->name) || !isset($product->slug) 
        || !isset($product->category) || !isset($product->price) || !isset($product->discount_price)) {
            $strErrorDesc = "Missing information for create product";
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
            array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')); 
          
            return;
        }
        $productModel = new ProductModel();
        if (null ==($productModel->adminAuth($token))) {
            $strErrorDesc = "Unauthorized";
            $this->sendOutput(json_encode(array('error' =>$strErrorDesc)),
            array('Content-Type: application/json', "HTTP/1.1 401 Unauthorized"));
            return;
        }
        try {
            
            if ($productModel->createProduct($product)) {
                $this->sendOutput(json_encode(array('message' => "created")),
                array('Content-Type: application/json', 'HTTP/1.1 201 Created'));
                return;
            }
        } catch (Exception $e) {
            $strErrorDesc = $e->getMessage();
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
            array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')); 
            return;
        }
        $strErrorDesc ="cannot create products, maybe duplicated";
        $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
        array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')); 
    }

    public function getAllProducts()
    {
        $productModel = new ProductModel();
        $products = $productModel->getAllProducts();
        if ($products) {
            $this->sendOutput(json_encode($products),
            array('Content-Type: application/json', 'HTTP/1.1 200 OK')); 
        }
    }

    public function hideProduct()
    {
        $token = $this->getToken();
        $product = $this->getRequestBody();
        
        if (!isset($product->product_id)) {
            $strErrorDesc ="invalid";
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
            array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')); 
            return;
        }
        $productModel = new ProductModel();
        if (null ==($productModel->adminAuth($token))) {
            $strErrorDesc = "Unauthorized";
            $this->sendOutput(json_encode(array('error' =>$strErrorDesc)),
            array('Content-Type: application/json', "HTTP/1.1 401 Unauthorized"));
            return;
        }
        try {
            $res = $productModel->hideProduct($product);
            if ($res) {
                $this->sendOutput(json_encode(array('message' => "hidden")),
                array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
                return;
            }
        } catch (Exception $e) {
            $strErrorDesc = $e->getMessage();
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
            array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')); 
            return;
        }
        $strErrorDesc ="failed to edit product";
        $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
        array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')); 
    }
    
    public function editProduct()
    {
        $token = $this->getToken();
        $product = $this->getRequestBody();
        
        if (!isset($product->id)) {
            $strErrorDesc ="invalid";
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
            array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')); 
            return;
        }
        if (!isset($product->name) && !isset($product->category) &&!isset($product->slug) &&
        !isset($product->discount_price) && !isset($product->color) && !isset($product->price) && !isset($product->img)
        && !isset($product->sizes) && !isset($product->sale) && !isset($product->shipped_from_abroad) && !isset($product->quantity)
        && !isset($product->star_ratings) && !isset($product->votes) ) {
            $strErrorDesc ="invalid";
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
            array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')); 
            return;
        }
        
        $productModel = new ProductModel();
        if (null ==($productModel->adminAuth($token))) {
            $strErrorDesc = "Unauthorized";
            $this->sendOutput(json_encode(array('error' =>$strErrorDesc)),
            array('Content-Type: application/json', "HTTP/1.1 401 Unauthorized"));
            return;
        }
        
        try {
            $res = $productModel->editProduct($product);
            if ($res) {
                $this->sendOutput(json_encode(array('message' => "edited")),
                array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
                return;
            }
        } catch (Exception $e) {
            $strErrorDesc = $e->getMessage();
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
            array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')); 
            return;
        }
        $strErrorDesc ="failed to edit product";
        $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
        array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')); 
    }
    
}
