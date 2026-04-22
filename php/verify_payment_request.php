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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
    exit;
}

$payload = json_decode(file_get_contents('php://input'), true);
$action = strtolower(trim($payload['action'] ?? 'verify'));
$type = trim($payload['type'] ?? '');
$applicantId = trim($payload['applicant_id'] ?? '');

if ($type === '' || $applicantId === '') {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'type and applicant_id are required.'
    ]);
    exit;
}

$table = null;
$newStatus = null;
if ($type === 'exam') {
    $table = 'exam_payment';
    $newStatus = ($action === 'reject') ? 'payment rejected' : 'payment verified';
} elseif ($type === 'training') {
    $table = 'training_payment';
    $newStatus = ($action === 'reject') ? 'payment rejected' : 'training payment verified';
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

if (!in_array($action, ['verify', 'reject'], true)) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid action. Allowed actions: verify, reject.'
    ]);
    exit;
}

if ($action === 'verify') {
    $verifyCh = curl_init($supabaseUrl . '/rest/v1/' . $table . '?applicant_id=eq.' . urlencode($applicantId));
    curl_setopt($verifyCh, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($verifyCh, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($verifyCh, CURLOPT_POSTFIELDS, json_encode(['verified' => true]));
    curl_setopt($verifyCh, CURLOPT_HTTPHEADER, [
        'apikey: ' . $supabaseKey,
        'Authorization: Bearer ' . $supabaseKey,
        'Content-Type: application/json',
        'Prefer: return=representation'
    ]);

    $verifyResponse = curl_exec($verifyCh);
    $verifyHttpCode = curl_getinfo($verifyCh, CURLINFO_HTTP_CODE);
    $verifyCurlError = curl_error($verifyCh);
    curl_close($verifyCh);

    if ($verifyResponse === false || !empty($verifyCurlError)) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to verify payment request.'
        ]);
        exit;
    }

    if ($verifyHttpCode < 200 || $verifyHttpCode >= 300) {
        http_response_code($verifyHttpCode);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to verify payment request.',
            'details' => $verifyResponse
        ]);
        exit;
    }
} else {
    $deleteCh = curl_init($supabaseUrl . '/rest/v1/' . $table . '?applicant_id=eq.' . urlencode($applicantId));
    curl_setopt($deleteCh, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($deleteCh, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($deleteCh, CURLOPT_HTTPHEADER, [
        'apikey: ' . $supabaseKey,
        'Authorization: Bearer ' . $supabaseKey,
        'Content-Type: application/json',
        'Prefer: return=representation'
    ]);

    $deleteResponse = curl_exec($deleteCh);
    $deleteHttpCode = curl_getinfo($deleteCh, CURLINFO_HTTP_CODE);
    $deleteCurlError = curl_error($deleteCh);
    curl_close($deleteCh);

    if ($deleteResponse === false || !empty($deleteCurlError)) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to reject payment request.'
        ]);
        exit;
    }

    if ($deleteHttpCode < 200 || $deleteHttpCode >= 300) {
        http_response_code($deleteHttpCode);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to reject payment request.',
            'details' => $deleteResponse
        ]);
        exit;
    }
}

$columns = ['status', 'AI_Status'];
$statusUpdated = false;
$statusError = null;

foreach ($columns as $column) {
    $statusCh = curl_init($supabaseUrl . '/rest/v1/applicant_information?uuid=eq.' . urlencode($applicantId));
    curl_setopt($statusCh, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($statusCh, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($statusCh, CURLOPT_POSTFIELDS, json_encode([$column => $newStatus]));
    curl_setopt($statusCh, CURLOPT_HTTPHEADER, [
        'apikey: ' . $supabaseKey,
        'Authorization: Bearer ' . $supabaseKey,
        'Content-Type: application/json',
        'Prefer: return=representation'
    ]);

    $statusResponse = curl_exec($statusCh);
    $statusHttpCode = curl_getinfo($statusCh, CURLINFO_HTTP_CODE);
    $statusCurlError = curl_error($statusCh);
    curl_close($statusCh);

    if (!empty($statusCurlError)) {
        $statusError = 'Connection error while updating applicant status.';
        continue;
    }

    if ($statusHttpCode >= 200 && $statusHttpCode < 300) {
        $statusUpdated = true;
        break;
    }

    $statusError = is_string($statusResponse) ? $statusResponse : 'Unknown status update error.';

    if (stripos($statusError, 'Could not find the') !== false && stripos($statusError, 'column') !== false) {
        continue;
    }
}

if (!$statusUpdated) {
    echo json_encode([
        'success' => true,
        'message' => ($action === 'reject' ? 'Payment rejected, but applicant status update failed.' : 'Payment verified, but applicant status update failed.'),
        'status_updated' => false,
        'status_update_error' => $statusError
    ]);
    exit;
}

echo json_encode([
    'success' => true,
    'message' => ($action === 'reject' ? 'Payment rejected successfully.' : 'Payment verified successfully.'),
    'status_updated' => true
]);
