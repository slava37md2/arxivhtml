-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Июл 23 2009 г., 10:55
-- Версия сервера: 5.0.45
-- Версия PHP: 5.2.4
-- 
-- БД: `skyblog`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `skyblog_blog`
-- 

CREATE TABLE `skyblog_blog` (
  `id` int(12) NOT NULL auto_increment,
  `cat` int(5) NOT NULL,
  `idarxiv` varchar(15) NOT NULL,
  `title` varchar(255) NOT NULL,
  `kslova` varchar(255) default NULL,
  `descript` varchar(255) default NULL,
  `cortext` text NOT NULL,
  `text` text NOT NULL,
  `prosmotr` int(10) default '0',
  `avtor` varchar(100) NOT NULL,
  `data` varchar(100) default NULL,
  `pic` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 PACK_KEYS=0 AUTO_INCREMENT=1 ;

-- FULLTEXT KEY `text` (`text`)
-- Дамп данных таблицы `skyblog_blog`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `skyblog_cat`
-- 

CREATE TABLE `skyblog_cat` (
  `id` int(5) NOT NULL auto_increment,
  `cattitle` varchar(100) default NULL,
  `kslova` varchar(255) default NULL,
  `descript` varchar(255) default NULL,
  `textcat` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 PACK_KEYS=0 AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `skyblog_cat`
-- 

INSERT INTO `skyblog_cat` VALUES (1, 'News', 'Free script, SkyScript, Sky, Blog, script', 'Free scripts - SkyScript', 'Free scripts - SkyScript');

-- --------------------------------------------------------

-- 
-- Структура таблицы `skyblog_coment`
-- 

CREATE TABLE `skyblog_coment` (
  `id` int(5) NOT NULL auto_increment,
  `comblog` int(5) default NULL,
  `comavtor` varchar(100) default NULL,
  `comemail` varchar(255) default NULL,
  `comdate` varchar(100) default NULL,
  `comtext` text,
  `comotvet` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 PACK_KEYS=0 AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `skyblog_coment`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `skyblog_nastr`
-- 

CREATE TABLE `skyblog_nastr` (
  `id` int(2) NOT NULL auto_increment,
  `na_str` int(3) default NULL,
  `name` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `skyblog_nastr`
-- 

INSERT INTO `skyblog_nastr` VALUES (1, 5, 'admin', 'admin');
