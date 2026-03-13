<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
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

/* HEADER */

.header{
background:#6b0f1a;
color:white;
text-align:center;
padding:25px;
font-size:28px;
font-weight:bold;
letter-spacing:1px;
}

.container{
width:1100px;
margin:auto;
padding:50px 0;
}

/* ================= SERVICES SECTION ================= */

.services-section{
max-width:1200px;
margin:80px auto;
display:flex;
gap:40px;
justify-content:center;
}

/* COLUMNS */

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

/* LINKS */

.service-column a{
display:block;
text-decoration:none;
color:#444;
margin:10px 0;
padding:6px 0;
transition:.3s;
border-bottom:1px solid transparent;
}

.service-column a:hover{
color:#8b0014;
border-bottom:1px solid #8b0014;
padding-left:6px;
}

/* ================= RIGHT CARD ================= */

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

.policy-body h3{
font-size:18px;
margin-bottom:10px;
}

.visit-link{
text-decoration:none;
color:#d6001c;
font-weight:600;
}

.visit-link:hover{
text-decoration:underline;
}

</style>
</head>

<body>

<!-- ================= HEADER ================= -->

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

<li >

<a href="../user/services.php">Claim and Services</a>


</li>

<li>
<a href="../user/contactus.php">Contact Us</a>
</li>

</ul>

</nav>

</div>

</header>

<div class="header">Claim and Services</div>
<div class="container">


<!-- ================= SERVICES SECTION ================= -->

<div class="services-section">

<!-- PRU SERVICES -->

<div class="service-column">

<h3>PRUServices</h3>

<a href="quick_guide.php">Quick Guide</a>
<a href="signin.php">Sign in</a>
<a href="create_account.php">Create account</a>

</div>


<!-- MAKE REQUEST -->

<div class="service-column">

<h3>Make a Request</h3>

<a href="withdrawal.php">Partial Withdrawal</a>
<a href="payment.php">Payment link</a>

</div>


<!-- CLAIMS -->

<div class="service-column">

<h3>Claims</h3>

<a href="death_claim.php">Death claim</a>
<a href="critical_claim.php">Critical illness claim</a>
<a href="medical_claim.php">Medical claim</a>
<a href="disability_claim.php">Disability claim</a>

</div>


<!-- RIGHT CARD -->

<div class="policy-card">

<img src="../assets/claim.jpg">

<div class="policy-body">

<h3>Simpler way to manage your policy</h3>

<a class="visit-link" href="#">
Visit PRUServices →
</a>

</div>

</div>

</div>

</body>
</html>