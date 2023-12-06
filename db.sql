-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 29-Nov-2023 às 02:13
-- Versão do servidor: 5.7.36
-- versão do PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "-03:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `transportes`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nm_cliente` varchar(100) DEFAULT NULL,
  `ds_nome_fantasia` varchar(100) DEFAULT NULL,
  `ds_razao_social` varchar(100) DEFAULT NULL,
  `ds_tipo_pessoa` varchar(4) NOT NULL,
  `nr_cpf_cnpj` varchar(20) NOT NULL,
  `cd_registro` int(11) NOT NULL,
  `ie_isento_ins_est` tinyint(1) NOT NULL DEFAULT '0',
  `nr_inscricao_est` varchar(15) DEFAULT NULL,
  `nr_inscricao_mun` varchar(15) NOT NULL,
  `nr_inscricao_suframa` varchar(10) NOT NULL,
  `nr_cep` varchar(10) NOT NULL,
  `ds_endereco` varchar(120) NOT NULL,
  `nr_endereco` varchar(5) NOT NULL,
  `ds_complemento` varchar(50) DEFAULT NULL,
  `nm_bairro` varchar(30) NOT NULL,
  `nm_municipio` varchar(20) NOT NULL,
  `nm_estado` varchar(20) NOT NULL,
  `nm_pais` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
