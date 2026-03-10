<?php
include_once "../php/session.php";


if (!isset($_SESSION['user_id'])) {
    // Not logged in
    header("Location: admin_login.php");
    exit;
}
$applicants = 10;
$clients = 12;
$events = 32;

$user_name = "Levi De Guzman";
$user_role = "Junior Unit Manager";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Set Availability</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../style/set_availability.css">
</head>
<body>
	<header>
<div class="header">

    <div class="logo-section">
        <img src="../assets/logo.jpg" class="logo">
        <h2 class="brand">ALPHA AQUILA</h2>
    </div>

    <div class="header-right">
        <nav class="nav">
            <a href="dashboard.php" class="nav-link"> Home </a>
            <a href="#" class="nav-link">Insurance Inquiries</a>
            <a href="set_availability_ui.php" class="nav-link active">Set Availability</a>
            <a href="appointment_list.php" class="nav-link">Appointment List</a>
            <a href="applicant_list.php" class="nav-link">Applicant List</a>
        </nav>

        <div class="user-section">
            <span class="material-icons notification-icon">notifications</span>

            <div class="profile-wrapper" id="profileToggle">
                <div class="user-info">
                    <strong><?php echo $user_name; ?></strong>
                    <small><?php echo $user_role; ?></small>
                </div>

                <div class="profile-avatar">LD</div>
                <span class="dropdown-arrow">▼</span>

                <div class="profile-dropdown">
                    <a href="#">Profile</a>
                    <a href="#">Settings</a>
                    <a href="#" id="logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

</div>
</header>

<div class="calendar-container">
    
    <div class="calendar-header">
        <button id="prevMonth">&#9664;</button>
        <h1 id="monthYear"></h1>
        <button id="nextMonth">&#9654;</button>
    </div>

    <div class="calendar-days">
        <div>Sun</div>
        <div>Mon</div>
        <div>Tue</div>
        <div>Wed</div>
        <div>Thu</div>
        <div>Fri</div>
        <div>Sat</div>
    </div>

    <div id="calendarDates" class="calendar-dates"></div>

</div>

<!-- AVAILABILITY MODAL -->
<div id="availabilityModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>

        <h2 id="modalDateTitle"></h2>

        <label>Start Time</label>
        <input type="time" id="startTime">

        <label>End Time</label>
        <input type="time" id="endTime">

        <button id="saveAvailability">Save Availability</button>

        <div id="savedTimes"></div>
    </div>
</div>

<script src="../js/set_availability.js"></script>
</body>
</html>