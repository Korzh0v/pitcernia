<?php
include "../db.php";
session_start();

$id = 5;
$sql = "SELECT * FROM pizza WHERE id=$id";
$wynik = $conn->query($sql);

if ($wynik->num_rows==0){
    die("Pizza nie istnieje");
}

$pizza = $wynik->fetch_assoc();

if ($_SERVER['REQUEST_METHOD']=="POST"){
    $ilosc = (int)$_POST['ilosc'];
    if ($ilosc<1) $ilosc=1;
    if (!isset($_SESSION['koszyk'])) $_SESSION['koszyk'] = array();
    if (isset($_SESSION['koszyk'][$id])) $_SESSION['koszyk'][$id]+=$ilosc;
    else $_SESSION['koszyk'][$id]=$ilosc;
    header("Location: ../koszyk.php");
    exit;
}
?>

<h2><?php echo $pizza['nazwa']; ?></h2>
<img src="../img/capriciosa.jpg" width="300"><br>
<p>Rozmiar: <?php echo $pizza['rozmiar']; ?></p>
<p>Cena: <?php echo $pizza['cena']; ?> zł</p>
<p>Składniki: <?php echo $pizza['skladniki']; ?></p>
<p>Opis: <?php echo $pizza['opis']; ?></p>

<form method="POST">
Ilość: <input type="number" name="ilosc" value="1" min="1"><br><br>
<button type="submit">Dodaj do koszyka</button>
</form>

<br>
<a href="../index.php">Powrót do menu</a>
<a href="../koszyk.php">Przejdź do koszyka</a>
