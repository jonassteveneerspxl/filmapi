-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 23 mrt 2026 om 18:46
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `filmapi`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `films`
--

CREATE TABLE `films` (
  `id` int(11) NOT NULL,
  `titel` varchar(255) NOT NULL,
  `type` enum('film','serie') NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `jaar` year(4) DEFAULT NULL,
  `beoordeling` tinyint(4) DEFAULT NULL CHECK (`beoordeling` between 1 and 10),
  `bekeken` tinyint(1) DEFAULT 0,
  `aangemaakt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `films`
--

INSERT INTO `films` (`id`, `titel`, `type`, `genre`, `jaar`, `beoordeling`, `bekeken`, `aangemaakt`) VALUES
(2, 'Inception', 'film', 'Sci-Fi', '2010', 9, 1, '2026-03-23 17:19:38'),
(3, 'The Last of Us', 'serie', 'Drama', '2023', 9, 0, '2026-03-23 17:19:38'),
(4, 'Interstellar', 'film', 'Sci-Fi', '2014', 8, 1, '2026-03-23 17:19:38'),
(5, 'The Dark Knight', 'film', 'Actie', '2008', 10, 1, '2026-03-23 17:41:22'),
(6, 'the vow', 'film', 'drama', '2011', 10, 1, '2026-03-23 17:42:58');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `films`
--
ALTER TABLE `films`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
