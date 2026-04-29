<?php

header("Content-Type: application/json");

$supabaseUrl = "https://ncsobcjlvytbivoxezfd.supabase.co";
$anonKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MTU2ODc3NiwiZXhwIjoyMDg3MTQ0Nzc2fQ.TLktUWOmr-iAZTy4Vm0F_ihUa2q_tQuP83RLTodPcEY";

// ============================
// GET TOTAL APPLICANTS
// ============================

$url = $supabaseUrl . "/rest/v1/applicant_information?select=count";

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $anonKey",
    "Authorization: Bearer $anonKey",
    "Prefer: count=exact",
    "Content-Type: application/json"
]);

curl_setopt($ch, CURLOPT_HEADER, true);

$response = curl_exec($ch);

$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

$headers = substr($response, 0, $headerSize);
$body = substr($response, $headerSize);

curl_close($ch);

// Extract count from Content-Range header
$totalApplicants = 0;

if (preg_match('/Content-Range:\s\d+-\d+\/(\d+)/i', $headers, $matches)) {
    $totalApplicants = (int)$matches[1];
}

echo json_encode([
    "success" => true,
    "totalApplicants" => $totalApplicants
]);

?>