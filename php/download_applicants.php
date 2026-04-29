<?php

$supabaseUrl = "https://ncsobcjlvytbivoxezfd.supabase.co";
$anonKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MTU2ODc3NiwiZXhwIjoyMDg3MTQ0Nzc2fQ.TLktUWOmr-iAZTy4Vm0F_ihUa2q_tQuP83RLTodPcEY";

$start = $_GET['start'] ?? null;
$end = $_GET['end'] ?? null;

if (!$start || !$end) {
    die("Invalid date range");
}

// include full day range for end date
$startDate = $start . "T00:00:00";
$endDate = $end . "T23:59:59";

// Supabase query
$url = $supabaseUrl . "/rest/v1/applicant_information?select=*"
    . "&created_at=gte." . $startDate
    . "&created_at=lte." . $endDate;

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

// CSV output
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="applicants.csv"');

$output = fopen('php://output', 'w');

// headers
fputcsv($output, [
    "Full Name",
    "Email",
    "Address",
    "Birthdate",
    "Current Job",
    "School Graduated",
    "Contact Number"
]);

// rows
if ($data) {
    foreach ($data as $item) {

        $fullName = $item['AI_LastName'] . ", " . $item['AI_FirstName'];

        fputcsv($output, [
            $fullName,
            $item['AI_Email'],
            $item['AI_Address'],
            $item['AI_Birthdate'],
            $item['AI_CurrentJob'],
            $item['AI_SchoolGraduated'],
            $item['AI_ContactNum']
        ]);
    }
}

fclose($output);
exit;

?>