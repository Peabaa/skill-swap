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

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);
$searchTerm = $data["query"] ?? '';

if (empty($searchTerm)) {
    http_response_code(400);
    echo json_encode(["message" => "Search term is required."]);
    exit();
}

// Normalize search term
$normalizedSearchTerm = strtolower(trim($searchTerm));

// Database connection
$conn = new mysqli("localhost", "root", "", "skillswapusers");

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["message" => "Database connection failed."]);
    exit();
}

// Search for users with matching skills
$stmt = $conn->prepare("SELECT id, email, skills FROM users WHERE skills IS NOT NULL AND skills LIKE ?");

if (!$stmt) {
    http_response_code(500);
    echo json_encode(["message" => "Statement preparation failed: " . $conn->error]);
    $conn->close();
    exit();
}

$likeTerm = "%" . $searchTerm . "%";
$stmt->bind_param("s", $likeTerm);
$stmt->execute();
$result = $stmt->get_result();

$results = [];

while ($row = $result->fetch_assoc()) {
    $skills = array_map('trim', explode(',', $row['skills']));

    foreach ($skills as $skill) {
        $normalizedSkill = strtolower(trim($skill));

        if (strpos($normalizedSkill, $normalizedSearchTerm) !== false) {
            $results[] = [
                'user_id' => $row['id'],
                'email' => $row['email'],
                'skill_name' => $skill
            ];
        }
    }
}

echo json_encode(['results' => $results]);

$stmt->close();
$conn->close();
?>
