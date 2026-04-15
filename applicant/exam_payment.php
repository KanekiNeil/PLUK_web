<?php
session_start();

// Prefer token from URL (email link), fallback to session
$token = $_GET['token'] ?? ($_SESSION['verification_token'] ?? '');

if (empty($token)) {
    header('Location: verify_email.php');
    exit;
}

$supabaseUrl = "https://ncsobcjlvytbivoxezfd.supabase.co";
$anonKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MTU2ODc3NiwiZXhwIjoyMDg3MTQ0Nzc2fQ.TLktUWOmr-iAZTy4Vm0F_ihUa2q_tQuP83RLTodPcEY";

$ch = curl_init($supabaseUrl . "/rest/v1/email_verification?select=email,app_id&token=eq." . urlencode($token));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $anonKey",
    "Authorization: Bearer $anonKey",
    "Content-Type: application/json"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr = curl_error($ch);
curl_close($ch);

if ($response === false || !empty($curlErr)) {
    $_SESSION['pending_email'] = "Error fetching email. Please verify your email again.";
} elseif ($httpCode >= 200 && $httpCode < 300) {
    $data = json_decode($response, true);
    if (is_array($data) && isset($data[0]['email']) && !empty($data[0]['email'])) {
        $_SESSION['pending_email'] = $data[0]['email'];
        $_SESSION['verification_token'] = $token;
		$_SESSION['app_id'] = $data[0]['app_id'];
    } else {
        $_SESSION['pending_email'] = "Email not found. Please verify your email again.";
    }
} else {
    $_SESSION['pending_email'] = "Error fetching email. Please verify your email again.";
}

$isExamPaymentVerified = false;
$sessionAppId = $_SESSION['app_id'] ?? null;

if (!empty($sessionAppId)) {
	$verifyPaymentUrl = $supabaseUrl . "/rest/v1/exam_payment?select=verified&applicant_id=eq." . urlencode($sessionAppId);
	$verifyCh = curl_init($verifyPaymentUrl);
	curl_setopt($verifyCh, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($verifyCh, CURLOPT_HTTPHEADER, [
		"apikey: $anonKey",
		"Authorization: Bearer $anonKey",
		"Content-Type: application/json"
	]);

	$verifyResponse = curl_exec($verifyCh);
	$verifyHttpCode = curl_getinfo($verifyCh, CURLINFO_HTTP_CODE);
	curl_close($verifyCh);

	if ($verifyResponse !== false && $verifyHttpCode >= 200 && $verifyHttpCode < 300) {
		$verifyData = json_decode($verifyResponse, true);
		if (is_array($verifyData)) {
			foreach ($verifyData as $row) {
				if (!empty($row['verified'])) {
					$isExamPaymentVerified = true;
					break;
				}
			}
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Confirm Payment - Alpha Aquila</title>
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}
		
		body {
			font-family: Arial, Helvetica, sans-serif;
			background: #f5f5f5;
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
			max-width: 900px;
			margin: 20px auto;
			background: white;
			padding: 25px 40px;
			border-radius: 8px;
			box-shadow: 0 2px 10px rgba(0,0,0,0.1);
		}
		
		.steps-progress {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 40px;
			position: relative;
		}
		
		.steps-progress::before {
			display: none;
		}
		
		.step {
			display: flex;
			flex-direction: column;
			align-items: center;
			gap: 10px;
			flex: 1;
			position: relative;
			z-index: 2;
			cursor: pointer;
		}
		
		.step::after {
			content: '';
			position: absolute;
			top: 20px;
			left: calc(50% + 25px);
			width: calc(100% - 50px);
			height: 2px;
			background: #ccc;
			z-index: 0;
		}
		
		.step:last-child::after {
			display: none;
		}
		
		.step.completed::after {
			background: #8B3A3A;
		}
		
		.step.completed .step-number {
			background: #8B3A3A;
			color: white;
			border-color: #8B3A3A;
		}
		
		.step.active .step-number {
			background: #8B3A3A;
			color: white;
			border-color: #8B3A3A;
		}
		
		.step-number {
			width: 42px;
			height: 42px;
			border-radius: 50%;
			background: white;
			border: 2px solid #ccc;
			display: flex;
			align-items: center;
			justify-content: center;
			font-weight: bold;
			color: #666;
			font-size: 15px;
			transition: transform 0.2s ease;
		}
		
		.step:hover .step-number {
			transform: scale(1.1);
		}
		
		.step.locked {
			cursor: not-allowed;
			opacity: 0.5;
		}
		
		.step.locked:hover .step-number {
			transform: none;
		}
		
		.step.locked .step-number {
			background: #e0e0e0;
			border-color: #ccc;
			color: #999;
		}
		
		.step.completed .step-number {
			background: #8B3A3A;
			color: white;
			border-color: #8B3A3A;
		}
		
		.step-label {
			font-size: 12px;
			color: #666;
			text-align: center;
			font-weight: 500;
		}
		
		.step.active .step-label {
			color: #333;
			font-weight: 500;
		}
		
		.step.completed .step-label {
			color: #333;
			font-weight: bold;
		}
		
		.content {
			text-align: center;
		}
		
		.content h2 {
			color: #666;
			font-size: 18px;
			margin-bottom: 15px;
			font-weight: 500;
		}
		
		.payment-box {
			border: 2px solid #ddd;
			border-radius: 8px;
			padding: 20px;
			margin-bottom: 15px;
			background: #fafafa;
		}
		
		.payment-box h3 {
			color: #333;
			font-size: 16px;
			margin-bottom: 15px;
			font-weight: 600;
		}
		
		.payment-details {
			display: flex;
			flex-direction: column;
			gap: 15px;
			text-align: left;
		}
		
		.detail-row {
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 8px 0;
			border-bottom: 1px solid #e0e0e0;
		}
		
		.detail-row:last-child {
			border-bottom: none;
		}
		
		.detail-label {
			color: #666;
			font-size: 12px;
			font-weight: 500;
		}
		
		.detail-value {
			color: #333;
			font-size: 12px;
			font-weight: 600;
		}
		
		.description {
			color: #999;
			font-size: 12px;
			margin-bottom: 15px;
			line-height: 1.4;
		}
		
		.submit-btn {
			width: 100%;
			max-width: 500px;
			padding: 14px;
			background: #8B3A3A;
			color: white;
			border: none;
			font-size: 16px;
			font-weight: bold;
			cursor: pointer;
			border-radius: 4px;
			transition: background 0.3s;
		}
		
		.submit-btn:hover {
			background: #6B2A2A;
		}
		
		.submit-btn:active {
			transform: scale(0.98);
		}

		.modal-overlay {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.5);
			display: none;
			align-items: center;
			justify-content: center;
			z-index: 999;
		}

		.modal-overlay.show {
			display: flex;
		}

		.upload-modal {
			background: #fff;
			width: 100%;
			max-width: 520px;
			border-radius: 8px;
			padding: 20px;
			box-shadow: 0 12px 28px rgba(0, 0, 0, 0.2);
		}

		.upload-modal h3 {
			margin-bottom: 10px;
			color: #8B3A3A;
		}

		.upload-modal p {
			font-size: 13px;
			color: #555;
			margin-bottom: 15px;
		}

		.file-input {
			width: 100%;
			padding: 10px;
			border: 1px solid #ddd;
			border-radius: 6px;
			background: #fafafa;
		}

		.preview-img {
			display: none;
			max-width: 100%;
			max-height: 240px;
			object-fit: contain;
			margin-top: 12px;
			border: 1px solid #eee;
			border-radius: 6px;
		}

		.modal-actions {
			display: flex;
			justify-content: flex-end;
			gap: 10px;
			margin-top: 16px;
		}

		.btn-secondary,
		.btn-primary {
			padding: 10px 14px;
			border: none;
			border-radius: 6px;
			font-weight: 600;
			cursor: pointer;
		}

		.btn-secondary {
			background: #e6e6e6;
			color: #333;
		}

		.btn-primary {
			background: #8B3A3A;
			color: #fff;
		}
		
		@media (max-width: 768px) {
			.container {
				padding: 20px;
				margin: 20px;
			}
			
			.steps-progress {
				margin-bottom: 30px;
			}
			
			.payment-box {
				padding: 15px;
			}
			
			.detail-row {
				flex-direction: column;
				align-items: flex-start;
				gap: 5px;
			}
		}
	</style>
</head>
<body>
	<!-- Header -->
	<div class="header">
		<div class="logo">
			<img src="../assets/nobg_logo.png" alt="Alpha Aquila Logo">
			<span>ALPHA AQUILA</span>
		</div>
	</div>
	
	<!-- Main Container -->
	<div class="container">

	<?= $_SESSION['pending_email']; ?>
		<!-- Progress Steps -->
		<div class="steps-progress">
			<div class="step active" data-step="1">
				<div class="step-number">1</div>
				<div class="step-label">Exam Payment</div>
			</div>
			
			<div class="step locked" data-step="2">
				<div class="step-number">2</div>
				<div class="step-label">Training Registration</div>
			</div>
			
			<div class="step locked" data-step="3">
				<div class="step-number">3</div>
				<div class="step-label">Training Payment</div>
			</div>
			
			<div class="step locked" data-step="4">
				<div class="step-number">4</div>
				<div class="step-label">Review</div>
			</div>
		</div>
		
		<!-- Content -->
		<div class="content">
			<!-- Heading -->
			<h2>Confirm your examination payment</h2>
			
			<!-- Payment Details Box -->
			<div class="payment-box">
				<h3>Payment Details</h3>
				<div class="payment-details">
					<div class="detail-row">
						<span class="detail-label">Name:</span>
						<span class="detail-value"></span>
					</div>
					<div class="detail-row">
						<span class="detail-label">Amount:</span>
						<span class="detail-value"></span>
					</div>
					<div class="detail-row">
						<span class="detail-label">Timestamp:</span>
						<span class="detail-value"></span>
					</div>
					<div class="detail-row">
						<span class="detail-label">Transaction ID:</span>
						<span class="detail-value"></span>
					</div>
				</div>
			</div>
			
			<!-- Description -->
			<div class="description">
				You can only proceed to the next step once your payment has been reviewed<br>
				and confirmed by the admin.
			</div>
			
			<!-- Submit Button -->
			<button class="submit-btn" onclick="sendConfirmation()">Send Confirmation</button>
		</div>
	</div>

	<div class="modal-overlay" id="receiptModal" role="dialog" aria-modal="true" aria-labelledby="receiptModalTitle">
		<div class="upload-modal">
			<h3 id="receiptModalTitle">Upload E-Receipt</h3>
			<p>Please upload a clear image of your e-receipt. This will be sent for admin review.</p>
			<input type="file" id="receiptFileInput" class="file-input" accept="image/*">
			<img id="receiptPreview" class="preview-img" alt="E-receipt preview">
			<div class="modal-actions">
				<button type="button" class="btn-secondary" onclick="closeReceiptModal()">Cancel</button>
				<button type="button" class="btn-primary" id="confirmUploadBtn" onclick="submitExamPayment()">Submit Receipt</button>
			</div>
		</div>
	</div>
	
	<script>
		const currentStep = 2;
		const examPaymentVerified = <?php echo $isExamPaymentVerified ? 'true' : 'false'; ?>;
		const pages = ['verify_email.php', 'exam_payment.php', 'training_registration.php', 'training_payment.php', 'review.php'];
		const receiptModal = document.getElementById('receiptModal');
		const receiptFileInput = document.getElementById('receiptFileInput');
		const receiptPreview = document.getElementById('receiptPreview');
		const confirmUploadBtn = document.getElementById('confirmUploadBtn');
		const sendConfirmationBtn = document.querySelector('.submit-btn');
		let receiptBase64 = '';
		
		// Get completed steps from localStorage
		function getCompletedSteps() {
			const completed = localStorage.getItem('completedSteps');
			return completed ? JSON.parse(completed) : [];
		}
		
		// Save completed step to localStorage
		function completeStep(step) {
			const completed = getCompletedSteps();
			if (!completed.includes(step)) {
				completed.push(step);
				localStorage.setItem('completedSteps', JSON.stringify(completed));
			}
		}
		
		// Initialize step states based on completed steps
		function initializeSteps() {
			if (examPaymentVerified) {
				completeStep(2);
				if (sendConfirmationBtn) {
					sendConfirmationBtn.textContent = 'Continue to Training Registration';
				}
			}

			const completed = getCompletedSteps();
			const steps = document.querySelectorAll('.step');
			
			steps.forEach(step => {
				const stepNum = parseInt(step.dataset.step);
				
				// Unlock if step is completed or is the next available step
				if (completed.includes(stepNum) || stepNum <= Math.max(...completed, 0) + 1) {
					step.classList.remove('locked');
					step.onclick = () => navigateToStep(stepNum);
					
					if (completed.includes(stepNum) && stepNum < currentStep) {
						step.classList.add('completed');
					}
				}
			});
		}
		
		function navigateToStep(targetStep) {
			if (targetStep === currentStep) return;
			const completed = getCompletedSteps();
			// Can only navigate to completed steps or current step
			if (completed.includes(targetStep) || targetStep <= Math.max(...completed, 0) + 1) {
				window.location.href = pages[targetStep];
			}
		}
		
		function sendConfirmation() {
			if (examPaymentVerified) {
				completeStep(2);
				window.location.href = 'training_registration.php';
				return;
			}

			receiptModal.classList.add('show');
		}

		function closeReceiptModal() {
			receiptModal.classList.remove('show');
			receiptFileInput.value = '';
			receiptBase64 = '';
			receiptPreview.src = '';
			receiptPreview.style.display = 'none';
		}

		receiptFileInput.addEventListener('change', (event) => {
			const file = event.target.files[0];

			if (!file) {
				receiptBase64 = '';
				receiptPreview.src = '';
				receiptPreview.style.display = 'none';
				return;
			}

			if (!file.type.startsWith('image/')) {
				alert('Please upload an image file only.');
				receiptFileInput.value = '';
				return;
			}

			const reader = new FileReader();
			reader.onload = () => {
				receiptBase64 = reader.result;
				receiptPreview.src = reader.result;
				receiptPreview.style.display = 'block';
			};
			reader.readAsDataURL(file);
		});

		async function submitExamPayment() {
			if (!receiptBase64) {
				alert('Please upload your e-receipt image before submitting.');
				return;
			}

			confirmUploadBtn.disabled = true;
			confirmUploadBtn.textContent = 'Submitting...';

			try {
				const response = await fetch('../php/submit_exam_payment.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json'
					},
					body: JSON.stringify({ payment_proof: receiptBase64 })
				});

				const data = await response.json();

				if (!response.ok || !data.success) {
					throw new Error(data.message || 'Failed to submit payment confirmation.');
				}

				completeStep(2);
				alert('Confirmation sent to admin for review.');
				window.location.href = 'training_registration.php';
			} catch (error) {
				alert(error.message || 'Something went wrong. Please try again.');
			} finally {
				confirmUploadBtn.disabled = false;
				confirmUploadBtn.textContent = 'Submit Receipt';
			}
		}

		receiptModal.addEventListener('click', (event) => {
			if (event.target === receiptModal) {
				closeReceiptModal();
			}
		});
		
		// Initialize on page load
		initializeSteps();
	</script>
</body>
</html>
