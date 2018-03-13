CREATE DATABASE indiv_register;
USE indiv_register;
CREATE TABLE user(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(100) NOT NULL,
	`password` VARCHAR(100),
    favNumber INT
);
