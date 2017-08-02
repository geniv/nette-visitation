-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vytvořeno: Stř 02. srp 2017, 10:05
-- Verze serveru: 10.0.29-MariaDB-0ubuntu0.16.04.1
-- Verze PHP: 7.0.18-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `zdimericka`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `zdm_visitation`
--

CREATE TABLE `zdm_visitation` (
  `id` int(11) NOT NULL,
  `id_locale` int(11) DEFAULT NULL,
  `telemail` varchar(100) DEFAULT NULL,
  `added` datetime DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='prohlidky';

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `zdm_visitation`
--
ALTER TABLE `zdm_visitation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_visitation_zdm_locale_idx` (`id_locale`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `zdm_visitation`
--
ALTER TABLE `zdm_visitation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `zdm_visitation`
--
ALTER TABLE `zdm_visitation`
  ADD CONSTRAINT `fk_visitation_locale` FOREIGN KEY (`id_locale`) REFERENCES `zdm_locale` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
