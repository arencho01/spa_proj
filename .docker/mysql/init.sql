SET NAMES utf8;

CREATE DATABASE IF NOT EXISTS `finances`;

USE `finances`;


CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL,
    `password` VARCHAR(255) NOT NULL
)ENGINE=innoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `finance_operations` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT,
    `sum` DECIMAL(10, 2),
    `type` ENUM('приход', 'расход'),
    `comment` TEXT,
    `date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
)ENGINE=innoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1;

