-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 28 2016 г., 18:19
-- Версия сервера: 5.5.50
-- Версия PHP: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `mvc`
--

-- --------------------------------------------------------

--
-- Структура таблицы `group2menu_admin`
--

CREATE TABLE IF NOT EXISTS `group2menu_admin` (
  `group_id` int(11) NOT NULL,
  `menu_admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `group2menu_admin`
--

INSERT INTO `group2menu_admin` (`group_id`, `menu_admin_id`) VALUES
(1, 19),
(1, 23),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(4, 1),
(4, 3),
(4, 4),
(4, 6),
(4, 7),
(4, 9),
(4, 10),
(4, 11),
(4, 12),
(4, 16),
(4, 17),
(4, 18),
(4, 19),
(4, 20),
(4, 21),
(4, 22),
(4, 24),
(4, 25),
(4, 27),
(4, 34),
(4, 36),
(4, 37);

-- --------------------------------------------------------

--
-- Структура таблицы `group2page`
--

CREATE TABLE IF NOT EXISTS `group2page` (
  `group_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `group2page`
--

INSERT INTO `group2page` (`group_id`, `page_id`) VALUES
(1, 16),
(1, 17),
(1, 27),
(1, 34),
(1, 35),
(1, 37),
(1, 43),
(1, 44),
(1, 45),
(1, 51),
(4, 0),
(4, 5),
(4, 10),
(4, 11),
(4, 15),
(4, 19),
(4, 20),
(4, 21),
(4, 22),
(4, 23),
(4, 24),
(4, 25),
(4, 26),
(4, 28),
(4, 29),
(4, 30),
(4, 31),
(4, 32),
(4, 33),
(4, 38),
(4, 39),
(4, 41),
(4, 46),
(4, 48),
(4, 50),
(4, 52);

-- --------------------------------------------------------

--
-- Структура таблицы `group2user`
--

CREATE TABLE IF NOT EXISTS `group2user` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `group2user`
--

INSERT INTO `group2user` (`group_id`, `user_id`) VALUES
(1, 1),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(4, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `access` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`group_id`, `name`, `icon`, `access`) VALUES
(1, 'Зарегистрированный', 'fa fa-user', 0),
(2, 'Менеджер', 'fa fa-briefcase', 0),
(3, 'Техподдержка', 'fa fa-wrench', 0),
(4, 'Администратор', 'fa fa-user-secret', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `menu_admin`
--

CREATE TABLE IF NOT EXISTS `menu_admin` (
  `menu_admin_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `del` int(1) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `index` int(11) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `menu_admin`
--

INSERT INTO `menu_admin` (`menu_admin_id`, `page_id`, `icon`, `title`, `date`, `del`, `parent_id`, `index`) VALUES
(1, 0, 'fa fa-user-secret', 'Администрирование', '2016-09-25 17:40:36', 0, 0, 1),
(3, 0, 'fa fa-wrench', 'Настройки системы', '2016-09-25 17:40:36', 0, 0, 7),
(4, 10, '', '', '2016-09-26 14:23:11', 0, 3, 6),
(6, 11, '', '', '2016-09-26 14:23:11', 0, 7, 0),
(7, 0, 'fa fa-bars', 'Меню', '2016-09-26 14:23:11', 0, 3, 8),
(8, 0, '', '', '2016-09-26 14:23:11', 1, 26, 0),
(9, 15, '', '', '2016-09-26 14:23:11', 0, 3, 7),
(10, 19, '', '', '2016-09-26 14:23:11', 0, 3, 0),
(11, 20, '', '', '2016-09-26 14:23:11', 0, 3, 4),
(12, 21, '', '', '2016-09-25 17:40:36', 0, 3, 5),
(16, 33, '', '', '2016-10-20 23:24:23', 0, 1, 1),
(17, 29, '', '', '2016-10-20 23:57:21', 0, 1, 1),
(18, 28, '', '', '2016-10-26 21:31:30', 0, 1, 1),
(19, 37, '', '', '2016-10-26 22:15:42', 0, 0, 0),
(20, 32, '', '', '2016-10-26 23:15:01', 0, 1, 1),
(21, 30, '', '', '2016-10-26 23:15:24', 0, 1, 1),
(22, 31, '', '', '2016-10-26 23:15:41', 0, 1, 1),
(23, 51, '', '', '2016-10-26 23:59:05', 0, 0, 1),
(24, 52, '', '', '2016-10-26 23:59:15', 0, 3, 1),
(25, 41, '', '', '2016-10-27 00:47:58', 0, 1, 1),
(26, 0, '', '', '2016-10-27 01:43:11', 1, 0, 8),
(27, 5, '', '', '2016-10-27 14:04:43', 0, 1, 0),
(28, 43, 'fa fa-user', '', '2016-10-27 14:25:23', 0, 0, 1),
(29, 27, '', '', '2016-10-27 14:32:15', 0, 0, 3),
(30, 35, '', '', '2016-10-27 14:32:42', 0, 0, 4),
(31, 44, '', '', '2016-10-27 14:32:51', 0, 0, 2),
(32, 45, '', '', '2016-10-27 14:52:12', 0, 0, 5),
(33, 0, '', '', '2016-10-27 15:32:29', 1, 26, 3),
(34, 50, '', '', '2016-11-06 15:53:49', 0, 1, 3),
(35, 0, '', '', '2016-11-06 15:54:05', 1, 26, 1),
(36, 46, '', '', '2016-11-12 08:32:07', 0, 3, 3),
(37, 48, '', '', '2016-11-12 08:32:42', 0, 3, 2),
(38, 0, '', '', '2016-11-15 21:49:42', 1, 26, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `notice2user`
--

CREATE TABLE IF NOT EXISTS `notice2user` (
  `notice_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `notices`
--

CREATE TABLE IF NOT EXISTS `notices` (
  `notice_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `type` int(11) NOT NULL COMMENT 'email, sms, web',
  `del` int(1) NOT NULL,
  `is_html` int(1) NOT NULL,
  `event` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `notices`
--

INSERT INTO `notices` (`notice_id`, `subject`, `text`, `type`, `del`, `is_html`, `event`) VALUES
(1, 'Восстановление пароля', '&lt;!DOCTYPE html&gt;\r\n&lt;html&gt;\r\n&lt;head&gt;\r\n	&lt;title&gt;&lt;/title&gt;\r\n	&lt;link href=&quot;https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css&quot; rel=&quot;stylesheet&quot; /&gt;\r\n&lt;/head&gt;\r\n&lt;body&gt;\r\n&lt;table border=&quot;0&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; style=&quot;background-color:#f4f4f4; font-style:normal; font-variant:normal normal; white-space:normal; width:100%&quot;&gt;\r\n	&lt;tbody&gt;\r\n		&lt;tr&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n			&lt;td style=&quot;width:300px&quot;&gt;\r\n			&lt;div style=&quot;padding:10px 30px&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;color:#696969&quot;&gt;Project name&lt;/span&gt;&lt;/span&gt;&lt;/div&gt;\r\n			&lt;/td&gt;\r\n			&lt;td style=&quot;width:300px&quot;&gt;\r\n			&lt;table border=&quot;0&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; style=&quot;background-color:#f4f4f4; width:100%&quot;&gt;\r\n				&lt;tbody&gt;\r\n					&lt;tr&gt;\r\n						&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n						&lt;td style=&quot;width:300px&quot;&gt;\r\n						&lt;div style=&quot;padding:10px 30px; text-align:right&quot;&gt;&lt;img alt=&quot;Project name&quot; src=&quot;http://mvc2/files/design/logo-dark-sm.png&quot; style=&quot;height:25px; width:79px&quot; /&gt;&lt;/div&gt;\r\n						&lt;/td&gt;\r\n					&lt;/tr&gt;\r\n				&lt;/tbody&gt;\r\n			&lt;/table&gt;\r\n			&lt;/td&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n			&lt;td colspan=&quot;2&quot; style=&quot;background-color:#0099ff; width:600px&quot;&gt;\r\n			&lt;div style=&quot;padding:10px 30px&quot;&gt;\r\n			&lt;h1&gt;&lt;span style=&quot;font-size:28px&quot;&gt;&lt;span style=&quot;color:#ffffff&quot;&gt;Восстановление пароля&lt;/span&gt;&lt;/span&gt;&lt;/h1&gt;\r\n			&lt;/div&gt;\r\n			&lt;/td&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n			&lt;td colspan=&quot;2&quot; style=&quot;background-color:#ffffff&quot;&gt;\r\n			&lt;div style=&quot;padding:10px 30px&quot;&gt;\r\n			&lt;h1&gt;&lt;span style=&quot;font-size:24px&quot;&gt;Здравствуйте, %user_name%!&lt;/span&gt;&lt;/h1&gt;\r\n\r\n			&lt;p&gt;Для восстановления пароль пройдите по ссылке:&lt;/p&gt;\r\n\r\n			&lt;p&gt;&lt;a class=&quot;btn btn-primary&quot; href=&quot;%link%&quot;&gt;Восстановить пароль&lt;/a&gt;&lt;/p&gt;\r\n\r\n			&lt;hr /&gt;\r\n			&lt;p&gt;&lt;span style=&quot;font-size:14px&quot;&gt;&lt;span style=&quot;color:#a9a9a9&quot;&gt;Если вы не собирались изменять пароль, проигнорируйте данное сообщение.&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n			&lt;/div&gt;\r\n			&lt;/td&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n			&lt;td colspan=&quot;2&quot;&gt;\r\n			&lt;div class=&quot;small&quot; style=&quot;padding:10px 30px 0&quot;&gt;\r\n			&lt;p style=&quot;text-align:center&quot;&gt;&amp;copy; Project name, 2016&lt;/p&gt;\r\n			&lt;/div&gt;\r\n			&lt;/td&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n	&lt;/tbody&gt;\r\n&lt;/table&gt;\r\n&lt;/body&gt;\r\n&lt;/html&gt;', 1, 0, 1, 2),
(2, 'Регистрация на сайте', '&lt;!DOCTYPE html&gt;\r\n&lt;html&gt;\r\n&lt;head&gt;\r\n	&lt;title&gt;&lt;/title&gt;\r\n	&lt;link href=&quot;https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css&quot; rel=&quot;stylesheet&quot; /&gt;\r\n&lt;/head&gt;\r\n&lt;body&gt;\r\n&lt;table border=&quot;0&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; style=&quot;background-color:#f4f4f4; width:100%&quot;&gt;\r\n	&lt;tbody&gt;\r\n		&lt;tr&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n			&lt;td style=&quot;width:300px&quot;&gt;\r\n			&lt;div style=&quot;padding:10px 30px&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;color:#696969&quot;&gt;Project name&lt;/span&gt;&lt;/span&gt;&lt;/div&gt;\r\n			&lt;/td&gt;\r\n			&lt;td style=&quot;width:300px&quot;&gt;\r\n			&lt;table border=&quot;0&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; style=&quot;background-color:#f4f4f4; width:100%&quot;&gt;\r\n				&lt;tbody&gt;\r\n					&lt;tr&gt;\r\n						&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n						&lt;td style=&quot;width:300px&quot;&gt;\r\n						&lt;div style=&quot;padding:10px 30px; text-align:right&quot;&gt;&lt;img alt=&quot;Project name&quot; src=&quot;http://mvc2/files/design/logo-dark-sm.png&quot; style=&quot;height:25px; width:79px&quot; /&gt;&lt;/div&gt;\r\n						&lt;/td&gt;\r\n					&lt;/tr&gt;\r\n				&lt;/tbody&gt;\r\n			&lt;/table&gt;\r\n			&lt;/td&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n			&lt;td colspan=&quot;2&quot; style=&quot;background-color:#0099ff; width:600px&quot;&gt;\r\n			&lt;div style=&quot;padding:10px 30px&quot;&gt;\r\n			&lt;h1&gt;&lt;span style=&quot;font-size:22px&quot;&gt;&lt;span style=&quot;color:#ffffff&quot;&gt;Регистрация на сайте&lt;/span&gt;&lt;/span&gt;&lt;/h1&gt;\r\n			&lt;/div&gt;\r\n			&lt;/td&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n			&lt;td colspan=&quot;2&quot; style=&quot;background-color:#ffffff&quot;&gt;\r\n			&lt;div style=&quot;padding:10px 30px&quot;&gt;\r\n			&lt;div style=&quot;margin-bottom:20px&quot;&gt;\r\n			&lt;h2&gt;&lt;span style=&quot;font-size:24px&quot;&gt;Поздравляем, %user_name%!&lt;/span&gt;&lt;/h2&gt;\r\n			&lt;/div&gt;\r\n\r\n			&lt;p&gt;Вы успешно зарегистрировались на сайте Project name.&lt;/p&gt;\r\n\r\n			&lt;p&gt;Для активации вашего профиля&amp;nbsp;необходимо перейти по ссылке:&lt;/p&gt;\r\n\r\n			&lt;p&gt;&lt;a class=&quot;btn btn-primary&quot; href=&quot;%link%&quot;&gt;Активировать профиль&lt;/a&gt;&lt;/p&gt;\r\n\r\n			&lt;hr /&gt;\r\n			&lt;p&gt;&lt;span style=&quot;font-size:14px&quot;&gt;&lt;span style=&quot;color:#a9a9a9&quot;&gt;Если вы не регистрировались на сайте, проигнорируйте данное сообщение.&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n			&lt;/div&gt;\r\n			&lt;/td&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n			&lt;td colspan=&quot;2&quot;&gt;\r\n			&lt;div class=&quot;small&quot; style=&quot;padding:10px 30px 0&quot;&gt;\r\n			&lt;p style=&quot;text-align:center&quot;&gt;&amp;copy; Project name, 2016&lt;/p&gt;\r\n			&lt;/div&gt;\r\n			&lt;/td&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n	&lt;/tbody&gt;\r\n&lt;/table&gt;\r\n&lt;/body&gt;\r\n&lt;/html&gt;', 1, 0, 1, 1),
(3, 'Ошибка', '%text%', 2, 0, 0, 3),
(4, 'Исключение', '&lt;!DOCTYPE html&gt;\r\n&lt;html&gt;\r\n&lt;head&gt;\r\n	&lt;title&gt;&lt;/title&gt;\r\n	&lt;link href=&quot;https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css&quot; rel=&quot;stylesheet&quot; /&gt;\r\n&lt;/head&gt;\r\n&lt;body&gt;\r\n&lt;table border=&quot;0&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; style=&quot;background-color:#f4f4f4; width:100%&quot;&gt;\r\n	&lt;tbody&gt;\r\n		&lt;tr&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n			&lt;td style=&quot;width:300px&quot;&gt;\r\n			&lt;div style=&quot;padding:10px 30px&quot;&gt;&lt;span style=&quot;font-size:20px&quot;&gt;&lt;span style=&quot;color:#696969&quot;&gt;Project name&lt;/span&gt;&lt;/span&gt;&lt;/div&gt;\r\n			&lt;/td&gt;\r\n			&lt;td style=&quot;width:300px&quot;&gt;\r\n			&lt;table border=&quot;0&quot; cellpadding=&quot;0&quot; cellspacing=&quot;0&quot; style=&quot;background-color:#f4f4f4; width:100%&quot;&gt;\r\n				&lt;tbody&gt;\r\n					&lt;tr&gt;\r\n						&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n						&lt;td style=&quot;width:300px&quot;&gt;\r\n						&lt;div style=&quot;padding:10px 30px; text-align:right&quot;&gt;&lt;img alt=&quot;Project name&quot; src=&quot;http://mvc2/files/design/logo-dark-sm.png&quot; style=&quot;height:25px; width:79px&quot; /&gt;&lt;/div&gt;\r\n						&lt;/td&gt;\r\n					&lt;/tr&gt;\r\n				&lt;/tbody&gt;\r\n			&lt;/table&gt;\r\n			&lt;/td&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n			&lt;td colspan=&quot;2&quot; style=&quot;background-color:red; width:600px&quot;&gt;\r\n			&lt;div style=&quot;padding:10px 30px&quot;&gt;\r\n			&lt;h1&gt;&lt;span style=&quot;font-size:28px&quot;&gt;&lt;span style=&quot;color:#ffffff&quot;&gt;Исключение&lt;/span&gt;&lt;/span&gt;&lt;/h1&gt;\r\n			&lt;/div&gt;\r\n			&lt;/td&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n			&lt;td colspan=&quot;2&quot; style=&quot;background-color:#ffffff&quot;&gt;\r\n			&lt;div style=&quot;padding:10px 30px&quot;&gt;%text%&lt;/div&gt;\r\n			&lt;/td&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n			&lt;td colspan=&quot;2&quot;&gt;\r\n			&lt;div class=&quot;small&quot; style=&quot;padding:10px 30px 0&quot;&gt;\r\n			&lt;p style=&quot;text-align:center&quot;&gt;&amp;copy; Project name, 2016&lt;/p&gt;\r\n			&lt;/div&gt;\r\n			&lt;/td&gt;\r\n			&lt;td&gt;&amp;nbsp;&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n	&lt;/tbody&gt;\r\n&lt;/table&gt;\r\n&lt;/body&gt;\r\n&lt;/html&gt;', 1, 0, 1, 4),
(5, '1', '', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `page_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `handler` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `del` int(1) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `redirect_url` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `index` int(11) unsigned NOT NULL,
  `is_default` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`page_id`, `title`, `url`, `keywords`, `desc`, `handler`, `date`, `del`, `parent_id`, `redirect_url`, `icon`, `index`, `is_default`) VALUES
(1, 'Текст о сервисе', 'index', '', '', 'site/index', '0000-00-00 00:00:00', 0, 0, '', 'fa fa-home', 0, 1),
(3, 'Вход', 'login', '', '', 'site/login', '2016-09-13 16:20:43', 0, 0, '', 'fa fa-sign-in', 6, 0),
(5, 'Панель администратора', 'admin', '', '', 'admin/index', '2016-09-13 16:20:43', 0, 0, '', 'fa fa-dashboard', 1, 0),
(6, 'Регистрация', 'reg', '', '', 'site/reg', '2016-09-13 16:20:43', 0, 0, '', 'fa fa-registered', 8, 0),
(7, 'Восстановление пароля', 'restore', '', '', 'site/restore_pass', '2016-09-13 16:20:43', 0, 0, '', 'fa fa-refresh', 10, 0),
(8, 'Создание нового пароля', 'new_pass', '', '', 'site/new_pass', '2016-09-13 16:20:43', 0, 0, '', 'fa fa-key', 7, 0),
(9, 'Подтверждение E-mail', 'confirm', '', '', 'site/confirm_email', '2016-09-13 16:20:43', 0, 0, '', 'fa fa-check-square-o', 5, 0),
(10, 'Страницы сайта', 'pages', '', '', 'admin/pages', '2016-09-13 16:20:43', 0, 5, '', 'fa fa-files-o', 5, 0),
(11, 'Меню в личном кабинете', 'menu_admin', '', '', 'admin/menu_admin', '2016-09-13 16:20:43', 0, 5, '', '', 5, 0),
(14, 'Письма', 'letters', '', '', 'admin/letters', '2016-09-13 16:20:43', 1, 0, '', 'fa fa-envelope', 13, 0),
(15, 'Группы пользователей', 'groups', '', '', 'admin/groups', '2016-09-13 16:20:43', 0, 5, '', 'fa fa-users', 7, 0),
(16, 'Мой профиль', 'profile', '', '', 'user/profile', '2016-09-13 16:20:43', 0, 37, '', 'fa fa-user', 5, 0),
(17, 'Настройки', 'settings', '', '', 'user/settings', '2016-09-13 16:20:43', 0, 37, '', 'fa fa-cogs', 4, 0),
(18, 'Помощь', 'help', '', '', 'site/help', '2016-09-13 16:20:43', 0, 0, '', 'fa fa-info-circle', 3, 0),
(19, 'Пользователи', 'users', '', '', 'admin/users', '2016-09-13 16:20:43', 0, 5, '', 'fa fa-users', 5, 0),
(20, 'Основные настройки', 'settings', '', '', 'admin/settings', '2016-09-13 16:20:43', 0, 5, '', 'fa fa-cog', 2, 0),
(21, 'Файлы', 'upload_files', '', '', 'admin/upload_files', '2016-09-13 16:20:43', 0, 5, '', 'fa fa-file-text', 5, 0),
(22, 'Редактирование страницы', 'page', '', '', 'admin/edit_page', '2016-09-13 16:20:43', 0, 10, '', 'fa fa-cog', 0, 0),
(23, 'Редактирование уведомления', 'notice', '', '', 'admin/edit_notice', '2016-10-10 19:08:18', 0, 52, '', 'fa fa-cog', 0, 0),
(24, 'Редактирование группы', 'group', '', '', 'admin/edit_group', '2016-10-10 20:21:41', 0, 15, '', 'fa fa-users', 0, 0),
(25, 'Редактирование пользователя', 'user', '', '', 'admin/edit_user', '2016-10-11 15:00:13', 0, 19, '', 'fa fa-user', 0, 0),
(26, 'Редактирование меню', 'item', '', '', 'admin/edit_menu_admin', '2016-10-20 21:58:55', 0, 11, '', 'fa fa-cog', 0, 0),
(27, 'Мои вебинары', 'events', '', '', 'user/events', '2016-10-24 02:17:12', 0, 37, '', 'fa fa-video-camera', 1, 0),
(28, 'Статьи', 'posts', '', '', 'admin/posts', '2016-10-26 01:44:42', 0, 5, '', 'fa fa-font', 2, 0),
(29, 'Товары', 'goods', '', '', 'admin/goods', '2016-10-26 01:46:51', 0, 5, '', 'fa fa-shopping-basket', 2, 0),
(30, 'Комментарии', 'comments', '', '', 'admin/comments', '2016-10-26 01:48:20', 0, 5, '', 'fa fa-comments-o', 2, 0),
(31, 'Курсы', 'courses', '', '', 'admin/courses', '2016-10-26 13:45:36', 0, 5, '', 'fa fa-graduation-cap', 4, 0),
(32, 'Форум', 'topics', '', '', 'admin/topics', '2016-10-26 13:50:12', 0, 5, '', 'fa fa-comment', 3, 0),
(33, 'Вебинары', 'events', '', '', 'admin/events', '2016-10-26 13:54:10', 0, 5, '', 'fa fa-calendar', 2, 0),
(34, 'Мои уведомления', 'webnotices', '', '', 'user/webnotices', '2016-10-26 14:12:03', 0, 37, '', 'fa fa-bell-o', 0, 0),
(35, 'Мои курсы', 'courses', '', '', 'user/courses', '2016-10-26 14:31:50', 0, 37, '', 'fa fa-graduation-cap', 2, 0),
(36, 'Отзывы', 'feedbacks', '', '', 'site/feedbacks', '2016-10-26 17:36:13', 0, 0, '', 'fa fa-commenting-o', 4, 0),
(37, 'Моя страница', 'lk', '', '', 'user/index', '2016-10-26 23:12:05', 0, 0, '', 'fa fa-home', 0, 0),
(38, 'Друзья', 'friends', '', '', 'admin/friends', '2016-10-26 23:56:31', 0, 5, '', 'fa fa-user-plus', 0, 0),
(39, 'Сообщения', 'messages', '', '', 'admin/messages', '2016-10-26 23:58:41', 0, 5, '', 'fa fa-comments-o', 1, 0),
(40, 'Лайки', 'likes', '', '', 'admin/likes', '2016-10-27 00:35:21', 1, 0, '', 'fa fa-heart', 15, 0),
(41, 'Организации', 'orgs', '', '', 'admin/orgs', '2016-10-27 00:46:23', 0, 5, '', 'fa fa-briefcase', 2, 0),
(42, 'Заказы', 'orders', '', '', 'admin/orders', '2016-10-27 01:42:51', 1, 0, '', 'fa fa-money', 16, 0),
(43, 'Мои друзья', 'friends', '', '', 'user/friends', '2016-10-27 14:08:44', 0, 37, '', 'fa fa-user-plus', 6, 0),
(44, 'Мои статьи', 'posts', '', '', 'user/posts', '2016-10-27 14:09:55', 0, 37, '', 'fa fa-font', 3, 0),
(45, 'Мои организации', 'orgs', '', '', 'user/orgs', '2016-10-27 14:51:30', 0, 37, '', 'fa fa-briefcase', 0, 0),
(46, 'Помощь', 'help', '', '', 'admin/help', '2016-11-04 10:03:33', 0, 5, '', 'fa fa-info-circle', 15, 0),
(47, 'Меню правовых документов', 'menu_legal', '', '', 'admin/menu_legal', '2016-11-04 10:04:15', 1, 0, '', '', 14, 0),
(48, 'Правовые документы', 'legal', '', '', 'admin/legal', '2016-11-04 10:08:18', 0, 5, '', 'fa fa-gavel', 11, 0),
(49, 'Правовые документы', 'legal', '', '', 'site/legal', '2016-11-06 14:15:19', 0, 0, '', 'fa fa-gavel', 2, 0),
(50, 'Вопросы', 'questions', '', '', 'admin/questions', '2016-11-06 15:52:33', 0, 5, '', 'fa fa-question-circle', 17, 0),
(51, 'Мои сообщения', 'messages', '', '', 'user/messages', '2016-11-12 07:34:27', 0, 37, '', 'fa fa-comments-o', 0, 0),
(52, 'Уведомления', 'notices', '', '', 'admin/notices', '2016-11-18 11:55:48', 0, 5, '', 'fa fa-bell-o', 0, 0),
(53, 'События для уведомления', 'events', '', '', 'admin/notice_events', '2016-11-21 20:27:14', 1, 0, '', '', 12, 0),
(54, 'Редактирование события', 'event', '', '', 'admin/edit_notice_event', '2016-11-21 20:29:42', 1, 0, '', 'fa fa-cog', 11, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `browser` varchar(255) NOT NULL COMMENT 'Браузер',
  `date_active` datetime NOT NULL COMMENT 'Дата последней активности',
  `key` varchar(255) NOT NULL COMMENT 'Случайная строка'
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`session_id`, `user_id`, `ip`, `date`, `browser`, `date_active`, `key`) VALUES
(16, 1, '127.0.0.1', '2016-11-28 14:57:38', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36 OPR/41.0.2353.69', '2016-11-28 18:14:49', '1880144822');

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`key`, `value`) VALUES
('author', 'Project name'),
('email', 'notice@mail.ru'),
('fb_id', '0'),
('image', '/files/Salzburg_from_Gaisberg_big_version.jpg'),
('name', 'Service'),
('year_foundation', '2016');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL COMMENT 'Имя',
  `last_name` varchar(255) NOT NULL COMMENT 'Фамилия',
  `middle_name` varchar(255) NOT NULL COMMENT 'Отчество',
  `full_name` varchar(255) NOT NULL COMMENT 'ФИО',
  `first_last_name` varchar(255) NOT NULL COMMENT 'ФИ',
  `email` varchar(255) NOT NULL,
  `email_confirm` int(1) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `phone_confirm` int(1) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `date_active` datetime NOT NULL COMMENT 'Дата последней активности',
  `del` int(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `avatar` varchar(255) NOT NULL,
  `avatar_x` int(11) NOT NULL,
  `avatar_y` int(11) NOT NULL,
  `avatar_w` int(11) NOT NULL,
  `avatar_h` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `middle_name`, `full_name`, `first_last_name`, `email`, `email_confirm`, `phone`, `phone_confirm`, `pass`, `date_active`, `del`, `date`, `avatar`, `avatar_x`, `avatar_y`, `avatar_w`, `avatar_h`) VALUES
(1, 'Алексей', 'Смолин', 'Вячеславович', 'Смолин Алексей Вячеславович', 'Алексей Смолин', 'ajikcey@mail.ru', 1, '79097195002', 1, '85992c79d056ec4db0a41a4d83477219d8379d7b', '2016-11-28 18:14:49', 0, '2016-09-12 20:49:48', '', 0, 0, 0, 0),
(3, 'Елена', 'Клепцина', 'Эдуардовна', 'Клепцина Елена Эдуардовна', 'Елена Клепцина', 'helen_song@mail.ru', 1, '79628927072', 0, '85992c79d056ec4db0a41a4d83477219d8379d7b', '0000-00-00 00:00:00', 0, '2016-10-25 21:35:43', '', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `webnotices`
--

CREATE TABLE IF NOT EXISTS `webnotices` (
  `webnotice_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `del` int(1) NOT NULL,
  `is_old` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `group2menu_admin`
--
ALTER TABLE `group2menu_admin`
  ADD UNIQUE KEY `group_id` (`group_id`,`menu_admin_id`);

--
-- Индексы таблицы `group2page`
--
ALTER TABLE `group2page`
  ADD UNIQUE KEY `group_id` (`group_id`,`page_id`);

--
-- Индексы таблицы `group2user`
--
ALTER TABLE `group2user`
  ADD UNIQUE KEY `group_id` (`group_id`,`user_id`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Индексы таблицы `menu_admin`
--
ALTER TABLE `menu_admin`
  ADD PRIMARY KEY (`menu_admin_id`);

--
-- Индексы таблицы `notice2user`
--
ALTER TABLE `notice2user`
  ADD UNIQUE KEY `notice_id` (`notice_id`,`user_id`);

--
-- Индексы таблицы `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`notice_id`);

--
-- Индексы таблицы `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`page_id`),
  ADD UNIQUE KEY `url` (`url`,`parent_id`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Индексы таблицы `settings`
--
ALTER TABLE `settings`
  ADD UNIQUE KEY `key` (`key`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Индексы таблицы `webnotices`
--
ALTER TABLE `webnotices`
  ADD PRIMARY KEY (`webnotice_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `menu_admin`
--
ALTER TABLE `menu_admin`
  MODIFY `menu_admin_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT для таблицы `notices`
--
ALTER TABLE `notices`
  MODIFY `notice_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT для таблицы `sessions`
--
ALTER TABLE `sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `webnotices`
--
ALTER TABLE `webnotices`
  MODIFY `webnotice_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
