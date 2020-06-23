# ASCII function used to get unique salts
INSERT INTO USER (acronym, name, salt) VALUES ('bajenbrud', 'Agneta Hansson', (ASCII('bajenbrud') * unix_timestamp() ) );
INSERT INTO USER (acronym, name, salt) VALUES ('chosenone', 'Tage Jönnson', (ASCII('chosenone') * unix_timestamp() ) );
INSERT INTO USER (acronym, name, salt) VALUES ('keysersöze', 'Evert Jönåker', (ASCII('keysersöze') * unix_timestamp() ) );
INSERT INTO USER (acronym, name, salt) VALUES ('legend', 'Barbro Spjut', (ASCII('legend') * unix_timestamp() ) );
INSERT INTO USER (acronym, name, salt) VALUES ('hero', 'Birgitta Krook', (ASCII('hero') * unix_timestamp() ) );

UPDATE USER SET password = sha2(concat('bajenbrud', salt), 224) WHERE acronym = 'bajenbrud';
UPDATE USER SET password = sha2(concat('chosenone', salt), 224) WHERE acronym = 'chosenone';
UPDATE USER SET password = sha2(concat('keysersöze', salt), 224) WHERE acronym = 'keysersöze';
UPDATE USER SET password = sha2(concat('legend', salt), 224) WHERE acronym = 'legend';
UPDATE USER SET password = sha2(concat('hero', salt), 224) WHERE acronym = 'hero';

SELECT * FROM user;

#SELECT acronym, name FROM USER WHERE acronym = ? AND password = sha2(concat(?, salt),  224);

#T.ex:
#SELECT acronym, name FROM USER WHERE acronym = 'legend' AND password = sha2(concat('legend', salt),  224);