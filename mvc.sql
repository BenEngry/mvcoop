-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 03 2022 г., 15:13
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
(7, '323fsdfad', 'fdsafd', '`', '2022-08-17 21:39:29', 0),
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
(0, 'i\'m the best', '2022-10-03 13:48:23', 'consider'),
(23, 'i_m the best', '2022-10-03 14:03:28', 'declain');

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
(3, '3@3', 'user2', '111', 0, 1),
(5, 'jfhhj', 'jjhjhf', 'dddd', 26, 1),
(6, 'fsdad', 'sdfsfd', 'fsdasdfafsdasdfafsdasdfasdff', 0, 0),
(10, 'ben', 'ben', 'ben', 1, 1),
(12, 'dada', 'dada', 'dadada', 1, 0),
(17, 'dsadsasa', 'dasddas', 'sadsadaa', 2, 0),
(21, 'fdsdasdf', 'rew42234f', 'fdsdf234234234', 0, 0),
(22, 'user', 'user', 'user', 0, 0),
(23, 'adad', 'adad', 'adad', 0, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
