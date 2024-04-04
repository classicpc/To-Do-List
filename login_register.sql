-- This SQL dump creates a database named 'login_register' with a table 'users'.
-- It contains information about users, including their full name, email, and password.

-- Rewritten SQL Dump

-- Create the 'login_register' database if it doesn't exist
CREATE DATABASE IF NOT EXISTS `login_register`;

-- Use the 'login_register' database
USE `login_register`;

-- Create the 'users' table
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `full_name` VARCHAR(128) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert a sample user into the 'users' table
INSERT INTO `users` (`full_name`, `email`, `password`) 
VALUES ('Aktar', 'aktar@gmail.com', '$2y$10$Jmf9Xk2y8m.fo3c/ZgKmzOrdIRkU05KSGLI0picKLEtr68ll7hjB.');

-- The password in the above INSERT statement is hashed for security.

-- End of SQL Dump
