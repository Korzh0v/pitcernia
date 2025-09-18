<?php
session_start();
include "db.php";

// Sprawdzenie, czy przekazano ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  die("Nieprawidłowe ID pizzy.");
}

$id = (int)$_GET['id'];
$result = $conn->query("SELECT * FROM pizza WHERE id = $id");

if ($result->num_rows === 0) {
  die("Pizza o podanym ID nie istnieje.");
}

$pizza = $result->fetch_assoc();

// Obsługa dodania do koszyka
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $qty = isset($_POST['qty']) ? max(1, (int)$_POST['qty']) : 1;

  if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
  }

  if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id] += $qty;
  } else {
    $_SESSION['cart'][$id] = $qty;
  }

  header("Location: koszyk.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($pizza['nazwa']) ?> – Szczegóły pizzy</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <div class="nav">
    <a href="index.php">⏪ Powrót</a>
    <a href="koszyk.php">🛒 Koszyk</a>
  </div>

  <div class="content" style="max-width: 600px; margin: auto; text-align: center;">
    <h2>🍕 <?= htmlspecialchars($pizza['nazwa']) ?></h2>

    <?php
      $imagePath = "img/" . $pizza['id'] . ".jpg";
      if (file_exists($imagePath)) {
        echo "<img src='$imagePath' alt='Zdjęcie pizzy' style='max-width:100%; height:auto; border-radius: 8px;'>";
      } else {
        echo "<p><em>Brak zdjęcia pizzy.</em></p>";
      }
    ?>

    <p><strong>Rozmiar:</strong> <?= htmlspecialchars($pizza['rozmiar']) ?></p>
    <p><strong>Cena:</strong> <?= $pizza['cena'] ?> zł</p>
    <p><strong>Składniki:</strong><br><?= htmlspecialchars($pizza['skladniki']) ?></p>
    <p><strong>Opis:</strong><br><?= nl2br(htmlspecialchars($pizza['opis'])) ?></p>

    <form method="POST">
      <label>Ilość:
        <input type="number" name="qty" value="1" min="1" style="width: 60px;">
      </label>
      <br><br>
      <button type="submit">➕ Dodaj do koszyka</button>
    </form>
  </div>

</body>
</html>
