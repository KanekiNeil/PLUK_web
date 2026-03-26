<?php

$supabaseUrl = "https://ncsobcjlvytbivoxezfd.supabase.co";
$anonKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MTU2ODc3NiwiZXhwIjoyMDg3MTQ0Nzc2fQ.TLktUWOmr-iAZTy4Vm0F_ihUa2q_tQuP83RLTodPcEY";

// Optional filter
$aiid = $_GET['aiid'] ?? null;

$url = $supabaseUrl . "/rest/v1/application_appointment_with_applicant?select=*";

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

$appointments = [];

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
            $faceImage
        ];
    }
}

// IMPORTANT: return the array
return $appointments;