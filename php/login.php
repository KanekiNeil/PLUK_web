<?php
session_start();
//include_once "../config.php";

header("Content-Type: application/json");


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
    exit;
}

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email']) || !isset($data['password'])) {
    http_response_code(400);
    echo json_encode(["error" => "Email and password required"]);
    exit;
}

$email = trim($data['email']);
$password = trim($data['password']);

// Supabase REST API endpoint
$url = "https://ncsobcjlvytbivoxezfd.supabase.co/rest/v1/users?select=*";

$apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzE1Njg3NzYsImV4cCI6MjA4NzE0NDc3Nn0.LWELQVNAh5GzjU-YUSrO5O3b3Gj-lP7pUB3A_D-vNfA";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $apiKey",
    "Authorization: Bearer $apiKey",
    "Content-Type: application/json"
]);

$response = curl_exec($ch);
curl_close($ch);

$users = json_decode($response, true);

$found = false;
foreach ($users as $user) {
    if ($user['email'] === $email && $password === $user['password']) {
        $found = true;
        break;
    }
}

if ($found) {
    echo json_encode(['success' => true]);
        // Store session data
    $_SESSION['user_id'] = $user['id'];       // store user ID
    $_SESSION['email']   = $user['email'];    // optionally store email
    $_SESSION['session_id'] = session_id();  // store PHP session ID
} else {
    echo json_encode(['error' => 'Invalid credentials']);
}