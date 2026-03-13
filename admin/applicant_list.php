<?php
$appointments = [
    ["Juan Dela Cruz", "09218471841", "UP", "Engineer", "Pasig", "Pending"],
    ["Maria Santos", "09123456789", "NU", "Teacher", "Mandaluyong", "Approved"],
    ["Pedro Reyes", "09876543210", "ADMU", "Unemployed", "Cavite", "Completed"],
    ["Ana Lopez", "09555555555", "UPLB", "Doctor", "Tondo", "Cancelled"],
    ["Carlo Mendoza", "09444444444", "BSU", "N/A", "Davao", "Approved"]
];

$user_name = "Levi De Guzman";
$user_role = "Junior Unit Manager";
$initials = strtoupper(substr($user_name, 0, 1)) .
            strtoupper(substr(strrchr($user_name, " "), 1, 1));
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Applicant List</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

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

/* container */
.applicant-container{
    background:white;
    border-radius:18px;
    padding:30px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

/* title */
.page-title{
    font-weight:600;
    margin-bottom:20px;
}

/* TABLE DESIGN LIKE APPOINTMENT LIST */

.table-header,
.table-row{
    display:grid;
    grid-template-columns:1.5fr 1.2fr 1fr 1fr 1.5fr 1fr;
    padding:16px 15px;
    align-items:center;
}

.table-header{
    font-weight:700;
    border-bottom:2px solid #880318;
    font-size:16px;
}

.table-row{
    border-bottom:1px solid #f0f0f0;
    transition:0.2s ease;
    cursor:pointer;
}

.table-row:hover{
    background:#f8f9fc;
}

/* status badges */
.status-badge{
    padding:6px 14px;
    border-radius:20px;
    font-size:0.8rem;
    font-weight:500;
}

.badge-pending{
    background:#ffe7a0;
    color:#7a5c00;
}

.badge-approved{
    background:#d0e4ff;
    color:#1e56c5;
}

.badge-completed{
    background:#cde9d8;
    color:#2c7a4b;
}

.badge-cancelled{
    background:#ffd4d4;
    color:#a30000;
}

/* datatable search */
.dataTables_filter input{
    border-radius:8px;
    border:1px solid #ddd;
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

.user-section{
    display:flex;
    align-items:center;
    gap:12px;
}

.user-info{
   display: flex;
    flex-direction: column;
    line-height: 1.2;
}

.user-info strong {
    font-size: 13px;
    font-weight: 600;
}

.user-info small{
    font-size: 12px;
    color: #666;
}

.avatar{
    background:#2c6ed5;
    color:white;
    width:40px;
    height:40px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
}

.arrow{
    font-size: 10px;
    color: #444;
}

#applicantTable tbody tr{
cursor:pointer;
}

</style>
</head>

<body>

<!-- HEADER -->
<?php include '../components/header.php'; ?>

<div class="container mt-5">

<div class="applicant-container">


<div class="table-header">
    <div>Complete Name</div>
    <div>Contact Number</div>
    <div>School Graduated</div>
    <div>Current Job</div>
    <div>Home Address</div>
    <div>Work Status</div>
</div>

<?php foreach ($appointments as $appt): ?>

<div class="table-row">

<div><?= $appt[0] ?></div>
<div><?= $appt[1] ?></div>
<div><?= $appt[2] ?></div>
<div><?= $appt[3] ?></div>
<div><?= $appt[4] ?></div>

<div>

<?php
$statusClass = match($appt[5]) {
"Pending" => "badge-pending",
"Approved" => "badge-approved",
"Completed" => "badge-completed",
"Cancelled" => "badge-cancelled",
default => "bg-secondary"
};
?>

<span class="status-badge <?= $statusClass ?>">
<?= $appt[5] ?>
</span>

</div>

</div>

<?php endforeach; ?>
</table>

</div>
</div>

<?php include 'applicant_detail_modal.php'; ?>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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

function toggleProfile() {

    const dropdown = document.getElementById("profileDropdown");

    if (dropdown.style.display === "flex") {
        dropdown.style.display = "none";
    } else {
        dropdown.style.display = "flex";
    }
}


$(document).ready(function(){

    var table = $('#applicantTable').DataTable({
    responsive:true,
    pageLength:5,
    lengthChange:false
    });

    $('#applicantTable tbody').on('click','tr',function(){

    var data = table.row(this).data();
    if(!data) return;

    $('#modalName').text(data[0]);
    $('#modalContact').text(data[1]);
    $('#modalSchool').text(data[2]);
    $('#modalJob').text(data[3]);
    $('#modalAddress').text(data[4]);

    var statusText = $('<div>').html(data[5]).text().trim();
    $('#modalStatus').text(statusText);

    var modal = new bootstrap.Modal(document.getElementById('applicantModal'));
    modal.show();

    });

});

</script>

</body>
</html>