-- Active: 1779446988220@@127.0.0.1@3306
CREATE DATABASE peersync ;

DROP DATABASE peersync ;
use peersync ;

CREATE TABLE `roles` (
  `id` INT NOT NULL,
  `role` VARCHAR(50),
  PRIMARY KEY (`id`)
);

CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT,
  `name` VARCHAR(50)  NOT NULL,
  `email` VARCHAR(100)  NOT NULL,
  `password` VARCHAR(255)  NOT NULL,
  `first_time` ENUM('0', '1') NOT NULL,
  `role_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`role_id`)
      REFERENCES `roles`(`id`)
);

CREATE TABLE `skills` (
  `id` INT AUTO_INCREMENT,
  `name` VARCHAR(200),
  `dificulti` ENUM('easy', 'medium',"hard") NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `user_skills` (
  `id` INT AUTO_INCREMENT,
  `maitrise` ENUM("maîtrisées","à travailler") NOT NULL,
  `skill_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`skill_id`)
      REFERENCES `skills`(`id`),
  FOREIGN KEY (`user_id`)
      REFERENCES `users`(`id`)
);

CREATE TABLE `badges` (
  `id` INT AUTO_INCREMENT,
  `requirements` INT NOT NULL,
  `name` VARCHAR(50)  NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `user_badges` (
  `id` INT AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `skill_id` INT NOT NULL,
  `badge_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`skill_id`)
      REFERENCES `skills`(`id`),
  FOREIGN KEY (`user_id`)
      REFERENCES `users`(`id`),
  FOREIGN KEY (`badge_id`)
      REFERENCES `badges`(`id`)
);

CREATE TABLE `reviews` (
  `id` INT AUTO_INCREMENT,
  `comment` TEXT,
  `rating` INT,
  `reviewer_id` INT NOT NULL,
  `help_quest_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`reviewer_id`)
      REFERENCES `users`(`id`)
);

CREATE TABLE `status` (
  `id` INT NOT NULL,
  `status` VARCHAR(50),
  PRIMARY KEY (`id`)
);

CREATE TABLE `help_requests` (
  `id` INT AUTO_INCREMENT,
  `title` VARCHAR(255),
  `description` TEXT,
  `date_pub` DATETIME NOT NULL,
  `date_session` DATETIME,
  `learner_id` INT NOT NULL,
  `tutor_id` INT,
  `skill_id` INT NOT NULL,
  `status_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`tutor_id`)
      REFERENCES `users`(`id`),
  FOREIGN KEY (`learner_id`)
      REFERENCES `users`(`id`),
  FOREIGN KEY (`skill_id`)
      REFERENCES `skills`(`id`),
  FOREIGN KEY (`status_id`)
      REFERENCES `status`(`id`)
);