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
   (Replace later with DB queries)
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

/* Avatar Initials */
$initials = strtoupper(substr($user_name, 0, 1)) .
            strtoupper(substr(strrchr($user_name, " "), 1, 1));
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Dashboard</title>

<link rel="stylesheet" href="../style/dashboard.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

<!-- ==============================
HEADER
================================-->
<?php include "../components/header.php"; ?>


<!-- ==============================
MAIN CONTENT
================================-->
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
            <h1 id="applicantCount"><?= $stats['applicants'] ?></h1>
        </div>

        <div class="stat-box">
            <span class="material-icons stat-icon">person</span>
            <p>No. of Clients</p>
            <h1 id="clientCount"><?= $stats['clients'] ?></h1>
        </div>

        <div class="stat-box">
            <span class="material-icons stat-icon">event</span>
            <p>Upcoming Events</p>
            <h1 id="eventCount"><?= $stats['events'] ?></h1>
        </div>

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

    <!-- Calendar -->
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

    <!-- Appointments -->
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


<!-- ==============================
SCRIPTS
================================-->
<script src="../js/dashboard.js"></script>

<script>
document.getElementById("logout").addEventListener("click", function(e) {

    e.preventDefault();

    fetch("../php/logout.php", {
        method: "POST"
    })
    .then(response => response.json())
    .then(data => {

        if (data.success) {
            window.location.href = "admin_login.php";
        } else {
            alert("Logout failed.");
        }

    })
    .catch(() => {
        alert("An error occurred during logout.");
    });

});
</script>

</body>
</html>