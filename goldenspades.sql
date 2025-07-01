-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01-Jul-2025 às 17:38
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `goldenspades`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_d670b31c7caf8d18f681710061011145', 'i:1;', 1751382098),
('laravel_cache_d670b31c7caf8d18f681710061011145:timer', 'i:1751382098;', 1751382098),
('laravel_cache_f86966f3be89f79be6849c0a91122c7a', 'i:1;', 1751382547),
('laravel_cache_f86966f3be89f79be6849c0a91122c7a:timer', 'i:1751382547;', 1751382547);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `produto_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_04_10_085057_add_two_factor_columns_to_users_table', 1),
(5, '2025_04_10_085140_create_personal_access_tokens_table', 1),
(6, '2025_04_26_184121_create_produtos_table', 1),
(7, '2025_05_16_212057_create_profiles_table', 2),
(8, '2025_05_21_082226_create_orders_table', 3),
(9, '2025_05_21_083659_create_favorites_table', 4),
(10, '2025_05_24_145058_add_quantidade_to_produtos_table', 5),
(11, '2025_07_01_110335_add_endereco_to_orders_table', 6),
(12, '2025_07_01_110417_add_quantidade_to_produtos_table', 6),
(13, '2025_07_01_152730_add_estado_to_orders_table', 6),
(14, '2025_07_01_153545_add_metodo_to_orders_table', 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total` decimal(8,2) NOT NULL DEFAULT 0.00,
  `endereco` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'pendente',
  `metodo` varchar(255) NOT NULL DEFAULT 'pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `endereco`, `created_at`, `updated_at`, `estado`, `metodo`) VALUES
(1, 5, 0.00, 'X, nºX, XXXX-XXX, Coimbra', '2025-07-01 14:46:49', '2025-07-01 14:53:17', 'Enviado', 'mbway'),
(2, 5, 0.00, 'x, nºx, xxxx-xxx, coimbra', '2025-07-01 15:01:15', '2025-07-01 15:01:15', 'Pendente', 'mbway'),
(3, 2, 0.00, 'rua x, xxxx-xxx, coimbra', '2025-07-01 15:14:38', '2025-07-01 15:14:38', 'Pendente', 'mbway'),
(4, 2, 0.00, 'rua x, xxxx-xxx, coimbra', '2025-07-01 15:25:57', '2025-07-01 15:25:57', 'Pendente', 'mbway');

-- --------------------------------------------------------

--
-- Estrutura da tabela `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `produto_id` bigint(20) UNSIGNED NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `produto_id`, `quantidade`, `preco`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 1, 65.00, '2025-07-01 14:46:49', '2025-07-01 14:46:49'),
(2, 2, 3, 1, 65.00, '2025-07-01 15:01:15', '2025-07-01 15:01:15'),
(3, 3, 3, 2, 65.00, '2025-07-01 15:14:38', '2025-07-01 15:14:38'),
(4, 4, 4, 1, 40.00, '2025-07-01 15:25:57', '2025-07-01 15:25:57');

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(8,2) NOT NULL,
  `quantidade` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `imagem`, `categoria`, `descricao`, `preco`, `quantidade`, `created_at`, `updated_at`) VALUES
(1, 'Anel Gotta', 'images/anéis/1751363523_imagem_2025-07-01_105149526.png', 'Anéis', 'Um anel fino de ouro, com design em formato de V', 45.00, 5, '2025-06-10 09:52:03', '2025-07-01 09:52:03'),
(2, 'Anel Angel', 'images/anéis/1751363575_imagem_2025-07-01_105219893.png', 'Anéis', 'Um anel delicado de ouro, com aro fino e abertura frontal, traz duas pequenas pedras de cristal.', 60.00, 6, '2025-07-01 09:52:55', '2025-07-01 09:52:55'),
(3, 'Anel Pérola', 'images/anéis/1751363608_imagem_2025-07-01_105308265.png', 'Anéis', 'Anel dourado com aro duplo e delicado: no centro, uma pedra verde oval (estilo esmeralda) é circundada por um halo de pequenas gemas claras, criando um efeito de flor.', 65.00, 5, '2025-07-01 09:53:28', '2025-07-01 09:53:28'),
(4, 'Anel Remoinho', 'images/anéis/1751363634_imagem_2025-07-01_105342575.png', 'Anéis', 'Anel de ouro com aro aberto e pontas curvas e polidas que se afunilam em formato de gota, criando um visual fluido e minimalista.', 40.00, 9, '2025-07-01 09:53:54', '2025-07-01 09:53:54'),
(5, 'Anel nó', 'images/anéis/1751363663_imagem_2025-07-01_105403733.png', 'Anéis', 'Anel de aro fino dourado, aberto na parte inferior, com um elegante nó central formando o ponto focal da peça.', 50.00, 6, '2025-07-01 09:54:23', '2025-07-01 09:54:23'),
(6, 'Colar Marinheiro', 'images/colares/1751363726_imagem_2025-07-01_105447602.png', 'Colares', 'Colar em ouro com elos torcidos em formato de corda, criando um trançado delicado que reflete a luz de maneira sutil.', 70.00, 6, '2025-07-01 09:55:26', '2025-07-01 09:55:26'),
(7, 'Colar Leão', 'images/colares/1751363779_imagem_2025-07-01_105545314.png', 'Colares', 'Corrente dourada torcida acompanhada de pingente circular em relevo; o centro exibe a cabeça de um leão, enquadrada por uma borda decorativa.', 60.00, 3, '2025-07-01 09:56:19', '2025-07-01 09:56:19'),
(8, 'Colar Rosa', 'images/colares/1751363808_imagem_2025-07-01_105626963.png', 'Colares', 'Corrente fina dourada sustenta um pingente retangular de borda texturada; no centro, um delicado relevo de flor estilizada acrescenta um toque artístico e sutil.', 55.00, 3, '2025-07-01 09:56:48', '2025-07-01 09:56:48'),
(9, 'Colar Bela', 'images/colares/1751363837_imagem_2025-07-01_105658341.png', 'Colares', 'Fio contínuo de pequenas pedras claras cravadas em estrutura dourada, com extensor delicado para ajuste de comprimento.', 60.00, 4, '2025-07-01 09:57:17', '2025-07-01 09:57:17'),
(10, 'Colar Alma', 'images/colares/1751363868_imagem_2025-07-01_105725167.png', 'Colares', 'Corrente dourada delicada com pequenas esferas polidas distribuídas ao longo do fio, criando um visual minimalista e sofisticado.', 75.00, 6, '2025-07-01 09:57:48', '2025-07-01 09:57:48'),
(11, 'Medalha Gato', 'images/medalhas/1751363901_imagem_2025-07-01_105802837.png', 'Medalhas', 'Pingente em ouro com contorno vazado de gatinho; na altura do pescoço, duas pequenas pedras claras formam um delicado laço, acrescentando brilho sutil à peça.', 55.00, 7, '2025-07-01 09:58:21', '2025-07-01 09:58:21'),
(12, 'Medalha Anjo', 'images/medalhas/1751363926_imagem_2025-07-01_105828684.png', 'Medalhas', 'Pingente em ouro com silhueta de anjinho: halo sobre a cabeça, asas arredondadas e um pequeno cristal claro incrustado no centro da túnica, acrescentando brilho discreto.', 60.00, 5, '2025-07-01 09:58:46', '2025-07-01 09:58:46'),
(13, 'Medalha Estrela', 'images/medalhas/1751363958_imagem_2025-07-01_105905388.png', 'Medalhas', 'Pingente em ouro em forma de estrela de oito pontas, com pequeno cristal claro cravado no centro, conferindo brilho delicado.', 50.00, 3, '2025-07-01 09:59:18', '2025-07-01 09:59:18'),
(14, 'Medalha Especial', 'images/medalhas/1751363991_imagem_2025-07-01_105935175.png', 'Medalhas', 'Pingente oval em ouro com relevo de Nossa Senhora ao centro; a borda traz inscrição em baixo-relevo, conferindo caráter religioso e clássico à medalha.', 55.00, 2, '2025-07-01 09:59:51', '2025-07-01 09:59:51'),
(15, 'Medalha Santa', 'images/medalhas/1751364026_imagem_2025-07-01_110004645.png', 'Medalhas', 'Pingente oval em ouro com relevo de Nossa Senhora ao centro; a borda traz inscrição em baixo-relevo, conferindo caráter religioso e clássico à medalha.', 65.00, 2, '2025-07-01 10:00:26', '2025-07-01 10:00:26'),
(16, 'Pulseira Alma', 'images/pulseiras/1751364090_imagem_2025-07-01_110045996.png', 'Pulseiras', 'Bracelete fino em ouro, aro aberto, com um nó elegante no centro que funciona como ponto focal e símbolo de união.', 80.00, 4, '2025-07-01 10:01:30', '2025-07-01 10:01:30'),
(17, 'Pulseira Luna', 'images/pulseiras/1751364732_imagem_2025-07-01_111151942.png', 'Pulseiras', 'Pulseira bracelete em ouro polido, aberta e assimétrica, composta por dois arcos amplos que se cruzam suavemente, criando um desenho orgânico e contemporâneo.', 70.00, 2, '2025-07-01 10:12:12', '2025-07-01 10:12:12'),
(18, 'Pulseira Quadrados', 'images/pulseiras/1751364772_imagem_2025-07-01_111249874.png', 'Pulseiras', 'Pulseira bracelete geométrica em ouro, formada por duas hastes paralelas unidas por barras perpendiculares que criam aberturas retangulares, resultando num design arquitetônico e marcante.', 60.00, 3, '2025-07-01 10:12:52', '2025-07-01 10:12:52'),
(19, 'Pulseira Mar', 'images/pulseiras/1751364808_imagem_2025-07-01_111303881.png', 'Pulseiras', 'Pulseira bracelete dupla em ouro, composta por duas hastes finas que se cruzam em curvas suaves, criando um desenho ondulado em forma de “S” que abraça o pulso com elegância fluida.', 65.00, 4, '2025-07-01 10:13:28', '2025-07-01 10:13:28'),
(20, 'Pulseira Pérola Cinza', 'images/pulseiras/1751364837_imagem_2025-07-01_111339220.png', 'Pulseiras', 'Pulseira bracelete rígida em ouro, de design fino e polido, realçada ao centro por uma pequena placa retangular cravejada de micro-pedras brilhantes, conferindo um detalhe elegante e sofisticado.', 75.00, 6, '2025-07-01 10:13:57', '2025-07-01 10:13:57'),
(21, 'Relógio Gold', 'images/relógios/1751364954_imagem_2025-07-01_111540930.png', 'Relógios', 'Relógio de pulso todo em dourado, com caixa retangular polida, mostrador monocromático em tom champagne com índices discretos, e pulseira de elos articulados que lhe confere um visual clássico e elegante.', 90.00, 5, '2025-07-01 10:15:54', '2025-07-01 10:15:54'),
(22, 'Relógio Spades', 'images/relógios/1751364998_imagem_2025-07-01_111620556.png', 'Relógios', 'Relógio de pulso dourado com caixa quadrada de cantos suavemente arredondados; mostrador claro traz índices e ponteiros finos em tom ouro, enquanto a pulseira de elos largos e lisos cria um visual moderno e minimalista.', 80.00, 8, '2025-07-01 10:16:38', '2025-07-01 10:16:38'),
(23, 'Relógio Amavz', 'images/relógios/1751365020_imagem_2025-07-01_111647971.png', 'Relógios', 'Relógio de pulso dourado com caixa fina circular; mostrador em madrepérola exibe numerais romanos sutis nas posições 12, 3, 6 e 9, pontuado por pequenos cristais nos demais índices. Completa a peça uma pulseira de malha metálica dourada, conferindo elegância leve e contemporânea.', 70.00, 4, '2025-07-01 10:17:00', '2025-07-01 10:17:00'),
(24, 'Relógio Pérola Negra', 'images/relógios/1751365078_imagem_2025-07-01_111708543.png', 'Relógios', 'Relógio de pulso dourado com caixa redonda; mostrador grafite exibe índices em filetes dourados e um aro interno de pequenos pontos claros que adiciona sofisticação. A peça é completada por pulseira de malha metálica dourada, conferindo acabamento elegante e moderno.', 95.00, 7, '2025-07-01 10:17:58', '2025-07-01 10:17:58'),
(26, 'Relógio Double Gold', 'images/relógios/1751365295_imagem_2025-07-01_112110891.png', 'Relógios', 'Relógio de pulso dourado com caixa redonda polida; mostrador champagne exibe três subdials de cronógrafo, índices em barras e escala taquimétrica interna. A pulseira robusta de elos metálicos e os botões laterais completam o visual sofisticado e esportivo.', 100.00, 8, '2025-07-01 10:21:35', '2025-07-01 10:21:35');

-- --------------------------------------------------------

--
-- Estrutura da tabela `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `address`, `phone`, `created_at`, `updated_at`) VALUES
(1, 3, 'Travessa Rua da Barqueira, Taveiro, Coimbra, 3045-459', '927202585', '2025-05-21 08:18:28', '2025-05-21 08:29:18'),
(2, 4, '', '', '2025-05-21 12:48:34', '2025-05-21 12:48:34'),
(3, 5, '', '', '2025-07-01 13:00:09', '2025-07-01 13:00:09');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('stdXyR0re2nBWjZFdt7bLrpOwR23vS19QGbrVRXU', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0', 'YTo5OntzOjY6Il90b2tlbiI7czo0MDoiWTJRUWlOd3ZOanlPZlR1Z3JZdk5hR21hY0RLaENyNFJWZmw2ZVVlQyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czoyMToicGFzc3dvcmRfaGFzaF9zYW5jdHVtIjtzOjYwOiIkMnkkMTIkSm5OUEl1QnhMTE1hSzExSlhpazhxZTl4NjNNbFVHbVVybXNyRndZcXBsR3JUUHFtRXozZnUiO3M6MTc6ImNhcnJpbmhvX3N1YnRvdGFsIjtkOjQwO3M6MTc6ImNhcnJpbmhvX3NoaXBwaW5nIjtkOjcuNTtzOjE0OiJjYXJyaW5ob190b3RhbCI7ZDo0Ny41O3M6MTc6ImNoZWNrb3V0X2VuZGVyZWNvIjtzOjI0OiJydWEgeCwgeHh4eC14eHgsIGNvaW1icmEiO30=', 1751384281);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `usertype` varchar(255) NOT NULL DEFAULT 'user',
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `usertype`, `address`, `phone`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(2, 'Admin', 'admin@goldspades.com', '0', 'rua x, xxxx-xxx, coimbra', '987252444', '2025-05-16 19:56:44', '$2y$12$JnNPIuBxLLMaK11JXik8qe9x63MlUGmUrmsrFwYqplGrTPqmEz3fu', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-16 19:56:44', '2025-07-01 14:25:17'),
(3, 'Cruz', 'joaomarcruz@gmail.com', '1', 'Travessa Rua da Barqueira, Taveiro, Coimbra, 3045-459', '927202585', NULL, '$2y$12$b9zsvo1k/UADVWE3nnFbiOlBOlxGur5iS/vVG4tsl0vPxITbK.vai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-16 21:04:24', '2025-05-21 08:34:05'),
(4, 'Beatriz', 'beatrizexemplo@gmail.com', '1', 'rua principal, coimbra, 300-3455', '927545686', NULL, '$2y$12$bKeuykkSYVn.SwB.9UcfFO8iOlMN.i8GuBFf9ov9wslup4NcjBNoi', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-21 12:48:34', '2025-05-21 12:49:31'),
(5, 'Cruz', 'joaomcboss@gmail.com', '1', NULL, NULL, NULL, '$2y$12$4j1v6evqXFCNIyMuKUfEMeZMcPWm37vFr.40vwNKEYAvlHAO6sL4W', NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-01 13:00:09', '2025-07-01 13:00:09');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Índices para tabela `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Índices para tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Índices para tabela `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favorites_user_id_foreign` (`user_id`),
  ADD KEY `favorites_produto_id_foreign` (`produto_id`);

--
-- Índices para tabela `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Índices para tabela `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Índices para tabela `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_produto_id_foreign` (`produto_id`);

--
-- Índices para tabela `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Índices para tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `profiles_user_id_unique` (`user_id`);

--
-- Índices para tabela `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_produto_id_foreign` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_produto_id_foreign` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
