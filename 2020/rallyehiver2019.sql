-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  jeu. 06 déc. 2018 à 22:57
-- Version du serveur :  5.6.41
-- Version de PHP :  5.6.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `rallyehiver2019`
--

-- --------------------------------------------------------

--
-- Structure de la table `rallye_log`
--

CREATE TABLE `rallye_log` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(80) NOT NULL,
  `equipe` varchar(100) NOT NULL,
  `log` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `rallye_log`
--

INSERT INTO `rallye_log` (`id`, `date`, `ip`, `equipe`, `log`) VALUES
(1, '2018-11-11 18:53:59', '109.7.215.145', 'The B2', 'Form login'),
(2, '2018-11-11 19:29:55', '109.7.215.145', 'The B2', 'Form login'),
(3, '2018-11-11 20:32:03', '109.7.215.145', 'The B2', 'Form login'),
(4, '2018-11-11 21:45:10', '109.7.215.145', 'The B2', 'Form login'),
(5, '2018-11-12 18:19:15', '80.12.27.80', 'The B2', 'Form login'),
(6, '2018-11-12 22:58:44', '80.12.27.80', 'The B2', 'Token login'),
(7, '2018-11-14 19:04:06', '89.159.45.216', 'The B2', 'Form login'),
(8, '2018-11-15 10:33:17', '109.7.215.145', 'The B2', 'Token login'),
(9, '2018-11-16 18:04:54', '81.250.186.148', 'The B2', 'Token login'),
(10, '2018-11-18 13:33:46', '89.159.45.216', 'The B2', 'Token login'),
(11, '2018-11-18 16:55:28', '109.7.215.145', 'The B2', 'Token login'),
(12, '2018-11-18 21:34:15', '109.7.215.145', 'The B2', 'Form login'),
(13, '2018-11-24 10:32:30', '92.184.105.201', 'The B2', 'Token login'),
(14, '2018-11-25 13:59:23', '92.184.105.201', 'The B2', 'Token login'),
(15, '2018-11-25 14:03:17', '83.204.148.69', 'The B2', 'Form login'),
(16, '2018-11-25 21:49:53', '86.245.216.66', 'The B2', 'Form login'),
(17, '2018-11-26 07:00:18', '86.245.216.66', 'The B2', 'Form login'),
(18, '2018-11-26 18:07:56', '89.159.45.216', 'The B2', 'Token login'),
(19, '2018-11-26 18:34:07', '86.245.216.66', 'The B2', 'Token login'),
(20, '2018-11-26 18:40:25', '109.7.215.145', 'The B2', 'Form login'),
(21, '2018-11-28 07:00:37', '86.245.216.66', 'The B2', 'Form login'),
(22, '2018-11-28 07:30:47', '109.7.215.145', 'The B2', 'Form login'),
(23, '2018-11-28 13:24:12', '92.184.104.37', 'The B2', 'Token login'),
(24, '2018-11-28 14:11:44', '81.250.186.148', 'The B2', 'Form login'),
(25, '2018-11-28 16:25:48', '92.184.104.37', 'The B2', 'Token login'),
(26, '2018-11-28 17:21:08', '185.156.76.10', 'The B2', 'Form login'),
(27, '2018-11-28 21:47:29', '46.193.67.59', 'The B2', 'Form login'),
(28, '2018-11-28 21:48:45', '89.159.45.216', 'The B2', 'Token login'),
(29, '2018-11-28 21:52:54', '92.184.105.73', 'The B2', 'Token login'),
(30, '2018-11-28 22:24:53', '86.245.216.66', 'The B2', 'Token login'),
(31, '2018-12-01 10:59:56', '89.159.45.216', 'The B2', 'Token login'),
(32, '2018-12-01 11:08:27', '80.12.34.12', 'The B2', 'Token login'),
(33, '2018-12-02 15:20:43', '109.7.215.145', 'The B2', 'Form login'),
(34, '2018-12-04 04:18:39', '92.184.105.115', 'The B2', 'Form login'),
(35, '2018-12-04 05:02:02', '109.7.215.145', 'The B2', 'Form login'),
(36, '2018-12-04 07:03:34', '89.159.45.216', 'The B2', 'Token login'),
(37, '2018-12-04 19:30:49', '89.159.45.216', 'The B2', 'Token login'),
(38, '2018-12-04 19:30:49', '89.159.45.216', 'The B2', 'Token login'),
(39, '2018-12-04 21:29:51', '109.7.215.145', 'The B2', 'Form login'),
(40, '2018-12-04 21:47:41', '86.245.216.66', 'The B2', 'Token login'),
(41, '2018-12-05 11:15:16', '185.156.76.10', 'The B2', 'Token login'),
(42, '2018-12-05 21:27:16', '89.159.45.216', 'The B2', 'Token login'),
(43, '2018-12-06 20:01:43', '86.245.216.66', 'The B2', 'Token login'),
(44, '2018-12-06 21:31:20', '109.7.215.145', 'The B2', 'Form login'),
(45, '2018-12-06 21:43:46', '109.7.215.145', 'Orga', 'Form login'),
(46, '2018-12-06 21:47:07', '109.7.215.145', 'Orga', 'Form login');

-- --------------------------------------------------------

--
-- Structure de la table `rallye_msg`
--

CREATE TABLE `rallye_msg` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `equipe` varchar(80) NOT NULL,
  `msg` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `rallye_msg`
--

INSERT INTO `rallye_msg` (`id`, `date`, `equipe`, `msg`) VALUES
(1, '2018-11-11 20:28:12', 'The B2', 'Coucou Bob,\nJe fais des tests :)\nA bientôt !'),
(2, '2018-11-14 19:04:26', 'The B2', 'Test Timo');

-- --------------------------------------------------------

--
-- Structure de la table `rallye_people`
--

CREATE TABLE `rallye_people` (
  `id` int(11) NOT NULL,
  `nom` varchar(64) CHARACTER SET utf8 NOT NULL,
  `login` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `pwd` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `enigmes` text NOT NULL,
  `quest` text NOT NULL,
  `token` text NOT NULL,
  `contact` text NOT NULL,
  `indices` text NOT NULL,
  `jetlag` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `rallye_people`
--

INSERT INTO `rallye_people` (`id`, `nom`, `login`, `pwd`, `enigmes`, `quest`, `token`, `contact`, `indices`, `jetlag`) VALUES
(1, 'The B2', 'theb2', '$2y$10$sbdQFmdTyRV5P8ezWCzij.1WD3EW5QrZv5H8DKnQTdoPLdR3s6NV.', '{\"1\":1544008534}', '[\"gkehb0p5av\",\"q6ktqn8nf4\"]', '{\"c3216d65998dcb914a4f11c7d72475770ab5cbd3\":1544564710,\"afe738fd93754eb6fe78989a89912cf1952ef2e1\":1544638755,\"6f61958b1411877dd8e9442ee844adc35de5043b\":1544814246,\"222c1f094ca9bd69c483d256dc8e6e2561643cbb\":1545168855,\"454a8b648526a208a8ecca319e35f7881e869e62\":1545774593,\"3cf59077f0c8d865b23780e90e91fc385d02bcf2\":1545980437,\"ea4d8c80e8916c8feef363b149a25e964c709629\":1546017668}', '', '', 0),
(2, 'Orga', 'orga', '$2y$10$j0ijkvGzs5Sd8XsOxAq8xuwoHFVf4Z8HdVyMvseRBOIy6yTy/0QBy', '', '[]', '{\"7c24931efca1557757593238cc6d9d3570891ba2\":1546724827}', '', '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `rallye_posts`
--

CREATE TABLE `rallye_posts` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `equipe` varchar(50) NOT NULL,
  `enigme` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `text` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `rallye_posts`
--

INSERT INTO `rallye_posts` (`id`, `date`, `equipe`, `enigme`, `nom`, `text`) VALUES
(1, '2018-11-11 19:30:28', 'theb2', 1, 'Reine de la Casbah', 'J\'ai trouvé ! Le thème c\'est les jeux !!'),
(2, '2018-11-11 19:30:35', 'theb2', 1, 'Bob', 'LooooL'),
(4, '2018-11-11 21:10:18', 'theb2', 1, 'Lala Fatima', 'J\'te crois pas ...'),
(5, '2018-11-11 21:41:50', 'theb2', 1, 'Test', 'ehllo'),
(6, '2018-11-14 19:08:43', 'theb2', 1, 'Aicha Aicha', 'Ecoute-moi'),
(7, '2018-12-03 23:11:44', 'theb2', 6, 'SImon', 'Peut être un peu compliquée pour un n°6 :) à voir'),
(8, '2018-12-04 20:48:02', 'theb2', 7, 'Timo', 'C\'est la mer Noire ?'),
(9, '2018-12-04 20:48:14', 'theb2', 8, 'Timo', 'C\'est la mer... Noire ?'),
(10, '2018-12-04 20:48:21', 'theb2', 9, 'Timo', 'C\'est la mer Noire !');

-- --------------------------------------------------------

--
-- Structure de la table `rallye_try`
--

CREATE TABLE `rallye_try` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `equipe` varchar(80) NOT NULL,
  `enigme` int(11) NOT NULL,
  `mdp` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `rallye_try`
--

INSERT INTO `rallye_try` (`id`, `date`, `equipe`, `enigme`, `mdp`) VALUES
(1, '2018-11-11 19:32:52', 'theb2', 1, 'coucou'),
(2, '2018-11-11 19:32:58', 'theb2', 1, 'uno'),
(3, '2018-11-11 19:33:15', 'theb2', 1, 'inde'),
(4, '2018-11-11 20:20:25', 'theb2', 16, 'roidecoeur'),
(5, '2018-11-11 20:20:29', 'theb2', 16, 'barbu'),
(6, '2018-11-11 20:21:48', 'theb2', 9, 'risk'),
(7, '2018-11-11 20:31:31', 'theb2', 1, 'uno'),
(8, '2018-11-11 20:31:35', 'theb2', 1, 'inde'),
(9, '2018-11-11 20:46:47', 'theb2', 1, 'inde'),
(10, '2018-11-11 21:43:54', 'theb2', 1, 'inde'),
(11, '2018-11-11 21:43:55', 'theb2', 1, 'inde'),
(12, '2018-11-11 21:44:01', 'theb2', 1, 'inde'),
(13, '2018-11-11 21:45:27', 'theb2', 1, 'f\"zg'),
(14, '2018-11-11 21:45:31', 'theb2', 1, 'azfaf'),
(15, '2018-11-11 21:45:35', 'theb2', 1, 'uno'),
(16, '2018-11-11 21:45:40', 'theb2', 1, 'inde'),
(17, '2018-11-11 21:45:53', 'theb2', 1, 'inde'),
(18, '2018-11-11 21:47:32', 'theb2', 1, 'azdi'),
(19, '2018-11-11 21:47:37', 'theb2', 1, 'inde'),
(20, '2018-11-11 23:53:13', 'theb2', 1, 'inde'),
(21, '2018-11-11 23:53:57', 'theb2', 3, 'magellan'),
(22, '2018-11-14 19:08:58', 'theb2', 1, 'le jerk'),
(23, '2018-11-18 17:52:05', 'theb2', 1, 'zef'),
(24, '2018-11-18 17:52:07', 'theb2', 1, 'zef'),
(25, '2018-11-18 17:52:10', 'theb2', 1, 'zefzef'),
(26, '2018-11-18 17:52:11', 'theb2', 1, 'zefzef'),
(27, '2018-11-18 17:52:11', 'theb2', 1, 'zefzef'),
(28, '2018-11-18 17:52:12', 'theb2', 1, 'zefzef'),
(29, '2018-11-18 17:52:12', 'theb2', 1, 'zefzef'),
(30, '2018-11-18 17:52:13', 'theb2', 1, 'zefzef'),
(31, '2018-11-25 14:00:38', 'theb2', 11, 'dragon'),
(32, '2018-11-25 14:00:46', 'theb2', 11, 'scorpion'),
(33, '2018-11-25 14:00:58', 'theb2', 13, 'jeu'),
(34, '2018-11-25 14:03:29', 'theb2', 4, 'couillon'),
(35, '2018-11-25 14:03:44', 'theb2', 7, 'bahamas'),
(36, '2018-11-25 14:04:04', 'theb2', 18, 'jackpot'),
(37, '2018-11-25 14:04:30', 'theb2', 12, 'eau'),
(38, '2018-11-25 14:04:35', 'theb2', 12, 'air'),
(39, '2018-11-25 14:04:39', 'theb2', 12, 'feu'),
(40, '2018-11-25 14:04:43', 'theb2', 12, 'terre'),
(41, '2018-11-25 14:05:09', 'theb2', 2, 'lejeudesmilleeuros'),
(42, '2018-11-25 14:05:20', 'theb2', 2, 'jeudesmilleeuros'),
(43, '2018-11-25 14:05:44', 'theb2', 5, 'millebornes'),
(44, '2018-11-28 07:32:09', 'theb2', 14, 'montparnasse'),
(45, '2018-11-28 17:22:20', 'theb2', 8, 'paume'),
(46, '2018-11-28 17:22:25', 'theb2', 8, 'jeudepaume'),
(47, '2018-11-28 17:22:32', 'theb2', 9, 'risk'),
(48, '2018-11-28 17:22:48', 'theb2', 12, 'eau'),
(49, '2018-11-28 17:23:13', 'theb2', 16, 'roidecoeur'),
(50, '2018-11-28 17:23:17', 'theb2', 16, 'barbu'),
(51, '2018-11-28 17:23:29', 'theb2', 19, 'marseille'),
(52, '2018-11-28 22:13:09', 'theb2', 21, 'Vauban'),
(53, '2018-11-28 22:13:15', 'theb2', 21, 'vauban'),
(54, '2018-11-28 22:13:19', 'theb2', 21, 'vauban'),
(55, '2018-11-28 22:13:22', 'theb2', 21, 'vauban'),
(56, '2018-11-28 22:26:16', 'theb2', 21, 'Vauban'),
(57, '2018-11-28 22:31:11', 'theb2', 21, 'Vauban'),
(58, '2018-11-28 22:31:15', 'theb2', 21, 'vauban'),
(59, '2018-11-28 22:31:16', 'theb2', 21, 'vauban'),
(60, '2018-11-28 22:31:16', 'theb2', 21, 'vauban'),
(61, '2018-11-28 22:31:16', 'theb2', 21, 'vauban'),
(62, '2018-11-28 22:31:16', 'theb2', 21, 'vauban'),
(63, '2018-11-28 22:31:16', 'theb2', 21, 'vauban'),
(64, '2018-11-28 22:31:16', 'theb2', 21, 'vauban'),
(65, '2018-11-28 22:31:17', 'theb2', 21, 'vauban'),
(66, '2018-11-28 22:31:17', 'theb2', 21, 'vauban'),
(67, '2018-11-28 22:31:17', 'theb2', 21, 'vauban'),
(68, '2018-12-03 23:04:25', 'theb2', 6, 'simcity'),
(69, '2018-12-03 23:04:28', 'theb2', 6, 'simcity'),
(70, '2018-12-03 23:05:02', 'theb2', 6, 'simcity'),
(71, '2018-12-03 23:10:29', 'theb2', 6, 'simcity'),
(72, '2018-12-04 05:02:08', 'theb2', 6, 'KONAMI'),
(73, '2018-12-04 05:22:30', 'theb2', 6, 'simcity'),
(74, '2018-12-04 20:15:25', 'theb2', 6, 'timciby'),
(75, '2018-12-04 20:15:39', 'theb2', 6, 't1mc1by'),
(76, '2018-12-04 20:15:41', 'theb2', 6, 't1mc1by'),
(77, '2018-12-04 20:15:41', 'theb2', 6, 't1mc1by'),
(78, '2018-12-04 20:15:42', 'theb2', 6, 't1mc1by'),
(79, '2018-12-04 20:16:49', 'theb2', 6, 'simcity'),
(80, '2018-12-04 21:35:44', 'theb2', 1, 'bob'),
(81, '2018-12-04 21:35:49', 'theb2', 1, 'bob'),
(82, '2018-12-04 21:36:04', 'theb2', 1, 'inde'),
(83, '2018-12-04 21:36:08', 'theb2', 1, 'inde'),
(84, '2018-12-04 22:03:33', 'theb2', 1, 'inde'),
(85, '2018-12-04 22:11:35', 'theb2', 1, 'inde'),
(86, '2018-12-04 22:11:37', 'theb2', 1, 'inde'),
(87, '2018-12-04 22:11:38', 'theb2', 1, 'inde'),
(88, '2018-12-04 22:11:38', 'theb2', 1, 'inde'),
(89, '2018-12-04 22:13:29', 'theb2', 1, 'inde'),
(90, '2018-12-04 22:14:29', 'theb2', 1, 'inde'),
(91, '2018-12-04 22:16:53', 'theb2', 6, 'simcity'),
(92, '2018-12-04 22:17:04', 'theb2', 6, 'simcity'),
(93, '2018-12-04 22:17:08', 'theb2', 6, 'simcity'),
(94, '2018-12-04 22:17:28', 'theb2', 6, 'couillon'),
(95, '2018-12-04 22:17:30', 'theb2', 6, 'couillon'),
(96, '2018-12-04 22:17:36', 'theb2', 3, 'couillon'),
(97, '2018-12-04 22:17:43', 'theb2', 4, 'couillon'),
(98, '2018-12-04 22:17:57', 'theb2', 4, 'couillon'),
(99, '2018-12-04 22:20:13', 'theb2', 1, 'zjevozkj'),
(100, '2018-12-04 22:20:16', 'theb2', 1, 'inde'),
(101, '2018-12-04 22:20:21', 'theb2', 1, 'inde'),
(102, '2018-12-04 22:20:46', 'theb2', 4, 'couillon'),
(103, '2018-12-04 22:21:47', 'theb2', 1, 'aza'),
(104, '2018-12-04 22:21:50', 'theb2', 1, 'inde'),
(105, '2018-12-04 22:22:01', 'theb2', 1, 'inde'),
(106, '2018-12-04 22:22:06', 'theb2', 1, 'inde'),
(107, '2018-12-04 22:22:09', 'theb2', 1, 'azfa'),
(108, '2018-12-04 22:22:12', 'theb2', 1, 'inde'),
(109, '2018-12-04 22:22:26', 'theb2', 4, 'couillon'),
(110, '2018-12-04 22:22:33', 'theb2', 4, 'couillon'),
(111, '2018-12-04 22:22:35', 'theb2', 4, 'azda'),
(112, '2018-12-04 22:22:39', 'theb2', 4, 'couillon'),
(113, '2018-12-04 22:22:55', 'theb2', 6, 'simcity'),
(114, '2018-12-04 22:23:24', 'theb2', 6, 'simcity'),
(115, '2018-12-04 22:24:13', 'theb2', 6, 'simcity'),
(116, '2018-12-04 22:27:28', 'theb2', 1, 'inde'),
(117, '2018-12-04 22:27:52', 'theb2', 4, 'couillon'),
(118, '2018-12-04 22:28:05', 'theb2', 6, 'simcity'),
(119, '2018-12-04 22:28:14', 'theb2', 13, 'jeu'),
(120, '2018-12-04 22:28:35', 'theb2', 16, 'barbu'),
(121, '2018-12-04 22:28:50', 'theb2', 19, 'marseille'),
(122, '2018-12-04 22:29:32', 'theb2', 11, 'scorpion'),
(123, '2018-12-04 22:29:51', 'theb2', 20, 'xxx'),
(124, '2018-12-04 22:30:02', 'theb2', 17, 'xxx'),
(125, '2018-12-04 22:33:00', 'theb2', 11, 'scorpion'),
(126, '2018-12-04 22:38:28', 'theb2', 11, 'scorpion'),
(127, '2018-12-04 22:38:47', 'theb2', 11, 'scorpion'),
(128, '2018-12-04 22:41:16', 'theb2', 4, 'couillon'),
(129, '2018-12-04 22:41:36', 'theb2', 9, 'risk'),
(130, '2018-12-04 22:41:46', 'theb2', 13, 'jeu'),
(131, '2018-12-04 22:42:01', 'theb2', 14, 'montparnasse'),
(132, '2018-12-04 22:42:08', 'theb2', 16, 'barbu'),
(133, '2018-12-04 22:42:17', 'theb2', 12, 'eau'),
(134, '2018-12-04 22:42:28', 'theb2', 2, 'jeudesmilleeuros'),
(135, '2018-12-04 22:42:40', 'theb2', 6, 'simcity'),
(136, '2018-12-04 22:42:50', 'theb2', 1, 'inde'),
(137, '2018-12-04 22:43:04', 'theb2', 3, 'magellan'),
(138, '2018-12-04 22:43:10', 'theb2', 5, 'millebornes'),
(139, '2018-12-04 22:43:16', 'theb2', 7, 'bahamas'),
(140, '2018-12-04 22:43:26', 'theb2', 8, 'jeudepaume'),
(141, '2018-12-04 22:43:38', 'theb2', 10, 'cachecache'),
(142, '2018-12-04 22:43:43', 'theb2', 11, 'scorpion'),
(143, '2018-12-04 22:43:57', 'theb2', 15, 'newman'),
(144, '2018-12-04 22:44:00', 'theb2', 15, 'paulnewman'),
(145, '2018-12-04 22:44:08', 'theb2', 18, 'jackpot'),
(146, '2018-12-04 22:44:18', 'theb2', 19, 'marseille'),
(147, '2018-12-04 22:44:22', 'theb2', 17, 'xxx'),
(148, '2018-12-04 22:44:25', 'theb2', 20, 'xxx'),
(149, '2018-12-04 22:44:32', 'theb2', 21, 'xxx'),
(150, '2018-12-05 11:15:34', 'theb2', 1, 'inde');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `rallye_log`
--
ALTER TABLE `rallye_log`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rallye_msg`
--
ALTER TABLE `rallye_msg`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rallye_people`
--
ALTER TABLE `rallye_people`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Index pour la table `rallye_posts`
--
ALTER TABLE `rallye_posts`
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `rallye_try`
--
ALTER TABLE `rallye_try`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `rallye_log`
--
ALTER TABLE `rallye_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `rallye_msg`
--
ALTER TABLE `rallye_msg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `rallye_people`
--
ALTER TABLE `rallye_people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `rallye_posts`
--
ALTER TABLE `rallye_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `rallye_try`
--
ALTER TABLE `rallye_try`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
