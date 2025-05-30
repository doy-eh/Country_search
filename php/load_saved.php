<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$host = "localhost";
$username = "root";
$password = "";  
$dbname = "project_db";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}


$sql = "SELECT name, capital, region, flag_url FROM saved_countries ORDER BY created_at DESC";

$result = $conn->query($sql);

$countries = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $countries[] = $row;
    }
}

echo json_encode($countries);

$conn->close();
?>
