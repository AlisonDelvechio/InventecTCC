-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 02-Jul-2020 às 21:22
-- Versão do servidor: 10.4.10-MariaDB
-- versão do PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_tcc`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_historicos`
--

DROP TABLE IF EXISTS `tb_historicos`;
CREATE TABLE IF NOT EXISTS `tb_historicos` (
  `idHistorico` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuarioTela` varchar(50) NOT NULL,
  `dataInclusaoHistorico` datetime NOT NULL DEFAULT current_timestamp(),
  `operacao` varchar(2) NOT NULL,
  `atividade` longtext NOT NULL,
  `idPessoa` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`idHistorico`),
  KEY `idPessoaHist_idx` (`idPessoa`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_historicos`
--

INSERT INTO `tb_historicos` (`idHistorico`, `usuarioTela`, `dataInclusaoHistorico`, `operacao`, `atividade`, `idPessoa`) VALUES
(1, 'Teste', '2020-07-02 18:20:06', 'I', 'O usuÃ¡rio <b>Teste</b> cadastrou o usuÃ¡rio <b>Admin</b> com e-mail <b>administrador@gmail.com</b>', 1),
(2, 'Admin', '2020-07-02 18:20:51', 'I', 'O usuÃ¡rio <b>Admin</b> cadastrou o usuÃ¡rio <b>Funcionario</b> com e-mail <b>funcionario@gmail.com</b>', 2),
(3, 'Admin', '2020-07-02 18:21:07', 'I', 'O usuÃ¡rio <b>Admin</b> cadastrou o local <b>Sala 2</b> no bloco <b>Bloco 1</b>', 1),
(4, 'Admin', '2020-07-02 18:21:21', 'I', 'O usuÃ¡rio <b>Admin</b> cadastrou o patrimÃ´nio <b>Teste 1</b> no local <b>Sala 2</b>', 1),
(5, 'Admin', '2020-07-02 18:22:27', 'D', 'O usuÃ¡rio <b>Admin</b> excluiu o local <b>Sala 2</b>', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_locais`
--

DROP TABLE IF EXISTS `tb_locais`;
CREATE TABLE IF NOT EXISTS `tb_locais` (
  `idLocal` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomeLocal` varchar(50) NOT NULL,
  `blocoLocal` varchar(50) NOT NULL,
  `descricaoLocal` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`idLocal`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_patrimonios`
--

DROP TABLE IF EXISTS `tb_patrimonios`;
CREATE TABLE IF NOT EXISTS `tb_patrimonios` (
  `idPatrimonio` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomePatrimonio` varchar(50) NOT NULL,
  `numeroPatrimonio` char(11) NOT NULL,
  `pertencentePatrimonio` varchar(50) NOT NULL,
  `statusPatrimonio` varchar(20) NOT NULL,
  `dataPatrimonio` date NOT NULL,
  `descricaoPatrimonio` varchar(150) DEFAULT NULL,
  `idLocal` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`idPatrimonio`),
  KEY `idLocal_idx` (`idLocal`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_pessoas`
--

DROP TABLE IF EXISTS `tb_pessoas`;
CREATE TABLE IF NOT EXISTS `tb_pessoas` (
  `idPessoa` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nomePessoa` varchar(50) NOT NULL,
  `dataInclusaoPessoa` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`idPessoa`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_pessoas`
--

INSERT INTO `tb_pessoas` (`idPessoa`, `nomePessoa`, `dataInclusaoPessoa`) VALUES
(1, 'Administrador', '2020-07-02 18:20:06'),
(2, 'Funcionario', '2020-07-02 18:20:51');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuarios`
--

DROP TABLE IF EXISTS `tb_usuarios`;
CREATE TABLE IF NOT EXISTS `tb_usuarios` (
  `idUsuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `loginUsuario` varchar(50) NOT NULL,
  `emailUsuario` varchar(100) NOT NULL,
  `senhaUsuario` varchar(50) NOT NULL,
  `dataInclusaoUsuario` datetime NOT NULL DEFAULT current_timestamp(),
  `idPessoa` int(10) UNSIGNED NOT NULL,
  `tipoAcesso` varchar(4) NOT NULL,
  PRIMARY KEY (`idUsuario`),
  KEY `idPessoasUs_idx` (`idPessoa`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_usuarios`
--

INSERT INTO `tb_usuarios` (`idUsuario`, `loginUsuario`, `emailUsuario`, `senhaUsuario`, `dataInclusaoUsuario`, `idPessoa`, `tipoAcesso`) VALUES
(4, 'Admin', 'administrador@gmail.com', '111111', '2020-07-02 18:20:06', 1, 'ADM'),
(5, 'Funcionario', 'funcionario@gmail.com', '111111', '2020-07-02 18:20:51', 2, 'FUN');

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tb_historicos`
--
ALTER TABLE `tb_historicos`
  ADD CONSTRAINT `fk_historicos_pessoas_idPessoa` FOREIGN KEY (`idPessoa`) REFERENCES `tb_pessoas` (`idPessoa`);

--
-- Limitadores para a tabela `tb_patrimonios`
--
ALTER TABLE `tb_patrimonios`
  ADD CONSTRAINT `fk_patrimonio_local_idLocal` FOREIGN KEY (`idLocal`) REFERENCES `tb_locais` (`idLocal`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
  ADD CONSTRAINT `fk_usuarios_pessoas_idPessoa` FOREIGN KEY (`idPessoa`) REFERENCES `tb_pessoas` (`idPessoa`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
