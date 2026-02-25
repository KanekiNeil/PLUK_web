<?php
// Example static data (replace with DB query)
$appointments = [
    ["2026-03-01", "09:00 AM", "Juan Dela Cruz", "Career", "Pending"],
    ["2026-03-01", "10:30 AM", "Maria Santos", "Career", "Approved"],
    ["2026-03-02", "01:00 PM", "Pedro Reyes", "Sales", "Completed"],
    ["2026-03-03", "03:00 PM", "Ana Lopez", "Sales", "Cancelled"],
    ["2026-03-04", "11:00 AM", "Carlo Mendoza", "Sales", "Approved"]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointment List</title>
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
        <h4 class="mb-4">Appointment List</h4>

        <table id="appointmentTable" class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Full Name</th>
                    <th>
                        Appointment Type
                        <button class="btn btn-sm btn-light ms-1 p-0" type="button" id="typeFilterBtn">
                            <i class="bi bi-funnel-fill"></i>
                        </button>
                        <div class="dropdown-menu" id="typeFilterMenu"></div>
                    </th>
                    <th>
                        Status
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
                        <td>
                            <?php
                                $statusClass = match($appt[4]) {
                                    "Pending" => "bg-warning text-dark",
                                    "Approved" => "bg-primary",
                                    "Completed" => "bg-success",
                                    "Cancelled" => "bg-danger",
                                    default => "bg-secondary"
                                };
                            ?>
                            <span class="badge <?= $statusClass ?> status-badge">
                                <?= $appt[4] ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Appointment Detail Modal -->
<?php include 'appointment_detail_modal.php'; ?>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#appointmentTable').DataTable({
        responsive: true
    });

    $('#appointmentTable tbody').on('click', 'tr', function () {
        var data = table.row(this).data();
        if (!data) return; // Skip if empty row (footer, etc)

        // Fill modal with data
        $('#modalDate').text(data[0]);
        $('#modalTime').text(data[1]);
        $('#modalName').text(data[2]);
        $('#modalType').text(data[3]);

        // Extract status text (remove badge HTML)
        var statusText = $('<div>').html(data[4]).text().trim();
        $('#modalStatus').text(statusText);

        // Show modal
        var modal = new bootstrap.Modal(document.getElementById('appointmentModal'));
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
    populateFilter(3, '#typeFilterMenu');  // Appointment Type
    populateFilter(4, '#statusFilterMenu'); // Status
});
</script>

</body>
</html>