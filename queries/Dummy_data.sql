-- Dummy data for User table
-- INSERT INTO User (email, username, password) VALUES
--   ('user1@example.com', 'user1', 'password1'),
--   ('user2@example.com', 'user2', 'password2'),
--   ('user3@example.com', 'user3', 'password3');

-- -- Dummy data for UserRole table
-- INSERT INTO UserRole (role_id, user_id) VALUES
--   (1, 1), -- Assigning Admin role to user1
--   (2, 2), -- Assigning Customer role to user2
--   (2, 3); -- Assigning Customer role to user3

-- Dummy data for Roles table
use shopdb;

INSERT INTO Roles (role) VALUES
  ('user'), -- Must be id = 1 (or it will break)
  ('admin'); -- Must be id = 2 (or it will break)

-- Dummy data for Product table
INSERT INTO Product (product_name, product_price) VALUES
  ('Product A', 19.99),
  ('Product B', 29.99),
  ('Product C', 9.99),
  ('Product D', 19.99),
  ('Product E', 29.99),
  ('Product F', 9.99);

-- Dummy data for Order table
-- INSERT INTO `Order` (user_id) VALUES
--   (1), -- Order by user1
--   (2), -- Order by user2
--   (3); -- Order by user3

-- -- Dummy data for OrderLine table
-- INSERT INTO OrderLine (order_id, product_id, quantity) VALUES
--   (1, 1, 2), -- Order for Product A by user1
--   (2, 2, 3), -- Order for Product B by user2
--   (3, 3, 1); -- Order for Product C by user3
