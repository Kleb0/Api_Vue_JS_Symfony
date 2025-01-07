-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 07 jan. 2025 à 12:41
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `api_rest_afpa`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20241231190031', '2025-01-04 03:42:14', 3),
('DoctrineMigrations\\Version20250101182237', '2025-01-04 03:42:14', 0),
('DoctrineMigrations\\Version20250102003940', '2025-01-04 03:42:14', 0),
('DoctrineMigrations\\Version20250102005033', '2025-01-04 03:42:14', 0),
('DoctrineMigrations\\Version20250102005807', '2025-01-04 03:42:14', 0),
('DoctrineMigrations\\Version20250102014537', '2025-01-04 03:42:14', 0),
('DoctrineMigrations\\Version20250104024133', '2025-01-04 03:42:14', 20),
('DoctrineMigrations\\Version20250104024332', '2025-01-04 03:43:55', 22),
('DoctrineMigrations\\Version20250105160540', '2025-01-05 17:05:48', 259),
('DoctrineMigrations\\Version20250105162229', '2025-01-05 17:22:46', 9),
('DoctrineMigrations\\Version20250105171901', '2025-01-05 18:19:03', 7),
('DoctrineMigrations\\Version20250105175042', '2025-01-05 18:50:47', 7);

-- --------------------------------------------------------

--
-- Structure de la table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `release_date` date NOT NULL,
  `summary` longtext NOT NULL,
  `director` varchar(255) NOT NULL,
  `actors` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`actors`)),
  `likes` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `custom_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `movies`
--

INSERT INTO `movies` (`id`, `title`, `release_date`, `summary`, `director`, `actors`, `likes`, `image`, `custom_id`) VALUES
(26, 'E.T., l\'extra-terrestre', '1982-12-01', 'Une soucoupe volante atterrit en pleine nuit près de Los Angeles. Quelques extraterrestres, envoyés sur Terre en mission d\'exploration botanique, sortent de l\'engin, mais un des leurs s\'aventure au-delà de la clairière où se trouve la navette. Celui-ci se dirige alors vers la ville. C\'est sa première découverte de la civilisation humaine. Bientôt traquée par des militaires et abandonnée par les siens, cette petite créature apeurée se nommant E.T. se réfugie dans une résidence de banlieue.', 'Steven Spielberg', '[\"Henry Thomas\",\"Drew Barrymore\"]', 0, 'uploads/movies_images/ET.jpg', 1),
(27, 'Star Wars, épisode IV: un nouvel espoir', '1977-10-19', 'Alors que l\'Alliance rebelle tente de détruire l\'Étoile noire, arme suprême du despotique Empire galactique, Luke Skywalker, jeune ouvrier agricole, intercepte un appel à l\'aide de la princesse Leia. Il se lance ainsi dans une mission courageuse afin de la délivrer de Darth Vador et de l\'Empire.', 'George Lucas', '[\"Mark Hamill\",\"Harrison Ford\",\"Carrie Fisher\",\"Alec Guinness\"]', 0, 'uploads/movies_images/Star-Wars-New-Hope.jpg', 2),
(28, 'Star Wars Episode 1 : La Menace Fantome', '1999-10-13', 'Avant de devenir un célèbre chevalier Jedi, et bien avant de se révéler l\'âme la plus noire de la galaxie, Anakin Skywalker est un jeune esclave sur la planète Tatooine. La Force est déjà puissante en lui et il est un remarquable pilote de Podracer. Le maître Jedi Qui-Gon Jinn le découvre et entrevoit alors son immense potentiel. Pendant ce temps, l\'armée de droïdes de l\'insatiable Fédération du Commerce a envahi Naboo dans le cadre d\'un plan secret des Sith visant à accroître leur pouvoir.', 'George Lucas', '[\"Ewan McGregor\",\"Liam Neeson\",\"Jake Lloyd\"]', 0, 'uploads/movies_images/star-wars-la-menace-fantome-episode-1-star-wars-1-the-phantom-menace.jpg', 3),
(30, 'Star Wars Episode V : L\'empire contre-attaque', '1980-05-21', 'Les Rebelles se dispersent après l\'attaque de l\'Empire. Luke s\'entraîne avec Yoda tandis que ses amis échappent à Dark Vador', 'Irvin Kershner', '[\"Mark Hamill\",\"Harrison Ford\",\"Carrie Fisher\",\"Billy Dee Williams\"]', 0, 'uploads/movies_images/Star-Wars-Episode-5.jpg', 4),
(31, 'Star Wars : Épisode VI - Le Retour du Jedi', '1983-05-25', 'Luke Skywalker mène une mission pour sauver Han Solo et affronte Dark Vador dans la bataille finale', 'Richard Marquand', '[\"Mark Hamill\",\"Harrison Ford\",\"Carrie Fisher\",\"Billy Dee Williams\"]', 0, 'uploads/movies_images/Star-Wars-Episode-6.jpg', 5),
(32, 'Épisode III - La Revanche des Sith', '2005-05-19', 'Anakin Skywalker succombe au côté obscur et devient Dark Vador', 'George Lucas', '[\"Ewan McGregor\",\"Natalie Portman\",\"Hayden Christensen\",\"Ian McDiarmid\"]', 0, 'uploads/movies_images/Star-Wars-Episode-3.jpg', 6),
(33, 'Princesse Mononoké', '1997-12-07', 'Un jeune prince maudit par un sanglier démoniaque se retrouve pris dans un conflit entre les humains et les esprits de la forêt', 'Hayao Miyazaki', '[\"Y\\u014dji Matsuda\",\"Yuriko Ishida\",\"Y\\u016bko Tanaka\",\"Kaoru Kobayashi\"]', 0, 'uploads/movies_images/Mononoke.jpg', 7),
(34, 'Toy Story', '1995-02-11', 'Woody, un jouet cowboy, doit s\'allier à Buzz l\'Éclair, un nouveau jouet, pour retrouver leur chemin vers leur propriétaire Andy', 'John Lasseter', '[\"Tom Hanks\",\"Tim Allen\",\"Don Rickles\",\"Jim Varney\"]', 0, 'uploads/movies_images/toy-story.jpg', 8);

-- --------------------------------------------------------

--
-- Structure de la table `movies_categories`
--

CREATE TABLE `movies_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `custom_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `movies_categories`
--

INSERT INTO `movies_categories` (`id`, `category_name`, `custom_id`) VALUES
(8, 'Aventure', 1),
(9, 'Policier', 2),
(10, 'Espionnage', 3),
(11, 'Enquête', 4),
(12, 'Romance', 5),
(13, 'Science Fiction', 6),
(15, 'Action', 7),
(16, 'Catastrophe', 8),
(17, 'Film d\'animation', 9),
(18, 'Fantastique', 10),
(19, 'Historique', 11);

-- --------------------------------------------------------

--
-- Structure de la table `movies_movies_categories`
--

CREATE TABLE `movies_movies_categories` (
  `movies_id` int(11) NOT NULL,
  `movies_categories_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `movies_movies_categories`
--

INSERT INTO `movies_movies_categories` (`movies_id`, `movies_categories_id`) VALUES
(26, 8),
(26, 13),
(27, 8),
(27, 13),
(27, 15),
(28, 8),
(28, 13),
(28, 15),
(30, 8),
(30, 13),
(31, 8),
(31, 13),
(31, 18),
(32, 8),
(32, 13),
(32, 18),
(33, 15),
(33, 17),
(33, 18),
(34, 8),
(34, 17);

-- --------------------------------------------------------

--
-- Structure de la table `person`
--

CREATE TABLE `person` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `refresh_tokens`
--

CREATE TABLE `refresh_tokens` (
  `id` int(11) NOT NULL,
  `refresh_token` varchar(128) NOT NULL,
  `username` varchar(255) NOT NULL,
  `valid` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `refresh_tokens`
--

INSERT INTO `refresh_tokens` (`id`, `refresh_token`, `username`, `valid`) VALUES
(1, '489068f2ec2567a9002c3678924ad081bf68b79c29496bf79b64a8c8d7b14d35', 'clementmiermontei@outlook.com', '2025-02-03 03:49:06'),
(2, '20957787689cce99a3f61a77a17c539c2265d85a0f6428b7433730438f2b3640', 'Admin@outlook.com', '2025-02-03 03:50:09'),
(3, 'ff1c4976d411d4fcd1cbba9d9e40e3c8df76ffe97ddca0eb3e67838e39f63573', 'Patrick@hotmail.com', '2025-02-04 03:20:40'),
(4, 'ba0253afe1f73523d242659f9a63b3116941d6a18269c6b3af9eb6e4ff4a689c', 'LionelJospin@mail.com', '2025-02-05 17:46:20'),
(5, '7bd3fcea6a156e5d90cc3bb10e96a5d958f1876df95d032df88b7f492212b195', 'Administrateur@outlook.com', '2025-02-05 17:48:50');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'ADMIN'),
(2, 'USER');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `custom_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `comments` longtext NOT NULL,
  `comments_id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `movies_liked` longtext NOT NULL,
  `likes` int(11) NOT NULL,
  `api_token` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `street_name` varchar(255) NOT NULL,
  `street_number` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `postal_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `role_id`, `custom_id`, `email`, `password`, `first_name`, `comments`, `comments_id`, `role_name`, `movies_liked`, `likes`, `api_token`, `last_name`, `street_name`, `street_number`, `city`, `postal_code`) VALUES
(19, 2, 4, 'LionelJospin@mail.com', '$2y$13$Dvxlt1uLauEvXwgqqWYgNeYDXu.s/V4H/wndPTgJi.Aqkc1gshv9i', 'Lionel', '', 0, 'USER', '', 0, NULL, 'Jospin', 'Paris', 12, 'Quelquepart', 15000),
(20, 1, 5, 'Administrateur@outlook.com', '$2y$13$WsibUGuZxHG3/VOcDEDi..zkiLfpqMoqDBI/aAWSjdJQp40NNoKu2', 'Administrateur', '', 0, 'ADMIN', '', 0, NULL, 'Gentil', 'Administration', 20, 'AdministrationVille', 59000);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9474526C8F93B6FC` (`movie_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `movies_categories`
--
ALTER TABLE `movies_categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `movies_movies_categories`
--
ALTER TABLE `movies_movies_categories`
  ADD PRIMARY KEY (`movies_id`,`movies_categories_id`),
  ADD KEY `IDX_6FB156A353F590A4` (`movies_id`),
  ADD KEY `IDX_6FB156A3E31457CB` (`movies_categories_id`);

--
-- Index pour la table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `refresh_tokens`
--
ALTER TABLE `refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_9BACE7E1C74F2195` (`refresh_token`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_57698A6A5E237E06` (`name`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D6497BA2F5EB` (`api_token`),
  ADD KEY `IDX_8D93D649D60322AC` (`role_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `movies_categories`
--
ALTER TABLE `movies_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `refresh_tokens`
--
ALTER TABLE `refresh_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526C8F93B6FC` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`);

--
-- Contraintes pour la table `movies_movies_categories`
--
ALTER TABLE `movies_movies_categories`
  ADD CONSTRAINT `FK_6FB156A353F590A4` FOREIGN KEY (`movies_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_6FB156A3E31457CB` FOREIGN KEY (`movies_categories_id`) REFERENCES `movies_categories` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D649D60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
