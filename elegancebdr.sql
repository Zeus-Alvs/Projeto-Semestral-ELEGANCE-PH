-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04/12/2025 às 18:10
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `elegancebdr`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `carrinho`
--

CREATE TABLE `carrinho` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `tamanho` enum('P','M','G','GG') DEFAULT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 1,
  `foto` varchar(255) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `nomeproduto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `marca` enum('NIKE','HUGOBOSS','MIZUNO','PUMA','ADIDAS') DEFAULT NULL,
  `genero` enum('Masculino','Feminino','Unissex') DEFAULT NULL,
  `tipo` enum('Tenis','Camiseta','Chuteira','Top','Legging','Mochila','Meia','Bone','Shorts','Bermuda') DEFAULT NULL,
  `vendidos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`id`, `nome`, `preco`, `foto`, `marca`, `genero`, `tipo`, `vendidos`) VALUES
(1, 'Camiseta Nike Just do IT', 45.00, 'imagemProds/1764261732_FOTO 1.PNG', 'NIKE', 'Masculino', 'Camiseta', 1),
(2, 'Camiseta Hugo Boss Black', 70.00, 'imagemProds/1764261810_FOTO 2.PNG', 'HUGOBOSS', 'Masculino', 'Camiseta', 1),
(3, 'Camiseta Nike Multi-Color Logo Black', 71.00, 'imagemProds/1764261833_FOTO 3.PNG', 'NIKE', 'Masculino', 'Camiseta', 7),
(4, 'Camiseta Nike Air preta', 70.00, 'imagemProds/1764261848_ICON MAIS VENDIDO 1.PNG', 'NIKE', 'Masculino', 'Camiseta', NULL),
(5, 'Kit hugo boss camiseta branca e bermuda preta', 70.00, 'imagemProds/1764261864_ICON MAIS VENDIDO 2.PNG', 'HUGOBOSS', 'Masculino', 'Camiseta', NULL),
(6, 'Camiseta Nike athletic', 97.00, 'imagemProds/1764261876_ICON MAIS VENDIDO 3.PNG', 'NIKE', 'Masculino', 'Camiseta', 1),
(10, 'Camiseta Preta Puma', 99.00, 'imagemProds/1764624151_CamisetaPumaMasculina.webp', 'PUMA', 'Masculino', 'Camiseta', 3),
(11, 'Tenis Puma', 350.00, 'imagemProds/1764624208_TenisMasculinoPuma.avif', 'PUMA', 'Masculino', 'Tenis', 1),
(12, 'Mizuno Wave Prophecy 13', 549.99, 'imagemProds/1764811327_102183001_3-036-01.png', 'MIZUNO', 'Unissex', 'Tenis', NULL),
(13, 'Mizuno Vitality 4', 249.99, 'imagemProds/1764811546_101029029_1-016-01.png', 'MIZUNO', 'Unissex', 'Tenis', NULL),
(14, 'Mizuno Ball', 209.99, 'imagemProds/1764811747_MIMSA41887_3-209-01.png', 'MIZUNO', 'Unissex', 'Mochila', 2),
(15, 'Meião de Futebol', 39.99, 'imagemProds/1764811806_MNMFA51936_1-012-001.webp', 'MIZUNO', 'Masculino', 'Meia', NULL),
(16, 'Chuteira Morelia Club IN', 199.99, 'imagemProds/1764811851_107682682_1-021-01.webp', 'MIZUNO', 'Masculino', 'Chuteira', 3),
(17, 'Mizuno Sport New', 89.99, 'imagemProds/1764811894_MNMAA24791_3-041-03.jpg.webp', 'MIZUNO', 'Unissex', 'Bone', NULL),
(18, 'Mizuno Atlantis 2', 89.99, 'imagemProds/1764812046_101038038_2-004-01.webp', 'MIZUNO', 'Feminino', 'Tenis', NULL),
(19, 'Shots Saia Casual Street', 109.99, 'imagemProds/1764812085_MIFSS41264_2-030-01.webp', 'MIZUNO', 'Feminino', 'Shorts', NULL),
(20, 'Nike SB Force 58', 339.99, 'imagemProds/1764812150_011580IDA4.avif', 'NIKE', 'Masculino', 'Tenis', NULL),
(21, 'Nike Pro Dri-FIT', 154.49, 'imagemProds/1764812501_026628IDA2.webp', 'NIKE', 'Masculino', 'Legging', NULL),
(22, 'Nike Los Angeles Lakers', 599.99, 'imagemProds/1764812529_0231590LA3.avif', 'NIKE', 'Masculino', 'Camiseta', NULL),
(23, 'Nike Sportswear', 159.99, 'imagemProds/1764812560_05945900A1.jpg', 'NIKE', 'Feminino', 'Camiseta', NULL),
(24, 'Top Dri-FIT Nike Pro', 259.99, 'imagemProds/1764812589_059712P2A1.jpg', 'NIKE', 'Feminino', 'Top', NULL),
(25, 'Nike Dri-FIT Ace', 79.99, 'imagemProds/1764812677_0265715AA2.jpg', 'NIKE', 'Feminino', 'Bone', NULL),
(26, 'Blue Version Classic 3 Pares', 99.99, 'imagemProds/1764812946_Meias_Blue_Version_Classic_3_Pares_Branco_IB3784_03_standard.avif', 'ADIDAS', 'Masculino', 'Meia', NULL),
(27, 'Camo Chino', 499.99, 'imagemProds/1764813004_Shorts_Camo_Chino_Preto_JY2765_21_model.jpg', 'ADIDAS', 'Masculino', 'Bermuda', NULL),
(28, 'Malha Três Listras AEROREADY', 89.99, 'imagemProds/1764813031_Shorts_Adicolor_Classics_Sprinter_Preto_HS2069_01_laydown.avif', 'ADIDAS', 'Masculino', 'Shorts', NULL),
(29, 'Pochete Adicolor', 119.99, 'imagemProds/1764813141_Pochete_Adicolor_Borgonha_IX7468_01_standard.avif', 'ADIDAS', 'Feminino', 'Mochila', NULL),
(30, 'Legging 7/8 Techfit', 119.99, 'imagemProds/1764813162_Legging_7-8_Techfit_Azul_JY8362_21_model.avif', 'ADIDAS', 'Feminino', 'Legging', NULL),
(31, 'F50 Elite Campo', 1199.99, 'imagemProds/1764813217_Chuteira_F50_Elite_Campo_Roxo_JH7615_HM1.avif', 'ADIDAS', 'Feminino', 'Chuteira', NULL),
(32, 'Atletismo CBAt', 199.99, 'imagemProds/1764813825_pumalegin.avif', 'PUMA', 'Feminino', 'Legging', NULL),
(33, 'Meia Sapatilha (3 Pares)', 69.99, 'imagemProds/1764813847_meiap.avif', 'PUMA', 'Feminino', 'Meia', NULL),
(34, 'Wardrobe Essentials Relaxed 16\"', 349.99, 'imagemProds/1764813925_bermup.avif', 'PUMA', 'Masculino', 'Bermuda', NULL),
(35, 'Relaxed Cargo 16\" FUTURE.PUMA.ARCHIVE', 299.99, 'imagemProds/1764813950_bermudap.avif', 'PUMA', 'Masculino', 'Bermuda', NULL),
(36, 'Aba Curva Scuderia Ferrari Hamilton', 249.99, 'imagemProds/1764814002_bonp.avif', 'PUMA', 'Masculino', 'Bone', NULL),
(37, 'Low Impact Move ANIMAL REMIX', 159.99, 'imagemProds/1764814120_toppuma.avif', 'PUMA', 'Feminino', 'Top', NULL),
(39, 'Bolsa Repórter Em Material Revestido', 299.99, 'imagemProds/1764814519_4063538658873-Bolsas_2.jpg', 'HUGOBOSS', 'Unissex', 'Mochila', NULL),
(40, 'Tênis De Poliéster', 1299.99, 'imagemProds/1764814564_4063548372981_1.webp', 'HUGOBOSS', 'Unissex', 'Tenis', NULL),
(43, 'Run Velocity ULTRAWEAVE 4\"', 129.99, 'imagemProds/1764857396_pumashorts.avif', 'PUMA', 'Feminino', 'Shorts', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `CEP` char(8) NOT NULL,
  `CPF` char(11) NOT NULL,
  `nivel` enum('admin','usuario') NOT NULL DEFAULT 'usuario',
  `rua` varchar(100) DEFAULT NULL,
  `numero` varchar(100) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `Bairro` varchar(100) DEFAULT NULL,
  `Estado` varchar(100) DEFAULT NULL,
  `Cidade` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `foto`, `CEP`, `CPF`, `nivel`, `rua`, `numero`, `complemento`, `Bairro`, `Estado`, `Cidade`) VALUES
(55, 'Fernando', 'zebg@gmail.com', '$2y$10$OOo7bkdlolQYeH6wo5LosuaUcq2A3r6r5r9v8pK7rxBYWy/sGXub2', 'uploads/692bc01b59740_The Rock.jpg', '11701000', '44444444444', 'admin', 'Avenida Presidente Costa e Silva', '745', 'apto 56', 'Área Rural de Xique-Xique', 'BA', 'Xique-Xique'),
(57, 'Ronaldo', 'r@g', '$2y$10$skHKdGY/pSExyBFExU1rNexGhc7n68WHLsaFk3fEA4kQKcqbj6GG6', 'uploads/6931b4aee811c_r.webp', '11700005', '75698721485', 'usuario', 'Avenida Presidente Costa e Silva', '98', 'Casa', 'Vila Ana Maria', 'SP', 'Sarapuí');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `produto_id` (`produto_id`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `carrinho`
--
ALTER TABLE `carrinho`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `carrinho`
--
ALTER TABLE `carrinho`
  ADD CONSTRAINT `carrinho_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `carrinho_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
