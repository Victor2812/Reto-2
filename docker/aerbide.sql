-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 25-11-2022 a las 10:55:55
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
(1, 28),
(1, 31),
(2, 2),
(2, 5),
(2, 15),
(2, 18),
(2, 20),
(2, 22),
(3, 2),
(3, 10),
(3, 22),
(3, 23),
(3, 24),
(4, 2),
(4, 7),
(4, 9),
(4, 11),
(4, 12),
(4, 13),
(4, 15),
(4, 21),
(4, 22),
(4, 24),
(4, 25),
(4, 26),
(4, 27),
(4, 28);

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
(1, 'Logistica'),
(2, 'Produccion'),
(3, 'Ingenieria'),
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
(3, 'Nada chicos, ya esta, gracias por vuestra ayuda vacia....', 4, 4, NULL, '2022-11-22 11:46:16', NULL),
(4, 'arriaga@egibide.org\r\n\r\nSon 5â‚¬ gracias.', 4, 5, NULL, '2022-11-22 11:48:46', NULL),
(5, 'jaja, otro archivo, mira', 4, 2, NULL, '2022-11-22 11:50:18', 2),
(6, 'Mientras no se estrellen...', 4, 3, NULL, '2022-11-25 07:40:12', NULL),
(7, 'Y primer comentario', 4, 1, NULL, '2022-11-25 07:40:56', NULL),
(8, 'Podemos darles un redbull por las mañanas', 1, 7, NULL, '2022-11-25 07:51:00', NULL),
(9, 'Felicidades a todos los departamentos', 1, 8, NULL, '2022-11-25 07:51:51', NULL),
(10, 'Deja de pagar al proveedor hasta que solucione el problema', 1, 6, NULL, '2022-11-25 07:52:47', NULL),
(11, 'Mira que bien', 2, 8, NULL, '2022-11-25 07:59:13', NULL),
(12, 'La empresa no lo va a pagar', 2, NULL, 8, '2022-11-25 08:00:37', NULL),
(13, '¿ De que modelo estamos hablando ? ', 3, 10, NULL, '2022-11-25 08:07:56', NULL),
(14, 'Necesitamos mas personal en produccion !!', 3, 7, NULL, '2022-11-25 08:08:47', NULL),
(15, 'Puedes provar en AliExpress...', 3, 5, NULL, '2022-11-25 08:10:06', NULL),
(16, 'No deveriamos ir tan rapido', 4, 10, NULL, '2022-11-25 08:26:30', NULL),
(17, 'Dicen que el problema no es suyo.', 4, 9, NULL, '2022-11-25 08:28:22', NULL),
(18, 'No haciendo errores', 2, 15, NULL, '2022-11-25 08:44:10', NULL),
(19, 'Vaya mierda !', 2, 16, NULL, '2022-11-25 08:44:33', NULL),
(20, 'No creo que sea lo mas adecuado', 2, 19, NULL, '2022-11-25 08:45:20', NULL),
(21, 'Mientras siga teniendo maquina de Nespresso puedes reducir lo que quieras', 2, 18, NULL, '2022-11-25 08:52:24', 4),
(22, 'De que se encargaria ese departamento ?', 3, 14, NULL, '2022-11-25 08:54:00', NULL),
(23, 'Pero todos tendremos aginaldo, no ?', 3, 16, NULL, '2022-11-25 08:55:10', NULL),
(24, 'Tienes que hablar con recursos humanos', 3, 20, NULL, '2022-11-25 09:01:47', NULL),
(25, 'Me parece bien', 3, 22, NULL, '2022-11-25 09:13:41', NULL),
(26, 'Eso es buena señal, pero no debemos relajarnos', 3, 21, NULL, '2022-11-25 09:14:24', NULL),
(27, 'Mientras sea mas economico me parece correcto', 3, 19, NULL, '2022-11-25 09:16:29', NULL),
(28, 'No volvera a pasar', 4, 25, NULL, '2022-11-25 09:30:11', 5),
(29, 'Deverias preguntar al departamento de logistica.', 4, 24, NULL, '2022-11-25 09:31:03', NULL),
(30, 'Compro !!', 4, 22, NULL, '2022-11-25 09:31:34', NULL),
(31, 'Eso esta muy bien !', 4, 21, NULL, '2022-11-25 09:32:13', NULL),
(32, 'Depende del motivo por el que la pidas', 4, 20, NULL, '2022-11-25 09:32:58', NULL),
(33, 'Pues habra que pasarse por la oficina', 4, 16, NULL, '2022-11-25 09:33:43', NULL),
(34, 'Y no pongais nada en broma', 4, 26, NULL, '2022-11-25 09:35:31', NULL),
(35, 'Mira en la web del proveedor', 1, 24, NULL, '2022-11-25 09:41:03', NULL),
(36, 'Deveriamos hacer los aviones mas ligeros', 1, 26, NULL, '2022-11-25 09:41:35', NULL),
(37, 'A ver si se va a estrellar el avion', 1, 27, NULL, '2022-11-25 09:42:18', NULL),
(38, 'Por que no contratamos a Glovo de manera provisional', 1, 28, NULL, '2022-11-25 09:42:49', NULL);

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
(2, 'archivo.txt', '637cb77a789883.27298034'),
(3, 'material.png', '638070fd0bfaf4.70246346'),
(4, '2.png', '63808248a1aba3.61478780'),
(5, '3.png', '63808b23e21013.94306895');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `followers`
--

DROP TABLE IF EXISTS `followers`;
CREATE TABLE `followers` (
  `source` int(11) NOT NULL,
  `destination` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `followers`
--

INSERT INTO `followers` (`source`, `destination`) VALUES
(1, 2),
(1, 3),
(1, 4),
(2, 1),
(2, 3),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(4, 3);

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
(2, 'Este post tiene Archivos!!', 'Hola de nuevo, aqui os muestro unos archivos de ejemplo....', 1, '2022-11-22 11:37:47', 1, 1),
(3, 'Problema de calidad en los aviones', 'En realidad no hay ningun problema jajjaa, soy un risas.... Nuestros aviones son los mejores del mundo.', 4, '2022-11-22 11:43:43', 3, NULL),
(4, 'URGENTE!!!!! NECESITAMOS DINERO!!!!', 'Â¿Como podemos conseguir dinero para financiar los nuevos aviones? Llevo dias pensandolo y no se me ocurre nada... \r\n\r\nAYUDA!!!!!', 5, '2022-11-22 11:45:56', 4, NULL),
(5, 'Necesitamos materiales', 'En el sector de produccion nos estamos quedando sin acero valirio... Alguien me envia el email del proveedor por favor?', 2, '2022-11-22 11:48:12', 2, NULL),
(6, 'Problema con el acabado de algunos materiales', 'Muchos de los metales que están llegando a la fase de montaje final no tienen el pulido adecuado.(adjunto foto)\r\n¿ alguien sabe como solucionarlo ?', 4, '2022-11-25 07:38:37', 4, 3),
(7, 'Ideas para mejoras en el ritmo de produccion', 'Si teneis alguna idea para mejorar la produccion, enviarla al departamento de produccion.', 2, '2022-11-25 07:46:33', 4, NULL),
(8, 'Premio a la empresa mas innovadora', 'Felicidades,  hemos ganado un premio a la empresa innovadora del siglo.', 6, '2022-11-25 07:49:55', 1, NULL),
(9, 'Los envios de materiales no llegan', 'Los envios por tierra no llegan a tiempo a su destino, por favor que alguien hable con el almacen.', 1, '2022-11-25 07:56:05', 2, NULL),
(10, 'Nueva prueba', 'Estamos realizando pruebas en el tunel del viento con el nuevo prototipo.', 3, '2022-11-25 07:58:16', 2, NULL),
(11, 'Acciones de la empresa', 'El proximo lunes, saldra a la venta un paquete de acciones de la empresa que pueden comprar los empleados, estariais interesados', 5, '2022-11-25 08:04:11', 3, NULL),
(12, 'Ataque informatico', 'Hemos recivido un ataque informatico, cuidado con lo que descargais desde el trabajo', 6, '2022-11-25 08:06:40', 3, NULL),
(13, 'Menudos Ingeniros', 'La calidad de la ingeniería esta dejando mucho que desear', 3, '2022-11-25 08:22:36', 4, NULL),
(14, 'Nuevo departamento', 'Se a planteado la apertura de un nuevo departamento, que os parece la idea ?', 6, '2022-11-25 08:23:42', 4, NULL),
(15, 'Produccion ralentizada', 'Los errores estan ralentizando la produccion de los aviones, como se puede solucionar', 2, '2022-11-25 08:25:57', 4, NULL),
(16, 'Fiesta de Navidad', 'Este año la fiesta de navidad se hara solo para los trabajadores de la oficina.', 6, '2022-11-25 08:31:09', 1, NULL),
(17, 'Avion sin alas', 'Queremos hacer un avion sini alas, alguno sabe como hacerlo?', 3, '2022-11-25 08:37:44', 1, NULL),
(18, 'Reduccion de presupuesto', 'El presupuesto de los siguientes departamentos se reducira el proximo trimestre: calidad y produccion.', 5, '2022-11-25 08:39:34', 1, NULL),
(19, 'Nueva politica ', 'En base a las mejoras planteadas, se implantara un metodo Just in time en la logistica del almacen.', 1, '2022-11-25 08:42:25', 1, NULL),
(20, 'Reduccion de jornada', 'Alguien sabe como conseguir una reduccion de jornada ?', 6, '2022-11-25 08:46:37', 2, NULL),
(21, 'Lista de pedidos', 'La lista de pedidos esta llena para los proximos 4 años.', 5, '2022-11-25 08:47:57', 2, NULL),
(22, 'Plazas en el parking', 'Deveriamos asignar las plazas del aparcamiento a los trabajadores mas veteranos.', 6, '2022-11-25 08:50:15', 2, NULL),
(23, 'Fabricacion avanzada', 'La fabricacion de los nuevos modelos esta muy avanzada', 2, '2022-11-25 09:08:55', 3, NULL),
(24, 'Materiales de calidad', 'Las distintas calidades de materiales estan determinadas en unas tablas del proveedor, donde estan esas tablas ?', 4, '2022-11-25 09:11:12', 3, NULL),
(25, 'Preguntas absurdas', 'Se han estado realizando preguntas no muy profesionales en la web, por favor no lo hagais', 6, '2022-11-25 09:13:12', 3, NULL),
(26, 'Mejoras importantes', 'Si teneis ideas para mejoras en el diseño decidlas', 3, '2022-11-25 09:35:10', 4, NULL),
(27, 'Estandares de calidad', 'Se van a modificar los estandares de calidad del montaje final para reducir costes', 4, '2022-11-25 09:36:58', 4, NULL),
(28, 'Huelga de camioneros', 'Devido a la huelga de transportistas los envios de material se realizaran en bicicleta.', 1, '2022-11-25 09:38:53', 4, NULL),
(29, 'Stock de material', 'Tenemos escasez de pinturas aislantes y de pernos, esto no deveria suceder !', 1, '2022-11-25 09:44:30', 1, NULL),
(30, 'Avion no pasa revision', 'Se han detectado problemas en la revision final del nuevo modelo, se para su produccion hasta reparar los fallos.', 4, '2022-11-25 09:46:32', 1, NULL),
(31, 'Simulacro de incendio', 'Para mejorar la seguridad, se realizaran simulacros de incendio mas a menudo. ', 6, '2022-11-25 09:49:40', 1, NULL),
(32, 'Fuera de plazo', 'Los retrasos en la produccion han provocado que el ultimo avion se entrege fuera de plazo, como podemos solucionarlo.', 2, '2022-11-25 09:52:51', 2, NULL);

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
(4, 5),
(4, 6),
(4, 9),
(4, 24),
(4, 26),
(4, 29),
(5, 6),
(6, 7),
(6, 10),
(6, 12),
(6, 17),
(6, 19),
(6, 22),
(6, 26),
(6, 31),
(7, 11),
(7, 18),
(8, 13),
(9, 14),
(9, 28),
(10, 23),
(11, 27),
(12, 30);

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
(4, 'materiales', 6),
(5, 'aluminio', 1),
(6, 'mejoras', 8),
(7, 'dinero', 2),
(8, 'diseño', 1),
(9, 'novedad', 2),
(10, 'air360', 1),
(11, 'fabricacion', 1),
(12, 'fallos', 1);

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
(1, 'gaizka', 'Gaizka', NULL, NULL, '2022-11-22', 125, NULL, 'gaizka'),
(2, 'tania', 'Tania', 'Hernando', NULL, '2022-11-22', 95, 'Alcantarillera', 'tania'),
(3, 'victor', 'Victor', 'IbaÃ±ez', NULL, '2022-11-22', 100, 'Maquetador', 'victor'),
(4, 'imanol', 'Imanol', 'Urquijo', NULL, '2022-11-22', 140, NULL, 'imanol');

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
(2, 3),
(2, 20),
(3, 26),
(4, 29),
(4, 33);

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
  ADD KEY `file` (`file`),
  ADD KEY `author` (`author`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`file`) REFERENCES `files` (`id`),
  ADD CONSTRAINT `posts_ibfk_3` FOREIGN KEY (`author`) REFERENCES `users` (`id`);

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
