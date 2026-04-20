<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<title>PRU Claim and Services</title>

<style>

/* ================= GLOBAL ================= */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    background-color: #f5f5f5;
    color: #333;
}

/* ================= HEADER ================= */
header {
    background: #ffffff;
    padding: 15px 40px;
    border-bottom: 1px solid #ddd;
    position: relative;
    z-index: 1000;
}

.header-container {
    display: flex;
    align-items: center;
}


.logo {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 50%; /* makes logo circular */
    border: 2px solid #8b0000; /* optional border color */
}


/* ================= LOGO ================= */
.logo-title {
    display: flex;
    align-items: center;
    gap: 10px;
}

.logo-title h1 {
    font-size: 14px;
    font-weight: 700;
}


/* ================= TOP NAVIGATION ================= */
.top-nav ul {
    display: flex;
    list-style: none;
    gap: 50px;
    ;
}

.top-nav ul li {
    position: relative; 
}

.top-nav ul li a {
    text-decoration: none;
    color: #8b0000;
    font-weight: 600;
    font-size: 14px;
    padding: 10px 0;
    display: block;
    transition: 0.3s ease;
}

.top-nav ul li a:hover {
    opacity: 0.8;
}

.top-nav {
    margin-left: 500px;
}

/* ================= DROPDOWN ================= */
.top-nav ul li .dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    width: 200px;
    background: #ffffff;
    padding: 0;
    margin: 0;
    border-radius: 6px;
    box-shadow: 0 8px 18px rgba(0,0,0,0.06);

    display: block; /* vertical layout */
    opacity: 0;
    visibility: hidden;
    transform: translateY(5px);
    transition: all 0.2s ease;
    z-index: 999;
}

.top-nav ul li .dropdown-menu li a {
    text-align: left;
    padding: 10px 15px;
    display: block;
}

/* Show dropdown on hover */
.top-nav ul li:hover > .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

/* Dropdown items */
.dropdown-menu li {
    display: block;
    margin: 0; /* remove spacing between items */
    padding: 0;
    list-style: none;
}

.dropdown-menu li a {
    display: block;
    width: 100%;
    padding-left: 50px;
    padding: 6px 20px; /* spacing controlled here */
    font-size: 13px;
    font-weight: 500;
    color: #333;
    line-height: 1.2;
    text-decoration: none;
    white-space: nowrap;
    cursor: pointer;
}

.dropdown-menu li a:hover {
    background: #f3f3f3;
    color: #8b0000;
}

/* Dropdown arrow indicator */
.dropdown > a::after {
    content: " ▼";
    font-size: 10px;
    margin-left: 4px;
    color: #8b0000;
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
background:rgba(15,15,15,0.55);
backdrop-filter:blur(10px);
justify-content:center;
align-items:center;
z-index:2000;
animation:fadeIn .3s ease;
}

.modal-content{
width:680px;
max-width:92%;
border-radius:22px;
background:linear-gradient(145deg,#ffffff,#f9f9f9);
box-shadow:0 25px 60px rgba(0,0,0,0.15);
overflow:hidden;
animation:modalEnter .35s ease;
}
/* MODAL HEADER */

.modal-header{
background:linear-gradient(135deg,#8b0014,#b3122a);
color:white;
display:flex;
align-items:center;
padding:22px 28px;
gap:14px;
position:relative;
}

.modal-header{
    position: relative;
    z-index: 2;
}

.close-btn{
    position: relative;
    z-index: 3;
}

.modal-header::after{
content:"";
position:absolute;
inset:0;
background:linear-gradient(120deg,transparent,rgba(255,255,255,0.15),transparent);
opacity:.4;
}

.modal-icon{
width:42px;
height:42px;
border-radius:12px;
background:rgba(255,255,255,0.15);
display:flex;
align-items:center;
justify-content:center;
font-size:18px;
backdrop-filter:blur(6px);
}

.modal-header h2{
flex:1;
font-size:18px;
font-weight:600;
letter-spacing:.4px;
}

.close-btn{
width:34px;
height:34px;
display:flex;
align-items:center;
justify-content:center;
border-radius:50%;
background:rgba(255,255,255,0.15);
cursor:pointer;
font-size:18px;
transition:.25s;
}

.close-btn:hover{
background:white;
color:#8b0014;
transform:rotate(90deg);
}

/* MODAL BODY */

.modal-body{
padding:32px;
display:flex;
flex-direction:column;
gap:24px;
}

/* CLICKABLE SMALL TITLE */

.modal-link{
font-size:13.5px;
font-weight:600;
color:#6b0f1a;
text-decoration:none;
position:relative;
width:fit-content;
}

.modal-link::after{
content:"";
display:block;
height:2px;
width:0%;
background:#8b0014;
transition:.3s;
}

.modal-link:hover{
color:#b3122a;
}

.modal-link:hover::after{
width:100%;
}


/* MAIN TITLE */

.modal-main-title{
font-size:38px;
font-weight:800;
letter-spacing:1px;
margin:10px 0;
color:#111;
}

/* SUBTEXT */

.modal-subtext{
font-size:17px;
color:#555;
max-width:520px;
margin:auto;
line-height:1.6;
}


/* DIVIDER */
.modal-divider{
width:50px;
height:3px;
background:linear-gradient(90deg,#8b0014,#d94b5f);
border-radius:10px;
margin:10px 0;
}

/* INFO BOX */

.info-box{
background:#fafafa;
padding:18px;
border-radius:12px;
margin-bottom:15px;
box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

/* FEATURE ROW (REPLACES BULLETS) */

.feature{
display:flex;
align-items:flex-start;
gap:12px;
padding:10px 0;
border-bottom:1px solid #eee;
}

.feature:last-child{
border-bottom:none;
}

.feature-icon{
width:26px;
height:26px;
background:#8b0014;
color:white;
display:flex;
align-items:center;
justify-content:center;
border-radius:6px;
font-size:14px;
flex-shrink:0;
}

.feature-text{
flex:1;
color:#444;
}

/* HERO SECTION */
.modal-hero{
display:flex;
align-items:center;
gap:18px;
background:linear-gradient(145deg,#fafafa,#ffffff);
padding:18px;
border-radius:16px;
box-shadow:0 8px 20px rgba(0,0,0,0.05);
}

/* ICON INSIDE BODY */
.modal-hero-icon{
width:55px;
height:55px;
background:linear-gradient(135deg,#8b0014,#b3122a);
color:white;
display:flex;
align-items:center;
justify-content:center;
border-radius:14px;
font-size:22px;
box-shadow:0 8px 18px rgba(139,0,20,0.25);
}

/* TITLE IMPROVED */
.modal-main-title{
font-size:22px;
font-weight:700;
color:#111;
}

/* SUBTEXT */
.modal-subtext{
font-size:14.5px;
color:#666;
margin-top:4px;
line-height:1.5;
}

/* CTA BUTTON */
.cta-btn{
display:inline-flex;
align-items:center;
gap:10px;
margin-top:12px;

background:linear-gradient(135deg,#8b0014,#b3122a);
color:white;

padding:14px 22px;
border-radius:14px;

font-weight:600;
font-size:14px;
letter-spacing:.3px;

cursor:pointer;
transition:.3s ease;

box-shadow:0 10px 25px rgba(139,0,20,0.25);
position:relative;
overflow:hidden;
}

/* arrow */
.cta-btn::after{
content:"→";
font-size:16px;
transition:.3s;
}

/* shine effect */
.cta-btn::before{
content:"";
position:absolute;
top:0;
left:-100%;
width:100%;
height:100%;
background:linear-gradient(120deg,transparent,rgba(255,255,255,0.4),transparent);
transition:.5s;
}

/* hover */
.cta-btn:hover{
transform:translateY(-3px) scale(1.02);
box-shadow:0 15px 35px rgba(139,0,20,0.35);
}

.cta-btn:hover::before{
left:100%;
}

.cta-btn:hover::after{
transform:translateX(4px);
}

/* ANIMATION */

@keyframes modalEnter{
from{
transform:translateY(30px) scale(.95);
opacity:0;
}
to{
transform:translateY(0) scale(1);
opacity:1;
}
}

@keyframes fadeIn{
from{opacity:0;}
to{opacity:1;}
}

</style>
</head>

<body>

<?php include '../components/user_header.php'; ?>


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

<div class="modal-icon" id="modalIcon">
<i class="fas fa-shield-alt"></i>
</div>
<h2 id="modalTitle"></h2>
<button class="close-btn">&times;</button>

</div>

<div class="modal-body" id="modalText"></div>

</div>

</div>

<script>

const modal = document.getElementById("serviceModal");
const modalTitle = document.getElementById("modalTitle");
const modalText = document.getElementById("modalText");
const closeBtn = document.querySelector(".close-btn");
const modalIcon = document.getElementById("modalIcon");
const serviceData = {

premium:{
title:"Premium Payment Facilities",
text:`

<div class="modal-hero">

    <div class="modal-hero-icon">
        <i class="fas fa-credit-card"></i>
    </div>

    <div>
        <div class="modal-main-title">
            Premium Payment Facilities
        </div>

        <div class="modal-subtext">
            Pay your premiums easily through secure and convenient channels.
        </div>
    </div>

</div>

<div class="modal-divider"></div>

<a href="your-link-here.html" class="modal-link">
    Answering Your Policy Questions →
</a>

<a href="#" class="cta-btn">Proceed to Service</a>


`
},

forms:{
title:"Downloadable Forms",
text:`

<div class="modal-hero">

    <div class="modal-hero-icon">
        <i class="fas fa-file-alt"></i>
    </div>

    <div>
        <div class="modal-main-title">
            Downloadable Forms
        </div>

        <div class="modal-subtext">
           Find all the essential forms for policy-related transactions in just one click.
        </div>
    </div>

</div>

<div class="modal-divider"></div>

<a href="your-link-here.html" class="modal-link">
    What form do you need today?→
</a>

<div class="cta-btn">
    Proceed to Service
</div>

`
},

faq:{
title:"Policy FAQs",
text:`

<div class="modal-hero">

    <div class="modal-hero-icon">
        <i class="fas fa-circle-question"></i>
    </div>

    <div>
        <div class="modal-main-title">
            Policy FAQs
        </div>

        <div class="modal-subtext">
            Find the answer to your questions about your policy and our services.
        </div>
    </div>

</div>

<div class="modal-divider"></div>

<a href="your-link-here.html" class="modal-link">
    Answering Your Policy Questions →
</a>

<div class="cta-btn">
    Proceed to Service
</div>

`
},

withdrawal:{
title:"Partial Withdrawal",
text:`
<div class="modal-hero">

    <div class="modal-hero-icon">
        <i class="fa-money-bill-wave"></i>
    </div>

    <div>
        <div class="modal-main-title">
            Partial Withdrawal
        </div>

        <div class="modal-subtext">
            Find the answer to your questions about your policy and our services.
        </div>
    </div>

</div>

<div class="modal-divider"></div>

<a href="your-link-here.html" class="modal-link">
   Make a Request →
</a>

<div class="cta-btn">
    Proceed to Service
</div>
`
},

payment:{
title:"Payment Link",
text:`
<div class="modal-hero">

    <div class="modal-hero-icon">
        <i class="fas fa-link"></i>
    </div>

    <div>
        <div class="modal-main-title">
           Payment Link
        </div>

        <div class="modal-subtext">
            Request for a payment Link
        </div>
    </div>

</div>

<div class="modal-divider"></div>

<a href="your-link-here.html" class="modal-link">
    Payment Link →
</a>

<div class="cta-btn">
    Proceed to Service
</div>
`
},

death:{
title:"Death Claim",
text:`
<div class="modal-hero">

    <div class="modal-hero-icon">
        <i class="fas fa-hand-holding-heart"></i>
    </div>

    <div>
        <div class="modal-main-title">
           Filling a Death Claim
        </div>

        <div class="modal-subtext">
            Seamless and with outmost care and compassion for you.
        </div>
    </div>

</div>

<div class="modal-divider"></div>

<a href="your-link-here.html" class="modal-link">
    We Make Claims Convenient and Accessible →
</a>

<div class="cta-btn">
    Proceed to Service
</div>
`
},

critical:{
title:"Critical Illness Claim",
text:`
<div class="modal-hero">

    <div class="modal-hero-icon">
        <i class="fas fa-heart-pulse"></i>
    </div>

    <div>
        <div class="modal-main-title">
            Filling a Critical Illness Claim 
        </div>

        <div class="modal-subtext">
           Seamless and with outmost care and compassion for you.
        </div>
    </div>

</div>

<div class="modal-divider"></div>

<a href="your-link-here.html" class="modal-link">
   We Make Claims Convenient and Accessible →
</a>

<div class="cta-btn">
    Proceed to Service
</div>
`
},

medical:{
title:"Medical Claim",
text:`
<div class="modal-hero">

    <div class="modal-hero-icon">
        <i class="fas fa-notes-medical"></i>
    </div>

    <div>
        <div class="modal-main-title">
            Filling a Medical Claim
        </div>

        <div class="modal-subtext">
            Seamless and with outmost care and compassion for you.
        </div>
    </div>

</div>

<div class="modal-divider"></div>

<a href="your-link-here.html" class="modal-link">
    We Make Claims Convenient and Accessible →
</a>

<div class="cta-btn">
    Proceed to Service
</div>
`
},

disability:{
title:"Disability Claim",
text:`
<div class="modal-hero">

    <div class="modal-hero-icon">
        <i class="fas fa-wheelchair"></i>
    </div>

    <div>
        <div class="modal-main-title">
            Filling a Disability Claim
        </div>

        <div class="modal-subtext">
            Seamless and with outmost care and compassion for you.
        </div>
    </div>

</div>

<div class="modal-divider"></div>

<a href="your-link-here.html" class="modal-link">
   We Make Claims Convenient and Accessible →
</a>

<div class="cta-btn">
    Proceed to Service
</div>
`
}

};
document.querySelectorAll(".service-btn").forEach(btn=>{
btn.addEventListener("click",function(){

let service=this.dataset.service;

modalTitle.innerText=serviceData[service].title;
modalText.innerHTML=serviceData[service].text;

// ICON SWITCH
let iconMap = {
premium: "fa-credit-card",
forms: "fa-file-alt",
faq: "fa-circle-question",
withdrawal: "fa-money-bill-wave",
payment: "fa-link",
death: "fa-hand-holding-heart",
critical: "fa-heart-pulse",
medical: "fa-notes-medical",
disability: "fa-wheelchair"
};

modalIcon.innerHTML = `<i class="fas ${iconMap[service]}"></i>`;

modal.style.display="flex";

});
});

// Use event delegation (always works)
document.addEventListener("click", function(e){
    if(e.target.closest(".close-btn")){
        modal.style.display = "none";
    }
});

window.onclick=function(e){
if(e.target==modal){
modal.style.display="none";
}
}

</script>

</body>
</html>