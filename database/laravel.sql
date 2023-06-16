DROP DATABASE IF EXISTS `clear-reflection`;
CREATE DATABASE `clear-reflection`;

USE `clear-reflection`;
-- ACCOUNT RELATED -- 
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
	role_id INT PRIMARY KEY AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL UNIQUE
);

DROP TABLE IF EXISTS `image`;
CREATE TABLE `Image` (
	image_id INT PRIMARY KEY AUTO_INCREMENT,
	image_url VARCHAR(200) NOT NULL
);

DROP TABLE IF EXISTS `account`;
CREATE TABLE `Account` (
	account_id INT PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(255) NOT NULL UNIQUE,
	`password` VARCHAR(255) NOT NULL,
	full_name VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL UNIQUE,
	phone_number VARCHAR(20) NOT NULL,
	image_id INT,
	`address` VARCHAR(255) NOT NULL,
	role_id INT NOT NULL,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (role_id) REFERENCES `role`(role_id),
	FOREIGN KEY (image_id) REFERENCES `image`(image_id)
);


-- PRODUCT RELATED -- 
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
	category_id INT PRIMARY KEY AUTO_INCREMENT,
	category_name VARCHAR(100) NOT NULL,
	image_id INT,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (image_id) REFERENCES `image`(image_id)
);






DROP TABLE IF EXISTS `product-color`;
CREATE TABLE `product-color` (
	product_color_id INT PRIMARY KEY AUTO_INCREMENT,
	color_name VARCHAR(50)
);

DROP TABLE IF EXISTS `product-shape`;
CREATE TABLE `product-shape` (
	product_shape_id INT PRIMARY KEY AUTO_INCREMENT,
	shape_name VARCHAR(50)
);

DROP TABLE IF EXISTS `product-style`;
CREATE TABLE `product-style` (
	product_style_id INT PRIMARY KEY AUTO_INCREMENT,
	style_name VARCHAR(50)
)
;

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
	product_id INT PRIMARY KEY AUTO_INCREMENT,
	product_name VARCHAR(200) NOT NULL,
	`description` VARCHAR(1000),
	is_hide BIT,
	category_id INT,
	product_shape_id INT,
	product_style_id INT,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (category_id) REFERENCES `category`(category_id),
	FOREIGN KEY (product_shape_id) REFERENCES `product-shape`(product_shape_id),
	FOREIGN KEY (product_style_id) REFERENCES `product-style`(product_style_id)

);

DROP TABLE IF EXISTS `product-image`;
CREATE TABLE `product-image` (
	product_id INT,
	image_id INT,
	PRIMARY KEY (product_id, image_id),
	FOREIGN KEY (product_id) REFERENCES `product`(product_id),
	FOREIGN KEY (image_id) REFERENCES `image`(image_id)
);

DROP TABLE IF EXISTS `product-variant`;
CREATE TABLE `product-variant` (
	product_variant_id INT PRIMARY KEY AUTO_INCREMENT,
	product_id INT NOT NULL,
	height INT NOT NULL,
	width INT NOT NULL,
	color_id INT NOT NULL,
	quantity INT NOT NULL,
	price DECIMAL(18, 2) NOT NULL,
	image_id INT,
	FOREIGN KEY (product_id) REFERENCES `product`(product_id),
	FOREIGN KEY (color_id) REFERENCES `product-color`(product_color_id),
	FOREIGN KEY (image_id) REFERENCES `image`(image_id)
);

DROP TABLE IF EXISTS `product-review`;
CREATE TABLE `product-review` (
	product_review_id INT PRIMARY KEY AUTO_INCREMENT,
	account_id INT NOT NULL,
	product_id INT NOT NULL,
	content VARCHAR(1000) NOT NULL,
	rating TINYINT NOT NULL,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (account_id) REFERENCES `account`(account_id),
	FOREIGN KEY (product_id) REFERENCES `product`(product_id)
);


-- WISHLIST
DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE `wishlist` (
	wishlist_id INT PRIMARY KEY AUTO_INCREMENT,
	account_id INT NOT NULL,
	product_id INT NOT NULL,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (account_id) REFERENCES `account`(account_id),
    FOREIGN KEY (product_id) REFERENCES `product`(product_id)
);

-- CART RELATED -- 
DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
	cart_id INT PRIMARY KEY AUTO_INCREMENT,
	account_id INT NOT NULL,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (account_id) REFERENCES `account`(account_id)
);

DROP TABLE IF EXISTS `cart-detail`;
CREATE TABLE `cart-detail` (
	cart_detail_id INT PRIMARY KEY AUTO_INCREMENT,
	product_id INT NOT NULL,
	quantity INT NOT NULL,
	price DECIMAL(18,2) NOT NULL,
	cart_id INT NOT NULL,
	FOREIGN KEY (cart_id) REFERENCES `cart`(cart_id),
	FOREIGN KEY (product_id) REFERENCES `product`(product_id)
);



-- ORDER RELATED -- 
DROP TABLE IF EXISTS `coupon-type`;
CREATE TABLE `coupon-type`(
	coupon_type_id INT PRIMARY KEY AUTO_INCREMENT,
	coupon_type_name VARCHAR(50) NOT NULL
);

DROP TABLE IF EXISTS `coupon`;
CREATE TABLE `coupon` (
	coupon_id INT PRIMARY KEY AUTO_INCREMENT,
	coupon_name VARCHAR(200) NOT NULL,
	discount INT NOT NULL,
	coupon_type_id INT NOT NULL,
	`description` VARCHAR(200),
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	expired_at DATETIME NOT NULL,
	FOREIGN KEY (coupon_type_id) REFERENCES `coupon-type`(coupon_type_id)
);

DROP TABLE IF EXISTS `account-coupon`;
CREATE TABLE `account-coupon`(
	coupon_id INT,
	account_id INT,
	is_used BIT NOT NULL, 
	PRIMARY KEY (coupon_id, account_id),
	FOREIGN KEY (coupon_id) REFERENCES `coupon`(coupon_id),
	FOREIGN KEY (account_id) REFERENCES `account`(account_id)
);

DROP TABLE IF EXISTS `payment-method`;
CREATE TABLE `payment-method` (
	payment_method_id INT PRIMARY KEY AUTO_INCREMENT,
	payment_method_name VARCHAR(100) NOT NULL
);

DROP TABLE IF EXISTS `order-status`;
CREATE TABLE `order-status` (
	order_status_id INT PRIMARY KEY AUTO_INCREMENT,
	status_name VARCHAR(50) NOT NULL,
	status_description VARCHAR(100) NOT NULL
);

DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
	order_id INT PRIMARY KEY AUTO_INCREMENT,
	order_tracking_number VARCHAR(50),
	account_id INT NOT NULL,
	coupon_id INT,
	total_price DECIMAL(18,2) NOT NULL,
	total_quantity INT NOT NULL,
	order_status_id INT NOT NULL,
	billing_address VARCHAR(200),
	shipping_address VARCHAR(200),
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (account_id) REFERENCES `account`(account_id),
	FOREIGN KEY (order_status_id) REFERENCES `order-status`(order_status_id),
	FOREIGN KEY (coupon_id) REFERENCES `coupon`(coupon_id)
);

DROP TABLE IF EXISTS `order-detail`;
CREATE TABLE `order-detail` (
	order_detail_id INT PRIMARY KEY AUTO_INCREMENT,
	order_id INT NOT NULL,
	product_id INT NOT NULL,
	address_id INT NOT NULL,
	quantity INT NOT NULL,
	price DECIMAL(18,2) NOT NULL,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (order_id) REFERENCES `order`(order_id),
	FOREIGN KEY (product_id) REFERENCES `product`(product_id)
);

-- INVOICE RELATED
DROP TABLE IF EXISTS `invoice-status`;
CREATE TABLE `invoice-status` (
	invoice_status_id INT PRIMARY KEY AUTO_INCREMENT,
	status_name VARCHAR(50) NOT NULL,
	status_description VARCHAR(100) NOT NULL
);

DROP TABLE IF EXISTS `invoice`;
CREATE TABLE `invoice` (
	invoice_id INT PRIMARY KEY AUTO_INCREMENT,
	payment_method_id INT NOT NULL,
	coupon_id INT,
	invoice_status_id INT NOT NULL,
	account_id INT NOT NULL,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (payment_method_id) REFERENCES `payment-method`(payment_method_id),
	FOREIGN KEY (account_id) REFERENCES `Account`(account_id),
	FOREIGN KEY (invoice_status_id) REFERENCES `invoice-status`(invoice_status_id)
);


-- Other tables
DROP TABLE IF EXISTS `company-information`;
CREATE TABLE `company-information` (
	company_information_id INT PRIMARY KEY AUTO_INCREMENT,
	company_name VARCHAR(50) NOT NULL,
	company_address VARCHAR(100) NOT NULL,
	company_phone_number VARCHAR(20) NOT NULL,
	company_vat_number VARCHAR(20) NOT NULL
);

DROP TABLE IF EXISTS `notification`;
CREATE TABLE `notification` (
	notification_id INT PRIMARY KEY AUTO_INCREMENT,
	`message` VARCHAR(200) NOT NULL,
	account_id INT,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	is_read BIT,
	FOREIGN KEY (account_id) REFERENCES `account`(account_id)
);