-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour projet
CREATE DATABASE IF NOT EXISTS `projet` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `projet`;

-- Listage de la structure de table projet. balade
CREATE TABLE IF NOT EXISTS `balade` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `ville` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_heure_depart` datetime NOT NULL,
  `organisateur_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_540083D7D936B2FA` (`organisateur_id`),
  CONSTRAINT `FK_540083D7D936B2FA` FOREIGN KEY (`organisateur_id`) REFERENCES `personne` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.balade : ~1 rows (environ)
INSERT INTO `balade` (`id`, `nom`, `description`, `ville`, `date_heure_depart`, `organisateur_id`) VALUES
	(6, 'balade du siècle', 'Lorem Elsass ipsum Richard Schirmeck Kabinetpapier nullam leverwurscht Heineken und blottkopf, pellentesque tchao bissame merci vielmols dui salu libero. jetz gehts los sed gal baeckeoffe id, Huguette Miss Dahlias Spätzle wurscht messti de Bischheim sit schneck bredele ornare Racing. amet hopla vielmols, Oberschaeffolsheim Strasbourg dolor sit DNA, hoplageiss auctor, risus, s\'guelt geht\'s placerat habitant geïz senectus rossbolla non non sed nüdle elit hopla Salu bissame Chulien semper in, gravida id kartoffelsalad vulputate ac Verdammi quam. commodo ftomi!', 'Oberhausbergen', '2023-12-22 19:30:00', 1);

-- Listage de la structure de table projet. balade_personne
CREATE TABLE IF NOT EXISTS `balade_personne` (
  `balade_id` int NOT NULL,
  `personne_id` int NOT NULL,
  PRIMARY KEY (`balade_id`,`personne_id`),
  KEY `IDX_1BC368A7FE292D59` (`balade_id`),
  KEY `IDX_1BC368A7A21BD112` (`personne_id`),
  CONSTRAINT `FK_1BC368A7A21BD112` FOREIGN KEY (`personne_id`) REFERENCES `personne` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_1BC368A7FE292D59` FOREIGN KEY (`balade_id`) REFERENCES `balade` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.balade_personne : ~1 rows (environ)
INSERT INTO `balade_personne` (`balade_id`, `personne_id`) VALUES
	(6, 4);

-- Listage de la structure de table projet. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.categorie : ~5 rows (environ)
INSERT INTO `categorie` (`id`, `nom`) VALUES
	(1, 'Health'),
	(2, 'Behaviour'),
	(3, 'Food'),
	(4, 'News'),
	(5, 'Site');

-- Listage de la structure de table projet. chien
CREATE TABLE IF NOT EXISTS `chien` (
  `id` int NOT NULL AUTO_INCREMENT,
  `personne_id` int NOT NULL,
  `nom` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_naissance` date NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `date_actualisation` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_13A4067EA21BD112` (`personne_id`),
  CONSTRAINT `FK_13A4067EA21BD112` FOREIGN KEY (`personne_id`) REFERENCES `personne` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.chien : ~6 rows (environ)
INSERT INTO `chien` (`id`, `personne_id`, `nom`, `image_name`, `date_naissance`, `description`, `date_actualisation`) VALUES
	(2, 1, 'harlem', 'img-20220724-100308-654cd877e51d8679592298.jpg', '2016-02-12', NULL, '2023-11-11 18:58:54'),
	(3, 1, 'boomer', 'img-20220828-180548-654cdb1b7b442503021540.jpg', '2016-04-01', NULL, '2023-11-11 18:59:09'),
	(4, 1, 'lilas', 'img-20221228-163206-654cdb3b0a5ae901954140.jpg', '2019-02-14', NULL, '2023-11-11 19:15:55'),
	(8, 1, 'Rex', 'dash-dachshund-with-hat-654fd5f1f1a3c306932782.jpg', '2014-12-20', NULL, '2023-11-11 19:30:03'),
	(9, 4, 'Burtono', 'mastiff-english-65535721a08d3904027177.jpg', '2018-05-12', NULL, '2023-11-14 17:13:18'),
	(10, 6, 'Trevor', 'beagle-adult-65538deff26f5295072921.jpg', '2019-02-12', NULL, '2023-11-14 15:10:39'),
	(11, 4, 'Joy', 'setter-gordon-6553ab19d4669759752159.jpg', '2023-05-18', NULL, '2023-11-14 17:15:05');

-- Listage de la structure de table projet. chien_race
CREATE TABLE IF NOT EXISTS `chien_race` (
  `id` int NOT NULL AUTO_INCREMENT,
  `chien_id` int DEFAULT NULL,
  `nom_race` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5B5D7EE8BFCF400E` (`chien_id`),
  CONSTRAINT `FK_B584F83FBFCF400E` FOREIGN KEY (`chien_id`) REFERENCES `chien` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.chien_race : ~10 rows (environ)
INSERT INTO `chien_race` (`id`, `chien_id`, `nom_race`) VALUES
	(6, 2, 'bouvier'),
	(7, 2, 'collie border'),
	(8, 3, 'collie border'),
	(9, 4, 'malinois'),
	(10, 8, 'dachshund'),
	(11, 8, 'dhole'),
	(12, 8, 'dachshund'),
	(13, 9, 'mastiff english'),
	(14, 10, 'beagle'),
	(15, 10, 'beagle'),
	(16, 11, 'setter gordon');

-- Listage de la structure de table projet. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table projet.doctrine_migration_versions : ~9 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20231109110955', '2023-11-09 11:10:02', 289),
	('DoctrineMigrations\\Version20231111181119', '2023-11-11 18:11:34', 157),
	('DoctrineMigrations\\Version20231112181427', '2023-11-12 18:14:44', 161),
	('DoctrineMigrations\\Version20231113163344', '2023-11-13 16:33:53', 59),
	('DoctrineMigrations\\Version20231113193513', '2023-11-13 19:35:21', 136),
	('DoctrineMigrations\\Version20231114075130', '2023-11-14 07:51:39', 188),
	('DoctrineMigrations\\Version20231114081716', '2023-11-14 08:17:22', 19),
	('DoctrineMigrations\\Version20231114085335', '2023-11-14 08:53:39', 75),
	('DoctrineMigrations\\Version20231114162421', '2023-11-14 16:24:26', 140);

-- Listage de la structure de table projet. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table projet. personne
CREATE TABLE IF NOT EXISTS `personne` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudo` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `is_educateur` tinyint(1) DEFAULT NULL,
  `description_educateur` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_FCEC9EFE7927C74` (`email`),
  UNIQUE KEY `UNIQ_FCEC9EF86CC499D` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.personne : ~3 rows (environ)
INSERT INTO `personne` (`id`, `email`, `pseudo`, `roles`, `password`, `date_creation`, `description`, `is_educateur`, `description_educateur`) VALUES
	(1, 'coco@gmail.com', 'coco', '["ROLE_SUPER_ADMIN"]', '$2y$13$EfjDykRYy8LuDUoIx/Fp.uKGENqPa6rH9AhUtuy.3EKR7.BZAhIvS', '2023-11-09 11:11:09', NULL, 0, NULL),
	(4, 'coco2@gmail.com', 'coco2', '["ROLE_USER"]', '$2y$13$ViEr/QnTD1KxmHPOwaEni.PSITH6r6E2/YH1J5XWBa99SDyQ1QATy', '2023-11-14 08:15:50', NULL, 1, 'best dog trainer world'),
	(6, 'coco3@gmail.com', 'coco3', '[]', '$2y$13$HCE.A.5A8/qz6RPjHF.sieqcMr7Zf9WrMNFh7wqwqYjWst1VlWDFS', '2023-11-14 15:07:31', NULL, 1, NULL);

-- Listage de la structure de table projet. post
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `topic_id` int NOT NULL,
  `auteur_id` int DEFAULT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5A8A6C8D1F55203D` (`topic_id`),
  KEY `IDX_5A8A6C8D60BB6FE6` (`auteur_id`),
  CONSTRAINT `FK_5A8A6C8D1F55203D` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id`),
  CONSTRAINT `FK_5A8A6C8D60BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `personne` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.post : ~6 rows (environ)
INSERT INTO `post` (`id`, `topic_id`, `auteur_id`, `contenu`, `date_creation`) VALUES
	(1, 3, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', '2023-11-09 18:01:55'),
	(3, 4, NULL, 'hellololololololo', '2023-11-12 17:56:53'),
	(4, 4, 1, 'hopla réchime Miss Dahlias quam, blottkopf, hoplageiss tristique baeckeoffe leo in, geïz gal hopla ftomi!', '2023-11-14 13:32:56'),
	(5, 3, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut.', '2023-11-14 14:11:00'),
	(6, 4, 4, 'Exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2023-11-14 14:11:42'),
	(7, 4, 6, 'idghizehiugsrdhfgsdf', '2023-11-14 15:14:05'),
	(8, 3, 4, 'hahahahahahahahahahahahahhahaha', '2023-11-14 17:36:03');

-- Listage de la structure de table projet. seance
CREATE TABLE IF NOT EXISTS `seance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `organisateur_id` int NOT NULL,
  `nom` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_heure_depart` datetime NOT NULL,
  `ville` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `theme_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DF7DFD0ED936B2FA` (`organisateur_id`),
  KEY `IDX_DF7DFD0E59027487` (`theme_id`),
  CONSTRAINT `FK_DF7DFD0E59027487` FOREIGN KEY (`theme_id`) REFERENCES `theme` (`id`),
  CONSTRAINT `FK_DF7DFD0ED936B2FA` FOREIGN KEY (`organisateur_id`) REFERENCES `personne` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.seance : ~1 rows (environ)
INSERT INTO `seance` (`id`, `organisateur_id`, `nom`, `date_heure_depart`, `ville`, `description`, `theme_id`) VALUES
	(2, 4, 'seance du siècle', '2023-12-12 14:00:00', 'Strasbourg', 'Lorem Elsass ipsum Richard Schirmeck Kabinetpapier nullam leverwurscht Heineken und blottkopf, pellentesque tchao bissame merci vielmols dui salu libero. jetz gehts los sed gal baeckeoffe id, Huguette Miss Dahlias Spätzle wurscht messti de Bischheim sit schneck bredele ornare Racing. amet hopla vielmols, Oberschaeffolsheim Strasbourg dolor sit DNA, hoplageiss auctor, risus, s\'guelt geht\'s placerat habitant geïz senectus rossbolla non non sed nüdle elit hopla Salu bissame Chulien semper in, gravida id kartoffelsalad vulputate ac Verdammi quam. commodo ftomi!', NULL),
	(3, 4, 'Training session', '2023-11-20 18:30:00', 'London', NULL, 2);

-- Listage de la structure de table projet. seance_personne
CREATE TABLE IF NOT EXISTS `seance_personne` (
  `seance_id` int NOT NULL,
  `personne_id` int NOT NULL,
  PRIMARY KEY (`seance_id`,`personne_id`),
  KEY `IDX_E3754997E3797A94` (`seance_id`),
  KEY `IDX_E3754997A21BD112` (`personne_id`),
  CONSTRAINT `FK_E3754997A21BD112` FOREIGN KEY (`personne_id`) REFERENCES `personne` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_E3754997E3797A94` FOREIGN KEY (`seance_id`) REFERENCES `seance` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.seance_personne : ~0 rows (environ)

-- Listage de la structure de table projet. theme
CREATE TABLE IF NOT EXISTS `theme` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.theme : ~7 rows (environ)
INSERT INTO `theme` (`id`, `nom`) VALUES
	(1, 'Medical Training'),
	(2, 'Socializing'),
	(3, 'Leash Training'),
	(4, 'Basic Commands'),
	(5, 'Reactivity'),
	(6, 'House Training'),
	(7, 'Potty Training');

-- Listage de la structure de table projet. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categorie_id` int NOT NULL,
  `auteur_id` int DEFAULT NULL,
  `titre` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9D40DE1BBCF5E72D` (`categorie_id`),
  KEY `IDX_9D40DE1B60BB6FE6` (`auteur_id`),
  CONSTRAINT `FK_9D40DE1B60BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `personne` (`id`),
  CONSTRAINT `FK_9D40DE1BBCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.topic : ~3 rows (environ)
INSERT INTO `topic` (`id`, `categorie_id`, `auteur_id`, `titre`, `date_creation`) VALUES
	(1, 2, 1, 'my dog eats my shoes', '2023-11-09 17:50:28'),
	(3, 2, 1, 'my dog eats my food ', '2023-11-09 17:51:18'),
	(4, 2, NULL, 'hello', '2023-11-12 17:56:44');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
