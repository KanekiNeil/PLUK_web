<?php
// include_once "../php/session.php";

// if (!isset($_SESSION['user_id'])) {
//     header("Location: admin_login.php");
//     exit;
// }

$user_name = "Levi De Guzman";
$user_role = "Junior Unit Manager";

// Example static data (replace with DB query)
$payments = [
    ["juandelacruz@email.com", "02/16/26", "Juan Dela Cruz", "1,010", "N/A", "Not Paid"],
    ["mariasantos@email.com", "02/23/26", "Maria Santos", "1,010", "102873764484", "Paid"],
    ["rizaldoe@email.com", "02/27/26", "Rizal Doe", "1,010", "72383945465", "Pending"],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Confirmation Request</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            min-height: 100vh;
        }
        
        /* Header */
        .header {
            background: #fff;
            padding: 15px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .logo-section {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo-section img {
            height: 40px;
        }
        
        .logo-section h2 {
            color: #8B3A3A;
            font-size: 18px;
            font-weight: 600;
        }
        
        .nav {
            display: flex;
            gap: 30px;
        }
        
        .nav a {
            text-decoration: none;
            color: #333;
            font-size: 14px;
            font-weight: 500;
            padding: 5px 0;
        }
        
        .nav a:hover,
        .nav a.active {
            color: #8B3A3A;
            border-bottom: 2px solid #8B3A3A;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .user-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .notification-icon {
            color: #333;
            cursor: pointer;
        }
        
        .user-info {
            text-align: right;
        }
        
        .user-info strong {
            display: block;
            font-size: 14px;
            color: #333;
        }
        
        .user-info small {
            color: #666;
            font-size: 12px;
        }
        
        .profile-avatar {
            width: 35px;
            height: 35px;
            background: #4A90D9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
            font-weight: 600;
        }
        
        /* Main Content */
        .main-content {
            padding: 0 40px 40px;
        }
        
        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
            position: relative;
            min-height: 500px;
        }
        
        /* Background Logo */
        .bg-logo {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            z-index: 0;
            pointer-events: none;
        }
        
        .bg-logo img {
            width: 400px;
        }
        
        /* Table */
        .table-container {
            position: relative;
            z-index: 1;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead th {
            background: #8B3A3A;
            color: white;
            padding: 12px 15px;
            text-align: center;
            font-weight: 500;
            font-size: 14px;
        }
        
        thead th:first-child {
            border-radius: 5px 0 0 5px;
        }
        
        thead th:last-child {
            border-radius: 0 5px 5px 0;
        }
        
        tbody td {
            padding: 15px;
            text-align: center;
            font-size: 14px;
            color: #333;
            border-bottom: 1px solid #eee;
        }
        
        /* Status Dropdown */
        .status-dropdown {
            position: relative;
            display: inline-block;
        }
        
        .status-btn {
            padding: 6px 25px;
            border-radius: 20px;
            border: none;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0 auto;
        }
        
        .status-btn.not-paid {
            background: #FFB347;
            color: #333;
        }
        
        .status-btn.paid {
            background: #90EE90;
            color: #333;
        }
        
        .status-btn.pending {
            background: #C5E384;
            color: #333;
        }
        
        .status-btn .arrow {
            font-size: 10px;
        }
        
        .status-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
            z-index: 100;
            min-width: 120px;
            overflow: hidden;
        }
        
        .status-menu.show {
            display: block;
        }
        
        .status-menu a {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            font-size: 13px;
        }
        
        .status-menu a:hover {
            background: #f5f5f5;
        }
        
        /* Filter Icon */
        .filter-icon {
            cursor: pointer;
            font-size: 18px;
            vertical-align: middle;
            margin-left: 5px;
        }
    </style>
</head>
<body>

<!-- Header -->
<header class="header">
    <div class="logo-section">
        <img src="../assets/logo.jpg" alt="Logo">
        <h2>ALPHA AQUILA</h2>
    </div>
    
    <nav class="nav">
        <a href="dashboard.php">Home</a>
        <a href="#">Insurance Inquiries</a>
        <a href="set_availability_ui.php">Set Availability</a>
        <a href="appointment_list.php" class="active">Appointment List</a>
        <a href="applicant_list.php">Applicant List</a>
    </nav>
    
    <div class="user-section">
        <span class="material-icons notification-icon">notifications</span>
        <div class="user-info">
            <strong><?php echo htmlspecialchars($user_name); ?></strong>
            <small><?php echo htmlspecialchars($user_role); ?></small>
        </div>
        <div class="profile-avatar">
            <img src="../assets/default_avatar.png" alt="Avatar" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;" onerror="this.style.display='none'; this.parentElement.innerHTML='LD';">
        </div>
    </div>
</header>

<!-- Main Content -->
<div class="main-content">
    <div class="card">
        <!-- Background Logo -->
        <div class="bg-logo">
            <img src="../assets/nobg_logo.png" alt="Background Logo">
        </div>
        
        <!-- Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Timestamp</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Transaction ID</th>
                        <th>Status <span class="material-icons filter-icon" id="statusFilter">filter_alt</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $payment): ?>
                    <tr>
                        <td><?= htmlspecialchars($payment[0]) ?></td>
                        <td><?= htmlspecialchars($payment[1]) ?></td>
                        <td><?= htmlspecialchars($payment[2]) ?></td>
                        <td><?= htmlspecialchars($payment[3]) ?></td>
                        <td><?= htmlspecialchars($payment[4]) ?></td>
                        <td>
                            <?php
                                switch($payment[5]) {
                                    case "Not Paid": $statusClass = "not-paid"; break;
                                    case "Paid": $statusClass = "paid"; break;
                                    case "Pending": $statusClass = "pending"; break;
                                    default: $statusClass = "pending";
                                }
                            ?>
                            <div class="status-dropdown">
                                <button class="status-btn <?= $statusClass ?>" onclick="toggleStatusMenu(this)">
                                    <?= htmlspecialchars($payment[5]) ?>
                                    <span class="arrow">▼</span>
                                </button>
                                <div class="status-menu">
                                    <a href="#" onclick="changeStatus(this, 'Not Paid', 'not-paid')">Not Paid</a>
                                    <a href="#" onclick="changeStatus(this, 'Paid', 'paid')">Paid</a>
                                    <a href="#" onclick="changeStatus(this, 'Pending', 'pending')">Pending</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function toggleStatusMenu(btn) {
        // Close all other menus
        document.querySelectorAll('.status-menu').forEach(menu => {
            if (menu !== btn.nextElementSibling) {
                menu.classList.remove('show');
            }
        });
        // Toggle current menu
        btn.nextElementSibling.classList.toggle('show');
    }
    
    function changeStatus(link, status, statusClass) {
        event.preventDefault();
        const dropdown = link.closest('.status-dropdown');
        const btn = dropdown.querySelector('.status-btn');
        
        // Update button text and class
        btn.className = 'status-btn ' + statusClass;
        btn.innerHTML = status + ' <span class="arrow">▼</span>';
        
        // Close menu
        link.closest('.status-menu').classList.remove('show');
        
        // TODO: Add AJAX call to update status in database
    }
    
    // Close menus when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.status-dropdown')) {
            document.querySelectorAll('.status-menu').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });
</script>

</body>
</html>
