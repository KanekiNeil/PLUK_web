<?php
// Example static data (replace with DB query)
$appointments = [
    ["Juan Dela Cruz", "09218471841", "UP", "Engineer", "Pasig", "Pending"],
    ["Maria Santos", "09123456789", "NU", "Teacher", "Mandaluyong", "Approved"],
    ["Pedro Reyes", "09876543210", "ADMU", "Unemployed", "Cavite", "Completed"],
    ["Ana Lopez", "09555555555", "UPLB", "Doctor", "Tondo", "Cancelled"],
    ["Carlo Mendoza", "09444444444", "BSU", "N/A", "Davao", "Approved"]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Applicant List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .status-badge {
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card shadow p-4">
        <h4 class="mb-4">Applicant List</h4>

        <table id="applicantTable" class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>    
                    <th>Complete Name</th>
                    <th>Contact Number</th>
                    <th>School Graduated</th>
                    <th>Current Job</th>
                    <th>Home Address</th>
                    <th>
                        Work Status
                        <button class="btn btn-sm btn-light ms-1 p-0" type="button" id="statusFilterBtn">
                            <i class="bi bi-funnel-fill"></i>
                        </button>
                        <div class="dropdown-menu" id="statusFilterMenu"></div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $appt): ?>
                    <tr>
                        <td><?= $appt[0] ?></td>
                        <td><?= $appt[1] ?></td>
                        <td><?= $appt[2] ?></td>
                        <td><?= $appt[3] ?></td>
                        <td><?= $appt[4] ?></td>

                        <td>
                            <?php
                                $statusClass = match($appt[5]) {
                                    "Pending" => "bg-warning text-dark",
                                    "Approved" => "bg-primary",
                                    "Completed" => "bg-success",
                                    "Cancelled" => "bg-danger",
                                    default => "bg-secondary"
                                };
                            ?>
                            <span class="badge <?= $statusClass ?> status-badge">
                                <?= $appt[5] ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Applicant Detail Modal -->
<?php include 'applicant_detail_modal.php'; ?>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#applicantTable').DataTable({
        responsive: true
    });

    $('#applicantTable tbody').on('click', 'tr', function () {
        var data = table.row(this).data();
        if (!data) return; // Skip if empty row (footer, etc)

        // Fill modal with data
        $('#modalName').text(data[0]);
        $('#modalContact').text(data[1]);
        $('#modalSchool').text(data[2]);
        $('#modalJob').text(data[3]);
        $('#modalAddress').text(data[4]);

        // Extract status text (remove badge HTML)
        var statusText = $('<div>').html(data[5]).text().trim();
        $('#modalStatus').text(statusText);

        // Show modal
        var modal = new bootstrap.Modal(document.getElementById('applicantModal'));
        modal.show();
    });

    // Helper: populate dropdown
    function populateFilter(columnIndex, menuId) {
        var uniqueData = table.column(columnIndex).data().unique().sort();
        var menu = $(menuId);
        menu.empty();
        menu.append('<a class="dropdown-item" href="#" data-value="">All</a>');

        uniqueData.each(function(d) {
            // Strip badge HTML if present
            var text = $('<div>').html(d).text().trim();
            menu.append('<a class="dropdown-item" href="#" data-value="' + text + '">' + text + '</a>');
        });

        // Handle click
        menu.find('a').on('click', function(e){
            e.preventDefault();
            var val = $(this).data('value');
            table.column(columnIndex).search(val ? '^' + val + '$' : '', true, false).draw();
        });
    }

    // Populate filters
    //populateFilter(3, '#typeFilterMenu');  // Appointment Type
    //populateFilter(5, '#statusFilterMenu'); // Status
});
</script>

</body>
</html> 