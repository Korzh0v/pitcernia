-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Paź 02, 2025 at 12:06 PM
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
-- Database: `pizzeria`
--

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
  `opis` text NOT NULL,
  `obrazek` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pizza`
--

INSERT INTO `pizza` (`id`, `nazwa`, `rozmiar`, `cena`, `skladniki`, `opis`, `obrazek`) VALUES
(1, 'Margherita', 'mały', 20, 'sos pomidorowy, podwójna mozzarella', 'Pizza Margherita to klasyka włoskiej kuchni. Prosta, ale pełna smaku — sos pomidorowy i podwójna porcja kremowej mozzarelli na chrupiącym cieście.', 'pizza_margaritta.jpg'),
(2, 'Margherita', 'średni', 23, 'sos pomidorowy, podwójna mozzarella', 'Pizza Margherita to klasyka włoskiej kuchni. Prosta, ale pełna smaku — sos pomidorowy i podwójna porcja kremowej mozzarelli na chrupiącym cieście.', 'pizza_margaritta.jpg'),
(3, 'Margherita', 'duży', 27, 'sos pomidorowy, podwójna mozzarella', 'Pizza Margherita to klasyka włoskiej kuchni. Prosta, ale pełna smaku — sos pomidorowy i podwójna porcja kremowej mozzarelli na chrupiącym cieście.', 'pizza_margaritta.jpg'),
(4, '4 Cheese', 'mały', 22, 'sos kremowy, mozzarella, boczek, pieczarki, cebula', 'Pizza 4 Cheese to połączenie czterech serów na kremowym sosie z dodatkiem boczku, pieczarek i cebuli. Idealna dla miłośników serowego smaku.', '4sery.jpg'),
(5, '4 Cheese', 'średni', 25, 'sos kremowy, mozzarella, boczek, pieczarki, cebula', 'Pizza 4 Cheese to połączenie czterech serów na kremowym sosie z dodatkiem boczku, pieczarek i cebuli. Idealna dla miłośników serowego smaku.', '4sery.jpg'),
(6, '4 Cheese', 'duży', 28, 'sos kremowy, mozzarella, boczek, pieczarki, cebula', 'Pizza 4 Cheese to połączenie czterech serów na kremowym sosie z dodatkiem boczku, pieczarek i cebuli. Idealna dla miłośników serowego smaku.', '4sery.jpg'),
(7, 'Pepperoni', 'mały', 24, 'sos pomidorowy, podwójna mozzarella, podwójna pepperoni', 'Pizza Pepperoni to pikantna uczta dla miłośników intensywnych smaków. Podwójna porcja kiełbasy pepperoni, mozzarella i sos pomidorowy tworzą wyrazisty zestaw.', 'peperoni.jpg'),
(8, 'Pepperoni', 'średni', 28, 'sos pomidorowy, podwójna mozzarella, podwójna pepperoni', 'Pizza Pepperoni to pikantna uczta dla miłośników intensywnych smaków. Podwójna porcja kiełbasy pepperoni, mozzarella i sos pomidorowy tworzą wyrazisty zestaw.', 'peperoni.jpg'),
(9, 'Pepperoni', 'duży', 31, 'sos pomidorowy, podwójna mozzarella, podwójna pepperoni', 'Pizza Pepperoni to pikantna uczta dla miłośników intensywnych smaków. Podwójna porcja kiełbasy pepperoni, mozzarella i sos pomidorowy tworzą wyrazisty zestaw.', 'peperoni.jpg'),
(10, 'Diavola', 'mały', 25, 'sos pomidorowy, mozzarella, kiełbasa pepperoni, cebula, papryczki jalapeno', 'Diavola to pikantna pizza dla fanów mocniejszych smaków. Kiełbasa pepperoni, jalapeno i aromatyczny sos pomidorowy tworzą ogniste połączenie.', 'diavola.jpg'),
(11, 'Diavola', 'średni', 29, 'sos pomidorowy, mozzarella, kiełbasa pepperoni, cebula, papryczki jalapeno', 'Diavola to pikantna pizza dla fanów mocniejszych smaków. Kiełbasa pepperoni, jalapeno i aromatyczny sos pomidorowy tworzą ogniste połączenie.', 'diavola.jpg'),
(12, 'Diavola', 'duży', 33, 'sos pomidorowy, mozzarella, kiełbasa pepperoni, cebula, papryczki jalapeno', 'Diavola to pikantna pizza dla fanów mocniejszych smaków. Kiełbasa pepperoni, jalapeno i aromatyczny sos pomidorowy tworzą ogniste połączenie.', 'diavola.jpg'),
(13, 'Capricciosa', 'mały', 24, 'sos pomidorowy, mozzarella, szynka, pieczarki', 'Pizza Capricciosa to jedna z najpopularniejszych kompozycji. Składa się z aromatycznego sosu pomidorowego, kremowej mozzarelli, delikatnej szynki i świeżych pieczarek.', 'capriciosa.jpg'),
(14, 'Capricciosa', 'średni', 28, 'sos pomidorowy, mozzarella, szynka, pieczarki', 'Pizza Capricciosa to jedna z najpopularniejszych kompozycji. Składa się z aromatycznego sosu pomidorowego, kremowej mozzarelli, delikatnej szynki i świeżych pieczarek.', 'capriciosa.jpg'),
(15, 'Capricciosa', 'duży', 31, 'sos pomidorowy, mozzarella, szynka, pieczarki', 'Pizza Capricciosa to jedna z najpopularniejszych kompozycji. Składa się z aromatycznego sosu pomidorowego, kremowej mozzarelli, delikatnej szynki i świeżych pieczarek.', 'capriciosa.jpg'),
(16, 'Carbonara', 'mały', 26, 'sos kremowy, mozzarella, boczek, pieczarki, cebula', 'Pizza Carbonara to połączenie klasycznej włoskiej carbonary z pizzą. Kremowy sos, chrupiący boczek, pieczarki i cebula tworzą wyjątkowy smak.', 'carbonara.jpg'),
(17, 'Carbonara', 'średni', 29, 'sos kremowy, mozzarella, boczek, pieczarki, cebula', 'Pizza Carbonara to połączenie klasycznej włoskiej carbonary z pizzą. Kremowy sos, chrupiący boczek, pieczarki i cebula tworzą wyjątkowy smak.', 'carbonara.jpg'),
(18, 'Carbonara', 'duży', 32, 'sos kremowy, mozzarella, boczek, pieczarki, cebula', 'Pizza Carbonara to połączenie klasycznej włoskiej carbonary z pizzą. Kremowy sos, chrupiący boczek, pieczarki i cebula tworzą wyjątkowy smak.', 'carbonara.jpg'),
(19, 'Hawajska', 'mały', 27, 'sos pomidorowy, mozzarella, szynka, ananas', 'Pizza Hawajska to kontrowersyjna, ale uwielbiana propozycja. Słodki ananas idealnie komponuje się z szynką, mozzarellą i pomidorowym sosem.', 'hawajska.jpg'),
(20, 'Hawajska', 'średni', 30, 'sos pomidorowy, mozzarella, szynka, ananas', 'Pizza Hawajska to kontrowersyjna, ale uwielbiana propozycja. Słodki ananas idealnie komponuje się z szynką, mozzarellą i pomidorowym sosem.', 'hawajska.jpg'),
(21, 'Hawajska', 'duży', 32, 'sos pomidorowy, mozzarella, szynka, ananas', 'Pizza Hawajska to kontrowersyjna, ale uwielbiana propozycja. Słodki ananas idealnie komponuje się z szynką, mozzarellą i pomidorowym sosem.', 'hawajska.jpg'),
(22, 'Vegetariana', 'mały', 28, 'sos pomidorowy, mozzarella, kukurydza, pomidorki koktajlowe, papryka, cebula, oregano', 'Vegetariana to kolorowa pizza pełna świeżych warzyw i aromatycznych przypraw. Idealna dla miłośników warzyw i lekkiego smaku.', 'vege.jpg'),
(23, 'Vegetariana', 'średni', 32, 'sos pomidorowy, mozzarella, kukurydza, pomidorki koktajlowe, papryka, cebula, oregano', 'Vegetariana to kolorowa pizza pełna świeżych warzyw i aromatycznych przypraw. Idealna dla miłośników warzyw i lekkiego smaku.', 'vege.jpg'),
(24, 'Vegetariana', 'duży', 35, 'sos pomidorowy, mozzarella, kukurydza, pomidorki koktajlowe, papryka, cebula, oregano', 'Vegetariana to kolorowa pizza pełna świeżych warzyw i aromatycznych przypraw. Idealna dla miłośników warzyw i lekkiego smaku.', 'vege.jpg');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `pizza`
--
ALTER TABLE `pizza`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pizza`
--
ALTER TABLE `pizza`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
