Webbapplikationen Qisus.
============

Webbutveckling med PHP - Projekt
Andreas Lengqvist - al223bn

#Installation

##Förkrav
Lokal server eller webhotell med PHP och mysql förslagsvis phpMyAdmin.

##MySQL-databas
###Skapa användare
OBS! (Om du sitter på ett webbhotell så kan det vara så att du redan blivit tilldelad en användare och då kan du hoppa över det här steget.)
Skapa en användare i databasen. Byt ut "newuser" och "password mot de uppgifter du vill använda dig av.
```SQL
CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'password';
```
Ge användaren de rättigheter som krävs för att kunna läsa/skriva. Byt ut "newuser" mot användarnamnet i steg 1.
```SQL
GRANT ALL PRIVILEGES ON * . * TO 'newuser'@'localhost';
```
Ladda om rättigheterna på MySQL-serven så de nya läses in.
```SQL
FLUSH PRIVILEGES;
```


###Skapa databas och tabell
Skapa en databas, förslagsvid med utf8. Antingen manuellt via valfri klient eller med följande SQL-sats:
```SQL
CREATE DATABASE IF NOT EXISTS `qisus` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `qisus`;
```
##Tabeller
Skapa en tabell för ett quiz:
```SQL
CREATE TABLE `quiz` (
  `quizId` VARCHAR(255) NOT NULL DEFAULT '',
  `title` VARCHAR(70) NOT NULL DEFAULT '',
  `creator` VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`quizId`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
```
Skapa en tabell för frågor:
```SQL
CREATE TABLE `question` (
  `questionId` VARCHAR(255) NOT NULL DEFAULT '',
  `quizId` VARCHAR(255) NOT NULL DEFAULT '',
  `question` VARCHAR(3000) NOT NULL DEFAULT '',
  `answer` VARCHAR(255) NOT NULL DEFAULT '',
  INDEX (quizId)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
```
Skapa en tabell för spelare:
```SQL
CREATE TABLE `mail` (
  `adressId` VARCHAR(255) NOT NULL DEFAULT '',
  `quizId` VARCHAR(255) NOT NULL DEFAULT '',
  `adress` VARCHAR(3000) NOT NULL DEFAULT '',
  INDEX (quizId)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
```

## Foreing keys
Skapa nu relationen mellan de olika tabellerna genom att trycka dig in på question och mail.
Tryck på "Relation view".
Välj "quizId" som nu borde vara valbart eftersom den har ett index.
Välj därefter i dropdown-listan `databasens namn`.`quiz`.`quizId`

##Ladda upp och konfigurera källkoden.
Gå in i filen config.php (\Projekt Qisus\config.php)
Här finns generella inställningar för applikationen och de 4 inställningarna för databasåtkomst måste redigeras
Ändra raderna för följande kod:
```PHP
const DB_USERNAME = 'newuser';
const DB_PASSWORD = 'password';
const DB_CONNECTION = 'mysql:host=localhost;dbname=qisus';
```
DB_USERNAME är användarnamnet på användaren som skapades tidigare.
DB_PASSWORD är lösenordet till den användaren som skapades tidigare.
DB_CONNECTION är namnet på databasen och vilken host du använder dig av vanligt vis localhost eller '127.0.0.1'.

###Ladda upp filerna / lägg dem i den katalog på webbservern som du önskar köra applikationen från.
