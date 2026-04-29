<?php
session_start();

if (!isset($_SESSION['verification_token'])) {
	header('Location: verify_email.php');
	exit;
}

$supabaseUrl = "https://ncsobcjlvytbivoxezfd.supabase.co";
$supabaseKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MTU2ODc3NiwiZXhwIjoyMDg3MTQ0Nzc2fQ.TLktUWOmr-iAZTy4Vm0F_ihUa2q_tQuP83RLTodPcEY";
$applicant_id = $_SESSION['app_id'] ?? null;
$isTrainingPaymentVerified = false;
$hasTrainingPaymentRequest = false;
$isPaymentRejected = false;

if (!empty($applicant_id)) {
	$statusUrl = $supabaseUrl . "/rest/v1/applicant_information?select=status&uuid=eq." . urlencode($applicant_id) . "&limit=1";
	$statusCh = curl_init($statusUrl);
	curl_setopt($statusCh, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($statusCh, CURLOPT_HTTPHEADER, [
		"apikey: $supabaseKey",
		"Authorization: Bearer $supabaseKey",
		"Content-Type: application/json"
	]);

	$statusResponse = curl_exec($statusCh);
	$statusHttpCode = curl_getinfo($statusCh, CURLINFO_HTTP_CODE);
	curl_close($statusCh);

	if ($statusResponse !== false && $statusHttpCode >= 200 && $statusHttpCode < 300) {
		$statusData = json_decode($statusResponse, true);
		if (is_array($statusData) && !empty($statusData[0])) {
			$currentStatus = strtolower(trim((string)($statusData[0]['status'] ?? '')));
			$isPaymentRejected = ($currentStatus === 'payment rejected');
		}
	}

	$verifyPaymentUrl = $supabaseUrl . "/rest/v1/training_payment?select=verified&applicant_id=eq." . urlencode($applicant_id);
	$verifyCh = curl_init($verifyPaymentUrl);
	curl_setopt($verifyCh, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($verifyCh, CURLOPT_HTTPHEADER, [
		"apikey: $supabaseKey",
		"Authorization: Bearer $supabaseKey",
		"Content-Type: application/json"
	]);

	$verifyResponse = curl_exec($verifyCh);
	$verifyHttpCode = curl_getinfo($verifyCh, CURLINFO_HTTP_CODE);
	curl_close($verifyCh);

	if ($verifyResponse !== false && $verifyHttpCode >= 200 && $verifyHttpCode < 300) {
		$verifyData = json_decode($verifyResponse, true);
		if (is_array($verifyData)) {
			$hasTrainingPaymentRequest = !empty($verifyData);
			foreach ($verifyData as $row) {
				if (!empty($row['verified'])) {
					$isTrainingPaymentVerified = true;
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
	<title>Training Payment - Alpha Aquila</title>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
			font-weight: 500;
		}
		
		.content {
			text-align: center;
		}
		
		.content h2 {
			color: #8B3A3A;
			font-size: 22px;
			margin-bottom: 25px;
			font-weight: bold;
		}
		
		.payment-box {
			border: 1px solid #ddd;
			border-radius: 8px;
			padding: 25px 30px;
			max-width: 500px;
			margin: 0 auto 25px;
			text-align: left;
		}
		
		.payment-box h3 {
			font-size: 18px;
			color: #333;
			margin-bottom: 20px;
			font-weight: bold;
		}
		
		.payment-details {
			display: flex;
			flex-direction: column;
			gap: 15px;
		}
		
		.detail-row {
			display: flex;
			gap: 15px;
		}
		
		.detail-label {
			font-size: 14px;
			color: #333;
			font-weight: 500;
			min-width: 120px;
		}
		
		.detail-value {
			font-size: 14px;
			color: #333;
		}
		
		.description {
			color: #666;
			font-size: 13px;
			margin: 20px 0 25px;
			line-height: 1.6;
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
				margin-bottom: 25px;
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
		<!-- Progress Steps -->
		<div class="steps-progress">
			<div class="step completed" data-step="1">
				<div class="step-number">1</div>
				<div class="step-label">Exam Payment</div>
			</div>
			
			<div class="step completed" data-step="2">
				<div class="step-number">2</div>
				<div class="step-label">Training Registration</div>
			</div>
			
			<div class="step active" data-step="3">
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
			<h2>Confirm your training payment</h2>
			<?php if ($isPaymentRejected): ?>
				<div style="max-width: 500px; margin: 0 auto 16px; padding: 12px 14px; border-radius: 8px; background: #fff4e5; color: #9a3412; font-size: 13px; line-height: 1.4; text-align: left; border: 1px solid #fdba74;">
					Your last payment was rejected. Please upload a new payment proof and submit again.
				</div>
			<?php endif; ?>
			<?php if ($isTrainingPaymentVerified): ?>
				<div style="max-width: 500px; margin: 0 auto 20px; padding: 14px 16px; border-radius: 6px; background: #e8f5e9; color: #1b5e20; text-align: left; font-size: 14px; line-height: 1.5;">
					Your training payment is already verified. You can proceed directly to review.
				</div>
			<?php endif; ?>
			
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
			<button class="submit-btn" id="sendConfirmationBtn" onclick="sendConfirmation()">Send Confirmation</button>
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
				<button type="button" class="btn-primary" id="confirmUploadBtn" onclick="submitTrainingPayment()">Submit Receipt</button>
			</div>
		</div>
	</div>
	
	<script>
		const currentStep = 3;
		const trainingPaymentVerified = <?= $isTrainingPaymentVerified ? 'true' : 'false' ?>;
		let trainingPaymentSubmitted = <?= $hasTrainingPaymentRequest ? 'true' : 'false' ?>;
		const receiptModal = document.getElementById('receiptModal');
		const receiptFileInput = document.getElementById('receiptFileInput');
		const receiptPreview = document.getElementById('receiptPreview');
		const confirmUploadBtn = document.getElementById('confirmUploadBtn');
		const sendConfirmationBtn = document.getElementById('sendConfirmationBtn');
		let receiptBase64 = '';
		const pages = ['verify_email.php', 'exam_payment.php', 'training_registration.php', 'training_payment.php', 'review.php'];
		
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

		function uncompleteStep(step) {
			const completed = getCompletedSteps().filter(item => item !== step);
			localStorage.setItem('completedSteps', JSON.stringify(completed));
		}

		function canAccessStep(stepNum) {
			if (stepNum === 1) return true;
			if (stepNum === 2) return true;
			if (stepNum === 3) return true;
			if (stepNum === 4) return trainingPaymentVerified;
			return false;
		}
		
		// Initialize step states based on completed steps
		function initializeSteps() {
			if (trainingPaymentVerified) {
				completeStep(4);
				if (sendConfirmationBtn) {
					sendConfirmationBtn.textContent = 'Continue to Review';
				}
			} else if (trainingPaymentSubmitted) {
				uncompleteStep(4);
				if (sendConfirmationBtn) {
					sendConfirmationBtn.textContent = 'Payment Confirmation Sent (Pending Verification)';
					sendConfirmationBtn.disabled = true;
					sendConfirmationBtn.style.cursor = 'not-allowed';
					sendConfirmationBtn.style.opacity = '0.7';
				}
			} else {
				uncompleteStep(4);
			}

			const steps = document.querySelectorAll('.step');
			
			steps.forEach(step => {
				const stepNum = parseInt(step.dataset.step);

				if (canAccessStep(stepNum)) {
					step.classList.remove('locked');
					step.onclick = () => navigateToStep(stepNum);

					if (stepNum < currentStep) {
						step.classList.add('completed');
					}
				} else {
					step.classList.add('locked');
					step.classList.remove('completed');
					step.onclick = null;
				}
			});
		}
		
		function navigateToStep(targetStep) {
			if (targetStep === currentStep) return;
			if (canAccessStep(targetStep)) {
				window.location.href = pages[targetStep];
			}
		}
		
		function sendConfirmation() {
			if (trainingPaymentVerified) {
				completeStep(4);
				window.location.href = 'review.php';
				return;
			}

			if (trainingPaymentSubmitted) {
				swal.fire({ text: 'Your training payment confirmation is already submitted and waiting for verification.', icon: 'info', confirmButtonText: 'OK' });
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
				swal.fire({ text: 'Please upload an image file only.', icon: 'error', confirmButtonText: 'OK' });
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

		async function submitTrainingPayment() {
			if (!receiptBase64) {
				swal.fire({ text: 'Please upload your e-receipt image before submitting.', icon: 'error', confirmButtonText: 'OK' });
				return;
			}

			confirmUploadBtn.disabled = true;
			confirmUploadBtn.textContent = 'Submitting...';

			try {
				const response = await fetch('../php/submit_training_payment.php', {
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

				trainingPaymentSubmitted = true;
				uncompleteStep(4);
				closeReceiptModal();
				swal.fire({ text: 'Confirmation sent to admin for review. Please wait for payment verification before proceeding to review.', icon: 'success', confirmButtonText: 'OK' });
				if (sendConfirmationBtn) {
					sendConfirmationBtn.textContent = 'Payment Confirmation Sent (Pending Verification)';
					sendConfirmationBtn.disabled = true;
					sendConfirmationBtn.style.cursor = 'not-allowed';
					sendConfirmationBtn.style.opacity = '0.7';
				}
				initializeSteps();
			} catch (error) {
				swal.fire({ text: error.message || 'Something went wrong. Please try again.', icon: 'error', confirmButtonText: 'OK' });
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
