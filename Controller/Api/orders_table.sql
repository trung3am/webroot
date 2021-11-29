CREATE TABLE `test1`.`orders` ( `order_id` INT NOT NULL AUTO_INCREMENT , `client` VARCHAR(30) NOT NULL , `email` VARCHAR(30) NOT NULL , `status` VARCHAR(10) NOT NULL DEFAULT 'PENDING' , `PIC` VARCHAR(30) NULL ,`phone_number` INT(18) NOT NULL , `user_id` INT(8), `address` VARCHAR(200) NOT NULL, `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`order_id`), FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`)) ENGINE = InnoDB;

$sql = "CREATE TABLE `test1`.`orders` ( `order_id` INT NOT NULL AUTO_INCREMENT 
, `client` VARCHAR(30) NOT NULL , `email` VARCHAR(30) NOT NULL ,
 `status` VARCHAR(10) NOT NULL DEFAULT \'PENDING\' , `PIC` VARCHAR(30) NULL ,
 `phone_number` INT(18) NOT NULL , `user_id` INT(8), `address` VARCHAR(200) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`order_id`), 
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`)) ENGINE = InnoDB;";
