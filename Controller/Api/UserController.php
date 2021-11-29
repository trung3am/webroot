<?php
class UserController extends BaseController
{


  public function createUser()
  {
    $strErrorDesc = '';
    $user = $this->getRequestBody();
    
    if (!isset($user->user_name) || !isset($user->email) || !isset($user->password)) {
      $strErrorDesc = "Missing information for create user";
      $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
      array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')); 
    // checking valid of user information before created.
      return;
    }
    
    if ($this->validateEmail($user->email)|| $this->validateName($user->user_name) || strlen($user->password) >30) 
    {
      $strErrorDesc = "Invalid password/username/email or phonenumber";
      $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
      array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')); 
      // checking valid of user information before created.
      return; 
    }
    if (isset($user->phone_number) && $this->validatePhoneNumber($user->phone_number)) {
      $strErrorDesc = "Invalid phone number";
      $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
      array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')); 
    // checking valid of user information before created.
      return;
    }
    try {
      $userModel = new UserModel();
      
      $responseData = $userModel->createUser($user);
    } catch (Exception $e) {
      $strErrorDesc = $e->getMessage().'Something went wrong!';
        $strErrorHeader = "HTTP/1.1 500 Internal Server Error";
    }
    if (!$strErrorDesc) {
      if ($responseData ) {
        
        $this->sendOutput(
          json_encode($responseData), array('Content-Type: application/json', 'HTTP/1.1 201 Created')
        );
      }
      else {
        $this->sendOutput(
          json_encode(array('message'=>"Username or email already taken.")), array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')
        );
      }
      
    }
    else {
      $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
      array('Content-Type: application/json', $strErrorHeader)
      );
    }
  }
  public function editUserProfile()
  {
    $strErrorDesc = '';
    $user = $this->getRequestBody();
    $header = apache_request_headers();
    
    $token = $this->getToken();
    
    if (!isset($user->password) && !isset($user->email) && !isset($user->phone_number)) {
      $strErrorDesc = "Missing information";
      $this->sendOutput(json_encode(array('error' =>$strErrorDesc)),
      array('Content-Type: application/json', "HTTP/1.1 400 Bad Request"));
      return;
    }
    if((isset($user->password) && strlen($user->password) >30) ||
    (isset($user->email) && ($this->validateEmail($user->email)))){
      $strErrorDesc = "Invalid";
      $this->sendOutput(json_encode(array('error' =>$strErrorDesc)),
      array('Content-Type: application/json', "HTTP/1.1 400 Bad Request"));
      return;
    }
    $userModel = new UserModel();
    if (null ==($userModel->auth($token))) {
      $strErrorDesc = "Unauthorized";
      $this->sendOutput(json_encode(array('error' =>$strErrorDesc)),
      array('Content-Type: application/json', "HTTP/1.1 401 Unauthorized"));
      return;
    }
    try {
      
      $res = $userModel->editUser($user, $token);
    } catch (Exception $e) {
      $strErrorDesc = $e->getMessage().'Something went wrong!';
      $strErrorHeader = "HTTP/1.1 500 Internal Server Error";
      $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
      array('Content-Type: application/json', $strErrorHeader)
      );
    }
    if ($res) {
      $this->sendOutput(
        json_encode(array('edit' => "Ok")), array('Content-Type: application/json', 'HTTP/1.1 200 OK')
      );
    }

  
  }

  public function loginUser()
  {
    $user = $this->getRequestBody();
    if (!isset($user->user_name) || !isset($user->password)) {
      $strErrorDesc = "missing username/password";
      $this->sendOutput(json_encode(array('error' =>$strErrorDesc)),
      array('Content-Type: application/json', "HTTP/1.1 400 Bad Request"));
      return;
    }
    $userModel = new UserModel();
    $data = $userModel->getInfoLogin($user);
    if (password_verify($user->password,$data['password'])) {
      
      if (!$data['jwt']) {

        $data = $userModel->loginUser($user,$data['user_id']);

      }
      else {
        $data = $userModel->getUser($data['jwt']);
      }
      $this->sendOutput(
        json_encode($data), array('Content-Type: application/json', 'HTTP/1.1 200 OK')
      );     
      return;
      

    }
    $this->sendOutput(
      json_encode(array('message' => "invalid")), array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')
    );
  } 


  public function logoutUser()
  {
    $token = $this->getToken();
    if ($token) {
      try {
        $userModel = new UserModel();
        if (null ==($userModel->auth($token))) {
          $strErrorDesc = "Unauthorized";
          $this->sendOutput(json_encode(array('error' =>$strErrorDesc)),
          array('Content-Type: application/json', "HTTP/1.1 401 Unauthorized"));
          return;
        }
        if (!$userModel->logoutUser($token)) {
          $this->sendOutput(
            json_encode(array('message' => 'logout!')), array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        }
        else {
          $this->sendOutput(
            json_encode(array('message' => 'invalid')), array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')
            );
        }
      } catch (Exception $e) {
        $strErrorDesc = $e->getMessage().'Something went wrong!';
        $strErrorHeader = "HTTP/1.1 500 Internal Server Error";
        $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
        array('Content-Type: application/json', $strErrorHeader)
        );
      }  
    }
  }


  public function getUser()
  {
    $token = $this->getToken();
    if (!isset($token)) {
      $strErrorDesc = "Unauthorized";
      $this->sendOutput(json_encode(array('error' =>$strErrorDesc)),
      array('Content-Type: application/json', "HTTP/1.1 401 Unauthorized"));
      return;
    }
    $userModel = new UserModel();
    $user = $userModel->getUser($token);
    if ($user) {
      $this->sendOutput(json_encode($user),
      array('Content-Type: application/json', "HTTP/1.1 200 OK"));
      return;
    }
    $strErrorDesc = "Unauthorized";
      $this->sendOutput(json_encode(array('error' =>$strErrorDesc)),
      array('Content-Type: application/json', "HTTP/1.1 401 Unauthorized"));
      return;
  }


}