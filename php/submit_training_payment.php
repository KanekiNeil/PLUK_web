<?php
session_start();
header('Content-Type: application/json');

$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN';

if ($requestMethod === 'OPTIONS') {
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Preflight OK.'
    ]);
    exit;
}

if ($requestMethod !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method: ' . $requestMethod . '. Expected POST.'
    ]);
    exit;
}

$appId = $_SESSION['app_id'] ?? null;
if (empty($appId)) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Application session not found. Please verify your email again.'
    ]);
    exit;
}

$rawBody = file_get_contents('php://input');
$payload = json_decode($rawBody, true);
$paymentProof = trim($payload['payment_proof'] ?? '');

if ($paymentProof === '') {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'Payment proof is required.'
    ]);
    exit;
}

if (preg_match('/^data:image\/[a-zA-Z0-9.+-]+;base64,(.*)$/', $paymentProof, $matches)) {
    $paymentProof = $matches[1];
}

if (base64_decode($paymentProof, true) === false) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid payment proof image data.'
    ]);
    exit;
}

$supabaseUrl = "https://ncsobcjlvytbivoxezfd.supabase.co";
$supabaseKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MTU2ODc3NiwiZXhwIjoyMDg3MTQ0Nzc2fQ.TLktUWOmr-iAZTy4Vm0F_ihUa2q_tQuP83RLTodPcEY";

$insertPayload = [
    [
        'payment_proof' => $paymentProof,
        'applicant_id' => $appId
    ]
];

$ch = curl_init($supabaseUrl . '/rest/v1/training_payment');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($insertPayload));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'apikey: ' . $supabaseKey,
    'Authorization: Bearer ' . $supabaseKey,
    'Content-Type: application/json',
    'Prefer: return=representation'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($response === false || !empty($curlError)) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to connect to payment service.'
    ]);
    exit;
}

if ($httpCode < 200 || $httpCode >= 300) {
    http_response_code($httpCode);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to save training payment.',
        'details' => $response
    ]);
    exit;
}

echo json_encode([
    'success' => true,
    'message' => 'Training payment confirmation submitted successfully.'
]);
