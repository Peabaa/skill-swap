<?php
session_start();

// CORS headers for local development
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if (preg_match('/^http:\/\/localhost:\d+$/', $origin)) {
    header("Access-Control-Allow-Origin: $origin");
    header("Access-Control-Allow-Credentials: true");
}

header("Content-Type: application/json");

// If no user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["message" => "Not logged in"]);
    exit();
}

// Connect to database
$conn = new mysqli("sql12.freesqldatabase.com", "sql12781104", "gzbNBg7kY1", "sql12781104", 3306);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["message" => "Database connection failed."]);
    exit();
}

// Get full user info
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT id, email, skills FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

echo json_encode($user);

$stmt->close();
$conn->close();
?>
