<?php

include_once "../php/session.php";


if (!isset($_SESSION['user_id'])) {
    // Not logged in
    header("Location: admin_login.php");
    exit;
}
// $appointments = [
//     ["2026-02-16", "7:00-8:00 AM", "Juan Dela Cruz", "Career", "Rescheduled"],
//     ["2026-02-23", "1:00-2:00 PM", "Maria Santos", "Career", "Attended BYB"],
//     ["2026-02-27", "3:00-4:00 PM", "Rizal Doe", "Sales", "Processing"],
// ];

$appointments = include_once "../php/get_appointment_list.php";
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
    font-family: "Segoe UI", system-ui, -apple-system, sans-serif;
    background-color: #f5f6fa;
    color: #333;
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
    padding: 18px 35px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

/* LEFT SIDE (logo + text) */
.header-left {
    display: flex;
    align-items: center;
    gap: 12px; /* space between image and text */
}

.logo {
    font-size: 22px;
    font-weight: 700;
    color: #880318;
    letter-spacing: 0.5px;
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
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.06);
}

/* TABLE */
.table-header,
.table-row {
    display: grid;
    grid-template-columns: 1fr 1fr 1.5fr 1.5fr 1.2fr 0.2fr;
    padding: 16px 15px;
    align-items: center;
}

.table-header {
    font-weight: 700;
    border-bottom: 2px solid #880318;
    color: #000000;
    font-size: 16px;
    letter-spacing: 0.5px;
}

.table-row {
    border-bottom: 1px solid #f0f0f0;
    transition: 0.2s ease;
    cursor: pointer;
}

.table-row:hover {
    background: #f8f9fc;
}

/* STATUS DROPDOWN BASE STYLE */
.status-select {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    outline: none;
    appearance: none;
    text-align: center;
    min-width: 160px;
    transition: 0.2s ease;
}

/* STATUS COLORS */
.status-green {
    background: #d4edda;
    color: #155724;
}

.status-blue {
    background: #cce5ff;
    color: #004085;
}

.status-yellow {
    background: #fff3cd;
    color: #856404;
}

.status-red {
    background: #f8d7da;
    color: #721c24;
}

.status-lavender {
    background: #e6d4f5;
    color: #5a2d82;
}

.status-select:hover {
    transform: scale(1.03);
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
    width: 420px;
    border-radius: 18px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.15);
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
    background: #f1f3f9;
    padding: 15px;
    border-radius: 10px;
    margin: 18px 0;
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

/* FILTER HEADER */
.filter-header {
    position: relative;
    display: flex;
    align-items: center;
    gap: 6px;
}

.filter-icon {
    font-size: 14px;
    cursor: pointer;
    opacity: 0.6;
}

.filter-icon:hover {
    opacity: 1;
}

/* FILTER DROPDOWN BOX */
.filter-box {
    position: absolute;
    top: 28px;
    right: 0;
    background: white;
    border-radius: 8px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    display: none;
    flex-direction: column;
    min-width: 170px;
    z-index: 50;
    padding: 5px 0;
}

.filter-box div {
    padding: 8px 12px;
    cursor: pointer;
    font-size: 14px;
}

.filter-box div:hover {
    background: #f3f4f8;
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
                            <img src="../assets/account.png">
                        </span>
                        <span>Account</span>
                    </a>

                    <a href="#">
                        <span class="icon-wrapper">
                            <img src="../assets/setting.png">
                        </span>
                        <span>Settings</span>
                    </a>

                    <a href="#" id="logout">
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

            <div class="filter-header">
                Appointment Type
                <span class="filter-icon" onclick="toggleFilter('typeFilterBox')">⏷</span>

                <div class="filter-box" id="typeFilterBox">
                    <div onclick="applyTypeFilter('All')">All</div>
                    <div onclick="applyTypeFilter('Career')">Career</div>
                    <div onclick="applyTypeFilter('Sales')">Sales</div>
                </div>
            </div>

            <div class="filter-header">
                Status
                <span class="filter-icon" onclick="toggleFilter('statusFilterBox')">⏷</span>

                <div class="filter-box" id="statusFilterBox">
                    <div onclick="applyStatusFilter('All')">All</div>
                    <div onclick="applyStatusFilter('Attended BYB')">Attended BYB</div>
                    <div onclick="applyStatusFilter('Rescheduled')">Rescheduled</div>
                    <div onclick="applyStatusFilter('Waiting')">Waiting</div>
                    <div onclick="applyStatusFilter('Not Qualified')">Not Qualified</div>
                    <div onclick="applyStatusFilter('Set Appointment')">Set Appointment</div>
                    <div onclick="applyStatusFilter('Waiting for Reply')">Waiting for Reply</div>
                    <div onclick="applyStatusFilter('No Response')">No Response</div>
                    <div onclick="applyStatusFilter('With Existing Insurance')">With Existing Insurance</div>
                    <div onclick="applyStatusFilter('No Budget')">No Budget</div>
                </div>
            </div>
            <div>
                Face
            </div>
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
            data-date="<?= date("F d, Y", strtotime($appt[0])) ?>"
            data-time="<?= $appt[1] ?>"
            data-name="<?= htmlspecialchars($appt[2]) ?>"
            data-type="<?= htmlspecialchars($appt[3]) ?>"
            data-face="<?= htmlspecialchars($appt[5]) ?>"
            onclick="openModal(this)">

            <div><?= date("m/d/y", strtotime($appt[0])) ?></div>
            <div><?= $appt[1] ?></div>
            <div><?= htmlspecialchars($appt[2]) ?></div>
            <div><?= htmlspecialchars($appt[3]) ?></div>
            <div>
                <select class="status-select"
                        onchange="changeStatusColor(this)"
                        onclick="event.stopPropagation()"
                        data-type="<?= htmlspecialchars($appt[3]) ?>">

                    <?php if ($appt[3] === "Career"): ?>

                        <option value="Attended BYB">Attended BYB</option>
                        <option value="Rescheduled">Rescheduled</option>
                        <option value="Waiting">Waiting</option>
                        <option value="Not Qualified">Not Qualified</option>

                    <?php elseif ($appt[3] === "Sales"): ?>

                        <option value="Set Appointment">Set Appointment</option>
                        <option value="Waiting for Reply">Waiting for Reply</option>
                        <option value="No Response">No Response</option>
                        <option value="With Existing Insurance">With Existing Insurance</option>
                        <option value="No Budget">No Budget</option>

                    <?php endif; ?>

                </select>
            </div>
            <div>
                <img src="data:image/png;base64,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" alt="stack-of-photos">
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

            <h2 id="modalNameText"></h2>
            <input type="text" id="modalNameInput" style="display:none; width:100%; padding:8px; margin-bottom:10px;">

            <div class="appointment-box">
                <p>
                    <strong>Date:</strong> 
                    <span id="modalDateText"></span>
                    <input type="date" id="modalDateInput" style="display:none;">
                </p>

                <p>
                    <strong>Time:</strong> 
                    <span id="modalTimeText"></span>
                    <input type="text" id="modalTimeInput" style="display:none;">
                </p>
            </div>

            <div class="details">
                <p>
                    <strong>Appointment Type:</strong> 
                    <span id="modalApptTypeText"></span>
                </p>

                <p>
                    <strong>Status:</strong> 
                    <span id="modalStatusText"></span>
                </p>
            </div>

            <div>
                <img id="modalFaceImage" src="" alt="Face Image" style="max-width: 100%; height: auto;">
            </div>

            <div style="margin-top:20px; display:flex; gap:10px;">
                <button class="close-modal-btn" onclick="enableEdit()">Edit</button>
                <button class="close-modal-btn" id="saveBtn" onclick="saveChanges()" style="display:none; background:#155724;">Save</button>
                <button class="close-modal-btn" onclick="closeModal()">Close</button>
            </div>

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

let currentRow = null;

function openModal(row) {

    currentRow = row;

    const date = row.dataset.date;
    const time = row.dataset.time;
    const name = row.dataset.name;
    const type = row.dataset.type;
    const face = row.dataset.face;

    const select = row.querySelector(".status-select");
    const status = select.value;

    document.getElementById("modalOverlay").style.display = "flex";

    // TEXT MODE
    document.getElementById("modalNameText").innerText = name;
    document.getElementById("modalDateText").innerText = date;
    document.getElementById("modalTimeText").innerText = time;
    document.getElementById("modalApptTypeText").innerText = type;
    document.getElementById("modalStatusText").innerText = status;
    document.getElementById("modalFaceImage").src = "data:image/png;base64," + face;

    document.getElementById("modalType").innerText = type + " Details";

    disableEditMode();
}

function enableEdit() {

    // Hide text
    document.getElementById("modalNameText").style.display = "none";
    document.getElementById("modalDateText").style.display = "none";
    document.getElementById("modalTimeText").style.display = "none";

    // Show inputs
    document.getElementById("modalNameInput").style.display = "block";
    document.getElementById("modalDateInput").style.display = "inline";
    document.getElementById("modalTimeInput").style.display = "inline";

    // Fill inputs
    document.getElementById("modalNameInput").value =
        document.getElementById("modalNameText").innerText;

    document.getElementById("modalDateInput").value =
        new Date(document.getElementById("modalDateText").innerText)
            .toISOString().split('T')[0];

    document.getElementById("modalTimeInput").value =
        document.getElementById("modalTimeText").innerText;

    document.getElementById("saveBtn").style.display = "inline-block";
}

function disableEditMode() {

    document.getElementById("modalNameText").style.display = "block";
    document.getElementById("modalDateText").style.display = "inline";
    document.getElementById("modalTimeText").style.display = "inline";

    document.getElementById("modalNameInput").style.display = "none";
    document.getElementById("modalDateInput").style.display = "none";
    document.getElementById("modalTimeInput").style.display = "none";

    document.getElementById("saveBtn").style.display = "none";
}

function saveChanges() {

    const newName = document.getElementById("modalNameInput").value;
    const newDate = document.getElementById("modalDateInput").value;
    const newTime = document.getElementById("modalTimeInput").value;

    // Update table row
    currentRow.children[0].innerText =
        new Date(newDate).toLocaleDateString("en-US");

    currentRow.children[1].innerText = newTime;
    currentRow.children[2].innerText = newName;

    // Update dataset
    currentRow.dataset.name = newName;
    currentRow.dataset.date =
        new Date(newDate).toLocaleDateString("en-US");

    currentRow.dataset.time = newTime;

    // Update modal text
    document.getElementById("modalNameText").innerText = newName;
    document.getElementById("modalDateText").innerText =
        new Date(newDate).toLocaleDateString("en-US");
    document.getElementById("modalTimeText").innerText = newTime;

    disableEditMode();
}

function closeModal() {
    document.getElementById("modalOverlay").style.display = "none";
}

document.getElementById("modalOverlay").addEventListener("click", function(e){
    if(e.target === this){
        closeModal();
    }
});

function changeStatusColor(select) {

    const value = select.value;

    select.classList.remove(
        "status-green",
        "status-blue",
        "status-yellow",
        "status-red",
        "status-lavender"
    );

    switch (value) {

        // CAREER
        case "Attended BYB":
        case "Set Appointment":
            select.classList.add("status-green");
            break;

        case "Rescheduled":
        case "No Budget":
            select.classList.add("status-blue");
            break;

        case "Waiting":
        case "Waiting for Reply":
            select.classList.add("status-yellow");
            break;

        case "Not Qualified":
        case "No Response":
            select.classList.add("status-red");
            break;

        case "With Existing Insurance":
            select.classList.add("status-lavender");
            break;
    }
}

document.querySelectorAll(".status-select").forEach(select => {
    changeStatusColor(select);
});

let selectedType = "All";
let selectedStatus = "All";

// Toggle filter dropdown
function toggleFilter(id) {

    document.querySelectorAll(".filter-box").forEach(box => {
        if (box.id !== id) box.style.display = "none";
    });

    const box = document.getElementById(id);
    box.style.display = box.style.display === "flex" ? "none" : "flex";
}

// Apply Type Filter
function applyTypeFilter(type) {
    selectedType = type;
    filterTable();
    document.getElementById("typeFilterBox").style.display = "none";
}

// Apply Status Filter
function applyStatusFilter(status) {
    selectedStatus = status;
    filterTable();
    document.getElementById("statusFilterBox").style.display = "none";
}

// Filter Logic
function filterTable() {

    const rows = document.querySelectorAll(".table-row");

    rows.forEach(row => {

        const rowType = row.dataset.type;
        const rowStatus = row.querySelector(".status-select").value;

        const typeMatch = selectedType === "All" || rowType === selectedType;
        const statusMatch = selectedStatus === "All" || rowStatus === selectedStatus;

        if (typeMatch && statusMatch) {
            row.style.display = "grid";
        } else {
            row.style.display = "none";
        }

    });
}

// Close filter when clicking outside
document.addEventListener("click", function(e) {
    if (!e.target.closest(".filter-header")) {
        document.querySelectorAll(".filter-box").forEach(box => {
            box.style.display = "none";
        });
    }
});

</script>
<script>
document.getElementById("logout").addEventListener("click", function(e) {
    e.preventDefault();

    fetch("../php/logout.php", {
        method: "POST"
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Redirect to login page
            window.location.href = "admin_login.php";
        } else {
            alert("Logout failed");
        }
    })
    .catch(err => {
        console.error(err);
        alert("Something went wrong");
    });
});
</script>
</body>
</html>