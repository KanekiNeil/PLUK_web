<?php
session_start();

if (!isset($_SESSION['verification_token'])) {
	header('Location: verify_email.php');
	exit;
}

$supabaseUrl = "https://ncsobcjlvytbivoxezfd.supabase.co";
$supabaseKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MTU2ODc3NiwiZXhwIjoyMDg3MTQ0Nzc2fQ.TLktUWOmr-iAZTy4Vm0F_ihUa2q_tQuP83RLTodPcEY";
$applicant_id = $_SESSION['app_id'] ?? null;
$hasTrainingSchedule = false;
$existingTrainingSchedule = null;
$applicantPaymentStatus = '';
$canRegisterTraining = false;

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
			$applicantPaymentStatus = trim((string)($statusData[0]['status'] ?? $statusData[0]['AI_Status'] ?? ''));
			$normalizedStatus = strtolower($applicantPaymentStatus);
			$canRegisterTraining = ($normalizedStatus === 'exam passed' || $normalizedStatus === 'verify training payment' || $normalizedStatus === 'training payment verified');
		}
	}
}

if (!empty($applicant_id)) {
	$lookupUrl = $supabaseUrl . "/rest/v1/training_sched?select=id,training_type,date,start_time,end_time,applicant_id&applicant_id=eq." . urlencode($applicant_id) . "&limit=1";
	$lookupCh = curl_init($lookupUrl);
	curl_setopt($lookupCh, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($lookupCh, CURLOPT_HTTPHEADER, [
		"apikey: $supabaseKey",
		"Authorization: Bearer $supabaseKey",
		"Content-Type: application/json"
	]);

	$lookupResponse = curl_exec($lookupCh);
	$lookupHttpCode = curl_getinfo($lookupCh, CURLINFO_HTTP_CODE);
	curl_close($lookupCh);

	if ($lookupResponse !== false && $lookupHttpCode >= 200 && $lookupHttpCode < 300) {
		$lookupData = json_decode($lookupResponse, true);
		if (is_array($lookupData) && !empty($lookupData[0])) {
			$hasTrainingSchedule = true;
			$existingTrainingSchedule = $lookupData[0];
		}
	}
}

// Handle form submission
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register_training') {
    header('Content-Type: application/json');
    
    $training_type = $_POST['training_type'] ?? '';
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';
	$email = $_SESSION['pending_email'] ?? '';
    
    // If whole day, set automatic time to 9 AM - 6 PM
    if (strpos($training_type, 'Whole Day') !== false) {
        $start_time = '09:00:00';
        $end_time = '18:00:00';
    } else {
        // Extract start and end time from combo box value (e.g., "08:00-11:00")
        $times = explode('-', $time);
        $start_time = $times[0] . ':00';
        $end_time = isset($times[1]) ? $times[1] . ':00' : $times[0] . ':00';
    }
    
    if (empty($training_type) || empty($date)) {
        echo json_encode(['success' => false, 'message' => 'Required fields are missing']);
        exit;
    }

	if ($hasTrainingSchedule) {
		echo json_encode([
			'success' => true,
			'message' => 'Training is already registered.',
			'already_registered' => true,
			'next_url' => 'training_payment.php'
		]);
		exit;
	}

	if (!$canRegisterTraining) {
		echo json_encode([
			'success' => false,
			'message' => 'You have not passed the exam yet. Please pass the exam before registering for training.'
		]);
		exit;
	}
    
    // Insert using Supabase REST API
    $postData = [
        'email' => $email,
        'training_type' => $training_type,
        'date' => $date,
        'start_time' => $start_time,
        'end_time' => $end_time,
		'applicant_id' => $applicant_id
    ];
    
    $ch = curl_init($supabaseUrl . "/rest/v1/training_sched");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: $supabaseKey",
        "Authorization: Bearer $supabaseKey",
        "Content-Type: application/json",
        "Prefer: return=representation"
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    if ($curlError) {
        echo json_encode(['success' => false, 'message' => 'Connection error: ' . $curlError]);
    } else if ($httpCode >= 200 && $httpCode < 300) {
        echo json_encode(['success' => true, 'message' => 'Training registered successfully!']);
    } else {
        $error = json_decode($response, true);
        $errorMsg = isset($error['message']) ? $error['message'] : ('HTTP ' . $httpCode . ': ' . $response);
        // Include sent data for debugging
        echo json_encode(['success' => false, 'message' => $errorMsg, 'debug' => $postData]);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Training Registration - Alpha Aquila</title>
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
			font-weight: bold;
		}
		
		.content {
			text-align: center;
		}
		
		.content h2 {
			color: #333;
			font-size: 20px;
			margin-bottom: 15px;
			font-weight: 600;
		}
		
		.info-text {
			color: #666;
			font-size: 14px;
			margin-bottom: 30px;
			line-height: 1.6;
		}
		
		.joinpru-link {
			color: #0066cc;
			text-decoration: none;
			font-weight: 600;
		}
		
		.joinpru-link:hover {
			text-decoration: underline;
		}
		
		.training-schedule {
			margin-bottom: 30px;
			padding-bottom: 20px;
		}
		
		.training-item {
			display: flex;
			align-items: center;
			gap: 20px;
			padding: 15px;
			background: #f9f9f9;
			border-radius: 6px;
			margin-bottom: 15px;
		}
		
		.training-label {
			flex: 0 0 180px;
			font-size: 14px;
			font-weight: 500;
			color: #333;
			text-align: left;
		}
		
		.training-inputs {
			display: flex;
			gap: 10px;
			flex: 1;
		}
		
		.input-group {
			flex: 1;
			display: flex;
			flex-direction: column;
			gap: 5px;
		}
		
		.input-group label {
			font-size: 11px;
			color: #999;
			font-weight: 500;
		}
		
		.input-group input {
			padding: 8px 10px;
			border: 1px solid #ddd;
			border-radius: 4px;
			font-size: 13px;
			color: #333;
		}
		
		.input-group input:focus {
			outline: none;
			border-color: #8B3A3A;
			box-shadow: 0 0 3px rgba(139, 58, 58, 0.3);
		}
		
		.register-btn {
			width: 100%;
			padding: 14px;
			background: #8B3A3A;
			color: white;
			border: none;
			font-size: 16px;
			font-weight: bold;
			cursor: pointer;
			border-radius: 4px;
			transition: background 0.3s;
			margin-top: 20px;
		}
		
		.register-btn:hover {
			background: #6B2A2A;
		}
		
		.register-btn:active {
			transform: scale(0.98);
		}
		
		@media (max-width: 768px) {
			.container {
				padding: 15px 20px;
			}
			
			.training-item {
				flex-direction: column;
				align-items: flex-start;
			}
			
			.training-inputs {
				width: 100%;
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
			
			<div class="step active" data-step="2">
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
			<h2>Register for Instruction-Led Training</h2>
			<?php if (!$canRegisterTraining && !$hasTrainingSchedule): ?>
				<div style="max-width: 500px; margin: 0 auto 20px; padding: 14px 16px; border-radius: 6px; background: #fff3cd; color: #856404; text-align: left; font-size: 14px; line-height: 1.5;">
					You have not passed the exam yet. You can register for training only after passing the exam.
				</div>
			<?php endif; ?>
			<?php if ($hasTrainingSchedule): ?>
				<div style="max-width: 500px; margin: 0 auto 20px; padding: 14px 16px; border-radius: 6px; background: #e8f5e9; color: #1b5e20; text-align: left; font-size: 14px; line-height: 1.5;">
					Your training schedule is already recorded. You can proceed directly to training payment.
				</div>
			<?php endif; ?>
			
			<!-- Info Text -->
			<div class="info-text">
				To register for Instruction-Led Training. Click this link 
				<a href="https://joinpru.com.ph/our-proposals" class="joinpru-link">JoinPRU</a>
			</div>
			
			<div class="training-schedule">
				<!-- Training Type Selection -->
				<div class="training-item">
					<div class="training-label">Training Type</div>
					<div class="training-inputs">
						<div class="input-group">
							<label>Select Training</label>
							<select id="trainingType" style="padding: 8px 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 13px; color: #333;">
								<option value="">-- Select --</option>
								<option value="Instruction-Led Training 1">Instruction-Led Training 1</option>
								<option value="Instruction-Led Training 2">Instruction-Led Training 2</option>
								<option value="Whole Day (Training 1 & 2)">Whole Day (Training 1 & 2)</option>
							</select>
						</div>
					</div>
				</div>
				
				<!-- Schedule Selection (shown after training type is selected) -->
				<div class="training-item" id="scheduleItem" style="display: none;">
					<div class="training-label" id="scheduleLabel">Schedule</div>
					<div class="training-inputs">
						<div class="input-group">
							<label>Date</label>
							<input type="date" id="trainingDate">
						</div>
						<div class="input-group">
							<label>Time (3-hour session)</label>
							<select id="trainingTime" style="padding: 8px 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 13px; color: #333;">
								<option value="">-- Select Time --</option>
								<option value="08:00-11:00">8:00 AM - 11:00 AM</option>
								<option value="09:00-12:00">9:00 AM - 12:00 PM</option>
								<option value="13:00-16:00">1:00 PM - 4:00 PM</option>
								<option value="14:00-17:00">2:00 PM - 5:00 PM</option>
								<option value="15:00-18:00">3:00 PM - 6:00 PM</option>
								<option value="16:00-19:00">4:00 PM - 7:00 PM</option>
								<option value="17:00-20:00">5:00 PM - 8:00 PM</option>
								<option value="18:00-21:00">6:00 PM - 9:00 PM</option>
								<option value="19:00-22:00">7:00 PM - 10:00 PM</option>
								<option value="20:00-23:00">8:00 PM - 11:00 PM</option>
								<option value="21:00-00:00">9:00 PM - 12:00 AM</option>
							</select>
						</div>
					</div>
				</div>
				
				<!-- Schedule Info (shown when schedule is set) -->
				<div class="training-item" id="scheduleInfo" style="display: none; background: #e8f5e9;">
					<div class="training-label">Selected Schedule</div>
					<div class="training-inputs">
						<div class="input-group">
							<span id="scheduleInfoText" style="font-size: 14px; color: #333;"></span>
						</div>
					</div>
				</div>
			</div>
			
			<!-- Register Button -->
			<button class="register-btn" id="registerBtn" onclick="registerTraining()">Register</button>
		</div>
	</div>
	
	<script>
		const currentStep = 2;
		const hasTrainingSchedule = <?= $hasTrainingSchedule ? 'true' : 'false' ?>;
		const canRegisterTraining = <?= $canRegisterTraining ? 'true' : 'false' ?>;
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

		function canAccessStep(stepNum) {
			if (stepNum === 1) return true;
			if (stepNum === 2) return true;
			if (stepNum === 3) return hasTrainingSchedule;
			return false;
		}
		
		// Initialize step states based on completed steps
		function initializeSteps() {
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
		
		// Initialize on page load
		initializeSteps();

		if (hasTrainingSchedule) {
			const registerBtn = document.getElementById('registerBtn');
			if (registerBtn) {
				registerBtn.textContent = 'Continue to Training Payment';
			}
		} else if (!canRegisterTraining) {
			const registerBtn = document.getElementById('registerBtn');
			if (registerBtn) {
				registerBtn.textContent = 'Waiting for Exam Completion';
				registerBtn.disabled = true;
				registerBtn.style.cursor = 'not-allowed';
				registerBtn.style.opacity = '0.7';
			}
		}
		
		// Handle training type selection
		document.getElementById('trainingType').addEventListener('change', function() {
			const scheduleItem = document.getElementById('scheduleItem');
			const scheduleLabel = document.getElementById('scheduleLabel');
			const timeGroup = document.getElementById('trainingTime').closest('.input-group');
			
			if (this.value) {
				scheduleItem.style.display = 'flex';
				if (this.value.includes('Whole Day')) {
					scheduleLabel.textContent = 'Whole Day Schedule';
					timeGroup.style.display = 'none';
				} else {
					scheduleLabel.textContent = this.value + ' Schedule';
					timeGroup.style.display = 'flex';
				}
				// Update schedule info if date and time are already set
				updateScheduleInfo();
			} else {
				scheduleItem.style.display = 'none';
			}
		});
		
		// Show schedule info when date and time are set
		document.getElementById('trainingDate').addEventListener('change', updateScheduleInfo);
		document.getElementById('trainingTime').addEventListener('change', updateScheduleInfo);
		
		function updateScheduleInfo() {
			const trainingType = document.getElementById('trainingType').value;
			const date = document.getElementById('trainingDate').value;
			const timeSelect = document.getElementById('trainingTime');
			const time = timeSelect.value;
			const scheduleInfo = document.getElementById('scheduleInfo');
			const scheduleInfoText = document.getElementById('scheduleInfoText');
			
			const formattedDate = date ? new Date(date).toLocaleDateString('en-US', { 
				weekday: 'long', 
				year: 'numeric', 
				month: 'long', 
				day: 'numeric' 
			}) : '';
			
			if (trainingType.includes('Whole Day') && date) {
				scheduleInfoText.innerHTML = 'ILT 1 - ' + formattedDate + ' (9:00 AM - 6:00 PM)<br>ILT 2 - ' + formattedDate + ' (9:00 AM - 6:00 PM)';
				scheduleInfo.style.display = 'flex';
			} else if (trainingType && !trainingType.includes('Whole Day') && date && time) {
				// Get the display text from the selected option
				const timeText = timeSelect.options[timeSelect.selectedIndex].text;
				scheduleInfoText.textContent = trainingType + ' - ' + formattedDate + ' (' + timeText + ')';
				scheduleInfo.style.display = 'flex';
			} else {
				scheduleInfo.style.display = 'none';
			}
		}
		
		function registerTraining() {
			if (hasTrainingSchedule) {
				completeStep(3);
				window.location.href = 'training_payment.php';
				return;
			}

			if (!canRegisterTraining) {
				Swal.fire({
					text: 'You have not passed the exam yet. Please pass the exam before registering for training.',
					icon: 'warning',
					confirmButtonText: 'OK'
				});
				return;
			}

			const trainingType = document.getElementById('trainingType').value;
			const date = document.getElementById('trainingDate').value;
			const time = document.getElementById('trainingTime').value;
			
			if (!trainingType) {
				Swal.fire({ text: 'Please select a training type', icon: 'warning', confirmButtonText: 'OK' });
				return;
			}
			if (!date) {
				Swal.fire({ text: 'Please select a date', icon: 'warning', confirmButtonText: 'OK' });
				return;
			}
			if (!trainingType.includes('Whole Day') && !time) {
				Swal.fire({ text: 'Please select a time', icon: 'warning', confirmButtonText: 'OK' });
				return;
			}
			
			// Send data to server
			const formData = new FormData();
			formData.append('action', 'register_training');
			formData.append('email', '<?php echo isset($_SESSION["email"]) ? $_SESSION["email"] : ""; ?>');
			formData.append('training_type', trainingType);
			formData.append('date', date);
			formData.append('time', trainingType.includes('Whole Day') ? '09:00-18:00' : time);
			
			fetch('training_registration.php', {
				method: 'POST',
				body: formData
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					// Mark step 3 as completed
					completeStep(3);
					Swal.fire({ text: data.message, icon: 'success', confirmButtonText: 'OK' }).then(() => {
						window.location.href = 'training_payment.php';
					});
				} else {
					let errorMsg = 'Error: ' + data.message;
					if (data.debug) {
						errorMsg += '\n\nData sent: ' + JSON.stringify(data.debug);
					}
					Swal.fire({ text: errorMsg, icon: 'error', confirmButtonText: 'OK' });
				}
			})
			.catch(error => {
				console.error('Error:', error);
				Swal.fire({ text: 'An error occurred. Please try again.', icon: 'error', confirmButtonText: 'OK' });
			});
		}
	</script>
</body>
</html>
