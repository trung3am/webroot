    CREATE TABLE `test1`.`products` ( `product_id` INT(8) NOT NULL AUTO_INCREMENT , `product_name` VARCHAR(255) NOT NULL , `category` VARCHAR(30) NOT NULL DEFAULT 'accessories' , `brand` VARCHAR(30) NOT NULL , `price` INT(9) NOT NULL DEFAULT '0' , `status` BOOLEAN NOT NULL DEFAULT TRUE , `instock` BOOLEAN NOT NULL DEFAULT TRUE ,`imgurl` VARCHAR(255) DEFAULT '' ,`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`product_id`), UNIQUE `product_name` (`product_name`)) ENGINE = InnoDB;
$sql = "CREATE TABLE `test1`.`products` ( `product_id` INT(8) NOT NULL AUTO_INCREMENT 
, `product_name` VARCHAR(255) NOT NULL , `category` VARCHAR(30) NOT NULL DEFAULT \'accessories\' 
, `brand` VARCHAR(30) NOT NULL , `price` INT(9) NOT NULL DEFAULT \'0\' 
, `status` BOOLEAN NOT NULL DEFAULT TRUE , `instock` BOOLEAN NOT NULL DEFAULT TRUE 
,`imgurl` VARCHAR(255) DEFAULT \'\' ,`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP 
, PRIMARY KEY (`product_id`), UNIQUE `product_name` (`product_name`)) ENGINE = InnoDB;";
