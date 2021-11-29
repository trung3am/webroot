  <?php
require __DIR__ . "./inc/bootstrap.php";
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);


require PROJECT_ROOT_PATH . "/Controller/Api/UserController.php";
require PROJECT_ROOT_PATH . "/Controller/Api/ProductController.php";
require PROJECT_ROOT_PATH . "/Controller/Api/OrderController.php";

if(strtoupper($_SERVER['REQUEST_METHOD'])== "GET"){
  if ($uri[2]=='user' && $uri[3] == 'me') {
    $user = new UserController();
    $user->getUser();
  }
  if($uri[2] == "product" && $uri[3] == "all"){
    $Products = new ProductController();
    $Products->getAllProducts();  
  }
  if($uri[2] == "order" && $uri[3] == "all"){
    $order = new OrderController();
    $order->getOrders();  
  }
  if($uri[2] == "order" && $uri[3] == "admin"){
    $order = new OrderController();
    $order->getOrderDetailsAsAdmin();  
  }

  
}

if(strtoupper($_SERVER['REQUEST_METHOD'])== "POST"){
  if ($uri[2] == "user" && $uri[3] == "createuser") {
    $createUser = new UserController();
    $createUser->createUser();
  }
  if ($uri[2] == "user" && $uri[3] == "login") {
    $loginUser = new UserController();
    $loginUser->loginUser();
  }
  if ($uri[2] == "product" && $uri[3] == "create") {
    $createProduct = new ProductController();
    $createProduct->createProduct();
  }
  if ($uri[2] == "order" && $uri[3] == "create") {
    $createOrder = new OrderController();
    $createOrder->createOrder();
  }
}
if(strtoupper($_SERVER['REQUEST_METHOD'])=="PUT"){
  if ($uri[2] == "user" && $uri[3] == "edituser") {
    $editUserProfile = new UserController();
    $editUserProfile->editUserProfile();
  }
  if ($uri[2] == "user" && $uri[3] == "logout") {
    $userLogout = new UserController();
    $userLogout->logoutUser();
  }
  if ($uri[2] == "product" && $uri[3] == "edit") {
    $editProduct = new ProductController();
    $editProduct->editProduct();
  }
  if ($uri[2] == "order" && $uri[3] == "process") {
    $editOrder = new OrderController();
    $editOrder->processOrder();
  }
}




?>