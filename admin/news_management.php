<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Alpha Aquila - News</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #fff;
            min-height: 100vh;
            padding-top: 20px;
            font-family: Arial, sans-serif;
        }

        .news-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: start;
        }

        .news-card {
            border: 1px solid #d32f2f;
            border-radius: 8px;
            width: 220px;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s;
        }

        .news-card:hover {
            transform: translateY(-5px);
        }

        .news-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .card-actions {
            display: flex;
            justify-content: flex-end;
            padding: 5px 10px;
            background-color: #fff;
        }

        .card-actions i {
            cursor: pointer;
            margin-left: 10px;
            font-size: 1.1rem;
        }

        .add-news-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 20px;
        }

        /* Centered logo watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            width: 300px;
        }
    </style>
</head>
<body>

<div class="container position-relative">

    <!-- Add News Button -->
    <button class="btn btn-danger add-news-btn mb-3">
        <i class="bi bi-plus-lg"></i> Add News
    </button>

    <!-- News Cards -->
    <div class="news-container">
        <div class="news-card" data-title="Top 2 Financial Advisor" data-desc="Congrats to our top advisors!" data-date="2025-05-01" data-time="09:00" data-location="Manila" data-img="https://via.placeholder.com/220x300.png?text=News+1">
            <img src="../assets/ro_hiring.jpg" alt="News Image">
            <div class="card-actions">
                <i class="bi bi-pencil text-success edit-btn"></i>
                <i class="bi bi-trash text-danger"></i>
            </div>
        </div>

        <div class="news-card" data-title="Upcoming Webinar" data-desc="Join our webinar on insurance tips" data-date="2025-06-15" data-time="14:00" data-location="Online" data-img="https://via.placeholder.com/220x300.png?text=News+2">
            <img src="../assets/ro_hiring.jpg" alt="News Image">
            <div class="card-actions">
                <i class="bi bi-pencil text-success edit-btn"></i>
                <i class="bi bi-trash text-danger"></i>
            </div>
        </div>
    </div>
</div>

<?php include 'events_modal.php'; ?>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script>
$(document).ready(function(){
    $('.edit-btn').click(function(){
        var card = $(this).closest('.news-card');

        // Populate form with card data
        $('#newsTitle').val(card.data('title'));
        $('#newsDesc').val(card.data('desc'));
        $('#newsDate').val(card.data('date'));
        $('#newsTime').val(card.data('time'));
        $('#newsLocation').val(card.data('location'));

        // Show modal
        var modal = new bootstrap.Modal(document.getElementById('editNewsModal'));
        modal.show();
    });

    // Example submit
    $('#editNewsForm').submit(function(e){
        e.preventDefault();
        alert('Changes saved! (Implement saving logic here)');
        $('#editNewsModal').modal('hide');
    });
});
</script>
</body>
</html>