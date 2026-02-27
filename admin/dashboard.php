<?php
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
    <title>Dashboard</title>
    <link rel="stylesheet" href="../style/dashboard.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <a href="#" class="nav-link active">Home</a>
            <a href="#" class="nav-link">Insurance Inquiries</a>
            <a href="#" class="nav-link">Set Availability</a>
            <a href="#" class="nav-link">Appointment List</a>
            <a href="#" class="nav-link">Applicant List</a>
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
                    <a href="#">Logout</a>
                </div>
            </div>
        </div>
    </div>

</div>
</header>

<div class="container">

    <div class="left">

        <!-- OVERVIEW -->
        <div class="card overview">
            <div class="overview-header">
                <h3>Insurance and Appointment Activity Overview</h3>

                <!-- Calendar Filter -->
                <div class="filter-calendar">
                    <span class="material-icons">calendar_month</span>
                    <input type="date" id="overviewDate" hidden>
                </div>
            </div>

            <div class="stats">
                <div class="stat-box">
                    <span class="material-icons stat-icon">groups</span>
                    <p>No. of Applicants</p>
                    <h1><?php echo $applicants; ?></h1>
                </div>

                <div class="stat-box">
                    <span class="material-icons stat-icon">person</span>
                    <p>No. of Clients</p>
                    <h1><?php echo $clients; ?></h1>
                </div>

                <div class="stat-box">
                    <span class="material-icons stat-icon">event</span>
                    <p>Upcoming Events</p>
                    <h1><?php echo $events; ?></h1>
                </div>
            </div>
        </div>

        <!-- PRIORITIES + PAST JOB -->
        <div class="chart-row">
            <div class="card equal-card">
                <h3>Priorities</h3>
                <div class="pie"></div>
            </div>

            <div class="card equal-card">
                <h3>Past Job</h3>
                <div class="bars">
                    <div class="bar red"></div>
                    <div class="bar blue"></div>
                    <div class="bar teal"></div>
                    <div class="bar orange"></div>
                    <div class="bar yellow"></div>
                </div>
            </div>
        </div>

        <!-- LINE GRAPH -->
        <div class="card">
            <h3>Line</h3>
            <canvas id="lineChart"></canvas>
        </div>

    </div>

    <!-- RIGHT SIDE -->
    <div class="right">

        <div class="card schedule-card">

            <div class="calendar-header">
                <h3>Schedule</h3>
                <a href="#" class="see-all">See All</a>
            </div>

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

            <div class="appointments">
                <h4 id="selectedDate">February 16, 2026</h4>

                <div class="meeting">9:00 AM - 11:00 AM | 1st Client Meeting</div>
                <div class="meeting">1:00 PM - 2:00 PM | 2nd Client Meeting</div>
                <div class="meeting">3:00 PM - 4:00 PM | 3rd Client Meeting</div>
                <div class="meeting">4:30 PM - 5:30 PM | 4th Client Meeting</div>
                <div class="meeting">6:00 PM - 7:00 PM | 5th Client Meeting</div>
            </div>

        </div>

    </div>

</div>

<script src="../js/dashboard.js"></script>
</body>
</html>