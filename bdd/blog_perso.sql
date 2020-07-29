-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 23 juil. 2020 à 15:29
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blog_perso`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `articles_titre` varchar(100) NOT NULL,
  `chapo` text NOT NULL,
  `articles_contenu` mediumtext NOT NULL,
  `articles_publier` tinyint(1) NOT NULL,
  `articles_date_publication` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime DEFAULT NULL,
  `utilisateurs_id_utilisateur` int(11) NOT NULL,
  `user_mod` int(11) DEFAULT NULL,
  PRIMARY KEY (`article_id`,`utilisateurs_id_utilisateur`),
  KEY `fk_articles_utilisateurs1_idx` (`utilisateurs_id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`article_id`, `articles_titre`, `chapo`, `articles_contenu`, `articles_publier`, `articles_date_publication`, `date_creation`, `date_modification`, `utilisateurs_id_utilisateur`, `user_mod`) VALUES
(40, 'Lorem ipsum', '<p><span style=\"font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; text-align: justify; background-color: #ffffff;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla posuere sem elit, at aliquet augue varius et. Fusce molestie luctus neque, a porttitor massa sollicitudin ut. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Mauris blandit tellus ut sapien dictum, eget volutpat sem tempor. Duis vel volutpat ex. Donec id arcu leo. Duis felis tortor, placerat vel leo et, suscipit consectetur urna.</span></p>', '<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi lacinia venenatis lacinia. Maecenas viverra augue felis, vitae dapibus nibh molestie eget. Etiam quis faucibus ipsum, vel tempus risus. Nunc vitae ligula vel ligula fermentum consectetur. Vestibulum ut elementum dui. Maecenas id feugiat sem, vel facilisis nulla. Sed sodales eleifend lorem, vitae mattis lectus.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\">Fusce pellentesque mattis pretium. Mauris ut rutrum urna, at dictum ipsum. Nullam sollicitudin ante et nisi condimentum, non volutpat enim gravida. Aenean iaculis lobortis auctor. Cras condimentum sem rhoncus placerat volutpat. Ut porta sagittis mauris, in eleifend ante feugiat ut. Integer sem leo, facilisis blandit sem at, feugiat laoreet ligula. Nam nec dui vel ex vulputate feugiat. Ut mauris est, aliquet vel tincidunt nec, gravida eu mauris. Maecenas sed rutrum nunc.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\">Suspendisse sit amet leo vel erat porta porta nec quis nibh. Aliquam fringilla ex dolor, in tincidunt risus ultrices nec. Aliquam erat volutpat. Mauris et fringilla dui. Etiam sodales viverra tempus. Quisque ut turpis viverra dui fringilla fringilla in ut nibh. Nam ullamcorper orci purus, id maximus urna aliquam sit amet. Aenean lobortis purus in volutpat rhoncus. Cras volutpat lorem vulputate fermentum tempus. Mauris porttitor tellus ac purus posuere tempus. Quisque eget tincidunt purus. Suspendisse a pellentesque nisl. Aenean laoreet turpis gravida luctus tincidunt. Nullam at risus sit amet nulla vestibulum mollis nec luctus mi. Pellentesque varius leo id rutrum venenatis.</p>', 1, '2020-01-30 08:55:17', '2020-01-30 08:55:17', NULL, 1, NULL),
(41, 'Lorem Ipsum 2', '<p><span style=\"font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; text-align: justify; background-color: #ffffff;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc congue arcu ex, id ullamcorper ante tristique id. Donec sapien risus, molestie et ultricies et, interdum a risus. Mauris suscipit sodales magna id vulputate. Maecenas efficitur ullamcorper tristique. Suspendisse consequat, dui in sagittis maximus, elit dui vulputate ipsum, ut finibus nisi augue a tortor. Ut condimentum erat id ligula sagittis vulputate. Quisque bibendum suscipit neque at interdum. Donec posuere turpis sed libero cursus, et commodo arcu scelerisque. Phasellus non facilisis felis, sed consectetur massa. Donec sodales venenatis nulla at commodo. Fusce odio mauris, laoreet malesuada nulla et, ultricies ullamcorper tellus. Duis imperdiet lobortis nulla, a cursus massa gravida at. Pellentesque et nulla sed dui sodales scelerisque. Donec quam lacus, convallis vel ullamcorper id, posuere a massa. Integer ut mauris eu eros laoreet cursus vitae vitae sapien. Praesent suscipit sed leo et consequat. Imun.</span></p>', '<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus nec consequat orci, quis sagittis velit. Phasellus leo elit, porttitor ac ipsum sed, eleifend fermentum tellus. Donec ac placerat dui. Nunc viverra ornare mattis. Proin eleifend rhoncus arcu, id porttitor neque. Nulla ut eros nibh. Donec sagittis eget nibh maximus vestibulum. Vestibulum quam dui, viverra et tincidunt eu, pellentesque eget nisl. Curabitur hendrerit at dui eget fermentum. Donec vel elementum ipsum, ac luctus libero. Integer dignissim ultrices massa et pharetra. Praesent non posuere turpis, ac porttitor lectus.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\">Vivamus scelerisque mauris turpis, in mattis massa maximus et. Fusce tincidunt nibh nec nulla dignissim finibus. Vivamus luctus lorem purus, non condimentum ipsum pulvinar id. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Morbi hendrerit pretium consectetur. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In interdum sed lorem nec rutrum. Mauris bibendum lorem sit amet enim ultricies fermentum. Mauris ut eros at risus eleifend facilisis quis ac augue. Aliquam vulputate vehicula leo vitae pulvinar. Aliquam arcu nunc, egestas id ullamcorper id, congue ac leo. Phasellus ullamcorper luctus interdum. Proin mattis iaculis dui, quis vestibulum massa commodo sed. Praesent consequat lorem bibendum urna consectetur, vel faucibus nisi pretium. Morbi fringilla tellus id ullamcorper finibus. Aenean non efficitur nibh, non sagittis enim.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\">Donec faucibus arcu tortor, posuere elementum velit dictum nec. Curabitur blandit risus pulvinar, pulvinar massa eu, scelerisque augue. Proin mollis dolor metus, quis convallis massa ornare in. Etiam sollicitudin nisl ac lacus accumsan, sed hendrerit nisi blandit. Pellentesque at mauris erat. Sed commodo pretium molestie. Proin dui enim, ornare in magna sit amet, aliquam ultricies sem. Quisque cursus aliquam luctus. Proin sagittis quam lectus, in dictum nisi consequat eu. Nulla risus ante, sodales vel commodo a, suscipit ut neque. Mauris volutpat, magna nec vulputate consequat, magna dolor cursus sapien, id tristique massa lacus at justo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut interdum eros massa. Aliquam congue mauris at commodo viverra.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\">Fusce interdum nisi mi, eu fermentum sem iaculis quis. Sed consequat ligula eget cursus fringilla. Aliquam et nisl vel nisi hendrerit volutpat. Morbi non facilisis metus, vitae dignissim risus. Pellentesque nec ultricies magna, sit amet pellentesque purus. Pellentesque sit amet laoreet orci, ac hendrerit eros. In eu lorem at sapien egestas egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Vestibulum lobortis ultricies nisl, non tempus odio vulputate ut. Fusce quis tellus neque. Ut vitae tincidunt augue. In eget bibendum diam. Sed porttitor, sapien at aliquet pellentesque, magna augue molestie dui, ac consequat nisl ipsum nec arcu.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\">Quisque finibus maximus tincidunt. Ut non nisi cursus purus euismod tincidunt at et ante. Nullam pulvinar lectus libero, a venenatis lectus condimentum eget. Donec suscipit volutpat interdum. Nam in nibh ut diam porta iaculis. Nam et mollis lorem. Quisque tempor, risus ac cursus fringilla, mi ligula porta nulla, ut aliquet risus sapien at est. Cras at auctor lorem, ac fermentum mauris. In hac habitasse platea dictumst. Donec placerat nisl non mattis sollicitudin. Aenean et dapibus velit. Nulla commodo quam at nulla ullamcorper pulvinar. Aliquam volutpat purus erat, at malesuada quam lacinia sit amet. Donec molestie facilisis purus, sit amet fringilla odio accumsan sed. Aenean ligula ligula, condimentum a condimentum in, lacinia ac ex. Vestibulum nec hendrerit augue.</p>', 1, '2020-02-03 17:39:11', '2020-02-03 17:39:11', '2020-02-03 19:15:49', 1, 1),
(42, 'Lorem Ipsum 3', '<p><span style=\"font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; text-align: justify; background-color: #ffffff;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus quis risus risus. Nunc ac nulla tincidunt, rutrum sem non, placerat nisl. Vestibulum finibus viverra imperdiet. Ut id nisl ac justo dapibus bibendum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec purus ex, pulvinar a ornare ac, sodales nec leo. Suspendisse in enim nec elit accumsan aliquet. Sed suscipit eros enim. Aliquam mollis commodo ligula, et aliquam augue malesuada non. Etiam sollicitudin volutpat orci eget mattis.</span></p>', '<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent nulla eros, ornare eget sem vel, tristique lacinia ipsum. Praesent mattis scelerisque tortor quis sollicitudin. Suspendisse et venenatis enim. Sed laoreet neque a lectus cursus, a semper est ullamcorper. Aliquam egestas sodales leo vitae aliquam. Cras et felis lorem. Quisque lobortis lobortis dictum. Sed condimentum dolor quis libero malesuada, eu pretium ipsum bibendum. Proin convallis bibendum urna vel pulvinar. Nullam porttitor urna non scelerisque rhoncus. Mauris a rutrum dui, vitae efficitur purus. Praesent volutpat vel eros ac fermentum. Cras nec lorem euismod, pretium lectus venenatis, bibendum lorem.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\">Morbi ut viverra lacus, eget ultrices mauris. Pellentesque at nibh a nulla consectetur condimentum vitae a nisl. Fusce sit amet ex non tortor eleifend dignissim non vel urna. Praesent sed semper felis, eu feugiat ligula. Donec non dapibus ipsum. Morbi sit amet dui eget mi placerat pretium sit amet eu nisi. Morbi ultrices, lectus nec auctor placerat, tortor justo ornare ligula, ac bibendum ipsum tortor id magna. Praesent ullamcorper varius magna nec semper. Mauris dignissim dignissim ex vitae lacinia. Vestibulum eget diam non augue tristique dapibus. Aliquam erat volutpat.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\">Mauris tincidunt risus in leo semper sagittis. Proin ac lobortis justo, a tincidunt libero. Donec dictum finibus tellus. Ut ut leo bibendum, rhoncus mauris ut, imperdiet mi. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In scelerisque bibendum erat et efficitur. Pellentesque rhoncus sem auctor vehicula varius. Aliquam tincidunt pulvinar diam, a porttitor arcu tincidunt sit amet. Ut accumsan lorem nec enim commodo venenatis. Duis et lobortis ex, a interdum orci. Nullam vel augue non metus porta tincidunt.</p>', 1, '2020-02-04 20:33:13', '2020-02-04 20:33:13', '2020-02-05 16:16:21', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `clef`
--

DROP TABLE IF EXISTS `clef`;
CREATE TABLE IF NOT EXISTS `clef` (
  `clef_id` int(11) NOT NULL AUTO_INCREMENT,
  `clef_cle` tinyblob NOT NULL,
  `clef_iv` tinyblob NOT NULL,
  `utilisateurs_id_utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`clef_id`) USING BTREE,
  KEY `utilisateurs_id_utilisateur` (`utilisateurs_id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `clef`
--

INSERT INTO `clef` (`clef_id`, `clef_cle`, `clef_iv`, `utilisateurs_id_utilisateur`) VALUES
(1, 0x4a0963f74b3fb2aacaf5b8a21c28fd39, 0x1676d6a270438a3b8cb93e1c5c5372aa, 1),
(2, 0x9c72747aaffa0bb7a5c923e1b176cec8, 0x59778512db4c8adc4a1d03362ef5e5f1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE IF NOT EXISTS `commentaires` (
  `commentaires_id` int(11) NOT NULL AUTO_INCREMENT,
  `commentaires_utilisateur` varchar(255) NOT NULL,
  `commentaires_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `commentaires_statut` tinyint(4) DEFAULT '0',
  `utilisateurs_id_utilisateur` int(11) NOT NULL,
  `id_articles` int(11) NOT NULL,
  PRIMARY KEY (`commentaires_id`,`utilisateurs_id_utilisateur`),
  KEY `fk_commentaires_utilisateurs1_idx` (`utilisateurs_id_utilisateur`),
  KEY `id_articles` (`id_articles`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`commentaires_id`, `commentaires_utilisateur`, `commentaires_date`, `commentaires_statut`, `utilisateurs_id_utilisateur`, `id_articles`) VALUES
(1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took.', '2020-07-21 15:44:38', 1, 2, 42),
(4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi lacinia nunc a risus venenatis, ut facilisis odio volutpat. Nam non neque consectetur, blandit ante id, pellentesque quam. Ut auctor bibendum lacus a lacinia. Mauris quis commodo sem molestie.', '2020-07-22 14:28:14', 1, 2, 42),
(5, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi lacinia nunc a risus venenatis, ut facilisis odio volutpat. Nam non neque consectetur, blandit ante id, pellentesque quam. Ut auctor bibendum lacus a lacinia. Mauris quis commodo sem molestie.', '2020-07-22 14:28:31', 1, 2, 41),
(6, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi lacinia nunc a risus venenatis, ut facilisis odio volutpat. Nam non neque consectetur, blandit ante id, pellentesque quam. Ut auctor bibendum lacus a lacinia. Mauris quis commodo sem molestie.', '2020-07-22 14:28:43', 1, 2, 40),
(7, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi lacinia nunc a risus venenatis, ut facilisis odio volutpat. Nam non neque consectetur, blandit ante id, pellentesque quam. Ut auctor bibendum lacus a lacinia. Mauris quis commodo sem molestie.', '2020-07-22 14:28:51', 1, 2, 42),
(8, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi lacinia nunc a risus venenatis, ut facilisis odio volutpat. Nam non neque consectetur, blandit ante id, pellentesque quam. Ut auctor bibendum lacus a lacinia. Mauris quis commodo sem molestie.', '2020-07-22 14:28:59', 1, 2, 42);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `pseudonyme` varchar(20) NOT NULL,
  `email` varchar(45) NOT NULL,
  `mdp` tinyblob NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `administrateur` tinyint(1) NOT NULL DEFAULT '0',
  `code_validation` int(6) DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `pseudonyme`, `email`, `mdp`, `create_time`, `administrateur`, `code_validation`) VALUES
(1, 'Nerpp', 'regiaurelien@gmail.com', 0x6c43de0513db14f8b06348bc4d2492fd18294ef2c122e2b179d9584aa83c793fd3156fb21a081baf5fcce6ec2b14a7ded51ef414358add9044224d56ad43ec1f, '2020-04-02 15:50:15', 1, 1),
(2, 'Wamp', 'wampkarl@gmail.com', 0x4209fb68a23b6eaa65846697d739e9224051055f418fd61c4c9920d35cce5230a6500a54241d4dd2a6878426c8d2612a77edffde8a56e66dea69814db1952a79, '2020-04-02 15:51:21', 0, 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`utilisateurs_id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Contraintes pour la table `clef`
--
ALTER TABLE `clef`
  ADD CONSTRAINT `clef_ibfk_1` FOREIGN KEY (`utilisateurs_id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_ibfk_1` FOREIGN KEY (`id_articles`) REFERENCES `articles` (`article_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
