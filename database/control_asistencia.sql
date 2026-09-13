-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-09-2026 a las 02:43:23
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `control_asistencia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

CREATE TABLE `asistencias` (
  `id` int(11) NOT NULL,
  `sesion_id` int(11) NOT NULL,
  `estudiante_id` int(11) NOT NULL,
  `estado_asistencia` enum('asistio','tardanza','ausente') NOT NULL DEFAULT 'ausente',
  `fecha_hora_registro` timestamp NULL DEFAULT NULL,
  `ip_registro` varchar(45) DEFAULT NULL,
  `dispositivo` varchar(255) DEFAULT NULL,
  `observaciones` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistencias`
--

INSERT INTO `asistencias` (`id`, `sesion_id`, `estudiante_id`, `estado_asistencia`, `fecha_hora_registro`, `ip_registro`, `dispositivo`, `observaciones`) VALUES
(7, 4, 9, 'asistio', '2026-07-22 13:47:07', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL),
(8, 4, 10, 'asistio', '2026-07-22 13:47:12', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL),
(9, 4, 13, 'asistio', '2026-07-22 13:47:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL),
(10, 4, 11, 'ausente', NULL, NULL, NULL, NULL),
(11, 4, 12, 'ausente', NULL, NULL, NULL, NULL),
(12, 5, 24, 'asistio', '2026-09-13 00:17:31', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL),
(13, 5, 25, 'ausente', NULL, NULL, NULL, NULL),
(14, 6, 24, 'asistio', '2026-09-13 00:21:16', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL),
(15, 5, 26, 'ausente', NULL, NULL, NULL, NULL),
(16, 6, 25, 'tardanza', '2026-09-13 00:23:00', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL),
(17, 6, 26, 'ausente', NULL, NULL, NULL, NULL),
(18, 7, 24, 'asistio', '2026-09-13 00:27:36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL),
(19, 8, 24, 'asistio', '2026-09-13 00:29:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL),
(20, 7, 25, 'ausente', NULL, NULL, NULL, NULL),
(21, 7, 26, 'ausente', NULL, NULL, NULL, NULL),
(23, 9, 24, 'asistio', '2026-09-13 00:35:22', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL),
(24, 9, 25, 'tardanza', '2026-09-13 00:36:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL),
(25, 9, 26, 'tardanza', '2026-09-13 00:37:24', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL),
(26, 8, 25, 'ausente', NULL, NULL, NULL, NULL),
(27, 8, 26, 'ausente', NULL, NULL, NULL, NULL);

--
-- Disparadores `asistencias`
--
DELIMITER $$
CREATE TRIGGER `trg_calcular_estado_asistencia` BEFORE INSERT ON `asistencias` FOR EACH ROW BEGIN
    DECLARE v_hora_limite_asistencia TIME;
    DECLARE v_hora_limite_tardanza TIME;
    DECLARE v_hora_registro TIME;

    IF NEW.fecha_hora_registro IS NOT NULL THEN
        SELECT hora_limite_asistencia, hora_limite_tardanza
        INTO v_hora_limite_asistencia, v_hora_limite_tardanza
        FROM sesiones_clase WHERE id = NEW.sesion_id;

        SET v_hora_registro = TIME(NEW.fecha_hora_registro);

        IF v_hora_registro <= v_hora_limite_asistencia THEN
            SET NEW.estado_asistencia = 'asistio';
        ELSEIF v_hora_registro <= v_hora_limite_tardanza THEN
            SET NEW.estado_asistencia = 'tardanza';
        ELSE
            SET NEW.estado_asistencia = 'ausente';
        END IF;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `profesor_id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `codigo_curso` varchar(20) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `periodo` varchar(50) DEFAULT NULL,
  `tolerancia_tardanza_min` int(11) NOT NULL DEFAULT 10,
  `estado` enum('activo','inactivo','archivado') NOT NULL DEFAULT 'activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `profesor_id`, `nombre`, `codigo_curso`, `descripcion`, `periodo`, `tolerancia_tardanza_min`, `estado`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(6, 11, 'Programacion', 'Pro101', '', '2026-II', 10, 'activo', '2026-07-22 13:37:02', '2026-07-22 13:37:02'),
(7, 11, 'Base de Datos', 'DB101', '', '2026-II', 10, 'activo', '2026-07-22 13:37:40', '2026-07-22 13:37:40'),
(8, 11, 'Programacion Movil', 'PM101', '', '2026-II', 10, 'activo', '2026-07-22 13:38:24', '2026-07-22 13:38:24'),
(9, 11, 'Ingles', 'I102', '', '2026-II', 10, 'activo', '2026-07-22 13:38:58', '2026-07-22 13:38:58'),
(10, 11, 'Desarrollo Web', 'DW203', '', '2026-II', 10, 'activo', '2026-07-22 13:39:20', '2026-07-22 13:39:20'),
(11, 11, 'Curso de Test', 'Test-III', 'SISTEMA EN PROCESO DE FINALIZAR Y VENDER', '2026-II', 10, 'activo', '2026-09-13 00:12:40', '2026-09-13 00:13:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id` int(11) NOT NULL,
  `codigo_estudiante` varchar(20) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`id`, `codigo_estudiante`, `nombres`, `apellidos`, `correo`, `estado`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(9, '101', 'Mateo', 'Silva', 'msilva@estudiante.colegio.edu', 'activo', '2026-07-22 13:43:51', '2026-07-22 13:43:51'),
(10, '102', 'Lucia', 'Morales', 'lmorales@estudiante.colegio.edu', 'activo', '2026-07-22 13:44:14', '2026-07-22 13:44:14'),
(11, '103', 'Diego', 'Paredes', 'dparedes@estudiante.colegio.edu', 'activo', '2026-07-22 13:44:52', '2026-07-22 13:44:52'),
(12, '104', 'Camilla', 'Navarro', 'cnavarro@estudiante.colegio.edu', 'activo', '2026-07-22 13:45:18', '2026-07-22 13:45:18'),
(13, '105', 'Adrian', 'Guerrero', 'aguerrero@estudiante.colegio.edu', 'activo', '2026-07-22 13:45:49', '2026-07-22 13:45:49'),
(14, '001', 'Jose', 'rodriguez', 'rjose@estudiante.colegio.edu', 'activo', '2026-07-22 13:48:00', '2026-07-22 13:48:00'),
(15, '002', 'Lucia', 'Silva', 'lsilva@estudiante.colegio.edu', 'activo', '2026-07-22 13:48:34', '2026-07-22 13:48:34'),
(16, '003', 'manuel', 'cordova', 'mcordova@gmail.com', 'activo', '2026-07-22 13:48:46', '2026-07-22 13:48:46'),
(17, '004', 'victor', 'cordova', 'vcordova@gmail.com', 'activo', '2026-07-22 13:49:06', '2026-07-22 13:49:06'),
(18, '005', 'daniela', 'alarcon', 'dalarcon@estudiante.colegio.edu', 'activo', '2026-07-22 13:49:27', '2026-07-22 13:49:27'),
(19, '006', 'daniela', 'Morales', 'dmorales@gmail.com', 'activo', '2026-07-22 13:49:43', '2026-07-22 13:49:43'),
(20, '201', 'Mateo', 'alarcon', 'malarcon@gmail.com', 'activo', '2026-07-22 13:51:18', '2026-07-22 13:51:18'),
(21, '202', 'Jose', 'Morales', 'jmorales@gmail.com', 'activo', '2026-07-22 13:51:45', '2026-07-22 13:51:45'),
(23, '203', 'daniela', 'cordova', 'dcordova@estudiante.colegio.edu', 'activo', '2026-07-22 13:52:45', '2026-07-22 13:52:45'),
(24, '1', 'VICTOR', 'ALARCON', NULL, 'activo', '2026-09-13 00:14:19', '2026-09-13 00:14:19'),
(25, '2', 'MANUEL', 'ALARCON', NULL, 'activo', '2026-09-13 00:14:28', '2026-09-13 00:14:28'),
(26, '3', 'JHONY', 'ALARCON', NULL, 'activo', '2026-09-13 00:22:02', '2026-09-13 00:22:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones`
--

CREATE TABLE `inscripciones` (
  `id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `estudiante_id` int(11) NOT NULL,
  `fecha_inscripcion` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('activo','retirado') NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inscripciones`
--

INSERT INTO `inscripciones` (`id`, `curso_id`, `estudiante_id`, `fecha_inscripcion`, `estado`) VALUES
(11, 10, 9, '2026-07-22 13:43:51', 'activo'),
(12, 10, 10, '2026-07-22 13:44:14', 'activo'),
(13, 10, 11, '2026-07-22 13:44:52', 'activo'),
(14, 10, 12, '2026-07-22 13:45:18', 'activo'),
(15, 10, 13, '2026-07-22 13:45:49', 'activo'),
(16, 9, 14, '2026-07-22 13:48:00', 'activo'),
(17, 9, 15, '2026-07-22 13:48:34', 'activo'),
(18, 9, 16, '2026-07-22 13:48:46', 'activo'),
(19, 9, 17, '2026-07-22 13:49:06', 'activo'),
(20, 9, 18, '2026-07-22 13:49:27', 'activo'),
(21, 9, 19, '2026-07-22 13:49:43', 'activo'),
(22, 8, 20, '2026-07-22 13:51:18', 'activo'),
(23, 8, 21, '2026-07-22 13:51:45', 'activo'),
(24, 8, 23, '2026-07-22 13:52:45', 'activo'),
(25, 11, 24, '2026-09-13 00:14:19', 'activo'),
(26, 11, 25, '2026-09-13 00:14:28', 'activo'),
(27, 11, 26, '2026-09-13 00:22:02', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `intentos_login`
--

CREATE TABLE `intentos_login` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `exitoso` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `intentos_login`
--

INSERT INTO `intentos_login` (`id`, `usuario`, `ip`, `exitoso`, `fecha_creacion`) VALUES
(1, 'jperez', '::1', 1, '2026-07-13 05:20:57'),
(2, 'jperez', '::1', 1, '2026-07-13 05:29:45'),
(3, 'jperez', '::1', 0, '2026-07-13 16:51:20'),
(4, 'jperez', '::1', 1, '2026-07-13 16:52:13'),
(5, 'jperez', '::1', 1, '2026-07-13 17:09:53'),
(6, 'jperez', '::1', 1, '2026-07-15 19:40:07'),
(7, 'jperez', '::1', 1, '2026-07-15 20:25:28'),
(8, 'jperez', '::1', 1, '2026-07-22 13:14:47'),
(9, 'admin', '::1', 0, '2026-07-22 13:34:47'),
(10, 'admin', '::1', 0, '2026-07-22 13:35:09'),
(11, 'admin', '::1', 1, '2026-07-22 13:36:42'),
(12, 'admin', '::1', 1, '2026-07-22 14:09:49'),
(13, 'admin', '::1', 1, '2026-07-26 18:09:03'),
(14, 'admin', '::1', 1, '2026-07-26 18:44:50'),
(15, 'jgallardo', '::1', 1, '2026-07-26 18:48:13'),
(16, 'admin', '::1', 1, '2026-07-26 18:56:31'),
(17, 'jgallardo', '::1', 1, '2026-07-26 19:00:32'),
(18, 'admin', '::1', 1, '2026-07-26 19:00:44'),
(19, 'admin', '::1', 1, '2026-07-30 00:08:35'),
(20, 'admin', '::1', 1, '2026-07-30 00:09:36'),
(21, 'admin', '::1', 1, '2026-09-13 00:04:39'),
(22, 'admin', '::1', 1, '2026-09-13 00:04:48'),
(23, 'admin', '::1', 1, '2026-09-13 00:05:04'),
(24, '*-/4*5-345', '::1', 0, '2026-09-13 00:05:29'),
(25, 'admin', '::1', 1, '2026-09-13 00:05:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_actividad`
--

CREATE TABLE `log_actividad` (
  `id` int(11) NOT NULL,
  `profesor_id` int(11) DEFAULT NULL,
  `accion` varchar(100) NOT NULL,
  `tabla_afectada` varchar(50) DEFAULT NULL,
  `registro_id` int(11) DEFAULT NULL,
  `detalle` text DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `id` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `ultimo_login` timestamp NULL DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `rol` varchar(20) NOT NULL DEFAULT 'profesor'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`id`, `nombres`, `apellidos`, `correo`, `usuario`, `password_hash`, `estado`, `ultimo_login`, `fecha_creacion`, `fecha_actualizacion`, `rol`) VALUES
(3, 'Juan', 'Gallardo', 'gjuan@gmail.com', 'jgallardo', '$2y$10$Oeq4TIAnZlcUdgR.oqobF.JsloK6QTff.j10BKpccGwS/lUHdrc0G', 'activo', '2026-07-26 19:00:32', '2026-07-22 13:24:10', '2026-07-26 19:00:32', 'profesor'),
(5, 'felipe', 'guevara', 'fguevara@institutomanuelarevalo.drelm.edu.pe', 'fguevara', '$2y$10$IO/JTLG8fsREhBeVKxIAH.Y1mzi2pUx3SmTEDdS7UJ2a2l6z4xUeu', 'activo', NULL, '2026-07-22 13:26:31', '2026-07-22 13:26:31', 'profesor'),
(6, 'Jose', 'Velarde', 'vjose@gmail.com', 'jose', '$2y$10$NmiTumkqlvUBMk89HU7FEePihMvMgTW3UAhMBliieAWWEs.9RmzH2', 'activo', NULL, '2026-07-22 13:27:34', '2026-07-22 13:27:34', 'profesor'),
(7, 'Carlos', 'Mendoza', 'carlos.mendoza@colegio.edu', 'cmendoza', '$2y$10$X/XNkr2caeKxcNnYoPnfdeIsuqnBfqLdpysdjPd2l20tMs5alP.oe', 'activo', NULL, '2026-07-22 13:30:22', '2026-07-22 13:30:22', 'profesor'),
(8, 'Beatriz', 'Arrieta', 'beatriz.arrieta@colegio.edu', 'barrieta', '$2y$10$BB4l0oh1zq8xB8LsaD9oeOTn1AeVvY0DdF9kiI8.P8F4PuZbOxpi6', 'activo', NULL, '2026-07-22 13:31:21', '2026-07-22 13:31:21', 'profesor'),
(9, 'Javier', 'Fernández', 'javier.fernandez@colegio.edu', 'jfernandez', '$2y$10$qKFVQOQ.7zWH7rAx8y15TOpeqCvIEOUkKvNkm56V2iqgBZovKIH5u', 'activo', NULL, '2026-07-22 13:32:15', '2026-07-22 13:32:15', 'profesor'),
(10, 'Elena', 'Rostova', 'elena.rostova@colegio.edu', 'erostova', '$2y$10$YgHXv5mGg2t5BkxIV6ZFWuHqVZrDICcHqGRADbrbB1wd0FwglKs/y', 'activo', NULL, '2026-07-22 13:33:14', '2026-07-22 13:33:14', 'profesor'),
(11, 'Juan', 'Pérez', 'juan.perez@ejemplo.com', 'admin', '$2y$10$WoISXAnB5WVQuITysneVgOIKCj/DkJvmFnLfUeKJxbe03QVtlr0Xi', 'activo', '2026-09-13 00:05:35', '2026-07-22 13:36:27', '2026-09-13 00:05:35', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesiones_clase`
--

CREATE TABLE `sesiones_clase` (
  `id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_limite_asistencia` time NOT NULL,
  `hora_limite_tardanza` time NOT NULL,
  `tema` varchar(200) DEFAULT NULL,
  `token_formulario` varchar(64) NOT NULL,
  `estado` enum('programada','abierta','cerrada','cancelada') NOT NULL DEFAULT 'programada',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sesiones_clase`
--

INSERT INTO `sesiones_clase` (`id`, `curso_id`, `fecha`, `hora_inicio`, `hora_limite_asistencia`, `hora_limite_tardanza`, `tema`, `token_formulario`, `estado`, `fecha_creacion`) VALUES
(4, 10, '2026-07-22', '08:46:00', '08:50:00', '08:50:00', 'Introduccion', '274408649bd4444d132bbbf44cedeb75', 'cerrada', '2026-07-22 13:46:35'),
(5, 11, '2026-09-12', '19:15:00', '19:19:00', '19:19:00', 'PRUEBA DE TESTEO', '2fae6f3bd55a6e72c3d2f2df996e4c74', 'cerrada', '2026-09-13 00:15:33'),
(6, 11, '2026-09-12', '19:20:00', '19:22:00', '19:24:00', 'PRUEBA DE TESTEO 2', 'cb79107d19e6c266e9a04eb95bb7fc6e', 'cerrada', '2026-09-13 00:21:11'),
(7, 11, '2026-09-12', '19:26:00', '19:28:00', '19:30:00', 'PRUEBA DE TESTEO 3', '4f8a8fbe532e6f52a0bbc8c2f591bac7', 'cerrada', '2026-09-13 00:27:27'),
(8, 11, '2026-09-12', '19:28:00', '19:33:00', '19:40:00', NULL, 'a58ab92fae24cb902cfbe6b5d17f744a', 'cerrada', '2026-09-13 00:29:09'),
(9, 11, '2026-09-12', '19:34:00', '19:36:00', '19:40:00', 'PRUEBA DE TESTEO 4', '9e31bdf266f92d60743389b161b6409d', 'cerrada', '2026-09-13 00:35:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tokens_recuperacion`
--

CREATE TABLE `tokens_recuperacion` (
  `id` int(11) NOT NULL,
  `profesor_id` int(11) NOT NULL,
  `token` varchar(128) NOT NULL,
  `usado` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_expiracion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_resumen_asistencia`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_resumen_asistencia` (
`curso_id` int(11)
,`curso` varchar(150)
,`estudiante_id` int(11)
,`estudiante` varchar(201)
,`total_sesiones_registradas` bigint(21)
,`total_asistio` decimal(23,0)
,`total_tardanza` decimal(23,0)
,`total_ausente` decimal(23,0)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_resumen_asistencia`
--
DROP TABLE IF EXISTS `vista_resumen_asistencia`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_resumen_asistencia`  AS SELECT `c`.`id` AS `curso_id`, `c`.`nombre` AS `curso`, `e`.`id` AS `estudiante_id`, concat(`e`.`nombres`,' ',`e`.`apellidos`) AS `estudiante`, count(`a`.`id`) AS `total_sesiones_registradas`, sum(`a`.`estado_asistencia` = 'asistio') AS `total_asistio`, sum(`a`.`estado_asistencia` = 'tardanza') AS `total_tardanza`, sum(`a`.`estado_asistencia` = 'ausente') AS `total_ausente` FROM ((((`cursos` `c` join `inscripciones` `i` on(`i`.`curso_id` = `c`.`id` and `i`.`estado` = 'activo')) join `estudiantes` `e` on(`e`.`id` = `i`.`estudiante_id`)) left join `sesiones_clase` `s` on(`s`.`curso_id` = `c`.`id`)) left join `asistencias` `a` on(`a`.`sesion_id` = `s`.`id` and `a`.`estudiante_id` = `e`.`id`)) GROUP BY `c`.`id`, `e`.`id` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_sesion_estudiante` (`sesion_id`,`estudiante_id`),
  ADD KEY `idx_asistencias_estudiante` (`estudiante_id`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_curso` (`codigo_curso`),
  ADD KEY `idx_cursos_profesor` (`profesor_id`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_estudiante` (`codigo_estudiante`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_curso_estudiante` (`curso_id`,`estudiante_id`),
  ADD KEY `idx_inscripciones_estudiante` (`estudiante_id`);

--
-- Indices de la tabla `intentos_login`
--
ALTER TABLE `intentos_login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_intentos_usuario_fecha` (`usuario`,`fecha_creacion`);

--
-- Indices de la tabla `log_actividad`
--
ALTER TABLE `log_actividad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_log_profesor_fecha` (`profesor_id`,`fecha_creacion`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `sesiones_clase`
--
ALTER TABLE `sesiones_clase`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token_formulario` (`token_formulario`),
  ADD KEY `idx_sesiones_curso_fecha` (`curso_id`,`fecha`);

--
-- Indices de la tabla `tokens_recuperacion`
--
ALTER TABLE `tokens_recuperacion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `fk_tokens_profesor` (`profesor_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `intentos_login`
--
ALTER TABLE `intentos_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `log_actividad`
--
ALTER TABLE `log_actividad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `profesores`
--
ALTER TABLE `profesores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `sesiones_clase`
--
ALTER TABLE `sesiones_clase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tokens_recuperacion`
--
ALTER TABLE `tokens_recuperacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD CONSTRAINT `fk_asistencias_estudiante` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_asistencias_sesion` FOREIGN KEY (`sesion_id`) REFERENCES `sesiones_clase` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `fk_cursos_profesor` FOREIGN KEY (`profesor_id`) REFERENCES `profesores` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD CONSTRAINT `fk_inscripciones_curso` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_inscripciones_estudiante` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `log_actividad`
--
ALTER TABLE `log_actividad`
  ADD CONSTRAINT `fk_log_profesor` FOREIGN KEY (`profesor_id`) REFERENCES `profesores` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `sesiones_clase`
--
ALTER TABLE `sesiones_clase`
  ADD CONSTRAINT `fk_sesiones_curso` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tokens_recuperacion`
--
ALTER TABLE `tokens_recuperacion`
  ADD CONSTRAINT `fk_tokens_profesor` FOREIGN KEY (`profesor_id`) REFERENCES `profesores` (`id`) ON DELETE CASCADE;

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `ev_marcar_ausentes` ON SCHEDULE EVERY 5 MINUTE STARTS '2026-07-12 23:20:02' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    INSERT INTO asistencias (sesion_id, estudiante_id, estado_asistencia, fecha_hora_registro)
    SELECT s.id, i.estudiante_id, 'ausente', NULL
    FROM sesiones_clase s
    JOIN inscripciones i ON i.curso_id = s.curso_id AND i.estado = 'activo'
    WHERE CONCAT(s.fecha, ' ', s.hora_limite_tardanza) < NOW()
      AND s.estado <> 'cancelada'
      AND NOT EXISTS (
          SELECT 1 FROM asistencias a
          WHERE a.sesion_id = s.id AND a.estudiante_id = i.estudiante_id
      );

    UPDATE sesiones_clase
    SET estado = 'cerrada'
    WHERE CONCAT(fecha, ' ', hora_limite_tardanza) < NOW()
      AND estado IN ('programada','abierta');
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
