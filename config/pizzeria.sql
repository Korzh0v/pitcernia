-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Жов 04 2025 р., 17:24
-- Версія сервера: 10.4.32-MariaDB
-- Версія PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `pizzeria`
--

-- --------------------------------------------------------

--
-- Структура таблиці `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `haslo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `klient`
--

CREATE TABLE `klient` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `haslo` varchar(255) NOT NULL,
  `adres` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `klient`
--

INSERT INTO `klient` (`id`, `nazwa`, `email`, `haslo`, `adres`) VALUES
(1, '2131231', 'asdasd@gmail.com', '$2y$10$PHFbG0zyqp4K6FfKOINZ5eCCeOEeqVDDACdBTQUalNu', 'asdakkdalkcwww'),
(2, 'asyvfasvfaeyfa', 'jasbvfajfvvfu@gmail.com', 'isgfuavfausvfuf', 'tulipanowa 9'),
(3, 'acc1', 'oliverberg827@gmail.com', '$2y$10$bGSk7gcKQU52awc0g8Tz8eJYvfzZCCo7OmMKeReVo2SAqa.ULFag2', 'ul.asdsakdmaksdm1');

-- --------------------------------------------------------

--
-- Структура таблиці `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token_hash` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `password_resets`
--

INSERT INTO `password_resets` (`id`, `user_id`, `token_hash`, `expires_at`, `created_at`) VALUES
(1, 3, '4e01b8182fd2ed74f5dcd418c1c6dcb7a7a3cd1613f5f67f576d046c3b95c3b3', '2025-10-04 18:19:39', '2025-10-04 15:19:39');

-- --------------------------------------------------------

--
-- Структура таблиці `pizza`
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
-- Дамп даних таблиці `pizza`
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

-- --------------------------------------------------------

--
-- Структура таблиці `zamowienia`
--

CREATE TABLE `zamowienia` (
  `id` int(11) NOT NULL,
  `id_klient` int(11) NOT NULL,
  `id_pizza` int(11) NOT NULL,
  `ilosc` int(11) NOT NULL,
  `wykonane` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `zamowienia`
--

INSERT INTO `zamowienia` (`id`, `id_klient`, `id_pizza`, `ilosc`, `wykonane`) VALUES
(1, 1, 1, 2, 0),
(3, 2, 1, 3, 0),
(4, 2, 1, 5, 1),
(5, 2, 1, 5, 1);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `klient`
--
ALTER TABLE `klient`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Індекси таблиці `pizza`
--
ALTER TABLE `pizza`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `klient`
--
ALTER TABLE `klient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблиці `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблиці `pizza`
--
ALTER TABLE `pizza`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблиці `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `fk_password_resets_user` FOREIGN KEY (`user_id`) REFERENCES `klient` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
