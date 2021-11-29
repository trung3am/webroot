<?php

class ProductController extends BaseController 
{
    public function createProduct()
    {
        $token = $this->getToken();
        $product = $this->getRequestBody();
        if (!isset($product->product_name) || !isset($product->brand) 
        || !isset($product->category) || !isset($product->price)) {
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
        $products = $productModel->selectAllProducts();
        if ($products) {
            $this->sendOutput(json_encode($products),
            array('Content-Type: application/json', 'HTTP/1.1 201 Created')); 
        }
    }

    public function editProduct()
    {
        $token = $this->getToken();
        $product = $this->getRequestBody();
        
        if (!isset($product->product_id)) {
            $strErrorDesc ="invalid";
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
            array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')); 
            return;
        }
        if (!isset($product->product_name) && !isset($product->category) &&!isset($product->brand) &&
        !isset($product->instock) && !isset($product->status) && !isset($product->price) && !isset($product->imgurl) ) {
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
