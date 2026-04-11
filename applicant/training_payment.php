<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Training Payment - Alpha Aquila</title>
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
	
	<script>
		const currentStep = 4;
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
		
		// Initialize step states based on completed steps
		function initializeSteps() {
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
			// Mark step 4 as completed
			completeStep(4);
			
			// TODO: Send confirmation to admin
			alert('Confirmation sent to admin for review.');
			console.log('Training payment confirmation sent');
			window.location.href = 'review.php';
		}
		
		// Initialize on page load
		initializeSteps();
	</script>
</body>
</html>
