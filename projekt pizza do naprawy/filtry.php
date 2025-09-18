<?php
session_start();
include "db.php";

$ingredients = $_GET['ingredients'] ?? [];
$size = $_GET['size'] ?? '';
$minPrice = $_GET['minPrice'] ?? '';
$maxPrice = $_GET['maxPrice'] ?? '';
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Filtruj pizzę</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="nav">
    <a href="index.php">⏪ Menu główne</a>
    <a href="koszyk.php">🛒 Koszyk</a>
  </div>

  <div class="filters">
    <h3>🔍 Filtruj pizzę</h3>
    <form method="GET" action="filtry.php">
      <p><strong>Składniki:</strong></p>
      <?php
      $wszystkieSkladniki = [
        "sos pomidorowy", "sos kremowy", "mozzarella", "podwójna mozzarella", "szynka",
        "pieczarki", "boczek", "cebula", "ananas", "pepperoni", "podwójna pepperoni"
      ];
      foreach ($wszystkieSkladniki as $s) {
        $checked = in_array($s, $ingredients) ? "checked" : "";
        echo "<label><input type='checkbox' name='ingredients[]' value='$s' $checked> $s</label><br>";
      }
      ?>
      <br>
      <label>Rozmiar:
        <select name="size">
          <option value="">Dowolny</option>
          <option value="mały" <?= $size === "mały" ? "selected" : "" ?>>Mały</option>
          <option value="średni" <?= $size === "średni" ? "selected" : "" ?>>Średni</option>
          <option value="duży" <?= $size === "duży" ? "selected" : "" ?>>Duży</option>
        </select>
      </label>
      <br><br>
      <label>Cena od: <input type="number" name="minPrice" step="1" value="<?= htmlspecialchars($minPrice) ?>"></label><br>
      <label>do: <input type="number" name="maxPrice" step="1" value="<?= htmlspecialchars($maxPrice) ?>"></label>
      <br><br>
      <button type="submit">Szukaj</button>
    </form>
  </div>

  <div class="content">
    <h2 style="text-align:center;">🍕 Wyniki wyszukiwania</h2>
    <div style="display:flex; flex-wrap: wrap; justify-content:center;">
      <?php
      $sql = "SELECT * FROM pizza WHERE 1=1";

      if (!empty($ingredients)) {
        foreach ($ingredients as $ing) {
          $safeIng = $conn->real_escape_string($ing);
          $sql .= " AND skladniki LIKE '%$safeIng%'";
        }
      }

      if ($size !== '') {
        $safeSize = $conn->real_escape_string($size);
        $sql .= " AND rozmiar = '$safeSize'";
      }

      if ($minPrice !== '') {
        $sql .= " AND cena >= " . (int)$minPrice;
      }

      if ($maxPrice !== '') {
        $sql .= " AND cena <= " . (int)$maxPrice;
      }

      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<div class='pizza'>";
          echo "<h3>" . htmlspecialchars($row['nazwa']) . "</h3>";
          echo "<p>Rozmiar: " . $row['rozmiar'] . "</p>";
          echo "<p>Cena: " . $row['cena'] . " zł</p>";
          echo "<form method='POST' action='koszyk.php'>";
          echo "<input type='hidden' name='pizza_id' value='" . $row['id'] . "'>";
          echo "<input type='hidden' name='qty' value='1'>";
          echo "<button type='submit'>➕ Dodaj do koszyka</button>";
          echo "</form>";
          echo "<a href='pizza.php?id=" . $row['id'] . "'>Szczegóły</a>";
          echo "</div>";
        }
      } else {
        echo "<p style='text-align:center;'>Brak wyników.</p>";
      }
      ?>
    </div>
  </div>
</body>
</html>
