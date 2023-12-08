-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 28 2023 г., 19:41
-- Версия сервера: 10.4.28-MariaDB
-- Версия PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `jewelry`
--

-- --------------------------------------------------------

--
-- Структура таблицы `earrings`
--

CREATE TABLE `earrings` (
  `id` int(11) UNSIGNED NOT NULL,
  `img_path` varchar(45) NOT NULL DEFAULT 'no_img.png',
  `name` varchar(45) NOT NULL,
  `material` int(10) UNSIGNED NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `cost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `earrings`
--

INSERT INTO `earrings` (`id`, `img_path`, `name`, `material`, `description`, `cost`) VALUES
(1, '1.jpg', 'Серьги из золота с бриллиантами', 1, 'NULL', 70000),
(2, '2.jpg', 'Серьги из золота с бриллиантами', 1, 'Классические серьги из золота с бриллиантами – базовое украшение, без которого не обойтись ни одной девушке. Бриллианты – всегда уместны, а тип застёжки, английский замок, признан одним из самых надёжных и комфортных. Кроме того, такое украшение будет без', 62000),
(3, '3.jpg', 'Серьги из комбинированного золота', 1, 'NULL', 50000),
(4, '4.jpg', 'Серьги из золота с жемчугом', 2, 'NULL', 5990),
(5, '5.jpg', 'Серьги из золота с жемчугом', 2, 'NULL', 9990),
(6, '6.jpg', 'Серьги из золота с изумрудами', 2, 'NULL', 70000),
(7, '7.jpg', 'Серьги из белого золота с бриллиантами', 3, 'NULL', 40000),
(8, '8.jpg', 'Серьги из белого золота с бриллиантами', 3, 'NULL', 44000),
(9, '9.jpg', 'Серьги из белого золота с бриллиантами', 3, 'NULL', 104000),
(10, '10.jpg', 'Серьги из белого золота с бриллиантами', 3, 'NULL', 62000),
(11, '11.jpg', 'Серьги из комбинированного золота ', 1, 'NULL', 36000),
(12, '12.jpg', 'Серьги из комбинированного золота ', 1, 'NULL', 56000),
(13, '13.jpg', 'Серьги из белого золота с бриллиантами', 3, 'NULL', 11990),
(14, '14.jpg', 'Серьги из белого золота с бриллиантами', 3, 'NULL', 30000),
(15, '15.jpg', 'Серьги из белого золота с бриллиантами', 3, 'NULL', 26000),
(16, '16.jpg', 'Серьги из золота с бриллиантами', 2, 'NULL', 72000),
(17, '17.jpg', 'Серьги из золота с бриллиантами', 2, 'NULL', 106000),
(18, '18.jpg', 'Серьги из золота с бриллиантами', 2, 'NULL', 88000),
(19, '19.jpg', 'Серьги из золота с бриллиантами', 2, 'NULL', 9900),
(20, '20.jpg', 'Серьги из золота с бриллиантами', 2, 'NULL', 12990);

-- --------------------------------------------------------

--
-- Структура таблицы `material`
--

CREATE TABLE `material` (
  `id` int(11) NOT NULL,
  `material_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `material`
--

INSERT INTO `material` (`id`, `material_name`) VALUES
(1, 'Комбинированное золото 585 пробы'),
(2, 'Красное золото 585 пробы'),
(3, 'Белое золото 585 пробы');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `full_name` text DEFAULT NULL,
  `date` date DEFAULT NULL,
  `gender` text DEFAULT NULL,
  `adress` text DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `url` text DEFAULT NULL,
  `interes` text DEFAULT NULL,
  `rhesus` text DEFAULT NULL,
  `blood` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `full_name`, `date`, `gender`, `adress`, `password`, `url`, `interes`, `rhesus`, `blood`) VALUES
(5, 'sivov@gmail.com', NULL, '2003-09-27', 'woman', 'г. Волгоград ул.Смирнова д.111', '$2y$10$Az9f3BgPn4cy46WTL8wGjuS7MW8JUgITZpQ2QGSTdUwQSFPL2QWUC', 'https://vk.com/grommasso', 'Машинка', 'Положительный (+)', 'A (II)'),
(6, 'NEsivov@mail.ru', NULL, '2004-09-28', 'man', 'г. Волгоград ул.Смирнова д.1011', '$2y$10$DCccyfDbFpcTScwRRR3oxe4RRbrIJoyP08/NGcXMeOT1xU4ele7ou', 'https://vk.com/Lox', 'Стрелялки', 'Отрицательный (-)', 'A (II)'),
(8, '12314@mail.com', 'FSAFSASFASF', '0000-00-00', '', '', '$2y$10$nh9.GfAntWe3bHxegcXxyesMY8RPqRoQjlAcfR9i2JCz1CTS9ZmnG', '', '', '', ''),
(9, '123124124@gmail.com', 'Сивов Иван Дмитриевич', '2004-09-27', 'man', 'г.Волгоград ул. Смирнова д.10', '$2y$10$fB2FHq.I/.bpA7DEcCo0wecpGyC4uks4ItwicJUItay0Q7TD3rLT2', 'https://vk.com/grommass', 'Машинки', 'Отрицательный (-)', 'A (II)');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `earrings`
--
ALTER TABLE `earrings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `url` (`url`) USING HASH;

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `earrings`
--
ALTER TABLE `earrings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `material`
--
ALTER TABLE `material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
