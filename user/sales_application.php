SALES FORM

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Alpha Aquila Sales Appointment</title>

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


/* ================= FORM CONTAINER ================= */
.container{
    max-width:1000px;
    margin:40px auto;
    background:white;
    padding:40px;
    border-radius:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

/* ================= SECTION TITLES ================= */
.section-title{
    font-size:22px;
    font-weight:bold;
    margin-bottom:20px;
    color:#880318;
}

/* ================= INPUTS ================= */
.form-row{
    display:flex;
    gap:20px;
    margin-bottom:20px;
    flex-wrap:wrap;
}

.input-group{
    flex:1;
    display:flex;
    flex-direction:column;
}

input{
    padding:12px;
    border-radius:10px;
    border:1px solid #ccc;
    font-size:14px;
}

/* ================= PRIORITIES ================= */
.priority-list{
    display:flex;
    flex-direction:column;
    gap:10px;
}

.priority-list label{
    cursor:pointer;
}

/* ================= CALENDAR ================= */
.calendar-container{
    margin-top:20px;
}

.calendar-header{
    text-align:center;
    margin-bottom:15px;
    font-size:20px;
    font-weight:bold;
    color:#880318;
}

.calendar-days{
    display:grid;
    grid-template-columns:repeat(7,1fr);
    background:#880318;
    color:white;
    text-align:center;
    padding:10px 0;
    border-radius:8px;
    font-weight:bold;
}

.calendar-dates{
    display:grid;
    grid-template-columns:repeat(7,1fr);
    gap:10px;
    margin-top:15px;
}

.calendar-btn{
    padding:12px 0;
    border:none;
    border-radius:8px;
    background:#e2e0e0;
    cursor:pointer;
}

.calendar-btn:hover{
    background:#d6d6d6;
}

.calendar-btn.active{
    background:#880318;
    color:white;
}

/* ================= BUTTONS ================= */
.actions{
    display:flex;
    justify-content:flex-end;
    gap:20px;
    margin-top:30px;
}

.btn{
    padding:12px 30px;
    border-radius:30px;
    border:none;
    font-size:14px;
    cursor:pointer;
}

.btn-cancel{
    background:#ccc;
}

.btn-submit{
    background:#880318;
    color:white;
}

.btn-submit:hover{
    opacity:0.9;
}

/* ================= RESPONSIVE ================= */
@media(max-width:768px){
    .form-row{
        flex-direction:column;
    }
}

/* ================= MODAL ================= */

.modal-overlay{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.4);
    display:flex;
    justify-content:center;
    align-items:center;
    z-index:9999;
}

.modal-box{
    background:white;
    width:420px;
    padding:30px;
    border-radius:16px;
    border:3px solid #3b82f6;
    position:relative;
}

.modal-box h3{
    margin-bottom:10px;
}

.modal-box h4{
    margin-top:15px;
    margin-bottom:5px;
}

.modal-box ul{
    padding-left:18px;
}

.modal-box li{
    font-size:14px;
    margin-bottom:4px;
}

.close-btn{
    position:absolute;
    top:10px;
    right:15px;
    font-size:20px;
    cursor:pointer;
}

.apply-btn{
    margin-top:20px;
    width:100%;
    padding:10px;
    border:none;
    border-radius:20px;
    background:#880318;
    color:white;
    font-weight:600;
    cursor:pointer;
}

.apply-btn:hover{
    opacity:0.9;
}



</style>
</head>
<body>

<!-- ================= HEADER ================= -->
<header>
    <div class="header-container">
        
        <div class="logo-title">
            <img src="../assets/logo.jpg" alt="Alpha Aquila Logo" class="logo">
            <h1>ALPHA AQUILA</h1>
        </div>

        <nav class="top-nav">
            <ul>
                <li><a href="../index.php">Home</a></li>

                <li class="dropdown">
                    <a href="#">Work with Us</a>
                    <ul class="dropdown-menu">
                        <li><a href="#" id="salesLink">Sales</a></li>
                        <li><a href="#" id="careerLink">Career</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#">Claim and Services</a>
                </li>

                <li class="dropdown">
                    <a href="#">Contact Us</a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Phone</a></li>
                        <li><a href="#">Email Address</a></li>
                        <li><a href="#">Address</a></li>
                    </ul>
                </li>

            </ul>
        </nav>

    </div>
</header>


<!-- ================= APPLICATION MODAL ================= -->
<div class="modal-overlay" id="applyModal">

    <div class="modal-box">

        <span class="close-btn" id="closeModal">&times;</span>

        <h3>Welcome, Applicants!</h3>

        <p>
        Take the next step toward a rewarding and flexible career opportunity. 
        Check the qualifications and exciting benefits below:
        </p>

        <h4>Qualifications</h4>
        <ul>
            <li>Not more than 45 years old</li>
            <li>At least Fourth Year Graduate</li>
            <li>Open to applicants nationwide</li>
            <li>Willing to learn and grow</li>
        </ul>

        <h4>Perks and Benefits</h4>
        <ul>
            <li>Fun and supportive work culture</li>
            <li>45% commission-based income</li>
            <li>HMO coverage</li>
            <li>Opportunity to build your own business</li>
            <li>Chance to lead a team in the future</li>
            <li>Potential monthly income of ₱30,000–₱50,000+</li>
            <li>Qualification for local and international travel incentives</li>
        </ul>

        <button class="apply-btn" id="applyNow">Apply</button>

    </div>

</div>

<!-- ================= FORM ================= -->
<div class="container">

    <!-- STEP 1 -->
    <div class="section-title">Step 1: Personal Information</div>

    <div class="form-row">
        <div class="input-group">
            <label>First Name</label>
            <input type="text" placeholder="First Name">
        </div>
        <div class="input-group">
            <label>Last Name</label>
            <input type="text" placeholder="Last Name">
        </div>
        <div class="input-group">
            <label>Middle Name</label>
            <input type="text" placeholder="Middle Name">
        </div>
    </div>

    <div class="form-row">
        <div class="input-group">
            <label>Email</label>
            <input type="email" placeholder="@email.com">
        </div>
        <div class="input-group">
            <label>Phone</label>
            <input type="text" placeholder="Phone Number">
        </div>
    </div>

    <!-- STEP 2 -->
    <div class="section-title">Step 2: Choose Top 3 Priorities</div>

    <div class="priority-list">
        <label><input type="checkbox"> Protection</label>
        <label><input type="checkbox"> Education</label>
        <label><input type="checkbox"> Retirement</label>
        <label><input type="checkbox"> Medium to Long Term Goals</label>
        <label><input type="checkbox"> Critical Illness Fund</label>
        <label><input type="checkbox"> Estate Conservation</label>
    </div>

    <!-- STEP 3 -->
    <div class="section-title">Step 3: Schedule Appointment</div>

    <div class="calendar-container">

        <div class="calendar-header">FEBRUARY 2026</div>

        <div class="calendar-days">
            <div>SUN</div><div>MON</div><div>TUE</div>
            <div>WED</div><div>THU</div><div>FRI</div><div>SAT</div>
        </div>

        <div class="calendar-dates">
            <!-- 28 Days -->
            <script>
                for(let i=1;i<=28;i++){
                    document.write(`<button class="calendar-btn">${i}</button>`)
                }
            </script>
        </div>

    </div>

    <div class="actions">
        <button class="btn btn-cancel">Cancel</button>
        <button class="btn btn-submit">Submit</button>
    </div>

</div>

<!-- ================= JS ================= -->
<script>
const buttons = document.querySelectorAll(".calendar-btn");

buttons.forEach(btn=>{
    btn.addEventListener("click",()=>{
        buttons.forEach(b=>b.classList.remove("active"));
        btn.classList.add("active");
    });
});

const modal = document.getElementById("applyModal");
const applyBtn = document.getElementById("applyNow");
const closeBtn = document.getElementById("closeModal");
const form = document.getElementById("applicationForm");

// Apply button
applyBtn.addEventListener("click", () => {
    modal.style.display = "none";
    form.style.display = "block";
});

// Close modal
closeBtn.addEventListener("click", () => {
    modal.style.display = "none";
});
</script>

</body>
</html>