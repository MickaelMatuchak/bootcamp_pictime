-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  ven. 20 avr. 2018 à 16:49
-- Version du serveur :  5.6.39
-- Version de PHP :  7.0.28-1+0~20180306105011.16+stretch~1.gbpe20ff4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bootcamp`
--

-- --------------------------------------------------------

--
-- Structure de la table `personage`
--

CREATE TABLE `personage` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `life` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `race` varchar(255) NOT NULL,
  `victory` int(11) NOT NULL DEFAULT '0',
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `stat`
--

CREATE TABLE `stat` (
  `id` int(11) NOT NULL,
  `race` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `stat`
--

INSERT INTO `stat` (`id`, `race`, `name`, `value`) VALUES
(1, 'Default', 'force', 30),
(2, 'Default', 'armor', 20),
(3, 'Default', 'dexterity', 10),
(4, 'Dwarf', 'force', 5),
(5, 'Dwarf', 'armor', 5),
(6, 'Dwarf', 'dexterity', -2),
(7, 'Elf', 'force', -10),
(8, 'Elf', 'armor', 0),
(9, 'Elf', 'dexterity', 10),
(10, 'Human', 'force', 0),
(11, 'Human', 'armor', 0),
(12, 'Human', 'dexterity', 0),
(13, 'Orc', 'force', 4),
(14, 'Orc', 'armor', 4),
(15, 'Orc', 'dexterity', 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fight` int(11) NOT NULL DEFAULT '0',
  `victory` int(11) NOT NULL DEFAULT '0',
  `points` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `personage`
--
ALTER TABLE `personage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `key_id_user` (`user`);

--
-- Index pour la table `stat`
--
ALTER TABLE `stat`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `personage`
--
ALTER TABLE `personage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `stat`
--
ALTER TABLE `stat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `personage`
--
ALTER TABLE `personage`
  ADD CONSTRAINT `key_id_user` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
