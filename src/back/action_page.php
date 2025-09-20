<?php
session_start();

$conn = new mysqli("localhost", "root", "", "pitcernia");

if ($conn->connect_error) {
    exit("Connection error: " . $conn->connect_error);
}

if (!isset($_POST['username'], $_POST['password'], $_POST['email'], $_POST['psw-repeat'])) {
    exit('<script>alert("Wszystkie pola są wymagane!"); window.history.back();</script>');
}

if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email']) || empty($_POST['psw-repeat'])) {
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

if ($stmt = $conn->prepare('SELECT id FROM klienci WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo '<script>alert("Nazwa użytkownika już istnieje. Spróbuj ponownie z inną nazwą."); window.history.back();</script>';
    } else {
        $stmt->close();
        if ($stmt = $conn->prepare('SELECT id FROM klienci WHERE email = ?')) {
            $stmt->bind_param('s', $_POST['email']);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                echo '<script>alert("Ten adres email jest już zarejestrowany!"); window.history.back();</script>';
            } else {
                $stmt->close();
                if ($stmt = $conn->prepare('INSERT INTO klienci (username, password, email) VALUES (?, ?, ?)')) {
                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);

                    if ($stmt->execute()) {
                        // Registration successful, log user in automatically
                        $_SESSION['loggedin'] = TRUE;
                        $_SESSION['name'] = $_POST['username'];
                        $_SESSION['id'] = $conn->insert_id;

                        echo '<script>
                            alert("Rejestracja zakończona pomyślnie! Zostałeś automatycznie zalogowany.");
                            window.location.href = "strona_internetowa.html";
                        </script>';
                    } else {
                        echo '<script>alert("Wystąpił błąd podczas rejestracji. Spróbuj ponownie."); window.history.back();</script>';
                    }
                } else {
                    echo '<script>alert("Wystąpił błąd systemu."); window.history.back();</script>';
                }
            }
        }
    }

    if (isset($stmt)) {
        $stmt->close();
    }
} else {
    echo '<script>alert("Wystąpił błąd systemu."); window.history.back();</script>';
}

$conn->close();
