<?php
header("Content-Type: application/json");

include_once "session.php";

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$SUPABASE_URL = "https://ncsobcjlvytbivoxezfd.supabase.co";
$SUPABASE_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzE1Njg3NzYsImV4cCI6MjA4NzE0NDc3Nn0.LWELQVNAh5GzjU-YUSrO5O3b3Gj-lP7pUB3A_D-vNfA";

$date = $_GET["date"] ?? "";
$type = strtolower(trim($_GET["type"] ?? "all"));

if (!in_array($type, ["all", "applicant", "sales"], true)) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid type filter. Use all, applicant, or sales."]);
    exit;
}

$dateObj = DateTime::createFromFormat("Y-m-d", $date);
if (!$dateObj || $dateObj->format("Y-m-d") !== $date) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid date format. Use YYYY-MM-DD."]);
    exit;
}

$start = DateTime::createFromFormat("Y-m-d H:i:s", $date . " 00:00:00");
$end = clone $start;
$end->modify("+1 day");

$startIso = $start->format("Y-m-d\\TH:i:s");
$endIso = $end->format("Y-m-d\\TH:i:s");

function fetchSupabaseRows(string $url, string $key): array {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: $key",
        "Authorization: Bearer $key",
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($response === false || $curlError) {
        throw new RuntimeException("Failed to connect to Supabase.");
    }

    $data = json_decode($response, true);
    if ($httpCode >= 400 || !is_array($data)) {
        throw new RuntimeException("Invalid response from Supabase.");
    }

    return $data;
}

$applicantUrl = $SUPABASE_URL . "/rest/v1/application_appointment_with_applicant"
    . "?select=AA_DateTime,AI_FirstName,AI_LastName,status"
    . "&AA_DateTime=gte." . rawurlencode($startIso)
    . "&AA_DateTime=lt." . rawurlencode($endIso)
    . "&order=AA_DateTime.asc";

$salesUrl = $SUPABASE_URL . "/rest/v1/sales_appointment_with_info"
    . "?select=SA_DateTime,SA_Status,SI_FirstName,SI_LastName,SI_MiddleName"
    . "&SA_DateTime=gte." . rawurlencode($startIso)
    . "&SA_DateTime=lt." . rawurlencode($endIso)
    . "&order=SA_DateTime.asc";

try {
    $applicantData = [];
    $salesData = [];

    if ($type === "all" || $type === "applicant") {
        $applicantData = fetchSupabaseRows($applicantUrl, $SUPABASE_KEY);
    }

    if ($type === "all" || $type === "sales") {
        $salesData = fetchSupabaseRows($salesUrl, $SUPABASE_KEY);
    }
} catch (RuntimeException $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
    exit;
}

$appointments = [];
foreach ($applicantData as $row) {
    if (empty($row["AA_DateTime"])) {
        continue;
    }

    try {
        $dateTime = new DateTime($row["AA_DateTime"]);
    } catch (Exception $e) {
        continue;
    }

    $timeStart = $dateTime->format("g:i A");
    $timeEnd = clone $dateTime;
    $timeEnd->modify("+1 hour");

    $fullName = trim(($row["AI_FirstName"] ?? "") . " " . ($row["AI_LastName"] ?? ""));
    if ($fullName === "") {
        $fullName = "Unknown";
    }

    $appointments[] = [
        "datetime" => $dateTime->format("c"),
        "time_range" => $timeStart . " - " . $timeEnd->format("g:i A"),
        "full_name" => $fullName,
        "status" => $row["status"] ?? null,
        "type" => "Career"
    ];
}

foreach ($salesData as $row) {
    if (empty($row["SA_DateTime"])) {
        continue;
    }

    try {
        $dateTime = new DateTime($row["SA_DateTime"]);
    } catch (Exception $e) {
        continue;
    }

    $timeStart = $dateTime->format("g:i A");
    $timeEnd = clone $dateTime;
    $timeEnd->modify("+1 hour");

    $fullName = trim(
        ($row["SI_FirstName"] ?? "")
        . " "
        . ($row["SI_MiddleName"] ?? "")
        . " "
        . ($row["SI_LastName"] ?? "")
    );

    if ($fullName === "") {
        $fullName = "Unknown";
    }

    $appointments[] = [
        "datetime" => $dateTime->format("c"),
        "time_range" => $timeStart . " - " . $timeEnd->format("g:i A"),
        "full_name" => $fullName,
        "status" => $row["SA_Status"] ?? null,
        "type" => "Sales"
    ];
}

usort($appointments, function (array $a, array $b): int {
    return strcmp($a["datetime"], $b["datetime"]);
});

echo json_encode([
    "date" => $date,
    "appointments" => $appointments
]);
