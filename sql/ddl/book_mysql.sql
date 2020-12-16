--
-- Creating a small table.
-- Create a database and a user having access to this database,
-- this must be done by hand, se commented rows on how to do it.
--


-- SET GLOBAL local_infile = 1;
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



--
-- Table Book
--
DROP TABLE IF EXISTS Book;
CREATE TABLE Book (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `title` VARCHAR(256) NOT NULL,
    `author` VARCHAR(256) NOT NULL,
    `image` VARCHAR(256),
    `description` VARCHAR(512)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;


--
-- Insert into book
--
DELETE FROM Book;

LOAD DATA LOCAL INFILE 'book.csv'
INTO TABLE Book
CHARSET utf8
FIELDS
    TERMINATED BY ','
    ENCLOSED BY '"'
LINES
    TERMINATED BY '\n'
IGNORE 1 LINES
;
