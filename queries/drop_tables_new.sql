USE shopdb;


-- Drop tables in reverse order to handle dependencies
DROP TABLE IF EXISTS OrderLine;
DROP TABLE IF EXISTS `Order`;
DROP TABLE IF EXISTS UserRole;
DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Roles;
