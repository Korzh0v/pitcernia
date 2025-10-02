<?php
session_start();
include "db.php";

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