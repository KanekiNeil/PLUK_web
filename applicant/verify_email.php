<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Verify Email - Alpha Aquila</title>
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
		
		.content {
			text-align: center;
		}
		
		.email-icon {
			width: 80px;
			height: 80px;
			border: 2px solid #ddd;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			margin: 0 auto 30px;
			font-size: 40px;
			color: #999;
		}
		
		.content h2 {
			color: #333;
			font-size: 24px;
			margin-bottom: 20px;
		}
		
		.form-group {
			margin-bottom: 30px;
		}
		
		.form-group input {
			width: 100%;
			max-width: 400px;
			padding: 12px;
			border: none;
			border-bottom: 2px solid #ddd;
			font-size: 14px;
			color: #333;
		}
		
		.form-group input:focus {
			outline: none;
			border-bottom-color: #8B3A3A;
		}
		
		.form-group input::placeholder {
			color: #999;
		}
		
		.description {
			color: #666;
			font-size: 13px;
			margin: 20px 0 30px;
			line-height: 1.6;
		}
		
		.submit-btn {
			width: 100%;
			max-width: 400px;
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
				margin-bottom: 30px;
			}
			
			.step-label {
				font-size: 10px;
			}
			
			.content h2 {
				font-size: 18px;
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
			<div class="step active" onclick="navigateToStep(1)">
				<div class="step-number">1</div>
				<div class="step-label">Verify Email</div>
			</div>
			
			<div class="step" onclick="navigateToStep(2)">
				<div class="step-number">2</div>
				<div class="step-label">Exam Payment</div>
			</div>
			
			<div class="step" onclick="navigateToStep(3)">
				<div class="step-number">3</div>
				<div class="step-label">Training Registration</div>
			</div>
			
			<div class="step" onclick="navigateToStep(4)">
				<div class="step-number">4</div>
				<div class="step-label">Training Payment</div>
			</div>
			
			<div class="step" onclick="navigateToStep(5)">
				<div class="step-number">5</div>
				<div class="step-label">Review</div>
			</div>
		</div>
		
		<!-- Content -->
		<div class="content">
			<!-- Email Icon -->
			<div class="email-icon">✉️</div>
			
			<!-- Heading -->
			<h2>Verify your email address</h2>
			
			<!-- Email Input -->
			<div class="form-group">
				<input type="email" id="email" placeholder="Email" required>
			</div>
			
			<!-- Description -->
			<div class="description">
				In order to start using your pluk account. You need to<br>
				confirm your pluk email address.
			</div>
			
			<!-- Submit Button -->
			<button class="submit-btn" onclick="verifyEmail()">Verify Email Address</button>
		</div>
	</div>
	
	<script>
		const currentStep = 1;
		const pages = ['verify_email.php', 'exam_payment.php', 'training_registration.php', 'training_payment.php', 'review.php'];
		
		function navigateToStep(targetStep) {
			if (targetStep === currentStep) return;
			window.location.href = pages[targetStep - 1];
		}
		
		function verifyEmail() {
			const email = document.getElementById('email').value;
			
			if (!email) {
				alert('Please enter an email address');
				return;
			}
			
			if (!validateEmail(email)) {
				alert('Please enter a valid email address');
				return;
			}
			
			// TODO: Send verification email
			alert('Verification email sent to ' + email);
			console.log('Email verified:', email);
			window.location.href = 'exam_payment.php';
		}
		
		function validateEmail(email) {
			const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			return regex.test(email);
		}
		
		// Allow Enter key to submit
		document.getElementById('email').addEventListener('keypress', function(e) {
			if (e.key === 'Enter') {
				verifyEmail();
			}
		});
	</script>
</body>
</html>
