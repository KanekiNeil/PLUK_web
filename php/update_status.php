<?php
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "message" => "Method not allowed. Use POST."
    ]);
    exit;
}

$supabaseUrl = "https://ncsobcjlvytbivoxezfd.supabase.co";
$serviceRoleKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MTU2ODc3NiwiZXhwIjoyMDg3MTQ0Nzc2fQ.TLktUWOmr-iAZTy4Vm0F_ihUa2q_tQuP83RLTodPcEY";

$rawInput = file_get_contents("php://input");
$jsonInput = json_decode($rawInput, true);
$input = is_array($jsonInput) ? $jsonInput : $_POST;

$status = trim($input['status'] ?? '');
$aaid = trim((string)($input['aaid'] ?? ''));
$aiid = trim((string)($input['aiid'] ?? ''));
$appointmentDateTime = trim((string)($input['appointment_datetime'] ?? ''));

if ($status === '') {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Status is required."
    ]);
    exit;
}

if ($aaid === '' && $aiid === '') {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Provide AAID, or AIID with appointment_datetime."
    ]);
    exit;
}

if ($aaid !== '') {
    $updateUrl = $supabaseUrl . "/rest/v1/application_appointment?AAID=eq." . urlencode($aaid);
} else {
    $updateUrl = $supabaseUrl . "/rest/v1/application_appointment?aiid=eq." . urlencode($aiid);
}
$payload = json_encode(["status" => $status]);

$ch = curl_init($updateUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $serviceRoleKey",
    "Authorization: Bearer $serviceRoleKey",
    "Content-Type: application/json",
    "Prefer: return=representation"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    $curlError = curl_error($ch);
    curl_close($ch);
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Request failed: " . $curlError
    ]);
    exit;
}

curl_close($ch);

if ($httpCode >= 400) {
    http_response_code($httpCode);
    echo json_encode([
        "status" => "error",
        "message" => "Supabase update failed.",
        "details" => $response
    ]);
    exit;
}

$updatedRows = json_decode($response, true);

if (!is_array($updatedRows) || count($updatedRows) === 0) {
    http_response_code(404);
    echo json_encode([
        "status" => "error",
        "message" => "No matching appointment found to update."
    ]);
    exit;
}

echo json_encode([
    "status" => "success",
    "message" => "Appointment status updated successfully.",
    "data" => $updatedRows[0]
]);
