-- Insert Users
INSERT INTO User (email, username, password)
VALUES
  ('admin@example.com', 'adminuser', 'adminpassword'),
  ('user@example.com', 'regularuser', 'userpassword');

-- Insert User Roles
INSERT INTO UserRole (user_id, role)
VALUES
  (1, 'admin'),
  (2, 'user');

-- Insert Products
INSERT INTO Product (product_name, product_price)
VALUES
  ('Product A', 10.99),
  ('Product B', 15.49),
  ('Product C', 8.99),
  ('Product D', 12.79),
  ('Product E', 6.49);


-- Insert Orders
INSERT INTO `Order` (user_id)
VALUES
  (1), -- Admin user placing an order
  (2); -- Regular user placing an order

-- Insert Order Lines
INSERT INTO OrderLine (order_id, product_id, quantity)
VALUES
  (1, 1, 3), -- Admin user's order with 3 units of Product A
  (2, 2, 2), -- Regular user's order with 2 units of Product B;
  (3, 3, 5), -- Regular user's order with 5 units of Product C
  (3, 4, 2), -- Regular user's order with 2 units of Product D
  (4, 1, 4), -- Admin user's order with 4 units of Product A
  (4, 5, 3); -- Admin user's order with 3 units of Product E
