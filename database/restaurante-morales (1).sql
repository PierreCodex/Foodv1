-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-05-2025 a las 08:15:45
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `restaurante-morales`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `admin_image` varchar(225) NOT NULL,
  `nationality` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(100) NOT NULL,
  `qty` int(10) NOT NULL,
  `total_cost` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cart`
--

INSERT INTO `cart` (`id`, `food_id`, `user_id`, `session_id`, `qty`, `total_cost`) VALUES
(38, 44, NULL, 'a8ca273r7cjds06cmgms3kijde', 1, '40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deliveryboys`
--

CREATE TABLE `deliveryboys` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nationality` varchar(20) NOT NULL,
  `db_image` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `food`
--

CREATE TABLE `food` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `food_name` varchar(50) NOT NULL,
  `food_desc` varchar(255) NOT NULL,
  `category` varchar(20) NOT NULL,
  `price` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `food`
--

INSERT INTO `food` (`id`, `image`, `food_name`, `food_desc`, `category`, `price`) VALUES
(32, '/images/ceviche.jpg', 'Ceviche Clásico', 'Pescado fresco marinado con limón, cebolla y cilantro.', 'Mariscos', '35.00'),
(33, '/images/arroz_chaufa.jpg', 'Arroz Chaufa', 'Arroz frito al estilo chino-peruano con pollo y verduras.', 'Arroces', '28.00'),
(34, '/images/anticuchos.jpg', 'Anticuchos', 'Brochetas de corazón de res con salsa de ají.', 'Anticuchos', '22.00'),
(35, '/images/lomo_saltado.jpg', 'Lomo Saltado', 'Trozos de carne salteados con cebolla, tomate y papas.', 'Carnes', '32.00'),
(36, '/images/tacu_tacu.jpg', 'Tacu Tacu', 'Mezcla de arroz y frijoles fritos, acompañado de huevo.', 'Arroces', '24.00'),
(37, '/images/jugo_maracuya.jpg', 'Jugo de Maracuyá', 'Bebida refrescante de fruta de la pasión.', 'Bebidas', '10.00'),
(38, '/images/picarones.jpg', 'Picarones', 'Dulce frito de camote y zapallo con chancaca.', 'Postres', '18.00'),
(39, '/images/causa_limeña.jpg', 'Causa Limeña', 'Purê de papa amarilla con pollo y mayonesa.', 'Entradas', '30.00'),
(40, '/images/ceviche.jpg', 'Ceviche Clásico', 'Pescado fresco marinado con limón, cebolla y cilantro.', 'food', '35.00'),
(41, '/images/causa.jpg', 'Causa Limeña', 'Puré de papa amarilla relleno con pollo y mayonesa.', 'food', '30.00'),
(42, '/images/jugo_maracuya.jpg', 'Jugo de Maracuyá', 'Refrescante bebida natural de fruta de la pasión.', 'drinks', '10.00'),
(43, '/images/limonada.jpg', 'Limonada', 'Limonada casera con hierbabuena.', 'drinks', '8.00'),
(44, '/images/pizza.jpg', 'Pizza Pepperoni', 'Masa artesanal, salsa de tomate y pepperoni.', 'fastfood', '40.00'),
(45, '/images/hamburguesa.jpg', 'Hamburguesa Doble', 'Carne de res, queso, lechuga, tomate y salsa especial.', 'fastfood', '32.00'),
(46, '/images/cheesecake.jpg', 'Cheesecake', 'Pastel de queso cremoso con base de galleta.', 'cakes', '25.00'),
(47, '/images/tarta_fresa.jpg', 'Tarta de Fresa', 'Bizcocho suave con crema y fresas frescas.', 'cakes', '28.00'),
(48, '/images/picarones.jpg', 'Picarones', 'Aros fritos de camote y zapallo con miel de chancaca.', 'dessert', '18.00'),
(49, '/images/arroz_con_leche.jpg', 'Arroz con Leche', 'Postre cremoso de arroz con leche y canela.', 'dessert', '15.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `cart_ID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `cust_fname` varchar(15) NOT NULL,
  `cust_sname` varchar(15) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `location` varchar(225) NOT NULL,
  `email` varchar(50) NOT NULL,
  `street` varchar(15) NOT NULL,
  `building` varchar(10) NOT NULL,
  `message` varchar(225) NOT NULL,
  `total_cost` varchar(10) NOT NULL,
  `order_status` varchar(20) NOT NULL,
  `payment` varchar(200) NOT NULL,
  `updated_by` varchar(50) NOT NULL,
  `updated_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tablereservations`
--

CREATE TABLE `tablereservations` (
  `id` int(11) NOT NULL,
  `guest_name` varchar(50) NOT NULL,
  `people` int(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `message` varchar(255) NOT NULL,
  `expenses` varchar(100) NOT NULL,
  `updated_by` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(9) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`) VALUES
(1, 'Carlos', 'pierrecodex@gmail.com', 'i7zdanger', '981912809', 'santa isabel'),
(2, 'Jean Pierre', 'hi@namankhare.com', '$2y$10$aggHHMugXizh40Fvty8JVex2G..AHtoHEnzrwKwDzDchaLPBjpUR.', NULL, NULL),
(3, 'Jean', 'maria.lopez@empresa.com', '$2y$10$9/WXCyfOGVgHtEbiza4rO.aKtBS5JVewi2C9TqQzOYukmzKiWeRDG', '981912809', 'Urb Ignacio Merino 2da Etapa Mz Lote 27'),
(4, 'Carla', 'carla@gmail.com', '$2y$10$YvR4PGKBu/EiJIKIwaZrK.BCZzQCdI.C0U3F6uefb4tem..SxRrqe', '987897896', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cart_food` (`food_id`),
  ADD KEY `idx_cart_user` (`user_id`);

--
-- Indices de la tabla `deliveryboys`
--
ALTER TABLE `deliveryboys`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orders_cart` (`cart_ID`),
  ADD KEY `fk_orders_users` (`user_id`),
  ADD KEY `fk_orders_admin` (`admin_id`);

--
-- Indices de la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_reviews_user` (`user_id`),
  ADD KEY `idx_reviews_food` (`food_id`);

--
-- Indices de la tabla `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tablereservations`
--
ALTER TABLE `tablereservations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `deliveryboys`
--
ALTER TABLE `deliveryboys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `food`
--
ALTER TABLE `food`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tablereservations`
--
ALTER TABLE `tablereservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cart_food` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_admin` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_orders_cart` FOREIGN KEY (`cart_ID`) REFERENCES `cart` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`cart_ID`) REFERENCES `cart` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_food` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reviews_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
