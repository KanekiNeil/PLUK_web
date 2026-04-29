<?php

$_GET['type'] = 'applicant';
$availableDates = include '../php/get_available_dates.php';

$fullDates = [
    "2026-03-02",
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
        /* ================= GLOBAL ================= */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: #333;
        }

        /* ================= HEADER ================= */
        header {
            background: #ffffff;
            padding: 15px 40px;
            border-bottom: 1px solid #ddd;
            position: relative;
            z-index: 1000;
        }

        .header-container {
            display: flex;
            align-items: center;
        }


        .logo {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%; /* makes logo circular */
            border: 2px solid #8b0000; /* optional border color */
        }


        /* ================= LOGO ================= */
        .logo-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-title h1 {
            font-size: 14px;
            font-weight: 700;
        }


        /* ================= TOP NAVIGATION ================= */
        .top-nav ul {
            display: flex;
            list-style: none;
            gap: 50px;
            ;
        }

        .top-nav ul li {
            position: relative; 
        }

        .top-nav ul li a {
            text-decoration: none;
            color: #8b0000;
            font-weight: 600;
            font-size: 14px;
            padding: 10px 0;
            display: block;
            transition: 0.3s ease;
        }

        .top-nav ul li a:hover {
            opacity: 0.8;
        }

        .top-nav {
            margin-left: 500px;
        }

        /* ================= DROPDOWN ================= */
        .top-nav ul li .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            width: 200px;
            background: #ffffff;
            padding: 0;
            margin: 0;
            border-radius: 6px;
            box-shadow: 0 8px 18px rgba(0,0,0,0.06);

            display: block; /* vertical layout */
            opacity: 0;
            visibility: hidden;
            transform: translateY(5px);
            transition: all 0.2s ease;
            z-index: 999;
        }

        .top-nav ul li .dropdown-menu li a {
            text-align: left;
            padding: 10px 15px;
            display: block;
        }

        /* Show dropdown on hover */
        .top-nav ul li:hover > .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* Dropdown items */
        .dropdown-menu li {
            display: block;
            margin: 0; /* remove spacing between items */
            padding: 0;
            list-style: none;
        }

        .dropdown-menu li a {
            display: block;
            width: 100%;
            padding-left: 50px;
            padding: 6px 20px; /* spacing controlled here */
            font-size: 13px;
            font-weight: 500;
            color: #333;
            line-height: 1.2;
            text-decoration: none;
            white-space: nowrap;
            cursor: pointer;
        }

        .dropdown-menu li a:hover {
            background: #f3f3f3;
            color: #8b0000;
        }

        /* Dropdown arrow indicator */
        .dropdown > a::after {
            content: " ▼";
            font-size: 10px;
            margin-left: 4px;
            color: #8b0000;
        }


        /* PAGE BACKGROUND */
        body{
            background: linear-gradient(135deg,#f4f6f9,#e9eef5);
            font-family: 'Segoe UI', sans-serif;
        }

        /* FORM CONTAINER */
        .form-container{
            max-width: 850px;
            margin: 60px auto;
        }

        /* CARD DESIGN */
        .card{
            border-radius: 18px;
            border: none;
            box-shadow: 0 10px 35px rgba(0,0,0,0.08);
            padding: 35px;
        }

        /* TITLE */
        .card h3{
            font-weight: 600;
            margin-bottom: 25px;
        }

        /* INPUT FIELDS */
        .form-control{
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #dcdcdc;
            transition: all .3s;
        }

        .form-control:focus{
            border-color: #809bc4;
            box-shadow: 0 0 0 0.15rem rgba(13,110,253,.2);
        }

        /* LABELS */
        .form-label{
            font-weight: 500;
        }

        /* CAMERA SECTION */
        .camera-container{
            position: relative;
            width: 100%;
            max-width: 420px;
            margin: auto;
        }

        #video{
            width: 100%;
            border-radius: 12px;
            border: 2px solid #e5e5e5;
            transform: scaleX(-1);
        }

        /* FACE GUIDE */
        .face-circle{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 220px;
            height: 220px;
            border: 4px solid #00ffc8;
            border-radius: 50%;
            pointer-events: none;
            box-shadow: 0 0 12px rgba(0,255,200,0.7);
        }

        /* BUTTONS */
        #captureBtn{
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 500;
            background-color: #880318;
            color: white
        }

       #submitBtn{
            border-radius: 10px;
            padding:12px 30px;
            font-weight: 500;
            background-color: #880318;
            color: white;
            border: none;
            cursor: pointer;
            transition: 0.3s ease;
            border-radius: 50px;
            cursor:pointer;
        }


        #submitBtn:hover{
            background-color: #6d0212;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }


        .submit-container{
            display: flex;
            justify-content: flex-end;
            margin-top: 15px;
        }

        /* PREVIEW IMAGE */
        #preview{
            max-width: 200px;
            margin-top: 10px;
            border-radius: 10px;
            border: 2px solid #eee;
        }

 /* ================= CALENDAR ================= */
.calendar-container{
    margin-top:20px;
}

.calendar-header{
    text-align:center;
    margin-bottom:15px;
    font-size:20px;
    font-weight:bold;
    color:#880318;
}

.calendar-days{
    display:grid;
    grid-template-columns:repeat(7,1fr);
    background:#880318;
    color:white;
    text-align:center;
    padding:10px 0;
    border-radius:8px;
    font-weight:bold;
}

.calendar-dates{
    display:grid;
    grid-template-columns:repeat(7,1fr);
    gap:10px;
    margin-top:15px;
}

.calendar-btn{
    padding:12px 0;
    border:none;
    border-radius:8px;
    background:#e2e0e0;
    cursor:pointer;
}

/* Hover */
.calendar-btn:hover{
    background:#d6d6d6;
}

/* Selected */
.calendar-btn.active{
    background:#880318;
    color:white;
}

/* Available */
.calendar-btn.available{
    background:#d1e7dd;
}

/* Fully booked */
.calendar-btn.full{
    background:#f8d7da;
    cursor:not-allowed;
}

.calendar-nav{
    text-align:center;
    margin-bottom:10px;
}

/* ================= MODAL ================= */

.modal-overlay{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.4);
    display:flex;
    justify-content:center;
    align-items:center;
    z-index:9999;
}

.modal-box{
    background:white;
    width:420px;
    padding:30px;
    border-radius:16px;
    border:3px solid #f3f4f5;
    position:relative;
}

.modal-box h3{
    margin-bottom:10px;
}

.modal-box h4{
    margin-top:15px;
    margin-bottom:5px;
}

.modal-box ul{
    padding-left:18px;
}

.modal-box li{
    font-size:14px;
    margin-bottom:4px;
}

.close-btn{
    position:absolute;
    top:10px;
    right:15px;
    font-size:20px;
    cursor:pointer;
}



.apply-btn{
    margin-top:20px;
    width:100%;
    padding:10px;
    border:none;
    border-radius:20px;
    background:#880318;
    color:white;
    font-weight:600;
    cursor:pointer;
}

.apply-btn:hover{
    opacity:0.9;
}


    </style>
</head>
<body>
    
<?php include '../components/user_header.php'; ?>

<!-- ================= APPLICATION MODAL ================= -->
<div class="modal-overlay" id="applyModal">

    <div class="modal-box">

        <span class="close-btn" id="closeModal">&times;</span>

        <h3>Welcome, Applicants!</h3>

        <p>
        Take the next step toward a rewarding and flexible career opportunity. 
        Check the qualifications and exciting benefits below:
        </p>

        <h4>Qualifications</h4>
        <ul>
            <li>Not more than 45 years old</li>
            <li>At least Fourth Year Graduate</li>
            <li>Open to applicants nationwide</li>
            <li>Willing to learn and grow</li>
        </ul>

        <h4>Perks and Benefits</h4>
        <ul>
            <li>Fun and supportive work culture</li>
            <li>45% commission-based income</li>
            <li>HMO coverage</li>
            <li>Opportunity to build your own business</li>
            <li>Chance to lead a team in the future</li>
            <li>Potential monthly income of ₱30,000–₱50,000+</li>
            <li>Qualification for local and international travel incentives</li>
        </ul>

        <button class="apply-btn" id="applyNow">Apply</button>

    </div>

</div>


<div class="container form-container">
    <div class="card shadow p-4">
        <h3 class="mb-4 text-center">Personal Information Form</h3>

        <form id="applicationForm">

            <!-- PERSONAL INFO -->
            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control" placeholder="Enter first name">
            </div>

            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control" placeholder="Enter last name">
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email">
            </div>

            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="tel" name="phone" class="form-control" placeholder="Enter phone number">
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" placeholder="Enter address">
            </div>

            <div class="mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" name="birthdate" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Current Job</label>
                <input type="text" name="current_job" class="form-control" placeholder="Enter Current Job">
            </div>

            <div class="mb-3">
                <label class="form-label">School Graduated</label>
                <input type="text" name="school_graduated" class="form-control" placeholder="Enter school graduated">
            </div>

            <!-- UPLOAD WITH CAMERA ICON -->
            <h5 class="mt-4">Face Verification</h5>
                <hr>

                <div class="text-center">

                <div class="camera-container">
                <video id="video" autoplay playsinline></video>
                <div class="face-circle"></div>
                <canvas id="canvas" style="display:none;"></canvas>
                </div>

                <button type="button" class="btn" id="captureBtn">
                📷 Capture
                </button>

                <div class="mt-3">
                <img id="preview" style="display:none;">
                <input type="text" style="display: none;" name="face_image" id="faceImage">
                </div>

                </div>

            <!-- APPOINTMENT CALENDAR -->
              <h5 class="mt-4">Appointment Calendar</h5>
                <hr>

            <div class="calendar-container">
                <div class="calendar-header" id="calendarHeader"></div>
                <div class="calendar-nav">
                    <button type="button" id="toggleMonthBtn" class="btn btn-outline-secondary btn-sm" style="display:none;"></button>
                </div>

                <div class="calendar-days">
                    <div>SUN</div><div>MON</div><div>TUE</div>
                    <div>WED</div><div>THU</div><div>FRI</div><div>SAT</div>
                </div>

                <div class="calendar-dates" id="calendarDates"></div>

            </div>

            <input type="hidden" name="appointment_date" id="appointmentDate">
            <input type="hidden" name="available_date_id" id="availableDateId">
            <input type="hidden" name="meeting_link" id="meetingLink">
            <input type="hidden" name="application_type" value="applicant">

            <div class="text-center">
                <button type="submit" class="btn "id="submitBtn">
                    Submit
                </button>


            </div>

        </form>
    </div>
</div>

<!-- ================= JS ================= -->
<script>


const modal = document.getElementById("applyModal");
const applyBtn = document.getElementById("applyNow");
const closeBtn = document.getElementById("closeModal");
const form = document.getElementById("applicationForm");

// Apply button
applyBtn.addEventListener("click", () => {
    modal.style.display = "none";
    form.style.display = "block";
});

// Close modal
closeBtn.addEventListener("click", () => {
    modal.style.display = "none";
});
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2.34.0/dist/supabase.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", async () => {



    /* =========================
       📅 CALENDAR
    ========================== */

    const availableDatesRaw = <?php echo json_encode($availableDates); ?>;
    const fullDates = <?php echo json_encode($fullDates); ?>;

    const normalizedAvailableDates = (Array.isArray(availableDatesRaw) ? availableDatesRaw : [])
        .map((item) => {
            if (typeof item === "string") {
                return { id: null, date: item, meeting_link: null };
            }
            if (item && typeof item === "object" && item.date) {
                return { id: item.id ?? null, date: item.date, meeting_link: item.meeting_link ?? null };
            }
            return null;
        })
        .filter(Boolean);

    const availableDateSet = new Set(normalizedAvailableDates.map((item) => item.date));
    const availableDateIdMap = new Map(
        normalizedAvailableDates.map((item) => [item.date, item.id])
    );
    const availableDateMeetingLinkMap = new Map(
        normalizedAvailableDates.map((item) => [item.date, item.meeting_link])
    );

    const calendarDates = document.getElementById("calendarDates");
    const header = document.getElementById("calendarHeader");
    const toggleMonthBtn = document.getElementById("toggleMonthBtn");
    const appointmentInput = document.getElementById("appointmentDate");
    const availableDateIdInput = document.getElementById("availableDateId");
    const meetingLinkInput = document.getElementById("meetingLink");

    let selectedBtn = null;
    const today = new Date();

    function isLastWeekOfCurrentMonth(date) {
        const year = date.getFullYear();
        const month = date.getMonth();
        const lastDay = new Date(year, month + 1, 0).getDate();
        return date.getDate() > (lastDay - 7);
    }

    const canViewNextMonth = isLastWeekOfCurrentMonth(today);
    let monthOffset = 0;

    if (canViewNextMonth && toggleMonthBtn) {
        toggleMonthBtn.style.display = "inline-block";
    }

    function renderCalendar() {
        const displayDate = new Date(today.getFullYear(), today.getMonth() + monthOffset, 1);
        const month = displayDate.getMonth() + 1;
        const year = displayDate.getFullYear();

        const firstDay = new Date(year, month - 1, 1).getDay();
        const totalDays = new Date(year, month, 0).getDate();

        const monthNames = [
            "January","February","March","April","May","June",
            "July","August","September","October","November","December"
        ];

        header.textContent = `${monthNames[month-1]} ${year}`;
        if (toggleMonthBtn) {
            toggleMonthBtn.textContent = monthOffset === 0 ? "Show Next Month" : "Show Current Month";
        }

        calendarDates.innerHTML = "";
        selectedBtn = null;
        appointmentInput.value = "";
        if (availableDateIdInput) availableDateIdInput.value = "";
        if (meetingLinkInput) meetingLinkInput.value = "";

        for (let i = 0; i < firstDay; i++) {
            calendarDates.appendChild(document.createElement("div"));
        }

        for (let day = 1; day <= totalDays; day++) {

            const btn = document.createElement("button");
            btn.className = "calendar-btn";
            btn.type = "button";
            btn.textContent = day;

            const dateStr =
                `${year}-${String(month).padStart(2,"0")}-${String(day).padStart(2,"0")}`;
            const cellDate = new Date(year, month - 1, day);
            const todayStart = new Date(today.getFullYear(), today.getMonth(), today.getDate());
            const isPastDate = cellDate < todayStart;

            if (availableDateSet.has(dateStr)) {

                btn.classList.add("available");

            } else {

                btn.classList.add("unavailable");
                btn.disabled = true;

            }

            if (fullDates.includes(dateStr)) {

                btn.classList.remove("available");
                btn.classList.add("full");
                btn.disabled = true;

            }

            if (isPastDate) {
                btn.classList.remove("available");
                btn.classList.add("unavailable");
                btn.disabled = true;
            }

            btn.addEventListener("click", () => {

                if (selectedBtn) {
                    selectedBtn.classList.remove("active");
                }

                btn.classList.add("active");
                selectedBtn = btn;

                appointmentInput.value = dateStr;
                if (availableDateIdInput) {
                    availableDateIdInput.value = availableDateIdMap.get(dateStr) ?? "";
                }
                if (meetingLinkInput) {
                    meetingLinkInput.value = availableDateMeetingLinkMap.get(dateStr) ?? "";
                }

                Swal.fire({
                    icon: "info",
                    title: "Date Selected",
                    text: "Selected Date: " + dateStr,
                    timer: 1400,
                    showConfirmButton: false
                });
            });

            calendarDates.appendChild(btn);
        }
    }

    if (toggleMonthBtn) {
        toggleMonthBtn.addEventListener("click", () => {
            if (!canViewNextMonth) return;
            monthOffset = monthOffset === 0 ? 1 : 0;
            renderCalendar();
        });
    }

    renderCalendar();

    /* =========================
       📷 CAMERA
    ========================== */
    let faceDetected = false;

    const video = document.getElementById("video");
    const canvas = document.getElementById("canvas");
    const captureBtn = document.getElementById("captureBtn");
    const preview = document.getElementById("preview");
    const faceImage = document.getElementById("faceImage");
    const detectorOptions = new faceapi.TinyFaceDetectorOptions({
        inputSize: 128,
        scoreThreshold: 0.5
    });

    async function startCamera() {
        if (!video) return;

        try {

            const stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: "user" },
                audio: false
            });

            video.srcObject = stream;
            await video.play();

        } catch (err) {
            console.error(err);
            Swal.fire({
                icon: "error",
                title: "Camera Error",
                text: "Camera access denied or not supported."
            });
        }
    }
        async function loadFaceModel() {
            if (faceapi.tf && faceapi.tf.setBackend) {
                await faceapi.tf.setBackend("cpu");
                await faceapi.tf.ready();
            }

            await faceapi.nets.tinyFaceDetector.loadFromUri('../models/tiny_face_detector');
        }

    async function detectFace() {
        if (!video || video.readyState !== 4) return;

        const detection = await faceapi.detectSingleFace(
            video,
            detectorOptions
        );

        faceDetected = !!detection;

        // Optional UI feedback
        const circle = document.querySelector(".face-circle");
        if (circle) {
            circle.style.borderColor = faceDetected ? "lime" : "red";
        }
    }

    if (typeof faceapi === "undefined") {
        Swal.fire({
            icon: "error",
            title: "Face Library Missing",
            text: "face-api.js failed to load. Refresh the page or check the CDN connection."
        });
        return;
    }


    await Promise.all([
        startCamera(),
        loadFaceModel()
    ]);

    await detectFace();

    setInterval(detectFace, 300); // every 300ms

    if (captureBtn) {

        captureBtn.addEventListener("click", () => {

            if (!faceDetected) {
                Swal.fire({
                    icon: "warning",
                    title: "No Face Detected",
                    text: "Please position your face inside the circle."
                });
                return;
            }

            if (!video.videoWidth) {
                Swal.fire({
                    icon: "warning",
                    title: "Camera Not Ready",
                    text: "Camera not ready yet."
                });
                return;
            }

            const context = canvas.getContext("2d");

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const imageData = canvas.toDataURL("image/png");

            preview.src = imageData;
            preview.style.display = "block";

            faceImage.value = imageData;

            console.log("Face captured");
        });

    }

   

    const form = document.getElementById("applicationForm");

    if (form) {

        form.addEventListener("submit", async (e) => {

            if (!faceImage.value) {
                Swal.fire({
                    icon: "warning",
                    title: "Face Required",
                    text: "Please capture your face before submitting."
                });
                return;
            }

            e.preventDefault();

            if (form.dataset.submitting === "true") return;

            const appointmentDate = appointmentInput.value;
            const availableDateId = availableDateIdInput ? availableDateIdInput.value : "";

            if (!appointmentDate) {
                Swal.fire({
                    icon: "warning",
                    title: "Missing Appointment",
                    text: "Please select an appointment date."
                });
                return;
            }

            if (!availableDateId) {
                Swal.fire({
                    icon: "warning",
                    title: "Missing Date Reference",
                    text: "Please reselect an available appointment date."
                });
                return;
            }

            const submitBtn = form.querySelector("button[type='submit']");
            submitBtn.disabled = true;

            form.dataset.submitting = "true";

            try {

                const formData = new FormData(form);

                const response = await fetch("../php/submit_application.php", {
                    method: "POST",
                    body: formData
                });

                const data = await response.json();

                if (data.status === "success") {

                    const applicationId = data.application_id || "";

                    const copyText = async (text) => {
                        if (navigator.clipboard && window.isSecureContext) {
                            await navigator.clipboard.writeText(text);
                            return;
                        }

                        const tempInput = document.createElement("textarea");
                        tempInput.value = text;
                        tempInput.style.position = "fixed";
                        tempInput.style.left = "-9999px";
                        document.body.appendChild(tempInput);
                        tempInput.focus();
                        tempInput.select();
                        document.execCommand("copy");
                        document.body.removeChild(tempInput);
                    };

                    const swalConfig = {
                        icon: "success",
                        title: "Submitted",
                        text: data.message
                    };

                    if (applicationId) {
                        swalConfig.html = `
                            <p>${data.message}</p>
                            <p style="margin-top:8px;"><strong>Application ID:</strong><br>${applicationId}</p>
                        `;
                        swalConfig.showDenyButton = true;
                        swalConfig.denyButtonText = "Copy ID";
                        swalConfig.confirmButtonText = "Done";
                    }

                    const swalResult = await Swal.fire(swalConfig);

                    if (applicationId && swalResult.isDenied) {
                        await copyText(applicationId);
                        await Swal.fire({
                            icon: "success",
                            title: "Copied",
                            text: "Application ID copied to clipboard."
                        });
                    }

                    form.reset();
                    appointmentInput.value = "";
                    if (availableDateIdInput) availableDateIdInput.value = "";
                    if (meetingLinkInput) meetingLinkInput.value = "";

                    if (preview) preview.style.display = "none";

                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Submission Error",
                        text: data.message
                    });
                }

            } catch (err) {

                console.error(err);
                Swal.fire({
                    icon: "error",
                    title: "Request Failed",
                    text: "Something went wrong. Please try again."
                });

            }

            submitBtn.disabled = false;
            form.dataset.submitting = "false";

        });

    }

});
</script>
</body>
</html>