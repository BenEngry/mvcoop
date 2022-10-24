-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 24 2022 г., 17:15
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

CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `getAllLogsById` (IN `id` INT)  BEGIN
    SELECT
        `idUser`,
        `date`,
        `entered`,
        `sEntered`,
        `exit`,
        `sExit`
    FROM
        `logs` l
    WHERE idUser = id;
END$$

CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `getAllUserData` (`id` INT)  BEGIN
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
        op.`delOtherManagers` delOtherManagers
    FROM
        `users` u
            LEFT JOIN `opportunity` op ON u.id = op.idUser
    WHERE u.id = id;
END$$

CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `getAvgById` (`id` INT)  BEGIN
    SELECT
        CEIL(AVG(sExit - sEntered)) AS avgTime
    FROM
        `logs` l
    WHERE idUser = id;
END$$

CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `getAvgDayById` (`id` INT)  BEGIN
    SELECT
        `day`,
        CEIL(AVG(sExit - sEntered)) AS avgTime
    FROM
        `logs` l
    WHERE idUser = id AND day IS NOT NULL
    GROUP BY day;
END$$

CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `getAvgMonthById` (IN `id` INT)  BEGIN
    SELECT
        `month`,
        CEIL(AVG(sExit - sEntered)) AS avgTime
    FROM
        `logs` l
    WHERE idUser = id AND month IS NOT NULL
    GROUP BY month;
END$$

CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `getAvgYearById` (IN `id` INT)  BEGIN
    SELECT
        `year`,
        CEIL(AVG(sExit - sEntered)) AS avgTime
    FROM
        `logs` l
    WHERE idUser = id AND year IS NOT NULL
    GROUP BY year;
END$$

CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `getCurrentMessagesPage` (`idUs` INT, `page` INT)  BEGIN
    DECLARE off INT;
    SET off = 10 * page - 10;
    SELECT `id`, `name`, `title`, `message`, `created_at`, `status`, `idUser`
    FROM
        `messages`
    WHERE idUser = idUs
    LIMIT 10 OFFSET off;
END$$

CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `getMaxSessionById` (`id` INT)  BEGIN
    SELECT
        CEIL(MAX(sExit - sEntered)) AS maxTime
    FROM
        `logs` l
    WHERE idUser = id;
END$$

CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `getMessagesPage` (IN `page` INT)  BEGIN
    DECLARE off INT;
    SET off = 10 * page - 10;
    SELECT `id`, `name`, `title`, `message`, `created_at`, `status`, `idUser`
    FROM
        `messages`
    LIMIT 10 OFFSET off;
END$$

CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `getMinSessionById` (`id` INT)  BEGIN
    SELECT
        CEIL(MIN(sExit - sEntered)) AS maxTime
    FROM
        `logs` l
    WHERE idUser = id;
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

CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `getTimeSessionsById` (`id` INT)  BEGIN
    SELECT
        `day`,
        `month`,
        `year`,
        sExit - sEntered AS time
    FROM
        `logs` l
    WHERE idUser = id AND sExit IS NOT NULL;
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
-- Структура таблицы `logs`
--

CREATE TABLE `logs` (
  `idUser` int NOT NULL,
  `date` date NOT NULL,
  `entered` time DEFAULT NULL,
  `exit` time DEFAULT NULL,
  `sEntered` bigint DEFAULT NULL,
  `sExit` bigint DEFAULT NULL,
  `day` tinyint DEFAULT NULL,
  `month` tinyint DEFAULT NULL,
  `year` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `logs`
--

INSERT INTO `logs` (`idUser`, `date`, `entered`, `exit`, `sEntered`, `sExit`, `day`, `month`, `year`) VALUES
(50, '2022-10-21', '22:42:21', '22:42:25', 1666381341, 1666381345, NULL, NULL, NULL),
(50, '2022-10-21', '23:16:30', '23:19:44', 1666383390, 1666383584, 21, 10, 22),
(50, '2022-10-21', '23:19:54', '23:26:13', 1666383594, 1666383973, 21, 10, 22),
(50, '2022-10-21', '23:26:19', '23:26:22', 1666383979, 1666383982, 21, 10, 22),
(50, '2022-10-21', '23:28:25', '23:28:26', 1666384105, 1666384106, 21, 10, 22),
(50, '2022-10-21', '23:28:40', '23:28:41', 1666384120, 1666384121, 21, 10, 22),
(50, '2022-10-21', '23:28:46', '10:09:27', 1666384126, 1666422567, 21, 10, 22),
(50, '2022-10-22', '10:09:41', '22:13:48', 1666422581, 1666552428, 22, 10, 22),
(50, '2022-10-23', '22:13:57', '12:23:31', 1666552437, 1666603411, 23, 10, 22),
(52, '2022-10-24', '12:23:36', '12:24:11', 1666603416, 1666603451, 24, 10, 22),
(50, '2022-10-24', '12:24:19', '12:29:36', 1666603459, 1666603776, 24, 10, 22),
(50, '2022-10-24', '12:29:45', '13:00:53', 1666603785, 1666605653, 24, 10, 22),
(50, '2022-10-24', '13:03:10', '13:08:37', 1666605790, 1666606117, 24, 10, 22),
(50, '2022-10-24', '13:10:59', '13:17:02', 1666606259, 1666606622, 24, 10, 22),
(56, '2022-10-24', '13:19:53', '13:19:59', 1666606793, 1666606799, 24, 10, 22),
(50, '2022-10-24', '13:21:13', NULL, 1666606873, NULL, 24, 10, 22);

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
  `status` int UNSIGNED DEFAULT '0',
  `idUser` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `name`, `title`, `message`, `created_at`, `status`, `idUser`) VALUES
(11, '', '', '', '2022-09-02 08:04:07', 0, 0),
(12, 'fdsfaf', 'sdaff', 'dsaf', '2022-09-02 08:04:43', 0, 0),
(13, '', '', '', '2022-09-02 08:10:54', 0, 0),
(14, 'fdsafd', 'afasfs', 'afsafdsad', '2022-09-02 08:12:09', 0, 0),
(15, '122121', '12312', '321321312', '2022-09-02 08:29:37', 0, 0),
(16, 'gfdsfd', 'gdsfgdfsg', 'dfsgfdsgdfsg', '2022-09-09 09:57:50', 0, 0),
(17, 'fdsad', 'sdaf', 'safsafsa', '2022-10-24 11:56:45', 0, 50),
(18, 'Hehe', 'Haha', 'Hehe', '2022-10-24 12:23:50', 0, 52),
(19, '', '', '', '2022-10-24 12:30:45', 0, 50),
(20, '', '', '', '2022-10-24 12:32:31', 0, 50),
(21, 'dada', 'dada', 'dadada', '2022-10-24 12:32:56', 0, 50);

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
(49, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(50, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(51, 0, 1, 0, 0, 1, 1, 1, 0, 1, 1),
(52, 1, 0, 1, 1, 1, 1, 0, 0, 1, 1),
(53, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(54, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(56, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(57, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1);

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
(51, 'erre', '2022-10-15 23:40:04', 'consider');

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
(50, 'da@da', 'dada', '$2y$10$h.rrkcuITet9wsiAOmQw7..L5iYJGYyW.Ow0jgkIHqhdqNGTH6koy', 1, 0),
(51, 'ad@ad', 'adad', '$2y$10$h.rrkcu43f9wsiAOFmQw7..L5iYJGYyW.Ow0jgkIHqhdqNGTH6koy', 0, 0),
(52, 'da@d', 'dad', 'fds$2y$20$MZzfSYzUXfd5gfhR.CBPyoAl9EmZEmhnsSHsuJXO0qldU1cu', 1, 0),
(53, 'pe@pe', 'pepe', '$fg0$8KadG60Jdfdfd$RgfgsdmYPHIVubvRa6tB7vCLEfeblYeQT3wK15uyo', 0, 0),
(54, 'dad@ada', 'dadada', '$2y$20$MZzfSYzUXOLaCtf00cIKR.CBPyoAl9EmZEmhnsSHsuJXO0qldU1cu', 0, 0),
(56, 'max@max', 'max', '$2y$10$8KadG60JdOXQPnmmYPHIVubvRa6tB7vCLEfeblYeQT3wK15uyo/j6', 0, 0);

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `opportunity`
--
ALTER TABLE `opportunity`
  MODIFY `idUser` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
