-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 26, 2020 alle 13:03
-- Versione del server: 10.4.17-MariaDB
-- Versione PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gelateria`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `carrello`
--

CREATE TABLE `carrello` (
  `email_user` varchar(50) NOT NULL,
  `nome_item` varchar(20) NOT NULL,
  `grandezza` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `carrello`
--

INSERT INTO `carrello` (`email_user`, `nome_item`, `grandezza`) VALUES
('user@gmail.com', 'cioccocake', 'piccola');

-- --------------------------------------------------------

--
-- Struttura della tabella `category`
--

CREATE TABLE `category` (
  `nome` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `category`
--

INSERT INTO `category` (`nome`) VALUES
('gelato'),
('torta');

-- --------------------------------------------------------

--
-- Struttura della tabella `item`
--

CREATE TABLE `item` (
  `nome` varchar(20) NOT NULL,
  `descrizione` varchar(500) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `nome_category` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `item`
--

INSERT INTO `item` (`nome`, `descrizione`, `foto`, `nome_category`) VALUES
('albicocca', 'Gelato con polpa di albicocche fresche.', 'img/albicocca.jpeg', 'gelato'),
('arancia rossa', 'Delicato gelato ottenuto dalla spremitura di polpa d’arancia rossa.', 'img/arancia_rossa.jpeg', 'gelato'),
('cioccocake', 'Cremoso pan di Spagna al cacao e semifreddo al bacio racchiudono un’anima di cioccolato e nocciole.', 'img/cioccocake.jpeg', 'torta');

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

CREATE TABLE `user` (
  `email` varchar(100) NOT NULL,
  `ursname` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`email`, `ursname`, `password`, `admin`) VALUES
('admi@gmail.com', 'admin', 'admin', 1),
('user@gmail.com', 'user', 'user', 0);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `carrello`
--
ALTER TABLE `carrello`
  ADD PRIMARY KEY (`email_user`,`nome_item`),
  ADD KEY `nome_item` (`nome_item`);

--
-- Indici per le tabelle `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`nome`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indici per le tabelle `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`nome`),
  ADD UNIQUE KEY `nome` (`nome`),
  ADD KEY `nome_category` (`nome_category`);

--
-- Indici per le tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `carrello`
--
ALTER TABLE `carrello`
  ADD CONSTRAINT `carrello_ibfk_1` FOREIGN KEY (`email_user`) REFERENCES `user` (`email`),
  ADD CONSTRAINT `carrello_ibfk_2` FOREIGN KEY (`nome_item`) REFERENCES `item` (`nome`);

--
-- Limiti per la tabella `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`nome_category`) REFERENCES `category` (`nome`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
