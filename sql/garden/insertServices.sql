--
-- Setup for the article:
-- https://dbwebb.se/kunskap/lagra-innehall-i-databas-for-webbsidor-och-bloggposter-v2
--

--
-- Create the database with a testuser
--
-- CREATE DATABASE IF NOT EXISTS oophp;
-- GRANT ALL ON oophp.* TO user@localhost IDENTIFIED BY "pass";
-- USE oophp;

-- Ensure UTF8 as chacrter encoding within connection.
SET NAMES utf8;

DELETE FROM `services`;
INSERT INTO `services` (`title`, `image`, `price`, `description`, `filter`) VALUES
    ('Gräsklippning', 'services/grass.jpg', 399, 'Klippning av gräsmattan och trimning av kanterna om så önskas. Jag kommer med egen gräsklippare och trimmer.',"markdown"),
    ('Trädbeskärning', 'services/trees.jpg', 499, 'På våren beskär jag äppelträd och i juli-september andra träd. Jag tar med egna verktyg.',"markdown"),
    ('Ogräsrensning', 'services/weed.jpg', 399, 'Jag rensar bort ogräs i rabatter, trädgårdsland, vid plattor etc.',"markdown"),
    ('Planteringar', 'services/plant.jpg', 399, 'Planteringar av krukor, rabatter och häckar. Kostnad för krukor, dekorationer, plantor och jord tillkommer.',"markdown"),
    ('Häckklippning', 'services/hedge.jpg', 499, 'Jag klipper din häck till en fin form med egna verktyg.',"markdown"),
    ('Altantvätt', 'services/deck.jpg', 499, 'Ser din altan ut som denna? Jag lägger på mossmedel och högtryckstvättar din altan. Jag tar med eget miljövänligt mossmedel och högtryckstvätt.',"markdown"),
    ('Trädgårdskötsel', 'services/generic.jpg', 399, 'Vad behöver du hjälp med? Allmän trädgårdsskötsel kan vara vattning, vårstädning, fixa gräsmattan etc.',"markdown")
;

SELECT * FROM `services`;
