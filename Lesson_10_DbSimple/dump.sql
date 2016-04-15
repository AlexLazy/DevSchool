-- Adminer 4.2.4 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `ds_ads_list`;
CREATE TABLE `ds_ads_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `private` int(1) NOT NULL,
  `seller_name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `allow_mails` int(1) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `location_id` varchar(11) NOT NULL,
  `category_id` varchar(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` varchar(500) NOT NULL,
  `price` bigint(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ds_category`;
CREATE TABLE `ds_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf32;

INSERT INTO `ds_category` (`id`, `name`, `parent_id`) VALUES
(9,	'Автомобили с пробегом',	116),
(109,	'Новые автомобили',	116),
(14,	'Мотоциклы и мототехника',	116),
(81,	'Грузовики и спецтехника',	116),
(24,	'Квартиры',	118),
(23,	'Комнаты',	118),
(25,	'Дома, дачи, коттеджи',	118),
(111,	'Вакансии (поиск сотрудников)',	117),
(112,	'Резюме (поиск работы)',	117),
(114,	'Предложения услуг',	119),
(115,	'Запросы на услуги',	119),
(27,	'Одежда, обувь, аксессуары',	120),
(29,	'Детская одежда и обувь',	120),
(30,	'Товары для детей и игрушки',	120),
(116,	'Транспорт',	NULL),
(117,	'Работа',	NULL),
(118,	'Недвижимость',	NULL),
(119,	'Услуги',	NULL),
(120,	'Личные вещи',	NULL);

DROP TABLE IF EXISTS `ds_location`;
CREATE TABLE `ds_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `ds_location` (`id`, `name`) VALUES
(641780,	'Новосибирск'),
(641490,	'Барабинск'),
(641510,	'Бердск'),
(641600,	'Искитим'),
(641630,	'Колывань'),
(641680,	'Краснообск');

-- 2016-04-15 11:56:10
