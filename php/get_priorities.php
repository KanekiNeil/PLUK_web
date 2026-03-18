<?php

$supabaseUrl = "https://ncsobcjlvytbivoxezfd.supabase.co";
$anonKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzE1Njg3NzYsImV4cCI6MjA4NzE0NDc3Nn0.LWELQVNAh5GzjU-YUSrO5O3b3Gj-lP7pUB3A_D-vNfA";

$url = $supabaseUrl . "/rest/v1/priorities?select=*&order=id.asc";

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $anonKey",
    "Authorization: Bearer $anonKey",
    "Content-Type: application/json"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$data = json_decode($response, true);

$priorities = [];

if ($httpCode === 200 && $data && is_array($data)) {
    foreach ($data as $row) {
        $id = $row['id'] ?? $row['pid'] ?? null;
        $name = $row['PriorityName'] ?? $row['name'] ?? $row['priority_name'] ?? '';
        
        if ($id && $name) {
            $priorities[] = [
                'id' => $id,
                'name' => $name
            ];
        }
    }
}

return $priorities;
