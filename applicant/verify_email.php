<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Verify Email - Alpha Aquila</title>
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
		   <!-- Modal Trigger -->
		   <button class="submit-btn" id="openModalBtn">Verify Email</button>
		   <!-- Modal -->
		   <div id="verifyModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.3); z-index:1000;">
			   <div id="modalSlider" style="background:white; width:400px; height:480px; margin:100px auto; padding:30px; border-radius:8px; box-shadow:0 2px 10px rgba(0,0,0,0.2); position:relative; overflow:hidden;">
				   <span id="closeModalBtn" style="position:absolute; top:10px; right:15px; cursor:pointer; font-size:20px;">&times;</span>
				   <div class="slider-container" style="position:relative; width:100%; height:420px; overflow:hidden;">
					   <div class="slider-view email-view" style="width:100%; height:100%; position:absolute; left:0; top:0; transition:left 0.5s cubic-bezier(.68,-0.55,.27,1.55); background:white;">
						   <h2>Verify your email address</h2>
						   <div class="form-group">
							   <input type="email" id="email" placeholder="Email" required>
						   </div>
						   <div class="form-group">
							   <input type="text" id="applicantionId" name="app_id" placeholder="Applicant ID" required>
						   </div>
						   <div class="description" id="description">
							   In order to start using your pluk account. You need to<br>
							   confirm your pluk email address.
						   </div>
						   <div id="statusMessage" style="display: none; padding: 15px; border-radius: 8px; margin-bottom: 20px;"></div>
						   <div id="verificationLinksContainer" style="display:none;">
							   <div style="margin-top: 20px; text-align:center;">
								   <a href="#" id="resendVerificationLink" style="color: #8B3A3A; font-weight: bold; text-decoration:underline;">Resend Verification Email</a>
							   </div>
							   <div style="margin-top: 10px; text-align:center;">
								   <span id="useApplicantIdAfterSend" style="color:#8B3A3A; cursor:pointer; text-decoration:underline; font-size:16px; font-weight:normal;">Use Applicant ID instead</span>
							   </div>
						   </div>
						   <button class="submit-btn" id="submitBtn" onclick="verifyEmail()">Send Verification Email</button>
						  <div id="resendSection" style="display: none; margin-top: 15px;">
							  <p style="color: #666; font-size: 13px;">Didn't receive the email? <a href="#" onclick="verifyEmail(); return false;" style="color: #8B3A3A; font-weight: bold;">Resend</a></p>
						  </div>
						   <div style="margin-top: 20px; text-align:center;">
							   <span id="useApplicantId" style="color:#8B3A3A; cursor:pointer; font-size:13px; text-decoration:underline;">Use Applicant ID instead</span>
						   </div>
					   </div>
					   <div class="slider-view applicantid-view" style="width:100%; height:100%; position:absolute; left:100%; top:0; transition:left 0.5s cubic-bezier(.68,-0.55,.27,1.55); background:white;">
						   <h2>Applicant Login</h2>
						   <div class="form-group">
							   <input type="text" id="applicantId" placeholder="Applicant ID" required>
						   </div>
						   <div class="form-group">
							   <input type="password" id="applicantPassword" placeholder="Password" required>
						   </div>
						   <button class="submit-btn" id="loginBtn">Login</button>
						   <div style="margin-top: 20px; text-align:center;">
							   <span id="backToEmail" style="color:#8B3A3A; cursor:pointer; font-size:13px; text-decoration:underline;">Back to Email Verification</span>
						   </div>
					   </div>
				   </div>
			   </div>
		   </div>
	   </div>
   </div>
   <script>
	   // Modal logic
	   document.getElementById('openModalBtn').onclick = function() {
		   document.getElementById('verifyModal').style.display = 'block';
		   // Reset slider position
		   document.querySelector('.slider-container').style.transform = 'translateX(0px)';
	   };
	   document.getElementById('closeModalBtn').onclick = function() {
		   document.getElementById('verifyModal').style.display = 'none';
	   };
	   window.onclick = function(event) {
		   if (event.target === document.getElementById('verifyModal')) {
			   document.getElementById('verifyModal').style.display = 'none';
		   }
	   };
	   // Slide to Applicant ID view
	   document.addEventListener('DOMContentLoaded', function() {
		   const emailView = document.querySelector('.email-view');
		   const applicantIdView = document.querySelector('.applicantid-view');
		   document.getElementById('useApplicantId').onclick = function() {
			   emailView.style.left = '-100%';
			   applicantIdView.style.left = '0';
		   };
		   document.getElementById('backToEmail').onclick = function() {
			   emailView.style.left = '0';
			   applicantIdView.style.left = '100%';
		   };
		   // Reset on modal open
		   document.getElementById('openModalBtn').onclick = function() {
			   document.getElementById('verifyModal').style.display = 'block';
			   emailView.style.left = '0';
			   applicantIdView.style.left = '100%';
		   };
	   });
	   // ...existing code...
	   // Steps logic
	   const currentStep = 1;
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
				   // Lock steps 2-5 if email not verified
				   if (stepNum > 1 && !completed.includes(1)) {
					   step.classList.add('locked');
					   step.onclick = null;
				   } else if (completed.includes(stepNum) || stepNum <= Math.max(...completed, 0) + 1) {
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
		
		function verifyEmail() {
			const email = document.getElementById('email').value;
			const submitBtn = document.getElementById('submitBtn');
			const statusMessage = document.getElementById('statusMessage');
			const resendSection = document.getElementById('resendSection');
			
			if (!email) {
				Swal.fire({ text: 'Please enter an email address', icon: 'warning', confirmButtonText: 'OK' });
				return;
			}
		
			if (!validateEmail(email)) {
				Swal.fire({ text: 'Please enter a valid email address', icon: 'warning', confirmButtonText: 'OK' });
				return;
			}
			
			// Disable button and show loading
			submitBtn.disabled = true;
			submitBtn.textContent = 'Sending...';
			
			// Send verification email via API
			const formData = new FormData();
			formData.append('email', email);
			formData.append('app_id', document.getElementById('applicantionId').value);
                          
			fetch('../php/send_verification.php', {
				method: 'POST',
				body: formData
			})
			.then(response => response.json())
			.then(data => {
				submitBtn.disabled = false;
				submitBtn.textContent = 'Send Verification Email';
				
				if (data.success) {
					// Show success message
							  statusMessage.style.display = 'block';
							  statusMessage.style.background = '#e8f5e9';
							  statusMessage.style.color = '#2e7d32';
							  statusMessage.innerHTML = `
								  <strong style="font-size: 16px;">Verification Email Sent</strong><br><br>
								  <p>A verification email has been sent to <strong>${email}</strong>.</p>
								  <p style="margin-top: 10px;">Please check your inbox and follow the instructions to verify your email address and proceed with your application.</p>
								  <p style="margin-top: 15px; color: #666; font-size: 12px;">If you do not receive the email within a few minutes, please check your spam or junk folder.</p>
							  `;
							  // Show links inside modal
							  var linksContainer = document.getElementById('verificationLinksContainer');
							  if (linksContainer) {
								  linksContainer.style.display = 'block';
								  document.getElementById('resendVerificationLink').onclick = function() {
									  verifyEmail(); return false;
								  };
								  setTimeout(function() {
									  var useApplicantId = document.getElementById('useApplicantIdAfterSend');
									  if (useApplicantId) {
										  useApplicantId.onclick = function() {
											  document.querySelector('.email-view').style.left = '-100%';
											  document.querySelector('.applicantid-view').style.left = '0';
										  };
									  }
								  }, 100);
							  }
                              
							  setTimeout(function() {
								  var useApplicantId = document.getElementById('useApplicantIdAfterSend');
								  if (useApplicantId) {
									  useApplicantId.onclick = function() {
										  document.querySelector('.email-view').style.left = '-100%';
										  document.querySelector('.applicantid-view').style.left = '0';
									  };
								  }
							  }, 100);
				} else {
					// Show error message
					statusMessage.style.display = 'block';
					statusMessage.style.background = '#ffebee';
					statusMessage.style.color = '#c62828';
					statusMessage.innerHTML = '<strong>Error:</strong> ' + data.message;
				}
			})
			.catch(error => {
				submitBtn.disabled = false;
				submitBtn.textContent = 'Send Verification Email';
				
				statusMessage.style.display = 'block';
				statusMessage.style.background = '#ffebee';
				statusMessage.style.color = '#c62828';
				statusMessage.innerHTML = '<strong>Error:</strong> Could not send verification email. Please try again.';
				
				console.error('Error:', error);
			});
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
		   // Initialize on page load
		   initializeSteps();
	   </script>
	</body>
	</html>
