<?php
include "filtr.php";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Pitcowni</title>
</head>
<body>

<h1>Menu Pitcowni</h1>
<a href="koszyk.php">Koszyk</a>

<h3>Filtry</h3>
<form method="GET">
<p>Składniki:</p>
<?php
$wszystkieSkladniki = [
    "sos pomidorowy", "sos kremowy", "mozzarella", "podwójna mozzarella",
    "szynka", "pieczarki", "boczek", "cebula", "ananas", "pepperoni",
    "kukurydza", "pomidorki koktajlowe", "papryka", "oregano", "papryczki jalapeno"
];

foreach ($wszystkieSkladniki as $s){
    $checked = "";
    if (in_array($s, $ingredients)){
        $checked = "checked";
    }
    echo "<label><input type='checkbox' name='ingredients[]' value='$s' $checked> $s</label><br>";
}
?>
<br>
<label>Rozmiar:
    <select name="size">
        <option value="">Dowolny</option>
        <option value="mały" <?php if($size=="mały") echo "selected"; ?>>Mały</option>
        <option value="średni" <?php if($size=="średni") echo "selected"; ?>>Średni</option>
        <option value="duży" <?php if($size=="duży") echo "selected"; ?>>Duży</option>
    </select>
</label><br><br>

<label>Cena (zł):</label><br>
<input type="number" name="minPrice" placeholder="Od" value="<?php echo $minPrice; ?>" style="width:70px;">
-
<input type="number" name="maxPrice" placeholder="Do" value="<?php echo $maxPrice; ?>" style="width:70px;">

<br><br>
<button type="submit">Szukaj</button>
</form>

<h2>Pizze</h2>
<div>
<?php
if (!empty($pizze)){
    $pliki = [
        "Margherita" => "pizza/margherita.php",
        "4 Cheese" => "pizza/4cheese.php",
        "Pepperoni" => "pizza/pepperoni.php",
        "Diavola" => "pizza/diavola.php",
        "Capricciosa" => "pizza/capricciosa.php",
        "Carbonara" => "pizza/carbonara.php",
        "Hawajska" => "pizza/hawajska.php",
        "Vegetariana" => "pizza/vegetariana.php"
    ];

    foreach ($pizze as $p){

        echo "<div style='border:1px solid #ccc; padding:10px; margin:10px; display:inline-block; text-align:center;'>";

        $imgFile = "";
        if ($p['nazwa']=="Margherita"){
            $imgFile = "pizza_margaritta.jpg";
        } elseif ($p['nazwa']=="4 Cheese"){
            $imgFile = "4sery.jpg";
        } elseif ($p['nazwa']=="Pepperoni"){
            $imgFile = "peperoni.jpg";
        } elseif ($p['nazwa']=="Diavola"){
            $imgFile = "diavola.jpg";
        } elseif ($p['nazwa']=="Capricciosa"){
            $imgFile = "capriciosa.jpg";
        } elseif ($p['nazwa']=="Carbonara"){
            $imgFile = "carbonara.jpg";
        } elseif ($p['nazwa']=="Hawajska"){
            $imgFile = "hawajska.jpg";
        } elseif ($p['nazwa']=="Vegetariana"){
            $imgFile = "vege.jpg";
        }

        if ($imgFile!="" && file_exists("img/".$imgFile)){
            echo "<img src='img/$imgFile' style='max-width:150px'><br>";
        } else {
            echo "<p>Brak zdjęcia</p>";
        }

        echo $p['nazwa']."<br>";
        echo "Rozmiar: ".$p['rozmiar']."<br>";
        echo "Cena: ".$p['cena']." zł<br>";

        $link = "#";
        if (isset($pliki[$p['nazwa']])){
            $link = $pliki[$p['nazwa']];
        }
        echo "<a href='$link'>Szczegóły</a>";
        echo "</div>";
    }

} else {
    echo "<p>Brak wyników</p>";
}


?>
</div>
</body>
</html>