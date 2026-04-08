<?php

include_once "../php/session.php";


if (!isset($_SESSION['user_id'])) {
    // Not logged in
    header("Location: admin_login.php");
    exit;
}

$insuranceInquiries = array(
    array("2026-02-16", "7:00-8:00 AM", "Juan Dela Cruz", "Pending"),
    array("2026-02-23", "1:00-2:00 PM", "Maria Santos", "Approved"),
    array("2026-02-27", "3:00-4:00 PM", "Rizal Doe", "Processing"),
    array("2026-03-05", "9:00-10:00 AM", "Ana Reyes", "Pending"),
    array("2026-03-12", "2:00-3:00 PM", "Carlos Santos", "Rejected")
);

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
<link rel="stylesheet" href="../style/insurance_inquiries.css">
<title>Insurance Inquiries</title>
</head>

<body>

<!-- HEADER -->
<?php include "../components/header.php"; ?>


<!-- CONTENT -->
<div class="container-al">
    <div class="card">

        <div class="table-header">
            <div class="filter-header">
                Date
                <span class="active-filter-pill" id="dateFilterCurrent">All</span>
                <span class="filter-icon" onclick="toggleFilter('dateFilterBox')">⏷</span>

                <div class="filter-box" id="dateFilterBox">
                    <div onclick="applyDateFilter('All')">All</div>
                    <div onclick="applyDateFilter('Today')">Today</div>
                    <div onclick="applyDateFilter('Past')">Past</div>
                    <div onclick="applyDateFilter('Upcoming')">Upcoming</div>
                </div>
            </div>
            <div>Time</div>
            <div>Full Name</div>

            <div class="filter-header">
                Status
                <span class="filter-icon" onclick="toggleFilter('statusFilterBox')">⏷</span>

                <div class="filter-box" id="statusFilterBox">
                    <div onclick="applyStatusFilter('All')">All</div>
                    <div onclick="applyStatusFilter('Pending')">Pending</div>
                    <div onclick="applyStatusFilter('Approved')">Approved</div>
                    <div onclick="applyStatusFilter('Processing')">Processing</div>
                    <div onclick="applyStatusFilter('Rejected')">Rejected</div>
                </div>
            </div>
            <div>
                Action
            </div>
        </div>

        <div id="filterSummary" class="filter-summary">Showing: All records</div>

        <?php foreach ($insuranceInquiries as $inquiry): 
            $statusClass = match(true) {
                $inquiry[3] === "Approved" => "status-green",
                $inquiry[3] === "Pending" => "status-yellow",
                $inquiry[3] === "Processing" => "status-blue",
                $inquiry[3] === "Rejected" => "status-red",
                default => "status-default"
            };
        ?>

        <div class="table-row"
            data-date="<?= date("F d, Y", strtotime($inquiry[0])) ?>"
            data-date-raw="<?= htmlspecialchars($inquiry[0]) ?>"
            data-time="<?= $inquiry[1] ?>"
            data-name="<?= htmlspecialchars($inquiry[2]) ?>"
            data-status="<?= htmlspecialchars($inquiry[3]) ?>"
            onclick="openModal(this)">

            <div><?= date("m/d/y", strtotime($inquiry[0])) ?></div>
            <div><?= $inquiry[1] ?></div>
            <div><?= htmlspecialchars($inquiry[2]) ?></div>
            <div>
                <select class="status-select <?= $statusClass ?>"
                        onchange="persistStatus(this)"
                        onclick="event.stopPropagation()">

                    <option value="Pending" <?= $inquiry[3] === "Pending" ? "selected" : "" ?>>Pending</option>
                    <option value="Approved" <?= $inquiry[3] === "Approved" ? "selected" : "" ?>>Approved</option>
                    <option value="Processing" <?= $inquiry[3] === "Processing" ? "selected" : "" ?>>Processing</option>
                    <option value="Rejected" <?= $inquiry[3] === "Rejected" ? "selected" : "" ?>>Rejected</option>

                </select>
            </div>
            <div>
                <span class="material-icons" style="cursor:pointer; font-size:20px; color:#888;" onclick="editInquiry(this)">edit</span>
            </div>
        </div>

        <?php endforeach; ?>

    </div>

</div>

<div class="modal-overlay" id="modalOverlay">
    <div class="modal">
        <div class="modal-header">
            <h3>Insurance Inquiry Details</h3>
            <span class="close-btn" onclick="closeModal()">✖</span>
        </div>

        <div class="modal-content">

            <!-- NAME SECTION -->
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:15px;">
                <div>
                    <div id="modalName" style="font-size:18px; font-weight:700;"></div>
                </div>
            </div>

            <!-- SCHEDULE DATE SECTION -->
            <div style="margin-top:10px;">
                <div style="font-weight:600; margin-bottom:8px; color:#555;">
                    Schedule Information
                </div>

                <div style="background:#f4b2b2; padding:12px; border-radius:10px;">
                    <div id="modalDate"></div>
                    <div id="modalTime"></div>
                </div>
            </div>

            <!-- DETAILS SECTION -->
            <div style="margin-top:20px;">
                <div style="font-weight:600; margin-bottom:8px; color:#555;">
                    Inquiry Status
                </div>

                <div style="font-size:14px;">
                    <p>
                        <strong>Status:</strong> 
                        <span id="modalStatus" class="status-badge"></span>
                    </p>
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

function toggleFilter(filterId) {
    const filter = document.getElementById(filterId);
    const isVisible = filter.style.display === 'flex';
    
    // Close all filter boxes first
    document.querySelectorAll('.filter-box').forEach(box => {
        box.style.display = 'none';
    });
    
    // Toggle the selected filter
    if (!isVisible) {
        filter.style.display = 'flex';
    }
}

function applyDateFilter(type) {
    document.getElementById("dateFilterCurrent").textContent = type;
    document.getElementById("dateFilterBox").style.display = "none";
    updateFilterSummary();
}

function applyStatusFilter(status) {
    document.getElementById("statusFilterBox").style.display = "none";
    // Filter logic here
}

function updateFilterSummary() {
    const dateFilter = document.getElementById("dateFilterCurrent").textContent;
    document.getElementById("filterSummary").textContent = `Showing: ${dateFilter} records`;
}

function openModal(row) {
    const name = row.getAttribute('data-name');
    const date = row.getAttribute('data-date');
    const time = row.getAttribute('data-time');
    const status = row.getAttribute('data-status');
    
    document.getElementById('modalName').textContent = name;
    document.getElementById('modalDate').textContent = `Date: ${date}`;
    document.getElementById('modalTime').textContent = `Time: ${time}`;
    
    const statusBadge = document.getElementById('modalStatus');
    statusBadge.textContent = status;
    statusBadge.className = 'status-badge ' + getStatusClass(status);
    
    document.getElementById('modalOverlay').style.display = 'flex';
}

function getStatusClass(status) {
    switch(status) {
        case 'Approved': return 'status-green';
        case 'Pending': return 'status-yellow';
        case 'Processing': return 'status-blue';
        case 'Rejected': return 'status-red';
        default: return 'status-default';
    }
}

function closeModal() {
    document.getElementById('modalOverlay').style.display = 'none';
}

function persistStatus(select) {
    // API call to update status
    console.log('Status updated to:', select.value);
}

function editInquiry(element) {
    const row = element.closest('.table-row');
    openModal(row);
}

// Close modal when clicking outside
document.getElementById('modalOverlay').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

</script>

</body>
</html>
