-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-04-2025 a las 12:25:52
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
-- Base de datos: `nutrifit`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `appointment`
--

CREATE TABLE `appointment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `status_type` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat`
--

CREATE TABLE `chat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `read` tinyint(1) NOT NULL,
  `isOnline` tinyint(1) NOT NULL,
  `isCurrentUser` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `composicion_corporal`
--

CREATE TABLE `composicion_corporal` (
  `ComposicionCorporal_ID` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `composicion_corporal`
--

INSERT INTO `composicion_corporal` (`ComposicionCorporal_ID`, `nombre`, `fecha_creacion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Grasa corporal', '2025-04-21', 1, '2025-04-21 15:42:27', '2025-04-21 15:42:58'),
(2, 'Masa Muscular', '2025-04-27', 1, '2025-04-27 07:36:36', '2025-04-27 07:36:36'),
(3, 'Edad Metabolica', '2025-04-27', 1, '2025-04-27 07:37:10', '2025-04-27 07:37:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desafio`
--

CREATE TABLE `desafio` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `status_type` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `divisas`
--

CREATE TABLE `divisas` (
  `Divisa_ID` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `divisas`
--

INSERT INTO `divisas` (`Divisa_ID`, `nombre`, `fecha_creacion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'USD', '2025-04-21', 1, '2025-04-21 16:19:36', '2025-04-21 16:19:55'),
(2, 'MXN', '2025-04-27', 1, '2025-04-27 07:40:53', '2025-04-27 07:40:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento`
--

CREATE TABLE `documento` (
  `Documento_ID` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `tipo_documento` varchar(255) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `documento`
--

INSERT INTO `documento` (`Documento_ID`, `nombre`, `tipo_documento`, `fecha_creacion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Factura', 'Consulta', '2025-04-25', 1, NULL, NULL),
(2, 'Ticket', 'Consulta', '2025-04-25', 1, NULL, NULL),
(3, 'Comprobante', 'Consulta', '2025-04-25', 1, NULL, NULL),
(4, 'Boleta', 'Consulta', '2025-04-25', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatura`
--

CREATE TABLE `estatura` (
  `Estatura_ID` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `estatura`
--

INSERT INTO `estatura` (`Estatura_ID`, `nombre`, `fecha_creacion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Alta', '2025-04-21', 1, '2025-04-21 16:00:10', '2025-04-27 07:40:01'),
(2, 'Bajo', '2025-04-27', 1, '2025-04-27 07:33:51', '2025-04-27 07:39:50'),
(3, 'Mediana', '2025-04-27', 1, '2025-04-27 07:35:26', '2025-04-27 07:39:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medidas_corporales`
--

CREATE TABLE `medidas_corporales` (
  `MedidasCorporales_ID` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `medidas_corporales`
--

INSERT INTO `medidas_corporales` (`MedidasCorporales_ID`, `nombre`, `fecha_creacion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Índice de Masa Corporal', '2025-04-21', 1, '2025-04-21 15:26:03', '2025-04-27 07:38:06'),
(2, 'Cintura', '2025-04-27', 1, '2025-04-27 07:38:58', '2025-04-27 07:38:58'),
(3, 'Cadera', '2025-04-27', 1, '2025-04-27 07:39:04', '2025-04-27 07:39:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_04_12_195626_create_usuario_table', 1),
(2, '2025_04_12_195705_create_chat_table', 1),
(3, '2025_04_12_195739_create_desafio_table', 1),
(4, '2025_04_12_195812_create_notification_table', 1),
(5, '2025_04_12_195902_create_patient_table', 1),
(6, '2025_04_12_195934_create_plan_list_table', 1),
(7, '2025_04_12_200020_create_appointment_table', 1),
(8, '2025_04_13_012658_create_rol_table', 1),
(9, '2025_04_13_012738_create_users_table', 1),
(10, '2025_04_14_065553_add_remember_token_to_users_table', 1),
(11, '2025_04_16_074428_create_sessions_table', 1),
(12, '2025_04_16_094527_add_remember_token_expires_at_to_users_table', 1),
(13, '2025_04_17_015346_create_talla_table', 1),
(14, '2025_04_19_093426_create_talla_table', 2),
(15, '2025_04_19_093541_create_talla_table', 3),
(16, '2025_04_19_095139_create_talla_table', 4),
(17, '2025_04_19_102540_create_sistema_metrico_table', 5),
(18, '2025_04_21_084752_create_medidas_corporales_table', 6),
(19, '2025_04_21_092933_create_composicion_corporal_table', 7),
(20, '2025_04_21_094613_create_estatura_table', 8),
(21, '2025_04_21_100529_create_divisas_table', 9),
(22, '2025_04_22_095419_create_paciente_table', 10),
(23, '2025_04_25_022455_add_ciudad_localidad_edad_fecha_to_paciente_table', 11),
(24, '2025_04_25_022606_add_ciudad_localidad_edad_fecha_to_paciente_table', 12),
(25, '2025_04_26_011710_create_documento_table', 13),
(26, '2025_04_26_013437_create_pago_table', 13),
(27, '2025_04_27_100702_create_tipo_consulta_table', 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notification`
--

CREATE TABLE `notification` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `Paciente_ID` int(10) UNSIGNED NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `genero` enum('Masculino','Femenino','Otros') NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `rol_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `enfermedad` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `ciudad` varchar(255) DEFAULT NULL,
  `localidad` varchar(255) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`Paciente_ID`, `foto`, `nombre`, `apellidos`, `email`, `telefono`, `genero`, `usuario`, `rol_id`, `user_id`, `enfermedad`, `status`, `estado`, `ciudad`, `localidad`, `edad`, `fecha_nacimiento`, `fecha_creacion`, `created_at`, `updated_at`) VALUES
(1, 'http://127.0.0.1:8000/storage/pacientes/1745495611_regina.png', 'Regina', 'Estrada', 'Estrada21@gmail.com', '9995241085', 'Femenino', 'ResgEstrada', 2, 2, 'Hipertension', 1, 1, 'Calkini', 'Campeche', 23, '2003-04-09', '2025-04-23', '2025-04-24 04:38:13', '2025-04-25 17:51:49'),
(2, 'http://127.0.0.1:8000/storage/pacientes/1745458516_testcom.jpg', 'Lyura', 'Celestina', 'Celestina@gmail.com', '9961052845', 'Femenino', 'Celestina', 2, 2, 'Hepatitis B', 0, 1, 'Pomuch', 'Campeche', 25, '2003-04-24', '2025-04-23', '2025-04-24 04:47:21', '2025-04-25 17:58:28'),
(3, NULL, 'Angelica', 'Moreno', 'angelicaMron@gmail.com', '9961018212', 'Femenino', 'asfsfasfasfss', 2, 2, 'Artritis,Cancer Pulmonar', 1, 1, NULL, NULL, NULL, NULL, '2025-04-23', '2025-04-24 05:26:36', '2025-04-25 18:29:56'),
(4, 'http://127.0.0.1:8000/storage/pacientes/1745454970_alan-antony.jpeg', 'Alan Antony', 'Puc Yam', 'lyon_arthur2@hotmail.com', '9961018215', 'Masculino', 'Lyon_Arthur', 2, 2, 'Ninguna', 1, 1, NULL, NULL, NULL, NULL, '2025-04-24', '2025-04-24 06:36:10', '2025-04-24 17:49:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `Pago_ID` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`Pago_ID`, `nombre`, `fecha_creacion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Cheque', '2025-04-25', 1, NULL, NULL),
(2, 'Tarjeta De Debido', '2025-04-25', 1, NULL, NULL),
(3, 'Tarjeta De Credito', '2025-04-25', 1, NULL, NULL),
(4, 'Efectivo', '2025-04-25', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patient`
--

CREATE TABLE `patient` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `gender` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan_list`
--

CREATE TABLE `plan_list` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `tiempo` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `eliminado` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombre`, `estado`, `eliminado`, `created_at`, `updated_at`) VALUES
(1, 'Nutriólogo', 1, 0, '2025-04-19 07:58:52', '2025-04-19 07:58:52'),
(2, 'Paciente', 1, 0, '2025-04-19 07:58:52', '2025-04-19 07:58:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sistema_metrico`
--

CREATE TABLE `sistema_metrico` (
  `SistemaMetrico_ID` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sistema_metrico`
--

INSERT INTO `sistema_metrico` (`SistemaMetrico_ID`, `nombre`, `fecha_creacion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Centimetros', '2025-04-21', 1, '2025-04-21 14:18:56', '2025-04-27 07:40:21'),
(2, 'Kg', '2025-04-21', 0, '2025-04-21 14:27:17', '2025-04-21 14:29:10'),
(3, 'Pies', '2025-04-27', 1, '2025-04-27 07:40:25', '2025-04-27 07:40:25'),
(4, 'Pulgadas', '2025-04-27', 1, '2025-04-27 07:40:30', '2025-04-27 07:40:30'),
(5, 'Kilogramos', '2025-04-27', 1, '2025-04-27 07:42:22', '2025-04-27 07:42:22'),
(6, 'Metros', '2025-04-27', 1, '2025-04-27 07:42:38', '2025-04-27 07:42:38'),
(7, 'Porcentaje', '2025-04-27', 1, '2025-04-27 08:05:56', '2025-04-27 08:05:56'),
(8, 'Años', '2025-04-27', 1, '2025-04-27 08:07:31', '2025-04-27 08:07:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `talla`
--

CREATE TABLE `talla` (
  `Talla_ID` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `talla`
--

INSERT INTO `talla` (`Talla_ID`, `nombre`, `fecha_creacion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Mediana', '2025-04-19', 1, '2025-04-19 15:57:05', '2025-04-27 07:32:54'),
(2, 'Mediano', '2025-04-21', 0, '2025-04-21 14:29:57', '2025-04-21 14:30:01'),
(3, 'Chica', '2025-04-27', 1, '2025-04-27 07:33:00', '2025-04-27 07:33:00'),
(4, 'Grande', '2025-04-27', 1, '2025-04-27 07:33:06', '2025-04-27 07:33:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_consulta`
--

CREATE TABLE `tipo_consulta` (
  `Tipo_Consulta_ID` int(10) UNSIGNED NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Precio` decimal(8,2) NOT NULL,
  `Duracion` int(11) NOT NULL,
  `total_pago` decimal(8,2) NOT NULL,
  `Estado` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_consulta`
--

INSERT INTO `tipo_consulta` (`Tipo_Consulta_ID`, `Nombre`, `Precio`, `Duracion`, `total_pago`, `Estado`, `fecha_creacion`, `created_at`, `updated_at`) VALUES
(1, 'Consulta Por App ', 585.00, 60, 585.00, 1, '2025-04-27', NULL, NULL),
(2, 'Consulta Por Llamada', 292.00, 60, 292.00, 1, '2025-04-27', NULL, NULL),
(3, 'Consulta Normal', 600.00, 60, 600.00, 1, '2025-04-27', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `rol_id` bigint(20) UNSIGNED NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `eliminado` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token_expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `nombre`, `apellidos`, `email`, `usuario`, `password`, `remember_token`, `rol_id`, `activo`, `eliminado`, `created_at`, `updated_at`, `remember_token_expires_at`) VALUES
(2, 'Alan Antony', 'Puc Yam', 'puc-alan20@hotmail.com', 'WoolyOlvel', '$2y$12$2eX8kea.zxAt68bRmujfWOWPUKp3hgrfxgNlxSF2ltAABeYBU1svi', 'tFUDxhryhPAiPiXx4msrGsIMAAoZONFj6aCJn8nU0QFs506bIUl1MDs6nBQs', 1, 1, 0, '2025-04-19 13:59:50', '2025-04-24 03:51:07', '2025-05-24 03:51:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `composicion_corporal`
--
ALTER TABLE `composicion_corporal`
  ADD PRIMARY KEY (`ComposicionCorporal_ID`);

--
-- Indices de la tabla `desafio`
--
ALTER TABLE `desafio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `divisas`
--
ALTER TABLE `divisas`
  ADD PRIMARY KEY (`Divisa_ID`);

--
-- Indices de la tabla `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`Documento_ID`);

--
-- Indices de la tabla `estatura`
--
ALTER TABLE `estatura`
  ADD PRIMARY KEY (`Estatura_ID`);

--
-- Indices de la tabla `medidas_corporales`
--
ALTER TABLE `medidas_corporales`
  ADD PRIMARY KEY (`MedidasCorporales_ID`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`Paciente_ID`),
  ADD UNIQUE KEY `paciente_email_unique` (`email`),
  ADD UNIQUE KEY `paciente_telefono_unique` (`telefono`),
  ADD UNIQUE KEY `paciente_usuario_unique` (`usuario`),
  ADD KEY `paciente_rol_id_foreign` (`rol_id`),
  ADD KEY `paciente_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`Pago_ID`);

--
-- Indices de la tabla `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `plan_list`
--
ALTER TABLE `plan_list`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `sistema_metrico`
--
ALTER TABLE `sistema_metrico`
  ADD PRIMARY KEY (`SistemaMetrico_ID`);

--
-- Indices de la tabla `talla`
--
ALTER TABLE `talla`
  ADD PRIMARY KEY (`Talla_ID`);

--
-- Indices de la tabla `tipo_consulta`
--
ALTER TABLE `tipo_consulta`
  ADD PRIMARY KEY (`Tipo_Consulta_ID`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_usuario_unique` (`usuario`),
  ADD KEY `users_rol_id_foreign` (`rol_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `chat`
--
ALTER TABLE `chat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `composicion_corporal`
--
ALTER TABLE `composicion_corporal`
  MODIFY `ComposicionCorporal_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `desafio`
--
ALTER TABLE `desafio`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `divisas`
--
ALTER TABLE `divisas`
  MODIFY `Divisa_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `documento`
--
ALTER TABLE `documento`
  MODIFY `Documento_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estatura`
--
ALTER TABLE `estatura`
  MODIFY `Estatura_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `medidas_corporales`
--
ALTER TABLE `medidas_corporales`
  MODIFY `MedidasCorporales_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `notification`
--
ALTER TABLE `notification`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `Paciente_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `Pago_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `patient`
--
ALTER TABLE `patient`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `plan_list`
--
ALTER TABLE `plan_list`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sistema_metrico`
--
ALTER TABLE `sistema_metrico`
  MODIFY `SistemaMetrico_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `talla`
--
ALTER TABLE `talla`
  MODIFY `Talla_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_consulta`
--
ALTER TABLE `tipo_consulta`
  MODIFY `Tipo_Consulta_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD CONSTRAINT `paciente_rol_id_foreign` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`),
  ADD CONSTRAINT `paciente_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_rol_id_foreign` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
