<?php
session_start();
$conn = new mysqli("localhost", "root", "", "pizzeria");
if ($conn->connect_error) {
    die("Błąd połączenia");
}

$sql = "SELECT zamowienia.id, zamowienia.data_zamowienia AS `zamowienie_data`, klient.nazwa AS `klient_nazwa`, pizza.nazwa AS `pizza_nazwa`, zamowienie_pizza.ilosc, pizza.cena, zamowienia.wykonane FROM zamowienia JOIN klient ON zamowienia.id_klient = klient.id JOIN zamowienie_pizza zamowienie_pizza ON zamowienia.id = zamowienie_pizza.id_zamowienia JOIN pizza ON zamowienie_pizza.id_pizza = pizza.id ORDER BY zamowienia.id;";
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
<h2>HISTORIA ZAMÓWIEŃ</h2>
<table>
    <tr>
        <th>Nr. zamówienia</th>
        <th>Data</th>
        <th>Klient</th>
        <th>Pizza</th>
        <th>Ilość</th>
        <th>Cena pizzy</th>
        <th>Łączna cena</th>
        <th>Wykonane?</th>
    </tr>
    <?php $lacznie_wydano = 0;
    while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['zamowienie_data'] ?></td>
        <td><?= $row['klient_nazwa'] ?></td>
        <td><?= $row['pizza_nazwa'] ?></td>
        <td><?= $row['ilosc'] ?></td>
        <td><?= $row['cena'] ?> zł</td>
        <td><?= $row['ilosc'] * $row['cena'] ?> zł</td>
        <td><?= $row['wykonane'] ?></td>
        <?php $lacznie_wydano +=  $row['ilosc'] * $row['cena'] ?>
    </tr>
    <?php } ?>
</table>
<h3>Łącznie wydano: <?php echo $lacznie_wydano ?>zł</h3>
<?php $conn->close(); ?>
</body>
</html>