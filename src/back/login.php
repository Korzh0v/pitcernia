<?php
session_start();

$conn = new mysqli("localhost", "root", "", "pitcernia");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_POST['username'], $_POST['password'])) {
    exit('Please fill both the username and password fields!');
}

if (empty($_POST['username']) || empty($_POST['password'])) {
    exit('Please enter username and password!');
}

if ($stmt = $conn->prepare('SELECT id, password FROM klienci WHERE username = ?')) {

    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();

    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();

        if (password_verify($_POST['password'], $password)) {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;

            echo '<script>
                alert("Zalogowano pomyślnie!");
                window.location.href = "strona_internetowa.html";
            </script>';
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
    echo 'Could not prepare statement!';
}

$conn->close();
