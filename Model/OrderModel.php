<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class OrderModel extends Database 
{
    public function createOrderWithToken($order, $jwt)
    {
        
        $user = $this->selectOne("select * from users where jwt = \"{$jwt}\"");
        
        if (!$user) {
            
            return;
            
        }
        if (!$this->checkProductOrder($order)) {
            
            return;
        }
        $query = "insert into orders (client, email, phone_number, user_id, address, payment)
        values(\"{$user['user_name']}\", \"{$user['email']}\", \"{$user['phone_number']}\", \"{$user['user_id']}\",\"{$order->address}\"),\"{$order->payment}\" ";
        
        return $this->createOrder($query, $order);
    }

    public function createOrderWithNoToken($order)
    {
        if (!$this->checkProductOrder($order)) {
            return;
        }
        $query = "insert into orders (client, email, phone_number, address, payment)
        values(\"{$order->user_name}\", \"{$order->email}\", \"{$order->phone_number}\",\"{$order->address}\",\"{$order->payment}\") ";
        return $this->createOrder($query, $order);
    }

    protected function createOrder($query, $order)
    {
        try {
            $order_id = $this->insert($query);
            for ($i=0; $i < count($order->products); $i++) { 
                if (!isset($order->products[$i]->sizes)||$order->products[$i]->sizes== null) {
                    
                    $this->insert("insert into order_details (order_id, product_id, quantity)
                values (\"{$order_id}\", \"{$order->products[$i]->product_id}\",\"{$order->products[$i]->quantity}\")");
                }
                else {
                    
                    $this->insert("insert into order_details (order_id, product_id, quantity, size)
                values (\"{$order_id}\", \"{$order->products[$i]->product_id}\",\"{$order->products[$i]->quantity}\",\"{$order->products[$i]->sizes}\")");
                }
                
            }
               
            
        } catch (Exception $e) {
            throw new Exception("Error Processing Request", $e);
            return 0;
        }
        return 1;
    }



    protected function selectAllOrders()
    {
        return $this->selectAll("select * from orders");
    }


    public function getOrders($jwt)
    {
        
        $user = $this->auth($jwt);
        if (isset($user) && $user['admin'] == 0) {
            
            $orders = $this->selectAll("select order_id, status, created_at from orders where user_id = \"{$user['user_id']}\"");
            $order_details = array();
            foreach ($orders as $key => $value) {
                $res = $this->getOrderDetails($value['order_id']);
                $res += ["status"=> $value['status']];
                $res += ["created_at"=> $value['created_at']];
                array_push($order_details, $res);
            }
            return $order_details;
        }
        if (isset($user) && $user['admin'] == 1) {
            
            return $this->selectAll("select * from orders");

        }
        return ;
    }

    
    public function getOrderDetails($order_id)
    {
        $order_details = $this->selectAll("select * from order_details where order_id = \"{$order_id}\"");
        
        $quantity = array();
        $product_id = array();
        foreach ($order_details as $key => $value) {
            array_push($product_id, $value['product_id']);
            array_push($quantity, $value['quantity']);
        }
        return ["order_id"=> $order_id, "product_id" => $product_id, "quantity"=>$quantity];
    }

    public function auth($jwt)
    {
        return $this->selectOne("select user_id, admin from users where jwt = \"{$jwt}\"");
        
    }

    public function editOrder($order)
    {
        $query = "update orders set PIC = \"{$order->PIC}\" , status = \"{$order->status}\"
         where order_id = {$order->order_id};
         select * from orders where order_id = {$order->order_id}";
        return $this->edit($query);
    }


    protected function checkProductOrder($order)
    {
        $avail_product_id = array();
        $avail_product = $this->selectAllProducts();
        foreach ($avail_product as $key => $value) {
            array_push($avail_product_id, $value['id']);

        }
        
        foreach ($order->products as $key => $value) {
            if (array_search($value->product_id, $avail_product_id) === false) {
                return 0;
            }
        }
        return 1;
    }
}
