<?php

$supabaseUrl = "https://ncsobcjlvytbivoxezfd.supabase.co";
$anonKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MTU2ODc3NiwiZXhwIjoyMDg3MTQ0Nzc2fQ.TLktUWOmr-iAZTy4Vm0F_ihUa2q_tQuP83RLTodPcEY";

// Optional filter
$aiid = $_GET['aiid'] ?? null;

$url = $supabaseUrl . "/rest/v1/available_dates?select=*";

if ($aiid) {
    $url .= "&aiid=eq." . urlencode($aiid);
}
if (isset($_GET['type']) && $_GET['type'] === 'applicant') {
    $url .= "&appointment_type=eq.applicant";
}elseif (isset($_GET['type']) && $_GET['type'] === 'client') {
    $url .= "&appointment_type=eq.client";
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

$dates = [];

if ($data) {
    foreach ($data as $row) {
        $date = $row['date'];
        $dates[] = $date;
    }
}

// IMPORTANT: return the array
return $dates;