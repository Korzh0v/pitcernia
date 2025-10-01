<?php
session_start();
$conn = new mysqli("localhost", "root", "", "pizzeria");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_POST['username'], $_POST['password'])) {
    exit('<script>alert("Proszę wypełnić wszystkie pola!"); window.history.back();</script>');
}

if (empty($_POST['username']) || empty($_POST['password'])) {
    exit('<script>alert("Proszę wprowadzić nazwę użytkownika i hasło!"); window.history.back();</script>');
}

if ($stmt = $conn->prepare('SELECT id, haslo FROM klient WHERE nazwa = ?')) {
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();

        if (password_verify($_POST['password'], $password)) {
            session_regenerate_id(true);
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;

            echo '<script>
                window.location.href = "../front/strona internetowa.html";
            </script>';
            exit;
        } else {
            echo '<script>
                alert("Nieprawidłowa nazwa użytkownika lub hasło!");
                window.history.back();
            </script>';
        }
    } else {
        echo '<script>
            alert("Nieprawidłowa nazwa użytkownika lub hasło!");
            window.history.back();
        </script>';
    }
    $stmt->close();
} else {
    echo '<script>alert("Wystąpił błąd systemu!"); window.history.back();</script>';
}

$conn->close();

?>