-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Wrz 21, 2025 at 07:12 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pitceria`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `haslo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klient`
--

CREATE TABLE `klient` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `haslo` varchar(50) NOT NULL,
  `adres` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pizza`
--

CREATE TABLE `pizza` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(50) NOT NULL,
  `rozmiar` varchar(10) NOT NULL,
  `cena` int(11) NOT NULL,
  `skladniki` varchar(255) NOT NULL,
  `opis` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pizza`
--

INSERT INTO `pizza` (`id`, `nazwa`, `rozmiar`, `cena`, `skladniki`, `opis`) VALUES
(1, 'Margherita', 'mały', 20, 'sos pomidorowy, podwójna mozzarella', 'Pizza Margherita to klasyka włoskiej kuchni. Prosta, ale pełna smaku — sos pomidorowy i podwójna porcja kremowej mozzarelli na chrupiącym cieście.'),
(2, '4 Cheese', 'duży', 36, 'sos kremowy, mozzarella, boczek, pieczarki, cebula', 'Pizza 4 Cheese to połączenie czterech serów na kremowym sosie z dodatkiem boczku, pieczarek i cebuli. Idealna dla miłośników serowego smaku.'),
(3, 'Pepperoni', 'duży', 35, 'sos pomidorowy, podwójna mozzarella, podwójna pepperoni', 'Pizza Pepperoni to pikantna uczta dla miłośników intensywnych smaków. Podwójna porcja kiełbasy pepperoni, mozzarella i sos pomidorowy tworzą wyrazisty zestaw.'),
(4, 'Diavola', 'duży', 37, 'sos pomidorowy, mozzarella, kiełbasa pepperoni, cebula, papryczki jalapeno', 'Diavola to pikantna pizza dla fanów mocniejszych smaków. Kiełbasa pepperoni, jalapeno i aromatyczny sos pomidorowy tworzą ogniste połączenie.'),
(5, 'Capricciosa', 'mały', 24, 'sos pomidorowy, mozzarella, szynka, pieczarki', 'Pizza Capricciosa to jedna z najpopularniejszych kompozycji. Składa się z aromatycznego sosu pomidorowego, kremowej mozzarelli, delikatnej szynki i świeżych pieczarek.'),
(6, 'Carbonara', 'średni', 30, 'sos kremowy, mozzarella, boczek, pieczarki, cebula', 'Pizza Carbonara to połączenie klasycznej włoskiej carbonary z pizzą. Kremowy sos, chrupiący boczek, pieczarki i cebula tworzą wyjątkowy smak.'),
(7, 'Hawajska', 'średni', 29, 'sos pomidorowy, mozzarella, szynka, ananas', 'Pizza Hawajska to kontrowersyjna, ale uwielbiana propozycja. Słodki ananas idealnie komponuje się z szynką, mozzarellą i pomidorowym sosem.'),
(8, 'Vegetariana', 'mały', 28, 'sos pomidorowy, mozzarella, kukurydza, pomidorki koktajlowe, papryka, cebula, oregano', 'Vegetariana to kolorowa pizza pełna świeżych warzyw i aromatycznych przypraw. Idealna dla miłośników warzyw i lekkiego smaku.');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `id` int(11) NOT NULL,
  `id_klient` int(11) NOT NULL,
  `id_pizza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `klient`
--
ALTER TABLE `klient`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `pizza`
--
ALTER TABLE `pizza`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `klient`
--
ALTER TABLE `klient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pizza`
--
ALTER TABLE `pizza`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
