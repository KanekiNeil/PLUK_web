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

$applicationId = trim($_GET['application_id'] ?? '');

if ($applicationId === '' || !preg_match('/^[0-9a-fA-F-]{36}$/', $applicationId)) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'A valid application_id is required.'
    ]);
    exit;
}

$supabaseUrl = 'https://ncsobcjlvytbivoxezfd.supabase.co';
$supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MTU2ODc3NiwiZXhwIjoyMDg3MTQ0Nzc2fQ.TLktUWOmr-iAZTy4Vm0F_ihUa2q_tQuP83RLTodPcEY';

function fetchSupabaseRows(string $url, string $key): array {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'apikey: ' . $key,
        'Authorization: Bearer ' . $key,
        'Content-Type: application/json'
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($response === false || $curlError) {
        throw new RuntimeException('Failed to connect to Supabase.');
    }

    $data = json_decode($response, true);
    if ($httpCode >= 400 || !is_array($data)) {
        throw new RuntimeException('Invalid response from Supabase.');
    }

    return $data;
}

try {
    $applicantUrl = $supabaseUrl . '/rest/v1/applicant_information?select=uuid,aiid,AI_FirstName,AI_LastName,AI_ContactNum,AI_CurrentJob,status&uuid=eq.' . urlencode($applicationId) . '&limit=1';
    $applicantRows = fetchSupabaseRows($applicantUrl, $supabaseKey);

    if (empty($applicantRows)) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Application ID not found.'
        ]);
        exit;
    }

    $applicant = $applicantRows[0];
    $aiid = $applicant['aiid'] ?? '';

    if ($aiid === '') {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'No linked appointment record was found for this application.'
        ]);
        exit;
    }

    $appointmentUrl = $supabaseUrl . '/rest/v1/application_appointment_with_applicant?select=aaid,AA_DateTime,status,AA_FaceID,applicant_aiid,AI_FirstName,AI_LastName,AI_ContactNum,AI_CurrentJob&applicant_aiid=eq.' . urlencode($aiid) . '&order=AA_DateTime.desc&limit=1';
    $appointmentRows = fetchSupabaseRows($appointmentUrl, $supabaseKey);

    if (empty($appointmentRows)) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'No appointment is currently scheduled for this application.'
        ]);
        exit;
    }

    $appointment = $appointmentRows[0];
    $dateTime = new DateTime($appointment['AA_DateTime']);
    $timeStart = $dateTime->format('g:i A');
    $timeEnd = clone $dateTime;
    $timeEnd->modify('+1 hour');

    $fullName = trim(($applicant['AI_FirstName'] ?? '') . ' ' . ($applicant['AI_LastName'] ?? ''));
    if ($fullName === '') {
        $fullName = 'Unknown Applicant';
    }

    echo json_encode([
        'success' => true,
        'data' => [
            'application_id' => $applicationId,
            'aiid' => $aiid,
            'full_name' => $fullName,
            'contact_number' => $applicant['AI_ContactNum'] ?? '',
            'current_job' => $applicant['AI_CurrentJob'] ?? '',
            'applicant_status' => $applicant['status'] ?? '',
            'appointment' => [
                'aaid' => $appointment['AAID'] ?? '',
                'datetime' => $appointment['AA_DateTime'],
                'date' => $dateTime->format('F j, Y'),
                'time_range' => $timeStart . ' - ' . $timeEnd->format('g:i A'),
                'status' => $appointment['status'] ?? '',
                'type' => 'Career'
            ]
        ]
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}