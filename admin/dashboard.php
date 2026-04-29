<?php
include_once "../php/session.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: admin_login.php");
    exit();
}

/* ==============================
   AUTHENTICATION CHECK
================================*/


/* ==============================
   SAMPLE DASHBOARD DATA
================================*/


$stats = [
    "applicants" => 10,
    "clients" => 12,
    "events" => 32
];


/* ==============================
   USER INFO
================================*/
$user_name = "Levi De Guzman";
$user_role = "Junior Unit Manager";

$initials = strtoupper(substr($user_name, 0, 1)) .
            strtoupper(substr(strrchr($user_name, " "), 1, 1));
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="../style/dashboard.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- ================= ANNOUNCEMENT STYLE ================= -->
<style>
.fab {
    position: fixed;
    bottom: 25px;
    right: 25px;
    width: 65px;
    height: 65px;
    background: #800000;
    color: #fff;
    border-radius: 50%;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    cursor: pointer;
    box-shadow: 0 5px 12px rgba(0,0,0,0.3);
    z-index: 999;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(0,0,0,0.5);
}

.modal-content {
    background: #fff;
    width: 420px;
    margin: 80px auto;
    padding: 20px;
    border-radius: 12px;
    max-height: 80vh;
    overflow-y: auto;
}

.modal-header {
    display: flex;
    justify-content: space-between;
}

.close {
    cursor: pointer;
    font-size: 24px;
}

#announcementInput {
    width: 100%;
    height: 90px;
    margin-top: 15px;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

.modal-actions {
    margin-top: 10px;
    text-align: right;
}

.modal-actions button {
    background: #800000;
    color: #fff;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
}

.announcement-item {
    background: #f5f5f5;
    padding: 12px;
    margin-top: 10px;
    border-radius: 8px;
    position: relative;
}

.edit-btn {
    position: absolute;
    right: 10px;
    top: 10px;
    cursor: pointer;
    color: #800000;
}
</style>

</head>

<body>

<?php include "../components/admin_header.php"; ?>

<div class="container">

<!-- LEFT SIDE -->
<div class="left">

<!-- OVERVIEW CARD -->
<div class="card overview">

    <div class="overview-header">
        <h3>Insurance and Appointment Activity Overview</h3>

        <div class="filter-calendar">
            <span class="material-icons">calendar_month</span>
            <input type="date" id="overviewDate">
        </div>
    </div>

    <div class="stats">

        <div class="stat-box">
            <span class="material-icons stat-icon">groups</span>

            <p>No. of Applicants</p>
            <h1 id="applicantCount">0</h1>
        </div>

        <div class="stat-box">
            <span class="material-icons stat-icon">person</span>
            <p>No. of Clients</p>
            <h1 id="clientCount">0</h1>
        </div>

        <div class="stat-box">
            <span class="material-icons stat-icon">event</span>
            <p>Upcoming Meetings</p>
            <h1 id="meetingCount">0</h1>
        </div>

    </div>
</div>

<!-- EXPORT APPLICANTS CARD -->
<div class="export-card">
    <div class="export-header">
        <span class="material-icons">file_download</span>
        <h3>Export Applicants</h3>
    </div>

    <div class="export-container">
        <div class="export-input-group">
            <label for="startDate">From Date:</label>
            <input type="date" id="startDate">
        </div>

        <div class="export-input-group">
            <label for="endDate">To Date:</label>
            <input type="date" id="endDate">
        </div>

        <button class="export-btn" onclick="exportApplicantsExcel()">
            <span class="material-icons">download</span>
            Export Excel
        </button>
    </div>
</div>

<!-- PRIORITIES + PAST JOB -->
<div class="chart-row">

    <div class="card equal-card">
        <h3>Priorities</h3>
        <div class="pie-wrapper">
            <div class="pie"></div>
            <div class="pie-legend"></div>
        </div>
    </div>

    <div class="card equal-card">
        <h3>Past Job</h3>

        <div class="bar-wrapper">
            <div class="bar-yaxis"></div>
            <div class="bars"></div>
        </div>

    </div>

</div>

<!-- LINE CHART -->
<div class="card line-chart-card">
    <h3>Line</h3>
    <canvas id="lineChart"></canvas>
</div>

</div>

<!-- RIGHT SIDE -->
<div class="right">

<div class="card schedule-card">

    <div class="calendar-header">
        <h3>Schedule</h3>
        <div class="schedule-actions">
            <select id="appointmentTypeFilter" class="schedule-type-filter">
                <option value="all">All Appointments</option>
                <option value="applicant">Applicant</option>
                <option value="sales">Sales</option>
            </select>
            <a href="#" class="see-all">See All</a>
        </div>
    </div>

    <div class="calendar-card">
        <div class="calendar">

        <div class="month">
            <button id="prev">&lt;</button>
            <span id="monthYear"></span>
            <button id="next">&gt;</button>
        </div>

        <div class="days">
            <span>Sun</span><span>Mon</span><span>Tue</span>
            <span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
        </div>

        <div class="dates" id="dates"></div>

        </div>
    </div>

    <div class="schedule-divider"></div>

    <div class="appointments">

        <h4 id="selectedDate">Select a date</h4>
        <div class="title-divider"></div>
        <div id="appointmentsList" class="appointments-list">
            <div class="meeting">Select a date to view appointments.</div>
        </div>

    </div>

</div>

</div>

</div>

<!-- ================= FLOATING BUTTON ================= -->
<button id="announcementBtn" class="fab">
    <span class="material-icons">article</span>
</button>

<!-- ================= MODAL ================= -->
<div id="announcementModal" class="modal">
<div class="modal-content">

    <div class="modal-header">
        <h2>Announcements</h2>
        <span id="closeModal" class="close">&times;</span>
    </div>

    <textarea id="announcementInput" placeholder="Write announcement..."></textarea>

    <div class="modal-actions">
        <button id="saveAnnouncement">Post</button>
    </div>

    <div id="announcementList"></div>

</div>
</div>

<!-- ================= SCRIPTS ================= -->

<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
<script src="../js/dashboard.js"></script>

<script>

/* LOGOUT */
document.getElementById("logout").addEventListener("click", function(e) {
    e.preventDefault();
    fetch("../php/logout.php", { method: "POST" })
    .then(res => res.json())
    .then(data => {
        if (data.success) window.location.href = "admin_login.php";
        else Swal.fire({ text: "Logout failed.", icon: 'error', confirmButtonText: 'OK' });
    });
});

/* ANNOUNCEMENTS */
const fab = document.getElementById("announcementBtn");
const modal = document.getElementById("announcementModal");
const closeModal = document.getElementById("closeModal");
const saveBtn = document.getElementById("saveAnnouncement");
const input = document.getElementById("announcementInput");
const list = document.getElementById("announcementList");

let announcements = [];
let editIndex = null;

fab.onclick = () => modal.style.display = "block";
closeModal.onclick = () => modal.style.display = "none";

saveBtn.onclick = () => {
    const text = input.value.trim();
    if (!text) return;

    if (editIndex !== null) {
        announcements[editIndex] = text;
        editIndex = null;
    } else {
        announcements.push(text);
    }

    input.value = "";
    renderAnnouncements();
};

function renderAnnouncements() {
    list.innerHTML = "";
    announcements.forEach((item, index) => {
        const div = document.createElement("div");
        div.className = "announcement-item";
        div.innerHTML = `
            ${item}
            <span class="material-icons edit-btn" onclick="editAnnouncement(${index})">edit</span>
        `;
        list.appendChild(div);
    });
}

function editAnnouncement(index) {
    input.value = announcements[index];
    editIndex = index;
}

window.onclick = (e) => {
    if (e.target == modal) modal.style.display = "none";
};

</script>

</body>
</html>