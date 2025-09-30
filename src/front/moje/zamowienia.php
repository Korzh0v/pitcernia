<?php
$conn = new mysqli("localhost", "root", "", "pizzeria");
if ($conn->connect_error) {
    die("Błąd połączenia");
}

$sql = "SELECT 
            klient.nazwa AS klient_nazwa, pizza.nazwa AS pizza_nazwa, pizza.cena, zamowienia.ilosc, zamowienia.id, zamowienia.id_klient, zamowienia.id_pizza FROM zamowienia JOIN klient ON klient.id = zamowienia.id_klient JOIN pizza ON pizza.id = zamowienia.id_pizza WHERE zamowienia.wykonane = 0";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>pitceria</title>
    <style>
        table, th, td {
        border: 1px solid;
        }
    </style>
</head>
<body>
<hr>
<h2>AKTYWNE ZAMÓWIENIA</h2>
<table>
    <tr>
        <th>Nr. zamówienia</th>
        <th>Klient</th>
        <th>Pizza</th>
        <th>Ilość</th>
        <th>Cena pizzy</th>
        <th>Łączna cena</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['klient_nazwa'] ?></td>
        <td><?= $row['pizza_nazwa'] ?></td>
        <td><?= $row['ilosc'] ?></td>
        <td><?= $row['cena'] ?> zł</td>
        <td><?= $row['ilosc'] * $row['cena'] ?> zł</td>
    </tr>
    <?php } ?>
</table>
<?php $conn->close(); ?>
</body>
</html>