<?php
header('Content-Type: application/json; charset=utf-8');

// Підключення до бази даних
$conn = new mysqli("localhost", "root", "", "pizzeria");
if ($conn->connect_error) {
    echo json_encode(['error' => 'Błąd połączenia z bazą danych'], JSON_UNESCAPED_UNICODE);
    exit;
}

if (!isset($_GET['nazwa'])) {
    echo json_encode(['error' => 'Brak nazwy pizzy'], JSON_UNESCAPED_UNICODE);
    exit;
}

$nazwa = $conn->real_escape_string(urldecode($_GET['nazwa']));
$sql = "SELECT * FROM pizza WHERE nazwa='$nazwa' ORDER BY FIELD(rozmiar, 'mały','średni','duży')";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    echo json_encode(['error' => 'Pizza nie istnieje'], JSON_UNESCAPED_UNICODE);
    exit;
}
 
$pizze = [];
while ($row = $result->fetch_assoc()) {
    $pizze[] = $row;
}

$pizza = $pizze[0];

$response = [
    'nazwa' => $pizza['nazwa'],
    'obrazek' => $pizza['obrazek'],
    'skladniki' => $pizza['skladniki'],
    'opis' => $pizza['opis'] ?? 'Smaczna pizza',
    'rozmiary' => []
];

foreach ($pizze as $p) {
    $response['rozmiary'][] = [
        'id' => $p['id'],
        'rozmiar' => $p['rozmiar'],
        'cena' => $p['cena']
    ];
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
$conn->close();
