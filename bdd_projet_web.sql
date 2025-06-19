-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 19, 2025 at 11:14 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bdd_projet_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_commentaires_com`
--

CREATE TABLE `t_commentaires_com` (
  `id` int NOT NULL,
  `contenu` text COLLATE utf8mb4_general_ci NOT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_utilisateur` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_commentaires_com`
--

INSERT INTO `t_commentaires_com` (`id`, `contenu`, `date_creation`, `id_utilisateur`) VALUES
(5, 'Salut moi c\'est moi', '2025-06-19 12:35:36', 9),
(6, 'Salut moi c\'est toi', '2025-06-19 12:43:03', 11);

-- --------------------------------------------------------

--
-- Table structure for table `t_utilisateur_uti`
--

CREATE TABLE `t_utilisateur_uti` (
  `uti_id` int NOT NULL,
  `uti_pseudo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `uti_email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `uti_motdepasse` varbinary(255) NOT NULL,
  `uti_compte_active` tinyint(1) NOT NULL DEFAULT '1',
  `uti_code_activation` char(5) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_utilisateur_uti`
--

INSERT INTO `t_utilisateur_uti` (`uti_id`, `uti_pseudo`, `uti_email`, `uti_motdepasse`, `uti_compte_active`, `uti_code_activation`) VALUES
(1, 'test', 'test.mail@mail.com', 0x243279243130246459783372476d34305367455355324b47415861746545454844694843656b354d6a4b4f446e76455a796c6e4e654a6b3933727971, 1, NULL),
(6, 'voir', 'voir@email.com', 0x243279243130247a4b6d30795961426561752f626a48435648764478755a49585a2f4759324f365a4c6e7a32667479596665464c31566a47377a3069, 1, NULL),
(7, 'nathan', 'nathan.yh@hotmail.com', 0x2432792431302443575747646a46794d7a5530344273534458397441656267554772496a6e575a6647564b54704a614930666f2f714e715273395465, 1, NULL),
(8, 'trolley', 'trolley@gmail.com', 0x24327924313024516d4b6d7a616e784d733030733038574a377276572e52336675457552762f6a5139585a557a6d6347546d2e614c58652f48316c53, 1, NULL),
(9, 'azerty', 'azerty@gmail.com', 0x2432792431302434385774354d39364c43373255306a7851484f714d654c56516575744a4e4d796f39685137486f6562736245764c5a4c504d51436d, 1, NULL),
(10, 'as', 'e.em@gmail.com', 0x24327924313024566e6743425a716d36712e34426b6369345649454d2e7a6b5656316d6c33706d53426b3849396d502e307148304c582e4b56656f57, 1, NULL),
(11, 'po', 'po@email.com', 0x2432792431302478496e78785250366a4e6d4f36633373627974437775503848655a775a69716531392e6c374650714d4658386f3551457937664243, 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_commentaires_com`
--
ALTER TABLE `t_commentaires_com`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_utilisateur_uti`
--
ALTER TABLE `t_utilisateur_uti`
  ADD PRIMARY KEY (`uti_id`),
  ADD UNIQUE KEY `uti_pseudo` (`uti_pseudo`),
  ADD UNIQUE KEY `uti_email` (`uti_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_commentaires_com`
--
ALTER TABLE `t_commentaires_com`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `t_utilisateur_uti`
--
ALTER TABLE `t_utilisateur_uti`
  MODIFY `uti_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
