-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 16-06-2025 a las 21:34:43
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
  `status` int UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cadena_custodias`
--

INSERT INTO `cadena_custodias` (`id`, `evidencia_id`, `responsable`, `cargo`, `accion`, `destino`, `fecha`, `hora`, `observaciones`, `fecha_registro`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'FERNANDO PERES MAMANI', 'CARGO RESPONSABLE', 'ACCION QUE SE REALIZO EN LA CUSTODIA', 'DESTINO LUGAR CADENA', '2025-06-15', '14:00:00', 'OBSERVACIONES CADENA', '2025-06-16', 1, '2025-06-16 18:26:46', '2025-06-16 18:31:28'),
(2, 2, 'PEDRO GONZALES', 'CARGO PEDRO', 'ACCION REALZIADA CADENA', 'LA PAZ', '2025-06-16', '17:35:00', 'OBSERVACIONES CADENA DE CUSTODIA EVI02', '2025-06-16', 1, '2025-06-16 21:33:11', '2025-06-16 21:33:11');

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
  `evidencia_archivo_id` bigint UNSIGNED NOT NULL,
  `fecha_alteracion` date NOT NULL,
  `hora_alteracion` time NOT NULL,
  `encriptado_original` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `encriptado_alteracion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_registro` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `control_integridads`
--

INSERT INTO `control_integridads` (`id`, `evidencia_id`, `evidencia_archivo_id`, `fecha_alteracion`, `hora_alteracion`, `encriptado_original`, `encriptado_alteracion`, `fecha_registro`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2025-06-14', '15:33:20', '8922c9d952e5539de042589cd0cef3cce686429b9b23f9131d3f1b28e2483f00', '33b2dbe1217dbd83f1f330a0e1ac3243f6d3b08d2df1d6777437a473bbb5be53', '2025-06-14', '2025-06-14 19:33:20', '2025-06-14 19:33:20'),
(2, 2, 6, '2025-06-16', '17:32:36', 'c366e5857e90a892df1f24352ff5eea4d62f1c43a22470194591f39023975f95', 'df1c9ac8f3bdf88b7e8ad1860ae1ab5833bd1328649e4fc4b16f03e592e7eca9', '2025-06-16', '2025-06-16 21:32:36', '2025-06-16 21:32:36');

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
(1, 'EVI01', 'DESC', 'JUAN PERES', '2025-01-01', '09:00:00', 'ORIGEN ARCHIVO', '2025-01-01', '05:00:00', 'LUGAR RECOLECCION', 'JUAN PERES', 'HERRAMIENTA USADA', '2025-06-13', 1, '2025-06-13 20:08:42', '2025-06-13 20:08:42'),
(2, 'EVI02', 'DESCRIPCION EVI02', 'PEDRO GONZALES', '2025-06-16', '15:00:00', 'ORIGEN DEL ARCHIVO EVI02', '2025-01-01', '09:00:00', 'LUGAR RECOLECCION', 'PEDRO GONZALES', 'HERRAMIENTA EVI02', '2025-06-16', 1, '2025-06-16 21:32:26', '2025-06-16 21:32:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evidencia_archivos`
--

CREATE TABLE `evidencia_archivos` (
  `id` bigint UNSIGNED NOT NULL,
  `evidencia_id` bigint UNSIGNED NOT NULL,
  `archivo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hash_archivo` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `evidencia_archivos`
--

INSERT INTO `evidencia_archivos` (`id`, `evidencia_id`, `archivo`, `hash_archivo`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '011749845322.mp4', 'f20619921b55a3ee2d3ceebbad4dbba83dd8b6ba6c0414b152ed7f6f050f1761', 1, '2025-06-13 20:08:42', '2025-06-13 20:08:42'),
(2, 1, '211749929600.jpeg', '33b2dbe1217dbd83f1f330a0e1ac3243f6d3b08d2df1d6777437a473bbb5be53', 1, '2025-06-13 20:08:42', '2025-06-14 19:33:20'),
(3, 1, '211749845322.docx', 'b30efc6534ae1c0c65102d96e379ea9f1e879cbb881d666821b87fe23d8e6724', 1, '2025-06-13 20:08:42', '2025-06-13 20:08:42'),
(4, 1, '311749845322.jpg', 'd32bf753da66cccf03da6e01736ecfaf76ce806e18d6afdadff124e86478091e', 1, '2025-06-13 20:08:42', '2025-06-13 20:08:42'),
(5, 1, '011749928788.jpeg', '33b2dbe1217dbd83f1f330a0e1ac3243f6d3b08d2df1d6777437a473bbb5be53', 0, '2025-06-14 19:19:48', '2025-06-14 19:37:49'),
(6, 2, '621750109556.pdf', 'df1c9ac8f3bdf88b7e8ad1860ae1ab5833bd1328649e4fc4b16f03e592e7eca9', 1, '2025-06-16 21:32:26', '2025-06-16 21:32:36'),
(7, 2, '121750109546.mp4', 'f20619921b55a3ee2d3ceebbad4dbba83dd8b6ba6c0414b152ed7f6f050f1761', 1, '2025-06-16 21:32:26', '2025-06-16 21:32:26');

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
(3, 1, 'MODIFICACIÓN', 'EL USUARIO admin ACTUALIZÓ UN USUARIO', '{\"ci\": \"123456\", \"id\": 2, \"dir\": \"ZONA LOS OLIVOS\", \"fono\": \"76767676\", \"foto\": \"21749839361.jpg\", \"tipo\": \"ADMINISTRADOR\", \"acceso\": 1, \"ci_exp\": \"LP\", \"correo\": \"juan@gmail.com\", \"nombre\": \"JUAN\", \"status\": 1, \"materno\": \"MAMANI\", \"paterno\": \"PERES\", \"usuario\": \"juan@gmail.com\", \"created_at\": \"2025-06-13T18:29:21.000000Z\", \"updated_at\": \"2025-06-13T18:29:21.000000Z\", \"fecha_registro\": \"2025-06-13\"}', '{\"ci\": \"123456\", \"id\": 2, \"dir\": \"ZONA LOS OLIVOS\", \"fono\": \"76767676\", \"foto\": \"21749839909.jpg\", \"tipo\": \"ADMINISTRADOR\", \"acceso\": \"1\", \"ci_exp\": \"LP\", \"correo\": \"juan@gmail.com\", \"nombre\": \"JUAN\", \"status\": 1, \"materno\": \"MAMANI\", \"paterno\": \"PERES\", \"usuario\": \"juan@gmail.com\", \"created_at\": \"2025-06-13T18:29:21.000000Z\", \"updated_at\": \"2025-06-13T18:38:29.000000Z\", \"fecha_registro\": \"2025-06-13\"}', 'USUARIOS', '2025-06-13', '14:38:29', 'Equipo Escritorio - S.O. Windows - Navegador Chrome', '127.0.0.1', '2025-06-13 18:38:29', '2025-06-13 18:38:29'),
(4, 1, 'CREACIÓN', 'EL USUARIO admin REGISTRO UNA CADENA DE CUSTODIA', '{\"id\": 1, \"hora\": \"14:00\", \"cargo\": \"CARGO\", \"fecha\": \"2025-06-16\", \"accion\": \"ACCION QUE SE REALIZO\", \"destino\": \"DESTINO LUGAR\", \"created_at\": \"2025-06-16T18:26:46.000000Z\", \"updated_at\": \"2025-06-16T18:26:46.000000Z\", \"responsable\": \"FERNANDO PERES\", \"evidencia_id\": \"1\", \"observaciones\": \"OBSERVACIONES\", \"fecha_registro\": \"2025-06-16\"}', NULL, 'CADENA DE CUSTODIA', '2025-06-16', '14:26:46', 'Equipo Escritorio - S.O. Windows - Navegador Chrome', '127.0.0.1', '2025-06-16 18:26:47', '2025-06-16 18:26:47'),
(5, 1, 'MODIFICACIÓN', 'EL USUARIO admin ACTUALIZÓ UNA CADENA DE CUSTODIA', '{\"id\": 1, \"hora\": \"14:00:00\", \"cargo\": \"CARGO\", \"fecha\": \"2025-06-16\", \"accion\": \"ACCION QUE SE REALIZO\", \"status\": 1, \"destino\": \"DESTINO LUGAR\", \"created_at\": \"2025-06-16T18:26:46.000000Z\", \"updated_at\": \"2025-06-16T18:26:46.000000Z\", \"responsable\": \"FERNANDO PERES\", \"evidencia_id\": 1, \"observaciones\": \"OBSERVACIONES\", \"fecha_registro\": \"2025-06-16\"}', '{\"id\": 1, \"hora\": \"14:00:00\", \"cargo\": \"CARGO RESPONSABLE\", \"fecha\": \"2025-06-15\", \"accion\": \"ACCION QUE SE REALIZO EN LA CUSTODIA\", \"status\": 1, \"destino\": \"DESTINO LUGAR CADENA\", \"created_at\": \"2025-06-16T18:26:46.000000Z\", \"updated_at\": \"2025-06-16T18:29:04.000000Z\", \"responsable\": \"FERNANDO PERES MAMANI\", \"evidencia_id\": \"1\", \"observaciones\": \"OBSERVACIONES CADENA\", \"fecha_registro\": \"2025-06-16\"}', 'CADENA DE CUSTODIA', '2025-06-16', '14:29:04', 'Equipo Escritorio - S.O. Windows - Navegador Chrome', '127.0.0.1', '2025-06-16 18:29:04', '2025-06-16 18:29:04'),
(6, 1, 'CREACIÓN', 'EL USUARIO admin REGISTRO UN USUARIO', '{\"ci\": \"432222\", \"id\": 3, \"dir\": \"LOS OLIVOS\", \"fono\": \"77777777\", \"tipo\": \"FORENSE\", \"acceso\": \"1\", \"ci_exp\": \"LP\", \"correo\": null, \"nombre\": \"FERNANDO\", \"materno\": \"PAREDES\", \"paterno\": \"PAREDES\", \"usuario\": \"FPAREDES\", \"created_at\": \"2025-06-16T21:22:15.000000Z\", \"updated_at\": \"2025-06-16T21:22:15.000000Z\", \"fecha_registro\": \"2025-06-16\"}', NULL, 'USUARIOS', '2025-06-16', '17:22:15', 'Equipo Escritorio - S.O. Windows - Navegador Chrome', '127.0.0.1', '2025-06-16 21:22:15', '2025-06-16 21:22:15'),
(7, 1, 'CREACIÓN', 'EL USUARIO admin REGISTRO UN USUARIO', '{\"ci\": \"433434334\", \"id\": 4, \"dir\": \"LOS PEDREGALES\", \"fono\": \"64454545\", \"foto\": \"41750108957.jpg\", \"tipo\": \"PERITO\", \"acceso\": \"1\", \"ci_exp\": \"LP\", \"correo\": null, \"nombre\": \"MARIA\", \"materno\": \"CONDORI\", \"paterno\": \"CONDORI\", \"usuario\": \"MCONDORI\", \"created_at\": \"2025-06-16T21:22:37.000000Z\", \"updated_at\": \"2025-06-16T21:22:37.000000Z\", \"fecha_registro\": \"2025-06-16\"}', NULL, 'USUARIOS', '2025-06-16', '17:22:37', 'Equipo Escritorio - S.O. Windows - Navegador Chrome', '127.0.0.1', '2025-06-16 21:22:37', '2025-06-16 21:22:37'),
(8, 1, 'CREACIÓN', 'EL USUARIO admin REGISTRO UN USUARIO', '{\"ci\": \"2323424\", \"id\": 5, \"dir\": \"LOS OLIVOS\", \"fono\": \"6544444\", \"tipo\": \"AUDITOR\", \"acceso\": \"1\", \"ci_exp\": \"LP\", \"correo\": \"jorge@gmail.com\", \"nombre\": \"JORGE\", \"materno\": \"MARTINES\", \"paterno\": \"MARTINEZ\", \"usuario\": \"JMARTINEZ\", \"created_at\": \"2025-06-16T21:23:09.000000Z\", \"updated_at\": \"2025-06-16T21:23:09.000000Z\", \"fecha_registro\": \"2025-06-16\"}', NULL, 'USUARIOS', '2025-06-16', '17:23:09', 'Equipo Escritorio - S.O. Windows - Navegador Chrome', '127.0.0.1', '2025-06-16 21:23:09', '2025-06-16 21:23:09'),
(9, 1, 'CREACIÓN', 'EL USUARIO admin REGISTRO UN USUARIO', '{\"ci\": \"434444\", \"id\": 6, \"dir\": \"LOS PEDREGALES\", \"fono\": \"7445454545\", \"tipo\": \"OBSERVADOR\", \"acceso\": \"1\", \"ci_exp\": \"LP\", \"correo\": null, \"nombre\": \"EDUARDO\", \"materno\": \"\", \"paterno\": \"CARVAJAL\", \"usuario\": \"ECARVAJAL\", \"created_at\": \"2025-06-16T21:23:31.000000Z\", \"updated_at\": \"2025-06-16T21:23:31.000000Z\", \"fecha_registro\": \"2025-06-16\"}', NULL, 'USUARIOS', '2025-06-16', '17:23:31', 'Equipo Escritorio - S.O. Windows - Navegador Chrome', '127.0.0.1', '2025-06-16 21:23:31', '2025-06-16 21:23:31'),
(10, 3, 'CREACIÓN', 'EL USUARIO FPAREDES REGISTRO UNA EVIDENCIA', '{\"id\": 2, \"codigo\": \"EVI02\", \"archivos\": [{\"id\": 6, \"ext\": \"jpg\", \"name\": \"021750109546.jpg\", \"status\": 1, \"archivo\": \"021750109546.jpg\", \"url_file\": \"http://sised.test/evidencias/021750109546.jpg\", \"created_at\": \"2025-06-16T21:32:26.000000Z\", \"updated_at\": \"2025-06-16T21:32:26.000000Z\", \"archivo_b64\": \"\", \"url_archivo\": \"http://sised.test/evidencias/021750109546.jpg\", \"evidencia_id\": 2, \"hash_archivo\": \"c366e5857e90a892df1f24352ff5eea4d62f1c43a22470194591f39023975f95\"}, {\"id\": 7, \"ext\": \"mp4\", \"name\": \"121750109546.mp4\", \"status\": 1, \"archivo\": \"121750109546.mp4\", \"url_file\": \"http://sised.test/imgs/attach.png\", \"created_at\": \"2025-06-16T21:32:26.000000Z\", \"updated_at\": \"2025-06-16T21:32:26.000000Z\", \"archivo_b64\": \"\", \"url_archivo\": \"http://sised.test/evidencias/121750109546.mp4\", \"evidencia_id\": 2, \"hash_archivo\": \"f20619921b55a3ee2d3ceebbad4dbba83dd8b6ba6c0414b152ed7f6f050f1761\"}], \"created_at\": \"2025-06-16T21:32:26.000000Z\", \"updated_at\": \"2025-06-16T21:32:26.000000Z\", \"descripcion\": \"DESCRIPCION EVI02\", \"hora_creacion\": \"15:00\", \"hora_hallazgo\": \"09:00\", \"fecha_creacion\": \"2025-06-16\", \"fecha_hallazgo\": \"2025-01-01\", \"fecha_registro\": \"2025-06-16\", \"nombre_creador\": \"PEDRO GONZALES\", \"origen_archivo\": \"ORIGEN DEL ARCHIVO EVI02\", \"lugar_recoleccion\": \"LUGAR RECOLECCION\", \"persona_recolector\": \"PEDRO GONZALES\", \"herramienta_utilizada\": \"HERRAMIENTA EVI02\"}', NULL, 'EVIDENCIAS', '2025-06-16', '17:32:26', 'Equipo Escritorio - S.O. Windows - Navegador Chrome', '127.0.0.1', '2025-06-16 21:32:26', '2025-06-16 21:32:26'),
(11, 3, 'CREACIÓN', 'EL USUARIO FPAREDES REGISTRO UNA CADENA DE CUSTODIA', '{\"id\": 2, \"hora\": \"17:35\", \"cargo\": \"CARGO PEDRO\", \"fecha\": \"2025-06-16\", \"accion\": \"ACCION REALZIADA CADENA\", \"destino\": \"LA PAZ\", \"created_at\": \"2025-06-16T21:33:11.000000Z\", \"updated_at\": \"2025-06-16T21:33:11.000000Z\", \"responsable\": \"PEDRO GONZALES\", \"evidencia_id\": \"2\", \"observaciones\": \"OBSERVACIONES CADENA DE CUSTODIA EVI02\", \"fecha_registro\": \"2025-06-16\"}', NULL, 'CADENA DE CUSTODIA', '2025-06-16', '17:33:11', 'Equipo Escritorio - S.O. Windows - Navegador Chrome', '127.0.0.1', '2025-06-16 21:33:11', '2025-06-16 21:33:11');

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
(7, '2025_06_08_184526_create_evidencia_archivos_table', 2),
(8, '2025_06_14_144743_create_notificacions_table', 3),
(9, '2025_06_14_144746_create_notificacion_users_table', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacions`
--

CREATE TABLE `notificacions` (
  `id` bigint UNSIGNED NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `modulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registro_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `notificacions`
--

INSERT INTO `notificacions` (`id`, `descripcion`, `fecha`, `hora`, `modulo`, `registro_id`, `created_at`, `updated_at`) VALUES
(1, 'El usuario <b>admin</b> modifico un archivo de la evidencia <b>EVI01</b>', '2025-06-14', '15:33:00', 'EvidenciaArchivo', 2, '2025-06-14 19:33:20', '2025-06-14 19:33:20'),
(2, 'El usuario <b>admin</b> eliminó un archivo de la evidencia <b>EVI01</b>', '2025-06-14', '15:37:00', 'EvidenciaArchivo', 5, '2025-06-14 19:37:49', '2025-06-14 19:37:49'),
(3, 'El usuario <b>FPAREDES</b> modifico un archivo de la evidencia <b>EVI02</b>', '2025-06-16', '17:32:00', 'EvidenciaArchivo', 6, '2025-06-16 21:32:36', '2025-06-16 21:32:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion_users`
--

CREATE TABLE `notificacion_users` (
  `id` bigint UNSIGNED NOT NULL,
  `notificacion_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `visto` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `notificacion_users`
--

INSERT INTO `notificacion_users` (`id`, `notificacion_id`, `user_id`, `visto`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2025-06-14 19:33:20', '2025-06-16 13:59:32'),
(2, 1, 2, 1, '2025-06-14 19:33:20', '2025-06-16 21:27:03'),
(3, 2, 1, 1, '2025-06-14 19:37:49', '2025-06-16 13:59:37'),
(4, 2, 2, 1, '2025-06-14 19:37:49', '2025-06-16 21:28:44'),
(5, 3, 1, 0, '2025-06-16 21:32:36', '2025-06-16 21:32:36'),
(6, 3, 2, 0, '2025-06-16 21:32:36', '2025-06-16 21:32:36'),
(7, 3, 3, 1, '2025-06-16 21:32:36', '2025-06-16 21:33:28'),
(8, 3, 4, 0, '2025-06-16 21:32:36', '2025-06-16 21:32:36'),
(9, 3, 5, 0, '2025-06-16 21:32:36', '2025-06-16 21:32:36'),
(10, 3, 6, 0, '2025-06-16 21:32:36', '2025-06-16 21:32:36');

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
(2, 'JPERES', 'JUAN', 'PERES', 'MAMANI', '123456', 'LP', 'ZONA LOS OLIVOS', 'juan@gmail.com', '76767676', '$2y$12$c/SadN/8ivZnWH3UsPsIu.rJaa31GisVFIFXDRhtigPWxmr14Vu5.', 1, 'ADMINISTRADOR', '21749839909.jpg', '2025-06-13', 1, '2025-06-13 18:29:21', '2025-06-13 18:38:29'),
(3, 'FPAREDES', 'FERNANDO', 'PAREDES', 'PAREDES', '432222', 'LP', 'LOS OLIVOS', NULL, '77777777', '$2y$12$q4/Y69ng6wELn02V4gDMEeQ1dygCLZNpHLHiATYkNt5yLkYaYLkZC', 1, 'FORENSE', NULL, '2025-06-16', 1, '2025-06-16 21:22:15', '2025-06-16 21:22:15'),
(4, 'MCONDORI', 'MARIA', 'CONDORI', 'CONDORI', '433434334', 'LP', 'LOS PEDREGALES', NULL, '64454545', '$2y$12$7ym8lo9PGnIeR9bV174YjOWPPXDzF9uRvlMBJI5yQBvhGrbDNQRQ.', 1, 'PERITO', '41750108957.jpg', '2025-06-16', 1, '2025-06-16 21:22:37', '2025-06-16 21:22:37'),
(5, 'JMARTINEZ', 'JORGE', 'MARTINEZ', 'MARTINES', '2323424', 'LP', 'LOS OLIVOS', 'jorge@gmail.com', '6544444', '$2y$12$9PMz9w40niaZmgoylHQKJu4v6tSgnXtxDD0NhuxKUMGg0q9JYMiPG', 1, 'AUDITOR', NULL, '2025-06-16', 1, '2025-06-16 21:23:09', '2025-06-16 21:23:09'),
(6, 'ECARVAJAL', 'EDUARDO', 'CARVAJAL', '', '434444', 'LP', 'LOS PEDREGALES', NULL, '7445454545', '$2y$12$0iNi5Nrv1mSO81xs3ZBD8eH2llpHU.eYQpIURFndtNU3aYjafBkVy', 1, 'OBSERVADOR', NULL, '2025-06-16', 1, '2025-06-16 21:23:31', '2025-06-16 21:23:31');

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
-- Indices de la tabla `notificacions`
--
ALTER TABLE `notificacions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notificacion_users`
--
ALTER TABLE `notificacion_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notificacion_users_notificacion_id_foreign` (`notificacion_id`),
  ADD KEY `notificacion_users_user_id_foreign` (`user_id`);

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `configuracions`
--
ALTER TABLE `configuracions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `control_integridads`
--
ALTER TABLE `control_integridads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `evidencias`
--
ALTER TABLE `evidencias`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `evidencia_archivos`
--
ALTER TABLE `evidencia_archivos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `historial_accions`
--
ALTER TABLE `historial_accions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `notificacions`
--
ALTER TABLE `notificacions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `notificacion_users`
--
ALTER TABLE `notificacion_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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

--
-- Filtros para la tabla `notificacion_users`
--
ALTER TABLE `notificacion_users`
  ADD CONSTRAINT `notificacion_users_notificacion_id_foreign` FOREIGN KEY (`notificacion_id`) REFERENCES `notificacions` (`id`),
  ADD CONSTRAINT `notificacion_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
