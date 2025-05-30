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
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

// Get JSON input and decode
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing country id"]);
    exit;
}

$id = intval($data['id']);

$stmt = $conn->prepare("DELETE FROM saved_countries WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Country deleted successfully."]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to delete country."]);
}

$stmt->close();
$conn->close();
?>
