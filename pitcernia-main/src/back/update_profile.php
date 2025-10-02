<?php
session_start();

if (!isset($_SESSION['id'])) {
    
    exit();
}

$conn = new mysqli("localhost", "root", "", "pizzeria");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Błąd połączenia z bazą']);
    exit();
}

if (!isset($_POST['username'], $_POST['email'], $_POST['address'])) {
    echo json_encode(['success' => false, 'message' => 'Wszystkie pola są wymagane']);
    exit();
}

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$address = trim($_POST['address']);
$user_id = $_SESSION['id'];

if (empty($username) || empty($email) || empty($address)) {
    echo json_encode(['success' => false, 'message' => 'Wszystkie pola muszą być wypełnione']);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Nieprawidłowy format email']);
    exit();
}

if (strlen($address) < 10) {
    echo json_encode(['success' => false, 'message' => 'Adres musi mieć co najmniej 10 znaków']);
    exit();
}

if ($stmt = $conn->prepare('SELECT id FROM klient WHERE nazwa = ? AND id != ?')) {
    $stmt->bind_param('si', $username, $user_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Nazwa użytkownika jest już zajęta']);
        exit();
    }
    $stmt->close();
}

if ($stmt = $conn->prepare('SELECT id FROM klient WHERE email = ? AND id != ?')) {
    $stmt->bind_param('si', $email, $user_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Ten adres email jest już zarejestrowany']);
        exit();
    }
    $stmt->close();
}

if ($stmt = $conn->prepare('UPDATE klient SET nazwa = ?, email = ?, adres = ? WHERE id = ?')) {
    $stmt->bind_param('sssi', $username, $email, $address, $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['name'] = $username;
        echo json_encode(['success' => true, 'message' => 'Profil zaktualizowany pomyślnie']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Błąd podczas aktualizacji']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Błąd systemu']);
}

$conn->close();
?>