<?php
$conn = new mysqli("localhost", "root", "", "pizzeria");
if ($conn->connect_error){
  die("error" . $conn->connect_error);
}
?>