<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    echo json_encode([
        'logged_in' => true,
        'user_name' => $_SESSION['name']
    ]);
} else {
    echo json_encode(['logged_in' => false]);
}


?>