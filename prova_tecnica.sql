-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 11-06-2024 a las 09:45:56
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `test_prova`
--
CREATE DATABASE IF NOT EXISTS `test_prova` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `test_prova`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendars`
--

CREATE TABLE `calendars` (
  `id` bigint UNSIGNED NOT NULL,
  `order_date` date NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `calendars`
--

INSERT INTO `calendars` (`id`, `order_date`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(19, '2024-06-13', 18, 4, '103.96', '2024-06-06 13:56:51', '2024-06-06 13:56:51'),
(20, '2024-06-13', 1, 3, '20.97', '2024-06-06 13:56:51', '2024-06-06 13:56:51'),
(24, '2024-06-11', 18, 3, '77.97', '2024-06-07 07:16:53', '2024-06-07 07:16:53'),
(25, '2024-06-19', 11, 1, '6.99', '2024-06-07 07:26:47', '2024-06-07 07:26:47'),
(26, '2024-06-04', 1, 1, '6.99', '2024-06-07 11:38:23', '2024-06-07 11:38:23'),
(27, '2024-06-10', 1, 2, '13.98', '2024-06-10 12:49:17', '2024-06-10 12:49:17'),
(28, '2024-06-12', 18, 3, '77.97', '2024-06-11 05:58:08', '2024-06-11 05:58:08'),
(33, '2024-06-02', 1, 1, '6.99', '2024-06-11 07:11:58', '2024-06-11 07:11:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `code`, `name`, `description`, `parent_id`, `created_at`, `updated_at`) VALUES
(2, '4321', 'MEAT', 'The meat', NULL, NULL, '2024-06-06 07:11:08'),
(5, '12123', 'SALTY', 'The salty', NULL, NULL, '2024-06-10 08:50:50'),
(12, '12345', 'PINEAPPLE', 'The pineapples', 5, NULL, '2024-06-07 13:18:28'),
(14, '3213', 'FRUITS', 'The fruits', NULL, NULL, '2024-06-11 06:16:21'),
(15, '12112', 'WHITE', 'White meat', 2, NULL, '2024-06-06 13:52:12'),
(17, '1212311', 'RED', 'The red meat', 2, NULL, '2024-06-06 07:12:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category_products`
--

CREATE TABLE `category_products` (
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `category_products`
--

INSERT INTO `category_products` (`created_at`, `updated_at`, `category_id`, `product_id`) VALUES
(NULL, NULL, 2, 9),
(NULL, NULL, 2, 18),
(NULL, NULL, 5, 1),
(NULL, NULL, 5, 11),
(NULL, NULL, 12, 11),
(NULL, NULL, 17, 9),
(NULL, NULL, 17, 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `images`
--

CREATE TABLE `images` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `images`
--

INSERT INTO `images` (`id`, `product_id`, `image_path`, `created_at`, `updated_at`) VALUES
(52, 11, 'images/47Dr2Fksghx3z1NXx30U8Hg5HWpf7eqaUYoOoOVV.png', '2024-06-10 08:15:28', '2024-06-10 08:15:28'),
(53, 11, 'images/KAHcWWyioT8UN1ltlukhRE7MVBHrK7EuQOrlmwsW.png', '2024-06-10 08:15:28', '2024-06-10 08:15:28'),
(54, 11, 'images/Y6Q8g5rWyUL60Ubwl7bCzQc0B9pnVAooDdiDpOml.png', '2024-06-10 08:15:28', '2024-06-10 08:15:28'),
(55, 18, 'images/4b40zSfyKYQBBZfJNYQ6CZcPRK8vf5NJhGERhDjR.png', '2024-06-10 08:15:52', '2024-06-10 08:15:52'),
(56, 18, 'images/lUjpVmfiB1Xro1wMqC9Zq77b9a28Q0IYSrfBtnvM.png', '2024-06-10 08:15:52', '2024-06-10 08:15:52'),
(57, 18, 'images/pJM6Eqez3PEPdCOF9Ox01wcQdx78nVBkIPssisBI.png', '2024-06-10 08:15:52', '2024-06-10 08:15:52'),
(70, 1, 'images/9YClX1yvUQmEkFfJtaPWvfc80QSYmnYbOskxCclh.png', '2024-06-11 06:34:15', '2024-06-11 06:34:15'),
(71, 9, 'images/dmzQBoyxhqxDsjRVRF58BsrMjjDIrlwRWDvlrr7I.jpg', '2024-06-11 06:34:45', '2024-06-11 06:34:45'),
(72, 9, 'images/wzJil9BwGzxNiW7obiegz3AxyfPiwLQpfuurNBF4.jpg', '2024-06-11 06:34:45', '2024-06-11 06:34:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2024_06_03_000000_create_categories_table', 1),
(4, '2024_06_04_000000_create_products_table', 2),
(5, '2024_06_04_000001_create_products_table', 3),
(6, '2024_06_04_000002_create_products_table', 4),
(7, '2024_06_04_000003_create_products_table', 5),
(8, '2024_06_04_000005_create_category_product_table', 6),
(9, '2014_10_12_100000_create_password_resets_table', 7),
(10, '2024_06_05_135352_create_images_table', 7),
(11, '2024_06_05_154203_create_tariffs_table', 8),
(12, '2024_06_05_135351_create_images_table', 9),
(13, '2024_06_06_103734_create_calendar_table', 10),
(14, '2024_06_06_103733_create_calendars_table', 11),
(15, '2024_06_06_103732_create_calendars_table', 12),
(16, '2024_12_14_000001_create_personal_access_tokens_table', 13),
(17, '2019_12_14_000002_create_personal_access_tokens_table', 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(3, 'App\\Models\\User', 3, 'API TOKEN', 'ef47c9c1e918eb5323ae7e5be655153f3ed1048218153f2949f68a1a1de2db61', '[\"*\"]', '2024-06-10 13:13:59', NULL, '2024-06-10 12:49:03', '2024-06-10 13:13:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `code`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, '1', 'APPLE', 'Apples are fruit', NULL, NULL),
(9, '4321', 'POTATOES', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\r\n\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.', '2024-06-05 13:22:07', '2024-06-05 13:22:07'),
(11, '2212', 'CUCUMBERS', 'Cucumbers are vegetables', '2024-06-05 13:52:57', '2024-06-05 13:52:57'),
(18, '1234', 'CUPCAKES', 'Cupcakes are desserts', '2024-06-06 07:13:46', '2024-06-06 07:13:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tariffs`
--

CREATE TABLE `tariffs` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tariffs`
--

INSERT INTO `tariffs` (`id`, `product_id`, `price`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(57, 11, '6.99', '2021-12-12', '2024-12-14', '2024-06-10 08:15:28', '2024-06-10 08:15:28'),
(58, 18, '25.99', '2022-10-12', '2024-10-12', '2024-06-10 08:15:52', '2024-06-10 08:15:52'),
(78, 1, '6.99', '2023-10-12', '2024-10-12', '2024-06-11 06:34:15', '2024-06-11 06:34:15'),
(79, 1, '16.00', '2024-06-10', '2024-06-11', '2024-06-11 06:34:15', '2024-06-11 06:34:15'),
(80, 9, '7.99', '2022-11-12', '2022-11-14', '2024-06-11 06:34:45', '2024-06-11 06:34:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Yelko', 'test@example.com', NULL, '$2y$10$9eTs97gSxhqDZSb84xhh7.NYc.83Bsi9cwkLgzbaOKx7pQJ1Uq8de', '1vlmIqZv1SoqcGMQTnt9FgXWcQS8yz2ggr2NqiuYlexsU9yqyhe8DLbZLLFZ', NULL, NULL),
(2, 'Maxim', 'test@gmail.com', NULL, '$2y$12$K1XCzia0g0aNBPrT4arHTuH0035rFVEI2p8HRkntfMy9ayCsbQMhe', NULL, '2024-06-05 07:14:41', '2024-06-05 07:14:41'),
(3, 'Edu', 'test@yahoo.es', NULL, '$2y$12$QcGMZkIZT66SWqphyuhNyOsMYy4UUI06U32tsYH79fsS.Gu.xZpei', NULL, '2024-06-10 06:57:46', '2024-06-10 06:57:46');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calendars`
--
ALTER TABLE `calendars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `calendars_product_id_foreign` (`product_id`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indices de la tabla `category_products`
--
ALTER TABLE `category_products`
  ADD PRIMARY KEY (`category_id`,`product_id`),
  ADD KEY `category_products_producte_id_foreign` (`product_id`);

--
-- Indices de la tabla `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images_product_id_foreign` (`product_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_code_unique` (`code`);

--
-- Indices de la tabla `tariffs`
--
ALTER TABLE `tariffs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tariffs_product_id_start_date_end_date_unique` (`product_id`,`start_date`,`end_date`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calendars`
--
ALTER TABLE `calendars`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `tariffs`
--
ALTER TABLE `tariffs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `calendars`
--
ALTER TABLE `calendars`
  ADD CONSTRAINT `calendars_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `category_products`
--
ALTER TABLE `category_products`
  ADD CONSTRAINT `category_products_categoria_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `category_products_producte_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Filtros para la tabla `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tariffs`
--
ALTER TABLE `tariffs`
  ADD CONSTRAINT `tariffs_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
