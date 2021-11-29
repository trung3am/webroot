<?php
class BaseController
{
  public function __call($name, $arguments)
  {
    $this->sendOutput('', array('HTTP/1.1 404 Not Found'));

  }

  protected function getRequestBody()
  {
    $raw_data = file_get_contents("php://input");
    return json_decode($raw_data);
  }


  protected function getUriSegment()
  {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode('/', $uri);
    return $uri;
  }

  protected function getQueryStringParams()
  {
    return parse_str($_SERVER['QUERY_STRING'], $query);
  }

  protected function sendOutput($data, $httpHeaders = array())
  {
    header_remove('Set-Cookie');
    if (is_array($httpHeaders) && count($httpHeaders)) {
      foreach ($httpHeaders as $httpHeader ) {
        header($httpHeader);
      }
    }
    echo $data;
    exit();
  }

  protected function validateEmail($email)
  {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email)>30) {
      return 1;
    }
    return 0;
  }

  protected function validateName($name)
  {
    if (!preg_match('/^[A-Za-z][A-Za-z0-9]{5,29}$/', $name) || strlen($name) >30) {
      return 1;
    }
    return 0;
  }

  protected function validatePhoneNumber($phone_number)
  {
    if (!preg_match('!^[1-9][0-9]*$!', $phone_number)) {
      return 1;
    }
    return 0;
  }
  
  protected function getToken()
  {
    $header = apache_request_headers();
    
    if (!isset($header) ||!isset($header['Authorization'])) {
      $strErrorDesc = "Unauthorized";
      $this->sendOutput(json_encode(array('error' =>$strErrorDesc)),
      array('Content-Type: application/json', "HTTP/1.1 401 Unauthorized"));
      return;
    }
    $token = str_replace("Bearer ", "", $header['Authorization']);
    if ($token) {
      return $token;
    }
    return ;
  }
}
