<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Company Website</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        /* Company logo section */
        .company-header {
            padding: 40px 0;
            text-align: center;
            background: #f8f9fa;
        }

        .company-header img {
            max-width: 120px;
            margin-bottom: 15px;
        }

        /* Carousel image height */
        .carousel-item img {
            height: 400px;
            object-fit: cover;
        }

        /* Video section */
        .video-section {
            padding: 60px 0;
            background: #f1f1f1;
        }

        /* Footer */
        footer {
            background: #212529;
            color: white;
            padding: 40px 0;
        }

        footer a {
            color: #adb5bd;
            text-decoration: none;
        }

        footer a:hover {
            color: white;
        }
    </style>
</head>
<body>

<!-- TOP NAVBAR -->
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

<!-- NAVLINKS BAR -->
<div class="bg-light border-bottom">
    <div class="container">
        <div class="collapse navbar-collapse justify-content-center py-2" id="mainNavbar">
            <ul class="nav justify-content-center">
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Work With Us</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Claims and Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
            </ul>
        </div>
    </div>
</div>

<!-- COMPANY LOGO + NAME -->
<div class="company-header d-flex align-items-center justify-content-center gap-4 text-start">
    <img src="https://via.placeholder.com/120" alt="Company Logo" class="img-fluid">

    <div>
        <h1 class="fw-bold mb-1">Company Name</h1>
        <p class="text-muted mb-0">Your trusted partner in services</p>
    </div>
</div>  

<!-- IMAGE CAROUSEL -->
<div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="https://picsum.photos/1200/400?1" class="d-block w-100" alt="Slide 1">
        </div>
        <div class="carousel-item">
            <img src="https://picsum.photos/1200/400?2" class="d-block w-100" alt="Slide 2">
        </div>
        <div class="carousel-item">
            <img src="https://picsum.photos/1200/400?3" class="d-block w-100" alt="Slide 3">
        </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- YOUTUBE IFRAME SECTION -->
<div class="video-section text-center">
    <div class="container">
        <h2 class="mb-4">Watch Our Introduction</h2>
        <div class="ratio ratio-16x9">
            <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" 
                    title="YouTube video"
                    allowfullscreen></iframe>
        </div>
    </div>
</div>

<?php include_once 'products_modal.php';
      include_once 'news_modal.php'; ?>

<!-- FOOTER -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h5>About Us</h5>
                <p>We provide high-quality services tailored to meet your needs.</p>
            </div>

            <div class="col-md-4 mb-3">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Work With Us</a></li>
                    <li><a href="#">Claims & Services</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>

            <div class="col-md-4 mb-3">
                <h5>Contact Information</h5>
                <p>Email: info@company.com</p>
                <p>Phone: +63 900 000 0000</p>
                <p>Address: Your City, Philippines</p>
            </div>
        </div>

        <hr class="border-light">

        <div class="text-center">
            <small>&copy; 2026 Company Name. All Rights Reserved.</small>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap 5 JS -->

<script>
    document.addEventListener('DOMContentLoaded', function () {

        // Select all carousel images
        const carouselImages = document.querySelectorAll('#mainCarousel .carousel-item img');

        // Create modal instance
        const infoModal = new bootstrap.Modal(document.getElementById('infoModal'));

        // Add click event to each image
        carouselImages.forEach(function (img) {
            img.style.cursor = "pointer"; // Optional: show pointer cursor
            img.addEventListener('click', function () {
                infoModal.show();
            });
        });

    });
</script>
<script>
    window.addEventListener('load', function () {
        var announcementModal = new bootstrap.Modal(
            document.getElementById('announcementModal')
        );
        announcementModal.show();
    });
</script>

</body>
</html>