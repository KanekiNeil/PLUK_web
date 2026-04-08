<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Review - Alpha Aquila</title>
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
		
		.step.active .step-number {
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
		
		/* Section Boxes */
		.section-box {
			border: 1px solid #ddd;
			border-radius: 12px;
			padding: 25px 30px;
			margin-bottom: 25px;
			position: relative;
		}
		
		.section-title {
			position: absolute;
			top: -12px;
			left: 30px;
			background: white;
			padding: 0 10px;
			font-size: 14px;
			font-weight: 600;
			color: #333;
		}
		
		/* Personal Details */
		.personal-details {
			display: flex;
			align-items: center;
			gap: 30px;
		}
		
		.avatar {
			width: 70px;
			height: 70px;
			border-radius: 50%;
			background: linear-gradient(135deg, #87CEEB 0%, #4A90D9 100%);
			display: flex;
			align-items: center;
			justify-content: center;
		}
		
		.avatar svg {
			width: 45px;
			height: 45px;
			fill: white;
		}
		
		.detail-group {
			display: flex;
			flex-direction: column;
			gap: 5px;
		}
		
		.detail-label {
			font-size: 11px;
			color: #999;
		}
		
		.detail-value {
			font-size: 16px;
			font-weight: 600;
			color: #333;
		}
		
		/* Payment Details */
		.payment-row {
			display: flex;
			align-items: center;
			gap: 20px;
			margin-bottom: 15px;
		}
		
		.payment-row:last-child {
			margin-bottom: 0;
		}
		
		.payment-type {
			font-size: 11px;
			color: #999;
			min-width: 120px;
		}
		
		.payment-date {
			font-size: 14px;
			color: #333;
			min-width: 120px;
		}
		
		.payment-transaction {
			font-size: 14px;
			color: #333;
		}
		
		/* Reviewers Section */
		.reviewers-title {
			font-size: 14px;
			font-weight: 600;
			color: #333;
			margin-bottom: 15px;
			text-align: center;
		}
		
		.training-section {
			margin-bottom: 20px;
		}
		
		.training-section:last-child {
			margin-bottom: 0;
		}
		
		.training-section-title {
			font-size: 13px;
			font-weight: 600;
			color: #333;
			margin-bottom: 10px;
		}
		
		.reviewer-cards {
			display: flex;
			gap: 15px;
		}
		
		.reviewer-card {
			flex: 1;
			display: flex;
			align-items: center;
			gap: 12px;
			padding: 12px 15px;
			border: 1px solid #ddd;
			border-radius: 8px;
			background: white;
		}
		
		.reviewer-icon {
			width: 30px;
			height: 35px;
			display: flex;
			align-items: center;
			justify-content: center;
		}
		
		.reviewer-icon svg {
			width: 28px;
			height: 32px;
			fill: #ccc;
		}
		
		.reviewer-info {
			display: flex;
			flex-direction: column;
			gap: 2px;
		}
		
		.reviewer-training {
			font-size: 11px;
			color: #999;
		}
		
		.reviewer-name {
			font-size: 13px;
			color: #333;
			font-weight: 500;
		}
		
		@media (max-width: 768px) {
			.container {
				padding: 20px;
				margin: 20px;
			}
			
			.personal-details {
				flex-direction: column;
				text-align: center;
			}
			
			.reviewer-cards {
				flex-direction: column;
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
			
			<div class="step completed" data-step="3">
				<div class="step-number">3</div>
				<div class="step-label">Training Payment</div>
			</div>
			
			<div class="step active" data-step="4">
				<div class="step-number">4</div>
				<div class="step-label">Review</div>
			</div>
		</div>
		
		<!-- Personal Details -->
		<div class="section-box">
			<div class="section-title">Personal Details</div>
			<div class="personal-details">
				<div class="avatar">
					<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
						<circle cx="12" cy="8" r="4"/>
						<path d="M12 14c-6 0-8 3-8 6v1h16v-1c0-3-2-6-8-6z"/>
					</svg>
				</div>
				<div class="detail-group">
					<span class="detail-label">Applicant Name:</span>
					<span class="detail-value">Juan Dela Cruz</span>
				</div>
				<div class="detail-group">
					<span class="detail-label">Applicant email:</span>
					<span class="detail-value">plukjuandelacruz@gmail.com</span>
				</div>
			</div>
		</div>
		
		<!-- Payment Details -->
		<div class="section-box">
			<div class="section-title">Payment Details</div>
			<div class="payment-row">
				<span class="payment-type">Examination Payment</span>
				<span class="payment-date">03 / 03/ 2026</span>
				<span class="payment-transaction">TransactionID: 0262 82762 9033</span>
			</div>
			<div class="payment-row">
				<span class="payment-type">Training Payment</span>
				<span class="payment-date">03 / 03/ 2026</span>
				<span class="payment-transaction">TransactionID: 0262 82762 9033</span>
			</div>
		</div>
		
		<!-- Reviewers -->
		<div class="section-box">
			<div class="section-title">Reviewers</div>
			
			<!-- Training 1 Reviewers -->
			<div class="training-section">
				<div class="training-section-title">Instruction-Led Training 1</div>
				<div class="reviewer-cards">
					<div class="reviewer-card">
						<div class="reviewer-icon">
							<svg viewBox="0 0 24 30" xmlns="http://www.w3.org/2000/svg">
								<rect x="2" y="0" width="20" height="26" rx="2" fill="none" stroke="#ccc" stroke-width="1.5"/>
								<line x1="6" y1="8" x2="18" y2="8" stroke="#ccc" stroke-width="1"/>
								<line x1="6" y1="12" x2="18" y2="12" stroke="#ccc" stroke-width="1"/>
								<line x1="6" y1="16" x2="14" y2="16" stroke="#ccc" stroke-width="1"/>
							</svg>
						</div>
						<div class="reviewer-info">
							<span class="reviewer-training">Instruction-Led Training 1</span>
							<span class="reviewer-name">Reviewer 01</span>
						</div>
					</div>
					<div class="reviewer-card">
						<div class="reviewer-icon">
							<svg viewBox="0 0 24 30" xmlns="http://www.w3.org/2000/svg">
								<rect x="2" y="0" width="20" height="26" rx="2" fill="none" stroke="#ccc" stroke-width="1.5"/>
								<line x1="6" y1="8" x2="18" y2="8" stroke="#ccc" stroke-width="1"/>
								<line x1="6" y1="12" x2="18" y2="12" stroke="#ccc" stroke-width="1"/>
								<line x1="6" y1="16" x2="14" y2="16" stroke="#ccc" stroke-width="1"/>
							</svg>
						</div>
						<div class="reviewer-info">
							<span class="reviewer-training">Instruction-Led Training 1</span>
							<span class="reviewer-name">Reviewer 02</span>
						</div>
					</div>
				</div>
			</div>
			
			<!-- Training 2 Reviewers -->
			<div class="training-section">
				<div class="training-section-title">Instruction-Led Training 2</div>
				<div class="reviewer-cards">
					<div class="reviewer-card">
						<div class="reviewer-icon">
							<svg viewBox="0 0 24 30" xmlns="http://www.w3.org/2000/svg">
								<rect x="2" y="0" width="20" height="26" rx="2" fill="none" stroke="#ccc" stroke-width="1.5"/>
								<line x1="6" y1="8" x2="18" y2="8" stroke="#ccc" stroke-width="1"/>
								<line x1="6" y1="12" x2="18" y2="12" stroke="#ccc" stroke-width="1"/>
								<line x1="6" y1="16" x2="14" y2="16" stroke="#ccc" stroke-width="1"/>
							</svg>
						</div>
						<div class="reviewer-info">
							<span class="reviewer-training">Instruction-Led Training 2</span>
							<span class="reviewer-name">Reviewer 01</span>
						</div>
					</div>
					<div class="reviewer-card">
						<div class="reviewer-icon">
							<svg viewBox="0 0 24 30" xmlns="http://www.w3.org/2000/svg">
								<rect x="2" y="0" width="20" height="26" rx="2" fill="none" stroke="#ccc" stroke-width="1.5"/>
								<line x1="6" y1="8" x2="18" y2="8" stroke="#ccc" stroke-width="1"/>
								<line x1="6" y1="12" x2="18" y2="12" stroke="#ccc" stroke-width="1"/>
								<line x1="6" y1="16" x2="14" y2="16" stroke="#ccc" stroke-width="1"/>
							</svg>
						</div>
						<div class="reviewer-info">
							<span class="reviewer-training">Instruction-Led Training 2</span>
							<span class="reviewer-name">Reviewer 02</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<script>
		const currentStep = 4;
		const pages = ['exam_payment.php', 'training_registration.php', 'training_payment.php', 'review.php'];
		
		// Get completed steps from localStorage
		function getCompletedSteps() {
			const completed = localStorage.getItem('completedSteps');
			return completed ? JSON.parse(completed) : [];
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
				window.location.href = pages[targetStep - 1];
			}
		}
		
		// Initialize on page load
		initializeSteps();
	</script>
	</body>
</html>