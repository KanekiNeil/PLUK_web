<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed. Use GET.'
    ]);
    exit;
}

$supabaseUrl = 'https://ncsobcjlvytbivoxezfd.supabase.co';
$anonKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MTU2ODc3NiwiZXhwIjoyMDg3MTQ0Nzc2fQ.TLktUWOmr-iAZTy4Vm0F_ihUa2q_tQuP83RLTodPcEY';

$now = new DateTime('now');
$today = $now->format('Y-m-d');
$currentTime = $now->format('H:i:s');

$url = $supabaseUrl . '/rest/v1/available_dates?select=date,start_time,end_time,appointment_type&appointment_type=eq.applicant&date=gte.' . rawurlencode($today) . '&order=date.asc,start_time.asc';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'apikey: ' . $anonKey,
    'Authorization: Bearer ' . $anonKey,
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    $curlError = curl_error($ch);
    curl_close($ch);
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Unable to fetch available dates.',
        'error' => $curlError
    ]);
    exit;
}

curl_close($ch);

if ($httpCode >= 400) {
    http_response_code($httpCode);
    echo json_encode([
        'success' => false,
        'message' => 'Supabase request failed.',
        'details' => $response
    ]);
    exit;
}

$decoded = json_decode($response, true);

if (!is_array($decoded)) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid response received from the data source.'
    ]);
    exit;
}

$slots = [];
foreach ($decoded as $row) {
    $date = $row['date'] ?? null;
    $startTime = $row['start_time'] ?? null;
    $endTime = $row['end_time'] ?? null;

    if (!$date) {
        continue;
    }

    if ($date === $today && $startTime) {
        $startParts = explode(':', (string)$startTime);
        $startHour = isset($startParts[0]) ? (int)$startParts[0] : null;
        $startMinute = isset($startParts[1]) ? (int)$startParts[1] : 0;

        if ($startHour !== null) {
            $slotStart = (clone $now)->setTime($startHour, $startMinute, 0);
            if ($slotStart < $now) {
                continue;
            }
        }
    }

    $slots[] = [
        'date' => $date,
        'start_time' => $startTime,
        'end_time' => $endTime,
        'appointment_type' => $row['appointment_type'] ?? 'applicant'
    ];
}

echo json_encode([
    'success' => true,
    'data' => $slots
]);
