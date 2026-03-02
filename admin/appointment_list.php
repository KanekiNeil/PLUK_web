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
    background: #f5f6fa;
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
</style>
</head>
<body>

<!-- HEADER -->
<div class="header">

    <div class="header-left">
        <img src="../assets/logo.jpg" height="40">
        <div class="logo">Alpha Aquila</div>
    </div>
    <div class="burger" onclick="toggleMenu()">☰</div>
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

        <div class="table-row">
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

<script>
function toggleMenu() {
    const nav = document.getElementById("navbar");
    nav.style.display = nav.style.display === "flex" ? "none" : "flex";
}
</script>

</body>
</html>