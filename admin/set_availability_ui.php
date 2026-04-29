<?php
include_once "../php/session.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: admin_login.php");
    exit;
}

$user_name = "Levi De Guzman";
$user_role = "Junior Unit Manager";
$initials = strtoupper(substr($user_name, 0, 1)) .
            strtoupper(substr(strrchr($user_name, " "), 1, 1));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Set Availability</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/set_availability.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Ensure SweetAlert2 appears above Bootstrap modals/backdrops */
        .swal2-container {
            z-index: 20000 !important;
        }
    </style>
</head>
<body>

<?php include_once "../components/admin_header.php"; ?>

<!-- Tabs -->
<ul class="nav nav-tabs justify-content-center mb-4 availability-tabs" id="calendarTabs" role="tablist" aria-label="Availability type">
    <li class="nav-item">
        <button class="nav-link active" data-type="client" type="button" role="tab" aria-selected="true">Client</button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-type="applicant" type="button" role="tab" aria-selected="false">Applicant</button>
    </li>
</ul>

<!-- SINGLE CALENDAR CONTAINER -->
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

        <!-- NEW: Meeting Link -->
        <label>Meeting Link</label>
        <input type="text" id="meetingLink" placeholder="Paste your meeting link here">

        <button id="saveAvailability">Save Availability</button>
        <div id="savedTimes"></div>
    </div>
</div>


<script src="../js/set_availability.js" type="module"></script>
</body>
</html>