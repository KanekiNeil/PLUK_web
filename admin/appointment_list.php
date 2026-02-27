<?php
// $appointments = [
//     ["2026-03-01", "09:00 AM", "Juan Dela Cruz", "Career", "Pending"],
//     ["2026-03-01", "10:30 AM", "Maria Santos", "Career", "Approved"],
//     ["2026-03-02", "01:00 PM", "Pedro Reyes", "Sales", "Completed"],
//     ["2026-03-03", "03:00 PM", "Ana Lopez", "Sales", "Cancelled"],
//     ["2026-03-04", "11:00 AM", "Carlo Mendoza", "Sales", "Approved"]
// ];
?>

<!--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointment List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


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
-->

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>AppointmentList</title>
	<style>
		body {
			font-family: system-ui;
		}
		.absolute-image {
			position: absolute;
			top: 0px;
			left: 5px;
			width: 86px;
			height: 98px;
			object-fit: fill;
		}
		.box {
			flex: 1;
			align-self: stretch;
		}
		.box2 {
			width: 148px;
			height: 1px;
			background: #880318;
			margin-bottom: 222px;
			margin-left: 900px;
		}
		.box3 {
			width: 110px;
			height: 18px;
			background: #FFFFFF;
			margin-left: 515px;
		}
		.column {
			align-self: stretch;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			position: relative;
		}
		.column2 {
			align-self: stretch;
		}
		.column3 {
			align-self: stretch;
			align-items: flex-start;
			padding-bottom: 411px;
			background-image: url('https://storage.googleapis.com/tagjs-prod.appspot.com/v1/VEluO1e3Nv/3jymq8oa_expires_30_days.png');
			background-size: 100% 100%;
		}
		.column4 {
			max-width: 1234px;
			box-sizing: border-box;
			align-self: stretch;
			display: flex;
			flex-direction: column;
			padding-top: 4px;
			padding-bottom: 4px;
			margin-bottom: 18px;
			margin-left: 107px;
			margin-right: 194px;
			gap: 2px;
		}
		.column5 {
			align-self: stretch;
			background: #FFFDFD;
			border: 1px solid #D9D9D9;
			padding-top: 11px;
			padding-left: 70px;
			padding-right: 15px;
		}
		.contain {
			display: flex;
			flex-direction: column;
			background: #FFFFFF;
		}
		.image {
			width: 252px;
			height: 38px;
			margin-left: 91px;
			object-fit: fill;
		}
		.image2 {
			width: 36px;
			height: 38px;
			margin-right: 18px;
			object-fit: fill;
		}
		.image3 {
			width: 43px;
			height: 43px;
			margin-right: 50px;
			object-fit: fill;
		}
		.image4 {
			width: 9px;
			height: 9px;
			object-fit: fill;
		}
		.image5 {
			width: 42px;
			height: 39px;
			margin-right: 91px;
			object-fit: fill;
		}
		.image6 {
			width: 42px;
			height: 39px;
			object-fit: fill;
		}
		.image7 {
			width: 20px;
			height: 18px;
			margin-right: 9px;
			object-fit: fill;
		}
		.image8 {
			width: 21px;
			height: 18px;
			margin-right: 10px;
			object-fit: fill;
		}
		.image9 {
			width: 21px;
			height: 18px;
			margin-right: 11px;
			object-fit: fill;
		}
		.row-view {
			align-self: stretch;
			display: flex;
			align-items: center;
			background: #FFFFFF;
			border: 1px solid #00000040;
			padding-top: 18px;
			padding-bottom: 18px;
			box-shadow: 0px 0px 4px #00000040;
		}
		.row-view2 {
			max-width: 1039px;
			align-self: stretch;
			display: flex;
			align-items: center;
			margin-bottom: 2px;
			margin-left: 465px;
			margin-right: 31px;
		}
		.row-view3 {
			align-self: stretch;
			display: flex;
			align-items: center;
			margin-left: 89px;
			margin-right: 24px;
		}
		.row-view4 {
			align-self: stretch;
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 21px;
		}
		.row-view5 {
			flex-shrink: 0;
			display: flex;
			align-items: center;
			background: #FE9E75;
			border-radius: 15px;
			padding-top: 5px;
			padding-bottom: 5px;
		}
		.row-view6 {
			align-self: stretch;
			display: flex;
			align-items: center;
			margin-bottom: 27px;
		}
		.row-view7 {
			flex-shrink: 0;
			display: flex;
			align-items: center;
			background: #9FEB4D;
			border-radius: 15px;
			padding-top: 6px;
			padding-bottom: 6px;
		}
		.row-view8 {
			align-self: stretch;
			display: flex;
			align-items: flex-start;
			margin-bottom: 63px;
		}
		.row-view9 {
			flex-shrink: 0;
			display: flex;
			align-items: center;
			background: #FCFF59;
			border-radius: 15px;
			padding-top: 5px;
			padding-bottom: 5px;
		}
		.text {
			color: #000000;
			font-size: 17px;
			margin-right: 20px;
			width: 161px;
		}
		.text2 {
			color: #000000;
			font-size: 17px;
			font-weight: bold;
			margin-right: 40px;
		}
		.text3 {
			color: #000000;
			font-size: 17px;
			font-weight: bold;
			margin-right: 37px;
		}
		.text4 {
			color: #000000;
			font-size: 17px;
			font-weight: bold;
			margin-right: 39px;
		}
		.text5 {
			color: #000000;
			font-size: 17px;
			font-weight: bold;
		}
		.text6 {
			color: #FFFFFF;
			font-size: 20px;
			font-weight: bold;
		}
		.text7 {
			color: #FFFFFF;
			font-size: 20px;
			font-weight: bold;
			margin-right: 99px;
		}
		.text8 {
			color: #FFFFFF;
			font-size: 20px;
			font-weight: bold;
			margin-right: 3px;
		}
		.text9 {
			color: #FFFFFF;
			font-size: 20px;
			font-weight: bold;
			margin-right: 28px;
		}
		.text10 {
			color: #000000;
			font-size: 20px;
		}
		.text11 {
			color: #000000;
			font-size: 20px;
			margin-left: 32px;
			margin-right: 28px;
		}
		.text12 {
			color: #000000;
			font-size: 20px;
			margin-right: 111px;
		}
		.text13 {
			color: #000000;
			font-size: 20px;
			margin-left: 25px;
			margin-right: 21px;
		}
		.text14 {
			color: #000000;
			font-size: 20px;
			margin-right: 132px;
		}
		.text15 {
			color: #000000;
			font-size: 20px;
			margin-right: 117px;
		}
		.text16 {
			color: #000000;
			font-size: 20px;
			margin-left: 48px;
			margin-right: 27px;
		}
		.view {
			align-self: stretch;
			background: #FFFFFF;
			padding-bottom: 9px;
		}
	</style>
</head>
<body>
		<div class="contain">
		<div class="view">
			<div class="column">
				<div class="column2">
					<div class="row-view">
						<img
							src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/VEluO1e3Nv/52y01mi2_expires_30_days.png" 
							class="image"
						/>
						<div class="box">
						</div>
						<img
							src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/VEluO1e3Nv/7k5m3lbz_expires_30_days.png" 
							class="image2"
						/>
						<span class="text" >
							Levi De Guzman <br/>Junior Unit Manager
						</span>
						<img
							src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/VEluO1e3Nv/qt1h0hpt_expires_30_days.png" 
							class="image3"
						/>
					</div>
					<div class="column3">
						<div class="row-view2">
							<span class="text2" >
								Home
							</span>
							<span class="text3" >
								Insurance Inquiries
							</span>
							<span class="text3" >
								Set  Availability
							</span>
							<span class="text4" >
								Appointment List
							</span>
							<span class="text5" >
								Applicant List
							</span>
							<div class="box">
							</div>
							<img
								src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/VEluO1e3Nv/ziz0xfij_expires_30_days.png" 
								class="image4"
							/>
						</div>
						<div class="box2">
						</div>
						<div class="column4">
							<div class="row-view3">
								<span class="text6" >
									Date
								</span>
								<div class="box">
								</div>
								<span class="text6" >
									Time
								</span>
								<div class="box">
								</div>
								<span class="text7" >
									Full Name
								</span>
								<span class="text8" >
									Appointment Type
								</span>
								<img
									src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/VEluO1e3Nv/76lxmh53_expires_30_days.png" 
									class="image5"
								/>
								<span class="text9" >
									Status
								</span>
								<img
									src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/VEluO1e3Nv/08kukxjj_expires_30_days.png" 
									class="image6"
								/>
							</div>
							<div class="column5">
								<div class="row-view4">
									<span class="text10" >
										02/16/26
									</span>
									<span class="text10" >
										7:00-8:00 AM
									</span>
									<span class="text10" >
										Juan De La Cruz
									</span>
									<span class="text10" >
										Career
									</span>
									<div class="row-view5">
										<span class="text11" >
											Rescheduled
										</span>
										<img
											src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/VEluO1e3Nv/6ucm8eos_expires_30_days.png" 
											class="image7"
										/>
									</div>
								</div>
								<div class="row-view6">
									<span class="text10" >
										02/23/26
									</span>
									<div class="box">
									</div>
									<span class="text10" >
										1:00-2:00 PM
									</span>
									<div class="box">
									</div>
									<span class="text10" >
										Maria Santos
									</span>
									<div class="box">
									</div>
									<span class="text12" >
										Career
									</span>
									<div class="row-view7">
										<span class="text13" >
											Attended BYB
										</span>
										<img
											src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/VEluO1e3Nv/sbwbmh0d_expires_30_days.png" 
											class="image8"
										/>
									</div>
								</div>
								<div class="row-view8">
									<span class="text14" >
										02/27/26
									</span>
									<span class="text10" >
										3:00-4:00 PM
									</span>
									<div class="box">
									</div>
									<span class="text10" >
										Rizal Doe
									</span>
									<div class="box">
									</div>
									<span class="text15" >
										Sales
									</span>
									<div class="row-view9">
										<span class="text16" >
											Processing
										</span>
										<img
											src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/VEluO1e3Nv/bq9lsmcz_expires_30_days.png" 
											class="image9"
										/>
									</div>
								</div>
							</div>
						</div>
						<div class="box3">
						</div>
					</div>
				</div>
				<img
					src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/VEluO1e3Nv/e19b1a13_expires_30_days.png" 
					class="absolute-image"
				/>
			</div>
		</div>
	</div>
</body>
</html>