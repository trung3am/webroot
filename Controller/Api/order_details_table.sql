CREATE TABLE `test1`.`order_details` ( `id` INT NOT NULL AUTO_INCREMENT , `order_id` INT NOT NULL , `product_id` INT(8) NOT NULL , `quantity` INT NOT NULL , `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`), FOREIGN KEY (`order_id`) REFERENCES `orders`(`order_id`),FOREIGN KEY (`product_id`) REFERENCES `products`(`product_id`)) ENGINE = InnoDB;

$sql = "CREATE TABLE `test1`.`order_details` ( `id` INT NOT NULL AUTO_INCREMENT 
, `order_id` INT NOT NULL , `product_id` INT(8) NOT NULL , `quantity` INT NOT NULL 
, `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`), 
FOREIGN KEY (`order_id`) REFERENCES `orders`(`order_id`),FOREIGN KEY (`product_id`) 
REFERENCES `products`(`product_id`)) ENGINE = InnoDB;";
