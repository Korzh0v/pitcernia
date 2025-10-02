<?php
// Włącz wyświetlanie błędów (usuń po naprawieniu!)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Połączenie z bazą danych
$host = "localhost";
$username = "root";
$password = "";
$database = "pizzeria";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

header('Content-Type: text/html; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"] ?? '');
    
    if (empty($email)) {
        echo "Podaj adres email!";
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Nieprawidłowy format adresu email!";
        exit;
    }
    
    try {
        // Sprawdź czy użytkownik istnieje w tabeli klient
        $stmt = $conn->prepare("SELECT id FROM klient WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($userId);
        $stmt->fetch();
        $stmt->close();
        
        if ($userId) {
            // Generuj token
            $token = bin2hex(random_bytes(32));
            $tokenHash = hash('sha256', $token);
            $expire = date("Y-m-d H:i:s", strtotime("+1 hour"));
            
            // Usuń stare tokeny dla tego użytkownika
            $deleteStmt = $conn->prepare("DELETE FROM password_resets WHERE user_id = ?");
            $deleteStmt->bind_param("i", $userId);
            $deleteStmt->execute();
            $deleteStmt->close();
            
            // Dodaj nowy token
            $insertStmt = $conn->prepare("INSERT INTO password_resets (user_id, token_hash, expires_at) VALUES (?, ?, ?)");
            $insertStmt->bind_param("iss", $userId, $tokenHash, $expire);
            
            if ($insertStmt->execute()) {
                // Link resetujący - dostosuj ścieżkę!
                $resetLink = "http://localhost/pitcernia/src/back/reset_password.php?token=" . $token;
                
                echo "OK|<a href='$resetLink' target='_blank' style='color:#007bff;text-decoration:underline;'>Kliknij tutaj aby zresetować hasło</a>";
            } else {
                echo "Błąd podczas tworzenia tokenu: " . $insertStmt->error;
            }
            
            $insertStmt->close();
        } else {
            echo "Nie znaleziono użytkownika o takim adresie email!";
        }
        
    } catch (Exception $e) {
        echo "Błąd: " . $e->getMessage();
    }
    
    $conn->close();
    
} else {
    echo "Nieprawidłowe żądanie!";
}
?>