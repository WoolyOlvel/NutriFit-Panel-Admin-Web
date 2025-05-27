-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-05-2025 a las 16:30:56
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
(1, 2, 1, 'Alan Antony', 'Puc Yam', 'puc-alan20@hotmail.com', '9961018215', 22, 'Masculino', '2003-04-28', 'Lic.Nutricion', 'Nutrición Clínica', 'UAC', 'Diabetes I', 'AutoInmunes', 'Como nutriólogo especializado en enfermedades autoinmunes, me enfoco en diseñar planes de alimentación personalizados para personas que padecen condiciones como lupus, artritis reumatoide, enfermedad celíaca, esclerosis múltiple, tiroiditis de Hashimoto, entre otras.', '10', '<p><strong>Enfermedades crónicas y metabólicas:</strong></p><ul><li>Diabetes tipo 1 y 2</li><li>Hipertensión arterial</li><li>Colesterol y triglicéridos altos (dislipidemias)</li><li>Síndrome metabólico</li><li>Obesidad y sobrepeso</li><li>Hígado graso no alcohólico</li><li>Hipotiroidismo e hipertiroidismo</li></ul><p><strong>Enfermedades autoinmunes (especialidad):</strong></p><ul><li>Lupus eritematoso sistémico</li><li>Artritis reumatoide</li><li>Enfermedad celíaca</li><li>Tiroiditis de Hashimoto</li><li>Esclerosis múltiple</li><li>Psoriasis</li><li>Enfermedad de Crohn</li><li>Colitis ulcerosa</li></ul>', 'http://127.0.0.1:8000/storage/nutriologos/1747302812_alan-antony.jpeg', 'http://127.0.0.1:8000/storage/fotos_portadas/1747313108_portada_alan-antony.jpg', 12, 'Lunes a Viernes: 10:00AM-4:00PM, 6:00PM-8:00PM', 'Soy nutriólogo y mi misión es ayudarte a alcanzar un estilo de vida más saludable por medio de una alimentación equilibrada y personalizada. Me especializo en evaluar tu estado nutricional, entender tus hábitos y necesidades, y construir contigo un plan que no solo funcione, sino que también se adapte a ti.', 'Calkini', 'Campeche', 'Presencial', 'Disponibles', 1, '2025-05-15 09:07:51', '2025-05-15 15:07:51', '2025-05-16 15:35:03'),
(2, 11, 1, 'Regina', 'Caceres Estrada', 'caceresEstrada@gmail.com', '9812531245', 27, 'Femenino', '1998-02-03', 'Nutrióloga', 'Nutrición Clínica', 'Universidad Autónoma de Campeche', 'Diplomado en Nutrición Funcional, Diplomado en Abordaje Nutricional de Enfermedades Autoinmunes', 'Autoinmunes', 'Especialización enfocada en el manejo nutricional de enfermedades autoinmunes como lupus, artritis reumatoide, enfermedad celíaca y tiroiditis de Hashimoto, con base en estrategias antiinflamatorias y funcionales.', '12', '<p><strong>Enfermedades Tratadas:</strong></p><ul><li>Lupus Eritematoso Sistémico</li><li>Artritis Reumatoide</li><li>Tiroiditis de Hashimoto</li><li>Enfermedad Celíaca</li><li>Esclerosis Múltiple</li><li>Psoriasis</li><li>Colitis Ulcerativa</li><li>Enfermedad de Crohn</li><li>Diabetes Tipo 1 y Tipo 2</li><li>Hipotiroidismo</li><li>Hipertensión Arterial</li><li>Síndrome Metabólico</li><li>Fibromialgia</li><li>Anemia</li><li>Obesidad y Sobrepeso</li><li>Gastritis Crónica</li><li>Hígado Graso</li><li>Dislipidemias (colesterol/triglicéridos elevados)</li></ul>', 'http://127.0.0.1:8000/storage/nutriologos/1747641849_regina.jpeg', 'http://127.0.0.1:8000/storage/fotos_portadas/1747641710_portada_regina.jpg', 45, 'Lunes a Viernes: 9:00 AM a 6:00 PM', 'Soy una nutrióloga comprometida con la salud integral de mis pacientes. Mi enfoque combina nutrición basada en evidencia, empatía y seguimiento personalizado, especialmente para quienes viven con enfermedades crónicas o autoinmunes. Mi objetivo es mejorar tu calidad de vida a través de una alimentación adecuada a tus necesidades.', 'Campeche', 'Campeche', 'Virtual', 'Pocos Cupos', 1, '2025-05-19 08:01:50', '2025-05-19 14:01:50', '2025-05-19 14:09:47');

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
  `proteina` decimal(5,2) DEFAULT NULL,
  `ec` decimal(5,2) DEFAULT NULL,
  `me` decimal(5,2) DEFAULT NULL,
  `gv` decimal(5,2) DEFAULT NULL,
  `pg` decimal(5,2) DEFAULT NULL,
  `gs` decimal(5,2) DEFAULT NULL,
  `meq` decimal(5,2) DEFAULT NULL,
  `bmr` decimal(7,2) DEFAULT NULL,
  `ac` decimal(5,2) DEFAULT NULL,
  `imc` decimal(5,2) DEFAULT NULL,
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

INSERT INTO `consulta` (`Consulta_ID`, `Paciente_ID`, `Tipo_Consulta_ID`, `user_id`, `Documento_ID`, `Pago_ID`, `Divisa_ID`, `nombre_paciente`, `apellidos`, `email`, `telefono`, `genero`, `usuario`, `enfermedad`, `localidad`, `ciudad`, `edad`, `fecha_nacimiento`, `nombre_nutriologo`, `peso`, `talla`, `cintura`, `cadera`, `gc`, `mm`, `em`, `altura`, `proteina`, `ec`, `me`, `gv`, `pg`, `gs`, `meq`, `bmr`, `ac`, `imc`, `detalles_diagnostico`, `resultados_evaluacion`, `analisis_nutricional`, `objetivo_descripcion`, `proxima_consulta`, `nombre_consultorio`, `direccion_consultorio`, `plan_nutricional_path`, `total_pago`, `fecha_creacion`, `estado`, `estado_proximaConsulta`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 2, 2, 2, 'Regina', 'Estrada', 'Estrada21@gmail.com', '9995241085', 'Femenino', 'ResgEstrada', 'Hipertension', 'Campeche', 'Calkini', 24, '2003-04-09', 'Alan Antony Puc Yam', 72.40, 'M', 83.00, 98.00, 32.50, 29.10, 30.00, 1.65, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>Paciente con antecedentes familiares de hipertensión. Presenta valores elevados de presión arterial en consulta previa. IMC en rango de sobrepeso. Se recomienda reducción progresiva de peso y ajuste en hábitos alimenticios y de actividad física.</p>', '<ul><li>IMC: 26.6 (Sobrepeso)</li><li>Riesgo cardiovascular moderado</li><li>Retención de líquidos leve</li><li>Hábitos alimenticios con alto consumo de sodio</li><li>Actividad física irregular</li></ul>', '<ul><li>Consumo calórico actual: 2200 kcal/día</li><li>Macronutrientes desequilibrados: exceso de carbohidratos simples y sodio</li><li>Ingesta de frutas y verduras: baja</li><li>Hidratación: insuficiente (&lt;1.5 L/día)</li></ul>', '<p>Reducir 6 kg en 3 meses mediante plan alimenticio hipocalórico controlado en sodio, aumentar ingesta de fibra y agua, e implementar actividad física moderada al menos 4 veces por semana. Mejorar perfil lipídico y reducir presión arterial.</p>', '2025-06-09 17:00:00', 'NutriVida Campeche', 'Calle 20 #158, Col. Centro, Calkiní, Campeche, C.P. 24900', '[\"http:\\/\\/127.0.0.1:8000\\/storage\\/plan_nutricional\\/reginaestrada\\/1\\/1_1746793598_0_referencias.pdf\"]', 585.00, '2025-05-09', 1, 3, '2025-05-09 18:26:38', '2025-05-09 18:26:38'),
(2, 25, 1, 11, 2, 2, 2, 'Isabel', 'Cuevas', 'monsecuevas@gmail.com', '9961025846_nut11', 'Femenino', 'monsee_nut11', 'Artritis', 'Campeche', 'Calkini', 22, '2003-04-16', 'Regina Caceres Estrada', 58.70, 'M', 82.00, 90.00, 30.40, 32.10, 25.00, 1.62, 17.20, 26.00, 22.40, 7.00, 0.00, 21.30, 28.50, 1335.00, 52.30, 22.40, '<p>Paciente con artritis leve en etapa de mantenimiento. Se reportan episodios esporádicos de inflamación articular, sin deformidades visibles.</p>', '<p>Valores bioquímicos dentro de parámetros aceptables. Nivel de grasa corporal ligeramente elevado. Buen tono muscular.</p>', '<p>Alimentación desbalanceada con bajo consumo de ácidos grasos esenciales. Necesario incorporar omega-3 y reducir alimentos inflamatorios.</p>', '<p>Mejorar el estado nutricional y reducir procesos inflamatorios mediante una dieta antiinflamatoria personalizada. Aumentar la masa muscular magra y mantener un peso saludable.</p>', '2025-05-26 12:00:00', 'Consultorio Nutricional Integral “Vitalité”', 'Calle 18 No. 102 x 19 y 21, Colonia Centro, Calkiní, Campeche', '[\"http:\\/\\/127.0.0.1:8000\\/storage\\/plan_nutricional\\/isabelcuevas\\/2\\/2_1748339092_0_cv-puc-yam-alan-antony-isc.doc\"]', 585.00, '2025-05-20', 1, 3, '2025-05-20 17:07:05', '2025-05-27 15:44:52'),
(3, 25, 1, 11, 2, 2, 2, 'Isabel', 'Cuevas', 'monsecuevas@gmail.com', '9961025846_nut11', 'Femenino', 'monsee_nut11', 'Artritis', 'Campeche', 'Calkini', 22, '2003-04-16', 'Regina Caceres Estrada', 58.70, 'M', 82.00, 90.00, 30.40, 32.10, 25.00, 1.62, 18.10, 24.00, 22.60, 6.00, 1.60, 20.10, 29.70, 1352.00, 53.90, 21.80, '<p>Paciente con artritis leve en etapa de mantenimiento. Se reportan episodios esporádicos de inflamación articular, sin deformidades visibles.</p>', '<p>Valores bioquímicos dentro de parámetros aceptables. Nivel de grasa corporal ligeramente elevado. Buen tono muscular.</p>', '<p>Alimentación desbalanceada con bajo consumo de ácidos grasos esenciales. Necesario incorporar omega-3 y reducir alimentos inflamatorios.</p>', '<p>Mejorar el estado nutricional y reducir procesos inflamatorios mediante una dieta antiinflamatoria personalizada. Aumentar la masa muscular magra y mantener un peso saludable.</p>', '2025-05-26 15:00:00', 'Consultorio Nutricional Integral “Vitalité”', 'Calle 18 No. 102 x 19 y 21, Colonia Centro, Calkiní, Campeche', '[\"http:\\/\\/127.0.0.1:8000\\/storage\\/plan_nutricional\\/isabelcuevas\\/3\\/3_1748339188_0_cv-presentacion-puc-yam-alan-antony.docx\"]', 585.00, '2025-05-22', 1, 3, '2025-05-22 09:40:00', '2025-05-27 15:46:28'),
(4, 25, 2, 11, 1, 1, 2, 'Isabel', 'Cuevas', 'monsecuevas@gmail.com', '9961025846_nut11', 'Femenino', 'monsee_nut11', 'Artritis', 'Campeche', 'Calkini', 22, '2003-04-16', 'Regina Caceres Estrada', 60.30, 'M', 85.00, 92.00, 28.90, 33.40, 24.00, 1.60, 18.90, 23.00, 22.90, 5.40, 2.10, 18.80, 30.50, 1371.00, 55.20, 21.60, '<p>Paciente presenta episodios moderados de inflamación articular. Se observa mejoría general desde última consulta, pero persiste rigidez matutina.</p>', '<p>Ligera reducción en porcentaje de grasa corporal. Masa muscular en incremento. No se detectan nuevos signos de desnutrición ni deficiencias graves.</p>', '<p>Consumo adecuado de proteínas y fibra, pero aún se excede ligeramente en consumo de azúcares simples y sodio.</p>', '<p>Reducir los niveles de inflamación y mantener el avance en composición corporal. Consolidar hábitos alimenticios antiinflamatorios y fomentar mayor actividad física funcional.</p>', '2025-06-13 11:30:00', 'Clínica NutriVida Activa', 'Calle 25 #204 x 30 y 32, Barrio San Luis, Calkiní, Campeche', '[\"http:\\/\\/127.0.0.1:8000\\/storage\\/plan_nutricional\\/isabelcuevas\\/4\\/4_1748339257_0_cv-puc-yam-alan-antony-isc.doc\"]', 292.00, '2025-05-23', 1, 3, '2025-05-23 07:11:09', '2025-05-27 15:47:37'),
(5, 15, 3, 2, 3, 4, 2, 'Isabel', 'Cuevas', 'monsecuevas@gmail.com', '9961025846', 'Femenino', 'monsee', 'Artritis', 'Campeche', 'Calkini', 22, '2003-04-16', 'Alan Antony Puc Yam', 57.30, 'M', 77.00, 92.00, 26.90, 34.10, 21.00, 1.61, 17.50, 24.00, 22.40, 6.50, 3.20, 21.30, 28.70, 1328.00, 53.80, 22.10, '<p>La paciente ha mostrado una respuesta positiva al plan alimenticio con reducción de grasa corporal y circunferencia abdominal, lo cual contribuye a una menor inflamación articular.</p>', '<ul><li>Mejora en la movilidad articular.</li><li>Disminución del dolor reportado.</li><li>Hábitos alimenticios más constantes y balanceados.</li><li>Mejora en composición corporal.</li></ul>', '<ul><li>Reducción efectiva de azúcares simples.</li><li>Incremento en alimentos antiinflamatorios (pescado azul, vegetales verdes, cúrcuma).</li><li>Buena adherencia al plan de hidratación.</li></ul>', '<p>Continuar reduciendo grasa visceral, mantener masa muscular y reforzar el sistema inmunológico para apoyar el tratamiento de artritis. Se promoverá la actividad física de bajo impacto.</p>', '2025-06-12 10:00:00', 'VitalBalance Calkiní', 'Calle 18 #255, entre 15 y 17, Centro, Calkiní, Campeche', NULL, 600.00, '2025-05-23', 1, 3, '2025-05-23 18:54:38', '2025-05-26 20:46:23');

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
(57, '2025_05_15_073322_add_table_status_to_ajustes_table', 40),
(58, '2025_05_18_020029_add_status_movil_to_notificaciones_table', 41),
(59, '2025_05_18_020526_add_table_status_movil_to_notificaciones_table', 42),
(60, '2025_05_18_021912_create_reservaciones_table', 43),
(61, '2025_05_18_022608_create_reservaciones_table', 44),
(62, '2025_05_18_022721_create_notificaciones_table', 45),
(63, '2025_05_19_125127_modify_paciente_table_unique_constraints', 46),
(64, '2025_05_24_145441_create_nutridesafios_table', 47),
(65, '2025_05_24_154220_create_nutridesafios_table', 48),
(66, '2025_05_26_134616_add_imc_to_consulta_table', 49),
(67, '2025_05_26_144317_update_bmr_column_in_consulta_table', 50);

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
  `status_movil` tinyint(4) NOT NULL DEFAULT 0,
  `estado` tinyint(4) NOT NULL DEFAULT 1,
  `estado_movil` tinyint(4) NOT NULL DEFAULT 1,
  `tiempo_transcurrido` varchar(255) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`Notificacion_ID`, `Reservacion_ID`, `Chat_ID`, `Paciente_ID`, `Consulta_ID`, `tipo_notificacion`, `nombre`, `apellidos`, `foto`, `descripcion_mensaje`, `nombre_consultorio`, `direccion_consultorio`, `nombre_nutriologo`, `status`, `status_movil`, `estado`, `estado_movil`, `tiempo_transcurrido`, `fecha_creacion`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 1, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-19 10:20 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 02:30:53', '2025-05-18 08:30:53', '2025-05-19 03:59:59', 2),
(2, 1, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400 con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-19 10:20', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 06:22:26', '2025-05-18 12:22:26', '2025-05-19 03:59:59', 2),
(3, 1, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400 con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-05-19 10:20', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 06:31:10', '2025-05-18 12:31:10', '2025-05-19 03:59:59', 2),
(4, 1, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400 con el Nut. Alan Antony Puc Yam con estado: Próxima consulta para el día 2025-05-28 15:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 06:32:27', '2025-05-18 12:32:27', '2025-05-19 03:59:59', 2),
(5, 2, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-19 09:50 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 06:34:05', '2025-05-18 12:34:05', '2025-05-19 03:59:59', 2),
(6, 2, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en 121221 asfasf con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-19 09:50', '121221', 'asfasf', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 06:34:39', '2025-05-18 12:34:39', '2025-05-19 03:59:59', 2),
(7, 2, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en 121221 asfasf con el Nut. Alan Antony Puc Yam con estado: Realizado para el día 2025-05-27 11:00', '121221', 'asfasf', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 06:35:15', '2025-05-18 12:35:15', '2025-05-19 03:59:59', 2),
(8, 3, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en 121221 asfasf con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-05-27 11:00', '121221', 'asfasf', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 06:35:15', '2025-05-18 12:35:15', '2025-05-19 03:59:59', 2),
(9, 3, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en 121221 asfasfss con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-27 11:00', '121221', 'asfasfss', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 06:49:14', '2025-05-18 12:49:14', '2025-05-19 03:59:59', 2),
(10, 3, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en 121221 asfasfss con el Nut. Alan Antony Puc Yam con estado: Realizado para el día 2025-05-30 12:00', '121221', 'asfasfss', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 06:50:11', '2025-05-18 12:50:11', '2025-05-19 03:59:59', 2),
(11, 4, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en 121221 asfasfss con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-05-30 12:00', '121221', 'asfasfss', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 06:50:11', '2025-05-18 12:50:11', '2025-05-19 03:59:59', 2),
(12, 4, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-30 12:00 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', '121221', 'asfasfss', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 06:52:31', '2025-05-18 12:52:31', '2025-05-19 03:59:59', 2),
(13, 5, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-21 12:25 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 07:04:36', '2025-05-18 13:04:36', '2025-05-19 03:59:59', 2),
(14, 5, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400 con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-21 12:25', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 07:05:03', '2025-05-18 13:05:03', '2025-05-19 03:59:59', 2),
(15, 5, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400 con el Nut. Alan Antony Puc Yam con estado: Realizado para el día 2025-05-30 16:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 07:08:44', '2025-05-18 13:08:44', '2025-05-19 03:59:59', 2),
(16, 6, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400 con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-05-30 16:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 07:08:44', '2025-05-18 13:08:44', '2025-05-19 03:59:59', 2),
(17, 7, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-20 10:50 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 1, 1, 1, 0, '0 seconds ago', '2025-05-18 07:11:01', '2025-05-18 13:11:01', '2025-05-19 03:59:59', 2),
(18, 7, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en pp safasf con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-20 10:50', 'pp', 'safasf', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 08:15:01', '2025-05-18 14:15:01', '2025-05-19 03:59:59', 2),
(19, 7, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en pp safasf con el Nut. Alan Antony Puc Yam con estado: Realizado para el día 2025-05-29 12:00', 'pp', 'safasf', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 08:15:38', '2025-05-18 14:15:38', '2025-05-19 03:59:59', 2),
(20, 8, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en pp safasf con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-05-29 12:00', 'pp', 'safasf', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 08:15:38', '2025-05-18 14:15:38', '2025-05-19 03:59:59', 2),
(21, 8, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en pp safasf con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-29 12:00', 'pp', 'safasf', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 08:23:24', '2025-05-18 14:23:24', '2025-05-19 03:59:59', 2),
(22, 8, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en pp safasf con el Nut. Alan Antony Puc Yam con estado: Realizado para el día 2025-06-02 12:00', 'pp', 'safasf', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 08:24:16', '2025-05-18 14:24:16', '2025-05-19 03:59:59', 2),
(23, 9, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en pp safasf con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-06-02 12:00', 'pp', 'safasf', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 08:24:16', '2025-05-18 14:24:16', '2025-05-19 03:59:59', 2),
(24, 10, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-22 10:25 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 1, 1, 1, 0, '0 seconds ago', '2025-05-18 08:33:00', '2025-05-18 14:33:00', '2025-05-19 03:59:59', 2),
(25, 10, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” 45454545 con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-22 10:25', 'Consultorio Nutricional “Vida y Salud”', '45454545', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 08:34:00', '2025-05-18 14:34:00', '2025-05-19 03:59:59', 2),
(26, 10, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” 45454545 con el Nut. Alan Antony Puc Yam con estado: Realizado para el día 2025-06-04 10:00', 'Consultorio Nutricional “Vida y Salud”', '45454545', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 08:34:51', '2025-05-18 14:34:51', '2025-05-19 03:59:59', 2),
(27, 11, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” 45454545 con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-06-04 10:00', 'Consultorio Nutricional “Vida y Salud”', '45454545', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 08:34:51', '2025-05-18 14:34:51', '2025-05-19 03:59:59', 2),
(28, 12, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-24 12:20 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 08:53:29', '2025-05-18 14:53:29', '2025-05-19 03:59:59', 2),
(29, 12, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Clínica NutriBalance 15 con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-24 12:20', 'Clínica NutriBalance', '15', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 08:54:02', '2025-05-18 14:54:02', '2025-05-19 03:59:59', 2),
(30, 12, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Clínica NutriBalance 15 con el Nut. Alan Antony Puc Yam con estado: Realizado para el día 2025-05-23 12:00', 'Clínica NutriBalance', '15', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 08:55:43', '2025-05-18 14:55:43', '2025-05-19 03:59:59', 2),
(31, 13, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Clínica NutriBalance 15 con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-05-23 12:00', 'Clínica NutriBalance', '15', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 08:55:43', '2025-05-18 14:55:43', '2025-05-19 03:59:59', 2),
(32, 14, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-21 10:24 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 08:58:28', '2025-05-18 14:58:28', '2025-05-19 03:59:59', 2),
(33, 14, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida 2 con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-21 10:24', 'Centro Integral NutriVida', '2', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 08:58:51', '2025-05-18 14:58:51', '2025-05-19 03:59:59', 2),
(34, 14, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida 2 con el Nut. Alan Antony Puc Yam con estado: Realizado para el día 2025-06-04 15:00', 'Centro Integral NutriVida', '2', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 12:53:41', '2025-05-18 18:53:41', '2025-05-19 03:59:59', 2),
(35, 15, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida 2 con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-06-04 15:00', 'Centro Integral NutriVida', '2', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 12:53:41', '2025-05-18 18:53:41', '2025-05-19 03:59:59', 2),
(36, 9, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400 con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-06-02 12:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 12:54:52', '2025-05-18 18:54:52', '2025-05-19 03:59:59', 2),
(37, 16, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-22 10:40 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 12:56:01', '2025-05-18 18:56:01', '2025-05-19 03:59:59', 2),
(38, 16, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400 con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-22 10:40', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 12:56:47', '2025-05-18 18:56:47', '2025-05-19 03:59:59', 2),
(39, 11, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” 45454545 con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-06-04 10:00', 'Consultorio Nutricional “Vida y Salud”', '45454545', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 12:58:30', '2025-05-18 18:58:30', '2025-05-19 03:59:59', 2),
(40, 11, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400 con el Nut. Alan Antony Puc Yam con estado: Realizado para el día 2025-06-10 17:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 13:01:39', '2025-05-18 19:01:39', '2025-05-19 03:59:59', 2),
(41, 17, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400 con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-06-10 17:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 13:01:39', '2025-05-18 19:01:39', '2025-05-19 03:59:59', 2),
(42, 17, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400 con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-06-10 17:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 13:02:29', '2025-05-18 19:02:29', '2025-05-19 03:59:59', 2),
(43, 17, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400 con el Nut. Alan Antony Puc Yam con estado: Realizado para el día 2025-06-17 09:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 13:03:18', '2025-05-18 19:03:18', '2025-05-19 03:59:59', 2),
(44, 18, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400 con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-06-17 09:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 13:03:18', '2025-05-18 19:03:18', '2025-05-19 03:59:59', 2),
(45, 19, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-06-05 14:30 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 1, 1, 1, 0, '0 seconds ago', '2025-05-18 13:14:20', '2025-05-18 19:14:20', '2025-05-19 03:59:59', 2),
(46, 19, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400 con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-06-05 14:30', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 13:32:44', '2025-05-18 19:32:44', '2025-05-19 03:59:59', 2),
(47, 19, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400 con el Nut. Alan Antony Puc Yam con estado: Realizado para el día 2025-06-11 10:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 13:35:19', '2025-05-18 19:35:19', '2025-05-19 03:59:59', 2),
(48, 20, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400 con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-06-11 10:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 13:35:19', '2025-05-18 19:35:19', '2025-05-19 03:59:59', 2),
(49, 20, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400 con el Nut. Alan Antony Puc Yam con estado: Próxima consulta para el día 2025-06-17 16:00', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 13:43:09', '2025-05-18 19:43:09', '2025-05-19 03:59:59', 2),
(50, 18, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-06-17 09:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 13:44:50', '2025-05-18 19:44:50', '2025-05-19 03:59:59', 2),
(51, 18, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche con el Nut. Alan Antony Puc Yam con estado: Realizado para el día 2025-06-20 15:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 13:48:05', '2025-05-18 19:48:05', '2025-05-19 03:59:59', 2),
(52, 21, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-06-20 15:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 13:48:05', '2025-05-18 19:48:05', '2025-05-19 03:59:59', 2),
(53, 21, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-06-20 15:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 13:48:58', '2025-05-18 19:48:58', '2025-05-19 03:59:59', 2),
(54, 21, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Clínica NutriBalance Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche, C.P. 24800 con el Nut. Alan Antony Puc Yam con estado: Realizado para el día 2025-05-27 17:00', 'Clínica NutriBalance', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche, C.P. 24800', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 13:50:36', '2025-05-18 19:50:36', '2025-05-19 03:59:59', 2),
(55, 22, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Clínica NutriBalance Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche, C.P. 24800 con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-05-27 17:00', 'Clínica NutriBalance', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche, C.P. 24800', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 13:50:36', '2025-05-18 19:50:36', '2025-05-19 03:59:59', 2),
(56, 22, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Clínica NutriBalance Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche, C.P. 24800 con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-27 17:00', 'Clínica NutriBalance', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche, C.P. 24800', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 13:52:21', '2025-05-18 19:52:21', '2025-05-19 03:59:59', 2),
(57, 22, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Clínica NutriBalance Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche, C.P. 24800 con el Nut. Alan Antony Puc Yam con estado: Realizado para el día 2025-05-27 17:00', 'Clínica NutriBalance', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche, C.P. 24800', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 14:00:07', '2025-05-18 20:00:07', '2025-05-19 03:59:59', 2),
(58, 23, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-06-05 10:35 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 1, 1, 1, 0, '0 seconds ago', '2025-05-18 14:01:04', '2025-05-18 20:01:04', '2025-05-19 03:59:59', 2),
(59, 23, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche, C.P. 24800 con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-06-05 10:35', 'Consultorio Nutricional “Vida y Salud”', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche, C.P. 24800', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 14:01:41', '2025-05-18 20:01:41', '2025-05-19 03:59:59', 2),
(60, 23, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche con el Nut. Alan Antony Puc Yam con estado: Realizado para el día 2025-06-11 11:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 14:02:37', '2025-05-18 20:02:37', '2025-05-19 03:59:59', 2),
(61, 24, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-06-11 11:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 14:02:37', '2025-05-18 20:02:37', '2025-05-19 03:59:59', 2),
(62, 24, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-06-11 11:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 14:03:19', '2025-05-18 20:03:19', '2025-05-19 03:59:59', 2),
(63, 24, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche con el Nut. Alan Antony Puc Yam con estado: Realizado para el día 2025-06-18 12:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 14:03:52', '2025-05-18 20:03:52', '2025-05-19 03:59:59', 2),
(64, 25, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-06-18 12:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 14:03:52', '2025-05-18 20:03:52', '2025-05-19 03:59:59', 2),
(65, 25, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-06-18 12:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 14:08:04', '2025-05-18 20:08:04', '2025-05-19 03:59:59', 2),
(66, 25, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche con el Nut. Alan Antony Puc Yam con estado: Realizado para el día 2025-06-24 12:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 14:08:31', '2025-05-18 20:08:31', '2025-05-19 03:59:59', 2),
(67, 26, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-06-24 12:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 14:08:31', '2025-05-18 20:08:31', '2025-05-19 03:59:59', 2),
(68, 26, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-06-24 12:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 14:10:35', '2025-05-18 20:10:35', '2025-05-19 03:59:59', 2),
(69, 26, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche con el Nut. Alan Antony Puc Yam con estado: Realizado para el día 2025-06-26 12:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 14:11:00', '2025-05-18 20:11:00', '2025-05-19 03:59:59', 2),
(70, 27, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-06-26 12:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 14:11:00', '2025-05-18 20:11:00', '2025-05-19 03:59:59', 2),
(71, 27, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-06-26 12:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 14:11:17', '2025-05-18 20:11:17', '2025-05-19 03:59:59', 2),
(72, 27, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche con el Nut. Alan Antony Puc Yam con estado: Realizado para el día 2025-07-01 09:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 14:11:48', '2025-05-18 20:11:48', '2025-05-19 03:59:59', 2),
(73, 28, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-07-01 09:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 14:11:48', '2025-05-18 20:11:48', '2025-05-19 03:59:59', 2),
(74, 28, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-07-01 09:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 14:12:14', '2025-05-18 20:12:14', '2025-05-19 03:59:59', 2),
(75, 28, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche con el Nut. Alan Antony Puc Yam con estado: Realizado para el día 2025-07-09 12:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 14:12:31', '2025-05-18 20:12:31', '2025-05-19 03:59:59', 2),
(76, 29, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche con el Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-07-09 12:00', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 14:12:31', '2025-05-18 20:12:31', '2025-05-19 03:59:59', 2),
(77, 29, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-07-09 12:00 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 14:12:49', '2025-05-18 20:12:49', '2025-05-19 03:59:59', 2),
(78, 30, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-20 10:30 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 14:22:38', '2025-05-18 20:22:38', '2025-05-19 03:59:59', 2),
(79, 30, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Centro Integral NutriVida asf con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-20 10:30', 'Centro Integral NutriVida', 'asf', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 14:23:26', '2025-05-18 20:23:26', '2025-05-23 02:20:18', 2),
(80, 31, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-21 10:30 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 14:37:54', '2025-05-18 20:37:54', '2025-05-19 03:59:59', 2),
(81, 31, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Consultorio Nutricional “Vida y Salud” Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-21 10:30', 'Consultorio Nutricional “Vida y Salud”', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 15:03:26', '2025-05-18 21:03:26', '2025-05-19 03:59:59', 2),
(82, 32, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-21 11:25 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 15:03:59', '2025-05-18 21:03:59', '2025-05-19 03:59:59', 2),
(83, 32, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-21 11:25 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 's', 's', 'Alan Antony Puc Yam', 0, 1, 1, 0, '0 seconds ago', '2025-05-18 15:08:06', '2025-05-18 21:08:06', '2025-05-19 03:59:59', 2),
(84, 33, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-27 10:50 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 1, 1, 1, 1, '0 seconds ago', '2025-05-18 15:08:43', '2025-05-18 21:08:43', '2025-05-20 13:58:17', 2),
(85, 34, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-21 09:20 con el Nut. Regina Caceres Estrada (Estado: En espera)', NULL, NULL, 'Regina Caceres Estrada', 1, 1, 1, 1, '0 seconds ago', '2025-05-19 11:52:38', '2025-05-19 17:52:38', '2025-05-19 17:54:12', 11),
(86, 34, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-21 09:20 con el Nut. Regina Caceres Estrada ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'f', 'f', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-19 11:54:00', '2025-05-19 17:54:00', '2025-05-19 17:54:14', 11),
(87, 35, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-21 09:30 con el Nut. Regina Caceres Estrada (Estado: En espera)', NULL, NULL, 'Regina Caceres Estrada', 1, 1, 1, 1, '0 seconds ago', '2025-05-19 12:03:39', '2025-05-19 18:03:39', '2025-05-19 18:06:33', 11),
(88, 35, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-21 09:30 con el Nut. Regina Caceres Estrada ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', '2', '2', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-19 12:06:30', '2025-05-19 18:06:30', '2025-05-19 18:06:34', 11),
(89, 36, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-20 08:45 con el Nut. Regina Caceres Estrada (Estado: En espera)', NULL, NULL, 'Regina Caceres Estrada', 1, 1, 1, 1, '0 seconds ago', '2025-05-19 12:07:30', '2025-05-19 18:07:30', '2025-05-19 18:10:21', 11),
(90, 36, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-20 08:45 con el Nut. Regina Caceres Estrada ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'f', 'f', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-19 12:10:16', '2025-05-19 18:10:16', '2025-05-19 18:10:22', 11),
(91, 37, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-21 09:00 con el Nut. Regina Caceres Estrada (Estado: En espera)', NULL, NULL, 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 07:54:44', '2025-05-20 13:54:44', '2025-05-20 14:44:04', 11),
(92, 33, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en 2 2 con el Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-27 10:50', '2', '2', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 07:58:03', '2025-05-20 13:58:03', '2025-05-20 14:53:15', 2),
(93, 37, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en 2 2 con el Nut. Regina Caceres Estrada con estado: En progreso para el día 2025-05-21 09:00', '2', '2', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 07:59:53', '2025-05-20 13:59:53', '2025-05-20 14:40:26', 11),
(94, 38, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-21 10:00 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 08:02:45', '2025-05-20 14:02:45', '2025-05-20 14:53:48', 2),
(95, 37, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en 2 2 con el Nut. Regina Caceres Estrada con estado: Realizado para el día 2025-05-21 12:00', '2', '2', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 08:09:41', '2025-05-20 14:09:41', '2025-05-20 14:40:24', 11),
(96, 39, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en 2 2 con el Nut. Regina Caceres Estrada con estado: En espera para el día 2025-05-21 12:00', '2', '2', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 08:09:41', '2025-05-20 14:09:41', '2025-05-20 14:44:33', 11),
(97, 40, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-21 09:00 con el Nut. Regina Caceres Estrada (Estado: En espera)', NULL, NULL, 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 08:10:12', '2025-05-20 14:10:12', '2025-05-20 14:44:23', 11),
(98, 41, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-21 11:24 con el Nut. Regina Caceres Estrada (Estado: En espera)', NULL, NULL, 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 08:21:14', '2025-05-20 14:21:14', '2025-05-20 14:44:39', 11),
(99, 40, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en 2 2 con el Nut. Regina Caceres Estrada con estado: En progreso para el día 2025-05-21 09:00', '2', '2', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 08:31:55', '2025-05-20 14:31:55', '2025-05-20 14:44:20', 11),
(100, 42, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-22 10:00 con el Nut. Regina Caceres Estrada (Estado: En espera)', NULL, NULL, 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 08:36:17', '2025-05-20 14:36:17', '2025-05-20 14:44:26', 11),
(101, 43, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-23 10:48 con el Nut. Regina Caceres Estrada (Estado: En espera)', NULL, NULL, 'Regina Caceres Estrada', 1, 1, 1, 1, '0 seconds ago', '2025-05-20 08:39:52', '2025-05-20 14:39:52', '2025-05-20 14:44:30', 11),
(102, 40, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-21 09:00 con el Nut. Regina Caceres Estrada ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', '2', '2', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 08:42:30', '2025-05-20 14:42:30', '2025-05-20 14:44:17', 11),
(103, 41, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-21 11:24 con el Nut. Regina Caceres Estrada ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', '2', '2', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 08:42:44', '2025-05-20 14:42:44', '2025-05-20 14:44:35', 11),
(104, 39, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-21 12:00 con el Nut. Regina Caceres Estrada ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', '2', '2', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 08:42:55', '2025-05-20 14:42:55', '2025-05-20 14:44:14', 11),
(105, 42, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-22 10:00 con el Nut. Regina Caceres Estrada ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', '2', '2', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 08:43:09', '2025-05-20 14:43:09', '2025-05-20 14:44:05', 11),
(106, 43, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-23 10:48 con el Nut. Regina Caceres Estrada ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', '2', '2', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 08:43:17', '2025-05-20 14:43:17', '2025-05-20 14:44:09', 11),
(107, 44, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-22 09:00 con el Nut. Regina Caceres Estrada (Estado: En espera)', NULL, NULL, 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 08:44:56', '2025-05-20 14:44:56', '2025-05-20 14:53:40', 11),
(108, 45, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-20 10:00 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 08:52:57', '2025-05-20 14:52:57', '2025-05-20 14:52:57', 2),
(109, 46, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-22 10:00 con el Nut. Regina Caceres Estrada (Estado: En espera)', NULL, NULL, 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 09:04:26', '2025-05-20 15:04:26', '2025-05-20 15:14:34', 11),
(110, 44, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en 2 2 con Nut. Regina Caceres Estrada con estado: En progreso para el día 2025-05-22 09:00', '2', '2', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 09:14:13', '2025-05-20 15:14:13', '2025-05-20 15:14:13', 11),
(111, 46, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en 2 Calle 14#97A con Nut. Regina Caceres Estrada con estado: En progreso para el día 2025-05-22 10:00', '2', 'Calle 14#97A', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 09:30:05', '2025-05-20 15:30:05', '2025-05-20 15:30:05', 11),
(112, 46, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-22 10:00 con el Nut. Regina Caceres Estrada ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', '2', 'Calle 14#97A', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 09:32:01', '2025-05-20 15:32:01', '2025-05-20 15:46:33', 11),
(113, 47, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-21 10:24 con el Nut. Regina Caceres Estrada (Estado: En espera)', NULL, NULL, 'Regina Caceres Estrada', 1, 1, 1, 1, '0 seconds ago', '2025-05-20 09:46:50', '2025-05-20 15:46:50', '2025-05-20 17:01:58', 11),
(114, 48, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-20 09:00 con el Nut. Regina Caceres Estrada (Estado: En espera)', NULL, NULL, 'Regina Caceres Estrada', 1, 1, 1, 1, '0 seconds ago', '2025-05-20 09:50:33', '2025-05-20 15:50:33', '2025-05-20 16:13:47', 11),
(115, 49, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-21 09:00 con el Nut. Regina Caceres Estrada (Estado: En espera)', NULL, NULL, 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 09:55:50', '2025-05-20 15:55:50', '2025-05-20 16:07:05', 11),
(116, 50, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-21 12:00 con el Nut. Regina Caceres Estrada (Estado: En espera)', NULL, NULL, 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 10:00:01', '2025-05-20 16:00:01', '2025-05-20 16:08:46', 11),
(117, 49, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-21 09:00 con el Nut. Regina Caceres Estrada ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'f', 'f', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 10:05:31', '2025-05-20 16:05:31', '2025-05-20 16:06:38', 11),
(118, 50, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en 5 5 con Nut. Regina Caceres Estrada con estado: Realizado para el día 2025-05-21 12:00', '5', '5', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 10:08:27', '2025-05-20 16:08:27', '2025-05-20 16:08:39', 11),
(119, 48, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en 55 55 con Nut. Regina Caceres Estrada con estado: En progreso para el día 2025-05-20 09:00', '55', '55', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 10:11:59', '2025-05-20 16:11:59', '2025-05-20 16:13:42', 11),
(120, 47, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en 22 22 con Nut. Regina Caceres Estrada con estado: En progreso para el día 2025-05-21 10:24', '22', '22', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 10:12:39', '2025-05-20 16:12:39', '2025-05-20 17:00:20', 11),
(121, 48, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en 55 55 con Nut. Regina Caceres Estrada con estado: Realizado para el día 2025-05-22 12:00', '55', '55', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 10:13:23', '2025-05-20 16:13:23', '2025-05-20 16:13:26', 11),
(122, 51, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en 55 55 con Nut. Regina Caceres Estrada con estado: En espera para el día 2025-05-22 12:00', '55', '55', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 10:13:23', '2025-05-20 16:13:23', '2025-05-20 17:00:08', 11),
(123, 47, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-21 10:24 con el Nut. Regina Caceres Estrada ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', '22', '22', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 10:59:40', '2025-05-20 16:59:40', '2025-05-20 17:00:14', 11),
(124, 51, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en 55 55 con Nut. Regina Caceres Estrada con estado: Realizado para el día 2025-05-22 12:00', '55', '55', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 10:59:55', '2025-05-20 16:59:55', '2025-05-20 16:59:59', 11);
INSERT INTO `notificaciones` (`Notificacion_ID`, `Reservacion_ID`, `Chat_ID`, `Paciente_ID`, `Consulta_ID`, `tipo_notificacion`, `nombre`, `apellidos`, `foto`, `descripcion_mensaje`, `nombre_consultorio`, `direccion_consultorio`, `nombre_nutriologo`, `status`, `status_movil`, `estado`, `estado_movil`, `tiempo_transcurrido`, `fecha_creacion`, `created_at`, `updated_at`, `user_id`) VALUES
(125, 52, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-22 10:20 con el Nut. Regina Caceres Estrada (Estado: En espera)', NULL, NULL, 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 11:00:52', '2025-05-20 17:00:52', '2025-05-22 09:55:13', 11),
(126, 52, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Clínica NutriBalance Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche con Nut. Regina Caceres Estrada con estado: En progreso para el día 2025-05-22 10:20', 'Clínica NutriBalance', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-20 11:03:33', '2025-05-20 17:03:33', '2025-05-22 09:54:59', 11),
(127, 53, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-23 13:30 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 01:47:24', '2025-05-22 07:47:24', '2025-05-22 09:55:23', 2),
(128, 52, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Clínica NutriBalance Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche con Nut. Regina Caceres Estrada con estado: Realizado para el día 2025-05-26 15:00', 'Clínica NutriBalance', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 03:54:47', '2025-05-22 09:54:47', '2025-05-22 09:54:50', 11),
(129, 54, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Clínica NutriBalance Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche con Nut. Regina Caceres Estrada con estado: En espera para el día 2025-05-26 15:00', 'Clínica NutriBalance', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche', 'Regina Caceres Estrada', 0, 0, 1, 1, '0 seconds ago', '2025-05-22 03:54:47', '2025-05-22 09:54:47', '2025-05-22 09:54:47', 11),
(130, 55, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-06-05 10:10 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 1, 1, 1, 1, '0 seconds ago', '2025-05-22 19:01:41', '2025-05-23 01:01:41', '2025-05-23 01:21:39', 2),
(131, 55, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-06-05 10:10 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'cancelado', 'cancelado', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 19:21:29', '2025-05-23 01:21:29', '2025-05-23 01:21:45', 2),
(132, 56, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-06-05 10:10 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 1, 1, 1, 1, '0 seconds ago', '2025-05-22 19:22:23', '2025-05-23 01:22:23', '2025-05-23 01:32:04', 2),
(133, 56, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-06-05 10:10 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', '12', 'fas', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 19:31:57', '2025-05-23 01:31:57', '2025-05-23 01:32:05', 2),
(134, 57, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-06-05 11:11 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 1, 1, 1, 1, '0 seconds ago', '2025-05-22 19:32:26', '2025-05-23 01:32:26', '2025-05-23 01:35:27', 2),
(135, 57, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-06-05 11:11 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', '12', 'fas', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 19:35:22', '2025-05-23 01:35:22', '2025-05-23 01:35:27', 2),
(136, 58, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-06-05 09:50 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 1, 1, 1, 1, '0 seconds ago', '2025-05-22 19:36:28', '2025-05-23 01:36:28', '2025-05-23 01:37:30', 2),
(137, 58, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-06-05 09:50 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'f', 'f', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 19:37:22', '2025-05-23 01:37:22', '2025-05-23 01:37:31', 2),
(138, 59, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-29 11:55 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 1, 1, 1, 1, '0 seconds ago', '2025-05-22 19:37:58', '2025-05-23 01:37:58', '2025-05-23 01:40:20', 2),
(139, 59, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-29 11:55 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'f', 'f', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 19:39:43', '2025-05-23 01:39:43', '2025-05-23 01:40:21', 2),
(140, 60, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-29 11:55 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 19:40:05', '2025-05-23 01:40:05', '2025-05-23 02:20:19', 2),
(141, 30, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-20 10:30 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'Centro Integral NutriVida', 'asf', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 19:58:48', '2025-05-23 01:58:48', '2025-05-23 02:20:34', 2),
(142, 31, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-21 10:30 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'Consultorio Nutricional “Vida y Salud”', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 19:58:57', '2025-05-23 01:58:57', '2025-05-23 02:20:32', 2),
(143, 45, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-20 10:00 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'f', 'f', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 19:59:16', '2025-05-23 01:59:16', '2025-05-23 02:20:47', 2),
(144, 38, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-21 10:00 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'f', 'f', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 19:59:26', '2025-05-23 01:59:26', '2025-05-23 02:20:44', 2),
(145, 13, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-23 12:00 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'Clínica NutriBalance', '15', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 19:59:38', '2025-05-23 01:59:38', '2025-05-23 02:20:36', 2),
(146, 60, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en f f con Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-05-29 11:55', 'f', 'f', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 19:59:58', '2025-05-23 01:59:58', '2025-05-23 02:20:19', 2),
(147, 53, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-23 13:30 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'f', 'f', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 20:00:10', '2025-05-23 02:00:10', '2025-05-23 02:20:30', 2),
(148, 33, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-27 10:50 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', '2', '2', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 20:00:23', '2025-05-23 02:00:23', '2025-05-23 02:20:42', 2),
(149, 9, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-06-02 12:00 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 20:00:31', '2025-05-23 02:00:31', '2025-05-23 02:20:28', 2),
(150, 60, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-29 11:55 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'f', 'f', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 20:00:41', '2025-05-23 02:00:41', '2025-05-23 02:20:21', 2),
(151, 15, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-06-04 15:00 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'Centro Integral NutriVida', '2', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 20:00:51', '2025-05-23 02:00:51', '2025-05-23 02:20:20', 2),
(152, 6, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-30 16:00 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 20:00:59', '2025-05-23 02:00:59', '2025-05-23 02:20:19', 2),
(153, 54, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Clínica NutriBalance Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche con Nut. Regina Caceres Estrada con estado: En progreso para el día 2025-05-26 15:00', 'Clínica NutriBalance', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche', 'Regina Caceres Estrada', 0, 0, 1, 1, '0 seconds ago', '2025-05-22 23:06:17', '2025-05-23 05:06:17', '2025-05-23 05:06:17', 11),
(154, 61, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-22 18:30 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 23:10:36', '2025-05-23 05:10:36', '2025-05-23 05:18:52', 2),
(155, 62, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-23 10:30 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 1, 1, 1, 1, '0 seconds ago', '2025-05-22 23:12:35', '2025-05-23 05:12:35', '2025-05-23 05:18:46', 2),
(156, 61, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-22 18:30 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'cancelado', 'cancelado', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 23:19:19', '2025-05-23 05:19:19', '2025-05-23 05:19:54', 2),
(157, 62, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-23 10:30 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'cancelado', 'cancelado', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 23:19:29', '2025-05-23 05:19:29', '2025-05-23 05:19:50', 2),
(158, 63, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-23 11:35 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 23:23:14', '2025-05-23 05:23:14', '2025-05-23 05:32:49', 2),
(159, 64, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-23 11:50 con el Nut. Regina Caceres Estrada (Estado: En espera)', NULL, NULL, 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 23:24:40', '2025-05-23 05:24:40', '2025-05-23 05:29:01', 11),
(160, 64, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-23 11:50 con el Nut. Regina Caceres Estrada ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'cac', 'cac', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 23:28:46', '2025-05-23 05:28:46', '2025-05-23 05:28:57', 11),
(161, 63, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-23 11:35 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'cancelado', '2', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 23:30:10', '2025-05-23 05:30:10', '2025-05-23 05:32:51', 2),
(162, 65, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-22 10:30 con el Nut. Regina Caceres Estrada (Estado: En espera)', NULL, NULL, 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 23:31:16', '2025-05-23 05:31:16', '2025-05-23 05:48:14', 11),
(163, 66, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-24 09:00 con el Nut. Regina Caceres Estrada (Estado: En espera)', NULL, NULL, 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 23:41:39', '2025-05-23 05:41:39', '2025-05-23 05:48:16', 11),
(164, 67, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-26 11:30 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 23:42:21', '2025-05-23 05:42:21', '2025-05-23 05:48:18', 2),
(165, 65, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-22 10:30 con el Nut. Regina Caceres Estrada ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', '5', '5', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 23:48:42', '2025-05-23 05:48:42', '2025-05-23 05:49:38', 11),
(166, 66, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-24 09:00 con el Nut. Regina Caceres Estrada ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'f', 'f', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 23:48:53', '2025-05-23 05:48:53', '2025-05-23 05:49:34', 11),
(167, 67, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-26 11:30 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'cancelado', 'f', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 23:49:16', '2025-05-23 05:49:16', '2025-05-23 05:49:30', 2),
(168, 68, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-23 10:50 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 23:51:05', '2025-05-23 05:51:05', '2025-05-23 06:17:38', 2),
(169, 69, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-26 10:45 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-22 23:51:58', '2025-05-23 05:51:58', '2025-05-23 06:17:38', 2),
(170, 68, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-23 10:50 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'f', 'ff', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-23 00:17:19', '2025-05-23 06:17:19', '2025-05-23 06:17:46', 2),
(171, 69, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-26 10:45 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'f', 'f', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-23 00:17:31', '2025-05-23 06:17:31', '2025-05-23 06:17:40', 2),
(172, 70, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-23 10:20 con el Nut. Regina Caceres Estrada (Estado: En espera)', NULL, NULL, 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-23 00:27:49', '2025-05-23 06:27:49', '2025-05-23 07:13:50', 11),
(173, 71, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-23 10:20 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-23 00:36:12', '2025-05-23 06:36:12', '2025-05-26 19:19:03', 2),
(174, 70, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Clínica NutriBalance Calle 14#97A con Nut. Regina Caceres Estrada con estado: En progreso para el día 2025-05-23 10:20', 'Clínica NutriBalance', 'Calle 14#97A', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-23 01:06:22', '2025-05-23 07:06:22', '2025-05-23 07:13:42', 11),
(175, 70, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Clínica NutriVida Activa Calle 25 #204 x 30 y 32, Barrio San Luis, Calkiní, Campeche con Nut. Regina Caceres Estrada con estado: Realizado para el día 2025-06-13 11:30', 'Clínica NutriVida Activa', 'Calle 25 #204 x 30 y 32, Barrio San Luis, Calkiní, Campeche', 'Regina Caceres Estrada', 0, 1, 1, 1, '0 seconds ago', '2025-05-23 01:13:15', '2025-05-23 07:13:15', '2025-05-23 07:13:33', 11),
(176, 72, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Clínica NutriVida Activa Calle 25 #204 x 30 y 32, Barrio San Luis, Calkiní, Campeche con Nut. Regina Caceres Estrada con estado: En espera para el día 2025-06-13 11:30', 'Clínica NutriVida Activa', 'Calle 25 #204 x 30 y 32, Barrio San Luis, Calkiní, Campeche', 'Regina Caceres Estrada', 0, 0, 1, 1, '0 seconds ago', '2025-05-23 01:13:15', '2025-05-23 07:13:15', '2025-05-23 07:13:15', 11),
(177, 73, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-29 10:10 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 1, 1, 1, 1, '0 seconds ago', '2025-05-23 12:42:35', '2025-05-23 18:42:35', '2025-05-23 18:46:15', 2),
(178, 73, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en VitalBalance Calkiní Calle 18 #255, entre 15 y 17, Centro, Calkiní, Campeche con Nut. Alan Antony Puc Yam con estado: En progreso para el día 2025-05-29 10:10', 'VitalBalance Calkiní', 'Calle 18 #255, entre 15 y 17, Centro, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-23 12:46:03', '2025-05-23 18:46:03', '2025-05-23 18:57:41', 2),
(179, 73, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en VitalBalance Calkiní Calle 18 #255, entre 15 y 17, Centro, Calkiní, Campeche con Nut. Alan Antony Puc Yam con estado: Realizado para el día 2025-06-12 10:00', 'VitalBalance Calkiní', 'Calle 18 #255, entre 15 y 17, Centro, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-23 12:57:25', '2025-05-23 18:57:25', '2025-05-23 18:57:32', 2),
(180, 74, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en VitalBalance Calkiní Calle 18 #255, entre 15 y 17, Centro, Calkiní, Campeche con Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-06-12 10:00', 'VitalBalance Calkiní', 'Calle 18 #255, entre 15 y 17, Centro, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-23 12:57:25', '2025-05-23 18:57:25', '2025-05-27 16:38:11', 2),
(181, 72, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Clínica NutriVida Activa Calle 25 #204 x 30 y 32, Barrio San Luis, Calkiní, Campeche con Nut. Regina Caceres Estrada con estado: En progreso para el día 2025-06-13 11:30', 'Clínica NutriVida Activa', 'Calle 25 #204 x 30 y 32, Barrio San Luis, Calkiní, Campeche', 'Regina Caceres Estrada', 0, 0, 1, 1, '0 seconds ago', '2025-05-26 13:13:07', '2025-05-26 19:13:07', '2025-05-26 19:13:07', 11),
(182, 72, NULL, 25, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en Clínica NutriVida Activa Calle 25 #204 x 30 y 32, Barrio San Luis, Calkiní, Campeche con Nut. Regina Caceres Estrada con estado: En espera para el día 2025-06-13 11:30', 'Clínica NutriVida Activa', 'Calle 25 #204 x 30 y 32, Barrio San Luis, Calkiní, Campeche', 'Regina Caceres Estrada', 0, 0, 1, 1, '0 seconds ago', '2025-05-26 13:13:42', '2025-05-26 19:13:42', '2025-05-26 19:13:42', 11),
(183, 75, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-05-28 12:00 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 1, 1, 1, 1, '0 seconds ago', '2025-05-26 13:17:17', '2025-05-26 19:17:17', '2025-05-26 19:19:02', 2),
(184, 75, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-28 12:00 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'cancelado', 'f', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-26 13:18:42', '2025-05-26 19:18:42', '2025-05-26 19:19:07', 2),
(185, 71, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-05-23 10:20 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'cancelado', 'cancelado', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-26 13:18:54', '2025-05-26 19:18:54', '2025-05-26 19:19:04', 2),
(186, 74, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Tu cita ha sido actualizada en VitalBalance Calkiní Calle 18 #255, entre 15 y 17, Centro, Calkiní, Campeche con Nut. Alan Antony Puc Yam con estado: En espera para el día 2025-06-12 10:00', 'VitalBalance Calkiní', 'Calle 18 #255, entre 15 y 17, Centro, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-27 10:37:48', '2025-05-27 16:37:48', '2025-05-27 16:41:27', 2),
(187, 74, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Lamentamos informarle que su cita programada para el 2025-06-12 10:00 con el Nut. Alan Antony Puc Yam ha sido cancelada. Para reagendar, puede contactarnos o seleccionar otro horario disponible en nuestro sistema. Agradecemos su comprensión.', 'VitalBalance Calkiní', 'Calle 18 #255, entre 15 y 17, Centro, Calkiní, Campeche', 'Alan Antony Puc Yam', 0, 1, 1, 1, '0 seconds ago', '2025-05-27 10:41:10', '2025-05-27 16:41:10', '2025-05-27 16:41:28', 2),
(188, 76, NULL, 15, NULL, 1, 'Isabel', 'Cuevas', NULL, 'Nueva cita programada para   el día 2025-06-03 11:30 con el Nut. Alan Antony Puc Yam (Estado: En espera)', NULL, NULL, 'Alan Antony Puc Yam', 0, 0, 1, 1, '0 seconds ago', '2025-05-27 10:47:04', '2025-05-27 16:47:04', '2025-05-27 16:47:04', 2);

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
-- Estructura de tabla para la tabla `nutridesafios`
--

CREATE TABLE `nutridesafios` (
  `NutriDesafios_ID` int(10) UNSIGNED NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` date DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `nutridesafios`
--

INSERT INTO `nutridesafios` (`NutriDesafios_ID`, `foto`, `nombre`, `url`, `tipo`, `status`, `estado`, `fecha_creacion`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 'http://127.0.0.1:8000/storage/nutridesafios/1748115526_nutrimemoria.png', 'NutriMemoria', 'https://puzzel.org/es/memory/play?p=-OLSVCp9We7cscOnap4e', 'Memoramas', 1, 1, '2025-05-24', 2, '2025-05-25 01:10:38', '2025-05-25 01:38:46'),
(3, 'http://127.0.0.1:8000/storage/nutridesafios/1748115571_nutriletras.png', 'NutriLetras', 'https://puzzel.org/es/wordseeker/play?p=-OLSUKa0w4shWco4kj0E', 'Sopa De Letras', 1, 1, '2025-05-24', 2, '2025-05-25 01:39:31', '2025-05-25 01:39:31'),
(4, 'http://127.0.0.1:8000/storage/nutridesafios/1748116232_crucifit.png', 'Crucifit', 'https://puzzel.org/es/wordseeker/play?p=-OLSUKa0w4shWco4kj0E', 'Crucigrama', 2, 1, '2025-05-24', 2, '2025-05-25 01:50:32', '2025-05-25 01:50:32');

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
(15, 'http://192.168.50.221:8000/storage/pacientes/1748234655_isabel.jpg', 'Isabel', 'Cuevas', 'monsecuevas@gmail.com', '9961025846', 'Femenino', 'monsee', 2, 2, 'Artritis', 1, 1, 'Calkini', 'Campeche', 22, '2003-04-16', '2025-05-14', '2025-05-14 17:22:14', '2025-05-26 10:44:15'),
(16, 'http://192.168.50.221:8000/storage/pacientes/1747278798_paula.jpg', 'Paula', 'Tuz Tuz', 'pautuztuz@gmail.com', '9993340566', 'Femenino', 'PauTuz', 2, 2, 'ninguna', 1, 1, 'Pomuch', 'Hecelchakan', 20, '2004-07-27', '2025-05-14', '2025-05-15 09:12:53', '2025-05-15 09:13:18'),
(25, 'http://192.168.50.221:8000/storage/pacientes/1748234655_isabel.jpg', 'Isabel', 'Cuevas', 'monsecuevas@gmail.com', '9961025846_nut11', 'Femenino', 'monsee_nut11', 2, 11, 'Artritis', 1, 1, 'Calkini', 'Campeche', 22, '2003-04-16', '2025-05-14', '2025-05-19 18:59:02', '2025-05-19 18:59:02'),
(30, 'http://192.168.50.221:8000/storage/pacientes/1747278798_paula.jpg', 'Paula', 'Tuz Tuz', 'pautuztuz@gmail.com', '9993340566_nut11', 'Femenino', 'PauTuz_nut11', 2, 11, 'ninguna', 1, 1, 'Pomuch', 'Hecelchakan', 20, '2004-07-27', '2025-05-14', '2025-05-20 12:26:30', '2025-05-20 12:26:30'),
(31, 'http://127.0.0.1:8000/storage/pacientes/1746409781_alcrya.png', 'Alcrya', 'Lumina', 'LyrcaLumina@gmail.com', '9961025841_nut11', 'Femenino', 'Alcrya Lumina_nut11', 2, 11, 'Disformia,Hipertensión', 1, 1, 'Merida', 'Yucatán', 20, '2002-12-12', '2025-05-05', '2025-05-20 12:42:05', '2025-05-20 12:42:05');

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
(1, NULL, 15, 4, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'Acudo a consulta porque me diagnosticaron gastritis crónica y he tenido molestias frecuentes como dolor estomacal, acidez y sensación de llenura. Me gustaría saber qué tipo de alimentación debo seguir para mejorar mi digestión y evitar que los síntomas empeoren.', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', '2025-05-19 10:20:54', '2025-05-28 15:00:00', 0, 'web', '2025-05-18 08:30:53', '2025-05-18 12:32:27', 2),
(2, NULL, 15, 7, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 585.00, 'sjjssjjsjss', '121221', 'asfasf', 'Alan Antony Puc Yam', '2025-05-19 09:50:05', '2025-05-27 11:00:00', 0, 'web', '2025-05-18 12:34:04', '2025-05-18 12:35:15', 2),
(3, NULL, 15, 10, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 585.00, 'Seguimiento: sjjssjjsjss', '121221', 'asfasfss', 'Alan Antony Puc Yam', '2025-05-27 11:00:00', '2025-05-30 12:00:00', 0, 'web', '2025-05-18 12:35:15', '2025-05-18 12:50:11', 2),
(4, NULL, 15, 12, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 585.00, 'Seguimiento: Seguimiento: sjjssjjsjss', '121221', 'asfasfss', 'Alan Antony Puc Yam', '2025-05-30 12:00:00', NULL, 0, 'web', '2025-05-18 12:50:11', '2025-05-18 12:52:31', 2),
(5, NULL, 15, 15, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 292.00, 'ajjajajaja', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', '2025-05-21 12:25:36', '2025-05-30 16:00:00', 0, 'web', '2025-05-18 13:04:36', '2025-05-18 13:08:44', 2),
(6, NULL, 15, 152, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 292.00, 'Seguimiento: ajjajajaja', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', '2025-05-30 16:00:00', NULL, 0, 'web', '2025-05-18 13:08:44', '2025-05-23 02:00:59', 2),
(7, NULL, 15, 19, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'gkfkgnggng', 'pp', 'safasf', 'Alan Antony Puc Yam', '2025-05-20 10:50:02', '2025-05-29 12:00:00', 0, 'web', '2025-05-18 13:11:01', '2025-05-18 14:15:38', 2),
(8, NULL, 15, 22, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'Seguimiento: gkfkgnggng', 'pp', 'safasf', 'Alan Antony Puc Yam', '2025-05-29 12:00:00', '2025-06-02 12:00:00', 0, 'web', '2025-05-18 14:15:38', '2025-05-18 14:24:16', 2),
(9, NULL, 15, 149, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'Seguimiento: Seguimiento: gkfkgnggng', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', '2025-06-02 12:00:00', NULL, 0, 'web', '2025-05-18 14:24:16', '2025-05-23 02:00:31', 2),
(10, NULL, 15, 26, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 292.00, 'jsjsjsjsjsjs', 'Consultorio Nutricional “Vida y Salud”', '45454545', 'Alan Antony Puc Yam', '2025-05-22 10:25:00', '2025-06-04 10:00:00', 0, 'web', '2025-05-18 14:33:00', '2025-05-18 14:34:51', 2),
(11, NULL, 15, 40, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 292.00, 'Seguimiento: jsjsjsjsjsjs', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', '2025-06-04 10:00:00', '2025-06-10 17:00:00', 0, 'web', '2025-05-18 14:34:51', '2025-05-18 19:01:39', 2),
(12, NULL, 15, 30, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 585.00, 'suaja', 'Clínica NutriBalance', '15', 'Alan Antony Puc Yam', '2025-05-24 12:20:30', '2025-05-23 12:00:00', 0, 'web', '2025-05-18 14:53:29', '2025-05-18 14:55:43', 2),
(13, NULL, 15, 145, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 585.00, 'Seguimiento: suaja', 'Clínica NutriBalance', '15', 'Alan Antony Puc Yam', '2025-05-23 12:00:00', NULL, 0, 'web', '2025-05-18 14:55:43', '2025-05-23 01:59:38', 2),
(14, NULL, 15, 34, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'ahshsjja', 'Centro Integral NutriVida', '2', 'Alan Antony Puc Yam', '2025-05-21 10:24:29', '2025-06-04 15:00:00', 0, 'web', '2025-05-18 14:58:28', '2025-05-18 18:53:41', 2),
(15, NULL, 15, 151, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'Seguimiento: ahshsjja', 'Centro Integral NutriVida', '2', 'Alan Antony Puc Yam', '2025-06-04 15:00:00', NULL, 0, 'web', '2025-05-18 18:53:41', '2025-05-23 02:00:51', 2),
(16, NULL, 15, 38, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'dvdbdd', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', '2025-05-22 10:40:03', NULL, 0, 'web', '2025-05-18 18:56:01', '2025-05-18 18:56:47', 2),
(17, NULL, 15, 43, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 292.00, 'Seguimiento: Seguimiento: jsjsjsjsjsjs', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', '2025-06-10 17:00:00', '2025-06-17 09:00:00', 0, 'web', '2025-05-18 19:01:39', '2025-05-18 19:03:18', 2),
(18, NULL, 15, 51, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 292.00, 'Seguimiento: Seguimiento: Seguimiento: jsjsjsjsjsjs', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', '2025-06-17 09:00:00', '2025-06-20 15:00:00', 0, 'web', '2025-05-18 19:03:18', '2025-05-18 19:48:05', 2),
(19, NULL, 15, 47, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'ajakaja', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', '2025-06-05 14:30:22', '2025-06-11 10:00:00', 0, 'web', '2025-05-18 19:14:20', '2025-05-18 19:35:19', 2),
(20, NULL, 15, 49, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'Seguimiento: ajakaja', 'Consultorio Nutricional “Vida y Salud”', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche, C.P. 24400', 'Alan Antony Puc Yam', '2025-06-11 10:00:00', '2025-06-17 16:00:00', 0, 'web', '2025-05-18 19:35:19', '2025-05-18 19:43:09', 2),
(21, NULL, 15, 54, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 292.00, 'Seguimiento: Seguimiento: Seguimiento: Seguimiento: jsjsjsjsjsjs', 'Clínica NutriBalance', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche, C.P. 24800', 'Alan Antony Puc Yam', '2025-06-20 15:00:00', '2025-05-27 17:00:00', 0, 'web', '2025-05-18 19:48:05', '2025-05-18 19:50:36', 2),
(22, NULL, 15, 57, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 292.00, 'Seguimiento: Seguimiento: Seguimiento: Seguimiento: Seguimiento: jsjsjsjsjsjs', 'Clínica NutriBalance', 'Calle 20 #158 por 25 y 27, Col. Centro, Hecelchakán, Campeche, C.P. 24800', 'Alan Antony Puc Yam', '2025-05-27 17:00:00', NULL, 0, 'web', '2025-05-18 19:50:36', '2025-05-18 20:00:07', 2),
(23, NULL, 15, 60, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'fmmfkdld', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', '2025-06-05 10:35:05', '2025-06-11 11:00:00', 0, 'web', '2025-05-18 20:01:03', '2025-05-18 20:02:37', 2),
(24, NULL, 15, 63, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'fmmfkdld', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', '2025-06-11 11:00:00', '2025-06-18 12:00:00', 0, 'web', '2025-05-18 20:02:37', '2025-05-18 20:03:52', 2),
(25, NULL, 15, 66, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'fmmfkdld', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', '2025-06-18 12:00:00', '2025-06-24 12:00:00', 0, 'web', '2025-05-18 20:03:52', '2025-05-18 20:08:31', 2),
(26, NULL, 15, 69, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'fmmfkdld', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', '2025-06-24 12:00:00', '2025-06-26 12:00:00', 0, 'web', '2025-05-18 20:08:31', '2025-05-18 20:11:00', 2),
(27, NULL, 15, 72, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'Seguimiento: fmmfkdld', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', '2025-06-26 12:00:00', '2025-07-01 09:00:00', 0, 'web', '2025-05-18 20:11:00', '2025-05-18 20:11:48', 2),
(28, NULL, 15, 75, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'Seguimiento: fmmfkdld', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', '2025-07-01 09:00:00', '2025-07-09 12:00:00', 0, 'web', '2025-05-18 20:11:48', '2025-05-18 20:12:31', 2),
(29, NULL, 15, 77, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'Seguimiento: fmmfkdld', 'Centro Integral NutriVida', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', '2025-07-09 12:00:00', NULL, 0, 'web', '2025-05-18 20:12:31', '2025-05-18 20:12:49', 2),
(30, NULL, 15, 141, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 585.00, 'rkrk', 'Centro Integral NutriVida', 'asf', 'Alan Antony Puc Yam', '2025-05-20 10:30:40', NULL, 0, 'web', '2025-05-18 20:22:38', '2025-05-23 01:58:48', 2),
(31, NULL, 15, 142, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'fg', 'Consultorio Nutricional “Vida y Salud”', 'Av. 22 No. 102 por 15 y 17, Barrio San Luis, Calkiní, Campeche', 'Alan Antony Puc Yam', '2025-05-21 10:30:56', NULL, 0, 'web', '2025-05-18 20:37:54', '2025-05-23 01:58:57', 2),
(32, NULL, 15, 83, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 585.00, 'yuh', 's', 's', 'Alan Antony Puc Yam', '2025-05-21 11:25:00', NULL, 0, 'web', '2025-05-18 21:03:59', '2025-05-18 21:08:06', 2),
(33, NULL, 15, 148, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'hhaja', '2', '2', 'Alan Antony Puc Yam', '2025-05-27 10:50:45', NULL, 0, 'web', '2025-05-18 21:08:43', '2025-05-23 02:00:23', 2),
(34, NULL, 15, 86, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'ajkaiaja', 'f', 'f', 'Regina Caceres Estrada', '2025-05-21 09:20:39', NULL, 0, 'web', '2025-05-19 17:52:38', '2025-05-19 17:54:00', 11),
(35, NULL, 15, 88, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'gghhhh', '2', '2', 'Regina Caceres Estrada', '2025-05-21 09:30:40', NULL, 0, 'web', '2025-05-19 18:03:39', '2025-05-19 18:06:30', 11),
(36, NULL, 15, 90, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'gg', 'f', 'f', 'Regina Caceres Estrada', '2025-05-20 08:45:31', NULL, 0, 'web', '2025-05-19 18:07:30', '2025-05-19 18:10:16', 11),
(37, NULL, 25, 95, 'Isabel', 'Cuevas', '9961025846_nut11', 'Femenino', 'monsee_nut11', 22, 600.00, 'hoal', '2', '2', 'Regina Caceres Estrada', '2025-05-21 09:00:47', '2025-05-21 12:00:00', 0, 'web', '2025-05-20 13:54:44', '2025-05-20 14:09:41', 11),
(38, NULL, 15, 144, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'usud', 'f', 'f', 'Alan Antony Puc Yam', '2025-05-21 10:00:48', NULL, 0, 'web', '2025-05-20 14:02:45', '2025-05-23 01:59:26', 2),
(39, NULL, 25, 104, 'Isabel', 'Cuevas', '9961025846_nut11', 'Femenino', 'monsee_nut11', 22, 600.00, 'Seguimiento: hoal', '2', '2', 'Regina Caceres Estrada', '2025-05-21 12:00:00', NULL, 0, 'web', '2025-05-20 14:09:41', '2025-05-20 14:42:55', 11),
(40, NULL, 25, 102, 'Isabel', 'Cuevas', '9961025846_nut11', 'Femenino', 'monsee_nut11', 22, 600.00, 'hjj', '2', '2', 'Regina Caceres Estrada', '2025-05-21 09:00:15', NULL, 0, 'web', '2025-05-20 14:10:12', '2025-05-20 14:42:30', 11),
(41, NULL, 25, 103, 'Isabel', 'Cuevas', '9961025846_nut11', 'Femenino', 'monsee_nut11', 22, 600.00, 'hola', '2', '2', 'Regina Caceres Estrada', '2025-05-21 11:24:17', NULL, 0, 'web', '2025-05-20 14:21:14', '2025-05-20 14:42:44', 11),
(42, NULL, 25, 105, 'Isabel', 'Cuevas', '9961025846_nut11', 'Femenino', 'monsee_nut11', 22, 600.00, 'tt', '2', '2', 'Regina Caceres Estrada', '2025-05-22 10:00:20', NULL, 0, 'web', '2025-05-20 14:36:17', '2025-05-20 14:43:09', 11),
(43, NULL, 25, 106, 'Isabel', 'Cuevas', '9961025846_nut11', 'Femenino', 'monsee_nut11', 22, 585.00, 'hshajsj', '2', '2', 'Regina Caceres Estrada', '2025-05-23 10:48:55', NULL, 0, 'web', '2025-05-20 14:39:52', '2025-05-20 14:43:17', 11),
(44, NULL, 25, 110, 'Isabel', 'Cuevas', '9961025846_nut11', 'Femenino', 'monsee_nut11', 22, 600.00, 'hjos', '2', '2', 'Regina Caceres Estrada', '2025-05-22 09:00:59', NULL, 0, 'web', '2025-05-20 14:44:56', '2025-05-20 15:14:13', 11),
(45, NULL, 15, 143, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'ff', 'f', 'f', 'Alan Antony Puc Yam', '2025-05-20 10:00:59', NULL, 0, 'web', '2025-05-20 14:52:57', '2025-05-23 01:59:16', 2),
(46, NULL, 25, 112, 'Isabel', 'Cuevas', '9961025846_nut11', 'Femenino', 'monsee_nut11', 22, 585.00, 'jsjs', '2', 'Calle 14#97A', 'Regina Caceres Estrada', '2025-05-22 10:00:29', NULL, 0, 'web', '2025-05-20 15:04:26', '2025-05-20 15:32:01', 11),
(47, NULL, 25, 123, 'Isabel', 'Cuevas', '9961025846_nut11', 'Femenino', 'monsee_nut11', 22, 600.00, 'hola', '22', '22', 'Regina Caceres Estrada', '2025-05-21 10:24:53', NULL, 0, 'web', '2025-05-20 15:46:50', '2025-05-20 16:59:40', 11),
(48, NULL, 25, 121, 'Isabel', 'Cuevas', '9961025846_nut11', 'Femenino', 'monsee_nut11', 22, 600.00, 'ggwd', '55', '55', 'Regina Caceres Estrada', '2025-05-20 09:00:36', '2025-05-22 12:00:00', 0, 'web', '2025-05-20 15:50:33', '2025-05-20 16:13:23', 11),
(49, NULL, 25, 117, 'Isabel', 'Cuevas', '9961025846_nut11', 'Femenino', 'monsee_nut11', 22, 600.00, 'd', 'f', 'f', 'Regina Caceres Estrada', '2025-05-21 09:00:53', NULL, 0, 'web', '2025-05-20 15:55:50', '2025-05-20 16:05:31', 11),
(50, NULL, 25, 118, 'Isabel', 'Cuevas', '9961025846_nut11', 'Femenino', 'monsee_nut11', 22, 600.00, 's', '5', '5', 'Regina Caceres Estrada', '2025-05-21 12:00:04', NULL, 0, 'web', '2025-05-20 16:00:01', '2025-05-20 16:08:27', 11),
(51, NULL, 25, 124, 'Isabel', 'Cuevas', '9961025846_nut11', 'Femenino', 'monsee_nut11', 22, 600.00, 'Seguimiento: ggwd', '55', '55', 'Regina Caceres Estrada', '2025-05-22 12:00:00', NULL, 0, 'web', '2025-05-20 16:13:23', '2025-05-20 16:59:55', 11),
(52, NULL, 25, 128, 'Isabel', 'Cuevas', '9961025846_nut11', 'Femenino', 'monsee_nut11', 22, 585.00, 'Holaaa', 'Clínica NutriBalance', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche', 'Regina Caceres Estrada', '2025-05-22 10:20:56', '2025-05-26 15:00:00', 3, 'web', '2025-05-20 17:00:51', '2025-05-22 09:54:47', 11),
(53, NULL, 15, 147, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'Holas', 'f', 'f', 'Alan Antony Puc Yam', '2025-05-23 13:30:29', NULL, 0, 'web', '2025-05-22 07:47:24', '2025-05-23 02:00:10', 2),
(54, NULL, 25, 153, 'Isabel', 'Cuevas', '9961025846_nut11', 'Femenino', 'monsee_nut11', 22, 585.00, 'Seguimiento: Holaaa', 'Clínica NutriBalance', 'Calle 13 No. 206 por 20 y 22, Col. Centro, Champotón, Campeche', 'Regina Caceres Estrada', '2025-05-26 15:00:00', NULL, 1, 'web', '2025-05-22 09:54:47', '2025-05-23 05:06:17', 11),
(55, NULL, 15, 131, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'Holassl', 'cancelado', 'cancelado', 'Alan Antony Puc Yam', '2025-06-05 10:10:39', NULL, 0, 'web', '2025-05-23 01:01:41', '2025-05-23 01:21:29', 2),
(56, NULL, 15, 133, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'holas', '12', 'fas', 'Alan Antony Puc Yam', '2025-06-05 10:10:21', NULL, 0, 'web', '2025-05-23 01:22:23', '2025-05-23 01:31:57', 2),
(57, NULL, 15, 135, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'shhss', '12', 'fas', 'Alan Antony Puc Yam', '2025-06-05 11:11:24', NULL, 0, 'web', '2025-05-23 01:32:26', '2025-05-23 01:35:22', 2),
(58, NULL, 15, 137, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'hsha', 'f', 'f', 'Alan Antony Puc Yam', '2025-06-05 09:50:26', NULL, 0, 'web', '2025-05-23 01:36:28', '2025-05-23 01:37:22', 2),
(59, NULL, 15, 139, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'hhh', 'f', 'f', 'Alan Antony Puc Yam', '2025-05-29 11:55:56', NULL, 0, 'web', '2025-05-23 01:37:58', '2025-05-23 01:39:43', 2),
(60, NULL, 15, 150, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'gd', 'f', 'f', 'Alan Antony Puc Yam', '2025-05-29 11:55:03', NULL, 0, 'web', '2025-05-23 01:40:05', '2025-05-23 02:00:41', 2),
(61, NULL, 15, 156, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'hsjs', 'cancelado', 'cancelado', 'Alan Antony Puc Yam', '2025-05-22 18:30:34', NULL, 0, 'web', '2025-05-23 05:10:36', '2025-05-23 05:19:19', 2),
(62, NULL, 15, 157, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 292.00, 'haua', 'cancelado', 'cancelado', 'Alan Antony Puc Yam', '2025-05-23 10:30:33', NULL, 0, 'web', '2025-05-23 05:12:35', '2025-05-23 05:19:29', 2),
(63, NULL, 15, 161, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 292.00, 'rrr', 'cancelado', '2', 'Alan Antony Puc Yam', '2025-05-23 11:35:12', NULL, 0, 'web', '2025-05-23 05:23:14', '2025-05-23 05:30:10', 2),
(64, NULL, 25, 160, 'Isabel', 'Cuevas', '9961025846_nut11', 'Femenino', 'monsee_nut11', 22, 600.00, 'fff', 'cac', 'cac', 'Regina Caceres Estrada', '2025-05-23 11:50:38', NULL, 0, 'web', '2025-05-23 05:24:40', '2025-05-23 05:28:46', 11),
(65, NULL, 25, 165, 'Isabel', 'Cuevas', '9961025846_nut11', 'Femenino', 'monsee_nut11', 22, 292.00, 'upss', '5', '5', 'Regina Caceres Estrada', '2025-05-22 10:30:14', NULL, 0, 'web', '2025-05-23 05:31:16', '2025-05-23 05:48:42', 11),
(66, NULL, 25, 166, 'Isabel', 'Cuevas', '9961025846_nut11', 'Femenino', 'monsee_nut11', 22, 600.00, 'jsjsjsjss', 'f', 'f', 'Regina Caceres Estrada', '2025-05-24 09:00:37', NULL, 0, 'web', '2025-05-23 05:41:39', '2025-05-23 05:48:53', 11),
(67, NULL, 15, 167, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 585.00, 'usuw', 'cancelado', 'f', 'Alan Antony Puc Yam', '2025-05-26 11:30:19', NULL, 0, 'web', '2025-05-23 05:42:21', '2025-05-23 05:49:16', 2),
(68, NULL, 15, 170, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'rrhry', 'f', 'ff', 'Alan Antony Puc Yam', '2025-05-23 10:50:03', NULL, 0, 'web', '2025-05-23 05:51:05', '2025-05-23 06:17:19', 2),
(69, NULL, 15, 171, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 585.00, 'rrh', 'f', 'f', 'Alan Antony Puc Yam', '2025-05-26 10:45:56', NULL, 0, 'web', '2025-05-23 05:51:58', '2025-05-23 06:17:31', 2),
(70, NULL, 25, 175, 'Isabel', 'Cuevas', '9961025846_nut11', 'Femenino', 'monsee_nut11', 22, 292.00, 'dud', 'Clínica NutriVida Activa', 'Calle 25 #204 x 30 y 32, Barrio San Luis, Calkiní, Campeche', 'Regina Caceres Estrada', '2025-05-23 10:20:46', '2025-06-13 11:30:00', 3, 'web', '2025-05-23 06:27:49', '2025-05-23 07:13:15', 11),
(71, NULL, 15, 185, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'jsjs', 'cancelado', 'cancelado', 'Alan Antony Puc Yam', '2025-05-23 10:20:10', NULL, 0, 'web', '2025-05-23 06:36:12', '2025-05-26 19:18:54', 2),
(72, NULL, 25, 182, 'Isabel', 'Cuevas', '9961025846_nut11', 'Femenino', 'monsee_nut11', 22, 292.00, 'Seguimiento: dud', 'Clínica NutriVida Activa', 'Calle 25 #204 x 30 y 32, Barrio San Luis, Calkiní, Campeche', 'Regina Caceres Estrada', '2025-06-13 11:30:00', NULL, 4, 'web', '2025-05-23 07:13:15', '2025-05-26 19:13:42', 11),
(73, NULL, 15, 179, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'Holas', 'VitalBalance Calkiní', 'Calle 18 #255, entre 15 y 17, Centro, Calkiní, Campeche', 'Alan Antony Puc Yam', '2025-05-29 10:10:34', '2025-06-12 10:00:00', 3, 'web', '2025-05-23 18:42:35', '2025-05-23 18:57:25', 2),
(74, NULL, 15, 187, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'Seguimiento: Holas', 'VitalBalance Calkiní', 'Calle 18 #255, entre 15 y 17, Centro, Calkiní, Campeche', 'Alan Antony Puc Yam', '2025-06-12 10:00:00', NULL, 0, 'web', '2025-05-23 18:57:25', '2025-05-27 16:41:10', 2),
(75, NULL, 15, 184, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 600.00, 'jdjd', 'cancelado', 'f', 'Alan Antony Puc Yam', '2025-05-28 12:00:14', NULL, 0, 'web', '2025-05-26 19:17:17', '2025-05-26 19:18:42', 2),
(76, NULL, 15, 188, 'Isabel', 'Cuevas', '9961025846', 'Femenino', 'monsee', 22, 585.00, 'Me siento mareada, con vomitos', NULL, NULL, 'Alan Antony Puc Yam', '2025-06-03 11:30:02', NULL, 4, 'movil', '2025-05-27 16:47:04', '2025-05-27 16:47:04', 2);

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
(8, 'Isabel', 'Cuevas', 'monsecuevas@gmail.com', 'monsee', '$2y$12$rMF75mAHj0K4YssDGzJpme4.E/FX1B1bv/acAOq.aCHVXHnNl4N.2', '9anZVRwbpGIxzmvHdStASAvIHxRUO0fTyifKi88nvpZ5gJfmzV5jdvrGgkDx', 2, 1, 0, '2025-05-14 07:08:28', '2025-05-27 07:29:35', '2025-06-26 07:29:35'),
(9, 'Maria', 'Veronica', 'marivero@gmail.com', 'marivero', '$2y$12$7L5m4r7hRyTtdVdiGZ6gZ.aWtZdJKraYGDqvUDNGPOvINgjWq4vE2', NULL, 1, 1, 0, '2025-05-14 07:30:37', '2025-05-14 07:34:58', '2025-06-13 07:32:56'),
(10, 'Paula', 'Tuz Tuz', 'pautuztuz@gmail.com', 'PauTuz', '$2y$12$4kXAcvKD0pT6eMwDCLBgBuibA3x3RA3vNzonHRsDfQSNFtGdhEB9m', NULL, 2, 1, 0, '2025-05-15 09:10:26', '2025-05-15 09:10:26', NULL),
(11, 'Regina', 'Caceres Estrada', 'caceresEstrada@gmail.com', 'Regina_Estrada', '$2y$12$3kUwRHohWXi1g/hcpEtkPuwdxhGLA6gwdRqdD.XczF8g6u91tGanK', 'L3z9abpjMI3ZiF5qK6b3dukEOJeH3AlvbmUnMYPxfR6T2NKoAhuFFm95PWOC', 1, 1, 0, '2025-05-19 14:01:02', '2025-05-19 14:01:17', '2025-06-18 14:01:17');

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
-- Indices de la tabla `nutridesafios`
--
ALTER TABLE `nutridesafios`
  ADD PRIMARY KEY (`NutriDesafios_ID`),
  ADD KEY `nutridesafios_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`Paciente_ID`),
  ADD UNIQUE KEY `paciente_telefono_unique` (`telefono`),
  ADD UNIQUE KEY `paciente_usuario_unique` (`usuario`),
  ADD UNIQUE KEY `paciente_email_user_id_unique` (`email`,`user_id`),
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
  MODIFY `Ajuste_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `Consulta_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `Notificacion_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT de la tabla `notification`
--
ALTER TABLE `notification`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nutridesafios`
--
ALTER TABLE `nutridesafios`
  MODIFY `NutriDesafios_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `Paciente_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
  MODIFY `Reservacion_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
-- Filtros para la tabla `nutridesafios`
--
ALTER TABLE `nutridesafios`
  ADD CONSTRAINT `nutridesafios_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

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
