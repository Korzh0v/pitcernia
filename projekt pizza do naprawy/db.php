<?php
$conn = new mysqli("localhost", "root", "", "pitceria");
if ($conn->connect_error) {
  die("Błąd połączenia: " . $conn->connect_error);
}
?>
