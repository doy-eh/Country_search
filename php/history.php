<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$host = "localhost";
$username = "root";
$password = "";
$dbname = "project_db";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([]);
    exit;
}

$sql = "SELECT id, name, capital, region, flag_url FROM saved_countries ORDER BY id DESC"; // include id
$result = $conn->query($sql);

$savedCountries = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $savedCountries[] = $row;
    }
}

echo json_encode($savedCountries);

$conn->close();
?>
