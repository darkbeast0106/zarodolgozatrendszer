-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1:3306
-- Létrehozás ideje: 2018. Feb 23. 07:38
-- Kiszolgáló verziója: 5.7.19
-- PHP verzió: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `szakdolgozat`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `diakok`
--

DROP TABLE IF EXISTS `diakok`;
CREATE TABLE IF NOT EXISTS `diakok` (
  `diak_felh_id` bigint(11) NOT NULL,
  `diak_vnev` varchar(45) NOT NULL,
  `diak_knev` varchar(45) NOT NULL,
  `diak_knev2` varchar(45) DEFAULT NULL,
  `diak_oszt_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`diak_felh_id`),
  KEY `diak_osztaly_idx` (`diak_oszt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalok`
--

DROP TABLE IF EXISTS `felhasznalok`;
CREATE TABLE IF NOT EXISTS `felhasznalok` (
  `felhasznalo_id` bigint(11) NOT NULL,
  `felhasznalo_nev` varchar(45) NOT NULL,
  `felhasznalo_jelszo` char(32) NOT NULL,
  `felhasznalo_email` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`felhasznalo_id`),
  UNIQUE KEY `felhasznalo_nev` (`felhasznalo_nev`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `hataridok`
--

DROP TABLE IF EXISTS `hataridok`;
CREATE TABLE IF NOT EXISTS `hataridok` (
  `hatarido_id` int(11) NOT NULL AUTO_INCREMENT,
  `hatarido_megnevezes` enum('kihirdetes','jelentkezes','vegleges_elfogadas','elso_bemutatas','masodik_bemutatas','harmadik_bemutatas','beadas') NOT NULL,
  `hataridok_ertek` date DEFAULT NULL,
  PRIMARY KEY (`hatarido_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `hataridok`
--

INSERT INTO `hataridok` (`hatarido_id`, `hatarido_megnevezes`, `hataridok_ertek`) VALUES
(1, 'kihirdetes', NULL),
(2, 'jelentkezes', NULL),
(3, 'vegleges_elfogadas', NULL),
(4, 'elso_bemutatas', NULL),
(5, 'masodik_bemutatas', NULL),
(6, 'harmadik_bemutatas', NULL),
(7, 'beadas', NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `jogosultsag`
--

DROP TABLE IF EXISTS `jogosultsag`;
CREATE TABLE IF NOT EXISTS `jogosultsag` (
  `jogosultsag_id` int(11) NOT NULL,
  `jogosultsag_nev` varchar(128) NOT NULL,
  `konzulens` tinyint(4) NOT NULL,
  `osztalyfonok` tinyint(4) NOT NULL,
  `vezetoseg` tinyint(4) NOT NULL,
  `koordinator` tinyint(4) NOT NULL,
  PRIMARY KEY (`jogosultsag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `jogosultsag`
--

INSERT INTO `jogosultsag` (`jogosultsag_id`, `jogosultsag_nev`, `konzulens`, `osztalyfonok`, `vezetoseg`, `koordinator`) VALUES
(0, 'Tanár', 0, 0, 0, 0),
(1, 'Konzulens', 1, 0, 0, 0),
(2, 'Osztályfőnök', 0, 1, 0, 0),
(3, 'Osztályfőnök, Konzulens', 1, 1, 0, 0),
(4, 'Vezetőség tagja', 0, 0, 1, 0),
(5, 'Vezetőség tagja, Konzulens', 1, 0, 1, 0),
(6, 'Vezetőség tagja, Osztályfőnök', 0, 1, 1, 0),
(7, 'Vezetőség tagja, Osztályfőnök, Konzulens', 1, 1, 1, 0),
(8, 'Koordinátor', 0, 0, 0, 1),
(9, 'Koordinátor, Konzulens', 1, 0, 0, 1),
(10, 'Koordinátor, Osztályfőnök', 0, 1, 0, 1),
(11, 'Koordinátor, Osztályfőnök, Konzulens', 1, 1, 0, 1),
(12, 'Koordinátor, Vezetőség tagja', 0, 0, 1, 1),
(13, 'Koordinátor, Vezetőség tagja, Konzulens', 1, 0, 1, 1),
(14, 'Koordinátor, Vezetőség tagja, Osztályfőnök', 0, 1, 1, 1),
(15, 'Koordinátor, Vezetőség tagja, Osztályfőnök, Konzulens', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `osztalyok`
--

DROP TABLE IF EXISTS `osztalyok`;
CREATE TABLE IF NOT EXISTS `osztalyok` (
  `osztaly_id` int(11) NOT NULL AUTO_INCREMENT,
  `osztaly_nev` varchar(8) NOT NULL,
  `osztalyfonok_id` bigint(11) DEFAULT NULL,
  `vegzes_eve` year(4) NOT NULL,
  PRIMARY KEY (`osztaly_id`),
  KEY `osztaly_of_idx` (`osztalyfonok_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tanarok`
--

DROP TABLE IF EXISTS `tanarok`;
CREATE TABLE IF NOT EXISTS `tanarok` (
  `tanar_felh_id` bigint(11) NOT NULL,
  `tanar_vnev` varchar(45) NOT NULL,
  `tanar_knev` varchar(45) NOT NULL,
  `tanar_knev2` varchar(45) DEFAULT NULL,
  `tanar_ferohely` int(2) UNSIGNED DEFAULT NULL,
  `tanar_jogosultsag_id` int(11) NOT NULL,
  PRIMARY KEY (`tanar_felh_id`),
  KEY `tanar_jog_idx` (`tanar_jogosultsag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `temak`
--

DROP TABLE IF EXISTS `temak`;
CREATE TABLE IF NOT EXISTS `temak` (
  `tema_id` int(11) NOT NULL AUTO_INCREMENT,
  `kiiro_id` bigint(11) NOT NULL,
  `tema_cim` varchar(128) NOT NULL,
  `tema_leiras` text,
  `tema_eszkozok` text,
  `tema_evszam` year(4) NOT NULL,
  PRIMARY KEY (`tema_id`),
  KEY `tema_kiiro_idx` (`kiiro_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `valasztott`
--

DROP TABLE IF EXISTS `valasztott`;
CREATE TABLE IF NOT EXISTS `valasztott` (
  `valasztott_id` int(11) NOT NULL AUTO_INCREMENT,
  `valaszto_diak_id` bigint(11) NOT NULL,
  `konzulens_id` bigint(11) DEFAULT NULL,
  `valasztott_tema_id` int(11) DEFAULT NULL,
  `valasztott_cim` varchar(128) NOT NULL,
  `valasztott_link` varchar(256) NOT NULL,
  `valasztott_status` enum('elutasitva','elfogadasra_var','felt_elfogadva','vegleg_elfogadva','1_bemutatva','2_bemutatva','3_bemutatva','leadva') CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL DEFAULT 'elfogadasra_var',
  `program_allapot` int(3) UNSIGNED NOT NULL DEFAULT '0',
  `dokumentacio_allapot` int(3) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`valasztott_id`),
  KEY `valasztott_diak_idx` (`valaszto_diak_id`),
  KEY `valasztott_konzulens_idx` (`konzulens_id`),
  KEY `valasztott_tema_idx` (`valasztott_tema_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `diakok`
--
ALTER TABLE `diakok`
  ADD CONSTRAINT `diak_felh` FOREIGN KEY (`diak_felh_id`) REFERENCES `felhasznalok` (`felhasznalo_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `diak_osztaly` FOREIGN KEY (`diak_oszt_id`) REFERENCES `osztalyok` (`osztaly_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Megkötések a táblához `osztalyok`
--
ALTER TABLE `osztalyok`
  ADD CONSTRAINT `osztaly_of` FOREIGN KEY (`osztalyfonok_id`) REFERENCES `tanarok` (`tanar_felh_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Megkötések a táblához `tanarok`
--
ALTER TABLE `tanarok`
  ADD CONSTRAINT `tanar_felh` FOREIGN KEY (`tanar_felh_id`) REFERENCES `felhasznalok` (`felhasznalo_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tanar_jog` FOREIGN KEY (`tanar_jogosultsag_id`) REFERENCES `jogosultsag` (`jogosultsag_id`) ON UPDATE CASCADE;

--
-- Megkötések a táblához `temak`
--
ALTER TABLE `temak`
  ADD CONSTRAINT `tema_kiiro` FOREIGN KEY (`kiiro_id`) REFERENCES `tanarok` (`tanar_felh_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `valasztott`
--
ALTER TABLE `valasztott`
  ADD CONSTRAINT `valasztott_diak` FOREIGN KEY (`valaszto_diak_id`) REFERENCES `diakok` (`diak_felh_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `valasztott_konzulens` FOREIGN KEY (`konzulens_id`) REFERENCES `tanarok` (`tanar_felh_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `valasztott_tema` FOREIGN KEY (`valasztott_tema_id`) REFERENCES `temak` (`tema_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
