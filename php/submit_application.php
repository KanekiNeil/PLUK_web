<?php
header("Content-Type: application/json");

// Your Supabase project info
$SUPABASE_URL = "https://ncsobcjlvytbivoxezfd.supabase.co";
$SUPABASE_KEY = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzE1Njg3NzYsImV4cCI6MjA4NzE0NDc3Nn0.LWELQVNAh5GzjU-YUSrO5O3b3Gj-lP7pUB3A_D-vNfA";

// ---------------------------
// 1️⃣ GET FORM DATA
// ---------------------------
$firstName           = trim($_POST['first_name'] ?? '');
$lastName            = trim($_POST['last_name'] ?? '');
$middleName          = trim($_POST['middle_name'] ?? '');
$email               = trim($_POST['email'] ?? '');
$address             = trim($_POST['address'] ?? '');
$birthdate           = trim($_POST['birthdate'] ?? '');
$currentJob          = trim($_POST['current_job'] ?? '');
$schoolGraduated     = trim($_POST['school_graduated'] ?? '');
$faceImage           = $_POST['face_image'] ?? '';
$phone               = trim($_POST['phone'] ?? '');
$appointmentDate     = trim($_POST['appointment_date'] ?? '');
$applicationType     = trim($_POST['application_type'] ?? 'applicant');
$selectedPriorities  = trim($_POST['selected_priorities'] ?? '');

// Get priority IDs from either hidden field or checkbox array
$priorityIds = [];
if (!empty($selectedPriorities)) {
    $priorityIds = array_filter(array_map('trim', explode(',', $selectedPriorities)));
} else if (isset($_POST['priority_id']) && is_array($_POST['priority_id'])) {
    $priorityIds = array_filter(array_map('trim', $_POST['priority_id']));
}

if (!in_array($applicationType, ['applicant', 'sales'], true)) {
    $applicationType = 'applicant';
}

if ($appointmentDate) {
    $dateTime = new DateTime($appointmentDate . ' 08:00 PM');
    $appointmentDate = $dateTime->format('Y-m-d H:i:s');
}

// ---------------------------
// 2️⃣ BASIC VALIDATION
// ---------------------------
$errors = [];
if (!$firstName) $errors[] = "First Name is required.";
if (!$lastName)  $errors[] = "Last Name is required.";
if (!$email)     $errors[] = "Email is required.";
if (!$appointmentDate) $errors[] = "Please select an appointment date.";
if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
}
if (!empty($errors)) {
    echo json_encode(["status" => "error", "message" => implode(" ", $errors)]);
    exit;
}

// ---------------------------
// 3️⃣ PROCESS FACE IMAGE
// ---------------------------
if ($applicationType === 'applicant' && !$faceImage) {
    echo json_encode(["status" => "error", "message" => "Face image is required."]);
    exit;
}

if ($faceImage) {
    $faceImage = preg_replace('/^data:image\/\w+;base64,/', '', $faceImage); // remove prefix
    // keep as base64 string, Supabase TEXT column can store this
}

// ---------------------------
// 4️⃣ INSERT INTO applicant_information
// ---------------------------
$applicantData = [
    "AI_FirstName" => $firstName,
    "AI_LastName" => $lastName,
    "AI_Email" => $email,
    "AI_Address" => $address ?: null,
    "AI_Birthdate" => $birthdate ?: null,
    "AI_CurrentJob" => $currentJob ?: null,
    "AI_SchoolGraduated" => $schoolGraduated ?: null
];
$salesData = [
    "SI_FirstName" => $firstName,
    "SI_MiddleName" => $middleName ?: null,
    "SI_LastName" => $lastName,
    "SI_Email" => $email,
    "SI_PhoneNum" => $phone ?: null,
];

// Use curl to POST JSON to Supabase REST endpoint
function supabaseInsert($table, $data, $SUPABASE_URL, $SUPABASE_KEY) {
    $ch = curl_init("$SUPABASE_URL/rest/v1/$table");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: $SUPABASE_KEY",
        "Authorization: Bearer $SUPABASE_KEY",
        "Content-Type: application/json",
        "Prefer: return=representation" // return inserted row
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([$data]));
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        throw new Exception("Curl error: $error_msg");
    }
    curl_close($ch);
    if ($httpCode >= 400) {
        throw new Exception("Supabase API error: $response");
    }
    $rows = json_decode($response, true);
    return $rows[0] ?? null;
}

try {
    if ($applicationType === 'applicant') {

        $insertedApplicant = supabaseInsert("applicant_information", $applicantData, $SUPABASE_URL, $SUPABASE_KEY);
        if (!$insertedApplicant || !isset($insertedApplicant["aiid"])) {
            throw new Exception("Failed to create applicant record.");
        }

        $AIID = $insertedApplicant["aiid"];

        $appointmentData = [
            "AA_FaceID" => ($faceImage ?: null),
            "AA_DateTime" => $appointmentDate,
            "aiid" => $AIID
        ];

        supabaseInsert("application_appointment", $appointmentData, $SUPABASE_URL, $SUPABASE_KEY);

    } else {

        $insertedSales = supabaseInsert("sales_information", $salesData, $SUPABASE_URL, $SUPABASE_KEY);
        if (!$insertedSales) {
            throw new Exception("Failed to create sales record.");
        }

        $SIID = $insertedSales["siid"] ?? $insertedSales["SIID"] ?? $insertedSales["id"] ?? null;
        if (!$SIID) {
            throw new Exception("Sales record inserted but ID was not returned.");
        }

        $salesAppointmentData = [
            "SA_DateTime" => $appointmentDate,
            "siid" => $SIID
        ];

        supabaseInsert("sales_appointment", $salesAppointmentData, $SUPABASE_URL, $SUPABASE_KEY);

        // Insert selected priorities into sales_priorities table as comma-separated text
        if (!empty($priorityIds)) {
            $prioritiesText = implode(',', $priorityIds);
            $priorityData = [
                "siid" => $SIID,
                "pid" => $prioritiesText
            ];
            supabaseInsert("sales_priorities", $priorityData, $SUPABASE_URL, $SUPABASE_KEY);
        }
    }

    echo json_encode(["status" => "success", "message" => "Your application was submitted successfully!"]);

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}