<?php
include_once "../php/session.php";


if (!isset($_SESSION['user_id'])) {
    // Not logged in
    header("Location: admin_login.php");
    exit;
}
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

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
    padding:30px;
    box-shadow:0 8px 25px rgba(0,0,0,0.06);
    min-height: 500px;
}

/* optional wrapper matching appointment_list */
.container-al {
    padding: 40px;
}

/* ===== TITLE ===== */
.page-title{
    font-weight:600;
    margin-bottom:20px;
}

/* ===== GRID TABLE ===== */
.table-header,
.table-row {
    display: grid;
    grid-template-columns: 1fr 1fr 1.5fr 1.5fr 1.2fr 0.2fr;
    padding: 16px 15px;
    align-items: center;
}

/* HEADER */
.table-header{
    font-weight: 700;
    border-bottom: 2px solid #880318;
    color: #000000;
    font-size: 16px;
    letter-spacing: 0.5px;
}

/* TEXT HANDLING */
.table-row div{
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
}

@media (max-width: 900px) {
    .table-header,
    .table-row {
        grid-template-columns: 1fr 1fr;
        row-gap: 10px;
    }
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

/* ===== MODAL DESIGN ===== */

.custom-modal {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

/* Header */
.custom-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    border-bottom: 1px solid #eee;
}

/* Body spacing */
.modal-body {
    padding: 20px 25px;
}

/* Each field */
.modal-item {
    margin-bottom: 15px;
}

/* Labels */
.modal-item label {
    font-size: 12px;
    color: #888;
    display: block;
    margin-bottom: 2px;
}

/* Values */
.modal-item p {
    margin: 0;
    font-size: 15px;
    font-weight: 500;
    color: #333;
}

/* Footer */
.modal-footer {
    border-top: 1px solid #eee;
    padding-bottom: 20px;
}

.modal-footer {
    display: flex;
    justify-content: center;
    padding: 20px;
    border-top: none;
    background-color: #f9fafb;
}

.close-modal-btn {
    background-color: #880318; /* green theme */
    color: white;
    border: none;
    padding: 10px 28px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.close-modal-btn:hover {
    opacity:0.85;
    transform: translateY(-3px) scale(1.03);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

</style>
</head>

<body>

<!-- HEADER -->
<?php include '../components/admin_header.php'; ?>

<div class="container-al">
<div class="card">

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

<script>

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

        const name = row.dataset.name;
        const contact = row.dataset.contact;
        const school = row.dataset.school;
        const job = row.dataset.job;
        const address = row.dataset.address;
        const status = row.dataset.status;

        // Fill modal
        document.getElementById('modalName').textContent = name;
        document.getElementById('modalContact').textContent = contact;
        document.getElementById('modalSchool').textContent = school;
        document.getElementById('modalJob').textContent = job;
        document.getElementById('modalAddress').textContent = address;

        // STATUS BADGE (dynamic color)
        const statusEl = document.getElementById('modalStatus');
        statusEl.textContent = status;

        statusEl.className = "status-badge"; // reset

        if (status === "Pending") statusEl.classList.add("badge-pending");
        if (status === "Approved") statusEl.classList.add("badge-approved");
        if (status === "Completed") statusEl.classList.add("badge-completed");
        if (status === "Cancelled") statusEl.classList.add("badge-cancelled");


        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('applicantModal'));
        modal.show();
    });

});
</script>

</body>
</html>