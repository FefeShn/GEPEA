-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02/10/2025 às 15:14
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_gepea`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `arquivo`
--

CREATE TABLE `arquivo` (
  `id_arquivo` int(11) NOT NULL,
  `nome_arquivo` varchar(255) NOT NULL,
  `descricao_arquivo` text DEFAULT NULL,
  `url_arquivo` varchar(500) NOT NULL,
  `tipo_arquivo` varchar(50) DEFAULT NULL,
  `tamanho_arquivo` bigint(20) DEFAULT NULL,
  `data_upload` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `atividade`
--

CREATE TABLE `atividade` (
  `id_atividade` int(11) NOT NULL,
  `descricao_atividade` text NOT NULL,
  `data_hora` datetime NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Estrutura para tabela `discussao`
--

CREATE TABLE `discussao` (
  `id_discussao` int(11) NOT NULL,
  `titulo_discussao` varchar(255) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `discussao_participante`
--

CREATE TABLE `discussao_participante` (
  `id_discussao` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `data_adicao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `evento`
--

CREATE TABLE `evento` (
  `id_evento` int(11) NOT NULL,
  `titulo_evento` varchar(255) NOT NULL,
  `conteudo_evento` text NOT NULL,
  `data_evento` datetime NOT NULL,
  `foto_evento` varchar(500) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensagem`
--

CREATE TABLE `mensagem` (
  `id_mensagem` int(11) NOT NULL,
  `mensagem` text NOT NULL,
  `data_mensagem` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_discussao` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `resposta_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `presenca`
--

CREATE TABLE `presenca` (
  `id_presenca` int(11) NOT NULL,
  `confirmacao` tinyint(1) DEFAULT 0,
  `data_confirmacao` timestamp NULL DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_atividade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome_user` varchar(255) NOT NULL,
  `email_user` varchar(255) NOT NULL,
  `senha_user` varchar(255) NOT NULL,
  `foto_user` varchar(500) DEFAULT NULL,
  `bio_user` text DEFAULT NULL,
  `cargo_user` varchar(100) DEFAULT NULL,
  `eh_adm` tinyint(1) DEFAULT 0,
  `lattes_user` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios`
(`id_usuario`, `nome_user`, `email_user`, `senha_user`, `foto_user`, `bio_user`, `cargo_user`, `eh_adm`, `lattes_user`)
VALUES
(1, 'Fernanda Sehn', 'fernandasehn6@gmail.com', '123', 'computer.jpg', 'admin do site temporariamente', 'Bolsista', 1, 'http://lattes.cnpq.br/5360280589109309');


--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `arquivo`
--
ALTER TABLE `arquivo`
  ADD PRIMARY KEY (`id_arquivo`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `atividade`
--
ALTER TABLE `atividade`
  ADD PRIMARY KEY (`id_atividade`),
  ADD KEY `id_usuario` (`id_usuario`);

--

--
-- Índices de tabela `discussao`
--
ALTER TABLE `discussao`
  ADD PRIMARY KEY (`id_discussao`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `discussao_participante`
--
ALTER TABLE `discussao_participante`
  ADD PRIMARY KEY (`id_discussao`,`id_usuario`),
  ADD KEY `idx_disc_part_usuario` (`id_usuario`);

--
-- Índices de tabela `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id_evento`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `mensagem`
--
ALTER TABLE `mensagem`
  ADD PRIMARY KEY (`id_mensagem`),
  ADD KEY `id_discussao` (`id_discussao`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `resposta_id` (`resposta_id`);

--
-- Índices de tabela `presenca`
--
ALTER TABLE `presenca`
  ADD PRIMARY KEY (`id_presenca`),
  ADD UNIQUE KEY `unique_presenca` (`id_usuario`,`id_atividade`),
  ADD KEY `id_atividade` (`id_atividade`);

--

--


--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email_user` (`email_user`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `arquivo`
--
ALTER TABLE `arquivo`
  MODIFY `id_arquivo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `atividade`
--
ALTER TABLE `atividade`
  MODIFY `id_atividade` int(11) NOT NULL AUTO_INCREMENT;

--

--
-- AUTO_INCREMENT de tabela `discussao`
--
ALTER TABLE `discussao`
  MODIFY `id_discussao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `evento`
--
ALTER TABLE `evento`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mensagem`
--
ALTER TABLE `mensagem`
  MODIFY `id_mensagem` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `presenca`
--
ALTER TABLE `presenca`
  MODIFY `id_presenca` int(11) NOT NULL AUTO_INCREMENT;

--

--


--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `arquivo`
--
ALTER TABLE `arquivo`
  ADD CONSTRAINT `arquivo_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `atividade`
--
ALTER TABLE `atividade`
  ADD CONSTRAINT `atividade_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

-- Restrições para tabelas `discussao`
--
ALTER TABLE `discussao`
  ADD CONSTRAINT `discussao_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Restrições para tabela `discussao_participante`
--
ALTER TABLE `discussao_participante`
  ADD CONSTRAINT `fk_disc_part_disc` FOREIGN KEY (`id_discussao`) REFERENCES `discussao` (`id_discussao`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_disc_part_user` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `mensagem`
--
ALTER TABLE `mensagem`
  ADD CONSTRAINT `mensagem_ibfk_1` FOREIGN KEY (`id_discussao`) REFERENCES `discussao` (`id_discussao`) ON DELETE CASCADE,
  ADD CONSTRAINT `mensagem_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `mensagem_ibfk_3` FOREIGN KEY (`resposta_id`) REFERENCES `mensagem` (`id_mensagem`) ON DELETE SET NULL;

--
-- Restrições para tabelas `presenca`
--
ALTER TABLE `presenca`
  ADD CONSTRAINT `presenca_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `presenca_ibfk_2` FOREIGN KEY (`id_atividade`) REFERENCES `atividade` (`id_atividade`) ON DELETE CASCADE;

--

-- Nota: A tabela utilizada nas páginas `index.php` e `admin/index-admin.php` é `publicacoes` (plural).
-- A estrutura singular `publicacao` foi removida por não ser utilizada no código atual.
-- Caso exista uma tabela `publicacao_imagens`, sua finalidade típica é relacionar múltiplas imagens
-- a uma única publicação (1:N), armazenando caminhos/URLs e metadados por imagem, evitando duplicação
-- de colunas na tabela principal e permitindo número variável de imagens por publicação.
COMMIT;
