<style>
    /* Flex container */
.header {
    display: flex;
    align-items: center;
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
</style>
<header>
<div class="header">

    <div class="logo-section">
        <img src="../assets/logo.jpg" class="logo" alt="Alpha Aquila Logo">
        <h2 class="brand">ALPHA AQUILA</h2>
    </div>

    <div class="header-right">

        <!-- Navigation -->
        <nav class="nav">
            <a href="#" class="nav-link active">Home</a>
            <a href="#" class="nav-link">Insurance Inquiries</a>
            <a href="set_availability_ui.php" class="nav-link"> Set Availability </a>
            <a href="appointment_list.php" class="nav-link">Appointment List</a>
            <a href="applicant_list.php" class="nav-link">Applicant List</a>
        </nav>

        <!-- User Section -->
        <div class="user-section">

            <span class="material-icons notification-icon">notifications</span>

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
                    <a href="#">Profile</a>
                    <a href="#">Settings</a>
                    <a href="#" id="logout">Logout</a>
                </div>

            </div>
        </div>

    </div>

</div>
</header>