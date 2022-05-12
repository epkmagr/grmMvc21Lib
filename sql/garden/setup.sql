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


--
-- Create table for garden
--
DROP TABLE IF EXISTS `garden`;
CREATE TABLE `garden`
(
  `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `path` CHAR(120) UNIQUE,
  `slug` CHAR(120) UNIQUE,

  `title` VARCHAR(120),
  `data` TEXT,
  `type` CHAR(20),
  `filter` VARCHAR(80) DEFAULT NULL,

  -- MySQL version 5.6 and higher
  `published` DATETIME  DEFAULT CURRENT_TIMESTAMP,
  `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

  -- MySQL version 5.5 and lower
  -- `published` DATETIME DEFAULT NULL,
  -- `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  -- `updated` DATETIME DEFAULT NULL, --  ON UPDATE CURRENT_TIMESTAMP,

  `deleted` DATETIME DEFAULT NULL
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

INSERT INTO `garden` (`path`, `slug`, `type`, `title`, `data`, `filter`, `published`) VALUES
    ("index", null, "page", "Välkommen till Maries Trädgårdsservice", "
![Trädgårdsredskap](../image/services/generic.jpg?w=250#toLeft)
Maries Trädgårdsservice är ett nystartad företag som hjälper dig med din trädgård.
Jag erbjuder tjänster som gräsklippning, trädbeskärning, ogräsrensning, planteringar
häckklippning, altantvätt och allmän trädgårdskötsel. Läs mer om mina
[Tjänster](../garden1/showServiceOverview).

Du kan även läsa min [Blogg](../content1/showBlogOverview).

Du måste vara inloggad för att kunna läsa på sidan. Logga in [här](../admin/login)!", "markdown",
"2020-05-19 09:43:01"),
    ("hem", null, "page", "Hemsida till Maries Trädgårdsservice", "Detta är
hemsida till Maries Trädgårdsservice.

![Trädgårdsredskap](../../image/services/generic.jpg?w=250#toLeft)
Jag erbjuder tjänster som gräsklippning, trädbeskärning, ogräsrensning, planteringar
häckklippning, altantvätt och allmän trädgårdskötsel. Läs mer om mina
[Tjänster](../../garden1/showServiceOverview).

Du kan även läsa min [Blogg](../../content1/showBlogOverview).

Du måste vara inloggad för att kunna läsa på sidan. Logga in [här](../../admin/login)!", "markdown",
"2020-05-09 09:43:01"),
    ("om", null, "page", "Om Maries Trädgårdsservice", "Maries Trädgårdsservice
startades våren 2020 som ett projektarbete på kursen Oophp på BTH. Webplatsen
utvecklades av Marie Grahn.

Maries Trädgårdsservice erbjuder tjänster inom trädgården, så som gräsklippning,
plantering och allmän trädgårdsskötsel.

### Maries Trädgårdsservice

Nu har jag utbildat mig till trädgårdsmästare och tänker satsa fullt ut på mitt nya
företag *Maries Trädgårdsservice*.

##### Trädgårdsservice

Jag erbjuder [tjänster](../../garden1/showServiceOverview) som gräsklippning, trädbeskärning, ogräsrensning, planteringar
häckklippning, altantvätt och allmän trädgårdskötsel. Jag tar med mig egna verktyg.
Det är viktigt för mig att vara så miljövänlig som möjligt.

##### Blogg
Jag driver också en [blogg](../../content1/showBlogOverview), som du välkommen att läsa.

### Om mig

![Marie](../../image/me.jpg?w=200&area=2,20,30,15#toRight)
Mitt namn är Marie Grahn, född och uppvuxen i Karlskrona. Efter 4-årig teknisk
linje med inriktning på telekommunikation på gymnasiet, så pluggade jag till
civilingenjör inom Datateknik på LTH i Lund. Jag har jobbat som systemansvarig på
Astra Draco i Lund och C++ utvecklare på Telia Research i Malmö innan jag flyttade
till Karlskrona och började jobba på Ericsson. Där jobbade jag med testning,
projektledning och Javautveckling till sommaren 2018. Då bestämde jag mig för att
lära mig nya saker och det bästa sättet var att börja studera igen. På distans har
jag pluggat Maskininlärning, Säkerhetskritisk mjukvara, Certifiering av säkerhetskritisk
mjukvara och webbprogrammering på BTH.

Jag bor i Karlskrona tillsammans med min man. Barnen, en son på 23 år och en dotter
på 20 år, är utflyttade och pluggar i Linköping. Jag gillar att dricka ett gott glas
vin och gärna ta en bit mörk choklad till. Mitt största intresse numera är
veteranfriidrott. Favoritgrenar numera är längd, kula och slägga.
", "markdown", "2020-05-08 09:43:01"),
    ("doc", null, "page", "Dokumentation om Maries Trädgårdsservice", "
Det här är en kortfattad dokumentation om webbplatsen *Maries Trädgårdsservice*.
Den beskriver kodstrukturen, administrativa gränssnittet, databasen och testning.

### Kodstruktur

Jag har delat upp det i följande:

+ Admin, administration, som innehåller en AdminController och en hjälpklass för databaskommunikationen.
+ Content, CMS (sidor & blogginlägg), som innehåller en ContentController och en hjälpklass för databaskommunikationen.
+ Garden, tjänsterna, som innehåller en GardenController och en hjälpklass för databaskommunikationen.
+ MyTextFilter, som innehåller ett textfilter som kan parsa texter.

#### Klassdiagram

![Klassdiagram](../../image/classDiagram.png?w=800)

Klassdiagrammet är skapat i *drawio*.

#### Admin

Admin är mitt adminstrativa gränssnitt där du kan uppdatera CMS med sidor och blogginlägg,
uppdatera tjänsterna och återställa databasen. Admin har sina vyer under *view/admin* och
de användarspecifika vyerna finns under *view/user*.
I *AdminController* finns actions som hanterar användaradministration, som in- och utloggning,
registrera användare och uppdatera användaren. I admingränssnittet så visas allt
innehåll paginerat och du kan sortera på de flesta kolumnerna. Det finns också en
sökfunktion för att lättare hitta.

Supportklassen, *AdminDbHelper*, hjälper till med kommunikationen med databasen och tabellen med användarna, users.

#### Content

Content är mitt CMS med sidor och blogginlägg. Content har sina vyer under *view/content1*. I *ContentController* finns actions som visar en sida, som t ex omsidan, och visar en översikt av blogginläggen samt visar ett blogginlägg. Det finns dessutom stöd för att skapa ny sida eller blogginlägg, uppdatera och ta bort.
ContentControllern visar också första sidan.

Supportklassen, *ContentDbHelper*, hjälper till med kommunikationen med databasen och tabellen med innehållet i contentdatabasen, garden.

#### Garden

Garden är tjänsterna som erbjuds. Garden har sina vyer under *view/garden1*. I *GardenController* finns actions som visar tjänsterna som lista eller översikt och så kan man titta på en tjänst mer i detalj. Det finns dessutom stöd för att skapa ny tjänst, uppdatera och ta bort.

Supportklassen, *GardenDbHelper*, hjälper till med kommunikationen med databasen och tabellen med tjänster.

#### MyTextFilter

En klass som innehåller textfilter för att parsa text. Klassen innehåller
följande filter:

+ *bbcode*, för att göra om bbcode till html
+ *link*, för att göra länkar i en text klickbara
+ *markdown*, för att göra om till markdown
+ *nl2br*, för att lägga till htmlradbrytning före alla \"newlines\"
+ *ecs*, för att göra om alla tecken till \"htmlentities\"
+ *strip_tags*, för att ta bort html- och phptaggar

Eftersom det enligt kraven är standard att sidor, tjänster och blogginlägg ska skrivas i markdown så är det en förvald inställning.

#### Vyer

Vyerna ligger under view och är uppdelade så här:

+ *admin*, här ligger vyer specifika för det administrativa gränssnittet och navigationsbarer
för CMS och tjänsterna.
+ *content1*, här ligger vyer specifika för CMS och används mest av ContentController. Layouten av första sidan ligger också här.
+ *garden1*, här ligger vyer specifika för tjänsterna och används mest av GardenController.
+ *support*, här ligger blandade vyer; en debug för att visa SESSION, POST och GETvariabler, header till CMS- och tjänsteadministration samt flashbild. Används av både GardenController och ContentController.
+ *user*, här ligger vyer specifika för användaradministration, t ex login, och används av ContentController.

#### Hjälp och support

Jag har en fil *function.php* som innehåller hjälpfuktioner som främst hjälper vyerna att presentera informationen och beharbeta informationen innan den presenteras.

### Administrativa gränssnitt

Det är endast administrativa användare som kan använda det administrativa gränssnittet.
Som adminstrativ användare kan du skapa nytt, ta bort och uppdatera. Du kan även
göra andra användare till admininstrativa användare samt aktivera borttagna användare igen.

Det administrativa gränssnittet erbjuder följande tjänster:

+ Bloggen, ett CMS för att administrera sidor och blogginlägg
+ Tjänster, där trädgårdstjänsterna administreras
+ Användare, där användare administreras
+ Återställ databasen

I rubrikerna finns det pilar, upp och ner, med vilka sorteringsordningen kan ändras.
Dessutom finns det möjlighet att välja antalet per sida, s.k. pagingering. Det
finns även en sökmöjlighet, där söksträngen anges utan wildcards. Jag valde att söka
ganska brett i databasen i de flesta kolumner.

Endast administrativa användare kan kopiera in bilder till användare i katalogen
*img/users*, till tjänsterna i katalogen *img/services* och till bloggen i katalogen
*img/blogg*. Ett förbättringsförslag är en uppladdningsmöjlighet istället.

### Registrera användare

En besökare måste registera sig för att kunna titta runt på webbplatsen.
Vem som helst kan registera sig som användare. Om du är registerad på Gravatar (med bild)
så anger du den mailadressen du har registrerad där, för då kommer din bild upp
automatiskt. Är du inte registrerad där så kan du ange en bild adress istället.

### Testning

Målet är en hög testtäckning, över 95%. Jag har en testklass per klass och använder phpunit.
#### Bild över testtäckningen
![Bild på testtäckning](../../image/coverage.png?w=900#toLeft)

### Databasen

Databasen innehåller följande tabeller:

+ *garden*, som innehåller mitt CMS med alla sidor och blogginlägg. En sida eller ett blogginlägg är beskriven av id, path, slug (görs av namnet om inget anges), titel, data (texten), typ (sida/page eller blogginlägg/post), filter (standard är markdown) samt datum när den skapades, uppdaterades och togs bort.
+ *services*, som innehåller alla tjänster. En tjänst är beskriven av id, titel, bild (standardbild om ingen anges), pris, beskrivning, filter (standard är markdown) samt datum när den skapades, uppdaterades och togs bort.
+ *users*, som innehåller användarna. En användare beskrivs av id, användarnamn, lösenord, för- och efternamn, emailadress, nummer, om den är aktiv samt om den är admin eller inte.

Borttagna sidor, blogginlägg och tjänster markeras som *deleted* och visas då bara i *Admin*, det admininstrativa gränssnittet som bara admin användare kan nå.

#### ER-diagram
![ER-diagram](../../image/er.png?w=700#toLeft)", "markdown", "2020-05-16 09:43:01"),
    ("blogpost-1", "beskarning-av-appeltrad", "post", "Beskärning av äppelträd", "
![Äppelträd](../../image/blogg/appleLate.jpg?h=150&area=20,50,60,15#toRight)
Finns det något vackrare än blommande äppelträd? Sagolikt!
Vill du ha  hjälp med beskärning av din fruktträd? Vill du ha ett nytt fruktträd
planterat? Hör gärna av dig till mig.

<!--more-->

![Äppelträd](../../image/blogg/appleLate.jpg?w=350#toLeftt)
Äppelträdet kan bli mellan 5 och 12 meter högt och tillhör familjen rosväxter.
De blommar vacker mellan april och juni, där tiden beror sorten och klimatet.

Beskärning av äppelträd görs med fördel tidigt på våren eller juli till augusti.Beskärningen av äppelträd är viktigast de första åren, då det beskärs kraftigt.
Äldre äppelträd får mer underhållsbeskärning.

Använd en vass och ren sekatör eller grensåg när du beskär. Klipp bort grenar som växer inåt kronan för att få luft i kronan.

![Äppelträd](../../image/blogg/appleEarly.jpg?w=350#toRight)

Läs mer om beskärning av äppelträd på [Wikipedia](https://sv.wikipedia.org/wiki/%C3%84ppeltr%C3%A4d).

Dett är en bild på ett redan färdigblommat äppelträd. Det är en från en tidig sort
som ger äpplen i slutet av augusti eller början av september.
", "markdown", "2020-05-09 12:03:01"),
    ("blogpost-2", "ett-blatt-hav", "post", "Ett blått hav", "![Scilla](../../image/blogg/scillaCloseup.jpg?h=150#toLeft)
Vilket underbart blått hav Scilla ger oss! Den har ett oerhört vackert namn på svenska, Blåstjärna. Det är en sparrisväxt....
<!--more-->
Scilla är en trädgårdsväxt i Sverige men växer naturligt i södra Europa, Mellanöstern
och Afrika. Vill du också ha fina trädgårdsväxter, så hör av dig så planterar jag
några hos dig.
Bilden nedan visar en Vårstjärna, som har en uppåtvänd blomma som är vit i mitten.
Den ryska blåstjärnan är helblå med en nedåthängande blomma.
Läs mer om Scilla på [Wikipedia](https://sv.wikipedia.org/wiki/Bl%C3%A5stj%C3%A4rnesl%C3%A4ktet).
[Scilla](../../image/blogg/scilla.jpg?w=350#toRight)
", "markdown", "2020-03-03 12:43:01"),
    ("blogpost-3", "tusenskona", "post", "Tusensköna", "
![Daisy](../../image/blogg/daisyCloseup.jpg?h=150&area=55,15,0,35&sharpen#toLeft)
Tusenskönan är en söt liten blomma med vita blomblad som växer i våra gräsmattor. Den går faktiskt att äta...

<!--more-->

Ja, tusenskönan går att äta. På våren blommorna fräscha och bladen späda och då
smakar de gott i till exempel en sallad. Enligt gammal folktro skulle man äta upp
de tre första tusenskönorna man såg på våren. Då var man nämligen skyddad mot
tandvärk resten av året!
![Daisy](../../image/blogg/daisyCloseup.jpg?w=250#toRight)
Tusensköna är så söt där den står i gräsmattan. Den heter *Bellis perennis*
på latin och tillhör familjen korgblommiga växter. Den blommar rikligt på
försommaren men blommar lite hela sommaren.
Läs mer om Tusensköna på [Wikipedia](https://sv.wikipedia.org/wiki/Tusensk%C3%B6na).

Puttikor
-----------------------------------

![Daisy](../../image/blogg/daisy.jpg?w=350#toLeft)
Min mormor gillade Tusenskönorna och kallade dem Puttikor. Kanske för att de var så små.
När jag var liten plockade jag gärna Puttikor till min mormor.", "markdown",
"2020-05-15 11:43:01"),
    ("blogpost-4", "vack-med-gamla-grenar", "post", "Väck med gamla grenar!", "![Pile of spruce](../../image/blogg/pile.jpg?h=150#toLeft)
En stor gammal gran blev rensad på sina torra döda grenar. Vilken stor hög det blev!
Det luktar gott när man sågar i gran men kodan är inte att leka med.

<!--more-->

![Spruce](../../image/blogg/spruce.jpg?w=350&aro#toRight)
Granen tillhör familjen tallväxter och är ett av cirka 35 arter av barrträd i gransläktet.
Den kan bli 200 år gammal och får sina kottar i 30-40 års ålder. De mest kända
gransorterna är kungsgran och vanlig rödgran som vi använder som julgranar.

Detta är en Kungsgran som är lite drygt 20 år och jättehög. Den hade blivit skräpig
nertill och då är det snyggt är rensa bort de döda grenarna. Det ger ett städat
intryck. Om du vill att jag ska hjälpa dig att ta bort döda grenar från dina träd,
så får du gärna höra av dig.", "markdown", "2020-05-12 15:43:01"),
("blogpost-5", "blabarstry", "post", "Blåbärstry", "Blåbärstry är en utmärkt häckplanta med ätliga bär.
![Honeysuckle](../../image/blogg/honeysuckleCloseup.jpg?h=150#toRight)
Vill du också ha en häck med ätbara bär? Eller du kanske vill ha en annan sorts
häck? Eller bärbuskar planterade? Hör av dig, så löser jag det.

<!--more-->
![Honeysuckle](../../image/blogg/honeysucklePlants.jpg?w=350#toLeft)
Blåbärstry är superbäret som alla vill odla. Det är en lättodlad och härdig
bärbuske som även är en fin häckväxt.

Blåbärstry är härdig ända upp till zon 6(7)
medan amerikanska blåbär inte är härdiga längre än 3-4(5). Humlor och andra
tidiga pollinerare har mycket nytta av Blåbärstry eftersom att blommorna kommer
tidigt och klarar frost bra.

För att det ska bli bär så måste du plantera olika sorter av Blåbärstry.
![Honeysuckle](../../image/blogg/honeysuckleHedge.jpg?w=350#toRight)

Du måste ta bort vedartade och torkade gamla grenar för att din Blåbärstrybuske
eller häck ska se snygg ut. Här har jag hjälpt en kund med det.

Hör av dig om du vill att jag ska fixa din Blåbärstryhäck med!

Läs mer sorten [Blue Velvet](https://www.blomsterlandet.se/tips-rad/vaxtinformation/tradgard/prydnadsbuskar/ovriga-prydnadsbuskar/blabarstry2/) här.
", "markdown",
"2020-05-17 14:03:01"),
("blogpost-6", "fore-och-efter", "post", "Före och efter", "![Ogräs vid plattor](../../image/blogg/weedWork.jpg?h=150#toLeft)
Ogräs är jobbigt att hålla efter men belöningen när det försvinner är värt så mycket.
Se här på ogräsrensningen vid plattorna. Det gäller också att hålla efter vissa växter som bambu....
<!--more-->
bambu
--------------
![Bambu vid staket](../../image/blogg/bambuFence.jpg?w=350#toRight)
Bambu är ett samlingsnamn på en grupp gräs som växer främst i tropiska områden i
Amerika och Asien men även i våra trädgårdar. Bambun kännetecknas av att dess blad
har bladskaft till skillnad från andra gräs som saknar dessa.Den är snabbväxande och
behöver hållas efter! Det kan jag hjälpa dig med.
[Bamburot](../../image/blogg/bambuRoot.jpg?w=350#toLeft)
Rötterna behöver grävas upp och hållas efter om du inte vill att den ska sprida sig
över hela trädgården och in till grannarna. Så här ser det ut hos en kund som har
problem med att grannens bambu växer in på tomten.
![BambuDiff](../../image/blogg/bambuDiff.jpg?w=350#toLeft)
Men det ska nog bli bra när det är klart! Det är ett tungt jobb och jag har många
timmar kvar innan jag är klar.
Läs mer om Bambu på [Wikipedia](https://sv.wikipedia.org/wiki/Bambu).

Lavendel
---------
Dessa vackra växter med skira blommor som luktar så gott. Här är jag hos en kund
som har Lavendel i rabatten men i före bilden så ser man inte ens den då bladen
till vårväxterna som blommat klart ännu inte vissnat ner. Då hjälper jag naturen
lite på traven och klipper bort vårblommornas blad och stjälkar. Och då ser man
Lavendeln.
![Lavendel före och efter](../../image/blogg/lavender.jpg?w=700#toLeft)

", "markdown", "2020-04-06 14:43:01");

SELECT `id`, `path`, `slug`, `type`, `title`, `created` FROM `garden`;

--
-- Create table for my garden services
--
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services`
(
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `title` VARCHAR(100) UNIQUE,
    `image` VARCHAR(100) DEFAULT NULL,    -- Link to an image
    `price` INT,
    `description` TEXT,
    `filter` VARCHAR(80) DEFAULT NULL,

    -- MySQL version 5.6 and higher
    `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    -- MySQL version 5.5 and lower
    -- `published` DATETIME DEFAULT NULL,
    -- `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- `updated` DATETIME DEFAULT NULL, --  ON UPDATE CURRENT_TIMESTAMP,

    `deleted` DATETIME DEFAULT NULL
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

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

--
-- Create table for users
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`
(
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `user` CHAR(10) UNIQUE,
    `password` CHAR(32),
    `name` CHAR(100),
    `email` VARCHAR(100),
    `number` CHAR(30),
    `image` VARCHAR(100) DEFAULT NULL,    -- Link to an image
    `active` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `admin` BOOLEAN DEFAULT false
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

DELETE FROM `users`;
INSERT INTO `users` (`user`, `name`, `email`, `number`, `image`,`admin`) VALUES
    ('admin', 'Admin Adminsson', 'admin@mariegarden.com', '070-777777', 'users/admin.png', true),
    ('doe', 'John Doe', 'john.doe@hotmail.com', '12345678', 'users/doe.png', false),
    ('mbfs17', 'Marie Grahn', 'mbfs17@student.bth.se', '070-2233445', '', false)
;

UPDATE `users`
SET active = CURRENT_TIMESTAMP,
    `password` = MD5(`user`)
;

SELECT * FROM `users`;
