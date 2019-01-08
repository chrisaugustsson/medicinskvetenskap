--
-- Creating a small table.
-- Create a database and a user having access to this database,
-- this must be done by hand, se commented rows on how to do it.
--



--
-- Create a database for test
--
-- DROP DATABASE anaxdb;
-- CREATE DATABASE IF NOT EXISTS anaxdb;
USE anaxdb;



--
-- Create a database user for the test database
--
-- GRANT ALL ON anaxdb.* TO anax@localhost IDENTIFIED BY 'anax';



-- Ensure UTF8 on the database connection
SET NAMES utf8;

DROP TABLE IF EXISTS Vote;
DROP TABLE IF EXISTS ThreadTag;
DROP TABLE IF EXISTS Comment;
DROP TABLE IF EXISTS Answer;
DROP TABLE IF EXISTS Thread;


--
-- Table Thread
--
CREATE TABLE Thread (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `title` VARCHAR(256) NOT NULL,
    `content` VARCHAR(20000) NOT NULL,
    `owner` VARCHAR(256) NOT NULL,
    `published` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `score` INT DEFAULT 0

) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;


--
-- Table Comments
--
CREATE TABLE Comment (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `owner` VARCHAR(256) NOT NULL,
    `content` VARCHAR(20000) NOT NULL,
    `published` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `score` INT DEFAULT 0,
    `threadID` INT,
    `answerID` INT,

    FOREIGN KEY (threadID) REFERENCES Thread(id)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Table Answer
--
CREATE TABLE Answer (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `owner` VARCHAR(256) NOT NULL,
    `content` VARCHAR(20000) NOT NULL,
    `published` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `score` INT DEFAULT 0,
    `threadID` INT,

    FOREIGN KEY (threadID) REFERENCES Thread(id)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Table User
--
DROP TABLE IF EXISTS User;
CREATE TABLE User (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `acronym` VARCHAR(80) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `firstName` VARCHAR(255) NOT NULL,
    `lastName` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `gravatar` VARCHAR(255) NOT NULL,
    `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Table for tags
--
DROP TABLE IF EXISTS Tag;
CREATE TABLE Tag (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `name` VARCHAR(254) UNIQUE NOT NULL,
    `description` VARCHAR(256)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Coupling table for tags and threads
--
CREATE TABLE ThreadTag (
	`id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
	`tagId` INTEGER,
    `threadId` INTEGER,

    FOREIGN KEY (threadId) REFERENCES Thread(id),
    FOREIGN KEY (tagId) REFERENCES Tag(id)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;


CREATE TABLE Vote (
	`id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
	`thread` INTEGER,
    `answer` INTEGER,
	`comment` INTEGER,
    `user` VARCHAR(200),


    FOREIGN KEY (thread) REFERENCES Thread(id),
    FOREIGN KEY (comment) REFERENCES Comment(id),
    FOREIGN KEY (answer) REFERENCES Answer(id)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;





insert into tag (name) value ("oprtopedi");
insert into tag (name) value ("kirurgi");
insert into tag (name) value ("magproblem");
insert into tag (name) value ("hjärnkirurgi");
insert into tag (name) value ("cancer");
insert into tag (name) value ("diabetes");