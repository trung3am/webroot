
CREATE TABLE `test1`.`users` ( `user_id` INT(8) NOT NULL AUTO_INCREMENT , `user_name` VARCHAR(30) NOT NULL , `password` VARCHAR(255) NOT NULL , `email` VARCHAR(30) NOT NULL , `phone_number` INT(18) NOT NULL ,`admin` BOOLEAN NOT NULL DEFAULT FALSE , `created_at` TIMESTAMP NOT NULL ,`banned` BOOLEAN DEFAULT FALSE ,`jwt` VARCHAR(255) NOT NULL , PRIMARY KEY (`user_id`), UNIQUE `user_name` (`user_name`), UNIQUE `email` (`email`)) ENGINE = InnoDB;
$sql = "CREATE TABLE `test1`.`users` ( `user_id` INT(8) NOT NULL AUTO_INCREMENT 
, `user_name` VARCHAR(30) NOT NULL , `password` VARCHAR(255) NOT NULL , `email` VARCHAR(30) NOT NULL 
, `phone_number` INT(18) NOT NULL ,`admin` BOOLEAN NOT NULL DEFAULT FALSE , `created_at` TIMESTAMP NOT NULL 
, `jwt` VARCHAR(255) NOT NULL , PRIMARY KEY (`user_id`), UNIQUE `user_name` (`user_name`)
, UNIQUE `email` (`email`)) ENGINE = InnoDB;";
