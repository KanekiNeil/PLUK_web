<?php

$supabaseUrl = "https://ncsobcjlvytbivoxezfd.supabase.co";
$anonKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MTU2ODc3NiwiZXhwIjoyMDg3MTQ0Nzc2fQ.TLktUWOmr-iAZTy4Vm0F_ihUa2q_tQuP83RLTodPcEY";

// Optional filter
$aiid = $_GET['aiid'] ?? null;

$url = $supabaseUrl . "/rest/v1/applicant_information?select=*";

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

$applicant = [];

if ($data) {
    foreach ($data as $row) {

        $fullName = $row['AI_FirstName'] . " " . $row['AI_LastName'];
        $contactNo = $row['AI_PhoneNum'] ?? "N/A";
        $schoolGraduated = $row['AI_SchoolGraduated'] ?? "N/A";
        $currentJob = $row['AI_CurrentJob'] ?? "N/A";
        $address = $row['AI_Address'] ?? "N/A";
        $workStatus = $row['AI_WorkStatus'] ?? "N/A";

        $applicant[] = [
            $fullName,
            $contactNo,
            $schoolGraduated,
            $currentJob,
            $address,
            $workStatus
        ];
    }
}

// IMPORTANT: return the array
return $applicant;