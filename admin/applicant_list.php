<?php
$appointments = include '../php/get_applicant_info.php';

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

<style>

/* ===== GLOBAL ===== */
body {
    margin: 0;
    font-family: "Segoe UI", system-ui, sans-serif;
    background-color: #f5f5f5;
    color: #333;
}

body::before {
    content: "";
    position: fixed;
    inset: 0;
    background: url("../assets/logo.jpg") center no-repeat;
    background-size: 400px;
    opacity: 0.05;
    z-index: -1;
}

/* ===== CONTAINER ===== */
.applicant-container{
    background:white;
    border-radius:16px;
    padding:25px;
    box-shadow:0 6px 20px rgba(0,0,0,0.06);
}

/* ===== TITLE ===== */
.page-title{
    font-weight:600;
    margin-bottom:20px;
}

/* ===== GRID TABLE ===== */
.table-header,
.table-row{
    display:grid;
    grid-template-columns: 
        minmax(180px, 2fr)
        minmax(140px, 1.5fr)
        minmax(120px, 1.2fr)
        minmax(140px, 1.2fr)
        minmax(220px, 2fr)
        minmax(110px, 1fr);
    gap:15px;
    padding:14px 18px;
    align-items:center;
}

/* HEADER */
.table-header{
    font-weight:bold;
    border-bottom:2px solid #880318;
    font-size:14px;
    background:#fafafa;
}

/* ROW */
.table-row{
    border-bottom:1px solid #eee;
    transition:0.2s ease;
}

.table-row:hover{
    background:#f9fafc;
    cursor:pointer;
}

/* TEXT HANDLING */
.table-row div{
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
}

/* Allow address wrapping */
.col-address{
    white-space:normal;
}

/* ===== STATUS BADGES ===== */
.status-badge{
    padding:2px 12px;
    border-radius:20px;
    font-size:0.75rem;
    font-weight:500;
}

.badge-pending{
    background:#fff3cd;
    color:#856404;
}

.badge-approved{
    background:#d1e7dd;
    color:#0f5132;
}

.badge-completed{
    background:#cff4fc;
    color:#055160;
}

.badge-cancelled{
    background:#f8d7da;
    color:#842029;
}

/* ===== USER HEADER (optional fix safe) ===== */
.user-section{
    display:flex;
    align-items:center;
    gap:10px;
}

.avatar{
    background:#2c6ed5;
    color:white;
    width:38px;
    height:38px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
}

.table-row {
    cursor: pointer;
}

.table-row:hover {
    background: #f1f5f9;
    transform: scale(1.01);
}

</style>
</head>

<body>

<!-- HEADER -->
<?php include '../components/header.php'; ?>

<div class="container mt-5">
<div class="applicant-container">

<h5 class="page-title">Applicant List</h5>

<!-- HEADER -->
<div class="table-header">
    <div>Complete Name</div>
    <div>Contact Number</div>
    <div>School Attended</div>
    <div>Job</div>
    <div>Address</div>
    <div>Status</div>
</div>

<!-- DATA -->
<?php foreach ($appointments as $appt): 
    $statusClass = match($appt[5]) {
        "Pending" => "badge-pending",
        "Approved" => "badge-approved",
        "Completed" => "badge-completed",
        "Cancelled" => "badge-cancelled",
        default => "bg-secondary"
    };
?>

<div class="table-row"
     data-name="<?= $appt[0] ?>"
     data-contact="<?= $appt[1] ?>"
     data-school="<?= $appt[2] ?>"
     data-job="<?= $appt[3] ?>"
     data-address="<?= $appt[4] ?>"
     data-status="<?= $appt[5] ?>">

    <div><?= $appt[0] ?></div>
    <div><?= $appt[1] ?></div>
    <div><?= $appt[2] ?></div>
    <div><?= $appt[3] ?></div>
    <div class="col-address"><?= $appt[4] ?></div>

    <div>
        <span class="status-badge <?= $statusClass ?>">
            <?= $appt[5] ?>
        </span>
    </div>

</div>

<?php endforeach; ?>

</div>
</div>

<?php include 'applicant_detail_modal.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>

/* ===== ROW CLICK → MODAL ===== */
document.querySelectorAll('.table-row').forEach(row => {
    row.addEventListener('click', () => {

        document.getElementById('modalName').textContent = row.dataset.name;
        document.getElementById('modalContact').textContent = row.dataset.contact;
        document.getElementById('modalSchool').textContent = row.dataset.school;
        document.getElementById('modalJob').textContent = row.dataset.job;
        document.getElementById('modalAddress').textContent = row.dataset.address;
        document.getElementById('modalStatus').textContent = row.dataset.status;

        new bootstrap.Modal(document.getElementById('applicantModal')).show();
    });
});

/* ===== SAFE PROFILE TOGGLE ===== */
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

</script>

<script>
document.querySelectorAll('.table-row').forEach(row => {

    row.addEventListener('click', () => {

        // Get data from clicked row
        const name = row.dataset.name;
        const contact = row.dataset.contact;
        const school = row.dataset.school;
        const job = row.dataset.job;
        const address = row.dataset.address;

        // Insert into modal
        document.getElementById('modalName').textContent = name;
        document.getElementById('modalContact').textContent = contact;
        document.getElementById('modalSchool').textContent = school;
        document.getElementById('modalJob').textContent = job;
        document.getElementById('modalAddress').textContent = address;

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('applicantModal'));
        modal.show();

    });

});
</script>

</body>
</html>