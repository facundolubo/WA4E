DROP DATABASE IF EXISTS js_profiles;
CREATE DATABASE js_profiles DEFAULT CHARACTER SET utf8 ;
USE js_profiles;

drop user if exists 'fred'@'localhost';
drop user if exists 'fred'@'127.0.0.1';
drop user if exists 'facundol'@'localhost';
drop user if exists 'facundol'@'127.0.0.1';
drop user if exists 'root'@'localhost';
drop user if exists 'root'@'127.0.0.1';

CREATE USER 'fred'@'localhost' IDENTIFIED BY 'Skullproz0!';
CREATE USER 'fred'@'127.0.0.1' IDENTIFIED BY 'Skullproz0!';
CREATE USER 'facundol'@'localhost' IDENTIFIED BY 'Skullproz0!';
CREATE USER 'facundol'@'127.0.0.1' IDENTIFIED BY 'Skullproz0!';
CREATE USER 'root'@'localhost' IDENTIFIED BY 'Skullproz0!';
CREATE USER 'root'@'127.0.0.1' IDENTIFIED BY 'Skullproz0!';

FLUSH PRIVILEGES;

CREATE TABLE users (
    user_id INTEGER NOT NULL AUTO_INCREMENT,
    name VARCHAR(128),
    email VARCHAR(128),
    password VARCHAR(128),
    PRIMARY KEY(user_id),
    INDEX(email)
) ENGINE=InnoDB CHARSET=utf8;

CREATE TABLE Profile (
  profile_id INTEGER NOT NULL AUTO_INCREMENT,
  user_id INTEGER NOT NULL,
  first_name TEXT,
  last_name TEXT,
  email TEXT,
  headline TEXT,
  summary TEXT,
  PRIMARY KEY(profile_id),
  CONSTRAINT profile_ibfk_2
  FOREIGN KEY (user_id)
  REFERENCES users (user_id)
  ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE users ADD INDEX(email);
ALTER TABLE users ADD INDEX(password);
INSERT INTO users (name,email,password)
    VALUES ('Chuck','csev@umich.edu','1a52e17fa899cf40fb04cfc42e6352f1');
INSERT INTO users (name,email,password)
    VALUES ('UMSI','umsi@umich.edu','1a52e17fa899cf40fb04cfc42e6352f1');
INSERT INTO users (name,email,password)
    VALUES ('facundol','facundolubo@gmail.com','4232');

GRANT ALL ON js_profiles.* TO 'facundol'@'localhost';
GRANT ALL ON js_profiles.* TO 'facundol'@'127.0.0.1';
GRANT ALL ON js_profiles.* TO 'fred'@'localhost';
GRANT ALL ON js_profiles.* TO 'fred'@'127.0.0.1';
GRANT ALL ON js_profiles.* TO 'root'@'localhost'; 
GRANT ALL ON js_profiles.* TO 'root'@'127.0.0.1';