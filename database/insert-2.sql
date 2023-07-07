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

INSERT INTO category (category_id, category_name, image_id) VALUES
(2, 'Vanity Mirrors', NULL),
(4, 'Wall Mirrors', NULL),
(5, 'Floor Mirrors\r\n', NULL),
(6, 'Decorative Mirrors', NULL),
(7, 'Bathroom Mirrors', NULL);

INSERT INTO company_information (company_information_id, company_name, company_address, company_phone_number, company_vat_number) VALUES
(1, 'Clear Reflection', '35/6 D5 street, Ward 25 Binh Thanh District HCM ', '090-187-1698', 'GB123456789');

INSERT INTO image (image_id, image_url) VALUES
(22, 'helo'),
(23, 'hi'),
(24, 'https://example.com/image1.jpg'),
(25, 'helo'),
(26, 'https://cdn.pixabay.com/photo/2023/03/17/02/42/architecture-7857832_1280.jpg'),
(27, 'https://cdn.pixabay.com/photo/2023/03/17/02/42/architecture-7857832_1280.jpg'),
(28, 'https://images.unsplash.com/photo-1688499153976-7573901224ff?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80'),
(29, 'https://images.unsplash.com/photo-1688499153976-7573901224ff?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80'),
(30, 'https://cdn.pixabay.com/photo/2023/03/17/02/42/architecture-7857832_1280.jpg');

INSERT INTO product (product_id, product_name, description, is_hide, category_id, product_shape_id, product_style_id, created_at, updated_at) VALUES
(21, 'Example Product', 'This is an example product', b'0', 2, 1, 2, '2023-07-04 07:32:10', '2023-07-04 07:32:10'),
(22, 'Example Product 1', 'This is an example product 1', b'1', 4, 3, 5, '2023-07-04 07:41:14', '2023-07-04 07:41:14'),
(23, 'Example Product 1', 'This is an example product 1', b'1', 4, 3, 5, '2023-07-04 07:41:37', '2023-07-04 07:41:37');

INSERT INTO product_color (product_color_id, color_name) VALUES
(1, 'Red'),
(2, 'White'),
(3, 'Silver'),
(4, 'Gold'),
(5, 'Bronze'),
(10, 'Green'),
(11, 'Pinl');

INSERT INTO product_image (product_id, image_id) VALUES
(23, 26),
(23, 27),
(22, 29),
(21, 29),
(21, 30);


INSERT INTO product_variant (product_variant_id, product_id, height, width, color_id, quantity, price, image_id) VALUES
(9, 21, 10, 5, 1, 100, '20.00', 24),
(10, 21, 8, 6, 10, 50, '15.00', NULL),
(11, 23, 10, 5, 1, 50, '20.00', 28),
(12, 23, 8, 6, 11, 12, '15.00', NULL);









