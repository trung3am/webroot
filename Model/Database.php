<?php
class Database {
  protected $connection = null;

  public function __construct()
  {
    try {
      $this ->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
      if (mysqli_connect_errno()) {
        throw new Exception("Cannot connect to database");
      }
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  

  public function insert($query)
  {
    try {
      
      $this->connection->query($query);
      
      return $this->connection->insert_id;
    } catch (Exception $e) {
      throw new Exception("Error Processing Request", $e);
      
    }
  }

  public function edit($query)
  {
    try {
      
      if($this->connection->multi_query($query)){
        
        do {
          if($result = $this->connection->store_result()){
            $res= $result->num_rows;
          }
        } while ($this->connection->next_result());
        
      }
      
      if (isset($res)) {
        return $res;
      }
      return;


    } catch (Exception $e) {
      throw new Exception("Error Processing Request", $e);
      
    }
  }

  public function verifyJWT($token){
    try {
      $result = $this->connection->query("select jwt from users where jwt = \"{$token}\"");
      
      return $result->num_rows;
    } catch (Exception $e) {
      throw new Exception("Error Processing Request", $e);
      
    }
  }

  public function selectOne($query)
  {
    $res = $this->connection->query($query);
    $res = $res->fetch_all(MYSQLI_ASSOC);
    foreach ($res as $key => $value) {
      return $value;

    }
  }


  public function selectAll($query)
  {
    $res = $this->connection->query($query);
    $res = $res->fetch_all((MYSQLI_ASSOC));
    return $res;
  
  }

  public function selectAllProducts()
  {
    $res = $this->connection->query("select * from products where status = 1");
    $res = $res->fetch_all(MYSQLI_ASSOC);
    return $res;
  }

  


}
