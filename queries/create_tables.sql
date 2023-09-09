USE shopdb;

CREATE TABLE User (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255),
  username VARCHAR(255) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE Roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  role VARCHAR(255)
);

CREATE TABLE Product (
  product_id INT AUTO_INCREMENT PRIMARY KEY,
  product_name VARCHAR(255),
  product_price FLOAT
);

CREATE TABLE UserRole (
  id INT AUTO_INCREMENT PRIMARY KEY,
  role_id INT,
  user_id INT,
  FOREIGN KEY (role_id) REFERENCES Roles(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES User(user_id) ON DELETE CASCADE
);

CREATE TABLE `Order` (
  order_id VARCHAR(255) PRIMARY KEY,
  user_id INT,
  order_status VARCHAR(255) DEFAULT 'In Progress',
  created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES User(user_id) ON DELETE CASCADE
);

CREATE TABLE OrderLine (
  orderline_id INT AUTO_INCREMENT PRIMARY KEY,
  order_id VARCHAR(255),
  product_id INT,
  quantity INT,
  price FLOAT,
  FOREIGN KEY (order_id) REFERENCES `Order`(order_id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES Product(product_id) ON DELETE CASCADE
);
