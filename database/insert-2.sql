USE clear_reflection;

INSERT INTO product_style (product_style_id, style_name) VALUES
(1, 'Contemporary'),
(2, 'Antique'),
(3, 'Art Deco'),
(4, 'Minimalist'),
(5, 'Industrial');

INSERT INTO product_shape (product_shape_id, shape_name) VALUES
(1, 'Rectangle'),
(2, 'Oval'),
(3, 'Round'),
(4, 'Square'),
(5, 'Sunburst');



INSERT INTO role (role_id, name) VALUES
(1, 'admin'),
(2, 'customer');
INSERT INTO image (image_id, image_url) VALUES
(1, 'vanity-mirror.png'),
(2, 'wall-mirror.png'),
(3, 'floor-mirror.png'),
(4, 'decorative-mirror.png'),
(5, 'bathroom-mirror.png');
INSERT INTO category (category_id, category_name, image_id) VALUES
(1, 'Vanity Mirrors', 1),
(2, 'Wall Mirrors', 2),
(3, 'Floor Mirrors\r\n', 3),
(4, 'Decorative Mirrors', 4),
(5, 'Bathroom Mirrors', 5);

INSERT INTO company_information (company_information_id, company_name, company_address, company_phone_number, company_vat_number) VALUES
(1, 'Clear Reflection', '35/6 D5 street, Ward 25 Binh Thanh District HCM ', '090-187-1698', 'GB123456789');



INSERT INTO product_color (product_color_id, color_name) VALUES
(1, 'Red'),
(2, 'White'),
(3, 'Silver'),
(4, 'Gold'),
(5, 'Bronze'),
(10, 'Green'),
(11, 'Pinl');

INSERT INTO coupon_type(coupon_type_id, coupon_type_name)
VALUES (1, 'Fixed'), (2, 'Percent');


INSERT INTO `Account`(username, password, full_name, email, phone_number, image_id, role_id)
VALUES ('phupro123ka1', '123,', 'Nguyễn Mạnh Phú 1', 'nguyenphu1147@gmail.com', '0783562372', 1, 1),
('daohoangmykhanh', '123,', 'Đào Hoàng Mỹ Khánh 2', 'daohoangmykhanh@gmail.com', '4812341234', 2, 1),
('nguyenphihung', '123,', 'Nguyễn Phi Hùng', 'hungn12333@gmail.com', '2341234', 3, 1),
('phupro123ka4', '123,', 'Nguyễn Mạnh Phú', 'nguyenphu1147@gmail.com', '0783562372', 4, 1),
('phupro123ka5', '123,', 'Nguyễn Mạnh Phú', 'nguyenphu1147@gmail.com', '0783562372', 5, 1),









