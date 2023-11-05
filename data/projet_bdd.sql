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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.categorie : ~0 rows (environ)

-- Listage de la structure de table projet. chien
CREATE TABLE IF NOT EXISTS `chien` (
  `id` int NOT NULL AUTO_INCREMENT,
  `personne_id` int NOT NULL,
  `nom` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_de_naissance` date NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_13A4067EA21BD112` (`personne_id`),
  CONSTRAINT `FK_13A4067EA21BD112` FOREIGN KEY (`personne_id`) REFERENCES `personne` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.chien : ~0 rows (environ)

-- Listage de la structure de table projet. chien_race
CREATE TABLE IF NOT EXISTS `chien_race` (
  `chien_id` int NOT NULL,
  `race_id` int NOT NULL,
  PRIMARY KEY (`chien_id`,`race_id`),
  KEY `IDX_5B5D7EE8BFCF400E` (`chien_id`),
  KEY `IDX_5B5D7EE86E59D40D` (`race_id`),
  CONSTRAINT `FK_5B5D7EE86E59D40D` FOREIGN KEY (`race_id`) REFERENCES `race` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_5B5D7EE8BFCF400E` FOREIGN KEY (`chien_id`) REFERENCES `chien` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.chien_race : ~0 rows (environ)

-- Listage de la structure de table projet. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table projet.doctrine_migration_versions : ~0 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20231020095552', '2023-10-20 09:56:19', 447),
	('DoctrineMigrations\\Version20231105173354', '2023-11-05 17:34:11', 298);

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
  `pseudo` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `is_educateur` tinyint(1) NOT NULL,
  `description_educateur` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_FCEC9EF86CC499D` (`pseudo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.personne : ~0 rows (environ)

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.post : ~0 rows (environ)

-- Listage de la structure de table projet. race
CREATE TABLE IF NOT EXISTS `race` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.race : ~0 rows (environ)

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.topic : ~0 rows (environ)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
