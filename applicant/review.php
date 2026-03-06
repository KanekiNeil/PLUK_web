<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Review - Alpha Aquila</title>

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{
font-family:Arial, Helvetica, sans-serif;
background:#f5f5f5;
}

.header{
background:white;
padding:15px 30px;
display:flex;
justify-content:space-between;
align-items:center;
border-bottom:1px solid #ddd;
}

.logo{
display:flex;
align-items:center;
gap:10px;
font-weight:bold;
font-size:16px;
color:#8B3A3A;
}

.logo img{
width:40px;
height:40px;
}

.container{
max-width:900px;
margin:20px auto;
background:white;
padding:25px 40px;
border-radius:8px;
box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

.steps-progress{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:40px;
position:relative;
}

.step{
display:flex;
flex-direction:column;
align-items:center;
gap:10px;
flex:1;
position:relative;
z-index:2;
cursor:pointer;
}

.step::after{
content:'';
position:absolute;
top:20px;
left:calc(50% + 25px);
width:calc(100% - 50px);
height:2px;
background:#ccc;
z-index:0;
}

.step:last-child::after{
display:none;
}

.step.completed::after{
background:#8B3A3A;
}

.step-number{
width:42px;
height:42px;
border-radius:50%;
background:white;
border:2px solid #ccc;
display:flex;
align-items:center;
justify-content:center;
font-weight:bold;
color:#666;
font-size:15px;
}

.step.completed .step-number,
.step.active .step-number{
background:#8B3A3A;
color:white;
border-color:#8B3A3A;
}

.step-label{
font-size:12px;
color:#666;
text-align:center;
font-weight:500;
}

.section-box{
border:1px solid #ddd;
border-radius:12px;
padding:25px 30px;
margin-bottom:25px;
position:relative;
}

.section-title{
position:absolute;
top:-12px;
left:30px;
background:white;
padding:0 10px;
font-size:14px;
font-weight:600;
color:#333;
}

/* Personal Details */

.personal-details{
display:flex;
align-items:center;
gap:30px;
}

.avatar{
width:70px;
height:70px;
border-radius:50%;
background:linear-gradient(135deg,#87CEEB 0%,#4A90D9 100%);
display:flex;
align-items:center;
justify-content:center;
}

.avatar svg{
width:45px;
height:45px;
fill:white;
}

.detail-group{
display:flex;
flex-direction:column;
gap:5px;
}

.detail-label{
font-size:11px;
color:#999;
}

.detail-value{
font-size:16px;
font-weight:600;
color:#333;
}

/* Payment */

.payment-row{
display:flex;
gap:20px;
margin-bottom:15px;
}

.payment-type{
font-size:11px;
color:#999;
min-width:120px;
}

.payment-date{
font-size:14px;
color:#333;
min-width:120px;
}

.payment-transaction{
font-size:14px;
color:#333;
}

/* Reviewers */

.training-section{
margin-bottom:20px;
}

.training-section-title{
font-size:13px;
font-weight:600;
color:#333;
margin-bottom:10px;
}

.reviewer-cards{
display:flex;
gap:15px;
}

.reviewer-card{
flex:1;
display:flex;
align-items:center;
justify-content:space-between;
padding:12px 15px;
border:1px solid #ddd;
border-radius:8px;
background:white;
cursor:pointer;
transition:0.2s;
}

.reviewer-card:hover{
background:#fafafa;
border-color:#8B3A3A;
}

.reviewer-left{
display:flex;
align-items:center;
gap:12px;
}

.reviewer-icon svg{
width:28px;
height:32px;
}

.reviewer-info{
display:flex;
flex-direction:column;
gap:2px;
}

.reviewer-training{
font-size:11px;
color:#999;
}

.reviewer-name{
font-size:13px;
color:#333;
font-weight:500;
}

/* DOWNLOAD BUTTON */

.download-btn{
background:#e5e5e5;
border:none;
border-radius:6px;
padding:6px;
cursor:pointer;
display:flex;
align-items:center;
justify-content:center;
}

.download-btn svg{
width:18px;
height:18px;
fill:#555;
}

.download-btn:hover{
background:#8B3A3A;
transform:scale(1.08);
}

.download-btn:hover svg{
fill:white;
}

@media (max-width:768px){

.container{
padding:20px;
margin:20px;
}

.personal-details{
flex-direction:column;
text-align:center;
}

.reviewer-cards{
flex-direction:column;
}

}
</style>
</head>

<body>

<div class="header">
<div class="logo">
<img src="../assets/nobg_logo.png">
<span>ALPHA AQUILA</span>
</div>
</div>

<div class="container">

<div class="steps-progress">

<div class="step completed" onclick="navigateToStep(1)">
<div class="step-number">1</div>
<div class="step-label">Verify Email</div>
</div>

<div class="step completed" onclick="navigateToStep(2)">
<div class="step-number">2</div>
<div class="step-label">Exam Payment</div>
</div>

<div class="step completed" onclick="navigateToStep(3)">
<div class="step-number">3</div>
<div class="step-label">Training Registration</div>
</div>

<div class="step completed" onclick="navigateToStep(4)">
<div class="step-number">4</div>
<div class="step-label">Training Payment</div>
</div>

<div class="step active">
<div class="step-number">5</div>
<div class="step-label">Review</div>
</div>

</div>

<!-- Personal -->

<div class="section-box">
<div class="section-title">Personal Details</div>

<div class="personal-details">

<div class="avatar">
<svg viewBox="0 0 24 24">
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

<!-- Payment -->

<div class="section-box">
<div class="section-title">Payment Details</div>

<div class="payment-row">
<span class="payment-type">Examination Payment</span>
<span class="payment-date">03 / 03 / 2026</span>
<span class="payment-transaction">TransactionID: 0262 82762 9033</span>
</div>

<div class="payment-row">
<span class="payment-type">Training Payment</span>
<span class="payment-date">03 / 03 / 2026</span>
<span class="payment-transaction">TransactionID: 0262 82762 9033</span>
</div>

</div>

<!-- REVIEWERS -->

<div class="section-box">
<div class="section-title">Reviewers</div>

<div class="training-section">
<div class="training-section-title">Instruction-Led Training 1</div>

<div class="reviewer-cards">

<div class="reviewer-card" onclick="window.open('reviewers/reviewer1.pdf','_blank')">

<div class="reviewer-left">
<div class="reviewer-icon">📄</div>

<div class="reviewer-info">
<span class="reviewer-training">Instruction-Led Training 1</span>
<span class="reviewer-name">Reviewer 01</span>
</div>
</div>

<a href="reviewers/reviewer1.pdf" download class="download-btn">
<svg viewBox="0 0 24 24">
<path d="M5 20h14v-2H5v2zM12 2v12l4-4 1.4 1.4L12 17.8l-5.4-5.4L8 10l4 4V2z"/>
</svg>
</a>

</div>


<div class="reviewer-card">

<div class="reviewer-left">
<div class="reviewer-icon">
📄
</div>

<div class="reviewer-info">
<span class="reviewer-training">Instruction-Led Training 1</span>
<span class="reviewer-name">Reviewer 02</span>
</div>
</div>

<a href="reviewers/reviewer2.pdf" download class="download-btn">
<svg viewBox="0 0 24 24">
<path d="M5 20h14v-2H5v2zM12 2v12l4-4 1.4 1.4L12 17.8l-5.4-5.4L8 10l4 4V2h0z"/>
</svg>
</a>

</div>

</div>
</div>


<div class="training-section">
<div class="training-section-title">Instruction-Led Training 2</div>

<div class="reviewer-cards">

<div class="reviewer-card">

<div class="reviewer-left">
<div class="reviewer-icon">
📄
</div>

<div class="reviewer-info">
<span class="reviewer-training">Instruction-Led Training 2</span>
<span class="reviewer-name">Reviewer 01</span>
</div>
</div>

<a href="reviewers/reviewer3.pdf" download class="download-btn">
<svg viewBox="0 0 24 24">
<path d="M5 20h14v-2H5v2zM12 2v12l4-4 1.4 1.4L12 17.8l-5.4-5.4L8 10l4 4V2h0z"/>
</svg>
</a>

</div>


<div class="reviewer-card">

<div class="reviewer-left">
<div class="reviewer-icon">
📄
</div>

<div class="reviewer-info">
<span class="reviewer-training">Instruction-Led Training 2</span>
<span class="reviewer-name">Reviewer 02</span>
</div>
</div>

<a href="reviewers/reviewer4.pdf" download class="download-btn">
<svg viewBox="0 0 24 24">
<path d="M5 20h14v-2H5v2zM12 2v12l4-4 1.4 1.4L12 17.8l-5.4-5.4L8 10l4 4V2h0z"/>
</svg>
</a>

</div>

</div>
</div>

</div>

</div>

<script>
const currentStep = 5;
const pages = ['verify_email.php','exam_payment.php','training_registration.php','training_payment.php','review.php'];

function navigateToStep(step){
if(step===currentStep) return;
window.location.href=pages[step-1];
}
</script>

</body>
</html>