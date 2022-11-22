-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 22-11-2022 a las 11:51:54
-- Versión del servidor: 10.9.3-MariaDB-1:10.9.3+maria~ubu2204
-- Versión de PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `aerbide`
--
CREATE DATABASE IF NOT EXISTS `aerbide` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `aerbide`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bookmarks`
--

DROP TABLE IF EXISTS `bookmarks`;
CREATE TABLE `bookmarks` (
  `user` int(11) NOT NULL,
  `post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `bookmarks`
--

INSERT INTO `bookmarks` (`user`, `post`) VALUES
(2, 2),
(2, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Logística'),
(2, 'Producción'),
(3, 'Ingeniería'),
(4, 'Calidad'),
(5, 'Financiero'),
(6, 'Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `author` int(11) NOT NULL,
  `post` int(11) DEFAULT NULL,
  `comment` int(11) DEFAULT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `file` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comments`
--

INSERT INTO `comments` (`id`, `text`, `author`, `post`, `comment`, `creation_date`, `file`) VALUES
(1, 'De locos... Estoy orgullosa de ti!!!!\r\n\r\nBesis', 2, 2, NULL, '2022-11-22 11:38:45', NULL),
(2, 'El foro es para cosas serias, gracias....', 1, 3, NULL, '2022-11-22 11:44:08', NULL),
(3, 'Nada chicos, ya está, gracias por vuestra ayuda vacía....', 4, 4, NULL, '2022-11-22 11:46:16', NULL),
(4, 'arriaga@egibide.org\r\n\r\nSon 5€ gracias.', 4, 5, NULL, '2022-11-22 11:48:46', NULL),
(5, 'jaja, otro archivo, mira', 4, 2, NULL, '2022-11-22 11:50:18', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `files`
--

DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `files`
--

INSERT INTO `files` (`id`, `name`, `path`) VALUES
(1, 'archivo.txt', '637cb48b70d532.39927949'),
(2, 'archivo.txt', '637cb77a789883.27298034');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `followers`
--

DROP TABLE IF EXISTS `followers`;
CREATE TABLE `followers` (
  `source` int(11) NOT NULL,
  `destination` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `category` int(11) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `author` int(11) NOT NULL,
  `file` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`id`, `title`, `text`, `category`, `creation_date`, `author`, `file`) VALUES
(1, 'Mi primer post', 'Hola jaja, soy nuevo en la empresa. Me llamo Gaizka y me gusta subir Posts para subir puntos y ser el mejor.', 3, '2022-11-22 11:35:23', 1, NULL),
(2, 'Este post tiene Archivos!!', 'Hola de nuevo, aquí os muestro unos archivos de ejemplo....', 1, '2022-11-22 11:37:47', 1, 1),
(3, 'Problema de calidad en los aviones', 'En realidad no hay ningún problema jajjaa, soy un risas.... Nuestros aviones son los mejores del mundo.', 4, '2022-11-22 11:43:43', 3, NULL),
(4, 'URGENTE!!!!! NECESITAMOS DINERO!!!!', '¿Cómo podemos conseguir dinero para financiar los nuevos aviones? Llevo días pensándolo y no se me ocurre nada... \r\n\r\nAYUDA!!!!!', 5, '2022-11-22 11:45:56', 4, NULL),
(5, 'Necesitamos materiales', 'En el sector de producción nos estamos quedando sin acero valirio... Alguien me envía el email del proveedor por favor?', 2, '2022-11-22 11:48:12', 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tagged`
--

DROP TABLE IF EXISTS `tagged`;
CREATE TABLE `tagged` (
  `tag` int(11) NOT NULL,
  `post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tagged`
--

INSERT INTO `tagged` (`tag`, `post`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `counter` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tags`
--

INSERT INTO `tags` (`id`, `name`, `counter`) VALUES
(1, 'primero', 1),
(2, 'archivos', 1),
(3, 'lmao', 1),
(4, 'materiales', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `points` int(11) NOT NULL DEFAULT 0,
  `job` varchar(64) DEFAULT NULL,
  `passwd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `surname`, `image`, `date`, `points`, `job`, `passwd`) VALUES
(1, 'gaizka', 'Gaizka', NULL, NULL, '2022-11-22', 10, NULL, 'gaizka'),
(2, 'tania', 'Tania', 'Hernando', NULL, '2022-11-22', 5, 'Alcantarillera', 'tania'),
(3, 'victor', 'Victor', 'Ibáñez', NULL, '2022-11-22', 5, 'Maquetador', 'victor'),
(4, 'imanol', 'Imanol', 'Urquijo', NULL, '2022-11-22', 5, NULL, 'imanol');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votes`
--

DROP TABLE IF EXISTS `votes`;
CREATE TABLE `votes` (
  `user` int(11) NOT NULL,
  `comment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `votes`
--

INSERT INTO `votes` (`user`, `comment`) VALUES
(1, 3),
(2, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`user`,`post`),
  ADD KEY `post` (`post`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author` (`author`),
  ADD KEY `post` (`post`),
  ADD KEY `comment` (`comment`),
  ADD KEY `file` (`file`);

--
-- Indices de la tabla `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`source`,`destination`),
  ADD KEY `destination` (`destination`);

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`),
  ADD KEY `file` (`file`);

--
-- Indices de la tabla `tagged`
--
ALTER TABLE `tagged`
  ADD PRIMARY KEY (`tag`,`post`),
  ADD KEY `post` (`post`);

--
-- Indices de la tabla `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indices de la tabla `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`user`,`comment`),
  ADD KEY `comment` (`comment`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookmarks_ibfk_2` FOREIGN KEY (`post`) REFERENCES `posts` (`id`);

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`author`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`comment`) REFERENCES `comments` (`id`),
  ADD CONSTRAINT `comments_ibfk_4` FOREIGN KEY (`file`) REFERENCES `files` (`id`);

--
-- Filtros para la tabla `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`destination`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`source`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`file`) REFERENCES `files` (`id`);

--
-- Filtros para la tabla `tagged`
--
ALTER TABLE `tagged`
  ADD CONSTRAINT `tagged_ibfk_1` FOREIGN KEY (`tag`) REFERENCES `tags` (`id`),
  ADD CONSTRAINT `tagged_ibfk_2` FOREIGN KEY (`post`) REFERENCES `posts` (`id`);

--
-- Filtros para la tabla `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`comment`) REFERENCES `comments` (`id`);
COMMIT;
