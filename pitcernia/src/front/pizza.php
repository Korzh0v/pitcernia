<?php
include "db.php";

if (!isset($_GET['nazwa'])) {
    die("Brak pizzy");
}
$nazwa = $conn->real_escape_string($_GET['nazwa']);

$sql = "SELECT * FROM pizza WHERE nazwa='$nazwa' ORDER BY FIELD(rozmiar, 'mały','średni','duży')";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    die("Pizza nie istnieje");
}

$pizze = [];
while ($row = $result->fetch_assoc()) {
    $pizze[] = $row;
}

$pizza = $pizze[0];
?>

<h2><?php echo htmlspecialchars($pizza['nazwa']); ?></h2>
<img src="/pitcernia/public/img/<?php echo htmlspecialchars($pizza['obrazek']); ?>" width="300"><br>
<p>Składniki: <?php echo htmlspecialchars($pizza['skladniki']); ?></p>
<p>Opis: <?php echo htmlspecialchars($pizza['opis']); ?></p>

<h3>Rozmiary i ceny</h3>
<ul>
<?php
foreach ($pizze as $p) {
    $cm = "";
    if ($p['rozmiar']=="mały") $cm = "24cm";
    if ($p['rozmiar']=="średni") $cm = "32cm";
    if ($p['rozmiar']=="duży") $cm = "40cm";

    echo "<li>" . $p['rozmiar'] . " ($cm) - " . $p['cena'] . " zł 
        <button onclick=\"addToCart('".htmlspecialchars($p['nazwa'])."','".$p['rozmiar']."',".$p['cena'].")\">
            Dodaj do koszyka
        </button>
    </li>";
}
?>
</ul>

<br>
<a href="strona internetowa.php">Powrót do menu</a>
