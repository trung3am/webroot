DROP TABLE IF EXISTS order_details;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS users;


CREATE TABLE `test1`.`users` ( `user_id` INT(8) NOT NULL AUTO_INCREMENT , `user_name` VARCHAR(30) NOT NULL , `password` VARCHAR(255) NOT NULL , `email` VARCHAR(30) NOT NULL , `phone_number` INT(18) NOT NULL ,`admin` BOOLEAN NOT NULL DEFAULT FALSE , `created_at` TIMESTAMP NOT NULL ,`banned` BOOLEAN DEFAULT FALSE ,`jwt` VARCHAR(255) NOT NULL , PRIMARY KEY (`user_id`), UNIQUE `user_name` (`user_name`), UNIQUE `email` (`email`)) ENGINE = InnoDB;
CREATE TABLE `test1`.`products` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(100) NOT NULL , `slug` VARCHAR(100) NOT NULL , `price` INT NOT NULL , `discount_price` INT NOT NULL , `category` VARCHAR(30) NOT NULL , `color` VARCHAR(30) NULL , `sizes` VARCHAR(10) NULL , `sale` BOOLEAN NOT NULL DEFAULT TRUE , `shipped_from_abroad` BOOLEAN NOT NULL DEFAULT TRUE , `quantity` INT NOT NULL DEFAULT '50' , `star_ratings` FLOAT NOT NULL DEFAULT '5.0' , `votes` INT NOT NULL DEFAULT '100' , `img` VARCHAR(255) NULL ,`hidden` BOOLEAN DEFAULT FALSE ,`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `test1`.`orders` ( `order_id` INT NOT NULL AUTO_INCREMENT , `client` VARCHAR(30) NOT NULL , `email` VARCHAR(30) NOT NULL , `status` VARCHAR(10) NOT NULL DEFAULT 'PENDING' , `PIC` VARCHAR(30) NULL ,`phone_number` INT(18) NOT NULL , `user_id` INT(8), `address` VARCHAR(200) NOT NULL, `payment` VARCHAR(15) DEFAULT "onDelivery"  ,`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`order_id`), FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`)) ENGINE = InnoDB;
CREATE TABLE `test1`.`order_details` ( `id` INT NOT NULL AUTO_INCREMENT , `order_id` INT NOT NULL , `product_id` INT(8) NOT NULL , `quantity` INT NOT NULL , `size` VARCHAR(3) ,`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`), FOREIGN KEY (`order_id`) REFERENCES `orders`(`order_id`),FOREIGN KEY (`product_id`) REFERENCES `products`(`id`)) ENGINE = InnoDB;

insert into products (name, slug, price, discount_price, category, color, sale, quantity, shipped_from_abroad, star_ratings, votes) values ("men's analog quartz watch","mens-analog-quartz-watch-547383",115000,644000, "men","black",1,5,0,4.8,350);
insert into products (name, slug, price, discount_price, category, color, sale, quantity, shipped_from_abroad, star_ratings, votes) values ("singedani four set handbag","singedani-four-set-handbag-647483",266800,533600, "women","gray",0,8,1,3.6,200);
insert into products (name, slug, price, discount_price, category, color, sale, quantity, shipped_from_abroad, star_ratings, votes) values ("Boys gray boxer set","boys-gray-boxer-set-546488",207000,276000, "kids","blue",1,3,0,2.5,150);
insert into products (name, slug, price, discount_price, category, color, sale, quantity, shipped_from_abroad, star_ratings, votes) values ("Hiamok men leather belt","hiamok-men-leather-belt-238192",90160,252540, "men","brown",0,10,1,3.8,20);
insert into products (name, slug, price, discount_price, category, color, sale, quantity, shipped_from_abroad, star_ratings, votes) values ("vintage print flare dress","vintage-print-flare-dress-987426",395600,1186800, "women","White",1,0,0,4.0,130);
insert into products (name, slug, price, discount_price, category, color, sale, quantity, shipped_from_abroad, star_ratings, votes) values ("capped sleeves red cotton dress","capped-sleeves-red-cotton-dress-349824",253000,379500, "kids","Red",1,2,1,2.1,268);
insert into products (name, slug, price, discount_price, category, color, sale, quantity, shipped_from_abroad, star_ratings, votes) values ("gemch men casual running shoes","gemch-men-casual-running-shoes-459123",694600,823400, "men","black",0,6,1,4,250);
insert into products (name, slug, price, discount_price, category, color, sale, quantity, shipped_from_abroad, star_ratings, votes) values ("Boho printed floral dress","boho-printed-floral-dress-656623",459770,505770, "women","skyblue",1,10,0,3.6,129);
insert into products (name, slug, price, discount_price, category, color, sale, quantity, shipped_from_abroad, star_ratings, votes) values ("Baby girl bowknot leather shoes","baby-girl-bowknot-leather-shoes-312947",113390,115460, "kids","Silver",0,9,1,4.1,50);
insert into products (name, slug, price, discount_price, category, color, sale, quantity, shipped_from_abroad, star_ratings, votes) values ("men khaki trouser - navy blue","men-khaki-trouser-navy-blue-537329",309580,309810, "men","Navy Blue",0,0,1,2.0,35);
insert into products (name, slug, price, discount_price, category, color, sale, quantity, shipped_from_abroad, star_ratings, votes) values ("Women printed bodycon dress","women-printed-bodycon-dress-439618",357420,377200, "women","gray",0,7,0,3.2,240);
insert into products (name, slug, price, discount_price, category, color, sale, quantity, shipped_from_abroad, star_ratings, votes) values ("girl princess lace dress","girl-princess-lace-dress-123567",415840,540500, "kids","White",1,4,1,3.6,70);
insert into products (name, slug, price, discount_price, category, color, sale, quantity, shipped_from_abroad, star_ratings, votes) values ("men's formal slim fit suit","mens-formal-slim-fit-suit-345987",834210,1390350, "men","Dark Blue",1,3,0,5.0,210);
insert into products (name, slug, price, discount_price, category, color, sale, quantity, shipped_from_abroad, star_ratings, votes) values ("Women's rome strappy gladiator loe flat flip","womens-rome-strappy-gladiator-loe-flat-flip-230978",201480,227010, "women","Gold",1,2,0,1.5,3);
insert into products (name, slug, price, discount_price, category, color, sale, quantity, shipped_from_abroad, star_ratings, votes) values ("navy long sleeved boys t-shirt","navy-long-sleeved-boys-tshirt-786534",220800,276000, "kids","black",0,0,1,2.9,65);
insert into products (name, slug, price, discount_price, category, color, sale, quantity, shipped_from_abroad, star_ratings, votes) values ("3 piece men's vest - white","3-piece-mens-vest-white-891267",206770,414000, "men","White",1,8,1,3.0,289);
insert into products (name, slug, price, discount_price, category, color, sale, quantity, shipped_from_abroad, star_ratings, votes) values ("checkers faix leather wrist watch","checkers-faix-leather-wrist-watch-120934",78430,101890, "women","Gold",1,4,1,4.0,200);
insert into products (name, slug, price, discount_price, category, color, sale, quantity, shipped_from_abroad, star_ratings, votes) values ("boys black crew neck t-shirt","boys-black-crew-neck-tshirt-784301",204700,276000, "kids","black",1,7,0,4.7,130);


update products set sizes = "S-L-M" where id = 3;
update products set sizes = "S-L-M" where id = 5;
update products set sizes = "S-M" where id = 6;
update products set sizes = "39-40-42" where id = 7;
update products set sizes = "M-L-XL" where id = 8;
update products set sizes = "S" where id = 9;
update products set sizes = "M-L" where id = 10;
update products set sizes = "M-L-XL" where id = 11;
update products set sizes = "S-M-L" where id = 12;
update products set sizes = "M-L-XL" where id = 13;
update products set sizes = "25-35-40" where id = 14;
update products set sizes = "M-L" where id = 15;
update products set sizes = "S-L-M" where id = 16;
update products set sizes = "S-M" where id = 18;

update products set img = "https://trung-img-server.herokuapp.com/61a82c63d9905444baf9d029" where id = 1;
update products set img = "https://trung-img-server.herokuapp.com/61a82dd1d9905444baf9d02f" where id = 2;
update products set img = "https://trung-img-server.herokuapp.com/61a82dd3d9905444baf9d032" where id = 3;
update products set img = "https://trung-img-server.herokuapp.com/61a82dd5d9905444baf9d035" where id = 4;
update products set img = "https://trung-img-server.herokuapp.com/61a82dd7d9905444baf9d038" where id = 5;
update products set img = "https://trung-img-server.herokuapp.com/61a82dd8d9905444baf9d03b" where id = 6;
update products set img = "https://trung-img-server.herokuapp.com/61a82ddad9905444baf9d03e" where id = 7;
update products set img = "https://trung-img-server.herokuapp.com/61a82dddd9905444baf9d041" where id = 8;
update products set img = "https://trung-img-server.herokuapp.com/61a82ddfd9905444baf9d044" where id = 9;
update products set img = "https://trung-img-server.herokuapp.com/61a82de1d9905444baf9d047" where id = 10;
update products set img = "https://trung-img-server.herokuapp.com/61a82de3d9905444baf9d04a" where id = 11;
update products set img = "https://trung-img-server.herokuapp.com/61a82de5d9905444baf9d04d" where id = 12;
update products set img = "https://trung-img-server.herokuapp.com/61a82de7d9905444baf9d050" where id = 13;
update products set img = "https://trung-img-server.herokuapp.com/61a82de9d9905444baf9d053" where id = 14;
update products set img = "https://trung-img-server.herokuapp.com/61a82dead9905444baf9d056" where id = 15;
update products set img = "https://trung-img-server.herokuapp.com/61a82decd9905444baf9d059" where id = 16;
update products set img = "https://trung-img-server.herokuapp.com/61a82deed9905444baf9d05c" where id = 17;
update products set img = "https://trung-img-server.herokuapp.com/61a82df0d9905444baf9d05f" where id = 18;

