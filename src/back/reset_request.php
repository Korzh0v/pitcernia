<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../../libs/PHPMailer-6.11.1/src/PHPMailer.php';
require __DIR__ . '/../../libs/PHPMailer-6.11.1/src/SMTP.php';
require __DIR__ . '/../../libs/PHPMailer-6.11.1/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$conn = new mysqli("localhost", "root", "", "pizzeria");

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
        $stmt = $conn->prepare("SELECT id FROM klient WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($userId);
        $stmt->fetch();
        $stmt->close();

        if ($userId) {
            // token
            $token = bin2hex(random_bytes(32));
            $tokenHash = hash('sha256', $token);
            $expire = date("Y-m-d H:i:s", strtotime("+1 hour"));

            $deleteStmt = $conn->prepare("DELETE FROM password_resets WHERE user_id = ?");
            $deleteStmt->bind_param("i", $userId);
            $deleteStmt->execute();
            $deleteStmt->close();

            $insertStmt = $conn->prepare("INSERT INTO password_resets (user_id, token_hash, expires_at) VALUES (?, ?, ?)");
            $insertStmt->bind_param("iss", $userId, $tokenHash, $expire);

            if ($insertStmt->execute()) {
                $resetLink = "http://localhost/pitcernia/src/back/reset_password.php?token=" . $token;

                // ✉️ Wysyłka maila przez PHPMailer
                $mail = new PHPMailer(true);

                try {
                    // SMTP config (dla Gmaila)
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'mykhailo.korzhovskyi@gmail.com'; // 👉 Twój adres Gmail
                    $mail->Password   = 'nzosddgfgacvumgj '; // 👉 Hasło do aplikacji Gmail
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port   = 587;

                    // Nadawca i odbiorca
                    $mail->setFrom('mykhailo.korzhovskyi@gmail.com', 'Pizzeria');
                    $mail->addAddress($email);

                    // Treść wiadomości
                    $mail->isHTML(true);
                    $mail->Subject = 'Resetowanie hasła - Pizzeria';
                    $mail->Body    = "Cześć!<br><br>Kliknij link, aby zresetować hasło:<br>
                                      <a href='$resetLink'>$resetLink</a><br><br>
                                      Link jest ważny przez 1 godzinę.";

                    $mail->send();
                    echo "OK|Na adres <b>$email</b> został wysłany link resetujący.";
                } catch (Exception $e) {
                    echo "Nie udało się wysłać maila. Błąd: {$mail->ErrorInfo}";
                }
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
