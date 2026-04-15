<?php

$supabaseUrl = "https://ncsobcjlvytbivoxezfd.supabase.co";
$anonKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MTU2ODc3NiwiZXhwIjoyMDg3MTQ0Nzc2fQ.TLktUWOmr-iAZTy4Vm0F_ihUa2q_tQuP83RLTodPcEY";

// Optional filter
$aiid = $_GET['aiid'] ?? null;
$type = $_GET['type'] ?? null; // 'applicant', 'sales', or null for both

$appointments = [];

// ============================
// 1. FETCH APPLICATION APPOINTMENTS
// ============================
if (!$type || $type === 'applicant') {
    $url = $supabaseUrl . "/rest/v1/application_appointment_with_applicant?select=*&order=AA_DateTime.desc";

    if ($aiid) {
        $url .= "&aiid=eq." . urlencode($aiid);
    }

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: $anonKey",
        "Authorization: Bearer $anonKey",
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if ($data) {
        foreach ($data as $row) {

            $dateTime = new DateTime($row['AA_DateTime']);

            $date = $dateTime->format('Y-m-d');
            $timeStart = $dateTime->format('g:i A');

            $timeEnd = clone $dateTime;
            $timeEnd->modify('+1 hour');
            $timeRange = $timeStart . "-" . $timeEnd->format('g:i A');

            $fullName = $row['AI_FirstName'] . " " . $row['AI_LastName'];
            $faceImage = $row['AA_FaceID']; // Assuming this is a base64 string of the image
            $aiid = $row['appointment_aiid']  ?? null;
            $appointmentDateTime = $row['AA_DateTime'];
            $currentJob = $row['AI_CurrentJob'] ?? null;
            $contactNum = $row['AI_ContactNum'] ?? null;

            $aaid = null;
            foreach ($row as $key => $value) {
                if (strtolower((string)$key) === 'aaid') {
                    $aaid = $value;
                    break;
                }
            }

            $appointments[] = [
                $aaid,
                $aiid,
                $date,
                $timeRange,
                $fullName,
                "Career", // Placeholder for appointment type
                $row['status'],
                $faceImage,
                $currentJob,
                $contactNum,
                "applicant",  // [10] Type indicator
                $appointmentDateTime  // [11] Full datetime for sorting
            ];
        }
    }
}

// ============================
// 2. FETCH SALES APPOINTMENTS
// ============================
if (!$type || $type === 'sales') {
    $url = $supabaseUrl . "/rest/v1/sales_appointment_with_info?select=*&order=SA_DateTime.desc";

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: $anonKey",
        "Authorization: Bearer $anonKey",
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if ($data) {
        foreach ($data as $row) {

            $dateTime = new DateTime($row['SA_DateTime']);

            $date = $dateTime->format('Y-m-d');
            $timeStart = $dateTime->format('g:i A');

            $timeEnd = clone $dateTime;
            $timeEnd->modify('+1 hour');
            $timeRange = $timeStart . "-" . $timeEnd->format('g:i A');

            $fullName = trim(($row['SI_FirstName'] ?? '') . " " . ($row['SI_MiddleName'] ?? '') . " " . ($row['SI_LastName'] ?? ''));
            if ($fullName === '') {
                $fullName = "Unknown Client";
            }

            $faceImage = $row['faceid'] ?? null;
            $said = $row['appointment_said'] ?? null;
            $client_siid = $row['client_siid'] ?? null;
            $appointmentDateTime = $row['SA_DateTime'];
            $contactNum = $row['SI_PhoneNum'] ?? null;

            $appointments[] = [
                $said,
                $client_siid,
                $date,
                $timeRange,
                $fullName,
                "Sales", // Appointment type
                $row['SA_Status'] ?? null,
                $faceImage,
                null,  // No current job for sales
                $contactNum,
                "sales",  // [10] Type indicator
                $appointmentDateTime  // [11] Full datetime for sorting
            ];
        }
    }
}

// ============================
// 3. SORT ALL APPOINTMENTS BY DATETIME (DESC)
// ============================
usort($appointments, function($a, $b) {
    return strtotime($b[11]) - strtotime($a[11]);
});

// IMPORTANT: return the array
return $appointments;