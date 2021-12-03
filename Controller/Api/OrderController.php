<?php
class OrderController extends BaseController
{

    public function createOrder()
    {
        $order = $this->getRequestBody();
        if (!isset($order->products) || !isset($order->address)   ) {
            $strErrorDesc = "Invalid";
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
            array('Content-Type: application/json', 'HTTP/1.1 400 Bad request')); 
            
            return;
        }
        
        $header = apache_request_headers();
        if (isset($header['Authorization'])) {
            $token = str_replace("Bearer ", "", $header['Authorization']);
            if ($token) {
                $orderModel = new OrderModel();
                if ($orderModel->createOrderWithToken($order, $token)) {
                    $this->sendOutput(json_encode(array('message' => 'OK')),
                    array('Content-Type: application/json', 'HTTP/1.1 201 Created')); 
                    return;
                }
                
            }
        }
        else {
            if (!isset($order->user_name) || !isset($order->email) || !isset($order->phone_number)) {
                $strErrorDesc = "Invalid";
                $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', 'HTTP/1.1 400 Bad request')); 
                
                return;
            }
            if ( $this->validateEmail($order->email) || $this->validatePhoneNumber($order->phone_number)) {
                $strErrorDesc = "Invalid";
                $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', 'HTTP/1.1 400 Bad request')); 
                return;
            }
            
            $orderModel = new OrderModel();
            if($orderModel->createOrderWithNoToken($order))
            {
                $this->sendOutput(json_encode(array('message' => 'OK')),
                array('Content-Type: application/json', 'HTTP/1.1 201 Created')); 
            }
            return;
        }
        
        $strErrorDesc = "Error";
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
            array('Content-Type: application/json', 'HTTP/1.1 500 Internal Server Error')); 
            return;

    }

    public function getOrders()
    {
        $token = $this->getToken();
        if (!$token) {
            return;
        }
        $orderModel = new OrderModel();
        $order = $orderModel->getOrders($token);
        $this->sendOutput(json_encode($order),
            array('Content-Type: application/json', 'HTTP/1.1 200 OK')); 
            return;
    }

    public function getOrderDetailsAsAdmin()
    {
        $token = $this->getToken();
        if (!$token) {
            return;
        }
        $orderModel = new OrderModel();
        $user = $orderModel->auth($token);
        if (null !== $user && $user['admin'] ==1 ) {
            $order = $this->getRequestBody();
            $res = $orderModel->getOrderDetails($order->order_id);
            $this->sendOutput(json_encode($res),
            array('Content-Type: application/json', 'HTTP/1.1 200 OK')); 
            return;
        }
        $this->sendOutput(json_encode(array('message' => 'Toang')),
        array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request'));
    }
 

    public function processOrder()
    {
        $token = $this->getToken();
        if (!$token) {
            return;
        }
        
        $orderModel = new OrderModel();
        $user = $orderModel->auth($token);
        if (null !== $user && $user['admin'] ==1 ) {
            $order = $this->getRequestBody();
            if (!isset($order->order_id)||!isset($order->PIC)||!isset($order->status)) {
                $this->sendOutput(json_encode(array('message' => 'Toang')),
                array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request'));
                return;
            }
            
            $res = $orderModel->editOrder($order);
            if ($res) {
                $this->sendOutput(json_encode(array('message' => 'OK')),
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')); 
                return;
            }
        }
        $this->sendOutput(json_encode(array('message' => 'Toang')),
        array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request'));
    }
    
}
