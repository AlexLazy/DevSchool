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
  `price` mediumint(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `ds_ads_list` (`id`, `private`, `seller_name`, `email`, `allow_mails`, `phone`, `location_id`, `category_id`, `title`, `description`, `price`) VALUES
(1,	1,	'Марк',	'marck@gmail.com',	0,	'+7 908 222 33 55',	'641490',	'14',	'Сто рублей',	'Сто рублей одной купюрой',	10000),
(5,	0,	'Кларк',	'klark@mail.ru',	1,	'8 900 445 64 45',	'641600',	'111',	'Двести рублей',	'Ты-дыщь',	5),
(6,	1,	'Петька',	'',	1,	'',	'641680',	'115',	'Фантазия кончилась',	'Какой-то текст',	333),
(7,	0,	'Ануфрий',	'',	0,	'6 666 666 66 66',	'641780',	'109',	'Текст',	'Тоже текст',	0),
(8,	1,	'Текст',	'',	0,	'',	'',	'',	'Текст',	'',	0);

DROP TABLE IF EXISTS `ds_category`;
CREATE TABLE `ds_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `category` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf32;

INSERT INTO `ds_category` (`id`, `name`, `category`) VALUES
(9,	'Автомобили с пробегом',	'Транспорт'),
(109,	'Новые автомобили',	'Транспорт'),
(14,	'Мотоциклы и мототехника',	'Транспорт'),
(81,	'Грузовики и спецтехника',	'Транспорт'),
(24,	'Квартиры',	'Недвижимость'),
(23,	'Комнаты',	'Недвижимость'),
(25,	'Дома, дачи, коттеджи',	'Недвижимость'),
(111,	'Вакансии (поиск сотрудников)',	'Работа'),
(112,	'Резюме (поиск работы)',	'Работа'),
(114,	'Предложения услуг',	'Услуги'),
(115,	'Запросы на услуги',	'Услуги'),
(27,	'Одежда, обувь, аксессуары',	'Личные вещи'),
(29,	'Детская одежда и обувь',	'Личные вещи'),
(30,	'Товары для детей и игрушки',	'Личные вещи');

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

-- 2016-04-10 11:56:34
