-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 05 juin 2024 à 06:22
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_notess`
--

-- --------------------------------------------------------

--
-- Structure de la table `grades`
--

DROP TABLE IF EXISTS `grades`;
CREATE TABLE IF NOT EXISTS `grades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `course` varchar(55) COLLATE utf8mb4_general_ci NOT NULL,
  `grade` decimal(5,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_student` (`student_id`),
  KEY `idx_teacher` (`teacher_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

DROP TABLE IF EXISTS `notes`;
CREATE TABLE IF NOT EXISTS `notes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `enseignant_id` int DEFAULT NULL,
  `nom_prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `matiere` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `classe` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nom_etudiant` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `matricule_s` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `filiere` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `enseignant` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `note1` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `note2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `note3` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `notes`
--

INSERT INTO `notes` (`id`, `enseignant_id`, `nom_prenom`, `matiere`, `classe`, `nom_etudiant`, `prenom`, `matricule_s`, `filiere`, `enseignant`, `note1`, `note2`, `note3`) VALUES
(1, 0, 'Express Needer', 'q', 'l2d', 'Phineas', 'Kenzas', 'iuui', 'pod', '23', '23', '23', '20'),
(2, 0, 'Hallo K.', 'Algebre', 'L2C', 'Phineas', 'Kenzas', 'IAI', 'pod', '23', '23', '23', '20'),
(3, 0, 'Hallo K.', 'Algebre', 'L2C', 'Phineas', 'Kenzas', 'IAI_CM_2022_GL001', 'Proba & Stats', '12', '15', '09', '16'),
(4, 0, 'Rema D.', 'POD', 'L2D', 'Rema', 'Kenzas', 'IAI_2021', 'POD', '12', '20', '15', '18');

-- --------------------------------------------------------

--
-- Structure de la table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_etudiant` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `age` int NOT NULL,
  `class` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `sex` varchar(2) COLLATE utf8mb4_general_ci NOT NULL,
  `matricule_s` int NOT NULL,
  `filiere` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `students`
--

INSERT INTO `students` (`id`, `nom_etudiant`, `age`, `class`, `email`, `sex`, `matricule_s`, `filiere`) VALUES
(1, 'Hallo Kenzas', 21, 'L2C', 'hallokenzas@gmail.com', 'Ma', 0, '');

-- --------------------------------------------------------

--
-- Structure de la table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
CREATE TABLE IF NOT EXISTS `teachers` (
  `id_enseignant` int NOT NULL AUTO_INCREMENT,
  `nom_prenom` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mdp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `matiere` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_enseignant`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `teachers`
--

INSERT INTO `teachers` (`id_enseignant`, `nom_prenom`, `email`, `mdp`, `matiere`) VALUES
(1, 'Phineas Kenzas', 'renenjanda196@gmail.com', 'Math', '');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `nom` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sex` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mdp` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `poste` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  UNIQUE KEY `username` (`nom`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
