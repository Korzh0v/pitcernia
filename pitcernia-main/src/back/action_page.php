<?php
session_start();

$conn = new mysqli("localhost", "root", "", "pizzeria");

if ($conn->connect_error) {
    exit("Connection error: " . $conn->connect_error);
}

if (!isset($_POST['username'], $_POST['password'], $_POST['email'], $_POST['psw-repeat'], $_POST['address'])) {
    exit('<script>alert("Wszystkie pola są wymagane!"); window.history.back();</script>');
}

if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email']) || empty($_POST['psw-repeat']) || empty($_POST['address'])) {
    exit('<script>alert("Wszystkie pola muszą być wypełnione!"); window.history.back();</script>');
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    exit('<script>alert("Nieprawidłowy format email!"); window.history.back();</script>');
}

if ($_POST['password'] !== $_POST['psw-repeat']) {
    exit('<script>alert("Hasła nie są identyczne!"); window.history.back();</script>');
}

if (strlen($_POST['password']) < 6) {
    exit('<script>alert("Hasło musi mieć co najmniej 6 znaków!"); window.history.back();</script>');
}

if (strlen(trim($_POST['address'])) < 10) {
    exit('<script>alert("Proszę podać pełny adres (co najmniej 10 znaków)!"); window.history.back();</script>');
}

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$address = trim($_POST['address']);

if ($stmt = $conn->prepare('SELECT id FROM klient WHERE nazwa = ?')) {
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        echo '<script>alert("Nazwa użytkownika już istnieje. Spróbuj ponownie z inną nazwą."); window.history.back();</script>';
        exit();
    }
    $stmt->close();
} else {
    echo '<script>alert("Wystąpił błąd systemu podczas sprawdzania nazwy użytkownika."); window.history.back();</script>';
    exit();
}

if ($stmt = $conn->prepare('SELECT id FROM klient WHERE email = ?')) {
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        echo '<script>alert("Ten adres email jest już zarejestrowany!"); window.history.back();</script>';
        exit();
    }
    $stmt->close();
} else {
    echo '<script>alert("Wystąpił błąd systemu podczas sprawdzania adresu email."); window.history.back();</script>';
    exit();
}

if ($stmt = $conn->prepare('INSERT INTO klient (nazwa, email, haslo, adres) VALUES (?, ?, ?, ?)')) {

    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt->bind_param('ssss', $username, $email, $password_hash, $address);

    if ($stmt->execute()) {

        $_SESSION['loggedin'] = TRUE;
        $_SESSION['name'] = $username;
        $_SESSION['id'] = $conn->insert_id;

        $stmt->close();
        $conn->close();

        echo '<script>
            window.location.href = "../front/strona internetowa.html";
        </script>';
    } else {
        $stmt->close();
        echo '<script>alert("Wystąpił błąd podczas rejestracji. Spróbuj ponownie."); window.history.back();</script>';
    }
} else {
    echo '<script>alert("Wystąpił błąd systemu podczas tworzenia konta."); window.history.back();</script>';
}

$conn->close();
