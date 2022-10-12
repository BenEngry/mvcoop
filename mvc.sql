-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 12 2022 г., 15:20
-- Версия сервера: 8.0.24
-- Версия PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `mvc`
--

DELIMITER $$
--
-- Процедуры
--
CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `getAllFromTable` (`tb` VARCHAR(20), `page` INT, `lim` INT)  BEGIN
    DECLARE off INT;
    SET off = lim * page - 10;
    SELECT
        *
    FROM
        tb
    LIMIT lim OFFSET off;
END$$

CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `getPromotionPage` (`page` INT)  BEGIN
    DECLARE off INT;
    SET off = 10 * page - 10;
    SELECT
        `id`,
       `login`,
       `desc`,
       `sended_at`,
       `status`
    FROM
        `users` u
    JOIN `promotions` p ON u.id = p.id_user
    LIMIT 10 OFFSET off;
END$$

CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `getUsersOpportunity` (IN `page` INT, IN `lim` INT)  BEGIN
    DECLARE off INT;
    SET off = lim * page - lim;
    SELECT
        u.`id` id,
        u.`login` login,
        u.`email` email,
        u.`role` role,
        op.`delUser` delUser,
        op.`promoteUser` promoteUser,
        op.`declineUser` declineUser,
        op.`passToLogData` passToLogData,
        op.`delUsersMessages` delUsersMessages,
        op.`reductionUsersMessages` reductionUsersMessages,
        op.`delOtherAdmins` delOtherAdmins,
        op.`delOtherManagers` delOtherManagers,
        op.`addComments` addComments,
        op.`loginingToPage` loginingToPage
    FROM
        `users` u
            LEFT JOIN `opportunity` op ON u.id = op.idUser
    LIMIT lim OFFSET off;
END$$

CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `getUsersPage` (`page` INT, `lim` INT)  BEGIN
    DECLARE off INT;
    SET off = lim * page - lim;
    SELECT
        `id`,
        `login`,
        `email`,
        `role`,
        `desc`,
        `sended_at`,
        `status`
    FROM
        `users` u
            LEFT JOIN `promotions` p ON u.id = p.id_user
    LIMIT lim OFFSET off;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(128) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL,
  `status` int UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `name`, `title`, `message`, `created_at`, `status`) VALUES
(7, '', 'VLAD TOP', 'OnePieceOneLove', '2022-08-17 21:39:29', 0),
(8, 'ggfddfg', 'fgdfgsddfgdfg', 'gfddfgsdfgdfgdfg', '2022-08-17 21:39:37', 0),
(9, 'fsdafsaf', 'sadfsafdsfadf', 'dadsafdsfdsaf', '2022-08-25 09:41:52', 0),
(10, 'dadadada', 'dadadadada', 'dadadada', '2022-08-25 22:08:02', 0),
(11, 'fdsdfa', 'fdsafsdf', 'dsafsa', '2022-09-02 08:04:07', 0),
(12, 'fdsfaf', 'sdaff', 'dsaf', '2022-09-02 08:04:43', 0),
(13, 'fsdafsaf', 'fsafs', 'fsdafas', '2022-09-02 08:10:54', 0),
(14, 'fdsafd', 'afasfs', 'afsafdsad', '2022-09-02 08:12:09', 0),
(15, '122121', '12312', '321321312', '2022-09-02 08:29:37', 0),
(16, 'gfdsfd', 'gdsfgdfsg', 'dfsgfdsgdfsg', '2022-09-09 09:57:50', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `opportunity`
--

CREATE TABLE `opportunity` (
  `idUser` int UNSIGNED NOT NULL,
  `delUser` tinyint UNSIGNED DEFAULT '0',
  `promoteUser` tinyint UNSIGNED DEFAULT '0',
  `declineUser` tinyint UNSIGNED DEFAULT '0',
  `passToLogData` tinyint UNSIGNED DEFAULT '0',
  `delUsersMessages` tinyint UNSIGNED DEFAULT '0',
  `reductionUsersMessages` tinyint UNSIGNED DEFAULT '0',
  `delOtherAdmins` tinyint UNSIGNED DEFAULT '0',
  `delOtherManagers` tinyint UNSIGNED DEFAULT '0',
  `addComments` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `loginingToPage` tinyint UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `opportunity`
--

INSERT INTO `opportunity` (`idUser`, `delUser`, `promoteUser`, `declineUser`, `passToLogData`, `delUsersMessages`, `reductionUsersMessages`, `delOtherAdmins`, `delOtherManagers`, `addComments`, `loginingToPage`) VALUES
(24, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(25, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(26, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(32, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(34, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `promotions`
--

CREATE TABLE `promotions` (
  `id_user` int NOT NULL,
  `desc` varchar(70) DEFAULT NULL,
  `sended_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `promotions`
--

INSERT INTO `promotions` (`id_user`, `desc`, `sended_at`, `status`) VALUES
(0, 'i\'m the best', '2022-10-03 13:48:23', 'declain'),
(5, 'decause', '2022-10-10 15:11:45', 'consider'),
(23, 'i_m the best', '2022-10-03 14:03:28', 'declain'),
(25, 'wewew', '2022-10-10 17:43:54', 'consider');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int UNSIGNED NOT NULL DEFAULT '0',
  `promotion` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `login`, `password`, `role`, `promotion`) VALUES
(1, '1@1', 'admin', '123123', 1, 0),
(2, '2@2', 'user1', '111', 0, 1),
(3, '3@3', 'user2', '111', 1, 1),
(5, 'jfhhj', 'jjhjhf', 'dddd', 26, 1),
(6, 'fsdad', 'sdfsfd', 'fsdasdfafsdasdfafsdasdfasdff', 0, 0),
(10, 'ben', 'ben', 'ben', 1, 1),
(12, 'dada', 'dada', 'dada', 1, 0),
(17, 'dsadsasa', 'dasddas', 'sadsadaa', 2, 0),
(21, 'fdsdasdf', 'rew42234f', 'fdsdf234234234', 0, 0),
(22, 'user', 'user', 'user', 1, 0),
(24, '111', '111', '111', 0, 0),
(25, 'nana', 'nana', 'nana', 0, 0),
(26, '1212', '1212', '1212', 0, 0),
(27, 'newus', 'newus', 'newus', 0, 0),
(28, 'newus', 'newus', 'newus', 0, 0),
(29, 'newus', 'newus', 'newus', 0, 0),
(30, 'qwqwq', 'qwqwq', 'qwqwq', 0, 0),
(31, 'sda', 'sda', 'sda', 0, 0),
(32, 'sda', 'sda', 'sda', 0, 0),
(33, 'test', 'test', 'test', 0, 0),
(34, 'wewewe', 'wewewe', 'wewewe', 0, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `opportunity`
--
ALTER TABLE `opportunity`
  ADD PRIMARY KEY (`idUser`);

--
-- Индексы таблицы `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id_user`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `opportunity`
--
ALTER TABLE `opportunity`
  MODIFY `idUser` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
