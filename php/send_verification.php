<?php
session_start();
header('Content-Type: application/json');

// Include PHPMailer
require_once __DIR__ . '/../vendor/phpmailer/Exception.php';
require_once __DIR__ . '/../vendor/phpmailer/PHPMailer.php';
require_once __DIR__ . '/../vendor/phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$supabaseUrl = "https://ncsobcjlvytbivoxezfd.supabase.co";
$supabaseKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MTU2ODc3NiwiZXhwIjoyMDg3MTQ0Nzc2fQ.TLktUWOmr-iAZTy4Vm0F_ihUa2q_tQuP83RLTodPcEY";

// Gmail SMTP Configuration
$gmailEmail = "prulifeukaoki@gmail.com";
$gmailAppPassword = "qwwpuzhibempdafc";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$email = $_POST['email'] ?? '';
$app_id = $_POST['app_id'] ?? null;

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit;
}

if (empty($app_id) || !preg_match('/^[0-9a-fA-F-]{36}$/', $app_id)) {
    echo json_encode(['success' => false, 'message' => 'Invalid application ID']);
    exit;
}

// Verify that the provided app_id exists in applicant_information
$lookupUrl = $supabaseUrl . "/rest/v1/applicant_information?select=uuid&uuid=eq." . urlencode($app_id);
$ch = curl_init($lookupUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $supabaseKey",
    "Authorization: Bearer $supabaseKey",
    "Content-Type: application/json"
]);

$lookupResponse = curl_exec($ch);
$lookupHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$lookupData = json_decode($lookupResponse, true);

if ($lookupHttpCode < 200 || $lookupHttpCode >= 300 || empty($lookupData)) {
    echo json_encode(['success' => false, 'message' => 'Application ID not found']);
    exit;
}

// Generate verification token
$token = bin2hex(random_bytes(32));
$expires_at = date('Y-m-d H:i:s', strtotime('+24 hours'));

// Store token in Supabase
$ch = curl_init($supabaseUrl . "/rest/v1/email_verification");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'email' => $email,
    'token' => $token,
    'expires_at' => $expires_at,
    'verified' => false,
    'app_id' => $app_id
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $supabaseKey",
    "Authorization: Bearer $supabaseKey",
    "Content-Type: application/json",
    "Prefer: return=representation"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode < 200 || $httpCode >= 300) {
    echo json_encode([
        'success' => false, 
        'message' => 'Failed to create verification token. HTTP Code: ' . $httpCode . ' Response: ' . $response
    ]);
    exit;
}

// Build verification URL
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
$verifyUrl = $baseUrl . "/PLUK_web/applicant/exam_payment.php?token=" . $token;

// Store email in session for later use
$_SESSION['pending_email'] = $email;
$_SESSION['verification_token'] = $token;

// Send email using PHPMailer
$mail = new PHPMailer(true);

try {
    // SMTP Configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $gmailEmail;
    $mail->Password = $gmailAppPassword;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    
    // Recipients
    $mail->setFrom($gmailEmail, 'Alpha Aquila');
    $mail->addAddress($email);
    
    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Verify Your Email - Alpha Aquila Licensing';
    $mail->Body = '
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background: #f5f5f5; }
            .container { max-width: 600px; margin: 0 auto; background: white; }
            .header { background: #8B3A3A; color: white; padding: 30px; text-align: center; }
            .header h1 { margin: 0; font-size: 28px; }
            .content { padding: 40px 30px; background: #ffffff; }
            .content h2 { color: #8B3A3A; margin-bottom: 20px; text-align: center; }
            .button-container { text-align: center; margin: 35px 0; }
            .button { display: inline-block; padding: 18px 45px; background: #8B3A3A; color: white !important; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px; }
            .link-text { background: #f5f5f5; padding: 15px; border-radius: 5px; word-break: break-all; font-size: 12px; color: #666; margin-top: 20px; }
            .footer { padding: 25px; text-align: center; color: #999; font-size: 12px; background: #f9f9f9; }
            .success-icon { font-size: 50px; margin-bottom: 15px; text-align: center; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>ALPHA AQUILA</h1>
            </div>
            <div class="content">
                <div class="success-icon">📧</div>
                <h2>Verify Your Email Address</h2>
                <p>Hello,</p>
                <p>Thank you for starting your licensing application with <strong>Alpha Aquila</strong>. To proceed to the next step of your licensing process, please verify your email address by clicking the button below:</p>
                
                <div class="button-container">
                    <a href="' . $verifyUrl . '" class="button">✓ VERIFY EMAIL & PROCEED</a>
                </div>
                
                <p style="color: #666; font-size: 13px;">If the button doesnt work, copy and paste this link into your browser:</p>
                <div class="link-text">' . $verifyUrl . '</div>
                
                <p style="margin-top: 25px; color: #666;"><strong>Whats next?</strong></p>
                <ul style="color: #666;">
                    <li>After verification, you will proceed to Exam Payment</li>
                    <li>Complete your Training Registration</li>
                    <li>Submit Training Payment</li>
                    <li>Final Review of your application</li>
                </ul>
                
                <p style="color: #999; font-size: 12px; margin-top: 25px;">This verification link will expire in 24 hours.</p>
            </div>
            <div class="footer">
                <p>© 2026 Alpha Aquila. All rights reserved.</p>
                <p>This is an automated email. Please do not reply.</p>
            </div>
        </div>
    </body>
    </html>
    ';
    
    $mail->AltBody = "Verify your email for Alpha Aquila Licensing. Click this link to proceed: $verifyUrl";
    
    $mail->send();
    
    echo json_encode([
        'success' => true, 
        'message' => 'Verification email sent! Please check your inbox at ' . $email . ' and click the verification link to proceed.',
        'email' => $email
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Failed to send email. Error: ' . $mail->ErrorInfo,
        'email' => $email,
        'testLink' => $verifyUrl
    ]);
}
?>
