<?php
header("Content-Type: application/json");

$SUPABASE_URL = "https://ncsobcjlvytbivoxezfd.supabase.co";
$SUPABASE_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzE1Njg3NzYsImV4cCI6MjA4NzE0NDc3Nn0.LWELQVNAh5GzjU-YUSrO5O3b3Gj-lP7pUB3A_D-vNfA"; // keep safe

function supabaseGet($url, $key) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: $key",
        "Authorization: Bearer $key",
        "Content-Type: application/json"
    ]);

    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result, true);
}

function getMonthlyCounts($tableName, $supabaseUrl, $supabaseKey, $year) {
    $start = sprintf('%04d-01-01T00:00:00', $year);
    $end = sprintf('%04d-01-01T00:00:00', $year + 1);
    $url = $supabaseUrl . "/rest/v1/" . $tableName . "?select=created_at"
        . "&created_at=gte." . urlencode($start)
        . "&created_at=lt." . urlencode($end)
        . "&order=created_at.asc";

    $rows = supabaseGet($url, $supabaseKey);
    $counts = array_fill(1, 12, 0);

    if (is_array($rows)) {
        foreach ($rows as $row) {
            $createdAt = $row['created_at'] ?? null;
            if (!$createdAt) {
                continue;
            }

            try {
                $createdDate = new DateTime($createdAt);
            } catch (Throwable $e) {
                continue;
            }

            if ((int)$createdDate->format('Y') !== $year) {
                continue;
            }

            $month = (int)$createdDate->format('n');
            $counts[$month]++;
        }
    }

    return array_values($counts);
}

// ============================
// 1. PRIORITIES (JOINED DATA)
// ============================

$prioritiesUrl = $SUPABASE_URL . "/rest/v1/sales_priorities?select=pid,siid";

$prioritiesData = supabaseGet($prioritiesUrl, $SUPABASE_KEY);

// Get priority names separately
$priorityNamesUrl = $SUPABASE_URL . "/rest/v1/priorities?select=pid,PriorityName";
$priorityNamesData = supabaseGet($priorityNamesUrl, $SUPABASE_KEY);

// map pid → name
$map = [];
foreach ($priorityNamesData as $p) {
    $map[$p["pid"]] = $p["PriorityName"];
}

// count priorities
$priorityCount = [];

foreach ($prioritiesData as $row) {

    if (!isset($row["pid"]) || $row["pid"] === null) continue;

    // split "1,2,4" → [1,2,4]
    $pids = explode(",", $row["pid"]);

    foreach ($pids as $pid) {
        $pid = trim($pid); // remove spaces

        if ($pid === "") continue;

        if (!isset($priorityCount[$pid])) {
            $priorityCount[$pid] = 0;
        }

        $priorityCount[$pid]++;
    }
}
// format output
$priorities = [];
foreach ($priorityCount as $pid => $count) {
    $priorities[] = [
        "priority" => $map[$pid] ?? "Unknown",
        "count" => $count
    ];
}

// ============================
// 2. PAST JOBS
// ============================

$jobsUrl = $SUPABASE_URL . "/rest/v1/applicant_information?select=AI_CurrentJob";

$jobsData = supabaseGet($jobsUrl, $SUPABASE_KEY);

$jobCount = [];

foreach ($jobsData as $row) {
    $job = $row["AI_CurrentJob"];
    if (!$job) continue;

    if (!isset($jobCount[$job])) {
        $jobCount[$job] = 0;
    }
    $jobCount[$job]++;
}

$jobs = [];
foreach ($jobCount as $job => $count) {
    $jobs[] = [
        "job" => $job,
        "count" => $count
    ];
}

// ============================
// 3. MONTHLY ACTIVITY (LINE)
// ============================

$currentYear = (int)date('Y');
$monthlyLabels = [
    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
];

$monthlyApplicantCounts = getMonthlyCounts('applicant_information', $SUPABASE_URL, $SUPABASE_KEY, $currentYear);
$monthlySalesCounts = getMonthlyCounts('sales_information', $SUPABASE_URL, $SUPABASE_KEY, $currentYear);

// ============================
// OUTPUT
// ============================

echo json_encode([
    "priorities" => $priorities,
    "jobs" => $jobs,
    "monthly_activity" => [
        "year" => $currentYear,
        "labels" => $monthlyLabels,
        "applicants" => $monthlyApplicantCounts,
        "sales" => $monthlySalesCounts
    ]
]);