<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: text/plain");  

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['name'], $data['capital'], $data['region'], $data['flag_url'])) {
    http_response_code(400);
    echo "Missing data";
    exit;
}

$host = "localhost";
$username = "root";
$password = "";
$dbname = "project_db";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo "Database connection failed";
    exit;
}

$checkStmt = $conn->prepare("SELECT COUNT(*) FROM saved_countries WHERE LOWER(name) = LOWER(?)");
$checkStmt->bind_param("s", $data['name']);
$checkStmt->execute();
$checkStmt->bind_result($count);
$checkStmt->fetch();
$checkStmt->close();

if ($count > 0) {
    echo "Country already saved.";
    $conn->close();
    exit;
}

$stmt = $conn->prepare("INSERT INTO saved_countries (name, capital, region, flag_url) VALUES (?, ?, ?, ?)");
$stmt->bind_param(
    "ssss",
    $data['name'],
    $data['capital'],
    $data['region'],
    $data['flag_url']
);

if ($stmt->execute()) {
    echo "Country saved successfully!";
} else {
    http_response_code(500);
    echo "Error saving country.";
}

$stmt->close();
$conn->close();
?>
