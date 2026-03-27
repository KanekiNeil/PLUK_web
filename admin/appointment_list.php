<?php

include_once "../php/session.php";


if (!isset($_SESSION['user_id'])) {
    // Not logged in
    //header("Location: admin_login.php");
    //exit;
}
// $appointments = [
//     ["2026-02-16", "7:00-8:00 AM", "Juan Dela Cruz", "Career", "Rescheduled"],
//     ["2026-02-23", "1:00-2:00 PM", "Maria Santos", "Career", "Attended BYB"],
//     ["2026-02-27", "3:00-4:00 PM", "Rizal Doe", "Sales", "Processing"],
// ];

$appointments = include "../php/get_appointment_list.php";

$user_name = "Levi De Guzman";
$user_role = "Junior Unit Manager";
$initials = strtoupper(substr($user_name, 0, 1)) .
            strtoupper(substr(strrchr($user_name, " "), 1, 1));


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="../style/dashboard.css"> 
<title>Appointment List</title>

<style>
body {
    margin: 0;
    font-family: "Segoe UI", system-ui, -apple-system, sans-serif;
    background-color: #f5f5f5;
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

.container-al {
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

.status-default {
    background: #f0f0f0;
    color: #333;
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

.modal-input {
    width: 60%;
    padding: 8px 10px;
    margin-top: 5px;
    border-radius: 8px;
    border:1px solid #ccc;
    font-size:14px;
}

.modal-select {
    width: 100%;
    padding: 8px 10px;
    margin-top:5px;
    border-radius: 8px;
    border:1px solid #ccc;
    font-size:14px;
}

.modal-btn {
    padding:8px 18px;
    border:none;
    border-radius:20px;
    cursor:pointer;
    font-weight:600;
    transition:0.2s;
}

#editBtn {
    background:#880318;
    color:white;
}

.save-btn {
    background:#155724;
    color:white;
}

.cancel-btn {
    background:#888;
    color:white;
}

.modal-btn:hover {
    opacity:0.85;
}

/* Status badges inside modal */
.status-badge {
    padding:4px 10px;
    border-radius:15px;
    font-size:13px;
    font-weight:600;
    display:inline-block;
}
.status-green { background:#d4edda; color:#155724; }
.status-blue { background:#cce5ff; color:#004085; }
.status-yellow { background:#fff3cd; color:#856404; }
.status-red { background:#f8d7da; color:#721c24; }
.status-lavender { background:#e6d4f5; color:#5a2d82; }

.appointment-box {
    background: #f1f3f9;
    padding: 20px;
    border-radius: 10px;
    margin: 25px 0;
    width: 50px;
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
<?php include "../components/header.php"; ?>


<!-- CONTENT -->
<div class="container-al">
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
                str_contains($appt[6], "Rescheduled") => "status-rescheduled",
                str_contains($appt[6], "Attended") => "status-attended",
                str_contains($appt[6], "Processing") => "status-processing",
                default => "status-default"
            };
        ?>

        <div class="table-row"
            data-aaid="<?= htmlspecialchars($appt[0]) ?>"
            data-aiid="<?= htmlspecialchars($appt[1]) ?>"
            data-date="<?= date("F d, Y", strtotime($appt[2])) ?>"
            data-time="<?= $appt[3] ?>"
            data-name="<?= htmlspecialchars($appt[4]) ?>"
            data-type="<?= htmlspecialchars($appt[5]) ?>"
            data-status="<?= htmlspecialchars($appt[6]) ?>"
            data-face="<?= htmlspecialchars($appt[7]) ?>"
            onclick="openModal(this)">

            <div><?= date("m/d/y", strtotime($appt[2])) ?></div>
            <div><?= $appt[3] ?></div>
            <div><?= htmlspecialchars($appt[4]) ?></div>
            <div><?= htmlspecialchars($appt[5]) ?></div>
            <div>
                <select class="status-select"
                        onchange="persistStatus(this)"
                        onclick="event.stopPropagation()"
                        data-type="<?= htmlspecialchars($appt[5]) ?>">

                    <?php if ($appt[5] === "Career"): ?>

                        <option value="Attended BYB" <?= $appt[6] === "Attended BYB" ? "selected" : "" ?>>Attended BYB</option>
                        <option value="Rescheduled" <?= $appt[6] === "Rescheduled" ? "selected" : "" ?>>Rescheduled</option>
                        <option value="Waiting" <?= $appt[6] === "Waiting" ? "selected" : "" ?>>Waiting</option>
                        <option value="Not Qualified" <?= $appt[6] === "Not Qualified" ? "selected" : "" ?>>Not Qualified</option>
                        <?php if (!in_array($appt[6], ["Attended BYB", "Rescheduled", "Waiting", "Not Qualified"], true)): ?>
                            <option value="<?= htmlspecialchars($appt[6]) ?>" selected><?= htmlspecialchars($appt[6]) ?></option>
                        <?php endif; ?>

                    <?php elseif ($appt[5] === "Sales"): ?>

                        <option value="Set Appointment" <?= $appt[6] === "Set Appointment" ? "selected" : "" ?>>Set Appointment</option>
                        <option value="Waiting for Reply" <?= $appt[6] === "Waiting for Reply" ? "selected" : "" ?>>Waiting for Reply</option>
                        <option value="No Response" <?= $appt[6] === "No Response" ? "selected" : "" ?>>No Response</option>
                        <option value="With Existing Insurance" <?= $appt[6] === "With Existing Insurance" ? "selected" : "" ?>>With Existing Insurance</option>
                        <option value="No Budget" <?= $appt[6] === "No Budget" ? "selected" : "" ?>>No Budget</option>
                        <?php if (!in_array($appt[6], ["Set Appointment", "Waiting for Reply", "No Response", "With Existing Insurance", "No Budget"], true)): ?>
                            <option value="<?= htmlspecialchars($appt[6]) ?>" selected><?= htmlspecialchars($appt[6]) ?></option>
                        <?php endif; ?>

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
            <h3>Appointment Details</h3>
            <span class="close-btn" onclick="closeModal()">✖</span>
        </div>

        <div class="modal-content">

            <!-- PROFILE SECTION -->
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:15px;">
                <img id="modalFaceImage" 
                    style="width:50px; height:50px; border-radius:50%; border:2px solid #880318;">
                <div>
                    <div id="modalName" style="font-size:18px; font-weight:700;"></div>
                </div>
            </div>

            <!-- SCHEDULE DATE SECTION -->
            <div style="margin-top:10px;">
                <div style="font-weight:600; margin-bottom:8px; color:#555;">
                    Schedule Date
                </div>

                <div style="background:#f4b2b2; padding:12px; border-radius:10px;">
                    <div id="modalDate"></div>
                    <div id="modalTime"></div>
                </div>
            </div>

            <!-- DETAILS SECTION -->
            <div style="margin-top:20px;">
                <div style="font-weight:600; margin-bottom:8px; color:#555;">
                    Details
                </div>

                <div style="font-size:14px;">

                    <p><strong>Current Job:</strong> <span id="modalType"></span></p>
                    <p><strong>Contact Number:</strong> <span>N/A</span></p>

                    <p>
                        <strong>Status:</strong> 
                        <span id="modalStatus" class="status-badge"></span>
                    </p>

                    <p><strong>Date Attended BYB:</strong> <span>N/A</span></p>
                    <p><strong>Next Step:</strong> <span>N/A</span></p>

                </div>
            </div>

            <!-- FOOTER -->
            <div style="text-align:center; margin-top:20px;">
                <button class="close-modal-btn" onclick="closeModal()">Close</button>
            </div>

        </div>
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
function toggleMenu() {
    const nav = document.getElementById("navbar");
    nav.style.display = nav.style.display === "flex" ? "none" : "flex";
}
function toggleProfile() {

    const dropdown = document.getElementById("profileDropdown");

    if (dropdown.style.display === "flex") {
        dropdown.style.display = "none";
    } else {
        dropdown.style.display = "flex";
    }
}

document.addEventListener("click", function(e){

    const profile = document.querySelector(".user-section");
    const dropdown = document.getElementById("profileDropdown");

    if (!profile.contains(e.target)) {
        dropdown.style.display = "none";
    }

});

let currentRow = null;

function openModal(row) {

    const name = row.dataset.name;
    const date = row.dataset.date;
    const time = row.dataset.time;
    const type = row.dataset.type;
    const status = row.dataset.status;
    const face = row.dataset.face;

    document.getElementById("modalOverlay").style.display = "flex";

    // PROFILE SECTION
    document.getElementById("modalName").innerText = name;
    document.getElementById("modalFaceImage").src = "data:image/png;base64," + face;

    // SCHEDULE DATE
    document.getElementById("modalDate").innerText = "📅 " + date;
    document.getElementById("modalTime").innerText = "⏰ " + time;

    // DETAILS
    document.getElementById("modalType").innerText = type;

    const statusEl = document.getElementById("modalStatus");
    statusEl.innerText = status;

    // RESET CLASS
    statusEl.className = "status-badge";

    switch (status) {
        case "Attended BYB":
        case "Set Appointment":
            statusEl.classList.add("status-green"); break;

        case "Rescheduled":
        case "No Budget":
            statusEl.classList.add("status-blue"); break;

        case "Waiting":
        case "Waiting for Reply":
            statusEl.classList.add("status-yellow"); break;

        case "Not Qualified":
        case "No Response":
            statusEl.classList.add("status-red"); break;

        case "With Existing Insurance":
            statusEl.classList.add("status-lavender"); break;

        default:
            statusEl.classList.add("status-default");
    }
}

function enableEdit() {

    document.getElementById("modalNameInput").readOnly = false;
    document.getElementById("modalDateInput").readOnly = false;
    document.getElementById("modalTimeInput").readOnly = false;

    const type = currentRow.dataset.type;

    const statusSelect = document.getElementById("modalStatusSelect");
    const currentStatus = currentRow.querySelector(".status-select").value;

    let options = [];

    if(type === "Career"){
        options = [
            "Attended BYB",
            "Rescheduled",
            "Waiting",
            "Not Qualified"
        ];
    }

    if(type === "Sales"){
        options = [
            "Set Appointment",
            "Waiting for Reply",
            "No Response",
            "With Existing Insurance",
            "No Budget"
        ];
    }

    if (currentStatus && !options.includes(currentStatus)) {
        options.unshift(currentStatus);
    }

    statusSelect.innerHTML = options.map(opt => 
        `<option value="${opt}">${opt}</option>`
    ).join("");

    statusSelect.value = currentStatus;

    document.getElementById("modalStatusText").style.display = "none";
    statusSelect.style.display = "block";

    document.getElementById("saveBtn").style.display = "inline-block";
}

function saveChanges() {
    const newName = document.getElementById("modalNameInput").value;
    const newDate = document.getElementById("modalDateInput").value;
    const newTime = document.getElementById("modalTimeInput").value;
    const newStatus = document.getElementById("modalStatusSelect").value;

    // Update table row
    currentRow.children[0].innerText = new Date(newDate).toLocaleDateString("en-US");
    currentRow.children[1].innerText = newTime;
    currentRow.children[2].innerText = newName;

    const rowStatusSelect = currentRow.querySelector(".status-select");
    rowStatusSelect.value = newStatus;
    persistStatus(rowStatusSelect);

    // Update modal
    document.getElementById("modalNameInput").readOnly = true;
    document.getElementById("modalDateInput").readOnly = true;
    document.getElementById("modalTimeInput").readOnly = true;

    const badge = document.getElementById("modalStatusText");
    badge.innerText = newStatus;
    badge.style.display = "inline-block";
    badge.className = "status-badge"; // reset
    switch (newStatus) {
        case "Attended BYB": case "Set Appointment": badge.classList.add("status-green"); break;
        case "Rescheduled": case "No Budget": badge.classList.add("status-blue"); break;
        case "Waiting": case "Waiting for Reply": badge.classList.add("status-yellow"); break;
        case "Not Qualified": case "No Response": badge.classList.add("status-red"); break;
        case "With Existing Insurance": badge.classList.add("status-lavender"); break;
    }

    // Hide select, show badge
    document.getElementById("modalStatusSelect").style.display = "none";

    // Toggle buttons
    document.getElementById("editBtn").style.display = "inline-block";
    document.getElementById("saveBtn").style.display = "none";
}

function disableEditMode(){

    document.getElementById("modalNameInput").readOnly = true;
    document.getElementById("modalDateInput").readOnly = true;
    document.getElementById("modalTimeInput").readOnly = true;

    document.getElementById("modalStatusSelect").style.display = "none";
    document.getElementById("modalStatusText").style.display = "inline-block";

    document.getElementById("saveBtn").style.display = "none";
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
        "status-lavender",
        "status-default"
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

        default:
            select.classList.add("status-default");

    }
}

document.querySelectorAll(".status-select").forEach(select => {
    select.dataset.previousStatus = select.value;
    changeStatusColor(select);
});

function persistStatus(select) {
    const row = select.closest(".table-row");
    const aaid = row?.dataset.aaid;
    const aiid = row?.dataset.aiid;
    const newStatus = select.value;
    const previousStatus = select.dataset.previousStatus || newStatus;

    changeStatusColor(select);

    if (!aaid && (!aiid)) {
        console.error("Missing IDs for status update", row?.dataset);
        alert("Unable to update status: missing appointment identifiers.");
        select.value = previousStatus;
        changeStatusColor(select);
        return;
    }

    const payload = {
        status: newStatus
    };

    if (aaid) {
        payload.aaid = aaid;
    } else {
        payload.aiid = aiid;
    }

    fetch("../php/update_status.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(payload)
    })
    .then(async (res) => {
        const data = await res.json().catch(() => ({}));
        if (!res.ok || data.status !== "success") {
            throw new Error(data.message || "Failed to update status");
        }
        select.dataset.previousStatus = newStatus;
    })
    .catch((error) => {
        select.value = previousStatus;
        changeStatusColor(select);
        alert(error.message || "Unable to update status.");
    });
}

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