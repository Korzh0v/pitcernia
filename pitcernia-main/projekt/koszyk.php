<?php
include "db.php";
session_start();

if (isset($_GET['usun'])){
    $id = (int)$_GET['usun'];
    unset($_SESSION['koszyk'][$id]);
    header("Location: koszyk.php");
    exit;
}

if (isset($_POST['aktualizuj'])){
    foreach ($_POST['ilosc'] as $id => $ilosc) {
        $ilosc = (int)$ilosc;
        if ($ilosc < 1) $ilosc = 1;
        $_SESSION['koszyk'][$id] = $ilosc;
    }
    header("Location: koszyk.php");
    exit;
}
?>
<html>
<head>
<title>Koszyk</title>
</head>
<body>

<h2>Twój koszyk</h2>

<?php
$total = 0;

if (isset($_SESSION['koszyk']) && count($_SESSION['koszyk']) > 0){
    echo "<form method='POST'>";
    echo "<table border='1' cellpadding='5'><tr><th>Pizza</th><th>Cena</th><th>Ilość</th><th>Suma</th><th>Usuń</th></tr>";

    foreach ($_SESSION['koszyk'] as $id => $ilosc){
        $sql = "SELECT * FROM pizza WHERE id=$id";
        $wynik = $conn->query($sql);
        if ($wynik->num_rows > 0) {
            $pizza = $wynik->fetch_assoc();
            $suma = $pizza['cena'] * $ilosc;
            $total += $suma;

            echo "<tr>";
            echo "<td>".$pizza['nazwa']."</td>";
            echo "<td>".$pizza['cena']."</td>";
            echo "<td><input type='number' name='ilosc[$id]' value='$ilosc' min='1'></td>";
            echo "<td>".$suma."</td>";
            echo "<td><a href='koszyk.php?usun=$id'>Usuń</a></td>";
            echo "</tr>";
        }
    }

    echo "<tr><td colspan='3'>Razem</td><td colspan='2'>$total</td></tr>";
    echo "</table><br>";
    echo "<input type='submit' name='aktualizuj' value='Aktualizuj koszyk'>";
    echo "</form>";

} else {
    echo "<p>Koszyk jest pusty</p>";
}
?>

<br>
<a href="index.php">Powrót do menu</a>



</body>
</html>