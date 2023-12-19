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
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ville` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_heure_depart` datetime NOT NULL,
  `organisateur_id` int NOT NULL,
  `point_longitude` decimal(15,12) DEFAULT NULL,
  `point_latitude` decimal(15,12) DEFAULT NULL,
  `topic_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_540083D71F55203D` (`topic_id`),
  KEY `IDX_540083D7D936B2FA` (`organisateur_id`),
  CONSTRAINT `FK_540083D71F55203D` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id`),
  CONSTRAINT `FK_540083D7D936B2FA` FOREIGN KEY (`organisateur_id`) REFERENCES `personne` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.balade : ~2 rows (environ)
INSERT INTO `balade` (`id`, `nom`, `description`, `ville`, `date_heure_depart`, `organisateur_id`, `point_longitude`, `point_latitude`, `topic_id`) VALUES
	(13, 'Balade à la Citadelle', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nemo eum possimus aperiam necessitatibus minus perspiciatis, quae, expedita, odit labore recusandae reiciendis est rem. Obcaecati hic temporibus, ipsa exercitationem aut sunt!', 'Strasbourg', '2023-12-20 15:00:00', 1, 7.776000000000, 48.575000000000, 8),
	(14, 'Balade à la Meinau', NULL, 'Strasbourg', '2024-01-16 16:00:00', 1, 7.754791975021, 48.557435400052, 20);

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

-- Listage des données de la table projet.balade_personne : ~2 rows (environ)
INSERT INTO `balade_personne` (`balade_id`, `personne_id`) VALUES
	(13, 4),
	(13, 6);

-- Listage de la structure de table projet. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.categorie : ~7 rows (environ)
INSERT INTO `categorie` (`id`, `nom`) VALUES
	(1, 'Health'),
	(2, 'Behaviour'),
	(3, 'Food'),
	(4, 'News'),
	(5, 'Site'),
	(6, 'Walks'),
	(7, 'Sessions');

-- Listage de la structure de table projet. chien
CREATE TABLE IF NOT EXISTS `chien` (
  `id` int NOT NULL AUTO_INCREMENT,
  `personne_id` int NOT NULL,
  `nom` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_naissance` date NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `date_actualisation` datetime NOT NULL,
  `races` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_13A4067EA21BD112` (`personne_id`),
  CONSTRAINT `FK_13A4067EA21BD112` FOREIGN KEY (`personne_id`) REFERENCES `personne` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.chien : ~5 rows (environ)
INSERT INTO `chien` (`id`, `personne_id`, `nom`, `image_name`, `date_naissance`, `description`, `date_actualisation`, `races`) VALUES
	(2, 1, 'Harlem', 'img-20220724-100308-655631eb82b47611926708.jpg', '2016-02-12', 'A 45kg Bernese Montain Dog x Border Collie Mix.\r\n\r\nHe is very friendly and gentle giant who\'s never had any problems with other dogs.\r\n\r\nHis favourite thing in life is to play with a ball.', '2023-11-23 14:40:33', '["bouvier", "collie border"]'),
	(3, 1, 'Boomer', 'img-20220828-180548-655632b47f2e0061526150.jpg', '2016-04-01', 'Nipperkin Jack Tar draft carouser strike colors Blimey yo-ho-ho snow no prey, no pay pink. Code of conduct fire in the hole salmagundi list interloper booty careen', '2023-12-19 15:07:18', '["collie border"]'),
	(4, 1, 'Lilas', 'microsoftteams-image-6555d3e81b514633237082.png', '2019-02-14', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Suscipit id enim dolorum aliquid animi voluptate distinctio iste expedita. Quae praesentium ut eius.', '2023-12-19 15:06:59', '["malinois"]'),
	(9, 4, 'Burtono', 'mastiff-english-65535721a08d3904027177.jpg', '2018-05-12', NULL, '2023-11-14 17:13:18', NULL),
	(10, 6, 'Trevor', 'beagle-adult-65538deff26f5295072921.jpg', '2019-02-12', NULL, '2023-11-14 15:10:39', NULL),
	(11, 4, 'Joy', 'setter-gordon-6553ab19d4669759752159.jpg', '2023-05-18', NULL, '2023-11-14 17:15:05', NULL),
	(19, 8, 'Charly', 'n02113186-9116-655c7928502bc282301323.jpg', '2014-01-12', NULL, '2023-11-21 09:32:24', '["corgi cardigan"]');

-- Listage de la structure de table projet. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table projet.doctrine_migration_versions : ~15 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20231116080020', '2023-11-16 08:00:30', 38),
	('DoctrineMigrations\\Version20231116082144', '2023-11-16 08:21:49', 18),
	('DoctrineMigrations\\Version20231116084522', '2023-11-16 08:45:29', 21),
	('DoctrineMigrations\\Version20231116084936', '2023-11-16 08:49:39', 52),
	('DoctrineMigrations\\Version20231116091003', '2023-11-16 09:10:08', 42),
	('DoctrineMigrations\\Version20231116124734', '2023-11-16 12:47:45', 240),
	('DoctrineMigrations\\Version20231116131823', '2023-11-16 13:18:28', 128),
	('DoctrineMigrations\\Version20231116150714', '2023-11-16 15:07:19', 40),
	('DoctrineMigrations\\Version20231116155300', '2023-11-16 15:53:03', 104),
	('DoctrineMigrations\\Version20231116161347', '2023-11-16 16:13:50', 38),
	('DoctrineMigrations\\Version20231116162508', '2023-11-16 16:25:10', 29),
	('DoctrineMigrations\\Version20231116171238', '2023-11-16 17:12:41', 31),
	('DoctrineMigrations\\Version20231116174428', '2023-11-16 17:44:36', 91),
	('DoctrineMigrations\\Version20231124150534', '2023-11-24 15:05:41', 168),
	('DoctrineMigrations\\Version20231208125408', '2023-12-08 12:54:16', 76),
	('DoctrineMigrations\\Version20231218100737', '2023-12-18 10:07:42', 163);

-- Listage de la structure de table projet. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.messenger_messages : ~0 rows (environ)
INSERT INTO `messenger_messages` (`id`, `body`, `headers`, `queue_name`, `created_at`, `available_at`, `delivered_at`) VALUES
	(1, 'O:36:\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\":2:{s:44:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\";a:1:{s:46:\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\";a:1:{i:0;O:46:\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\":1:{s:55:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\";s:21:\\"messenger.bus.default\\";}}}s:45:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\";O:51:\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\":2:{s:60:\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\";O:39:\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\":4:{i:0;s:30:\\"reset_password/email.html.twig\\";i:1;N;i:2;a:1:{s:10:\\"resetToken\\";O:58:\\"SymfonyCasts\\\\Bundle\\\\ResetPassword\\\\Model\\\\ResetPasswordToken\\":4:{s:65:\\"\\0SymfonyCasts\\\\Bundle\\\\ResetPassword\\\\Model\\\\ResetPasswordToken\\0token\\";s:40:\\"brIfKVhdAiAgHeWDbVKBoE37y2J4CHbk4zEwy3BM\\";s:69:\\"\\0SymfonyCasts\\\\Bundle\\\\ResetPassword\\\\Model\\\\ResetPasswordToken\\0expiresAt\\";O:17:\\"DateTimeImmutable\\":3:{s:4:\\"date\\";s:26:\\"2023-11-16 18:52:28.149096\\";s:13:\\"timezone_type\\";i:3;s:8:\\"timezone\\";s:3:\\"UTC\\";}s:71:\\"\\0SymfonyCasts\\\\Bundle\\\\ResetPassword\\\\Model\\\\ResetPasswordToken\\0generatedAt\\";i:1700157148;s:73:\\"\\0SymfonyCasts\\\\Bundle\\\\ResetPassword\\\\Model\\\\ResetPasswordToken\\0transInterval\\";i:1;}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\":2:{s:46:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\";a:3:{s:4:\\"from\\";a:1:{i:0;O:47:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\":5:{s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:4:\\"From\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";s:58:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\";a:1:{i:0;O:30:\\"Symfony\\\\Component\\\\Mime\\\\Address\\":2:{s:39:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\";s:24:\\"admin@projetcorentin.com\\";s:36:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\";s:19:\\"Projet Corentin Bot\\";}}}}s:2:\\"to\\";a:1:{i:0;O:47:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\":5:{s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:2:\\"To\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";s:58:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\";a:1:{i:0;O:30:\\"Symfony\\\\Component\\\\Mime\\\\Address\\":2:{s:39:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\";s:15:\\"coco2@gmail.com\\";s:36:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\";s:0:\\"\\";}}}}s:7:\\"subject\\";a:1:{i:0;O:48:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\":5:{s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:7:\\"Subject\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";s:55:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\";s:27:\\"Your password reset request\\";}}}s:49:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\";i:76;}i:1;N;}}}s:61:\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\";N;}}', '[]', 'default', '2023-11-16 17:52:28', '2023-11-16 17:52:28', NULL);

-- Listage de la structure de table projet. personne
CREATE TABLE IF NOT EXISTS `personne` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudo` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_educateur` tinyint(1) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `nom_image_profil` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_FCEC9EFE7927C74` (`email`),
  UNIQUE KEY `UNIQ_FCEC9EF86CC499D` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.personne : ~5 rows (environ)
INSERT INTO `personne` (`id`, `email`, `pseudo`, `roles`, `password`, `date_creation`, `description`, `is_educateur`, `last_login`, `nom_image_profil`) VALUES
	(1, 'coco@gmail.com', 'coco', '["ROLE_SUPER_ADMIN"]', '$2y$13$EfjDykRYy8LuDUoIx/Fp.uKGENqPa6rH9AhUtuy.3EKR7.BZAhIvS', '2023-11-09 11:11:09', 'Barkadeer bowsprit belay rum ballast quarter starboard splice the main brace cable galleon. Arr gun marooned Privateer provost pressgang gabion bucko gangplank shrouds. Buccaneer walk the plank chase Blimey jolly boat scourge of the seven seas jack hempen halter booty long boat.', 0, '2023-12-19 12:44:54', 'profile_picture_65564df36f900.jpg'),
	(4, 'coco2@gmail.com', 'coco2', '["ROLE_USER"]', '$2y$13$HFZiNPEiY8l4WNSaJ.jxsO3BZSXGZkfcixBncHR.ixoSGx67kI7WW', '2023-11-14 08:15:50', 'Lorem Elsass ipsum Heineken ullamcorper réchime morbi aliquam et id, Pfourtz ! turpis condimentum Christkindelsmärik eget semper risus, knepfle elementum eleifend ornare tchao bissame nullam schpeck lotto-owe blottkopf, tristique salu mänele hopla porta Gal. elit libero, flammekueche id consectetur ac Yo dû. in, adipiscing Oberschaeffolsheim Miss Dahlias purus hop ftomi!', 1, '2023-12-18 08:04:07', 'profile_picture_6557832648f1f.jpg'),
	(6, 'coco3@gmail.com', 'coco3', '[]', '$2y$13$HCE.A.5A8/qz6RPjHF.sieqcMr7Zf9WrMNFh7wqwqYjWst1VlWDFS', '2023-11-14 15:07:31', NULL, 1, '2023-12-18 09:54:09', 'profile_picture_655784a7da726.jpg'),
	(8, 'gertrude@exemple.com', 'geranium', '[]', '$2y$13$8Z6UeGIrPQ3cmcQvjl3TKOzzvKF6ov7ys/iapEMJ3nORWDu9rOvdK', '2023-11-21 09:06:07', NULL, 0, '2023-12-13 15:40:28', 'profile_picture_default.jpg'),
	(9, 'gerard@gmail.com', 'gege', '[]', '$2y$13$jomHlbhIQx2gLNqNy94UYeXvXI1lDpRdoNVXIX7lxvYY3LftpI4Ui', '2023-12-18 11:05:43', NULL, 0, '2023-12-18 11:05:43', 'profile_picture_default.jpg');

-- Listage de la structure de table projet. post
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `topic_id` int NOT NULL,
  `auteur_id` int DEFAULT NULL,
  `contenu` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `last_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5A8A6C8D1F55203D` (`topic_id`),
  KEY `IDX_5A8A6C8D60BB6FE6` (`auteur_id`),
  CONSTRAINT `FK_5A8A6C8D1F55203D` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id`),
  CONSTRAINT `FK_5A8A6C8D60BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `personne` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.post : ~31 rows (environ)
INSERT INTO `post` (`id`, `topic_id`, `auteur_id`, `contenu`, `date_creation`, `last_modified`) VALUES
	(1, 3, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', '2023-11-09 18:01:55', NULL),
	(3, 4, NULL, 'hellololololololo', '2023-11-12 17:56:53', NULL),
	(4, 4, 1, 'hopla réchime Miss Dahlias quam, blottkopf, hoplageiss tristique baeckeoffe leo in, geïz gal hopla ftomi!', '2023-11-23 13:45:54', '2023-12-13 10:38:29'),
	(5, 3, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut.', '2023-11-14 14:11:00', NULL),
	(6, 4, 4, 'Exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2023-11-14 14:11:42', NULL),
	(8, 3, 1, 'qsqztsedrftgy', '2023-12-08 10:09:28', NULL),
	(10, 12, 1, 'Etiam rhoeruncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. \r\nNam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. \r\n\r\nDonec vitae sapien ut libero venenatis faucibus. \r\nNullam quis ante.', '2023-11-23 12:32:51', '2023-12-12 10:28:41'),
	(12, 12, 4, 'Gal. kuglopf Hans ante salu habitant hopla Kabinetpapier varius schneck wurscht météor Coopé de Truchtersheim Wurschtsalad dui mollis hopla Oberschaeffolsheim  Yo dû. non aliquam ornare picon bière libero. consectetur gravida flammekueche ullamcorper Christkindelsmärik ornvare ac condimentum und s\'guelt hopla Heineken risusare', '2023-11-23 16:21:35', NULL),
	(13, 11, 1, 'rthre', '2023-12-08 09:33:24', NULL),
	(15, 8, 1, '£¨PKIPM¨%', '2023-12-08 10:20:17', NULL),
	(30, 3, 1, 'fckthisshit', '2023-12-08 10:37:03', NULL),
	(31, 11, 1, 'ery', '2023-12-08 10:38:26', NULL),
	(43, 21, 8, 'Coopé de Truchtersheim leo turpis, et bissame Salu bissame wie consectetur habitant Kabinetpapier ch\'ai sagittis auctor, leo hoplageiss Wurschtsalad schpeck porta Strasbourg Oberschaeffolsheim knack dui lacus mänele rossbolla id messti de Bischheim amet ornare ac hopla schnaps Carola quam. yeuh.', '2023-12-13 15:41:51', NULL),
	(44, 22, 8, 'Gal. leverwurscht picon bière nullam suspendisse s\'guelt mänele hopla sit eleifend Oberschaeffolsheim dignissim condimentum kuglopf sed', '2023-12-13 15:48:06', NULL),
	(45, 23, 8, 'Richard Schirmeck eleifend wurscht elit quam, ch\'ai nüdle tellus Yo dû. hop Heineken pellentesque sit nullam placerat turpis adipiscing Morbi Coopé de Truchtersheim senectus Oberschaeffolsheim barapli tristique schpeck hopla leverwurscht und dui knack bredele vielmols, Wurschtsalad ante Carola kougelhopf ac Salu bissame et yeuh.', '2023-12-13 15:48:57', NULL),
	(46, 24, NULL, 'My partner was about to get himself shot. I intervened. He was angry because those two dealers of yours had just murdered an eleven year-old boy. Then again, maybe he thought it was you who gave the order. \r\n\r\nHe has enough money to last forever. He knows he needs to keep moving. You\'ll never find him. He\'s out of the picture. I saved his life, I owed him that, but now he and I are done. Which is exactly what you wanted, isn\'t it. You\'ve always struck me as a very pragmatic man so if I may, I would like to review options with you. Of which, it seems to me you have two.', '2023-12-13 15:52:42', NULL),
	(47, 25, NULL, 'Now that there is the Tec-9, a crappy spray gun from South Miami. This gun is advertised as the most popular gun in American crime. Do you believe that shit? It actually says that in the little book that comes with it: the most popular gun in American crime. Like they\'re actually proud of that shit.', '2023-12-13 15:55:32', NULL),
	(48, 26, 4, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Saepe eligendi nobis iusto nesciunt excepturi dolore pariatur, totam provident quasi quod vitae, neque eius? Dolorem similique officiis accusantium expedita praesentium fugit?', '2023-12-14 07:38:14', NULL),
	(49, 27, 4, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis ipsa, reprehenderit quaerat dolorem debitis temporibus, asperiores nesciunt cupiditate, recusandae modi harum in tempora officiis esse quidem ad itaque fugiat porro.', '2023-12-14 07:39:11', NULL),
	(50, 28, 4, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo qui laboriosam officia sequi quaerat ad dolorum sapiente consequatur quo nulla perspiciatis impedit reiciendis rem culpa error, ab illo neque. Fuga!', '2023-12-14 07:41:10', NULL),
	(51, 29, 6, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis reprehenderit deleniti esse beatae in provident, aliquam alias a autem sunt hic aperiam, impedit sit quas. Repellat saepe omnis neque aspernatur?', '2023-12-14 07:43:32', NULL),
	(52, 31, 6, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta totam, natus, nobis aperiam, nesciunt tenetur esse aliquam sunt porro similique eligendi ipsum distinctio placeat ut possimus mollitia eos itaque adipisci?', '2023-12-14 07:46:07', NULL),
	(53, 4, 1, 'Careen no prey, no pay Arr fire ship landlubber or just lubber barque execution dock Pirate Round skysail Pieces of Eight. Plate Fleet careen pinnace weigh anchor provost cable salmagundi gunwalls draught main sheet. Splice the main brace Yellow Jack rigging coxswain main sheet Buccaneer snow Admiral of the Black list fluke.', '2023-12-15 10:11:58', NULL),
	(54, 4, 1, 'Killick belay bring a spring upon her cable bilge water knave hearties lugsail reef spyglass grog. Jack transom hornswaggle loot line scuppers rutters landlubber or just lubber Buccaneer doubloon. Gally nipperkin dead men tell no tales prow bilge rat fire in the hole grapple swab provost squiffy.', '2023-12-15 10:12:09', NULL),
	(55, 4, 1, 'Gally reef sails spike yawl crack Jennys tea cup clap of thunder gangplank scourge of the seven seas quarter rigging.', '2023-12-15 10:12:47', NULL),
	(56, 4, 1, 'Holystone keelhaul fore barque Admiral of the Black jack gangplank gaff execution dock deadlights. Marooned six pounders killick sutler weigh anchor long boat loaded to the gunwalls Chain Shot square-rigged scourge of the seven seas.', '2023-12-15 10:12:58', NULL),
	(57, 4, 1, 'Cat o\'nine tails cable yo-ho-ho come about furl coxswain heave down log mizzenmast black jack. Hardtack league dead men tell no tales grapple driver jury mast yard quarter chase gabion.', '2023-12-15 10:13:26', NULL),
	(58, 4, 1, 'Code of conduct draft keelhaul long clothes Blimey lass pinnace tack landlubber or just lubber Shiver me timbers.', '2023-12-15 10:13:38', NULL),
	(59, 4, 1, 'Blimey rutters gibbet hulk tack tender code of conduct spike keelhaul Arr.', '2023-12-15 10:13:57', NULL),
	(61, 34, 1, 'Nipperkin Jack Tar draft carouser strike colors Blimey yo-ho-ho snow no prey, no pay pink. Code of conduct fire in the hole salmagundi list interloper booty careen Corsair trysail coxswain. Transom squiffy pillage killick cackle fruit bilge rat cog black jack dead men tell no tales wherry.', '2023-12-15 13:27:41', '2023-12-15 13:40:16');

-- Listage de la structure de table projet. report
CREATE TABLE IF NOT EXISTS `report` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post_id` int NOT NULL,
  `reporter_id` int NOT NULL,
  `reason` longtext COLLATE utf8mb4_unicode_ci,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C42F77844B89032C` (`post_id`),
  KEY `IDX_C42F7784E1CFE6F5` (`reporter_id`),
  CONSTRAINT `FK_C42F77844B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  CONSTRAINT `FK_C42F7784E1CFE6F5` FOREIGN KEY (`reporter_id`) REFERENCES `personne` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.report : ~0 rows (environ)

-- Listage de la structure de table projet. reset_password_request
CREATE TABLE IF NOT EXISTS `reset_password_request` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `selector` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_7CE748AA76ED395` (`user_id`),
  CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `personne` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.reset_password_request : ~1 rows (environ)
INSERT INTO `reset_password_request` (`id`, `user_id`, `selector`, `hashed_token`, `requested_at`, `expires_at`) VALUES
	(6, 1, 'scz6wXAqewJe4UfUJO4z', 'z8p3RwDGgVyBWgFos0pi1FSLnHD6j0xR0Pj4+L7rshE=', '2023-12-15 12:59:28', '2023-12-15 13:59:28');

-- Listage de la structure de table projet. seance
CREATE TABLE IF NOT EXISTS `seance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `organisateur_id` int NOT NULL,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_heure_depart` datetime NOT NULL,
  `ville` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `theme_id` int DEFAULT NULL,
  `point_latitude` decimal(15,12) DEFAULT NULL,
  `point_longitude` decimal(15,12) DEFAULT NULL,
  `topic_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_DF7DFD0E1F55203D` (`topic_id`),
  KEY `IDX_DF7DFD0ED936B2FA` (`organisateur_id`),
  KEY `IDX_DF7DFD0E59027487` (`theme_id`),
  CONSTRAINT `FK_DF7DFD0E1F55203D` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id`),
  CONSTRAINT `FK_DF7DFD0E59027487` FOREIGN KEY (`theme_id`) REFERENCES `theme` (`id`),
  CONSTRAINT `FK_DF7DFD0ED936B2FA` FOREIGN KEY (`organisateur_id`) REFERENCES `personne` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.seance : ~2 rows (environ)
INSERT INTO `seance` (`id`, `organisateur_id`, `nom`, `date_heure_depart`, `ville`, `description`, `theme_id`, `point_latitude`, `point_longitude`, `topic_id`) VALUES
	(5, 4, 'Central Park Medical Training', '2024-01-10 18:00:00', 'New York', NULL, 1, 40.789475261829, -73.957573954182, 6),
	(6, 6, 'Travailler sur les ordres de bases', '2024-01-19 15:00:00', 'Strasbourg', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium praesentium veritatis, eius esse iusto similique saepe fugiat dolores illum pariatur alias harum voluptas. Natus quia placeat quos asperiores! Aspernatur, recusandae.', 4, 48.568031547389, 7.800164222717, 32);

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

-- Listage des données de la table projet.seance_personne : ~2 rows (environ)
INSERT INTO `seance_personne` (`seance_id`, `personne_id`) VALUES
	(5, 1),
	(5, 6);

-- Listage de la structure de table projet. theme
CREATE TABLE IF NOT EXISTS `theme` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `last_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9D40DE1BBCF5E72D` (`categorie_id`),
  KEY `IDX_9D40DE1B60BB6FE6` (`auteur_id`),
  CONSTRAINT `FK_9D40DE1B60BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `personne` (`id`),
  CONSTRAINT `FK_9D40DE1BBCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table projet.topic : ~23 rows (environ)
INSERT INTO `topic` (`id`, `categorie_id`, `auteur_id`, `titre`, `date_creation`, `last_modified`) VALUES
	(1, 2, 1, 'my dog eats my shoes', '2023-11-09 17:50:28', NULL),
	(3, 2, 1, 'my dog eats my food ', '2023-11-09 17:51:18', NULL),
	(4, 2, NULL, 'hello', '2023-11-12 17:56:44', NULL),
	(6, 7, 4, '[DISCUSSION] Central Park Medical Training', '2023-11-16 13:20:58', NULL),
	(8, 6, 1, '[DISCUSSION] Balade à la Citadelle', '2023-11-17 08:23:03', NULL),
	(9, 5, 1, 'test', '2023-11-23 13:48:18', '2023-12-08 15:45:03'),
	(11, 2, 1, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.', '2023-11-23 08:08:15', NULL),
	(12, 2, 1, 'Convallis aenean et tortor at. Lobortis mattis aliquam faucibus purus in massa tempor nec.', '2023-11-23 09:51:09', NULL),
	(20, 6, 1, '[DISCUSSION] Balade à la Meinau', '2023-12-13 08:23:50', NULL),
	(21, 3, 8, 'Lorem Elsass ipsum flammekueche nüdle condimentum hopla libero', '2023-12-13 15:41:19', NULL),
	(22, 1, 8, 'Salut bisamme Oberschaeffolsheim picon bière Christkindelsmärik Heineken Spätzle', '2023-12-13 15:47:46', NULL),
	(23, 5, 8, 'Morbi Spätzle auctor, ch\'ai Strasbourg wurscht ullamcorper tristique chambon sit', '2023-12-13 15:48:41', NULL),
	(24, 4, NULL, 'The blowfish puffs himself up four, five times larger than normal and why? Why does he do that? So that it makes him intimidating, that\'s why. Intimidating!', '2023-12-13 15:52:16', NULL),
	(25, 3, NULL, 'Your bones don\'t break, mine do. That\'s clear. Your cells react to bacteria and viruses differently than mine. You don\'t get sick, I do. That\'s also clear.', '2023-12-13 15:55:11', NULL),
	(26, 4, 4, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit.', '2023-12-14 07:38:03', NULL),
	(27, 1, 4, 'Officiis esse quidem ad itaque fugiat porro.', '2023-12-14 07:39:03', NULL),
	(28, 3, 4, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur facilis quas eius est, error aspernatur! Rem cumque iure et non molestias repudiandae similique! Dolor odit dignissimos deserunt quaerat, nesciunt distinctio.', '2023-12-14 07:40:18', NULL),
	(29, 1, 6, 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', '2023-12-14 07:43:19', NULL),
	(30, 5, 6, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis reprehenderit deleniti esse beatae in provident, aliquam alias a autem sunt hic aperiam, impedit sit quas. Repellat saepe omnis neque aspernatur?', '2023-12-14 07:44:53', NULL),
	(31, 4, 6, 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', '2023-12-14 07:46:00', NULL),
	(32, 7, 6, '[DISCUSSION] Travailler sur les ordres de bases', '2023-12-14 08:14:35', NULL),
	(33, 5, 6, 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Assumenda, tenetur fuga. Consequatur debitis rem distinctio', '2023-12-14 09:08:40', NULL),
	(34, 2, 6, 'Carola elit rucksack gal dignissim salu Hans réchime Gal ! Wurschtsalad porta munster yeuh. semper nüdle bissame mollis wurscht geht\'s Oberschaeffolsheim sit ftomi!', '2023-12-14 10:33:25', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
