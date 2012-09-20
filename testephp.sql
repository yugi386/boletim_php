-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Set 20, 2012 as 12:41 PM
-- Versão do Servidor: 5.5.8
-- Versão do PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `testephp`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunos`
--

CREATE TABLE IF NOT EXISTS `alunos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aluno` varchar(50) NOT NULL,
  `dataNascimento` date NOT NULL,
  `matricula` varchar(15) NOT NULL,
  `endereco` varchar(70) NOT NULL,
  `bairro` varchar(50) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `sexo` varchar(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `alunos`
--

INSERT INTO `alunos` (`id`, `aluno`, `dataNascimento`, `matricula`, `endereco`, `bairro`, `cidade`, `cep`, `estado`, `sexo`) VALUES
(1, 'Marisa', '1979-03-21', '123456', 'agora', '2', '3333333', '12300-000', 'AC', 'F'),
(2, 'rafaella', '1979-03-21', '1234', '222222222222222222', '222222', '33333', '12300-123', 'AC', 'F');

-- --------------------------------------------------------

--
-- Estrutura da tabela `boletim`
--

CREATE TABLE IF NOT EXISTS `boletim` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aluno_id` int(11) NOT NULL,
  `mediaFinal` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `boletim`
--

INSERT INTO `boletim` (`id`, `aluno_id`, `mediaFinal`) VALUES
(7, 2, 6.21834),
(8, 1, 4.72222);

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplinas`
--

CREATE TABLE IF NOT EXISTS `disciplinas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `disciplina` varchar(50) NOT NULL,
  `resumo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `disciplinas`
--

INSERT INTO `disciplinas` (`id`, `disciplina`, `resumo`) VALUES
(3, 'MATEMATICA', 'Disciplina obrigatÃ³ria em todos os cursos e todos os tempos.'),
(4, 'PORTUGUES', 'PORTUGUES PORTUGUES PORTUGUES'),
(5, 'INGLES', 'NOVO INGLES NOVO INGLES NOVO INGLES'),
(6, 'FISICA', 'FÃSICA FÃSICA FÃSICA');

-- --------------------------------------------------------

--
-- Estrutura da tabela `notas`
--

CREATE TABLE IF NOT EXISTS `notas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aluno_id` int(11) NOT NULL,
  `disciplina_id` int(11) NOT NULL,
  `p1` float NOT NULL,
  `p2` float NOT NULL,
  `atividade` float NOT NULL,
  `mediaDisciplina` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `notas`
--

INSERT INTO `notas` (`id`, `aluno_id`, `disciplina_id`, `p1`, `p2`, `atividade`, `mediaDisciplina`) VALUES
(1, 1, 3, 8, 7, 6, 7),
(2, 2, 4, 2, 3, 10, 5),
(5, 2, 3, 10, 10, 10, 10),
(6, 1, 4, 1, 2, 3, 2),
(7, 2, 5, 4, 5, 3.32, 4.10667),
(8, 2, 6, 4, 5.5, 7.8, 5.76667),
(9, 1, 5, 4, 5, 6.5, 5.16667);
