<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>PRU Claim and Services</title>

<style>

/* ================= GLOBAL ================= */
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Segoe UI',sans-serif;
}

body{
background:#f5f5f5;
color:#333;
}

/* ================= HEADER ================= */
header{
background:#ffffff;
padding:15px 40px;
border-bottom:1px solid #ddd;
position:relative;
z-index:1000;
}

.header-container{
display:flex;
align-items:center;
}

.logo{
width:60px;
height:60px;
object-fit:cover;
border-radius:50%;
border:2px solid #8b0000;
}

.logo-title{
display:flex;
align-items:center;
gap:10px;
}

.logo-title h1{
font-size:14px;
font-weight:700;
}

/* ================= NAV ================= */

.top-nav ul{
display:flex;
list-style:none;
gap:50px;
}

.top-nav ul li{
position:relative;
}

.top-nav ul li a{
text-decoration:none;
color:#8b0000;
font-weight:600;
font-size:14px;
padding:10px 0;
display:block;
}

.top-nav ul li a:hover{
opacity:.8;
}

.top-nav{
margin-left:500px;
}

/* ================= DROPDOWN ================= */

.top-nav ul li .dropdown-menu{
position:absolute;
top:100%;
left:0;
width:200px;
background:#fff;
border-radius:6px;
box-shadow:0 8px 18px rgba(0,0,0,0.06);
opacity:0;
visibility:hidden;
transform:translateY(5px);
transition:.2s;
}

.top-nav ul li:hover > .dropdown-menu{
opacity:1;
visibility:visible;
transform:translateY(0);
}

.dropdown-menu li{
list-style:none;
}

.dropdown-menu li a{
padding:8px 20px;
font-size:13px;
color:#333;
display:block;
}

.dropdown-menu li a:hover{
background:#f3f3f3;
color:#8b0000;
}

.dropdown > a::after{
content:" ▼";
font-size:10px;
margin-left:4px;
color:#8b0000;
}

/* ================= HEADER TITLE ================= */

.header{
background:#6b0f1a;
color:white;
text-align:center;
padding:25px;
font-size:28px;
font-weight:bold;
}

/* ================= CONTAINER ================= */

.container{
width:1100px;
margin:auto;
padding:50px 0;
}

/* ================= SERVICES ================= */

.services-section{
max-width:1200px;
margin:80px auto;
display:flex;
gap:40px;
justify-content:center;
}

.service-column{
background:white;
padding:25px;
border-radius:12px;
width:230px;
box-shadow:0 6px 20px rgba(0,0,0,0.06);
transition:.3s;
}

.service-column:hover{
transform:translateY(-5px);
}

.service-column h3{
margin-bottom:15px;
font-size:18px;
}

.service-column a{
display:block;
text-decoration:none;
color:#444;
margin:10px 0;
padding:6px 0;
border-bottom:1px solid transparent;
cursor:pointer;
transition:.3s;
}

.service-column a:hover{
color:#8b0014;
border-bottom:1px solid #8b0014;
padding-left:6px;
}

/* ================= POLICY CARD ================= */

.policy-card{
width:280px;
background:white;
border-radius:14px;
overflow:hidden;
box-shadow:0 10px 25px rgba(0,0,0,0.08);
transition:.3s;
}

.policy-card:hover{
transform:translateY(-6px);
}

.policy-card img{
width:100%;
height:170px;
object-fit:cover;
}

.policy-body{
padding:18px;
}

.visit-link{
text-decoration:none;
color:#d6001c;
font-weight:600;
}

/* ================= MODAL ================= */

.modal{
display:none;
position:fixed;
left:0;
top:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.5);
justify-content:center;
align-items:center;
z-index:2000;
}

.modal-content{
background:white;
width:520px;
max-width:95%;
border-radius:12px;
overflow:hidden;
box-shadow:0 20px 40px rgba(0,0,0,0.2);
animation:fade .3s ease;
}

/* MODAL HEADER */

.modal-header{
background:#8b0014;
color:white;
display:flex;
align-items:center;
padding:18px 22px;
gap:12px;
}

.modal-icon{
width:38px;
height:38px;
background:white;
color:#8b0014;
display:flex;
align-items:center;
justify-content:center;
border-radius:8px;
font-weight:bold;
}

.modal-header h2{
flex:1;
font-size:18px;
}

.close-btn{
font-size:22px;
cursor:pointer;
}

/* MODAL BODY */

.modal-body{
padding:25px;
max-height:500px;
overflow-y:auto;
line-height:1.9;
font-size: 20px;
}

/* INFO BOX */

.info-box{
background:#f7f7f7;
padding:14px;
border-radius:8px;
margin-bottom:12px;
border-left:4px solid #8b0014;
}

.info-box ul{
padding-left:18px;
margin-top:6px;
}

.info-box li{
margin-bottom:6px;
}

/* ANIMATION */

@keyframes fade{
from{transform:scale(.9);opacity:0;}
to{transform:scale(1);opacity:1;}
}

</style>
</head>

<body>

<header>

<div class="header-container">

<div class="logo-title">
<img src="../assets/logo.jpg" class="logo">
<h1>ALPHA AQUILA</h1>
</div>

<nav class="top-nav">

<ul>
<li><a href="../index.php">Home</a></li>

<li class="dropdown">
<a href="#">Work with Us</a>
<ul class="dropdown-menu">
<li><a href="#">Sales</a></li>
<li><a href="#">Career</a></li>
</ul>
</li>

<li><a href="../user/services.php">Claim and Services</a></li>
<li><a href="../user/contactus.php">Contact Us</a></li>

</ul>

</nav>

</div>

</header>

<div class="header">Claim and Services</div>

<div class="container">

<div class="services-section">

<!-- POLICY INFO -->
<div class="service-column">
<h3>Policy services information</h3>

<a class="service-btn" data-service="premium">Premium Payment facilities</a>
<a class="service-btn" data-service="forms">Downloadable Forms</a>
<a class="service-btn" data-service="faq">Policy FAQS</a>

</div>

<!-- REQUEST -->
<div class="service-column">

<h3>Make a Request</h3>

<a class="service-btn" data-service="withdrawal">Partial Withdrawal</a>
<a class="service-btn" data-service="payment">Payment link</a>

</div>

<!-- CLAIMS -->
<div class="service-column">

<h3>Claims</h3>

<a class="service-btn" data-service="death">Death claim</a>
<a class="service-btn" data-service="critical">Critical illness claim</a>
<a class="service-btn" data-service="medical">Medical claim</a>
<a class="service-btn" data-service="disability">Disability claim</a>

</div>

<!-- CARD -->
<div class="policy-card">

<img src="../assets/claim.jpg">

<div class="policy-body">
<h3>Simpler way to manage your policy</h3>
<a class="visit-link" href="#">Visit PRUServices →</a>
</div>

</div>

</div>

</div>

<!-- MODAL -->

<div class="modal" id="serviceModal">

<div class="modal-content">

<div class="modal-header">

<div class="modal-icon">ℹ️</div>
<h2 id="modalTitle"></h2>
<span class="close-btn">&times;</span>

</div>

<div class="modal-body" id="modalText"></div>

</div>

</div>

<script>

const modal = document.getElementById("serviceModal");
const modalTitle = document.getElementById("modalTitle");
const modalText = document.getElementById("modalText");
const closeBtn = document.querySelector(".close-btn");

const serviceData = {

premium:{
title:"Premium Payment Facilities",
text:`
<div class="info-box">
<strong>Payment Methods</strong>
<ul>
<li>PRUServices Online Payment</li>
<li>GCash Bills Payment</li>
<li>Online Banking</li>
<li>Automatic Debit / Credit Card</li>
<li>Authorized Payment Centers</li>
</ul>
</div>

<div class="info-box">
Payments are usually posted within 2–3 working days.
</div>
`
},

forms:{
title:"Downloadable Forms",
text:`
<div class="info-box">
<strong>Available Forms</strong>
<ul>
<li>Policy Amendment Forms</li>
<li>Claim Forms</li>
<li>Beneficiary Change Forms</li>
<li>Policy Servicing Forms</li>
</ul>
</div>
`
},

faq:{
title:"Policy FAQs",
text:`
<div class="info-box">
<ul>
<li>How to pay premiums</li>
<li>Understanding policy coverage</li>
<li>Claim procedures</li>
<li>Policy updates</li>
</ul>
</div>
`
},

withdrawal:{
title:"Partial Withdrawal",
text:`
<div class="info-box">
<ul>
<li>Available for investment-linked policies</li>
<li>Minimum fund value required</li>
<li>Requires withdrawal request form</li>
</ul>
</div>
`
},

payment:{
title:"Payment Link",
text:`
<div class="info-box">
Secure online payment through personalized payment links.
</div>
`
},

death:{
title:"Death Claim",
text:`
<div class="info-box">
<ul>
<li>Death certificate</li>
<li>Claim form</li>
<li>Policy details</li>
<li>Beneficiary identification</li>
</ul>
</div>
`
},

critical:{
title:"Critical Illness Claim",
text:`
<div class="info-box">
<ul>
<li>Cancer</li>
<li>Heart attack</li>
<li>Stroke</li>
<li>Kidney failure</li>
</ul>
</div>
`
},

medical:{
title:"Medical Claim",
text:`
<div class="info-box">
<ul>
<li>Hospital bills</li>
<li>Medical certificate</li>
<li>Doctor's statement</li>
</ul>
</div>
`
},

disability:{
title:"Disability Claim",
text:`
<div class="info-box">
<ul>
<li>Lump sum benefit</li>
<li>Income replacement</li>
<li>Premium waiver</li>
</ul>
</div>
`
}

};

document.querySelectorAll(".service-btn").forEach(btn=>{
btn.addEventListener("click",function(){

let service=this.dataset.service;

modalTitle.innerText=serviceData[service].title;
modalText.innerHTML=serviceData[service].text;

modal.style.display="flex";

});
});

closeBtn.onclick=function(){
modal.style.display="none";
}

window.onclick=function(e){
if(e.target==modal){
modal.style.display="none";
}
}

</script>

</body>
</html>