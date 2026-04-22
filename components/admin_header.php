<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<style>
    /* Flex container */
.header {
    display: flex;
    align-items: center;
    background: #ffffff;
    padding: 15px 40px;
    border-bottom: 1px solid #ddd;
    position: relative;
    z-index: 1000;
}

.header-right {
    margin-left: auto;   /* pushes nav + user to right */
    display: flex;
    align-items: center;
    gap: 40px;
}
/* ================= USER SECTION FIX ================= */
.user-section {
    display: flex;
    align-items: center;
    gap: 15px;
}

/* Notification Icon */
.notification-icon {
    font-size: 22px;
    cursor: pointer;
    color: #333;
    transition: 0.2s ease;
}

.notification-icon:hover {
    color: #8b0000;
}

/* ================= PROFILE WRAPPER ================= */
.profile-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    position: relative; /* IMPORTANT for dropdown positioning */
}

/* Profile Circle Icon */
.profile-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #1976d2;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 14px;
}



/* ================= LOGO SECTION ================= */
.logo-section {
    display: flex;
    align-items: center;
    gap: 10px;
}

.logo {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid #8b0000;
}

.brand {
    font-size: 14px;
    font-weight: 700;
}

/* ================= NAVIGATION ================= */
.nav {
    display: flex;
    align-items: center;
    gap: 50px;
}

.nav-link {
    text-decoration: none;
    color: #8b0000;
    font-weight: 600;
    font-size: 14px;
    padding: 10px 0;
    display: block;
    transition: 0.3s ease;
    cursor: pointer;
}

.nav-link:hover {
    opacity: 0.8;
}

.nav-link.active {
    border-bottom: 2px solid #8b0000;
}

/* ================= USER PROFILE (KEEPED AT RIGHT) ================= */
.user-info {
    display: flex;
    flex-direction: column;
    line-height: 1.2;
}

.user-info strong {
    font-size: 13px;
    font-weight: 600;
}

.user-info small {
    font-size: 12px;
    color: #666;
}

/* Dropdown Arrow */
.dropdown-arrow {
    font-size: 10px;
    color: #444;
}

/* ================= DROPDOWN MENU ================= */
.profile-dropdown {
    position: absolute;
    top: 55px;
    right: 0;
    width: 180px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    display: none;
    flex-direction: column;
    padding: 8px 0;
    z-index: 999;
}

/* Dropdown Links */
.profile-dropdown a {
    padding: 10px 15px;
    text-decoration: none;
    font-size: 13px;
    color: #333;
    transition: 0.2s ease;
}

.profile-dropdown a:hover {
    background: #f3f3f3;
    color: #8b0000;
}

/* Show dropdown when active */
.profile-wrapper.active .profile-dropdown {
    display: flex;
}

/* Notification Wrapper */
.notification-wrapper {
    position: relative;
}

/* Dropdown Card */
.notification-dropdown {
    position: absolute;
    top: 40px;
    right: 0;
    width: 260px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    padding: 15px;
    display: none;
    flex-direction: column;
    z-index: 999;
}

/* Title */
.notification-dropdown h4 {
    text-align: center;
    font-size: 14px;
    margin-bottom: 10px;
}

/* Notification Item */
.notif-item {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}

/* Time */
.notif-time {
    text-align: right;
    font-size: 11px;
    color: #777;
}

/* Empty lines */
.notif-empty {
    height: 20px;
    border-bottom: 1px solid #f0f0f0;
    margin: 5px 0;
}

/* View All Button */
.view-all-btn {
    margin-top: 10px;
    padding: 8px;
    border: none;
    border-radius: 6px;
    background: #e57373;
    color: white;
    font-size: 12px;
    cursor: pointer;
}

.view-all-btn:hover {
    background: #d32f2f;
}

/* Show dropdown */
.notification-wrapper.active .notification-dropdown {
    display: flex;
}

</style>
<?php $current_page = basename($_SERVER['PHP_SELF']); ?>
<header>
<div class="header">

    <div class="logo-section">
        <img src="../assets/logo.jpg" class="logo" alt="Alpha Aquila Logo">
        <h2 class="brand">ALPHA AQUILA</h2>
    </div>

    <div class="header-right">

        <!-- Navigation -->
        <nav class="nav">
            <a href="dashboard.php" class="nav-link <?= $current_page === 'dashboard.php' ? 'active' : '' ?>">Home</a>
            <a href="insurance_inquiries.php" class="nav-link <?= $current_page === 'insurance_inquiries.php' ? 'active' : '' ?>">Insurance Inquiries</a>
            <a href="set_availability_ui.php" class="nav-link <?= $current_page === 'set_availability_ui.php' ? 'active' : '' ?>"> Set Availability </a>
            <a href="appointment_list.php" class="nav-link <?= $current_page === 'appointment_list.php' ? 'active' : '' ?>">Appointment List</a>
            <a href="applicant_list.php" class="nav-link <?= $current_page === 'applicant_list.php' ? 'active' : '' ?>">Applicant List</a>
        </nav>

        <!-- User Section -->
        <div class="user-section">
            
            <div class="notification-wrapper" id="notifToggle">

            <span class="material-icons notification-icon">notifications</span>

            <!-- Notification Dropdown -->
            <div class="notification-dropdown">
                <h4>Notifications</h4>

                <div class="notif-item">
                    <div>
                        <strong>Career Meeting</strong><br>
                        <small>with Aislinn</small>
                    </div>
                    <span class="notif-time">5:00 pm<br><small>13/02/2025</small></span>
                </div>

                <!-- Empty placeholders -->
                <div class="notif-empty"></div>
                <div class="notif-empty"></div>
                <div class="notif-empty"></div>

                <button class="view-all-btn">View All</button>
            </div>

        </div>


            <div class="profile-wrapper" id="profileToggle">

                <div class="user-info">
                    <strong><?= htmlspecialchars($user_name) ?></strong>
                    <small><?= htmlspecialchars($user_role) ?></small>
                </div>

                <div class="profile-avatar">
                    <?= $initials ?>
                </div>

                <span class="dropdown-arrow">▼</span>

                <div class="profile-dropdown">
                    <a href="profile.php">Profile</a>
                    <a href="news_management.php">Announcement</a>
                    <a href="admin_login.php" id="logout">Logout</a>
                </div>

            </div>
        </div>

    </div>

</div>
</header>

<script>
const notifToggle = document.getElementById("notifToggle");

notifToggle.addEventListener("click", function (e) {
    e.stopPropagation();
    notifToggle.classList.toggle("active");
});

// Close when clicking outside
document.addEventListener("click", function () {
    notifToggle.classList.remove("active");
});
</script>