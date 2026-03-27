<?php
include_once "../php/session.php";

$user_name = "Levi De Guzman";
$user_role = "Junior Unit Manager";

$initials = strtoupper(substr($user_name, 0, 1)) .
            strtoupper(substr(strrchr($user_name, " "), 1, 1));
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Alpha Aquila - News</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
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

.container{
    max-width:1200px;
    margin-top:40px;
}

.add-news-wrapper{
    display:flex;
    justify-content:flex-end;
    margin-bottom:30px;
}

.news-container{
    display:flex;
    gap:40px;
    flex-wrap:wrap;
    justify-content:center;
}

.news-card{
    width:260px;
    height:380px;
    border:2px solid #dc3545;
    border-radius:18px;
    background:white;
    position:relative;
    overflow:hidden;
}

.news-card img{
    width:100%;
    height:100%;
    object-fit:cover;
}

/* enforce modal fixed width and stable text area */
.modal-dialog.custom-fixed {
    width: 1200px !important;
    max-width: 1200px !important;
    min-width: 1200px !important;
    margin: 20px auto !important;
}
.modal.show .modal-dialog.custom-fixed {
    transform: translate(0, 20px) !important;
}
.modal-content {
    width: 100%;
    min-width: 1200px !important;
}
#locationCaption {
    display: block;
    width: 100%;
    max-width: 100%;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.upload-poster-container img {
    max-width: 120px;
    max-height: 120px;
    object-fit: cover;
    border-radius: 8px;
}

@media (max-width: 1280px) {
    .modal-dialog {
        width: 90vw !important;
        max-width: 90vw !important;
    }
}

.card-actions{
    position:absolute;
    bottom:10px;
    right:12px;
    background:white;
    padding:4px 10px;
    border-radius:20px;
}
/* ================= HEADER FIX FOR DROPDOWN ================= */

/* Make sure header is always on top */
header {
    position: relative;
    z-index: 9999;
}

/* Allow dropdown to overflow properly */
.container,
.news-container {
    overflow: visible;
}

/* Prevent cards from clipping dropdown */
.news-card {
    overflow: visible; /* 🔥 CHANGED from hidden */
}

/* Ensure dropdown is above everything */
.profile-dropdown,
.notification-dropdown {
    z-index: 999;
}
</style>

</head>

<body>

<!-- SAME AS DASHBOARD -->
<?php include "../components/header.php"; ?>

<!-- MAIN CONTENT -->
<div class="container">

    <div class="add-news-wrapper">
        <button class="btn btn-danger" id="addNewsBtn">
            <i class="bi bi-plus-circle"></i> Add News
        </button>
    </div>

    <div class="news-container">

        <div class="news-card">
            <img src="../assets/ro_hiring.jpg">

            <div class="news-data d-none">
                <h6 class="news-title">Top Financial Advisor</h6>
                <p class="news-body">Congratulations!</p>
            </div>

            <div class="card-actions">
                <i class="bi bi-pencil text-success edit-btn"></i>
                <i class="bi bi-trash text-danger delete-btn"></i>
            </div>
        </div>

    </div>

</div>

<!-- MODALS (UNCHANGED) -->
<div class="modal fade" id="addNewsModal">
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable custom-fixed" style="width: 1100px; min-width: 1100px; max-width: 1100px; margin: 40px auto 20px auto;">
<form id="addNewsForm">
<div class="modal-content p-4" style="max-height: calc(100vh - 120px); overflow: hidden; border-radius: 20px; box-shadow: 0 8px 25px rgba(0,0,0,0.15);">

<div class="modal-header border-0 pb-0">
    <h5 class="modal-title">Add News Event</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body" style="overflow-y: auto; max-height: 65vh;">
    <!-- Event Title -->
    <div class="mb-3">
        <label class="form-label fw-bold">Event Title:</label>
        <input type="text" id="newsHeading" class="form-control" placeholder="Enter event title" required>
    </div>

    <!-- Description -->
    <div class="mb-3">
        <label class="form-label fw-bold">Description:</label>
        <textarea id="newsBody" class="form-control" rows="3" placeholder="Enter event description" required></textarea>
    </div>

    <!-- Date and Time Row -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Date:</label>
            <input type="date" id="newsDate" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Time:</label>
            <input type="time" id="newsTime" class="form-control" required>
        </div>
    </div>

    <!-- Location -->
    <div class="mb-3">
        <label class="form-label fw-bold">Location:</label>
        <div id="locationMap" style="width: 100%; height: 250px; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 10px;"></div>
        <input type="text" id="newsLocation" class="form-control" placeholder="Enter location or click on map" required>
        <p id="locationCaption" class="small text-muted mt-2">No location pinned yet.</p>
    </div>

    <!-- Upload a Poster -->
    <div class="mb-3">
        <label class="form-label fw-bold">Upload a Poster:</label>
        <div id="uploadPosterContainer" class="upload-poster-container border-2 border-dashed rounded p-3 text-center" style="cursor: pointer; border-color: #ddd; width: 140px; height: 140px; margin:auto;">
            <i class="bi bi-camera" style="font-size: 24px; color: #8B3A3A;"></i>
            <p class="mt-2 mb-0" style="font-size: 12px;">Click or drag</p>
            <input type="file" id="newsImage" class="form-control d-none" accept="image/*" required>
        </div>
        <div id="imagePreview" class="mt-2"></div>
    </div>
</div>

<div class="modal-footer border-0 pt-0" style="position: sticky; bottom: 0; background: #fff; z-index: 2;">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-danger">Save</button>
</div>

</form>
</div>
</div>

<div class="modal fade" id="deleteModal">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content p-3 text-center">

<p>Delete this news?</p>
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
<button class="btn btn-danger" id="confirmDelete">Delete</button>

</div>
</div>
</div>

<!-- SAME SCRIPT PLACEMENT AS DASHBOARD -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<script>
// Profile dropdown toggle
const profileToggle = document.getElementById("profileToggle");
if (profileToggle) {
    profileToggle.addEventListener("click", function (e) {
        e.stopPropagation();
        this.classList.toggle("active");
    });
}

// Close dropdown when clicking outside
document.addEventListener("click", function () {
    if (profileToggle) profileToggle.classList.remove("active");
});

// Initialize map
let map = null;
let marker = null;

function initializeMap() {
    if (map) return; // Already initialized
    
    setTimeout(() => {
        map = L.map('locationMap').setView([14.5994, 120.9842], 13); // Default to Metro Manila
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);
        
        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;
            const coordsText = `${lat.toFixed(5)}, ${lng.toFixed(5)}`;
            let caption = `Pinned location: ${coordsText}`;
            
            if (marker) {
                marker.setLatLng(e.latlng).setPopupContent(caption).openPopup();
            } else {
                marker = L.marker(e.latlng).addTo(map).bindPopup(caption).openPopup();
            }
            document.getElementById('newsLocation').value = caption;
            document.getElementById('locationCaption').innerText = caption;

            // Reverse geocode to a place name using Nominatim
            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                        if (data && data.address) {
                            const place = data.display_name || data.name || data.address.road || data.address.neighbourhood || data.address.village || coordsText;
                            const shortPlace = place.length > 70 ? place.slice(0, 70) + '...' : place;
                            caption = `Pinned location: ${shortPlace}`;
                            document.getElementById('newsLocation').value = caption;
                            document.getElementById('locationCaption').innerText = caption;
                            if (marker) marker.setPopupContent(caption).openPopup();
                        }
                    })
                .catch(() => {
                    // fallback already set
                });
        });
    }, 100);
}

// Handle modal show
document.getElementById('addNewsModal').addEventListener('shown.bs.modal', function() {
    initializeMap();
});

// File upload with preview
const uploadPosterContainer = document.getElementById('uploadPosterContainer');
const newsImageInput = document.getElementById('newsImage');
const imagePreview = document.getElementById('imagePreview');

function showUploadInput() {
    uploadPosterContainer.style.display = 'inline-flex';
    uploadPosterContainer.style.alignItems = 'center';
    uploadPosterContainer.style.justifyContent = 'center';
}

function hideUploadInput() {
    uploadPosterContainer.style.display = 'none';
}

function setPreviewImage(src) {
    imagePreview.innerHTML = `
        <div style="position: relative; display: inline-block; width: 120px; height: 120px;">
            <img src="${src}" style="width: 120px; height: 120px; object-fit: cover; border-radius: 5px;" />
            <button id="removeImage" type="button" style="position:absolute; top: -8px; right: -8px; width: 24px; height: 24px; border-radius: 50%; border:none; background:#dc3545; color:white; cursor:pointer;">×</button>
        </div>
    `;
    hideUploadInput();
    document.getElementById('removeImage').addEventListener('click', function() {
        newsImageInput.value = '';
        imagePreview.innerHTML = '';
        showUploadInput();
    });
}

uploadPosterContainer.addEventListener('click', function() {
    newsImageInput.click();
});

document.getElementById('newsImage').addEventListener('change', function(e) {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            setPreviewImage(event.target.result);
        };
        reader.readAsDataURL(file);
    }
});

// Drag and drop for file upload
const uploadContainer = document.querySelector('.upload-poster-container');
uploadContainer.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.style.backgroundColor = '#f0f0f0';
});

uploadContainer.addEventListener('dragleave', function() {
    this.style.backgroundColor = 'transparent';
});

uploadContainer.addEventListener('drop', function(e) {
    e.preventDefault();
    this.style.backgroundColor = 'transparent';
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        newsImageInput.files = files;
        const event = new Event('change', { bubbles: true });
        newsImageInput.dispatchEvent(event);
    }
});

$(function(){

let deleteCard = null;
let editingCard = null;

$('#addNewsBtn').click(function(){
    new bootstrap.Modal('#addNewsModal').show();
});

$(document).on('click', '.edit-btn', function(){
    editingCard = $(this).closest('.news-card');
    const data = editingCard.find('.news-data');
    const h6 = data.find('h6').text();
    const p = data.find('p').text();
    const s = data.find('small').map(function(){ return $(this).text(); }).get();

    $('#newsHeading').val(h6);
    $('#newsBody').val(p);
    const date = s[0] ? s[0].replace('Date: ', '') : '';
    const time = s[1] ? s[1].replace('Time: ', '') : '';
    const location = s[2] ? s[2].replace('Location: ', '') : '';

    $('#newsDate').val(date);
    $('#newsTime').val(time);
    $('#newsLocation').val(location);
    document.getElementById('locationCaption').innerText = location || 'No location pinned yet.';

    const currentImg = editingCard.find('img').attr('src');
    setPreviewImage(currentImg);
    new bootstrap.Modal('#addNewsModal').show();
});

$('#addNewsForm').submit(function(e){
    e.preventDefault();

    let title = $('#newsHeading').val();
    let body = $('#newsBody').val();
    let date = $('#newsDate').val();
    let time = $('#newsTime').val();
    let location = $('#newsLocation').val();
    let img = editingCard ? editingCard.find('img').attr('src') : '';
    if (!editingCard && $('#newsImage')[0].files[0]) {
        img = URL.createObjectURL($('#newsImage')[0].files[0]);
    }

    if (editingCard) {
        editingCard.find('img').attr('src', img);
        const nd = editingCard.find('.news-data');
        nd.find('h6').text(title);
        nd.find('p').text(body);
        nd.find('small').eq(0).text(`Date: ${date}`);
        nd.find('small').eq(1).text(`Time: ${time}`);
        nd.find('small').eq(2).text(`Location: ${location}`);
        editingCard = null;
    } else {
        $('.news-container').append(`
        <div class="news-card">
            <img src="${img}">
            <div class="news-data d-none">
                <h6>${title}</h6>
                <p>${body}</p>
                <small>Date: ${date}</small><br>
                <small>Time: ${time}</small><br>
                <small>Location: ${location}</small>
            </div>
            <div class="card-actions">
                <i class="bi bi-pencil text-success edit-btn"></i>
                <i class="bi bi-trash text-danger delete-btn"></i>
            </div>
        </div>
    `);
    }

    $('#addNewsModal').modal('hide');
    $('#addNewsForm')[0].reset();
    document.getElementById('imagePreview').innerHTML = '';
    showUploadInput();
});

$(document).on('click','.delete-btn',function(){
    deleteCard = $(this).closest('.news-card');
    new bootstrap.Modal('#deleteModal').show();
});

$('#confirmDelete').click(function(){
    deleteCard.remove();
    $('#deleteModal').modal('hide');
});

});
</script>

</body>
</html>