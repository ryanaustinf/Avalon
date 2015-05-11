SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `avalon`;
USE `avalon`;

CREATE TABLE IF NOT EXISTS `member`(
	id INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(128) NOT NULL,
    lastName VARCHAR(128) NOT NULL,
    username VARCHAR(64) NOT NULL,
    password VARCHAR(64) NOT NULL,
    bio VARCHAR(512),
    gamesPlayed INT DEFAULT 0
)engine = innoDB;

CREATE TABLE IF NOT EXISTS `moderator`(
	id INT PRIMARY KEY,
    CONSTRAINT moderatorfk_1
		FOREIGN KEY(id)
        REFERENCES `member`(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
)engine = innoDB;

CREATE TABLE IF NOT EXISTS `admin`(
	id INT PRIMARY KEY,
    CONSTRAINT adminfk_1
		FOREIGN KEY(id)
        REFERENCES `moderator`(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
)engine = innoDB;

CREATE TABLE IF NOT EXISTS `game`(
	id INT AUTO_INCREMENT PRIMARY KEY,
    hosted DATETIME NOT NULL DEFAULT NOW(),
    ended DATETIME DEFAULT NULL,
    cancelled BOOLEAN NOT NULL DEFAULT FALSE,
    friendsOnly BOOLEAN NOT NULL DEFAULT FALSE,
    minPlayers INT NOT NULL DEFAULT 5,
    maxPlayers INT NOT NULL DEFAULT 10,
    targeting BOOLEAN NOT NULL DEFAULT FALSE,
    ladyOfTheLake BOOLEAN NOT NULL DEFAULT FALSE
) engine = innoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;