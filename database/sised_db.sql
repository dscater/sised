-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 13-06-2025 a las 20:11:14
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sised_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cadena_custodias`
--

CREATE TABLE `cadena_custodias` (
  `id` bigint UNSIGNED NOT NULL,
  `evidencia_id` bigint UNSIGNED NOT NULL,
  `responsable` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cargo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `destino` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracions`
--

CREATE TABLE `configuracions` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre_sistema` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `configuracions`
--

INSERT INTO `configuracions` (`id`, `nombre_sistema`, `alias`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'SISED', 'SISED', 'logo.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control_integridads`
--

CREATE TABLE `control_integridads` (
  `id` bigint UNSIGNED NOT NULL,
  `evidencia_id` bigint UNSIGNED NOT NULL,
  `fecha_alteracion` date NOT NULL,
  `hora_alteracion` time NOT NULL,
  `encriptado_original` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `encriptado_alteracion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evidencias`
--

CREATE TABLE `evidencias` (
  `id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_creador` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_creacion` date NOT NULL,
  `hora_creacion` time NOT NULL,
  `origen_archivo` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_hallazgo` date NOT NULL,
  `hora_hallazgo` time NOT NULL,
  `lugar_recoleccion` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `persona_recolector` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `herramienta_utilizada` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `evidencias`
--

INSERT INTO `evidencias` (`id`, `codigo`, `descripcion`, `nombre_creador`, `fecha_creacion`, `hora_creacion`, `origen_archivo`, `fecha_hallazgo`, `hora_hallazgo`, `lugar_recoleccion`, `persona_recolector`, `herramienta_utilizada`, `fecha_registro`, `status`, `created_at`, `updated_at`) VALUES
(1, 'EVI01', 'DESC', 'JUAN PERES', '2025-01-01', '09:00:00', 'ORIGEN ARCHIVO', '2025-01-01', '05:00:00', 'LUGAR RECOLECCION', 'JUAN PERES', 'HERRAMIENTA USADA', '2025-06-13', 1, '2025-06-13 20:08:42', '2025-06-13 20:08:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evidencia_archivos`
--

CREATE TABLE `evidencia_archivos` (
  `id` bigint UNSIGNED NOT NULL,
  `evidencia_id` bigint UNSIGNED NOT NULL,
  `archivo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hash_archivo` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `evidencia_archivos`
--

INSERT INTO `evidencia_archivos` (`id`, `evidencia_id`, `archivo`, `hash_archivo`, `created_at`, `updated_at`) VALUES
(1, 1, '011749845322.mp4', 'f20619921b55a3ee2d3ceebbad4dbba83dd8b6ba6c0414b152ed7f6f050f1761', '2025-06-13 20:08:42', '2025-06-13 20:08:42'),
(2, 1, '111749845322.pdf', 'df1c9ac8f3bdf88b7e8ad1860ae1ab5833bd1328649e4fc4b16f03e592e7eca9', '2025-06-13 20:08:42', '2025-06-13 20:08:42'),
(3, 1, '211749845322.docx', 'b30efc6534ae1c0c65102d96e379ea9f1e879cbb881d666821b87fe23d8e6724', '2025-06-13 20:08:42', '2025-06-13 20:08:42'),
(4, 1, '311749845322.jpg', 'd32bf753da66cccf03da6e01736ecfaf76ce806e18d6afdadff124e86478091e', '2025-06-13 20:08:42', '2025-06-13 20:08:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_accions`
--

CREATE TABLE `historial_accions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `accion` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `datos_original` json DEFAULT NULL,
  `datos_nuevo` json DEFAULT NULL,
  `modulo` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `sistema` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `historial_accions`
--

INSERT INTO `historial_accions` (`id`, `user_id`, `accion`, `descripcion`, `datos_original`, `datos_nuevo`, `modulo`, `fecha`, `hora`, `sistema`, `ip`, `created_at`, `updated_at`) VALUES
(1, 1, 'CREACIÓN', 'EL USUARIO admin REGISTRO UN USUARIO', '{\"ci\": \"123456\", \"id\": 11, \"dir\": \"LOS OLIVOS\", \"fono\": \"65656565\", \"foto\": \"111749839223.jpg\", \"tipo\": \"ADMINISTRADOR\", \"acceso\": \"1\", \"ci_exp\": \"LP\", \"correo\": \"juan@gmail.com\", \"nombre\": \"JUAN\", \"materno\": \"MAMANI\", \"paterno\": \"PERES\", \"usuario\": \"juan@gmail.com\", \"created_at\": \"2025-06-13T18:27:03.000000Z\", \"updated_at\": \"2025-06-13T18:27:03.000000Z\", \"fecha_registro\": \"2025-06-13\"}', NULL, 'USUARIOS', '2025-06-13', '14:27:03', 'Equipo Escritorio - S.O. Windows - Navegador Chrome', '127.0.0.1', '2025-06-13 18:27:03', '2025-06-13 18:27:03'),
(2, 1, 'CREACIÓN', 'EL USUARIO admin REGISTRO UN USUARIO', '{\"ci\": \"123456\", \"id\": 2, \"dir\": \"ZONA LOS OLIVOS\", \"fono\": \"76767676\", \"foto\": \"21749839361.jpg\", \"tipo\": \"ADMINISTRADOR\", \"acceso\": \"1\", \"ci_exp\": \"LP\", \"correo\": \"juan@gmail.com\", \"nombre\": \"JUAN\", \"materno\": \"MAMANI\", \"paterno\": \"PERES\", \"usuario\": \"juan@gmail.com\", \"created_at\": \"2025-06-13T18:29:21.000000Z\", \"updated_at\": \"2025-06-13T18:29:21.000000Z\", \"fecha_registro\": \"2025-06-13\"}', NULL, 'USUARIOS', '2025-06-13', '14:29:21', 'Equipo Escritorio - S.O. Windows - Navegador Chrome', '127.0.0.1', '2025-06-13 18:29:21', '2025-06-13 18:29:21'),
(3, 1, 'MODIFICACIÓN', 'EL USUARIO admin ACTUALIZÓ UN USUARIO', '{\"ci\": \"123456\", \"id\": 2, \"dir\": \"ZONA LOS OLIVOS\", \"fono\": \"76767676\", \"foto\": \"21749839361.jpg\", \"tipo\": \"ADMINISTRADOR\", \"acceso\": 1, \"ci_exp\": \"LP\", \"correo\": \"juan@gmail.com\", \"nombre\": \"JUAN\", \"status\": 1, \"materno\": \"MAMANI\", \"paterno\": \"PERES\", \"usuario\": \"juan@gmail.com\", \"created_at\": \"2025-06-13T18:29:21.000000Z\", \"updated_at\": \"2025-06-13T18:29:21.000000Z\", \"fecha_registro\": \"2025-06-13\"}', '{\"ci\": \"123456\", \"id\": 2, \"dir\": \"ZONA LOS OLIVOS\", \"fono\": \"76767676\", \"foto\": \"21749839909.jpg\", \"tipo\": \"ADMINISTRADOR\", \"acceso\": \"1\", \"ci_exp\": \"LP\", \"correo\": \"juan@gmail.com\", \"nombre\": \"JUAN\", \"status\": 1, \"materno\": \"MAMANI\", \"paterno\": \"PERES\", \"usuario\": \"juan@gmail.com\", \"created_at\": \"2025-06-13T18:29:21.000000Z\", \"updated_at\": \"2025-06-13T18:38:29.000000Z\", \"fecha_registro\": \"2025-06-13\"}', 'USUARIOS', '2025-06-13', '14:38:29', 'Equipo Escritorio - S.O. Windows - Navegador Chrome', '127.0.0.1', '2025-06-13 18:38:29', '2025-06-13 18:38:29');

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
(1, '2024_01_31_165641_create_configuracions_table', 1),
(2, '2024_11_02_153317_create_users_table', 1),
(3, '2024_11_02_153318_create_historial_accions_table', 1),
(4, '2025_06_08_181910_create_evidencias_table', 2),
(5, '2025_06_08_181926_create_cadena_custodias_table', 2),
(6, '2025_06_08_181935_create_control_integridads_table', 2),
(7, '2025_06_08_184526_create_evidencia_archivos_table', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `usuario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paterno` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `materno` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ci` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ci_exp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dir` varchar(600) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fono` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `acceso` int NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_registro` date NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `usuario`, `nombre`, `paterno`, `materno`, `ci`, `ci_exp`, `dir`, `correo`, `fono`, `password`, `acceso`, `tipo`, `foto`, `fecha_registro`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'admin', NULL, '0', '', '', NULL, '', '$2y$12$65d4fgZsvBV5Lc/AxNKh4eoUdbGyaczQ4sSco20feSQANshNLuxSC', 1, 'ADMINISTRADOR', NULL, '2025-06-06', 1, NULL, NULL),
(2, 'juan@gmail.com', 'JUAN', 'PERES', 'MAMANI', '123456', 'LP', 'ZONA LOS OLIVOS', 'juan@gmail.com', '76767676', '$2y$12$c/SadN/8ivZnWH3UsPsIu.rJaa31GisVFIFXDRhtigPWxmr14Vu5.', 1, 'ADMINISTRADOR', '21749839909.jpg', '2025-06-13', 1, '2025-06-13 18:29:21', '2025-06-13 18:38:29');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cadena_custodias`
--
ALTER TABLE `cadena_custodias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cadena_custodias_evidencia_id_foreign` (`evidencia_id`);

--
-- Indices de la tabla `configuracions`
--
ALTER TABLE `configuracions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `control_integridads`
--
ALTER TABLE `control_integridads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `control_integridads_evidencia_id_foreign` (`evidencia_id`);

--
-- Indices de la tabla `evidencias`
--
ALTER TABLE `evidencias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `evidencias_codigo_unique` (`codigo`);

--
-- Indices de la tabla `evidencia_archivos`
--
ALTER TABLE `evidencia_archivos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evidencia_archivos_evidencia_id_foreign` (`evidencia_id`);

--
-- Indices de la tabla `historial_accions`
--
ALTER TABLE `historial_accions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `historial_accions_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cadena_custodias`
--
ALTER TABLE `cadena_custodias`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuracions`
--
ALTER TABLE `configuracions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `control_integridads`
--
ALTER TABLE `control_integridads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `evidencias`
--
ALTER TABLE `evidencias`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `evidencia_archivos`
--
ALTER TABLE `evidencia_archivos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `historial_accions`
--
ALTER TABLE `historial_accions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cadena_custodias`
--
ALTER TABLE `cadena_custodias`
  ADD CONSTRAINT `cadena_custodias_evidencia_id_foreign` FOREIGN KEY (`evidencia_id`) REFERENCES `evidencias` (`id`);

--
-- Filtros para la tabla `control_integridads`
--
ALTER TABLE `control_integridads`
  ADD CONSTRAINT `control_integridads_evidencia_id_foreign` FOREIGN KEY (`evidencia_id`) REFERENCES `evidencias` (`id`);

--
-- Filtros para la tabla `evidencia_archivos`
--
ALTER TABLE `evidencia_archivos`
  ADD CONSTRAINT `evidencia_archivos_evidencia_id_foreign` FOREIGN KEY (`evidencia_id`) REFERENCES `evidencias` (`id`);

--
-- Filtros para la tabla `historial_accions`
--
ALTER TABLE `historial_accions`
  ADD CONSTRAINT `historial_accions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
