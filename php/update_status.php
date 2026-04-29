<?php
header("Content-Type: application/json");

require_once __DIR__ . '/../vendor/phpmailer/Exception.php';
require_once __DIR__ . '/../vendor/phpmailer/PHPMailer.php';
require_once __DIR__ . '/../vendor/phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "message" => "Method not allowed. Use POST."
    ]);
    exit;
}

$supabaseUrl = "https://ncsobcjlvytbivoxezfd.supabase.co";
$serviceRoleKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MTU2ODc3NiwiZXhwIjoyMDg3MTQ0Nzc2fQ.TLktUWOmr-iAZTy4Vm0F_ihUa2q_tQuP83RLTodPcEY";
$gmailEmail = "prulifeukaoki@gmail.com";
$gmailAppPassword = "qwwpuzhibempdafc";

function fetchSupabaseRows(string $url, string $key): array
{
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'apikey: ' . $key,
                'Authorization: Bearer ' . $key,
                'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false || $curlError) {
                throw new RuntimeException('Failed to connect to Supabase.');
        }

        $data = json_decode($response, true);
        if ($httpCode >= 400 || !is_array($data)) {
                throw new RuntimeException('Invalid response from Supabase.');
        }

        return $data;
}

function sendRescheduleEmail(array $applicant, array $appointment, string $baseUrl, string $gmailEmail, string $gmailAppPassword, string $meetingLink = ''): void
{
        $email = trim((string)($applicant['AI_Email'] ?? ''));
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new RuntimeException('Applicant email address is missing or invalid.');
        }

        $fullName = trim((string)($applicant['AI_FirstName'] ?? '') . ' ' . (string)($applicant['AI_LastName'] ?? ''));
        if ($fullName === '') {
                $fullName = 'Applicant';
        }

        $appointmentDate = trim((string)($appointment['AA_DateTime'] ?? ''));
        $appointmentLabel = $appointmentDate !== '' ? (new DateTime($appointmentDate))->format('F j, Y g:i A') : 'your updated schedule';
                $meetingLink = trim($meetingLink);
                if ($meetingLink === '') {
                    $meetingLink = rtrim($baseUrl, '/') . '/PLUK_web/user/appointments.php?application_id=' . urlencode((string)($applicant['uuid'] ?? ''));
                }

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $gmailEmail;
        $mail->Password = $gmailAppPassword;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($gmailEmail, 'Prulife UK Black Orcas');
        $mail->addAddress($email, $fullName);

        $logoPath = __DIR__ . '/../assets/logo.jpg';
        if (is_file($logoPath)) {
                $mail->addEmbeddedImage($logoPath, 'logo.png');
        }

        $mail->isHTML(true);
        $mail->Subject = 'Your Rescheduled Appointment Request';
        $mail->Body = '
<div style="font-family: system-ui, sans-serif, Arial; font-size: 16px; background-color: #fff8f1">
    <div style="max-width: 600px; margin: auto; padding: 16px">
        <a style="text-decoration: none; outline: none" href="' . htmlspecialchars($baseUrl, ENT_QUOTES, 'UTF-8') . '/PLUK_web" target="_blank">
            <img
                style="height: 32px; vertical-align: middle"
                height="32px"
                src="cid:logo.png"
                alt="logo"
            />
        </a>
        <p>Hello ' . htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8') . ',</p>
        <p>
            Your rescheduling request has been received and your appointment has been updated.
        </p>
        <p>
            New appointment schedule: <strong>' . htmlspecialchars($appointmentLabel, ENT_QUOTES, 'UTF-8') . '</strong>
        </p>
        <p>
            <a href="' . htmlspecialchars($meetingLink, ENT_QUOTES, 'UTF-8') . '" style="
                display: inline-block;
                background-color: #e53935;
                color: white;
                padding: 10px 16px;
                text-decoration: none;
                border-radius: 6px;
                font-weight: 600;
            ">
                View Appointment
            </a>
        </p>
        <p>
            If you have any questions or need help getting started, our support team is just an email away
            at
            <a href="mailto:giga75852@gmail.com" style="text-decoration: none; outline: none; color: #fc0038"
                >giga75852@gmail.com</a
            >. We&#39;re here to assist you every step of the way!
        </p>
        <p>Best regards,<br />The Prulife UK Black Orcas Team</p>
    </div>
</div>';

        $mail->AltBody = 'Your rescheduled appointment request has been received. New schedule: ' . $appointmentLabel . '. View it here: ' . $meetingLink;
        $mail->send();
}

$rawInput = file_get_contents("php://input");
$jsonInput = json_decode($rawInput, true);
$input = is_array($jsonInput) ? $jsonInput : $_POST;

$status = trim($input['status'] ?? '');
$statusTarget = trim($input['status_target'] ?? 'appointment');
$applicantId = trim((string)($input['applicant_id'] ?? ''));
$aaid = trim((string)($input['aaid'] ?? ''));
$aiid = trim((string)($input['aiid'] ?? ''));
$said = trim((string)($input['said'] ?? ''));
$appointmentType = trim($input['appointment_type'] ?? 'applicant');
$appointmentDateTime = trim((string)($input['appointment_datetime'] ?? ''));
$meetingLink = trim((string)($input['meeting_link'] ?? ''));

if ($status === '') {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Status is required."
    ]);
    exit;
}

if ($statusTarget === 'applicant' || $statusTarget === 'applicant_information') {
    if ($applicantId === '') {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "applicant_id is required for applicant status updates."
        ]);
        exit;
    }

    $updateUrl = $supabaseUrl . "/rest/v1/applicant_information?uuid=eq." . urlencode($applicantId);
    $payload = json_encode(['status' => $status]);

    $ch = curl_init($updateUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: $serviceRoleKey",
        "Authorization: Bearer $serviceRoleKey",
        "Content-Type: application/json",
        "Prefer: return=representation"
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        $curlError = curl_error($ch);
        curl_close($ch);
        http_response_code(500);
        echo json_encode([
            "status" => "error",
            "message" => "Request failed: " . $curlError
        ]);
        exit;
    }

    curl_close($ch);

    if ($httpCode >= 400) {
        http_response_code($httpCode);
        echo json_encode([
            "status" => "error",
            "message" => "Supabase update failed.",
            "details" => $response
        ]);
        exit;
    }

    $updatedRows = json_decode($response, true);
    if (!is_array($updatedRows) || count($updatedRows) === 0) {
        http_response_code(404);
        echo json_encode([
            "status" => "error",
            "message" => "No matching applicant found to update."
        ]);
        exit;
    }

    echo json_encode([
        "status" => "success",
        "message" => "Applicant status updated successfully.",
        "data" => $updatedRows[0]
    ]);
    exit;
}

if ($appointmentType === 'sales') {
    // Sales appointment update
    if ($said === '') {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "SAID (Sales Appointment ID) is required for sales appointments."
        ]);
        exit;
    }
    $updateUrl = $supabaseUrl . "/rest/v1/sales_appointment?said=eq." . urlencode($said);
} else {
    // Applicant appointment update
    if ($aaid === '' && $aiid === '') {
        http_response_code(400);
        echo json_encode([
            "status" => "error",
            "message" => "Provide AAID, or AIID with appointment_datetime."
        ]);
        exit;
    }
    if ($aaid !== '') {
        $updateUrl = $supabaseUrl . "/rest/v1/application_appointment?AAID=eq." . urlencode($aaid);
    } else {
        $updateUrl = $supabaseUrl . "/rest/v1/application_appointment?aiid=eq." . urlencode($aiid);
    }
}

// Use appropriate status column name
$statusColumn = ($appointmentType === 'sales') ? 'SA_Status' : 'status';
$payloadData = [$statusColumn => $status];

if ($appointmentType !== 'sales' && $appointmentDateTime !== '') {
    try {
        $normalizedDateTime = (new DateTime($appointmentDateTime))->format('Y-m-d H:i:s');
        $payloadData['AA_DateTime'] = $normalizedDateTime;
    } catch (Throwable $e) {
        http_response_code(422);
        echo json_encode([
            "status" => "error",
            "message" => "Invalid appointment_datetime value."
        ]);
        exit;
    }
}

$payload = json_encode($payloadData);

$ch = curl_init($updateUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $serviceRoleKey",
    "Authorization: Bearer $serviceRoleKey",
    "Content-Type: application/json",
    "Prefer: return=representation"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    $curlError = curl_error($ch);
    curl_close($ch);
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Request failed: " . $curlError
    ]);
    exit;
}

curl_close($ch);

if ($httpCode >= 400) {
    http_response_code($httpCode);
    echo json_encode([
        "status" => "error",
        "message" => "Supabase update failed.",
        "details" => $response
    ]);
    exit;
}

$updatedRows = json_decode($response, true);

if (!is_array($updatedRows) || count($updatedRows) === 0) {
    http_response_code(404);
    echo json_encode([
        "status" => "error",
        "message" => "No matching appointment found to update."
    ]);
    exit;
}

$emailNotice = null;
if ($appointmentType !== 'sales' && strtolower($status) === 'rescheduled') {
    try {
        $appointmentRow = $updatedRows[0];
        $resolvedAiid = trim((string)($aiid !== '' ? $aiid : ($appointmentRow['aiid'] ?? $appointmentRow['applicant_aiid'] ?? '')));

        if ($resolvedAiid === '' && $aaid !== '') {
            $appointmentLookupUrl = $supabaseUrl . '/rest/v1/application_appointment_with_applicant?select=applicant_aiid,AA_DateTime,aaid&aaid=eq.' . urlencode($aaid) . '&limit=1';
            $appointmentLookupRows = fetchSupabaseRows($appointmentLookupUrl, $serviceRoleKey);

            if (!empty($appointmentLookupRows)) {
                $appointmentRow = array_merge($appointmentRow, $appointmentLookupRows[0]);
                $resolvedAiid = trim((string)($appointmentLookupRows[0]['applicant_aiid'] ?? ''));
            }
        }

        if ($resolvedAiid === '') {
            throw new RuntimeException('Unable to resolve the applicant record for the reschedule email.');
        }

        $applicantUrl = $supabaseUrl . '/rest/v1/applicant_information?select=uuid,aiid,AI_FirstName,AI_LastName,AI_Email,AI_ContactNum,AI_CurrentJob,status&aiid=eq.' . urlencode($resolvedAiid) . '&limit=1';
        $applicantRows = fetchSupabaseRows($applicantUrl, $serviceRoleKey);

        if (empty($applicantRows)) {
            throw new RuntimeException('Applicant record was not found for the reschedule email.');
        }

        $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
        sendRescheduleEmail($applicantRows[0], $appointmentRow, $baseUrl, $gmailEmail, $gmailAppPassword, $meetingLink);
    } catch (Throwable $e) {
        $emailNotice = $e->getMessage();
    }
}

echo json_encode([
    "status" => "success",
    "message" => "Appointment status updated successfully.",
    "data" => $updatedRows[0],
    "email_notice" => $emailNotice
]);
