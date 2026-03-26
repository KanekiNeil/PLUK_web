<?php
$_GET['type'] = 'client';
$availableDates = include '../php/get_available_dates.php';
$priorities = include '../php/get_priorities.php';

$fullDates = [
    "2026-03-02",
];
?>

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
.calendar-btn.available{
    background:#d1e7dd;
}

/* Fully booked */
.calendar-btn.full{
    background:#f8d7da;
    cursor:not-allowed;
}

.calendar-nav{
    text-align:center;
    margin-bottom:10px;
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
                    <a href="../user/services.php">Claim and Services</a>
                </li>

                <li >
                    <a href="../user/contactus.php">Contact Us</a>
                    
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

    <form id="applicationForm">

    <!-- STEP 1 -->
    <div class="section-title">Step 1: Personal Information</div>

    <div class="form-row">
        <div class="input-group">
            <label>First Name</label>
            <input type="text" name="first_name" placeholder="First Name">
        </div>
        <div class="input-group">
            <label>Last Name</label>
            <input type="text" name="last_name" placeholder="Last Name">
        </div>
        <div class="input-group">
            <label>Middle Name</label>
            <input type="text" name="middle_name" placeholder="Middle Name">
        </div>
    </div>

    <div class="form-row">
        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="@email.com">
        </div>
        <div class="input-group">
            <label>Phone</label>
            <input type="text" name="phone" placeholder="Phone Number">
        </div>
    </div>

    <!-- STEP 2 -->
    <div class="section-title">Step 2: Choose Top 3 Priorities</div>

    <div id="priorityWarning" style="color: #d32f2f; font-weight: bold; margin-bottom: 10px; display: none;">
        You can select a maximum of 3 priorities.
    </div>

    <div class="priority-list" id="priorityList">
        <?php 
        if (empty($priorities)) {
            $priorities = [
                ['id' => 1, 'name' => 'Protection'],
                ['id' => 2, 'name' => 'Education'],
                ['id' => 3, 'name' => 'Retirement'],
                ['id' => 4, 'name' => 'Medium to Long Term Goals'],
                ['id' => 5, 'name' => 'Critical Illness Fund'],
                ['id' => 6, 'name' => 'Estate Conservation']
            ];
        }
        ?>
        <?php foreach ($priorities as $priority): ?>
        <label>
            <input type="checkbox" name="priority_id" value="<?php echo $priority['id']; ?>" data-priority-id="<?php echo $priority['id']; ?>">
            <?php echo htmlspecialchars($priority['name']); ?>
        </label>
        <?php endforeach; ?>
    </div>

    <input type="hidden" name="selected_priorities" id="selectedPriorities" value="">

    <!-- STEP 3 -->
    <div class="section-title">Step 3: Schedule Appointment</div>

        <div class="calendar-container">
            <div class="calendar-header" id="calendarHeader"></div>
            <div class="calendar-nav">
                <button type="button" id="toggleMonthBtn" class="btn btn-outline-secondary btn-sm" style="display:none;"> </button>
            </div>

            <div class="calendar-days">
                <div>SUN</div><div>MON</div><div>TUE</div>
                <div>WED</div><div>THU</div><div>FRI</div><div>SAT</div>
            </div>

            <div class="calendar-dates" id="calendarDates"></div>

        </div>

    <input type="hidden" name="appointment_date" id="appointmentDate">
    <input type="hidden" name="application_type" value="sales">

    <div class="actions">
        <button type="button" class="btn btn-cancel">Cancel</button>
        <button type="submit" class="btn btn-submit">Submit</button>
    </div>

    </form>

</div>

<!-- ================= JS ================= -->
<script>


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

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const availableDates = <?php echo json_encode($availableDates); ?>;
    const fullDates = <?php echo json_encode($fullDates); ?>;

    // Priority selection logic
    const priorityCheckboxes = document.querySelectorAll('input[name="priority_id"]');
    const selectedPrioritiesInput = document.getElementById("selectedPriorities");
    const priorityWarning = document.getElementById("priorityWarning");

    function updateSelectedPriorities() {
        const checked = Array.from(priorityCheckboxes).filter(cb => cb.checked);
        const ids = checked.map(cb => cb.value);
        selectedPrioritiesInput.value = ids.join(',');
    }

    priorityCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checked = Array.from(priorityCheckboxes).filter(cb => cb.checked);
            
            if (checked.length > 3) {
                this.checked = false;
                priorityWarning.style.display = 'block';
                updateSelectedPriorities();
                return;
            }
            
            priorityWarning.style.display = checked.length === 3 ? 'block' : 'none';
            updateSelectedPriorities();
        });
    });

    const calendarDates = document.getElementById("calendarDates");
    const header = document.getElementById("calendarHeader");
    const toggleMonthBtn = document.getElementById("toggleMonthBtn");
    const appointmentInput = document.getElementById("appointmentDate");

    let selectedBtn = null;
    const today = new Date();

    function isLastWeekOfCurrentMonth(date) {
        const year = date.getFullYear();
        const month = date.getMonth();
        const lastDay = new Date(year, month + 1, 0).getDate();
        return date.getDate() > (lastDay - 7);
    }

    const canViewNextMonth = isLastWeekOfCurrentMonth(today);
    let monthOffset = 0;

    if (canViewNextMonth && toggleMonthBtn) {
        toggleMonthBtn.style.display = "inline-block";
    }

    function renderCalendar() {
        const displayDate = new Date(today.getFullYear(), today.getMonth() + monthOffset, 1);
        const month = displayDate.getMonth() + 1;
        const year = displayDate.getFullYear();

        const firstDay = new Date(year, month - 1, 1).getDay();
        const totalDays = new Date(year, month, 0).getDate();

        const monthNames = [
            "January","February","March","April","May","June",
            "July","August","September","October","November","December"
        ];

        header.textContent = `${monthNames[month-1]} ${year}`;
        if (toggleMonthBtn) {
            toggleMonthBtn.textContent = monthOffset === 0 ? "Show Next Month" : "Show Current Month";
        }

        calendarDates.innerHTML = "";
        selectedBtn = null;
        if (appointmentInput) appointmentInput.value = "";

        for (let i = 0; i < firstDay; i++) {
            calendarDates.appendChild(document.createElement("div"));
        }

        for (let day = 1; day <= totalDays; day++) {

            const btn = document.createElement("button");
            btn.className = "calendar-btn";
            btn.type = "button";
            btn.textContent = day;

            const dateStr =
                `${year}-${String(month).padStart(2,"0")}-${String(day).padStart(2,"0")}`;
            const cellDate = new Date(year, month - 1, day);
            const todayStart = new Date(today.getFullYear(), today.getMonth(), today.getDate());
            const isPastDate = cellDate < todayStart;

            if (availableDates.includes(dateStr)) {

                btn.classList.add("available");

            } else {

                btn.classList.add("unavailable");
                btn.disabled = true;

            }

            if (fullDates.includes(dateStr)) {

                btn.classList.remove("available");
                btn.classList.add("full");
                btn.disabled = true;

            }

            if (isPastDate) {
                btn.classList.remove("available");
                btn.classList.add("unavailable");
                btn.disabled = true;
            }

            btn.addEventListener("click", () => {

                if (selectedBtn) {
                    selectedBtn.classList.remove("active");
                }

                btn.classList.add("active");
                selectedBtn = btn;

                if (appointmentInput) appointmentInput.value = dateStr;

                alert("Selected Date: " + dateStr);
            });

            calendarDates.appendChild(btn);
        }
    }

    if (toggleMonthBtn) {
        toggleMonthBtn.addEventListener("click", () => {
            if (!canViewNextMonth) return;
            monthOffset = monthOffset === 0 ? 1 : 0;
            renderCalendar();
        });
    }

    renderCalendar();

        const form = document.getElementById("applicationForm");

    if (form) {

        form.addEventListener("submit", async (e) => {

            e.preventDefault();

            if (form.dataset.submitting === "true") return;

            const appointmentDate = appointmentInput.value;
            const selectedPriorities = selectedPrioritiesInput.value;

            if (!appointmentDate) {
                alert("Please select an appointment date.");
                return;
            }

            if (!selectedPriorities) {
                alert("Please select at least one priority.");
                return;
            }

            const submitBtn = form.querySelector("button[type='submit']");
            submitBtn.disabled = true;

            form.dataset.submitting = "true";

            try {

                const formData = new FormData(form);

                const response = await fetch("../php/submit_application.php", {
                    method: "POST",
                    body: formData
                });

                const data = await response.json();

                if (data.status === "success") {

                    alert(data.message);

                    form.reset();
                    appointmentInput.value = "";

                } else {
                    alert("Error: " + data.message);
                }

            } catch (err) {

                console.error(err);
                alert("Something went wrong. Please try again.");

            }

            submitBtn.disabled = false;
            form.dataset.submitting = "false";

        });

    }
    });
</script>

</body>
</html>