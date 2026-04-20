<?php

include_once "../php/session.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: admin_login.php");
    exit;
}

$user_data = array(
    "user_id" => 1,
    "user_name" => "Levi De Guzman",
    "user_role" => "Junior Unit Manager"
);

$user_name = $user_data['user_name'];
$user_role = $user_data['user_role'];
$initials = strtoupper(substr($user_name, 0, 1)) .
            strtoupper(substr(strrchr($user_name, " "), 1, 1));

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="../style/settings.css">
<title>Settings</title>
</head>
<body>

<!-- HEADER -->
<?php include "../components/admin_header.php"; ?>

<div class="container">

    <!-- NOTIFICATION SETTINGS -->
    <div class="card">
        <h2> Notification Settings</h2>

        <div class="setting-item">
            <label>New Inquiries</label>
            <div class="toggle" onclick="toggle(this)"></div>
        </div>

        <div class="setting-item">
            <label>New Appointments</label>
            <div class="toggle active" onclick="toggle(this)"></div>
        </div>

        <div class="setting-item">
            <label>Status Updates</label>
            <div class="toggle active" onclick="toggle(this)"></div>
        </div>

        <div class="setting-item">
            <label>Sound</label>
            <div class="toggle" onclick="toggle(this)"></div>
        </div>
    </div>

    <!-- DASHBOARD SETTINGS -->
    <div class="card">
        <h2> Dashboard Preferences</h2>

        <div class="setting-item">
            <label>Default Filter</label>
            <select>
                <option>Today</option>
                <option>All</option>
                <option>Upcoming</option>
            </select>
        </div>

        <div class="setting-item">
            <label>Auto Refresh</label>
            <div class="toggle active" onclick="toggle(this)"></div>
        </div>

        <div class="setting-item">
            <label>Show Type</label>
            <select>
                <option>All</option>
                <option>Career Only</option>
                <option>Sales Only</option>
            </select>
        </div>
    </div>

    <!-- UI SETTINGS -->
    <div class="card">
        <h2> UI Settings</h2>

        <div class="setting-item">
            <label>Dark Mode</label>
            <div class="toggle" onclick="toggle(this)"></div>
        </div>

        <div class="setting-item">
            <label>Theme Color</label>
            <select>
                <option>Maroon</option>
                <option>Blue</option>
                <option>Green</option>
            </select>
        </div>
    </div>

    

</div>

<script>

const profile = document.getElementById("profileToggle");

if (profile) {
    profile.addEventListener("click", function () {
        this.classList.toggle("active");
    });

    document.addEventListener("click", function (e) {
        if (!profile.contains(e.target)) {
            profile.classList.remove("active");
        }
    });
}

function toggle(el) {
    el.classList.toggle("active");

    // simulate auto-save (no button needed)
    console.log("Setting updated:", el.previousElementSibling?.innerText || "toggle");
}

// auto-save for select and inputs
document.querySelectorAll("select, input").forEach(el => {
    el.addEventListener("change", () => {
        console.log("Setting updated:", el.previousElementSibling?.innerText || el.value);
    });
});
</script>

</body>
</html>
