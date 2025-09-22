<?php
$conn = new mysqli("localhost", "root", "", "pitceria");
if ($conn->connect_error){
  die("error" . $conn->connect_error);
}
?>