<?php
session_start();
header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    echo json_encode([
        'logged_in' => true,
        'user_name' => $_SESSION['name']
    ]);
} else {
    echo json_encode(['logged_in' => false]);
}
