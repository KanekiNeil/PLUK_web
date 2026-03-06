<?php
include_once "../php/session.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: admin_login.php");
    exit;
}

$user_name = "Levi De Guzman";
$user_role = "Junior Unit Manager";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Appointment List</title>
<link rel="stylesheet" href="../style/appointment_list.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>

<!-- ================= HEADER ================= -->
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
            <a href="set_availability_ui.php" class="nav-link"> Set Availability </a>
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

<!-- ================= BACKGROUND WRAPPER ================= -->
<div class="appointment-wrapper">

    <div class="appointment-card">
        <table class="appointment-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Full Name</th>
                    <th>Appointment Type <span class="material-icons filter-icon">filter_list</span></th>
                    <th>Status <span class="material-icons filter-icon">filter_list</span></th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>02/16/26</td>
                    <td>7:00-8:00 AM</td>
                    <td>Juan De La Cruz</td>
                    <td>Career</td>
                    <td>
                        <div class="status-pill rescheduled">
                            Rescheduled
                            <span class="material-icons">arrow_drop_down</span>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>02/23/26</td>
                    <td>1:00-2:00 PM</td>
                    <td>Maria Santos</td>
                    <td>Career</td>
                    <td>
                        <div class="status-pill attended">
                            Attended BYB
                            <span class="material-icons">arrow_drop_down</span>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>02/27/26</td>
                    <td>3:00-4:00 PM</td>
                    <td>Rizal Doe</td>
                    <td>Sales</td>
                    <td>
                        <div class="status-pill processing">
                            Processing
                            <span class="material-icons">arrow_drop_down</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

<script>
const profile = document.getElementById("profileToggle");
profile.addEventListener("click", function () {
    this.classList.toggle("active");
});
document.addEventListener("click", function (e) {
    if (!profile.contains(e.target)) {
        profile.classList.remove("active");
    }
});
</script>

</body>
</html>