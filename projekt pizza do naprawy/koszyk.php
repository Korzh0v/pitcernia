<?php
session_start();
include "db.php";

// Dodanie do koszyka (z formularza z innych stron)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pizza_id'])) {
  $id = (int)$_POST['pizza_id'];
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

// Usuwanie pizzy z koszyka
if (isset($_GET['remove'])) {
  $idToRemove = (int)$_GET['remove'];
  unset($_SESSION['cart'][$idToRemove]);
  header("Location: koszyk.php");
  exit;
}

// Aktualizacja ilości
if (isset($_POST['update'])) {
  foreach ($_POST['qty'] as $id => $qty) {
    $qty = (int)$qty;
    if ($qty > 0) {
      $_SESSION['cart'][$id] = $qty;
    } else {
      unset($_SESSION['cart'][$id]);
    }
  }
  header("Location: koszyk.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Koszyk</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="nav">
    <a href="index.php">⏪ Menu</a>
  </div>

  <div class="content">
    <h2 style="text-align:center;">🛒 Twój koszyk</h2>

    <form method="POST">
      <table>
        <tr>
          <th>Pizza</th>
          <th>Cena</th>
          <th>Ilość</th>
          <th>Suma</th>
          <th>Usuń</th>
        </tr>
        <?php
        $total = 0;
        if (!empty($_SESSION['cart'])) {
          foreach ($_SESSION['cart'] as $id => $qty) {
            $result = $conn->query("SELECT * FROM pizza WHERE id = " . (int)$id);
            if ($row = $result->fetch_assoc()) {
              $sum = $row['cena'] * $qty;
              $total += $sum;
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['nazwa']) . "</td>";
              echo "<td>" . $row['cena'] . " zł</td>";
              echo "<td><input type='number' name='qty[$id]' value='$qty' min='1'></td>";
              echo "<td>" . $sum . " zł</td>";
              echo "<td><a href='koszyk.php?remove=$id'>🗑️</a></td>";
              echo "</tr>";
            }
          }
          echo "<tr><td colspan='3'><strong>Razem:</strong></td><td colspan='2'><strong>$total zł</strong></td></tr>";
        } else {
          echo "<tr><td colspan='5'>Koszyk jest pusty.</td></tr>";
        }
        ?>
      </table>
      <br>
      <?php if (!empty($_SESSION['cart'])): ?>
        <div style="text-align:center;">
          <button type="submit" name="update">Zaktualizuj koszyk</button>
        </div>
      <?php endif; ?>
    </form>
  </div>
</body>
</html>
