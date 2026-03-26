<?php
session_start();

$supabaseUrl = "https://ncsobcjlvytbivoxezfd.supabase.co";
$supabaseKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MTU2ODc3NiwiZXhwIjoyMDg3MTQ0Nzc2fQ.TLktUWOmr-iAZTy4Vm0F_ihUa2q_tQuP83RLTodPcEY";

$token = $_GET['token'] ?? '';
$error = '';
$success = false;
$email = '';

if (!empty($token)) {
    // Check token in Supabase
    $ch = curl_init($supabaseUrl . "/rest/v1/email_verification?token=eq." . urlencode($token) . "&select=*");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: $supabaseKey",
        "Authorization: Bearer $supabaseKey",
        "Content-Type: application/json"
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $data = json_decode($response, true);
    
    if ($httpCode >= 200 && $httpCode < 300 && !empty($data)) {
        $record = $data[0];
        $email = $record['email'];
        
        // Check if already verified
        if ($record['verified']) {
            $success = true;
            $_SESSION['email'] = $email;
            $_SESSION['email_verified'] = true;
        }
        // Check if expired
        else if (strtotime($record['expires_at']) < time()) {
            $error = 'This verification link has expired. Please request a new one.';
        }
        else {
            // Mark as verified in Supabase
            $ch = curl_init($supabaseUrl . "/rest/v1/email_verification?token=eq." . urlencode($token));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['verified' => true]));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "apikey: $supabaseKey",
                "Authorization: Bearer $supabaseKey",
                "Content-Type: application/json",
                "Prefer: return=representation"
            ]);
            
            $updateResponse = curl_exec($ch);
            $updateCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($updateCode >= 200 && $updateCode < 300) {
                $success = true;
                $_SESSION['email'] = $email;
                $_SESSION['email_verified'] = true;
            } else {
                $error = 'Failed to verify email. Please try again.';
            }
        }
    } else {
        $error = 'Invalid verification link.';
    }
} else {
    $error = 'No verification token provided.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - Alpha Aquila</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .header {
            background: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: bold;
            font-size: 16px;
            color: #8B3A3A;
        }
        
        .logo img {
            width: 40px;
            height: 40px;
        }
        
        .container {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 40px;
        }
        
        .icon.success {
            background: #e8f5e9;
            color: #4CAF50;
        }
        
        .icon.error {
            background: #ffebee;
            color: #f44336;
        }
        
        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 15px;
        }
        
        p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 25px;
        }
        
        .email {
            font-weight: bold;
            color: #8B3A3A;
        }
        
        .btn {
            display: inline-block;
            padding: 14px 40px;
            background: #8B3A3A;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 16px;
            transition: background 0.3s;
        }
        
        .btn:hover {
            background: #6B2A2A;
        }
        
        .btn-secondary {
            background: #666;
        }
        
        .btn-secondary:hover {
            background: #444;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="../assets/nobg_logo.png" alt="Alpha Aquila Logo">
            <span>ALPHA AQUILA</span>
        </div>
    </div>
    
    <div class="container">
        <?php if ($success): ?>
            <div class="icon success">✓</div>
            <h1>Email Verified!</h1>
            <p>Your email <span class="email"><?php echo htmlspecialchars($email); ?></span> has been successfully verified.</p>
            <p>Click the button below to proceed to the next step.</p>
            <a href="exam_payment.php" class="btn" id="proceedBtn">Proceed to Exam Payment</a>
            
            <script>
                // Mark step 1 as completed in localStorage
                const completedSteps = JSON.parse(localStorage.getItem('completedSteps') || '[]');
                if (!completedSteps.includes(1)) {
                    completedSteps.push(1);
                    localStorage.setItem('completedSteps', JSON.stringify(completedSteps));
                }
            </script>
        <?php else: ?>
            <div class="icon error">✕</div>
            <h1>Verification Failed</h1>
            <p><?php echo htmlspecialchars($error); ?></p>
            <a href="verify_email.php" class="btn btn-secondary">Back to Verification</a>
        <?php endif; ?>
    </div>
</body>
</html>
