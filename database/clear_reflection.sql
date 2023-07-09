DROP DATABASE IF EXISTS clear_reflection;
CREATE DATABASE clear_reflection;

USE clear_reflection;
-- ACCOUNT RELATED -- 
DROP TABLE IF EXISTS role;
CREATE TABLE role (
	role_id INT PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(50) NOT NULL UNIQUE
);

DROP TABLE IF EXISTS image;
CREATE TABLE Image (
	image_id INT PRIMARY KEY AUTO_INCREMENT,
	image_url VARCHAR(200) NOT NULL
);

DROP TABLE IF EXISTS `Account`;
CREATE TABLE `Account` (
	id INT PRIMARY KEY AUTO_INCREMENT,
	password VARCHAR(255) NOT NULL,
	full_name VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL UNIQUE,
	phone_number VARCHAR(20) NOT NULL,
	image_id INT,
	role_id INT NOT NULL,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (role_id) REFERENCES `role`(role_id),
	FOREIGN KEY (image_id) REFERENCES `image`(image_id)
);


-- PRODUCT RELATED -- 
DROP TABLE IF EXISTS category;
CREATE TABLE category (
	category_id INT PRIMARY KEY AUTO_INCREMENT,
	category_name VARCHAR(100) NOT NULL,
	image_id INT,
	FOREIGN KEY (image_id) REFERENCES `image`(image_id)
);






DROP TABLE IF EXISTS product_color;
CREATE TABLE product_color (
	product_color_id INT PRIMARY KEY AUTO_INCREMENT,
	color_name VARCHAR(50)
);

DROP TABLE IF EXISTS product_shape;
CREATE TABLE product_shape (
	product_shape_id INT PRIMARY KEY AUTO_INCREMENT,
	shape_name VARCHAR(50)
);

DROP TABLE IF EXISTS product_style;
CREATE TABLE product_style (
	product_style_id INT PRIMARY KEY AUTO_INCREMENT,
	style_name VARCHAR(50)
)
;

DROP TABLE IF EXISTS product;
CREATE TABLE product (
	product_id INT PRIMARY KEY AUTO_INCREMENT,
	product_name VARCHAR(200) NOT NULL,
	description VARCHAR(1000),
	is_hide BIT,
	category_id INT,
	product_shape_id INT,
	product_style_id INT,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (category_id) REFERENCES `category`(category_id),
	FOREIGN KEY (product_shape_id) REFERENCES `product_shape`(product_shape_id),
	FOREIGN KEY (product_style_id) REFERENCES `product_style`(product_style_id)

);

DROP TABLE IF EXISTS product_image;
CREATE TABLE product_image (
	product_id INT,
	image_id INT,
	PRIMARY KEY (product_id, image_id),
	FOREIGN KEY (product_id) REFERENCES `product`(product_id),
	FOREIGN KEY (image_id) REFERENCES `image`(image_id)
);

DROP TABLE IF EXISTS product_variant;
CREATE TABLE product_variant (
	product_variant_id INT PRIMARY KEY AUTO_INCREMENT,
	product_id INT NOT NULL,
	height INT NOT NULL,
	width INT NOT NULL,
	color_id INT NOT NULL,
	quantity INT NOT NULL,
	price DECIMAL(18, 2) NOT NULL,
	image_id INT,
	FOREIGN KEY (product_id) REFERENCES `product`(product_id),
	FOREIGN KEY (color_id) REFERENCES `product_color`(product_color_id),
	FOREIGN KEY (image_id) REFERENCES `image`(image_id)
);

DROP TABLE IF EXISTS product_review;
CREATE TABLE product_review (
	product_review_id INT PRIMARY KEY AUTO_INCREMENT,
	account_id INT NOT NULL,
	product_id INT NOT NULL,
	content VARCHAR(1000) NOT NULL,
	rating TINYINT NOT NULL,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (account_id) REFERENCES `account`(id),
	FOREIGN KEY (product_id) REFERENCES `product`(product_id)
);


-- WISHLIST
DROP TABLE IF EXISTS wishlist;
CREATE TABLE wishlist (
	wishlist_id INT PRIMARY KEY AUTO_INCREMENT,
	account_id INT NOT NULL,
	product_id INT NOT NULL,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (account_id) REFERENCES `account`(id),
    FOREIGN KEY (product_id) REFERENCES `product`(product_id)
);

-- CART RELATED -- 
DROP TABLE IF EXISTS cart;
CREATE TABLE cart (
	cart_id INT PRIMARY KEY AUTO_INCREMENT,
	account_id INT NOT NULL,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (account_id) REFERENCES `account`(id)
);

DROP TABLE IF EXISTS cart_detail;
CREATE TABLE cart_detail (
	cart_detail_id INT PRIMARY KEY AUTO_INCREMENT,
	product_id INT NOT NULL,
	quantity INT NOT NULL,
	price DECIMAL(18,2) NOT NULL,
	cart_id INT NOT NULL,
	FOREIGN KEY (cart_id) REFERENCES `cart`(cart_id),
	FOREIGN KEY (product_id) REFERENCES `product`(product_id)
);



-- ORDER RELATED -- 
DROP TABLE IF EXISTS coupon_type;
CREATE TABLE `coupon_type`(
	coupon_type_id INT PRIMARY KEY AUTO_INCREMENT,
	coupon_type_name VARCHAR(50) NOT NULL
);	

DROP TABLE IF EXISTS coupon;
CREATE TABLE coupon (
	coupon_id INT PRIMARY KEY AUTO_INCREMENT,
	`code` VARCHAR(200) NOT NULL,
	discount INT NOT NULL,
	coupon_type_id INT NOT NULL,
	description VARCHAR(200),
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	expired_at DATETIME NOT NULL,
	FOREIGN KEY (coupon_type_id) REFERENCES `coupon_type`(coupon_type_id)
);

DROP TABLE IF EXISTS account_coupon;
CREATE TABLE `account_coupon`(
	coupon_id INT,
	account_id INT,
	is_used BIT NOT NULL, 
	PRIMARY KEY (coupon_id, account_id),
	FOREIGN KEY (coupon_id) REFERENCES `coupon`(coupon_id),
	FOREIGN KEY (account_id) REFERENCES `account`(id)
);

DROP TABLE IF EXISTS payment_method;
CREATE TABLE payment_method (
	payment_method_id INT PRIMARY KEY AUTO_INCREMENT,
	payment_method_name VARCHAR(100) NOT NULL
);

DROP TABLE IF EXISTS order_status;
CREATE TABLE order_status (
	order_status_id INT PRIMARY KEY AUTO_INCREMENT,
	status_name VARCHAR(50) NOT NULL,
	status_description VARCHAR(100) NOT NULL
);






-- Other tables
DROP TABLE IF EXISTS company_information;
CREATE TABLE company_information (
	company_information_id INT PRIMARY KEY AUTO_INCREMENT,
	company_name VARCHAR(50) NOT NULL,
	company_address VARCHAR(100) NOT NULL,
	company_phone_number VARCHAR(20) NOT NULL,
	company_vat_number VARCHAR(20) NOT NULL
);

DROP TABLE IF EXISTS notification;
CREATE TABLE notification (
	notification_id INT PRIMARY KEY AUTO_INCREMENT,
	message VARCHAR(200) NOT NULL,
	account_id INT,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	is_read BIT,
	FOREIGN KEY (account_id) REFERENCES `account`(id)
);



-- adress///////////////////////////




DROP TABLE IF EXISTS administrative_units;
CREATE TABLE administrative_units (
	id integer NOT NULL,
	full_name varchar(255) NULL,
	full_name_en varchar(255) NULL,
	short_name varchar(255) NULL,
	short_name_en varchar(255) NULL,
	code_name varchar(255) NULL,
	code_name_en varchar(255) NULL,
    account_id int ,
	CONSTRAINT administrative_units_pkey PRIMARY KEY (id)
  
);


-- CREATE provinces TABLE
DROP TABLE IF EXISTS provinces;
CREATE TABLE provinces (
	code varchar(20) NOT NULL,
	name varchar(255) NOT NULL,
	name_en varchar(255) NULL,
	full_name varchar(255) NOT NULL,
	full_name_en varchar(255) NULL,
	code_name varchar(255) NULL,
	administrative_unit_id integer NULL,
    administrative_region_id int,
	CONSTRAINT provinces_pkey PRIMARY KEY (code)
);


-- provinces foreign keys

ALTER TABLE provinces ADD CONSTRAINT provinces_administrative_unit_id_fkey FOREIGN KEY (administrative_unit_id) REFERENCES administrative_units(id);


CREATE INDEX idx_provinces_unit ON provinces(administrative_unit_id);


-- CREATE districts TABLE
DROP TABLE IF EXISTS districts;
CREATE TABLE districts (
	code varchar(20) NOT NULL,
	name varchar(255) NOT NULL,
	name_en varchar(255) NULL,
	full_name varchar(255) NULL,
	full_name_en varchar(255) NULL,
	code_name varchar(255) NULL,
	province_code varchar(20) NULL,
	administrative_unit_id integer NULL,
	CONSTRAINT districts_pkey PRIMARY KEY (code)
);


-- districts foreign keys

ALTER TABLE districts ADD CONSTRAINT districts_administrative_unit_id_fkey FOREIGN KEY (administrative_unit_id) REFERENCES administrative_units(id);
ALTER TABLE districts ADD CONSTRAINT districts_province_code_fkey FOREIGN KEY (province_code) REFERENCES provinces(code);

CREATE INDEX idx_districts_province ON districts(province_code);
CREATE INDEX idx_districts_unit ON districts(administrative_unit_id);


-- CREATE wards TABLE
DROP TABLE IF EXISTS wards;
CREATE TABLE wards (
	code varchar(20) NOT NULL,
	name varchar(255) NOT NULL,
	name_en varchar(255) NULL,
	full_name varchar(255) NULL,
	full_name_en varchar(255) NULL,
	code_name varchar(255) NULL,
	district_code varchar(20) NULL,
	administrative_unit_id integer NULL,
	CONSTRAINT wards_pkey PRIMARY KEY (code)
);


-- wards foreign keys

ALTER TABLE wards ADD CONSTRAINT wards_administrative_unit_id_fkey FOREIGN KEY (administrative_unit_id) REFERENCES administrative_units(id);
ALTER TABLE wards ADD CONSTRAINT wards_district_code_fkey FOREIGN KEY (district_code) REFERENCES districts(code);

CREATE INDEX idx_wards_district ON wards(district_code);
CREATE INDEX idx_wards_unit ON wards(administrative_unit_id);
DROP TABLE IF EXISTS address;
CREATE TABLE address (
	address_id integer NOT NULL primary key,
	road_name  varchar(255) NULL,
    wards_code varchar(20),
    district_code varchar(20),
    province_code varchar(20),
    FOREIGN KEY (wards_code) REFERENCES `wards`(code),
    FOREIGN KEY (district_code) REFERENCES `districts`(code),
    FOREIGN KEY (province_code) REFERENCES `provinces`(code)
	
);

DROP TABLE IF EXISTS account_address;
CREATE TABLE account_address (
	id INT PRIMARY KEY AUTO_INCREMENT,
	address_id int NOT NULL,
    account_id INT ,
    FOREIGN KEY (address_id) REFERENCES `address`(address_id),
    FOREIGN KEY (account_id) REFERENCES `Account`(id)
);

DROP TABLE IF EXISTS company_address;
CREATE TABLE company_address (
	id INT PRIMARY KEY AUTO_INCREMENT,
	address_id int NOT NULL,
    company_information_id INT ,
    FOREIGN KEY (address_id) REFERENCES `address`(address_id),
    FOREIGN KEY (company_information_id) REFERENCES `company_information`(company_information_id)
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
    payment_method_id INT NOT NULL,
	address_id INT NOT NULL,
	created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (payment_method_id) REFERENCES `payment_method`(payment_method_id),
	FOREIGN KEY (account_id) REFERENCES `account`(id),
	FOREIGN KEY (order_status_id) REFERENCES `order_status`(order_status_id),
	FOREIGN KEY (coupon_id) REFERENCES `coupon`(coupon_id),
    FOREIGN KEY (address_id) REFERENCES `address`(address_id)

   
);

DROP TABLE IF EXISTS order_detail;
CREATE TABLE order_detail (
	order_detail_id INT PRIMARY KEY AUTO_INCREMENT,
	order_id INT NOT NULL,
    product_name varchar(250),
	product_id INT NOT NULL,
	quantity INT NOT NULL,
	height INT ,
	width INT ,
	color varchar(50) ,
	price DECIMAL(18,2) NOT NULL,
	FOREIGN KEY (order_id) REFERENCES `order`(order_id),
	FOREIGN KEY (product_id) REFERENCES `product`(product_id)
);




