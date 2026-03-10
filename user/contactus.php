<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $policyowner = $_POST['policyowner'] ?? "";
    $name = $_POST['name'] ?? "";
    $email = $_POST['email'] ?? "";
    $messageText = $_POST['message'] ?? "";

    $message = "Thank you for contacting us, $name! We received your message.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Contact Us</title>

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

/* MAIN CONTAINER */

.container{
width:1100px;
margin:auto;
padding:50px 0;
}

/* SUCCESS MESSAGE */

.success{
background:#d4edda;
color:#155724;
padding:12px;
border-radius:6px;
margin-bottom:20px;
}

/* CONTACT WRAPPER */

.contact-wrapper{
display:flex;
gap:50px;
align-items:center;
}

/* LEFT SIDE */

.left{
flex:1;
background:white;
padding:35px;
border-radius:10px;
box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

.left h2{
color:#6b0f1a;
margin-bottom:10px;
}

.left p{
font-size:14px;
margin-bottom:15px;
color:#555;
}

/* FORM */

form label{
font-weight:600;
font-size:14px;
color:#333;
}

.radio-group{
margin:10px 0 20px 0;
display:flex;
gap:20px;
}

.radio-group label{
font-weight:500;
cursor:pointer;
}

form input,
form textarea{
width:100%;
padding:12px;
margin-bottom:15px;
border-radius:6px;
border:1px solid #ddd;
font-size:14px;
transition:0.3s;
}

form input:focus,
form textarea:focus{
outline:none;
border-color:#bfa046;
box-shadow:0 0 4px rgba(191,160,70,0.4);
}

/* BUTTON */

button{
background:#6b0f1a;
color:white;
padding:12px 22px;
border:none;
border-radius:6px;
font-size:15px;
cursor:pointer;
transition:0.3s;
}

button:hover{
background:#bfa046;
color:#fff;
}

/* RIGHT IMAGE */

.right{
flex:1;
}

.right img{
width:100%;
border-radius:12px;
box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

/* CONTACT INFO */

.contact-info{
margin-top:60px;
display:flex;
justify-content:space-between;
gap:30px;
}

.contact-box{
flex:1;
background:white;
padding:25px;
border-radius:10px;
box-shadow:0 8px 18px rgba(0,0,0,0.08);
}

.contact-box h3{
color:#6b0f1a;
margin-bottom:10px;
}

.contact-box p{
font-size:14px;
color:#444;
line-height:1.6;
}

.email{
color:#bfa046;
font-weight:600;
}

</style>
</head>

<body>

<header>
    <div class="header-container">
        
        <div class="logo-title">
            <img src="../assets/logo.jpg" alt="Alpha Aquila Logo" class="logo">
            <h1>ALPHA AQUILA</h1>
        </div>

        <nav class="top-nav">
            <ul>
                <li><a href="#">Home</a></li>

                <li class="dropdown">
                    <a href="#">Work with Us</a>
                    <ul class="dropdown-menu">
                        <li><a href="#" id="salesLink">Sales</a></li>
                        <li><a href="#" id="careerLink">Career</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#">Claim and Services</a>
                    <ul class="dropdown-menu">
                        <li><a href="#">PRUServices</a></li>
                        <li><a href="#">Make a Request</a></li>
                        <li><a href="#">Claims</a></li>
                        <li><a href="#">Policy Services Information</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#" id="contactsLink" >Contact Us</a>
                    
                </li>

            </ul>
        </nav>

    </div>
</header>


<div class="header">Contact Us</div>

<div class="container">

<?php if($message != ""){ ?>
<div class="success"><?php echo $message; ?></div>
<?php } ?>

<div class="contact-wrapper">

<div class="left">

<h2>We'd love to hear from you</h2>
<p>Thank you for reaching out to us. Our team is ready to assist you.</p>

<form method="POST">

<label>Are you a Pru Life UK policyowner? *</label>

<div class="radio-group">
<label><input type="radio" name="policyowner" value="Yes"> Yes</label>
<label><input type="radio" name="policyowner" value="No"> No</label>
</div>

<input type="text" name="name" placeholder="Your Name" required>

<input type="email" name="email" placeholder="Your Email" required>

<textarea name="message" placeholder="Your Message" rows="5"></textarea>

<button type="submit">Send Message</button>

</form>

</div>

<div class="right">
<img src="../assets/contact.jpg" alt="meeting">
</div>

</div>

<div class="contact-info">

<div class="contact-box">
<h3>Phone</h3>
<p>
PLDT Metro Manila<br>
+63 (2) 8887 5433
</p>

<p>
Domestic Toll-free<br>
1 800 10 PRULINK<br>
(1 800 10 7785465)
</p>

<p>
Globe Metro Manila<br>
+63 (2) 7793-5433
</p>
</div>

<div class="contact-box">
<h3>Email Address</h3>
<p class="email">contact.us@prulifeuk.com.ph</p>
</div>

<div class="contact-box">
<h3>Address</h3>
<p>
Black Orcas Summit Life Insurance Agency<br>
Unit 2004, 20th Floor<br>
Antel Global Corporate Center<br>
Julia Vargas Avenue, Ortigas Center<br>
Brgy. San Antonio, Pasig City
</p>
</div>

</div>

</div>

</body>
</html>