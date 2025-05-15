-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-05-2025 a las 20:48:12
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
-- Estructura de tabla para la tabla `ajustes`
--

CREATE TABLE `ajustes` (
  `Ajuste_ID` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rol_id` bigint(20) UNSIGNED NOT NULL,
  `nombre_nutriologo` varchar(255) NOT NULL,
  `apellido_nutriologo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `edad` tinyint(3) UNSIGNED DEFAULT NULL,
  `genero` varchar(50) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `profesion` varchar(255) DEFAULT NULL,
  `especialidad` varchar(255) DEFAULT NULL,
  `universidad` varchar(255) DEFAULT NULL,
  `displomados` text DEFAULT NULL,
  `especializacion` varchar(255) DEFAULT NULL,
  `descripcion_especialziacion` text DEFAULT NULL,
  `experiencia` text DEFAULT NULL,
  `enfermedades_tratadas` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `foto_portada` varchar(255) DEFAULT NULL,
  `pacientes_tratados` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `horario_antencion` varchar(255) DEFAULT NULL,
  `descripcion_nutriologo` text DEFAULT NULL,
  `ciudad` varchar(255) DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL,
  `modalidad` varchar(255) DEFAULT NULL,
  `disponibilidad` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ajustes`
--

INSERT INTO `ajustes` (`Ajuste_ID`, `user_id`, `rol_id`, `nombre_nutriologo`, `apellido_nutriologo`, `email`, `telefono`, `edad`, `genero`, `fecha_nacimiento`, `profesion`, `especialidad`, `universidad`, `displomados`, `especializacion`, `descripcion_especialziacion`, `experiencia`, `enfermedades_tratadas`, `foto`, `foto_portada`, `pacientes_tratados`, `horario_antencion`, `descripcion_nutriologo`, `ciudad`, `estado`, `modalidad`, `disponibilidad`, `status`, `fecha_creacion`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Alan Antony', 'Puc Yam', 'puc-alan20@hotmail.com', '9961018215', 22, 'Masculino', '2003-04-28', 'Lic.Nutricion', 'Nutrición Clínica', 'UAC', 'Diabetes I', 'AutoInmunes', 'Como nutriólogo especializado en enfermedades autoinmunes, me enfoco en diseñar planes de alimentación personalizados para personas que padecen condiciones como lupus, artritis reumatoide, enfermedad celíaca, esclerosis múltiple, tiroiditis de Hashimoto, entre otras.', '10', '<p><strong>Enfermedades crónicas y metabólicas:</strong></p><ul><li>Diabetes tipo 1 y 2</li><li>Hipertensión arterial</li><li>Colesterol y triglicéridos altos (dislipidemias)</li><li>Síndrome metabólico</li><li>Obesidad y sobrepeso</li><li>Hígado graso no alcohólico</li><li>Hipotiroidismo e hipertiroidismo</li></ul><p><strong>Enfermedades autoinmunes (especialidad):</strong></p><ul><li>Lupus eritematoso sistémico</li><li>Artritis reumatoide</li><li>Enfermedad celíaca</li><li>Tiroiditis de Hashimoto</li><li>Esclerosis múltiple</li><li>Psoriasis</li><li>Enfermedad de Crohn</li><li>Colitis ulcerosa</li></ul>', 'http://127.0.0.1:8000/storage/nutriologos/1747302812_alan-antony.jpeg', 'http://127.0.0.1:8000/storage/fotos_portadas/1747313108_portada_alan-antony.jpg', 12, 'Lunes a Viernes: 10:00AM-4:00PM, 6:00PM-8:00PM', 'Soy nutriólogo y mi misión es ayudarte a alcanzar un estilo de vida más saludable por medio de una alimentación equilibrada y personalizada. Me especializo en evaluar tu estado nutricional, entender tus hábitos y necesidades, y construir contigo un plan que no solo funcione, sino que también se adapte a ti.', 'Calkini', 'Campeche', 'Presencial', 'Disponibles', 1, '2025-05-15 09:07:51', '2025-05-15 15:07:51', '2025-05-15 18:45:08');

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
-- Estructura de tabla para la tabla `consulta`
--

CREATE TABLE `consulta` (
  `Consulta_ID` int(10) UNSIGNED NOT NULL,
  `Paciente_ID` int(10) UNSIGNED NOT NULL,
  `Tipo_Consulta_ID` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `Documento_ID` int(10) UNSIGNED NOT NULL,
  `Pago_ID` int(10) UNSIGNED NOT NULL,
  `Divisa_ID` int(10) UNSIGNED NOT NULL,
  `nombre_paciente` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `genero` varchar(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `enfermedad` varchar(255) DEFAULT NULL,
  `localidad` varchar(255) DEFAULT NULL,
  `ciudad` varchar(255) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `nombre_nutriologo` varchar(255) NOT NULL,
  `peso` decimal(5,2) DEFAULT NULL,
  `talla` varchar(255) DEFAULT NULL,
  `cintura` decimal(5,2) DEFAULT NULL,
  `cadera` decimal(5,2) DEFAULT NULL,
  `gc` decimal(5,2) DEFAULT NULL,
  `mm` decimal(5,2) DEFAULT NULL,
  `em` decimal(5,2) DEFAULT NULL,
  `altura` decimal(5,2) DEFAULT NULL,
  `detalles_diagnostico` text DEFAULT NULL,
  `resultados_evaluacion` text DEFAULT NULL,
  `analisis_nutricional` text DEFAULT NULL,
  `objetivo_descripcion` text DEFAULT NULL,
  `proxima_consulta` datetime DEFAULT NULL,
  `nombre_consultorio` text DEFAULT NULL,
  `direccion_consultorio` text DEFAULT NULL,
  `plan_nutricional_path` text DEFAULT NULL,
  `total_pago` decimal(8,2) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `estado_proximaConsulta` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `consulta`
--

INSERT INTO `consulta` (`Consulta_ID`, `Paciente_ID`, `Tipo_Consulta_ID`, `user_id`, `Documento_ID`, `Pago_ID`, `Divisa_ID`, `nombre_paciente`, `apellidos`, `email`, `telefono`, `genero`, `usuario`, `enfermedad`, `localidad`, `ciudad`, `edad`, `fecha_nacimiento`, `nombre_nutriologo`, `peso`, `talla`, `cintura`, `cadera`, `gc`, `mm`, `em`, `altura`, `detalles_diagnostico`, `resultados_evaluacion`, `analisis_nutricional`, `objetivo_descripcion`, `proxima_consulta`, `nombre_consultorio`, `direccion_consultorio`, `plan_nutricional_path`, `total_pago`, `fecha_creacion`, `estado`, `estado_proximaConsulta`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 2, 2, 2, 'Regina', 'Estrada', 'Estrada21@gmail.com', '9995241085', 'Femenino', 'ResgEstrada', 'Hipertension', 'Campeche', 'Calkini', 24, '2003-04-09', 'Alan Antony Puc Yam', 72.40, 'M', 83.00, 98.00, 32.50, 29.10, 30.00, 1.65, '<p>Paciente con antecedentes familiares de hipertensión. Presenta valores elevados de presión arterial en consulta previa. IMC en rango de sobrepeso. Se recomienda reducción progresiva de peso y ajuste en hábitos alimenticios y de actividad física.</p>', '<ul><li>IMC: 26.6 (Sobrepeso)</li><li>Riesgo cardiovascular moderado</li><li>Retención de líquidos leve</li><li>Hábitos alimenticios con alto consumo de sodio</li><li>Actividad física irregular</li></ul>', '<ul><li>Consumo calórico actual: 2200 kcal/día</li><li>Macronutrientes desequilibrados: exceso de carbohidratos simples y sodio</li><li>Ingesta de frutas y verduras: baja</li><li>Hidratación: insuficiente (&lt;1.5 L/día)</li></ul>', '<p>Reducir 6 kg en 3 meses mediante plan alimenticio hipocalórico controlado en sodio, aumentar ingesta de fibra y agua, e implementar actividad física moderada al menos 4 veces por semana. Mejorar perfil lipídico y reducir presión arterial.</p>', '2025-06-09 17:00:00', 'NutriVida Campeche', 'Calle 20 #158, Col. Centro, Calkiní, Campeche, C.P. 24900', '[\"http:\\/\\/127.0.0.1:8000\\/storage\\/plan_nutricional\\/reginaestrada\\/1\\/1_1746793598_0_referencias.pdf\"]', 585.00, '2025-05-09', 1, 3, '2025-05-09 18:26:38', '2025-05-09 18:26:38');

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
  `tasa_cambio` decimal(10,4) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `divisas`
--

INSERT INTO `divisas` (`Divisa_ID`, `nombre`, `tasa_cambio`, `fecha_creacion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'USD', 19.5000, '2025-04-21', 1, '2025-04-21 16:19:36', '2025-04-21 16:19:55'),
(2, 'MXN', 1.0000, '2025-04-27', 1, '2025-04-27 07:40:53', '2025-04-27 07:40:53');

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
(27, '2025_04_27_100702_create_tipo_consulta_table', 14),
(28, '2025_04_27_113218_create_consulta_table', 15),
(29, '2025_04_28_011107_add_tasa_cambio_to_divisas_table', 16),
(30, '2025_05_02_115248_create_consulta_table', 17),
(31, '2025_05_02_120548_create_consulta_table', 18),
(32, '2025_05_03_234540_create_consulta_table', 19),
(33, '2025_05_04_104120_add_nombre_consultorio_direccion_estado_consulta_to_consulta_table', 20),
(34, '2025_05_06_112453_add_mm_to_consulta_table', 21),
(35, '2025_05_08_083615_create_reservaciones_table', 22),
(36, '2025_05_08_083642_create_notificaciones_create', 23),
(37, '2025_05_08_093900_create_reservaciones_table', 24),
(38, '2025_05_08_093934_create_notificaciones_table', 25),
(39, '2025_05_08_101312_create_reservaciones_table', 26),
(40, '2025_05_08_101350_create_notificaciones_table', 27),
(41, '2025_05_09_121643_create_reservaciones_table', 28),
(42, '2025_05_09_121759_create_reservaciones_table', 29),
(43, '2025_05_09_121834_create_notificaciones_table', 30),
(44, '2025_05_09_122148_create_reservaciones_table', 31),
(45, '2025_05_09_122225_create_notificaciones_table', 32),
(46, '2025_05_09_230257_create_reservaciones_table', 33),
(47, '2025_05_09_230400_create_notificaciones_table', 34),
(48, '2025_05_09_231316_create_reservaciones_table', 35),
(49, '2025_05_09_231352_create_notificaciones_table', 35),
(50, '2025_05_09_235815_create_reservaciones_table', 36),
(51, '2025_05_09_235844_create_notificaciones_table', 36),
(52, '2025_05_10_011416_create_reservacion_table', 37),
(53, '2025_05_10_011827_create_notificaciones_table', 37),
(54, '2025_05_10_024357_create_reservaciones_table', 38),
(55, '2025_05_10_024523_create_notificaciones_table', 38),
(56, '2025_05_15_034352_create_ajustes_table', 39),
(57, '2025_05_15_073322_add_table_status_to_ajustes_table', 40);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `Notificacion_ID` int(10) UNSIGNED NOT NULL,
  `Reservacion_ID` int(10) UNSIGNED DEFAULT NULL,
  `Chat_ID` int(10) UNSIGNED DEFAULT NULL,
  `Paciente_ID` int(10) UNSIGNED DEFAULT NULL,
  `Consulta_ID` int(10) UNSIGNED DEFAULT NULL,
  `tipo_notificacion` tinyint(4) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `descripcion_mensaje` text NOT NULL,
  `nombre_consultorio` text DEFAULT NULL,
  `direccion_consultorio` text DEFAULT NULL,
  `nombre_nutriologo` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `estado` tinyint(4) NOT NULL DEFAULT 1,
  `tiempo_transcurrido` varchar(255) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`Notificacion_ID`, `Reservacion_ID`, `Chat_ID`, `Paciente_ID`, `Consulta_ID`, `tipo_notificacion`, `nombre`, `apellidos`, `foto`, `descripcion_mensaje`, `nombre_consultorio`, `direccion_consultorio`, `nombre_nutriologo`, `status`, `estado`, `tiempo_transcurrido`, `fecha_creacion`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 1, NULL, NULL, NULL, 1, 'Juanito', 'López', NULL, 'Nueva cita programada para   el día 2025-05-11 10:00 (Estado: En espera)', NULL, NULL, NULL, 0, 1, '0 seconds ago', '2025-05-10 02:46:18', '2025-05-10 08:46:18', '2025-05-10 08:46:18', 2),
(2, 1, NULL, NULL, NULL, 1, 'Juanito', 'López', NULL, 'Tu cita ha sido actualizada en NutriVida Campeche Calle 20 #158, Col. Centro, Calkiní, Campeche, C.P. 24900 con estado: En progreso para el día 2025-05-11 10:00', NULL, NULL, NULL, 0, 1, '0 seconds ago', '2025-05-10 02:55:55', '2025-05-10 08:55:55', '2025-05-10 08:55:55', 2),
(3, 2, NULL, NULL, NULL, 1, 'Francisco', 'López', NULL, 'Nueva cita programada para   el día 2025-05-13 11:00 (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 02:59:56', '2025-05-10 08:59:56', '2025-05-10 08:59:56', 2),
(4, 2, NULL, NULL, NULL, 1, 'Francisco', 'López', NULL, 'Tu cita ha sido actualizada en Clínica NutriBalance Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400 con estado: En progreso para el día 2025-05-13 11:00', 'Clínica NutriBalance', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 03:00:46', '2025-05-10 09:00:46', '2025-05-10 09:00:46', 2),
(5, 1, NULL, NULL, NULL, 1, 'Juanito', 'López', NULL, 'Tu cita ha sido actualizada en NutriVida Campeche Calle 20 #158, Col. Centro, Calkiní, Campeche, C.P. 24900 con estado: Próxima consulta para el día 2025-05-16 13:00', 'NutriVida Campeche', 'Calle 20 #158, Col. Centro, Calkiní, Campeche, C.P. 24900', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 03:05:48', '2025-05-10 09:05:48', '2025-05-10 09:05:48', 2),
(6, 3, NULL, NULL, NULL, 1, 'Juanito', 'López', NULL, 'Tu cita ha sido actualizada en NutriVida Campeche Calle 20 #158, Col. Centro, Calkiní, Campeche, C.P. 24900 con estado: En espera para el día 2025-05-16 13:00', 'NutriVida Campeche', 'Calle 20 #158, Col. Centro, Calkiní, Campeche, C.P. 24900', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 03:05:48', '2025-05-10 09:05:48', '2025-05-10 09:05:48', 2),
(7, 2, NULL, NULL, NULL, 1, 'Francisco', 'López', NULL, 'Tu cita ha sido actualizada en Clínica NutriBalance Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400 con estado: Próxima consulta para el día 2025-05-30 14:00', 'Clínica NutriBalance', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 03:16:09', '2025-05-10 09:16:09', '2025-05-10 09:16:09', 2),
(8, 4, NULL, NULL, NULL, 1, 'Francisco', 'López', NULL, 'Tu cita ha sido actualizada en Clínica NutriBalance Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400 con estado: En espera para el día 2025-05-30 14:00', 'Clínica NutriBalance', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 03:16:09', '2025-05-10 09:16:09', '2025-05-10 09:16:09', 2),
(9, 5, NULL, NULL, NULL, 1, 'Javier', 'López', NULL, 'Nueva cita programada para   el día 2025-05-15 09:00con el Nut.Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 03:23:36', '2025-05-10 09:23:36', '2025-05-10 09:23:36', 2),
(10, 5, NULL, NULL, NULL, 1, 'Javier', 'López', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche, C.P. 24900 con estado: En progreso para el día 2025-05-15 09:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche, C.P. 24900', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 03:24:34', '2025-05-10 09:24:34', '2025-05-10 09:24:34', 2),
(11, 5, NULL, NULL, NULL, 1, 'Javier', 'López', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche, C.P. 24900con el Nut. Alan Antony Puc Yam con estado: Próxima consulta para el día 2025-05-28 15:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche, C.P. 24900', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 03:26:30', '2025-05-10 09:26:30', '2025-05-10 09:26:30', 2),
(12, 6, NULL, NULL, NULL, 1, 'Javier', 'López', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche, C.P. 24900con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-05-28 15:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche, C.P. 24900', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 03:26:30', '2025-05-10 09:26:30', '2025-05-10 09:26:30', 2),
(13, 7, NULL, NULL, NULL, 1, 'Regina', 'Estrada', NULL, 'Nueva cita programada para   el día 2025-05-16 09:00con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 03:40:24', '2025-05-10 09:40:24', '2025-05-10 09:40:24', 2),
(14, 7, NULL, NULL, NULL, 1, 'Regina', 'Estrada', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campechecon el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-16 09:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 03:41:15', '2025-05-10 09:41:15', '2025-05-10 09:41:15', 2),
(15, 7, NULL, NULL, NULL, 1, 'Regina', 'Estrada', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campechecon el Nut. Alan Antony Puc Yam con estado: Próxima consulta para el día 2025-05-31 09:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 03:41:46', '2025-05-10 09:41:46', '2025-05-10 09:41:46', 2),
(16, 8, NULL, NULL, NULL, 1, 'Regina', 'Estrada', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campechecon el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-05-31 09:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 03:41:46', '2025-05-10 09:41:46', '2025-05-10 09:41:46', 2),
(17, 9, NULL, NULL, NULL, 1, 'Regina', 'Caceres', NULL, 'Nueva cita programada para   el día 2025-05-13 09:00con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 03:47:24', '2025-05-10 09:47:24', '2025-05-10 09:47:24', 2),
(18, 9, NULL, NULL, NULL, 1, 'Regina', 'Caceres', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campechecon el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-13 09:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 03:47:54', '2025-05-10 09:47:54', '2025-05-10 09:47:54', 2),
(19, 9, NULL, NULL, NULL, 1, 'Regina', 'Caceres', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campechecon el Nut. Alan Antony Puc Yam con estado: Próxima consulta para el día 2025-05-26 15:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 03:48:19', '2025-05-10 09:48:19', '2025-05-10 09:48:19', 2),
(20, 10, NULL, NULL, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-18 09:00con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 03:54:40', '2025-05-10 09:54:40', '2025-05-10 09:54:40', 2),
(21, 10, NULL, NULL, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campechecon el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-18 09:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 03:55:31', '2025-05-10 09:55:31', '2025-05-10 09:55:31', 2),
(22, 10, NULL, NULL, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campechecon el Nut. Alan Antony Puc Yam con estado: Próxima consulta para el día 2025-05-29 14:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 03:55:53', '2025-05-10 09:55:53', '2025-05-10 09:55:53', 2),
(23, 11, NULL, NULL, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campechecon el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-05-29 14:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 03:55:53', '2025-05-10 09:55:53', '2025-05-10 09:55:53', 2),
(24, 12, NULL, NULL, NULL, 1, 'Alondra', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-18 09:00con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 03:59:13', '2025-05-10 09:59:13', '2025-05-10 09:59:13', 2),
(25, 12, NULL, NULL, NULL, 1, 'Alondra', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-18 09:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 04:00:40', '2025-05-10 10:00:40', '2025-05-10 10:00:40', 2),
(26, 12, NULL, NULL, NULL, 1, 'Alondra', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche con el Nut. Alan Antony Puc Yam con estado: Próxima consulta para el día 2025-05-31 13:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 04:01:03', '2025-05-10 10:01:03', '2025-05-10 10:01:03', 2),
(27, 13, NULL, NULL, NULL, 1, 'Alondra', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-05-31 13:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 04:01:03', '2025-05-10 10:01:03', '2025-05-10 10:01:03', 2),
(28, 14, NULL, NULL, NULL, 1, 'Jimena', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-10 09:00 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 04:08:38', '2025-05-10 10:08:38', '2025-05-10 10:08:38', 2),
(29, 14, NULL, NULL, NULL, 1, 'Jimena', 'Cuevas', NULL, 'Tu cita ha sido actualizada en NutriVida Campeche Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-10 09:00', 'NutriVida Campeche', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 04:08:59', '2025-05-10 10:08:59', '2025-05-10 10:08:59', 2),
(30, 14, NULL, NULL, NULL, 1, 'Jimena', 'Cuevas', NULL, 'Tu cita ha sido actualizada en NutriVida Campeche Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche con el Nut. Alan Antony Puc Yam con estado: Próxima consulta para el día 2025-05-30 12:00', 'NutriVida Campeche', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 04:09:24', '2025-05-10 10:09:24', '2025-05-10 10:09:24', 2),
(31, 15, NULL, NULL, NULL, 1, 'Jimena', 'Cuevas', NULL, 'Tu cita ha sido actualizada en NutriVida Campeche Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-05-30 12:00', 'NutriVida Campeche', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 04:09:24', '2025-05-10 10:09:24', '2025-05-10 10:09:24', 2),
(32, 16, NULL, NULL, NULL, 1, 'Berenice', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-10 09:00 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 04:13:00', '2025-05-10 10:13:00', '2025-05-10 10:13:00', 2),
(33, 16, NULL, NULL, NULL, 1, 'Berenice', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-10 09:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 04:14:37', '2025-05-10 10:14:37', '2025-05-10 10:14:37', 2),
(34, 16, NULL, NULL, NULL, 1, 'Berenice', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche con el Nut. Alan Antony Puc Yam con estado: Próxima consulta para el día 2025-05-28 15:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 04:15:13', '2025-05-10 10:15:13', '2025-05-10 10:15:13', 2),
(35, 17, NULL, NULL, NULL, 1, 'Berenice', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-05-28 15:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 04:15:13', '2025-05-10 10:15:13', '2025-05-10 10:15:13', 2),
(36, 18, NULL, NULL, NULL, 1, 'Alice', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-16 09:00 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 04:18:12', '2025-05-10 10:18:12', '2025-05-10 10:18:12', 2),
(37, 18, NULL, NULL, NULL, 1, 'Alice', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-16 09:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 04:18:37', '2025-05-10 10:18:37', '2025-05-10 10:18:37', 2),
(38, 18, NULL, NULL, NULL, 1, 'Alice', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche con el Nut. Alan Antony Puc Yam con estado: Realizado para el día 2025-05-29 12:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 04:18:59', '2025-05-10 10:18:59', '2025-05-10 10:18:59', 2),
(39, 19, NULL, NULL, NULL, 1, 'Alice', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-05-29 12:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 04:18:59', '2025-05-10 10:18:59', '2025-05-10 10:18:59', 2),
(40, 4, NULL, NULL, NULL, 1, 'Francisco', 'López', NULL, 'Tu cita ha sido actualizada en Clínica NutriBalance Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400 con el Nut. Alan Antony Puc Yam con estado: Cancelado para el día 2025-05-30 14:00', 'Clínica NutriBalance', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 04:21:46', '2025-05-10 10:21:46', '2025-05-10 10:21:46', 2),
(41, 15, NULL, NULL, NULL, 1, 'Jimena', 'Cuevas', NULL, 'Tu cita ha sido actualizada en NutriVida Campeche Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche con el Nut. Alan Antony Puc Yam con estado: Cancelado para el día Friday, 30 May 2025 a las 12:00', 'NutriVida Campeche', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 04:33:12', '2025-05-10 10:33:12', '2025-05-10 10:33:12', 2),
(42, 19, NULL, NULL, NULL, 1, 'Alice', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-29 12:00 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 04:38:14', '2025-05-10 10:38:14', '2025-05-10 10:38:14', 2),
(43, 20, NULL, NULL, NULL, 1, 'Alicete', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-16 09:00 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 1, 1, '0 seconds ago', '2025-05-10 05:10:42', '2025-05-10 11:10:42', '2025-05-10 16:55:50', 2),
(44, 17, NULL, NULL, NULL, 1, 'Berenice', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-28 15:00 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 08:01:24', '2025-05-10 14:01:24', '2025-05-10 14:01:24', 2),
(45, 21, NULL, NULL, NULL, 1, 'Miko', 'Reborth', NULL, 'Nueva cita programada para   el día 2025-05-12 16:00 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 08:30:25', '2025-05-10 14:30:25', '2025-05-10 14:30:25', 2),
(46, 21, NULL, NULL, NULL, 1, 'Miko', 'Reborth', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-24 17:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 08:32:41', '2025-05-10 14:32:41', '2025-05-10 14:32:41', 2),
(47, 21, NULL, NULL, NULL, 1, 'Miko', 'Reborth', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-24 00:00 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 08:33:43', '2025-05-10 14:33:43', '2025-05-10 14:33:43', 2),
(48, 22, NULL, NULL, NULL, 1, 'Miko', 'Reborth', NULL, 'Nueva cita programada para   el día 2025-05-12 16:00 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 08:33:56', '2025-05-10 14:33:56', '2025-05-10 14:33:56', 2),
(49, 22, NULL, NULL, NULL, 1, 'Miko', 'Reborth', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-12 16:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 08:34:26', '2025-05-10 14:34:26', '2025-05-10 14:34:26', 2),
(50, 22, NULL, NULL, NULL, 1, 'Miko', 'Reborth', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche con el Nut. Alan Antony Puc Yam con estado: Realizado para el día 2025-05-24 18:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 08:35:44', '2025-05-10 14:35:44', '2025-05-10 14:35:44', 2),
(51, 23, NULL, NULL, NULL, 1, 'Miko', 'Reborth', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-05-24 18:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-10 08:35:44', '2025-05-10 14:35:44', '2025-05-10 14:35:44', 2),
(52, 24, NULL, NULL, NULL, 1, 'Alice', 'Reborth', NULL, 'Nueva cita programada para   el día 2025-05-12 16:00 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 1, 1, '0 seconds ago', '2025-05-10 11:38:19', '2025-05-10 17:38:19', '2025-05-10 18:45:49', 2),
(53, 25, NULL, NULL, NULL, 1, 'Angel', 'Chan', NULL, 'Nueva cita programada para   el día 2025-05-20 14:00 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 1, 1, '0 seconds ago', '2025-05-10 12:28:01', '2025-05-10 18:28:01', '2025-05-10 18:48:14', 2),
(54, 26, NULL, NULL, NULL, 1, 'Angel2', 'Chan', NULL, 'Nueva cita programada para   el día 2025-05-22 14:00 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 1, 1, '0 seconds ago', '2025-05-10 12:29:11', '2025-05-10 18:29:11', '2025-05-10 18:47:46', 2),
(55, 27, NULL, NULL, NULL, 1, 'Melissa', 'Chan', NULL, 'Nueva cita programada para   el día 2025-05-23 14:00 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 1, 1, '0 seconds ago', '2025-05-10 12:34:19', '2025-05-10 18:34:19', '2025-05-10 18:49:04', 2),
(56, 28, NULL, NULL, NULL, 1, 'Melissa', 'Chan', NULL, 'Nueva cita programada para   el día 2025-05-25 14:00 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 1, 1, '0 seconds ago', '2025-05-10 12:50:29', '2025-05-10 18:50:29', '2025-05-10 18:50:49', 2),
(57, 29, NULL, NULL, NULL, 1, 'Melissass', 'Chan', NULL, 'Nueva cita programada para   el día 2025-05-14 14:00 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-12 06:56:56', '2025-05-12 12:56:56', '2025-05-12 12:56:56', 2),
(58, 30, NULL, NULL, NULL, 1, 'Smara', 'Chan', NULL, 'Nueva cita programada para   el día 2025-05-15 14:00 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-12 07:07:43', '2025-05-12 13:07:43', '2025-05-12 13:07:43', 2),
(59, 31, NULL, NULL, NULL, 1, 'Smara2', 'Chan', NULL, 'Nueva cita programada para   el día 2025-05-15 14:00 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-12 07:08:23', '2025-05-12 13:08:23', '2025-05-12 13:08:23', 2),
(60, 32, NULL, NULL, NULL, 1, 'Samara', 'Camara', NULL, 'Nueva cita programada para   el día 2025-05-12 14:00 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-12 07:15:29', '2025-05-12 13:15:29', '2025-05-12 13:15:29', 2),
(61, 33, NULL, NULL, NULL, 1, 'Ameli', 'Horta', NULL, 'Nueva cita programada para   el día 2025-05-19 14:00 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-12 07:19:25', '2025-05-12 13:19:25', '2025-05-12 13:19:25', 2),
(62, 34, NULL, NULL, NULL, 1, 'Amelis', 'Horta', NULL, 'Nueva cita programada para   el día 2025-05-19 14:00 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-12 07:32:08', '2025-05-12 13:32:08', '2025-05-12 13:32:08', 2),
(63, 35, NULL, NULL, NULL, 1, 'Amelis2', 'Horta', NULL, 'Nueva cita programada para   el día 2025-05-19 14:00 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-12 07:32:35', '2025-05-12 13:32:35', '2025-05-12 13:32:35', 2),
(64, 36, NULL, NULL, NULL, 1, 'Amelis22', 'Horta', NULL, 'Nueva cita programada para   el día 2025-05-19 14:00 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, '0 seconds ago', '2025-05-12 07:33:15', '2025-05-12 13:33:15', '2025-05-12 13:33:15', 2);

--
-- Disparadores `notificaciones`
--
DELIMITER $$
CREATE TRIGGER `update_reservacion_notificacion_id` AFTER INSERT ON `notificaciones` FOR EACH ROW BEGIN
                IF NEW.Reservacion_ID IS NOT NULL AND NEW.tipo_notificacion = 1 THEN
                    UPDATE reservaciones
                    SET Ultima_Notificacion_ID = NEW.Notificacion_ID
                    WHERE Reservacion_ID = NEW.Reservacion_ID;
                END IF;
            END
$$
DELIMITER ;

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
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
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
(1, 'http://127.0.0.1:8000/storage/pacientes/1745495611_regina.png', 'Regina', 'Estrada', 'Estrada21@gmail.com', '9995241085', 'Femenino', 'ResgEstrada', 2, 2, 'Hipertension', 1, 1, 'Calkini', 'Campeche', 24, '2003-04-09', '2025-04-23', '2025-04-24 04:38:13', '2025-05-05 16:58:52'),
(2, 'http://127.0.0.1:8000/storage/pacientes/1745458516_testcom.jpg', 'Lyura', 'Celestina', 'Celestina@gmail.com', '9961052845', 'Femenino', 'Celestina', 2, 2, 'Hepatitis B', 1, 1, 'Pomuch', 'Campeche', 25, '2003-04-24', '2025-04-23', '2025-04-24 04:47:21', '2025-05-08 01:36:09'),
(3, NULL, 'Angelica', 'Moreno', 'angelicaMron@gmail.com', '9961018212', 'Femenino', 'asfsfasfasfss', 2, 2, 'Artritis,Cancer Pulmonar', 1, 1, 'Nunkini', 'Campeche', 28, '1998-05-29', '2025-04-23', '2025-04-24 05:26:36', '2025-05-07 08:53:06'),
(4, 'http://127.0.0.1:8000/storage/pacientes/1745454970_alan-antony.jpeg', 'Alan Antony', 'Puc Yam', 'lyon_arthur2@hotmail.com', '9961018215', 'Masculino', 'Lyon_Arthur', 2, 2, 'Ninguna', 1, 1, NULL, NULL, NULL, NULL, '2025-04-24', '2025-04-24 06:36:10', '2025-04-24 17:49:48'),
(5, 'http://127.0.0.1:8000/storage/pacientes/1746409781_alcrya.png', 'Alcrya', 'Lumina', 'LyrcaLumina@gmail.com', '9961025841', 'Femenino', 'Alcrya Lumina', 2, 2, 'Disformia,Hipertensión', 1, 1, 'Merida', 'Yucatán', 20, '2002-12-12', '2025-05-05', '2025-05-05 07:48:39', '2025-05-05 07:51:54'),
(15, 'http://192.168.50.221:8000/storage/pacientes/1747275591_monserrat.jpg', 'Isabel', 'Cuevas', 'monsecuevas@gmail.com', '9961025846', 'Femenino', 'monsee', 2, NULL, 'Artritis', 1, 1, 'Calkini', 'Campeche', 22, '2003-04-16', '2025-05-14', '2025-05-14 17:22:14', '2025-05-15 20:31:03'),
(16, 'http://192.168.50.221:8000/storage/pacientes/1747278798_paula.jpg', 'Paula', 'Tuz Tuz', 'pautuztuz@gmail.com', '9993340566', 'Femenino', 'PauTuz', 2, 2, 'ninguna', 1, 1, 'Pomuch', 'Hecelchakan', 20, '2004-07-27', '2025-05-14', '2025-05-15 09:12:53', '2025-05-15 09:13:18');

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
-- Estructura de tabla para la tabla `reservaciones`
--

CREATE TABLE `reservaciones` (
  `Reservacion_ID` int(10) UNSIGNED NOT NULL,
  `Consulta_ID` int(10) UNSIGNED DEFAULT NULL,
  `Paciente_ID` int(10) UNSIGNED DEFAULT NULL,
  `Ultima_Notificacion_ID` int(10) UNSIGNED DEFAULT NULL,
  `nombre_paciente` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `genero` varchar(255) DEFAULT NULL,
  `usuario` varchar(255) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `precio_cita` decimal(8,2) DEFAULT NULL,
  `motivo_consulta` text DEFAULT NULL,
  `nombre_consultorio` text DEFAULT NULL,
  `direccion_consultorio` text DEFAULT NULL,
  `nombre_nutriologo` text DEFAULT NULL,
  `fecha_consulta` datetime NOT NULL,
  `fecha_proximaConsulta` datetime DEFAULT NULL,
  `estado_proximaConsulta` tinyint(4) NOT NULL DEFAULT 0,
  `origen` enum('movil','web') NOT NULL DEFAULT 'web',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `reservaciones`
--

INSERT INTO `reservaciones` (`Reservacion_ID`, `Consulta_ID`, `Paciente_ID`, `Ultima_Notificacion_ID`, `nombre_paciente`, `apellidos`, `telefono`, `genero`, `usuario`, `edad`, `precio_cita`, `motivo_consulta`, `nombre_consultorio`, `direccion_consultorio`, `nombre_nutriologo`, `fecha_consulta`, `fecha_proximaConsulta`, `estado_proximaConsulta`, `origen`, `created_at`, `updated_at`, `user_id`) VALUES
(1, NULL, NULL, 5, 'Juanito', 'López', '5551234567', 'Masculino', 'juanperez', 30, 585.00, 'Consulta nutricional inicial', 'NutriVida Campeche', 'Calle 20 #158, Col. Centro, Calkiní, Campeche, C.P. 24900', 'Alan Antony Puc Yam', '2025-05-11 10:00:00', '2025-05-16 13:00:00', 3, 'web', '2025-05-10 08:46:18', '2025-05-10 09:05:48', 2),
(2, NULL, NULL, 7, 'Francisco', 'López', '5551234567', 'Masculino', 'juanperez', 30, 585.00, 'Consulta nutricional inicial', 'Clínica NutriBalance', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', '2025-05-13 11:00:00', '2025-05-30 14:00:00', 2, 'web', '2025-05-10 08:59:56', '2025-05-10 09:16:09', 2),
(3, NULL, NULL, 6, 'Juanito', 'López', '5551234567', 'Masculino', 'juanperez', 30, 585.00, 'Seguimiento: Consulta nutricional inicial', 'NutriVida Campeche', 'Calle 20 #158, Col. Centro, Calkiní, Campeche, C.P. 24900', 'Alan Antony Puc Yam', '2025-05-16 13:00:00', NULL, 4, 'web', '2025-05-10 09:05:48', '2025-05-10 09:05:48', 2),
(4, NULL, NULL, 40, 'Francisco', 'López', '5551234567', 'Masculino', 'juanperez', 30, 585.00, 'Seguimiento: Consulta nutricional inicial', 'Clínica NutriBalance', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', '2025-05-30 14:00:00', NULL, 0, 'web', '2025-05-10 09:16:09', '2025-05-10 10:21:46', 2),
(5, NULL, NULL, 11, 'Javier', 'López', '5551234567', 'Masculino', 'juanperez', 30, 585.00, 'Consulta nutricional inicial', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche, C.P. 24900', 'Alan Antony Puc Yam', '2025-05-15 09:00:00', '2025-05-28 15:00:00', 2, 'web', '2025-05-10 09:23:36', '2025-05-10 09:26:30', 2),
(6, NULL, NULL, 12, 'Javier', 'López', '5551234567', 'Masculino', 'juanperez', 30, 585.00, 'Seguimiento: Consulta nutricional inicial', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche, C.P. 24900', 'Alan Antony Puc Yam', '2025-05-28 15:00:00', NULL, 4, 'web', '2025-05-10 09:26:30', '2025-05-10 09:26:30', 2),
(7, NULL, NULL, 15, 'Regina', 'Estrada', '5551234567', 'Femenino', 'Regina', 30, 585.00, 'Consulta nutricional inicial', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', '2025-05-16 09:00:00', '2025-05-31 09:00:00', 2, 'web', '2025-05-10 09:40:24', '2025-05-10 09:41:46', 2),
(8, NULL, NULL, 16, 'Regina', 'Estrada', '5551234567', 'Femenino', 'Regina', 30, 585.00, 'Seguimiento: Consulta nutricional inicial', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', '2025-05-31 09:00:00', NULL, 4, 'web', '2025-05-10 09:41:46', '2025-05-10 09:41:46', 2),
(9, NULL, NULL, 19, 'Regina', 'Caceres', '5551234567', 'Femenino', 'ReginaCaceres', 30, 585.00, 'Consulta nutricional inicial', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', '2025-05-13 09:00:00', '2025-05-26 15:00:00', 2, 'web', '2025-05-10 09:47:24', '2025-05-10 09:48:19', 2),
(10, NULL, NULL, 22, 'Isabel', 'Cuevas', '5551234567', 'Femenino', 'MOnsee', 30, 585.00, 'Consulta nutricional inicial', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', '2025-05-18 09:00:00', '2025-05-29 14:00:00', 2, 'web', '2025-05-10 09:54:40', '2025-05-10 09:55:53', 2),
(11, NULL, NULL, 23, 'Isabel', 'Cuevas', '5551234567', 'Femenino', 'MOnsee', 30, 585.00, 'Seguimiento: Consulta nutricional inicial', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', '2025-05-29 14:00:00', NULL, 4, 'web', '2025-05-10 09:55:53', '2025-05-10 09:55:53', 2),
(12, NULL, NULL, 26, 'Alondra', 'Cuevas', '5551234567', 'Femenino', 'Alondra', 30, 585.00, 'Consulta nutricional inicial', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', '2025-05-18 09:00:00', '2025-05-31 13:00:00', 2, 'web', '2025-05-10 09:59:13', '2025-05-10 10:01:03', 2),
(13, NULL, NULL, 27, 'Alondra', 'Cuevas', '5551234567', 'Femenino', 'Alondra', 30, 585.00, 'Seguimiento: Consulta nutricional inicial', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', '2025-05-31 13:00:00', NULL, 4, 'web', '2025-05-10 10:01:03', '2025-05-10 10:01:03', 2),
(14, NULL, NULL, 30, 'Jimena', 'Cuevas', '5551234567', 'Femenino', 'Jimena', 30, 585.00, 'Consulta nutricional inicial', 'NutriVida Campeche', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', '2025-05-10 09:00:00', '2025-05-30 12:00:00', 2, 'web', '2025-05-10 10:08:38', '2025-05-10 10:09:24', 2),
(15, NULL, NULL, 41, 'Jimena', 'Cuevas', '5551234567', 'Femenino', 'Jimena', 30, 585.00, 'Seguimiento: Consulta nutricional inicial', 'NutriVida Campeche', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', '2025-05-30 12:00:00', NULL, 0, 'web', '2025-05-10 10:09:24', '2025-05-10 10:33:12', 2),
(16, NULL, NULL, 34, 'Berenice', 'Cuevas', '5551234567', 'Femenino', 'Berenice', 30, 585.00, 'Consulta nutricional inicial', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', '2025-05-10 09:00:00', '2025-05-28 15:00:00', 2, 'web', '2025-05-10 10:13:00', '2025-05-10 10:15:13', 2),
(17, NULL, NULL, 44, 'Berenice', 'Cuevas', '5551234567', 'Femenino', 'Berenice', 30, 585.00, 'Seguimiento: Consulta nutricional inicial', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', '2025-05-28 15:00:00', NULL, 0, 'web', '2025-05-10 10:15:13', '2025-05-10 14:01:24', 2),
(18, NULL, NULL, 38, 'Alice', 'Cuevas', '5551234567', 'Femenino', 'Alice', 30, 585.00, 'Consulta nutricional inicial', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', '2025-05-16 09:00:00', '2025-05-29 12:00:00', 3, 'web', '2025-05-10 10:18:12', '2025-05-10 10:18:59', 2),
(19, NULL, NULL, 42, 'Alice', 'Cuevas', '5551234567', 'Femenino', 'Alice', 30, 585.00, 'Seguimiento: Consulta nutricional inicial', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', '2025-05-29 12:00:00', NULL, 0, 'web', '2025-05-10 10:18:59', '2025-05-10 10:38:14', 2),
(20, NULL, NULL, 43, 'Alicete', 'Cuevas', '5551234567', 'Femenino', 'Alicete', 30, 585.00, 'Consulta nutricional inicial', NULL, NULL, 'Alan Antony Puc Yam', '2025-05-16 09:00:00', NULL, 4, 'movil', '2025-05-10 11:10:42', '2025-05-10 11:10:42', 2),
(21, NULL, NULL, 47, 'Miko', 'Reborth', '5551234567', 'Femenino', 'Miko R.', 30, 585.00, 'Consulta nutricional inicial', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', '2025-05-12 16:00:00', '2025-05-24 00:00:00', 0, 'web', '2025-05-10 14:30:25', '2025-05-10 14:33:43', 2),
(22, NULL, NULL, 50, 'Miko', 'Reborth', '5551234567', 'Femenino', 'Miko', 30, 585.00, 'Consulta nutricional inicial', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', '2025-05-12 16:00:00', '2025-05-24 18:00:00', 3, 'web', '2025-05-10 14:33:56', '2025-05-10 14:35:44', 2),
(23, NULL, NULL, 51, 'Miko', 'Reborth', '5551234567', 'Femenino', 'Miko', 30, 585.00, 'Seguimiento: Consulta nutricional inicial', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche', 'Alan Antony Puc Yam', '2025-05-24 18:00:00', NULL, 4, 'web', '2025-05-10 14:35:44', '2025-05-10 14:35:44', 2),
(24, NULL, NULL, 52, 'Alice', 'Reborth', '5551234567', 'Femenino', 'Alice', 30, 585.00, 'Consulta nutricional inicial', NULL, NULL, 'Alan Antony Puc Yam', '2025-05-12 16:00:00', NULL, 4, 'movil', '2025-05-10 17:38:19', '2025-05-10 17:38:19', 2),
(25, NULL, NULL, 53, 'Angel', 'Chan', '5551234567', 'Femenino', 'Angelito', 30, 585.00, 'Consulta nutricional inicial', NULL, NULL, 'Alan Antony Puc Yam', '2025-05-20 14:00:00', NULL, 4, 'movil', '2025-05-10 18:28:01', '2025-05-10 18:28:01', 2),
(26, NULL, NULL, 54, 'Angel2', 'Chan', '5551234567', 'Femenino', 'Angelito22', 30, 585.00, 'Consulta nutricional inicial', NULL, NULL, 'Alan Antony Puc Yam', '2025-05-22 14:00:00', NULL, 4, 'movil', '2025-05-10 18:29:11', '2025-05-10 18:29:11', 2),
(27, NULL, NULL, 55, 'Melissa', 'Chan', '5551234567', 'Femenino', 'Meli_Chan', 30, 585.00, 'Consulta nutricional inicial', NULL, NULL, 'Alan Antony Puc Yam', '2025-05-23 14:00:00', NULL, 4, 'movil', '2025-05-10 18:34:19', '2025-05-10 18:34:19', 2),
(28, NULL, NULL, 56, 'Melissa', 'Chan', '5551234567', 'Femenino', 'Meli_Chane', 30, 585.00, 'Consulta nutricional inicial', NULL, NULL, 'Alan Antony Puc Yam', '2025-05-25 14:00:00', NULL, 4, 'movil', '2025-05-10 18:50:29', '2025-05-10 18:50:29', 2),
(29, NULL, NULL, 57, 'Melissass', 'Chan', '5551234567', 'Femenino', 'Meli_Chanes', 30, 585.00, 'Consulta nutricional inicial', NULL, NULL, 'Alan Antony Puc Yam', '2025-05-14 14:00:00', NULL, 4, 'movil', '2025-05-12 12:56:56', '2025-05-12 12:56:56', 2),
(30, NULL, NULL, 58, 'Smara', 'Chan', '5551234567', 'Femenino', 'Smaras', 30, 585.00, 'Consulta nutricional inicial', NULL, NULL, 'Alan Antony Puc Yam', '2025-05-15 14:00:00', NULL, 4, 'movil', '2025-05-12 13:07:43', '2025-05-12 13:07:43', 2),
(31, NULL, NULL, 59, 'Smara2', 'Chan', '5551234567', 'Femenino', 'Smaras2', 30, 585.00, 'Consulta nutricional inicial', NULL, NULL, 'Alan Antony Puc Yam', '2025-05-15 14:00:00', NULL, 4, 'movil', '2025-05-12 13:08:23', '2025-05-12 13:08:23', 2),
(32, NULL, NULL, 60, 'Samara', 'Camara', '5551234567', 'Femenino', 'Samara2', 30, 585.00, 'Consulta nutricional inicial', NULL, NULL, 'Alan Antony Puc Yam', '2025-05-12 14:00:00', NULL, 4, 'movil', '2025-05-12 13:15:29', '2025-05-12 13:15:29', 2),
(33, NULL, NULL, 61, 'Ameli', 'Horta', '5551234567', 'Femenino', 'Amelis', 30, 585.00, 'Consulta nutricional inicial', NULL, NULL, 'Alan Antony Puc Yam', '2025-05-19 14:00:00', NULL, 4, 'movil', '2025-05-12 13:19:25', '2025-05-12 13:19:25', 2),
(34, NULL, NULL, 62, 'Amelis', 'Horta', '5551234567', 'Femenino', 'Amelis2', 30, 585.00, 'Consulta nutricional inicial', NULL, NULL, 'Alan Antony Puc Yam', '2025-05-19 14:00:00', NULL, 4, 'movil', '2025-05-12 13:32:08', '2025-05-12 13:32:08', 2),
(35, NULL, NULL, 63, 'Amelis2', 'Horta', '5551234567', 'Femenino', 'Amelis22', 30, 585.00, 'Consulta nutricional inicial', NULL, NULL, 'Alan Antony Puc Yam', '2025-05-19 14:00:00', NULL, 4, 'movil', '2025-05-12 13:32:35', '2025-05-12 13:32:35', 2),
(36, NULL, NULL, 64, 'Amelis22', 'Horta', '5551234567', 'Femenino', 'Amelis222', 30, 585.00, 'Consulta nutricional inicial', NULL, NULL, 'Alan Antony Puc Yam', '2025-05-19 14:00:00', NULL, 4, 'movil', '2025-05-12 13:33:15', '2025-05-12 13:33:15', 2);

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
(2, 'Alan Antony', 'Puc Yam', 'puc-alan20@hotmail.com', 'WoolyOlvel', '$2y$12$2eX8kea.zxAt68bRmujfWOWPUKp3hgrfxgNlxSF2ltAABeYBU1svi', 'fjGLjzvqdpF96xfsO4BaORbqGCpWr2nufUk6CFVcSJjBSB1tAYtkQpuxIzVQ', 1, 1, 0, '2025-04-19 13:59:50', '2025-05-14 07:55:52', '2025-06-13 07:55:52'),
(3, 'Juan Pérez', 'Gil', 'juanperez@example.com', 'juancito', '$2y$12$e31DOZbPJieeUS.64JYbyuXxFvQJwiqIM0KlBCOTKBUXBklijQIiO', NULL, 1, 1, 0, '2025-05-08 09:47:43', '2025-05-08 09:47:43', NULL),
(4, 'Wilbert Edward', 'Yam', 'woolyolvel@gmail.com', 'Wepy25', '$2y$12$72sWhEMEeSTgt5EEhbngceeeaF0MdLOT8IAqcyOm7N61wUxGb1UlK', NULL, 1, 1, 0, '2025-05-09 17:31:33', '2025-05-14 07:27:41', '2025-06-08 17:32:02'),
(5, 'Regina C', 'Estrada', 'reginacaceres@gmail.com', 'regEstrada22', '$2y$12$sghG.YOSpPOeipkbZp6ud.E8Pn4k6kiXzQ1fKv0cg3amgAt6bUmla', NULL, 1, 1, 0, '2025-05-14 06:40:11', '2025-05-14 07:51:52', '2025-06-13 07:51:31'),
(6, 'Isabel', 'Cuevas', 'isaCuevas@gmail.com', 'isacuevas', '$2y$12$w1ZQX6jQG5r4V35Vhp5iZekCfA2GIwOdMS8UDqTWW8w823cDXM40.', NULL, 2, 1, 0, '2025-05-14 07:00:44', '2025-05-14 07:00:44', NULL),
(7, 'Wilbert', 'Puc Ku', 'wilberPucKu@gmail.com', 'pucku', '$2y$12$Z1LEz3hly8EvXNRFSE9XA.F1wKIyh7.3tLj3cvU2NsIVxifuiZjqu', NULL, 1, 1, 0, '2025-05-14 07:02:57', '2025-05-14 07:50:59', '2025-06-13 07:50:37'),
(8, 'Isabel', 'Cuevas', 'monsecuevas@gmail.com', 'monsee', '$2y$12$rMF75mAHj0K4YssDGzJpme4.E/FX1B1bv/acAOq.aCHVXHnNl4N.2', 'H1DqSWevuspZors7uqFfW28grEzCqjANtQpglCV7TRdI68Ogkf5XNI0kCg0l', 2, 1, 0, '2025-05-14 07:08:28', '2025-05-15 20:31:02', '2025-06-13 07:57:05'),
(9, 'Maria', 'Veronica', 'marivero@gmail.com', 'marivero', '$2y$12$7L5m4r7hRyTtdVdiGZ6gZ.aWtZdJKraYGDqvUDNGPOvINgjWq4vE2', NULL, 1, 1, 0, '2025-05-14 07:30:37', '2025-05-14 07:34:58', '2025-06-13 07:32:56'),
(10, 'Paula', 'Tuz Tuz', 'pautuztuz@gmail.com', 'PauTuz', '$2y$12$4kXAcvKD0pT6eMwDCLBgBuibA3x3RA3vNzonHRsDfQSNFtGdhEB9m', NULL, 2, 1, 0, '2025-05-15 09:10:26', '2025-05-15 09:10:26', NULL);

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
-- Indices de la tabla `ajustes`
--
ALTER TABLE `ajustes`
  ADD PRIMARY KEY (`Ajuste_ID`),
  ADD UNIQUE KEY `ajustes_email_unique` (`email`),
  ADD KEY `ajustes_user_id_index` (`user_id`),
  ADD KEY `ajustes_rol_id_index` (`rol_id`),
  ADD KEY `ajustes_nombre_nutriologo_apellido_nutriologo_index` (`nombre_nutriologo`,`apellido_nutriologo`),
  ADD KEY `ajustes_especialidad_index` (`especialidad`),
  ADD KEY `ajustes_ciudad_estado_index` (`ciudad`,`estado`);

--
-- Indices de la tabla `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `composicion_corporal`
--
ALTER TABLE `composicion_corporal`
  ADD PRIMARY KEY (`ComposicionCorporal_ID`);

--
-- Indices de la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`Consulta_ID`),
  ADD KEY `consulta_paciente_id_foreign` (`Paciente_ID`),
  ADD KEY `consulta_tipo_consulta_id_foreign` (`Tipo_Consulta_ID`),
  ADD KEY `consulta_user_id_foreign` (`user_id`),
  ADD KEY `consulta_documento_id_foreign` (`Documento_ID`),
  ADD KEY `consulta_pago_id_foreign` (`Pago_ID`),
  ADD KEY `consulta_divisa_id_foreign` (`Divisa_ID`);

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
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`Notificacion_ID`),
  ADD KEY `notificaciones_reservacion_id_foreign` (`Reservacion_ID`),
  ADD KEY `notificaciones_paciente_id_foreign` (`Paciente_ID`),
  ADD KEY `notificaciones_user_id_foreign` (`user_id`),
  ADD KEY `notificaciones_consulta_id_foreign` (`Consulta_ID`),
  ADD KEY `notificaciones_tipo_notificacion_status_estado_index` (`tipo_notificacion`,`status`,`estado`),
  ADD KEY `notificaciones_fecha_creacion_index` (`fecha_creacion`);

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
-- Indices de la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  ADD PRIMARY KEY (`Reservacion_ID`),
  ADD KEY `reservaciones_consulta_id_foreign` (`Consulta_ID`),
  ADD KEY `reservaciones_paciente_id_foreign` (`Paciente_ID`),
  ADD KEY `reservaciones_user_id_foreign` (`user_id`);

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
-- AUTO_INCREMENT de la tabla `ajustes`
--
ALTER TABLE `ajustes`
  MODIFY `Ajuste_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `composicion_corporal`
--
ALTER TABLE `composicion_corporal`
  MODIFY `ComposicionCorporal_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `consulta`
--
ALTER TABLE `consulta`
  MODIFY `Consulta_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `Notificacion_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `notification`
--
ALTER TABLE `notification`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `Paciente_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
-- AUTO_INCREMENT de la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  MODIFY `Reservacion_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ajustes`
--
ALTER TABLE `ajustes`
  ADD CONSTRAINT `ajustes_rol_id_foreign` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`),
  ADD CONSTRAINT `ajustes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `consulta_divisa_id_foreign` FOREIGN KEY (`Divisa_ID`) REFERENCES `divisas` (`Divisa_ID`),
  ADD CONSTRAINT `consulta_documento_id_foreign` FOREIGN KEY (`Documento_ID`) REFERENCES `documento` (`Documento_ID`),
  ADD CONSTRAINT `consulta_paciente_id_foreign` FOREIGN KEY (`Paciente_ID`) REFERENCES `paciente` (`Paciente_ID`),
  ADD CONSTRAINT `consulta_pago_id_foreign` FOREIGN KEY (`Pago_ID`) REFERENCES `pago` (`Pago_ID`),
  ADD CONSTRAINT `consulta_tipo_consulta_id_foreign` FOREIGN KEY (`Tipo_Consulta_ID`) REFERENCES `tipo_consulta` (`Tipo_Consulta_ID`),
  ADD CONSTRAINT `consulta_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones_consulta_id_foreign` FOREIGN KEY (`Consulta_ID`) REFERENCES `consulta` (`Consulta_ID`),
  ADD CONSTRAINT `notificaciones_paciente_id_foreign` FOREIGN KEY (`Paciente_ID`) REFERENCES `paciente` (`Paciente_ID`),
  ADD CONSTRAINT `notificaciones_reservacion_id_foreign` FOREIGN KEY (`Reservacion_ID`) REFERENCES `reservaciones` (`Reservacion_ID`),
  ADD CONSTRAINT `notificaciones_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD CONSTRAINT `paciente_rol_id_foreign` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`),
  ADD CONSTRAINT `paciente_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  ADD CONSTRAINT `reservaciones_consulta_id_foreign` FOREIGN KEY (`Consulta_ID`) REFERENCES `consulta` (`Consulta_ID`),
  ADD CONSTRAINT `reservaciones_paciente_id_foreign` FOREIGN KEY (`Paciente_ID`) REFERENCES `paciente` (`Paciente_ID`),
  ADD CONSTRAINT `reservaciones_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_rol_id_foreign` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
