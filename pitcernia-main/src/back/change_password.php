<?php
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Nie jesteś zalogowany']);
    exit();
}

$conn = new mysqli("localhost", "root", "", "pizzeria");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Błąd połączenia']);
    exit();
}

if (!isset($_POST['current_password'], $_POST['new_password'])) {
    echo json_encode(['success' => false, 'message' => 'Brak wymaganych danych']);
    exit();
}

$user_id = $_SESSION['id'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];

if (strlen($new_password) < 6) {
    echo json_encode(['success' => false, 'message' => 'Hasło musi mieć co najmniej 6 znaków']);
    exit();
}

if ($stmt = $conn->prepare('SELECT haslo FROM klient WHERE id = ?')) {
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($stored_hash);
    $stmt->fetch();
    $stmt->close();
    
    if (!password_verify($current_password, $stored_hash)) {
        echo json_encode(['success' => false, 'message' => 'Aktualne hasło jest nieprawidłowe']);
        exit();
    }
    
    if ($stmt = $conn->prepare('UPDATE klient SET haslo = ? WHERE id = ?')) {
        $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt->bind_param('si', $new_hash, $user_id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Hasło zostało zmienione']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Błąd podczas zmiany hasła']);
        }
        $stmt->close();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Błąd systemu']);
}

$conn->close();
?>