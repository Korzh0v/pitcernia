<?php
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

$message = "";
$error = "";
$showForm = true;
$userId = null;

// Sprawdź token
if (!isset($_GET['token']) || empty($_GET['token'])) {
    $error = "Brak tokenu resetowania hasła!";
    $showForm = false;
} else {
    $token = $_GET['token'];
    $tokenHash = hash('sha256', $token);
    
    // Sprawdź czy token istnieje i jest ważny
    $stmt = $conn->prepare("SELECT user_id, expires_at FROM password_resets WHERE token_hash = ?");
    $stmt->bind_param("s", $tokenHash);
    $stmt->execute();
    $stmt->bind_result($userId, $expires_at);
    $stmt->fetch();
    $stmt->close();
    
    if (!$userId) {
        $error = "Nieprawidłowy token resetowania hasła!";
        $showForm = false;
    } elseif (strtotime($expires_at) < time()) {
        $error = "Token wygasł! Link jest ważny tylko przez 1 godzinę.";
        $showForm = false;
    }
}

// Obsługa formularza
if ($_SERVER["REQUEST_METHOD"] == "POST" && $showForm && $userId) {
    $newPassword = $_POST["password"] ?? '';
    $confirmPassword = $_POST["confirm_password"] ?? '';
    
    if (empty($newPassword)) {
        $error = "Hasło nie może być puste!";
    } elseif (strlen($newPassword) < 6) {
        $error = "Hasło musi mieć co najmniej 6 znaków!";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "Hasła nie są identyczne!";
    } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        // Zaktualizuj hasło w tabeli klient
        $stmt = $conn->prepare("UPDATE klient SET haslo = ? WHERE id = ?");
        $stmt->bind_param("si", $hashedPassword, $userId);
        
        if ($stmt->execute()) {
            // Usuń token po użyciu
            $deleteStmt = $conn->prepare("DELETE FROM password_resets WHERE user_id = ?");
            $deleteStmt->bind_param("i", $userId);
            $deleteStmt->execute();
            $deleteStmt->close();
            
            $message = "✓ Hasło zostało zmienione pomyślnie!";
            $showForm = false;
        } else {
            $error = "Wystąpił błąd podczas zmiany hasła: " . $stmt->error;
        }
        
        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resetowanie Hasła - Pizzeria</title>
  <link rel="stylesheet" href="../front//style/reset_password.css">
</head>
<body>
  <div class="reset-container">
    <div class="icon-container">
      <svg xmlns="http://www.w3.org/2000/svg" 
           viewBox="0 0 24 24" 
           fill="none" 
           stroke="currentColor" 
           stroke-width="2" 
           stroke-linecap="round" 
           stroke-linejoin="round">
        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
      </svg>
    </div>

    <div class="reset-header">
      <h1>Resetowanie Hasła</h1>
      <p>Wprowadź nowe hasło do swojego konta.</p>
    </div>

    <?php if ($message): ?>
      <div class="message success">
        <?php echo $message; ?>
      </div>
    <?php endif; ?>

    <?php if ($error): ?>
      <div class="message error">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <?php if ($showForm): ?>
      <form method="POST">
        <div class="form-group">
          <label for="password">Nowe hasło:</label>
          <input type="password" id="password" name="password" required minlength="6">
          <div class="password-hint">Minimum 6 znaków</div>
        </div>

        <div class="form-group">
          <label for="confirm_password">Potwierdź hasło:</label>
          <input type="password" id="confirm_password" name="confirm_password" required minlength="6">
        </div>

        <button type="submit" class="submit-btn">Zmień hasło</button>
      </form>
    <?php endif; ?>

    <div class="back-link">
      <a href="../../src/front/strona internetowa.html">← Powrót do strony głównej</a>
    </div>
  </div>
</body>
</html>
