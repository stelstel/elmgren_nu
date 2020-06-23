DROP TABLE IF EXISTS `content`;

CREATE TABLE `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` char(80) CHARACTER SET utf8 DEFAULT NULL,
  `url` char(80) CHARACTER SET utf8 DEFAULT NULL,
  `TYPE` char(80) CHARACTER SET utf8 DEFAULT NULL,
  `title` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `DATA` text CHARACTER SET utf8,
  `FILTER` char(80) CHARACTER SET utf8 DEFAULT NULL,
  `published` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

/*
-- Query: SELECT * FROM stel14.content
LIMIT 0, 1000

-- Date: 2014-11-14 18:35
*/
TRUNCATE TABLE `content`;

INSERT INTO `content` (`id`,`slug`,`url`,`TYPE`,`title`,`DATA`,`FILTER`,`published`,`created`,`updated`,`deleted`) 
VALUES (1,'hem','hem','page','Hem','Detta är min hemsida. Den är skriven i [url=http://en.wikipedia.org/wiki/BBCode]bbcode[/url] vilket innebär att man kan formattera texten till [b]bold[/b] och [i]kursiv stil[/i] samt hantera länkar.\n\nDessutom finns ett filter \'nl2br\' som lägger in <br>-element istället för \n, det är smidigt, man kan skriva texten precis som man tänker sig att den skall visas, med radbrytningar.','bbcode,nl2br','2014-11-06 22:07:39','2014-11-06 22:07:39',NULL,NULL);

INSERT INTO `content` (`id`,`slug`,`url`,`TYPE`,`title`,`DATA`,`FILTER`,`published`,`created`,`updated`,`deleted`) 
VALUES (2,'om','om','page','Om','Detta är en sida om mig och min webbplats. Den är skriven i [Markdown](http://en.wikipedia.org/wiki/Markdown). Markdown innebär att du får bra kontroll över innehållet i din sida, du kan formattera och sätta rubriker, men du behöver inte bry dig om HTML.\n\nRubrik nivå 2\n-------------\n\nDu skriver enkla styrtecken för att formattera texten som **fetstil** och *kursiv*. Det finns ett speciellt sätt att länka, skapa tabeller och så vidare.\n\n###Rubrik nivå 3\n\nNär man skriver i markdown så blir det läsbart även som textfil och det är lite av tanken med markdown.','markdown','2014-11-06 22:07:39','2014-11-06 22:07:39',NULL,NULL);

INSERT INTO `content` (`id`,`slug`,`url`,`TYPE`,`title`,`DATA`,`FILTER`,`published`,`created`,`updated`,`deleted`) 
VALUES (3,'blogpost-1',NULL,'post','Välkommen till min blogg!','Detta är en bloggpost.\n\nNär det finns länkar till andra webbplatser så kommer de länkarna att bli klickbara.\n\nhttp://dbwebb.se är ett exempel på en länk som blir klickbar.','link,nl2br','2014-11-06 22:07:39','2014-11-06 22:07:39',NULL,NULL);

INSERT INTO `content` (`id`,`slug`,`url`,`TYPE`,`title`,`DATA`,`FILTER`,`published`,`created`,`updated`,`deleted`) 
VALUES (4,'blogpost-2',NULL,'post','Nu har sommaren kommit','Detta är en bloggpost som berättar att sommaren har kommit, ett budskap som kräver en bloggpost.','nl2br','2014-11-06 22:07:39','2014-11-06 22:07:39',NULL,NULL);

INSERT INTO `content` (`id`,`slug`,`url`,`TYPE`,`title`,`DATA`,`FILTER`,`published`,`created`,`updated`,`deleted`) 
VALUES (5,'blogpost-3',NULL,'post','Nu har hösten kommit','Detta är en bloggpost som berättar att sommaren har kommit, ett budskap som kräver en bloggpost','nl2br','2014-11-06 22:07:39','2014-11-06 22:07:39',NULL,NULL);

INSERT INTO `content` (`id`,`slug`,`url`,`TYPE`,`title`,`DATA`,`FILTER`,`published`,`created`,`updated`,`deleted`) 
VALUES (6,'blogpost-4',NULL,'post','Stefan bloggar','Jag har så mycket intressant att berätta så att jag tänkte att jag gör ett blogginlägg. Jag har så mycket intressant att berätta så att jag tänkte att jag gör ett blogginlägg. Jag har så mycket intressant att berätta så att jag tänkte att jag gör ett blogginlägg. Jag har så mycket intressant att berätta så att jag tänkte att jag gör ett blogginlägg.',NULL,'2014-11-08 23:22:15','2014-11-08 23:22:14',NULL,NULL);

INSERT INTO `content` (`id`,`slug`,`url`,`TYPE`,`title`,`DATA`,`FILTER`,`published`,`created`,`updated`,`deleted`) 
VALUES (7,'blogpost-5',NULL,'post','Få bort ALLT smink från ansiktet med skinsonic ansiktsborste','Det bästa med att vara bloggerska är att jag alltid får chansen att testa det senaste inom skönhet först :) Nu har jag fått hem en ny produkt, “skinsonic ansiktsborste“. Det är en elektronisk ansiktsborste som är framtagen för att få maximal rengöring när man tvättar ansiktet.\r\n\r\nSom jag nämnde förut har jag ju insett att jag inte får bort 100 % av allt mitt smink när jag går och lägger mig, det kan ju leda till finnar när man vaknar upp dagen efter.. Så att få extra hjälp när det kommer till rengöring är alltid välkommen. Denna sägs rengöra 6 gånger mer än när man tvättar med händerna… Jag har ju slutat tvätta ansiktet med endast händerna sen jag insåg \r\n\r\nJust nu använder jag ju en ansiktssvamp som jag skrev för ett tag sedan, men jag ska byta till denna för det känns som att den här kommer få bort ännu mer smink från ansiktet. Dessutom peelar ju den här borsten ansiktet = man får bort död hud.\r\n\r\nDenna kostar 599 kr vilket jag tycker är ett bra pris då jag har sett andra såna här produkter som kostar över 1500.. Och uppger ni koden “skin20″ får ni dessutom 20 % rabatt på erat köp :) Jag är noga med att alltid fixa rabatt-koder till er ifall jag ska skriva om skönhetsprodukter som ni säkert märkt (och förhoppningsvis uppskattar?). Perfekt att ge i julklapp också, för hallå.. Det är jul snart!? *Panik*',NULL,'2014-11-14 18:14:32','2014-11-14 18:14:32',NULL,NULL);