-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 13 déc. 2021 à 07:13
-- Version du serveur : 8.0.27
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `rpg`
--

-- --------------------------------------------------------

--
-- Structure de la table `combat`
--

DROP TABLE IF EXISTS `combat`;
CREATE TABLE IF NOT EXISTS `combat` (
  `id_combat` int NOT NULL AUTO_INCREMENT,
  `date_combat` date NOT NULL,
  PRIMARY KEY (`id_combat`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `combat`
--

INSERT INTO `combat` (`id_combat`, `date_combat`) VALUES
(2, '2021-12-15'),
(3, '2021-12-16'),
(4, '2021-12-03');

-- --------------------------------------------------------

--
-- Structure de la table `combat_personnage`
--

DROP TABLE IF EXISTS `combat_personnage`;
CREATE TABLE IF NOT EXISTS `combat_personnage` (
  `id_combat_personnage` int NOT NULL AUTO_INCREMENT,
  `id_personnage` int NOT NULL,
  `id_combat` int NOT NULL,
  PRIMARY KEY (`id_combat_personnage`),
  KEY `id_combat` (`id_combat`),
  KEY `id_personnage` (`id_personnage`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `combat_personnage`
--

INSERT INTO `combat_personnage` (`id_combat_personnage`, `id_personnage`, `id_combat`) VALUES
(8, 1, 2),
(9, 8, 4),
(10, 9, 4);

-- --------------------------------------------------------

--
-- Structure de la table `pantheon`
--

DROP TABLE IF EXISTS `pantheon`;
CREATE TABLE IF NOT EXISTS `pantheon` (
  `id_pantheon` int NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `token` varchar(100) NOT NULL,
  `hp` int NOT NULL,
  `defense` int NOT NULL,
  `str` int NOT NULL,
  `dex` int NOT NULL,
  `intel` int NOT NULL,
  `cha` int NOT NULL,
  PRIMARY KEY (`id_pantheon`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `pantheon`
--

INSERT INTO `pantheon` (`id_pantheon`, `name`, `token`, `hp`, `defense`, `str`, `dex`, `intel`, `cha`) VALUES
(1, 'Nadarr', 'image/token_tepes1639083245.png', -50, 25, 18, 12, 12, 17),
(2, 'Aldieza', 'image/token_calus_samurai_token1639083089.png', 0, 15, 13, 17, 12, 14),
(3, 'Nadarr', 'image/token_tibo_Nadarr1639370734.png', 15, 24, 18, 5, 14, 12),
(4, 'Anne', 'image/token_calus_anne-hilfe1639340524.png', 10, 12, 18, 12, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `personnage`
--

DROP TABLE IF EXISTS `personnage`;
CREATE TABLE IF NOT EXISTS `personnage` (
  `id_personnage` int NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `token` varchar(100) NOT NULL,
  `hp` int NOT NULL,
  `defense` int NOT NULL,
  `str` int NOT NULL,
  `dex` int NOT NULL,
  `intel` int NOT NULL,
  `cha` int NOT NULL,
  PRIMARY KEY (`id_personnage`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `personnage`
--

INSERT INTO `personnage` (`id_personnage`, `name`, `token`, `hp`, `defense`, `str`, `dex`, `intel`, `cha`) VALUES
(1, 'Drohk', 'image/token_Jean_Troll1639083024.png', 70, 8, 20, 18, 5, 2),
(6, 'Nadarr', 'image/token_tibo_Nadarr1639379323.png', 75, 23, 14, 5, 18, 5),
(7, 'Leodas', 'image/Token_Bakka_Leolas1639379358.png', 40, 23, 14, 19, 10, 5),
(8, 'Bubado', 'image/token_Bakka_Jirosten1639379392.png', 75, 23, 14, 5, 18, 5),
(9, 'Jeannine', 'image/token_Jeanine1639379424.png', 75, 23, 14, 5, 18, 5);

-- --------------------------------------------------------

--
-- Structure de la table `perso_profession`
--

DROP TABLE IF EXISTS `perso_profession`;
CREATE TABLE IF NOT EXISTS `perso_profession` (
  `id_perso_profession` int NOT NULL AUTO_INCREMENT,
  `id_personnage` int NOT NULL,
  `id_profession` int NOT NULL,
  PRIMARY KEY (`id_perso_profession`),
  KEY `id_personnage` (`id_personnage`),
  KEY `id_profession` (`id_profession`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `perso_profession`
--

INSERT INTO `perso_profession` (`id_perso_profession`, `id_personnage`, `id_profession`) VALUES
(1, 1, 1),
(6, 6, 3),
(7, 7, 6),
(8, 8, 1),
(9, 9, 2);

-- --------------------------------------------------------

--
-- Structure de la table `profession`
--

DROP TABLE IF EXISTS `profession`;
CREATE TABLE IF NOT EXISTS `profession` (
  `id_profession` int NOT NULL AUTO_INCREMENT,
  `professionName` varchar(32) NOT NULL,
  PRIMARY KEY (`id_profession`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `profession`
--

INSERT INTO `profession` (`id_profession`, `professionName`) VALUES
(1, 'Barbare'),
(2, 'Chevalier'),
(3, 'Guerrier'),
(4, 'Magicien'),
(5, 'Chasseur'),
(6, 'Barde'),
(7, 'Nécromancien');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `combat_personnage`
--
ALTER TABLE `combat_personnage`
  ADD CONSTRAINT `combat_personnage_ibfk_1` FOREIGN KEY (`id_combat`) REFERENCES `combat` (`id_combat`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `combat_personnage_ibfk_2` FOREIGN KEY (`id_personnage`) REFERENCES `personnage` (`id_personnage`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `perso_profession`
--
ALTER TABLE `perso_profession`
  ADD CONSTRAINT `perso_profession_ibfk_1` FOREIGN KEY (`id_personnage`) REFERENCES `personnage` (`id_personnage`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `perso_profession_ibfk_2` FOREIGN KEY (`id_profession`) REFERENCES `profession` (`id_profession`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
