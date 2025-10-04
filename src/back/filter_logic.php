<?php
session_start();

// Połączenie z bazą danych
$conn = new mysqli("localhost", "root", "", "pizzeria");
if ($conn->connect_error) {
    die("error" . $conn->connect_error);
}

// Obsługa filtrów
$ingredients = [];
if (isset($_GET['ingredients'])) {
    $ingredients = $_GET['ingredients'];
}

$size = "";
if (isset($_GET['size'])) {
    $size = $_GET['size'];
}

$minPrice = "";
if (isset($_GET['minPrice'])) {
    $minPrice = $_GET['minPrice'];
}

$maxPrice = "";
if (isset($_GET['maxPrice'])) {
    $maxPrice = $_GET['maxPrice'];
}

// Budowanie zapytania SQL z filtrami
$sql = "SELECT * FROM pizza WHERE TRUE";

if (!empty($ingredients)) {
    foreach ($ingredients as $ing) {
        $safe = $conn->real_escape_string($ing);
        $sql .= " AND skladniki LIKE '%$safe%'";
    }
}

if ($size != "") {
    $safe = $conn->real_escape_string($size);
    $sql .= " AND rozmiar='$safe'";
}

if ($minPrice != "") {
    $sql .= " AND cena >= " . (int)$minPrice;
}

if ($maxPrice != "") {
    $sql .= " AND cena <= " . (int)$maxPrice;
}

$result = $conn->query($sql);
$pizze = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pizze[] = $row;
    }
}

// Lista wszystkich składników
$wszystkieSkladniki = [
    "sos pomidorowy",
    "sos kremowy",
    "mozzarella",
    "podwójna mozzarella",
    "szynka",
    "pieczarki",
    "boczek",
    "cebula",
    "ananas",
    "pepperoni",
    "kukurydza",
    "pomidorki koktajlowe",
    "papryka",
    "oregano",
    "papryczki jalapeno"
];
?>