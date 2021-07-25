-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.24-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for blog_project
CREATE DATABASE IF NOT EXISTS `blog_project` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `blog_project`;

-- Dumping structure for table blog_project.articles
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(200) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(300) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- Dumping data for table blog_project.articles: ~12 rows (approximately)
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` (`id`, `slug`, `title`, `image`, `category_id`, `user_id`, `description`) VALUES
	(1, 'slug1', 'Kachin State', 'assets/article/k8.jpg', 1, 1, 'Kachin State is the northernmost state of Myanmar. It is bordered by China to the north and east; Shan State to the south; and Sagaing Region and India to the west. It lies between north latitude 23° 27\' and 28° 25\' longitude 96° 0\' and 98° 44\'. The area of Kachin State is 89,041 km².'),
	(7, 'inle lake-1627049373', 'Inle Lake', 'assets/article/inle1.jpg', 1, 2, 'Inle Lake is in the Shan Hills of Myanmar. At its southwestern edge, Phaung Daw Oo Paya is a tiered pagoda with gilded Buddha statues. In the hills, near the market town of Indein, the stupas of Shwe Inn Dein Pagoda resemble a field of gold spires. The ruined stupas at nearby Nyaung Ohak have been reclaimed by forest. Maing Thauk village is split between land and water, with a wooden bridge connecting the two halves.'),
	(8, 'myanmar country-1627135947', 'Myanmar Country', 'assets/article/flag.jpg', 1, 1, 'Myanmar (formerly Burma) is a Southeast Asian nation of more than 100 ethnic groups, bordering India, Bangladesh, China, Laos and Thailand. Yangon (formerly Rangoon), the country\'s largest city, is home to bustling markets, numerous parks and lakes, and the towering, gilded Shwedagon Pagoda, which contains Buddhist relics and dates to the 6th century.'),
	(9, 'yangon-1627051440', 'Yangon', 'assets/article/shwedagonpagoda.jpg', 1, 3, 'Yangon (formerly known as Rangoon) is the largest city in Myanmar (formerly Burma). A mix of British colonial architecture, modern high-rises and gilded Buddhist pagodas define its skyline. Its famed Shwedagon Paya, a huge, shimmering pagoda complex, draws thousands of pilgrims annually. The city\'s other notable religious sites include the Botataung and Sule pagodas, both housing Buddhist'),
	(10, 'elephant dance festival-1627135984', 'Elephant Dance Festival', 'assets/article/elephantdancefestival.jpg', 1, 4, 'Since the days of King Anawratha, Kyaukse town upon Shwethalyaung Hill has celebrated the elephant dance festival. Traditionally locals don a colourfully decorated, life-size elephant costume, welcoming the end of Thadingyut with a unique array of dance and acrobats. The festival is held every year on the day before full moon day of Thadingut with a total of 29 elephants gracing the stage â€“ 17 traditional, six sequined, and six baby elephants, according to the committee.'),
	(12, 'thanintharyi-1627051635', 'Thanintharyi', 'assets/article/t4.jpg', 1, 5, 'Tanintharyi Region is an administrative region of Myanmar, covering the long narrow southern part of the country on the Kra Isthmus. It borders the Andaman Sea to the west and the Tenasserim Hills, beyond which lie Thailand, to the east. To the north is the Mon State.'),
	(14, 'rose flowers-1627102606', 'Rose Flowers', 'assets/article/Flower2.jpg', 1, 3, 'Rose flowers are the ....'),
	(19, 'php -1627135098', 'PHP ', 'assets/article/P.jpg', 2, 4, 'PHP'),
	(21, 'java-1627136012', 'Java', 'assets/article/J.jpg', 1, 4, 'Java is '),
	(22, 'c programming-1627136022', 'C Programming', 'assets/article/C.jpg', 2, 4, 'C Progarmming is'),
	(23, 'mandalay moat-1627136394', 'Mandalay Moat', 'assets/article/m3.jpg', 1, 7, 'Mandalay moat is the ancient capital of Myanmar Kings'),
	(24, 'u bein bridge-1627136457', 'U Bein Bridge', 'assets/article/m7.jpg', 1, 7, 'U Bein bridge is a crossing that spans the Taungthaman Lake.');
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;

-- Dumping structure for table blog_project.article_comments
CREATE TABLE IF NOT EXISTS `article_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `article_id` (`article_id`),
  CONSTRAINT `article_comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `article_comments_ibfk_2` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

-- Dumping data for table blog_project.article_comments: ~34 rows (approximately)
/*!40000 ALTER TABLE `article_comments` DISABLE KEYS */;
INSERT INTO `article_comments` (`id`, `user_id`, `article_id`, `comment`) VALUES
	(1, 2, 8, 'How miserable this country'),
	(2, 3, 9, 'I love this country'),
	(3, 3, 9, '@jisoo Hey! check it out'),
	(5, 5, 14, 'OMG PINK '),
	(6, 7, 14, 'Love is the flower you\'ve got to let grow...'),
	(7, 7, 14, 'Love is the flower you\'ve got to let grow...'),
	(10, 3, 12, 'Wow, how lovely is it...'),
	(12, 4, 14, 'OMG Roses'),
	(13, 4, 14, 'OMG Roses'),
	(14, 4, 14, 'Nice '),
	(15, 4, 19, 'Hey Is it a programming language?'),
	(16, 4, 19, 'Yes I know it is a programming Language'),
	(17, 4, 19, 'Comment ma pay chin vuu naw'),
	(18, 4, 12, 'It is a wonderful region'),
	(19, 4, 12, 'Let take\'s a breath'),
	(20, 4, 9, 'Hello It\'is so good to me'),
	(21, 4, 10, 'Elephant Dance Festival'),
	(22, 4, 10, 'Kyauk Se'),
	(23, 4, 9, 'Yangon I like it'),
	(24, 4, 9, 'hi'),
	(25, 4, 9, 'hiii'),
	(26, 4, 9, 'hiii'),
	(27, 4, 9, 'Hello It\'is so good to me'),
	(28, 4, 10, 'Hello It\'is so good to me'),
	(29, 4, 10, 'Hello It\'is so good to me'),
	(30, 4, 10, 'Elephant Dance Festival'),
	(31, 4, 10, 'Elephant Dance Festival'),
	(32, 4, 1, 'khaung yay thauk chin tl'),
	(33, 4, 1, 'Kachin it\'s lovely'),
	(34, 4, 1, 'mite tl kwr thwr chin tl'),
	(35, 7, 23, 'Hi this is my article'),
	(36, 7, 23, 'Let\'s take the route'),
	(37, 1, 24, 'Nice Place'),
	(38, 1, 23, 'I love it');
/*!40000 ALTER TABLE `article_comments` ENABLE KEYS */;

-- Dumping structure for table blog_project.article_languages
CREATE TABLE IF NOT EXISTS `article_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

-- Dumping data for table blog_project.article_languages: ~22 rows (approximately)
/*!40000 ALTER TABLE `article_languages` DISABLE KEYS */;
INSERT INTO `article_languages` (`id`, `language_id`, `article_id`) VALUES
	(1, 1, 1),
	(3, 1, 19),
	(5, 1, 9),
	(6, 1, 7),
	(7, 2, 7),
	(8, 2, 1),
	(9, 2, 14),
	(10, 2, 12),
	(13, 3, 12),
	(14, 3, 14),
	(19, 1, 8),
	(20, 3, 8),
	(21, 1, 10),
	(22, 2, 10),
	(23, 3, 10),
	(24, 2, 21),
	(25, 3, 22),
	(26, 1, 23),
	(27, 2, 23),
	(28, 3, 23),
	(29, 1, 24),
	(30, 2, 24);
/*!40000 ALTER TABLE `article_languages` ENABLE KEYS */;

-- Dumping structure for table blog_project.article_likes
CREATE TABLE IF NOT EXISTS `article_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `article_id` (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

-- Dumping data for table blog_project.article_likes: ~15 rows (approximately)
/*!40000 ALTER TABLE `article_likes` DISABLE KEYS */;
INSERT INTO `article_likes` (`id`, `user_id`, `article_id`) VALUES
	(20, 7, 1),
	(22, 1, 1),
	(23, 1, 4),
	(24, 1, 5),
	(27, 1, 7),
	(28, 1, 12),
	(30, 1, 10),
	(32, 2, 8),
	(33, 3, 9),
	(34, 3, 14),
	(36, 7, 14),
	(39, 3, 12),
	(40, 4, 14),
	(42, 4, 19),
	(43, 7, 23),
	(44, 1, 24),
	(45, 1, 23);
/*!40000 ALTER TABLE `article_likes` ENABLE KEYS */;

-- Dumping structure for table blog_project.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table blog_project.categories: ~2 rows (approximately)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `slug`, `name`) VALUES
	(1, 'slug1', 'Places'),
	(2, 'slug2', 'IT');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Dumping structure for table blog_project.languages
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(300) NOT NULL,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table blog_project.languages: ~2 rows (approximately)
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` (`id`, `slug`, `name`) VALUES
	(1, 'php', 'PHP'),
	(2, 'js', 'Javascript'),
	(3, 'linux', 'Linux');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;

-- Dumping structure for table blog_project.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `image` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table blog_project.users: ~7 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `slug`, `email`, `password`, `image`) VALUES
	(1, 'Kim Ji Soo Update', 'hpw-009', 'jisoo@gmail.com', '$2y$10$PX2ubnF/dWiQYpkqxQ1RHuK64W6kd1C3fapppuZ9zO5AFBLiXUGTO', 'assets/users/3.jpg'),
	(2, 'Sehun', 'aa-008', 'sehun@gmail.com', '$2y$10$PX2ubnF/dWiQYpkqxQ1RHuK64W6kd1C3fapppuZ9zO5AFBLiXUGTO', 'assets/users/sehun.jpg'),
	(3, 'Manoban La Lisa (Black Pink)', 'smmt-1500', 'lisa@gmail.com', '$2y$10$PX2ubnF/dWiQYpkqxQ1RHuK64W6kd1C3fapppuZ9zO5AFBLiXUGTO', 'assets/users/8.jpg'),
	(4, 'Jennie Kim', '4', 'jennie@gmail.com', '$2y$10$PX2ubnF/dWiQYpkqxQ1RHuK64W6kd1C3fapppuZ9zO5AFBLiXUGTO', 'assets/users/jennie.jpg'),
	(5, 'Harry Style ', '', 'harrystyle@gmail.com', '$2y$10$PX2ubnF/dWiQYpkqxQ1RHuK64W6kd1C3fapppuZ9zO5AFBLiXUGTO', 'assets/users/Harry1.jpg'),
	(7, 'Park Rosanne  Update', '', 'rose@gmail.com', '$2y$10$PX2ubnF/dWiQYpkqxQ1RHuK64W6kd1C3fapppuZ9zO5AFBLiXUGTO', 'assets/users/4.jpg');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
