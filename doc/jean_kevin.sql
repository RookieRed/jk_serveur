-- phpMyAdmin SQL Dump
-- version 4.1.14.8
-- http://www.phpmyadmin.net
--
-- Client :  db618325086.db.1and1.com
-- Généré le :  Dim 27 Mars 2016 à 21:04
-- Version du serveur :  5.5.47-0+deb7u1-log
-- Version de PHP :  5.4.45-0+deb7u2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `db618325086`
--

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `chemin` varchar(100) COLLATE utf8_bin NOT NULL,
  `identifiant_jk` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `id_lieu` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`chemin`),
  UNIQUE KEY `ind_image_id_lieu` (`id_lieu`),
  KEY `identifiant_jk` (`identifiant_jk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `image`
--

INSERT INTO `image` (`chemin`, `identifiant_jk`, `id_lieu`) VALUES
('img/avatars/jk1/avatar.jpg', 'jk1', NULL),
('img/avatars/jk1/avatar1.jpg', 'jk1', NULL);

--
-- Déclencheurs `image`
--
DROP TRIGGER IF EXISTS `trg_image_insert`;
DELIMITER //
CREATE TRIGGER `trg_image_insert` BEFORE INSERT ON `image`
 FOR EACH ROW BEGIN

IF NEW.id_lieu IS NULL AND NEW.identifiant_jk IS NULL THEN
	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Une image doit être lié à quelque chose";
END IF;

END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_image_update`;
DELIMITER //
CREATE TRIGGER `trg_image_update` BEFORE UPDATE ON `image`
 FOR EACH ROW BEGIN

IF NEW.id_lieu IS NULL AND NEW.identifiant_jk IS NULL THEN
	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Une image doit être lié à quelque chose";
END IF;

END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `jean_kevin`
--

CREATE TABLE IF NOT EXISTS `jean_kevin` (
  `identifiant` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '',
  `nom` varchar(30) COLLATE utf8_bin NOT NULL,
  `prenom` varchar(20) COLLATE utf8_bin NOT NULL,
  `mail` varchar(75) COLLATE utf8_bin NOT NULL,
  `photo` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `mot_de_passe` varchar(32) COLLATE utf8_bin NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`identifiant`),
  UNIQUE KEY `mail` (`mail`),
  UNIQUE KEY `photo` (`photo`),
  KEY `photo_2` (`photo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `jean_kevin`
--

INSERT INTO `jean_kevin` (`identifiant`, `nom`, `prenom`, `mail`, `photo`, `mot_de_passe`, `actif`) VALUES
('j-k0', 'nom0', 'pren0', 'jk0@mail.cm', NULL, 'pass', 0),
('j-k1', 'nom1', 'pren1', 'jk1@mail.cm', NULL, 'pass', 0),
('j-k2', 'nom2', 'pren2', 'jk2@mail.cm', NULL, 'pass', 0),
('j-k3', 'nom3', 'pren3', 'jk3@mail.cm', NULL, 'pass', 0),
('j-k4', 'nom4', 'pren4', 'jk4@mail.cm', NULL, 'pass', 0),
('j-k5', 'nom5', 'pren5', 'jk5@mail.cm', NULL, 'pass', 0),
('j-k6', 'nom6', 'pren6', 'jk6@mail.cm', NULL, 'pass', 0),
('j-k7', 'nom7', 'pren7', 'jk7@mail.cm', NULL, 'pass', 0),
('j-k8', 'nom8', 'pren8', 'jk8@mail.cm', NULL, 'pass', 0),
('j-k9', 'nom9', 'pren9', 'jk9@mail.cm', NULL, 'pass', 0),
('jk1', 'Cédric', 'Eloundou', 'mail@mail.com', 'img/avatars/jk1/avatar.jpg', 'yolo', 1),
('jk2', 'Ced', 'dric', '', NULL, 'pass', 0),
('log1', 'nom1', 'prenom1', 'log1@mail.com', NULL, 'pass', 1);

-- --------------------------------------------------------

--
-- Structure de la table `lieu`
--

CREATE TABLE IF NOT EXISTS `lieu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `carte` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `libelle` varchar(30) COLLATE utf8_bin NOT NULL,
  `ville` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `libelle` (`libelle`),
  KEY `carte` (`carte`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Contenu de la table `lieu`
--

INSERT INTO `lieu` (`id`, `carte`, `libelle`, `ville`) VALUES
(0, NULL, 'o', 'o'),
(2, NULL, 'BU Paul Sab', 'Toulouse'),
(3, NULL, 'RU Insa', 'Toulouse');

-- --------------------------------------------------------

--
-- Structure de la table `position`
--

CREATE TABLE IF NOT EXISTS `position` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `identifiant_jk` varchar(20) COLLATE utf8_bin NOT NULL,
  `id_lieu` int(11) NOT NULL,
  `jour` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identifiant_jk` (`identifiant_jk`,`id_lieu`),
  KEY `id_lieu` (`id_lieu`),
  KEY `identifiant_jk_2` (`identifiant_jk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `r_jk_lieu`
--

CREATE TABLE IF NOT EXISTS `r_jk_lieu` (
  `identifiant_jk` varchar(20) COLLATE utf8_bin NOT NULL,
  `id_lieu` int(11) NOT NULL,
  PRIMARY KEY (`identifiant_jk`,`id_lieu`),
  KEY `id_lieu` (`id_lieu`),
  KEY `identifiant_jk` (`identifiant_jk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `r_lier`
--

CREATE TABLE IF NOT EXISTS `r_lier` (
  `identifiant1` varchar(20) COLLATE utf8_bin NOT NULL,
  `identifiant2` varchar(20) COLLATE utf8_bin NOT NULL,
  `surnom1` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `surnom2` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `effectif` tinyint(1) NOT NULL,
  PRIMARY KEY (`identifiant1`,`identifiant2`),
  KEY `identifiant1` (`identifiant1`),
  KEY `identifiant2` (`identifiant2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `r_lier`
--

INSERT INTO `r_lier` (`identifiant1`, `identifiant2`, `surnom1`, `surnom2`, `effectif`) VALUES
('jk1', 'j-k0', NULL, NULL, 1),
('jk1', 'j-k1', NULL, NULL, 1),
('jk1', 'j-k2', NULL, NULL, 1),
('jk1', 'j-k3', NULL, NULL, 1),
('jk1', 'j-k4', NULL, NULL, 1),
('jk1', 'j-k5', NULL, NULL, 1),
('jk1', 'j-k6', NULL, NULL, 1),
('jk1', 'j-k7', NULL, NULL, 1),
('jk2', 'jk1', NULL, NULL, 0);

--
-- Déclencheurs `r_lier`
--
DROP TRIGGER IF EXISTS `trg_r_lier_insert`;
DELIMITER //
CREATE TRIGGER `trg_r_lier_insert` BEFORE INSERT ON `r_lier`
 FOR EACH ROW BEGIN

IF NEW.identifiant1 = NEW.identifiant1 THEN
	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Amitié avec le même JK impossible";
END IF;

END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_r_lier_update`;
DELIMITER //
CREATE TRIGGER `trg_r_lier_update` BEFORE UPDATE ON `r_lier`
 FOR EACH ROW BEGIN

IF NEW.identifiant1 = NEW.identifiant1 THEN
	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Amitié avec le même JK impossible";
END IF;

END
//
DELIMITER ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `fk_image_jk` FOREIGN KEY (`identifiant_jk`) REFERENCES `jean_kevin` (`identifiant`),
  ADD CONSTRAINT `fk_image_lieu` FOREIGN KEY (`id_lieu`) REFERENCES `lieu` (`id`);

--
-- Contraintes pour la table `jean_kevin`
--
ALTER TABLE `jean_kevin`
  ADD CONSTRAINT `jean_kevin_ibfk_1` FOREIGN KEY (`photo`) REFERENCES `image` (`chemin`);

--
-- Contraintes pour la table `lieu`
--
ALTER TABLE `lieu`
  ADD CONSTRAINT `lieu_ibfk_1` FOREIGN KEY (`carte`) REFERENCES `image` (`chemin`);

--
-- Contraintes pour la table `position`
--
ALTER TABLE `position`
  ADD CONSTRAINT `position_ibfk_1` FOREIGN KEY (`identifiant_jk`) REFERENCES `jean_kevin` (`identifiant`);

--
-- Contraintes pour la table `r_jk_lieu`
--
ALTER TABLE `r_jk_lieu`
  ADD CONSTRAINT `r_jk_lieu_ibfk_1` FOREIGN KEY (`identifiant_jk`) REFERENCES `jean_kevin` (`identifiant`);

--
-- Contraintes pour la table `r_lier`
--
ALTER TABLE `r_lier`
  ADD CONSTRAINT `fk_amitie_jk2` FOREIGN KEY (`identifiant2`) REFERENCES `jean_kevin` (`identifiant`),
  ADD CONSTRAINT `fk_amitie_jk1` FOREIGN KEY (`identifiant1`) REFERENCES `jean_kevin` (`identifiant`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
