-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Ven 17 Février 2017 à 21:48
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `fimaj`
--

-- --------------------------------------------------------

--
-- Structure de la table `ban`
--

CREATE TABLE `ban` (
	`id` int(11) NOT NULL,
	`id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
	`id` int(11) NOT NULL,
	`titre` varchar(255) NOT NULL,
	`nb_vote_positif` int(11) NOT NULL DEFAULT '0',
	`nb_vote_negatif` int(11) NOT NULL DEFAULT '0',
	`id_user` int(11) NOT NULL,
	`date_creation` datetime NOT NULL,
	`nom_original` varchar(255) DEFAULT NULL,
	`nom_hash` varchar(255) DEFAULT NULL,
	`format` varchar(10) DEFAULT NULL,
	`pointsTotaux` int(11) NOT NULL DEFAULT '0',
	`genre` varchar(255) NOT NULL,
	`url` varchar(255) DEFAULT NULL,
	`supprime` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`pseudo` varchar(255) UNIQUE,
	`dateinscription` datetime NOT NULL,
	`grade` int(11) NOT NULL DEFAULT '0',
	PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- --------------------------------------------------------

--
-- Structure de la table `classic_users`
--

CREATE TABLE `classic_users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`id_user` int(11) NOT NULL UNIQUE,
	`username` varchar(255) NOT NULL UNIQUE,
	`pass` varchar(255) NOT NULL,
	`email` varchar(255) UNIQUE,
	PRIMARY KEY(`id`),
	FOREIGN KEY(`id_user`) REFERENCES users(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- --------------------------------------------------------

--
-- Structure de la table `federated_users`
--

CREATE TABLE `federated_users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`id_user` int(11) NOT NULL UNIQUE,
	`oauth_provider` enum('', 'facebook', 'google', 'twitter') NOT NULL,
	`oauth_uid` varchar(255) NOT NULL,
	`name` varchar(255),
	`gender` varchar(15),
	`email` varchar(255),
	`picture` varchar(255),
	PRIMARY KEY(`id`),
	FOREIGN KEY(`id_user`) REFERENCES users(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `vote`
--

CREATE TABLE `vote` (
	`id` int(11) NOT NULL,
	`id_image` int(11) NOT NULL,
	`id_user` int(11) NOT NULL,
	`vote` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `report`
--

CREATE TABLE `report` (
	`id` int(11) NOT NULL,
	`id_image` int(11) NOT NULL,
	`id_user` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
--	Structure de la table `auth_tokens`
--
CREATE TABLE `auth_tokens` (
	`id` int(11) NOT NULL,
	`selector` char(12),
	`token` char(64),
	`id_user` int(11) NOT NULL,
	`expires` datetime
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `ban`
--
ALTER TABLE `ban`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `id_user` (`id_user`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `url` (`url`);


--
-- Index pour la table `vote`
--
ALTER TABLE `vote`
ADD PRIMARY KEY (`id`);

--
-- Index pour la table `report`
--
ALTER TABLE `report`
ADD PRIMARY KEY (`id`);

--
-- Index pour la table `auth_tokens`
--
ALTER TABLE `auth_tokens`
ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `ban`
--
ALTER TABLE `ban`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `vote`
--
ALTER TABLE `vote`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `report`
--
ALTER TABLE `report`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `auth_tokens`
--
ALTER TABLE `auth_tokens`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
