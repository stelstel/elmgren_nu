--
-- Table for user
--
DROP TABLE IF EXISTS USER;
 
CREATE TABLE USER
(
  id INT AUTO_INCREMENT PRIMARY KEY,
  acronym CHAR(12) UNIQUE NOT NULL,
  name VARCHAR(80),
  password CHAR(32),
  salt INT NOT NULL
) ENGINE INNODB CHARACTER SET utf8;
 
INSERT INTO USER (acronym, name, salt) VALUES 
  ('doe', 'John/Jane Doe', unix_timestamp()),
  ('admin', 'Administrator', unix_timestamp())
;
 
UPDATE USER SET password = md5(concat('doe', salt)) WHERE acronym = 'doe';
UPDATE USER SET password = md5(concat('admin', salt)) WHERE acronym = 'admin';
 
SELECT * FROM USER;

# Kolla om det funkar
SELECT acronym, name FROM USER WHERE acronym = ? AND password = md5(concat(?, salt))
/*Tex SELECT acronym, name
FROM user 
WHERE acronym = "admin" AND password = md5(concat("admin", 1413581887) );
*/