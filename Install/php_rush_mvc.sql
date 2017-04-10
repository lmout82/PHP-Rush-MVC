-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 08, 2017 at 09:19 AM
-- Server version: 5.5.54-0+deb8u1
-- PHP Version: 5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `php_rush_mvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
`id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_modification` datetime NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'default.jpg'
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`, `category_id`, `user_id`, `creation_date`, `last_modification`, `image`) VALUES
(29, 'Ludo plonge en mer rouge', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris non tellus eu lacus pretium volutpat. Praesent rhoncus augue in diam varius, in semper dui elementum. Etiam nec leo in eros efficitur pharetra ac vel mi. Sed rutrum elit quis consectetur malesuada. Quisque dignissim sit amet massa hendrerit ornare. Nulla et porttitor magna. Integer vitae orci est.\r\n\r\nNam pulvinar, ante eu condimentum pharetra, enim justo dignissim libero, gravida euismod felis justo vitae sapien. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris vel arcu nulla. Donec vehicula euismod blandit. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer ut neque aliquam, volutpat purus vel, efficitur justo. Sed condimentum mauris at nisl euismod, pulvinar condimentum ipsum tempus. Aenean quis tincidunt mauris. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin congue augue est, at feugiat dolor posuere et.', 1, 2, '2017-04-07 18:04:00', '2017-04-07 20:03:58', '1491588238.jpg'),
(30, 'Ludo nous fait cadeau', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris non tellus eu lacus pretium volutpat. Praesent rhoncus augue in diam varius, in semper dui elementum. Etiam nec leo in eros efficitur pharetra ac vel mi. Sed rutrum elit quis consectetur malesuada. Quisque dignissim sit amet massa hendrerit ornare. Nulla et porttitor magna. Integer vitae orci est.\r\n\r\nNam pulvinar, ante eu condimentum pharetra, enim justo dignissim libero, gravida euismod felis justo vitae sapien. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris vel arcu nulla. Donec vehicula euismod blandit. Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer ut neque aliquam, volutpat purus vel, efficitur justo. Sed condimentum mauris at nisl euismod, pulvinar condimentum ipsum tempus. Aenean quis tincidunt mauris. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin congue augue est, at feugiat dolor posuere et.', 2, 2, '2017-04-07 18:09:43', '2017-04-07 20:09:41', '1491588581.jpg'),
(31, 'Ludo il bat Chuck Norris en apnÃ©e', 'Cette technique comporte trois problÃ¨mes. Tout dâ€™abord, vous devez fixer la taille en nombre de caractÃ¨res. Il va donc falloir y aller Ã  tÃ¢ton pour trouver la bonne mesure. Ce qui ne sera plus valable dÃ¨s quâ€™on changera la taille de la police, la taille du container, â€¦ DeuxiÃ¨mement, le contenu coupÃ© ne sera pas du tout affichÃ© sur la page. Cela pourrait cependant Ãªtre important de conserver le contenu en entier pour les robots des moteurs de recherche. Et enfin, dÃ¨s que votre texte contient des balises HTML, il y a de fortes chances pour que la coupure ne se fasse pas au bon endroit et vienne tout casser. Il faudrait alors envisager une fonction plus compliquÃ©e qui dÃ©couperait intelligemment en prenant en compte les balises. Pas chouette.', 1, 2, '2017-04-07 18:15:50', '2017-04-07 20:15:47', '1491588947.jpg'),
(32, 'Ludo il grossit pas et pourtant...', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris non tellus eu lacus pretium volutpat. Praesent rhoncus augue in diam varius, in semper dui elementum. Etiam nec leo in eros efficitur pharetra ac vel mi. Sed rutrum elit quis consectetur malesuada. Quisque dignissim sit amet massa hendrerit ornare. Nulla et porttitor magna. Integer vitae orci est.', 2, 2, '2017-04-07 18:17:22', '2017-04-07 20:17:20', '1491589040.jpg'),
(33, 'Ludo a rencontrÃ© Bob L''Eponge', 'Ludovic est un dÃ©rivÃ© du prÃ©nom Louis. Les racines germaniques de ce dernier, hlod- et -wig signifient "gloire" et "combat". Au fil des siÃ¨cles et des monarchies, le prÃ©nom est passÃ© de Hlodowig Ã  Louis. En fait, Ludovic figure parmi les nombreux avatars de Louis. Son histoire remonte au Moyen Ã‚ge. Ã€ l''Ã©poque, il Ã©tait rÃ©pertoriÃ© sous son ancienne forme Ludovicus dans plusieurs pays d''Europe, dont la France. MalgrÃ© tout, il est restÃ© dans l''ombre de Louis qui l''a empÃªchÃ© de connaÃ®tre la gloire jusqu''au XXe siÃ¨cle. En effet, Ludovic ne rÃ©ussit Ã  lui voler la vedette qu''Ã  partir des annÃ©es 1960. Il signa ainsi son plus vif succÃ¨s avec un pic de 6739 naissances en 1977 et s''est maintenu dans les rangs des prÃ©noms les plus populaires pendant plus de trente ans. Sa cote a nettement baissÃ© par la suite, mais Ludovic n''a pas quittÃ© la scÃ¨ne pour autant et son retour au premier plan est toujours possible.', 1, 2, '2017-04-07 18:19:54', '2017-04-07 20:19:52', '1491589192.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
`id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Plongee'),
(2, 'Chocolat');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
`id` int(11) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `publication_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `content`, `user_id`, `article_id`, `publication_date`) VALUES
(1, 'd hgd hgf gfj hgjf hnytdbgbtegd rg gbf', 2, 27, '2017-04-07 15:54:54'),
(2, 'd hgd hgf gfj hgjf hnytdbgbtegd rg gbf', 2, 27, '2017-04-07 15:57:31'),
(3, 'kjhfdskjhf kjdshfklsd f jdh kg lfhd  hg', 2, 27, '2017-04-07 15:57:40'),
(4, 'kjhfdskjhf kjdshfklsd f jdh kg lfhd  hg', 2, 27, '2017-04-07 16:00:16'),
(5, 'kjhfdskjhf kjdshfklsd f jdh kg lfhd  hg', 2, 27, '2017-04-07 16:01:59'),
(6, 'sdfgfdsfg fdsg fds gsfd', 2, 27, '2017-04-07 16:02:04'),
(7, 'T''as bien de la chance Ludo!', 2, 29, '2017-04-07 18:04:33'),
(8, 'T''as bien de la chance Ludo!', 2, 29, '2017-04-07 18:04:43'),
(9, 'T''as bien de la chance Ludo!', 2, 29, '2017-04-07 18:05:33'),
(10, 'Il triche il a des bouteilles!!!', 2, 31, '2017-04-07 18:16:11'),
(11, 'Il triche il a des bouteilles!!!', 2, 31, '2017-04-07 18:16:20'),
(12, 'ca c''est un super commentaire', 2, 33, '2017-04-07 20:43:42'),
(13, 'ca c''est un super commentaire', 2, 33, '2017-04-07 20:43:47'),
(14, 'test de ludo hihi', 10, 33, '2017-04-07 21:29:54'),
(15, 'encore un test', 10, 33, '2017-04-07 22:41:55'),
(16, 'dfds4ds685ds45ds', 10, 33, '2017-04-07 22:46:34');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tags_mapping`
--

CREATE TABLE IF NOT EXISTS `tags_mapping` (
  `article_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `group_name` varchar(10) NOT NULL DEFAULT 'registred',
  `is_banished` tinyint(1) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modification_date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `group_name`, `is_banished`, `creation_date`, `modification_date`) VALUES
(2, 'yann', '$2y$10$imjbLcmTH.MEXkpWQ2dQX.Yt7U18p.eYmWM.rdg8GDTOMzA93ttXW', 'yann@yann.com', 'admin', 0, '2017-04-06 08:39:53', '0000-00-00 00:00:00'),
(10, 'ludovic36', '$2y$10$UYBQcZ90WKQyTj.mlOaWH.ozpsGlSlL0upH6ySlbp5zOgLFLCD/dS', 'ludo@ludo2.fr', 'admin', 0, '2017-04-07 15:32:40', '2017-04-07 17:32:39'),
(14, 'anne', '$2y$10$mDjhhWxB.0XjmSU7fjwy0eh2P.lxqBIBu..2UAsmsVbqqFQeudJFq', 'anne@ludo.fr', 'registred', 0, '2017-04-07 22:37:32', '2017-04-08 00:37:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
 ADD PRIMARY KEY (`id`), ADD KEY `id` (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `tags_mapping`
--
ALTER TABLE `tags_mapping`
 ADD PRIMARY KEY (`article_id`,`tag_id`), ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tags_mapping`
--
ALTER TABLE `tags_mapping`
ADD CONSTRAINT `tags_mapping_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `tags_mapping_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
