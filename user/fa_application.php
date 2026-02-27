<?php
// Example: Fetch this from database in real usage
$availableDates = [
    "2026-03-01",
    "2026-03-03",
    "2026-03-05",
    "2026-03-08"
];

$fullDates = [
    "2026-03-02",
    "2026-03-06"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Advisors Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .form-container {
            max-width: 800px;
            margin: 50px auto;
        }

        .card {
            border-radius: 15px;
        }

        .skill-badge {
            margin-right: 5px;
            margin-bottom: 5px;
        }
                #calendar {
            max-width: 900px;
            margin: 40px auto;
        }

        .fc-day-full {
            background-color: #f8d7da !important;
            cursor: not-allowed;
        }

        .fc-day-available {
            background-color: #d1e7dd !important;
            cursor: pointer;
        }

        /* cam design */
        .camera-container {
            position: relative;
            width: 100%;
            max-width: 420px;
            margin: auto;
        }

        #video {
            width: 100%;
            border-radius: 12px;
        }

        /* CIRCLE FACE GUIDE */
        .face-circle {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 220px;  /* adjust size */
            height: 220px; /* keep it square for circle */
            border: 4px solid #00ffc8;
            border-radius: 50%;
            pointer-events: none; /* allow clicks through */
            box-shadow: 0 0 12px rgba(0,255,200,0.7);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark px-3">
        <!-- Logo Placeholder -->
        <a class="navbar-brand" href="#">
            <img src="https://via.placeholder.com/40" alt="Logo">
        </a>

        <!-- Burger Icon -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    <div class="container form-container">
    <div class="card shadow p-4">
        <h3 class="mb-4 text-center">Personal Information Form</h3>

        <form>

            <!-- PERSONAL INFO -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-control" placeholder="Enter first name">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" placeholder="Enter last name">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-control" placeholder="Enter email">
            </div>

            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="tel" class="form-control" placeholder="Enter phone number">
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" class="form-control" placeholder="Enter address">
            </div>

            <div class="mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" class="form-control" placeholder="Enter date of birth">
            </div>

            <div class="mb-3">
                <label class="form-label">Current Job</label>
                <input type="text" class="form-control" placeholder="Enter Current Job">
            </div>

            <div class="mb-3">
                <label class="form-label">School Graduated</label>
                <input type="text" class="form-control" placeholder="Enter school graduated">
            </div>

            <!-- UPLOAD WITH CAMERA ICON -->
            <div class="mb-3">
                <label class="form-label">Verify Face ID</label>

                <!-- Camera Preview -->
                <div class="camera-container">
                    <video id="video" autoplay playsinline></video>

                    <!-- CIRCLE FACE GUIDE -->
                    <div class="face-circle"></div>

                    <canvas id="canvas" style="display:none;"></canvas>
                </div>

                <!-- Capture Button -->
                <button type="button" class="btn btn-primary mt-2" id="captureBtn">
                    Capture Face
                </button>

                <!-- Preview Image -->
                <div class="mt-3">
                    <img id="preview" class="img-fluid rounded" style="display:none;">
                </div>

                <!-- Hidden input (image data for PHP) -->
                <input type="hidden" name="face_image" id="faceImage">
            </div>



            <!-- APPOINTMENT CALENDAR -->
            <div class="container">
                <h3 class="text-center mt-4">Set an Appointment</h3>
                <div id="calendar"></div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success px-4">
                    Submit
                </button>
            </div>

        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const addSkillBtn = document.getElementById('addSkillBtn');
    const skillInput = document.getElementById('skillInput');
    const skillsContainer = document.getElementById('skillsContainer');

    addSkillBtn.addEventListener('click', function () {
        const skillValue = skillInput.value.trim();

        if (skillValue !== '') {
            const badge = document.createElement('span');
            badge.className = 'badge bg-secondary skill-badge';
            badge.innerHTML = skillValue + ' <i class="bi bi-x ms-1" style="cursor:pointer;"></i>';

            // Remove skill on click
            badge.querySelector('i').addEventListener('click', function () {
                badge.remove();
            });

            skillsContainer.appendChild(badge);
            skillInput.value = '';
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const availableDates = <?php echo json_encode($availableDates); ?>;
        const fullDates = <?php echo json_encode($fullDates); ?>;

        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            selectable: true,

            dateClick: function(info) {
                const clickedDate = info.dateStr;

                if (fullDates.includes(clickedDate)) {
                    alert("This date is fully booked.");
                    return;
                }

                if (!availableDates.includes(clickedDate)) {
                    alert("Appointments not available on this date.");
                    return;
                }

                alert("You selected: " + clickedDate);
                // You can open modal here
            },

            dayCellDidMount: function(info) {
                const date = info.date.toISOString().split('T')[0];

                if (fullDates.includes(date)) {
                    info.el.classList.add('fc-day-full');
                } 
                else if (availableDates.includes(date)) {
                    info.el.classList.add('fc-day-available');
                }
            }
        });

        calendar.render();
    });


    // camera verification js.
    const video = document.getElementById("video");
    const canvas = document.getElementById("canvas");
    const captureBtn = document.getElementById("captureBtn");
    const preview = document.getElementById("preview");
    const faceImage = document.getElementById("faceImage");

    // Start Camera
    async function startCamera() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: "user"
                },
                audio: false
            });

            video.srcObject = stream;

            // wait until camera fully loads
            await video.play();

        } catch (err) {
            alert("Camera access denied or not supported.");
            console.error(err);
        }
    }

    startCamera();

    // Capture Photo
    captureBtn.addEventListener("click", () => {

        if (!video.videoWidth) {
            alert("Camera not ready yet.");
            return;
        }

        const context = canvas.getContext("2d");

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        const imageData = canvas.toDataURL("image/png");

        // Preview image
        preview.src = imageData;
        preview.style.display = "block";

        // Send to PHP
        faceImage.value = imageData;
    });
</script>
</body>
</html>