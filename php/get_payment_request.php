<?php
include_once __DIR__ . '/session.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized request.'
    ]);
    exit;
}

$type = trim($_GET['type'] ?? '');
$applicantId = trim($_GET['applicant_id'] ?? '');

if ($type === '' || $applicantId === '') {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'type and applicant_id are required.'
    ]);
    exit;
}

$table = null;
if ($type === 'exam') {
    $table = 'exam_payment';
} elseif ($type === 'training') {
    $table = 'training_payment';
} else {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid payment type.'
    ]);
    exit;
}

$supabaseUrl = "https://ncsobcjlvytbivoxezfd.supabase.co";
$supabaseKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MTU2ODc3NiwiZXhwIjoyMDg3MTQ0Nzc2fQ.TLktUWOmr-iAZTy4Vm0F_ihUa2q_tQuP83RLTodPcEY";

$url = $supabaseUrl . '/rest/v1/' . $table . '?select=id,payment_proof,verified,applicant_id&applicant_id=eq.' . urlencode($applicantId) . '&order=id.desc&limit=1';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'apikey: ' . $supabaseKey,
    'Authorization: Bearer ' . $supabaseKey,
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($response === false || !empty($curlError)) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to fetch payment request.'
    ]);
    exit;
}

if ($httpCode < 200 || $httpCode >= 300) {
    http_response_code($httpCode);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to fetch payment request.',
        'details' => $response
    ]);
    exit;
}

$rows = json_decode($response, true);
$row = (is_array($rows) && !empty($rows[0])) ? $rows[0] : null;

echo json_encode([
    'success' => true,
    'payment_proof' => $row['payment_proof'] ?? null,
    'verified' => (bool)($row['verified'] ?? false),
    'applicant_id' => $row['applicant_id'] ?? $applicantId
]);
