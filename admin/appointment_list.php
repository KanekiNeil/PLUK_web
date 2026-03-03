<?php
$appointments = [
    ["2026-02-16", "7:00-8:00 AM", "Juan Dela Cruz", "Career", "Rescheduled"],
    ["2026-02-23", "1:00-2:00 PM", "Maria Santos", "Career", "Attended BYB"],
    ["2026-02-27", "3:00-4:00 PM", "Rizal Doe", "Sales", "Processing"],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Appointment List</title>

<style>
body {
    margin: 0;
    font-family: system-ui;
    background-color: #f5f6fa;
    position: relative;
}

body::before {
    content: "";
    position: fixed;
    inset: 0;
    background-image: url("../assets/logo.jpg");
    background-repeat: no-repeat;
    background-position: center;
    background-size: 400px;
    opacity: 0.07; /* Makes it very light */
    z-index: -1;
}

/* HEADER */
.header {
    background: white;
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

/* LEFT SIDE (logo + text) */
.header-left {
    display: flex;
    align-items: center;
    gap: 12px; /* space between image and text */
}

.logo {
    font-size: 20px;
    font-weight: bold;
    color: #880318;
}

.burger {
    font-size: 26px;
    cursor: pointer;
    user-select: none;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 20px;
}

.admin-profile {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    font-weight: 500;
    position: relative;
}

.admin-img {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    object-fit: cover;
}

.dropdown {
    position: absolute;
    top: 50px;
    right: 0;
    background: white;
    border: 1.5px solid #880318;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    display: none;
    flex-direction: column;
    min-width: 150px;
    overflow: hidden;
}

.dropdown a {
    padding: 10px 15px;
    text-decoration: none;
    color: #333;
    transition: 0.2s;
}

.dropdown a:hover {
    background: #f0f0f0;
}

/* NAVBAR */
.navbar {
    background: #880318;
    color: white;
    display: none;
    flex-direction: row;
    justify-content: center;   /* centers items */
    align-items: center;
    gap: 30px;                 /* space between menu items */
    padding: 10px 25px;        /* smaller height */
    border-radius: 12px;       /* rounded corners */
    margin: 15px 30px;         /* spacing from header */
    animation: slideDown 0.3s ease;
}

.navbar a {
    color: white;
    text-decoration: none;
    padding: 6px 12px;         /* smaller clickable area */
    font-weight: 500;
    border-radius: 8px;        /* rounded each item */
    transition: 0.2s ease;
}

.navbar a:hover {
    opacity: 0.8;
	background: rgba(255, 255, 255, 0.15);
}

@keyframes slideDown {
    from {opacity: 0; transform: translateY(-10px);}
    to {opacity: 1; transform: translateY(0);}
}

/* MAIN CONTENT */
.container {
    padding: 40px;
}

.card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

/* TABLE */
.table-header,
.table-row {
    display: grid;
    grid-template-columns: 1fr 1fr 1.5fr 1.5fr 1fr;
    padding: 15px 10px;
    align-items: center;
}

.table-header {
    font-weight: bold;
    border-bottom: 2px solid #880318;
}

.table-row {
    border-bottom: 1px solid #eee;
    transition: 0.2s;
}

.table-row:hover {
    background: #d9d9d9;
}

/* STATUS */
.status {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    width: fit-content;
}

.status-rescheduled {
    background: #ffe0b2;
    color: #e65100;
}

.status-attended {
    background: #c8e6c9;
    color: #1b5e20;
}

.status-processing {
    background: #fff59d;
    color: #f57f17;
}

.status-default {
    background: #e0e0e0;
}

/* RESPONSIVE */
@media (max-width: 900px) {
    .table-header,
    .table-row {
        grid-template-columns: 1fr 1fr;
        row-gap: 10px;
    }
}

/* MODAL */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.4);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 999;
}

.modal {
    background: white;
    width: 400px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    animation: fadeIn 0.2s ease;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    border-bottom: 1px solid #eee;
}

.modal-content {
    padding: 20px;
}

.modal-content h2 {
    margin-top: 0;
}

.close-btn {
    cursor: pointer;
    font-size: 18px;
}

.appointment-box {
    background: #f8d7da;
    padding: 12px;
    border-radius: 8px;
    margin: 15px 0;
}

.details p {
    margin: 8px 0;
}

.close-modal-btn {
    background: #880318;
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 20px;
    cursor: pointer;
    margin-top: 15px;
}

.close-modal-btn:hover {
    opacity: 0.85;
}

@keyframes fadeIn {
    from { transform: scale(0.95); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

</style>
</head>
<body>

<!-- HEADER -->
<div class="header">

    <div class="header-left">
        <img src="../assets/logo.jpg" height="40">
        <div class="logo">Alpha Aquila</div>
    </div>
    <div class="header-right">
        <div class="admin-profile" onclick="toggleProfile()">
            <img src="../assets/admin.png" class="admin-img">
            <span>Levi De Guzman ▼</span>
                <div class="dropdown" id="profileDropdown">
                    <a href="#">
                        <span class="icon-wrapper">
                            <img src="../assets/    account.png">
                        </span>
                        <span>Account</span>
                    </a>

                    <a href="#">
                        <span class="icon-wrapper">
                            <img src="../assets/setting.png">
                        </span>
                        <span>Settings</span>
                    </a>

                    <a href="#">
                        <span class="icon-wrapper">
                            <img src="../assets/logout.png">
                        </span>
                        <span>Logout</span>
                    </a>
                </div>
        </div>
        <div class="burger" onclick="toggleMenu()">☰</div>
    </div>
</div>
<!-- NAVBAR (Hidden by default) -->
<div class="navbar" id="navbar">
    <a href="#">Home</a>
    <a href="#">Insurance Inquiries</a>
    <a href="#">Set Availability</a>
    <a href="#"><strong>Appointment List</strong></a>
    <a href="#">Applicant List</a>
</div>

<!-- CONTENT -->
<div class="container">
    <div class="card">

        <div class="table-header">
            <div>Date</div>
            <div>Time</div>
            <div>Full Name</div>
            <div>Appointment Type</div>
            <div>Status</div>
        </div>

        <?php foreach ($appointments as $appt): 
            $statusClass = match(true) {
                str_contains($appt[4], "Rescheduled") => "status-rescheduled",
                str_contains($appt[4], "Attended") => "status-attended",
                str_contains($appt[4], "Processing") => "status-processing",
                default => "status-default"
            };
        ?>

        <div class="table-row"
            onclick="openModal(
                '<?= date("F d, Y", strtotime($appt[0])) ?>',
                '<?= $appt[1] ?>',
                '<?= htmlspecialchars($appt[2]) ?>',
                '<?= htmlspecialchars($appt[3]) ?>',
                '<?= htmlspecialchars($appt[4]) ?>'
            )">

            <div><?= date("m/d/y", strtotime($appt[0])) ?></div>
            <div><?= $appt[1] ?></div>
            <div><?= htmlspecialchars($appt[2]) ?></div>
            <div><?= htmlspecialchars($appt[3]) ?></div>
            <div>
                <span class="status <?= $statusClass ?>">
                    <?= htmlspecialchars($appt[4]) ?>
                </span>
            </div>
        </div>

        <?php endforeach; ?>

    </div>
</div>

<div class="modal-overlay" id="modalOverlay">
    <div class="modal">
        <div class="modal-header">
            <h3 id="modalType">Appointment Details</h3>
            <span class="close-btn" onclick="closeModal()">✖</span>
        </div>

        <div class="modal-content">
            <h2 id="modalName"></h2>

            <div class="appointment-box">
                <p><strong>Date:</strong> <span id="modalDate"></span></p>
                <p><strong>Time:</strong> <span id="modalTime"></span></p>
            </div>

            <div class="details">
                <p><strong>Appointment Type:</strong> <span id="modalApptType"></span></p>
                <p><strong>Status:</strong> <span id="modalStatus"></span></p>
            </div>

            <button class="close-modal-btn" onclick="closeModal()">Close</button>
        </div>
    </div>
</div>

<script>
function toggleMenu() {
    const nav = document.getElementById("navbar");
    nav.style.display = nav.style.display === "flex" ? "none" : "flex";
}
function toggleProfile() {
    const dropdown = document.getElementById("profileDropdown");
    dropdown.style.display = dropdown.style.display === "flex" ? "none" : "flex";
}

function openModal(date, time, name, type, status) {
    document.getElementById("modalOverlay").style.display = "flex";

    document.getElementById("modalDate").innerText = date;
    document.getElementById("modalTime").innerText = time;
    document.getElementById("modalName").innerText = name;
    document.getElementById("modalApptType").innerText = type;
    document.getElementById("modalStatus").innerText = status;

    document.getElementById("modalType").innerText = type + " Details";
}

function closeModal() {
    document.getElementById("modalOverlay").style.display = "none";
}

document.getElementById("modalOverlay").addEventListener("click", function(e){
    if(e.target === this){
        closeModal();
    }
});

</script>

</body>
</html>