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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.chien : ~0 rows (environ)
INSERT INTO `chien` (`id`, `personne_id`, `nom`, `image_name`, `date_naissance`, `description`, `date_actualisation`) VALUES
	(2, 1, 'harlem', 'img-20220724-100308-654cd877e51d8679592298.jpg', '2016-02-12', NULL, '2023-11-09 13:02:47'),
	(3, 1, 'boomer', 'img-20220828-180548-654cdb1b7b442503021540.jpg', '2016-04-01', NULL, '2023-11-09 13:14:03'),
	(4, 1, 'lilas', 'img-20221228-163206-654cdb3b0a5ae901954140.jpg', '2019-02-14', NULL, '2023-11-09 14:35:41');

-- Listage de la structure de table projet. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table projet.doctrine_migration_versions : ~1 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20231109110955', '2023-11-09 11:10:02', 289);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.personne : ~0 rows (environ)
INSERT INTO `personne` (`id`, `email`, `pseudo`, `roles`, `password`, `date_creation`, `description`, `is_educateur`, `description_educateur`) VALUES
	(1, 'coco@gmail.com', 'coco', '[]', '$2y$13$EfjDykRYy8LuDUoIx/Fp.uKGENqPa6rH9AhUtuy.3EKR7.BZAhIvS', '2023-11-09 11:11:09', NULL, 0, NULL);

-- Listage de la structure de table projet. post
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `topic_id` int NOT NULL,
  `auteur_id` int NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5A8A6C8D1F55203D` (`topic_id`),
  KEY `IDX_5A8A6C8D60BB6FE6` (`auteur_id`),
  CONSTRAINT `FK_5A8A6C8D1F55203D` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id`),
  CONSTRAINT `FK_5A8A6C8D60BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `personne` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.post : ~1 rows (environ)
INSERT INTO `post` (`id`, `topic_id`, `auteur_id`, `contenu`, `date_creation`) VALUES
	(1, 3, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', '2023-11-09 18:01:55');

-- Listage de la structure de table projet. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categorie_id` int NOT NULL,
  `auteur_id` int NOT NULL,
  `titre` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9D40DE1BBCF5E72D` (`categorie_id`),
  KEY `IDX_9D40DE1B60BB6FE6` (`auteur_id`),
  CONSTRAINT `FK_9D40DE1B60BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `personne` (`id`),
  CONSTRAINT `FK_9D40DE1BBCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.topic : ~3 rows (environ)
INSERT INTO `topic` (`id`, `categorie_id`, `auteur_id`, `titre`, `date_creation`) VALUES
	(1, 2, 1, 'my dog eats my shoes', '2023-11-09 17:50:28'),
	(2, 2, 1, 'my dog eats my socks', '2023-11-09 17:50:52'),
	(3, 2, 1, 'my dog eats my food ', '2023-11-09 17:51:18');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
