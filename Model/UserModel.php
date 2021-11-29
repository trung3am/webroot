<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class UserModel extends Database {
 
  public function createUser($user){
    $user_name = $user->user_name;
    $user->user_name = '"'. $user->user_name . '"';
    $user->password = password_hash($user->password, PASSWORD_DEFAULT);
    $user->password = '"'. $user->password . '"';
    $user->email = '"'. $user->email . '"';
    
    if (!isset($user->phone_number)) {
      $query = "insert into users (user_name, password, email) 
    values({$user->user_name}, {$user->password}, {$user->email})";  
    }
    else{
      $query = "insert into users (user_name, password, email, phone_number) 
    values({$user->user_name}, {$user->password}, {$user->email}, {$user->phone_number})";
    }
    
    $user_id = $this->insert($query);
    if($user_id)
    {
      $user->user_name = $user_name;
      return $this->loginUser($user, $user_id);
    }
  }

  public function editUser($user, $token)
  {
    if (!$this->verifyJWT($token)) {
      return 0;
    }
    $editquery = "update users set ";
    $count = 0;
    if (isset($user->password)) {
      $user->password = password_hash($user->password, PASSWORD_DEFAULT);
      $editquery .= "password = \"{$user->password}\" ";
      $count++;
    }
    if (isset($user->email)) {
      if ($count==1) {
        $editquery .= ", email = \"{$user->email} \"";
      }
      else {
        $editquery .= "email = \"{$user->email} \"";
      }
      $count++;
    }
    if (isset($user->phone_number)) {
      if ($count>=1) {
        $editquery .= ", phone_number = {$user->phone_number} ";
      }
      else {
        $editquery .= "phone_number = {$user->phone_number} ";
      }
    }
    $editquery .= " where jwt = \"{$token}\";
    select user_id from users where jwt = \"{$token}\"";
    
    if($this->edit($editquery)){
      return 1;
    }
  }

  public function getInfoLogin($user)
  {
    $query=("select  user_id, password, jwt from users where user_name = \"{$user->user_name}\" ");
    return $this->selectOne($query);
  }

  public function loginUser($user, $user_id)
  {
    $jwt = $this->buildJWT($user_id,$user->user_name);
      $strjwt = '"'.$jwt .'"';
      
      $editquery = "
      update users set JWT = {$strjwt} where user_id = {$user_id};
      select user_id from users where jwt = {$strjwt}";
      
      if ($this->edit($editquery)) {
        return $this->getUser($jwt);
      }
  }

  public function getUser($jwt)
  {
    if ($jwt==null) {
      return 0;
    }
    $query = "select user_name, email, phone_number, jwt from users where jwt = \"{$jwt}\"";
      return $this->selectOne($query);
  }

  public function logoutUser($jwt)
  {
    
    $query="update users set jwt = \"\" where jwt = \"{$jwt}\";
    select * from users where jwt = \"{$jwt}\";";
    
    return $this->edit($query);
  }

  public function auth($jwt)
  {
    if (!$jwt) {
        return null;
    }
    $query = "select * from users where jwt = \"{$jwt}\"";
    return $this->selectOne($query);
    
  }

  public function adminAuth($jwt)
  {
    if (!$jwt) {
      return null;
    }
    $query = "select * from users where jwt = \"{$jwt}\" and admin = 1";
    return $this->selectOne($query);
    
  }





  private function base64url_encode($data)
  {
    // First of all you should encode $data to Base64 string
    $b64 = base64_encode($data);

    // Make sure you get a valid result, otherwise, return FALSE, as the base64_encode() function do
    if ($b64 === false) {
      return false;
    }

    // Convert Base64 to Base64URL by replacing “+” with “-” and “/” with “_”
    $url = strtr($b64, '+/', '-_');

    // Remove padding character from the end of line and return the Base64URL result
    return rtrim($url, '=');
  }
  //build the headers
  private function buildJWT($user_id, $user_name)
  {
    $headers = ['alg'=>'HS256','typ'=>'JWT'];
    $headers_encoded = $this->base64url_encode(json_encode($headers));

    //build the payload
    $payload = ['user_id'=>$user_id,'user_name'=> $user_name , 'current_time'=> time()];
    $payload_encoded = $this->base64url_encode(json_encode($payload));

    //build the signature
    $key = 'secret';
    $signature = hash_hmac('sha256',"$headers_encoded.$payload_encoded",$key,true);
    $signature_encoded = $this->base64url_encode($signature);

    //build and return the token
    $token = "$headers_encoded.$payload_encoded.$signature_encoded";
    return $token;

  }

}