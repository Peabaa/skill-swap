<?php
session_start();

// CORS headers
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

if (preg_match('/^http:\/\/localhost:\d+$/', $origin)) {
    header("Access-Control-Allow-Origin: $origin");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Credentials: true");
}

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$email = $data["email"] ?? '';
$password = $data["password"] ?? '';

$conn = new mysqli("localhost", "root", "", "skillswapusers");

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["message" => "Database connection failed."]);
    exit();
}

// Look for user
$stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($userId, $hashedPassword);
    $stmt->fetch();

    if (password_verify($password, $hashedPassword)) {
        session_regenerate_id(true); // Regenerate session ID for security
        $_SESSION['user_id'] = $userId;
        $_SESSION['email'] = $email;

        echo json_encode([
            "success" => true,
            "user_id" => $userId,
            "email" => $email
        ]);
    } else {
        http_response_code(401);
        echo json_encode(["message" => "Incorrect password."]);
    }
} else {
    http_response_code(401);
    echo json_encode(["message" => "Email not found."]);
}

$stmt->close();
$conn->close();
?>
