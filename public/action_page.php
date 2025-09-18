<?php
$conn = new mysqli("localhost", "root", "", "pitcernia"); 
if ($conn->connect_error) {
    exit("Connection error");
}

if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
    exit("Empty fields");
}

if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
    exit("Empty values");
}

if ($stmt = $conn->prepare('SELECT id FROM klienci WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo 'Username already exists. Try again ';
    } else {
        if ($stmt = $conn->prepare('INSERT INTO klienci (username, password, email) VALUES (?, ?, ?)')) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // haszowanie hasła
            $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
            if ($stmt->execute()) {
                echo 'Successfully registered';
            } else {
                echo 'Error occurred during registration';
            }
        } else {
            echo 'Error occurred';
        }
    }
} else {
    echo 'Error occurred';
}

$conn->close();
