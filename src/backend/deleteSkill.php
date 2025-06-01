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

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

header("Content-Type: application/json");

// Check for logged-in user
if (!isset($_SESSION['email'])) {
    http_response_code(401);
    echo json_encode(["message" => "Unauthorized. User not logged in."]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$skillToDelete = trim($data['skill'] ?? '');

if (empty($skillToDelete)) {
    http_response_code(400);
    echo json_encode(["message" => "Skill name is required."]);
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "skillswapusers");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["message" => "Database connection failed."]);
    exit();
}

$email = $_SESSION['email'];

// Fetch current skills
$stmt = $conn->prepare("SELECT skills FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $skills = array_map('trim', explode(',', $row['skills'] ?? ''));

    // Remove the skill if it exists
    $updatedSkills = array_filter($skills, function ($s) use ($skillToDelete) {
        return strcasecmp($s, $skillToDelete) !== 0;
    });

    if (count($skills) === count($updatedSkills)) {
        echo json_encode(["message" => "Skill not found."]);
        $stmt->close();
        $conn->close();
        exit();
    }

    $skillsString = implode(', ', $updatedSkills);

    // Update skills in DB
    $updateStmt = $conn->prepare("UPDATE users SET skills = ? WHERE email = ?");
    $updateStmt->bind_param("ss", $skillsString, $email);

    if ($updateStmt->execute()) {
        echo json_encode(["success" => true, "message" => "Skill deleted successfully."]);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Failed to update skills."]);
    }

    $updateStmt->close();
} else {
    http_response_code(404);
    echo json_encode(["message" => "User not found."]);
}

$stmt->close();
$conn->close();
?>
