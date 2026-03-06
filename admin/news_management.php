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
            background-color: #f8f9fa;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 40px;
        }

        .container {
            max-width: 1200px;
        }

        .add-news-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 30px;
        }

        .news-container {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
        }

        .news-card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            overflow: hidden;
            width: 250px;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
        }

        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }

        .news-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .card-body {
            padding: 15px;
            flex-grow: 1;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .card-text {
            font-size: 0.95rem;
            color: #555;
            margin-bottom: 12px;
        }

        .card-actions {
            display: flex;
            justify-content: flex-end;
            padding: 10px 15px;
            border-top: 1px solid #eee;
            background-color: #f9f9f9;
        }

        .card-actions i {
            cursor: pointer;
            font-size: 1.2rem;
            margin-left: 12px;
            transition: color 0.2s;
        }

        .card-actions i:hover {
            color: #d32f2f;
        }

        /* Modal Custom Styles */
        .modal-header {
            border-bottom: none;
        }

        .modal-title {
            font-weight: 600;
            font-size: 1.3rem;
        }

        .form-label {
            font-weight: 500;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-danger {
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-close {
            background-color: transparent;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Add News Button -->
    <button class="btn btn-danger add-news-btn" id="addNewsBtn">
        <i class="bi bi-plus-lg"></i> Add News
    </button>

    <!-- News Cards -->
    <div class="news-container">
        <div class="news-card" data-title="Top 2 Financial Advisor" data-desc="Congrats to our top advisors!" data-date="2025-05-01" data-time="09:00" data-location="Manila" data-img="../assets/ro_hiring.jpg">
            <img src="../assets/ro_hiring.jpg" alt="News Image">
            <div class="card-body">
                <div class="card-title">Top 2 Financial Advisor</div>
                <div class="card-text">Congrats to our top advisors!</div>
            </div>
            <div class="card-actions">
                <i class="bi bi-pencil text-success edit-btn"></i>
                <i class="bi bi-trash text-danger"></i>
            </div>
        </div>

        <div class="news-card" data-title="Upcoming Webinar" data-desc="Join our webinar on insurance tips" data-date="2025-06-15" data-time="14:00" data-location="Online" data-img="../assets/ro_hiring.jpg">
            <img src="../assets/ro_hiring.jpg" alt="News Image">
            <div class="card-body">
                <div class="card-title">Upcoming Webinar</div>
                <div class="card-text">Join our webinar on insurance tips</div>
            </div>
            <div class="card-actions">
                <i class="bi bi-pencil text-success edit-btn"></i>
                <i class="bi bi-trash text-danger"></i>
            </div>
        </div>
    </div>
</div>

<!-- Add News Modal -->
<div class="modal fade" id="addNewsModal" tabindex="-1" aria-labelledby="addNewsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form id="addNewsForm" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addNewsModalLabel">Add News</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="newsHeading" class="form-label">Heading</label>
                <input type="text" class="form-control" id="newsHeading" placeholder="Enter news heading" required>
            </div>
            <div class="mb-3">
                <label for="newsBody" class="form-label">Body</label>
                <textarea class="form-control" id="newsBody" rows="5" placeholder="Enter news details" required></textarea>
            </div>
            <div class="mb-3">
                <label for="newsImage" class="form-label">Upload Image</label>
                <input type="file" class="form-control" id="newsImage" accept="image/*" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger w-100">Post News</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script>
$(document).ready(function(){
    // Open Add News Modal
    $('#addNewsBtn').click(function(){
        var addModal = new bootstrap.Modal(document.getElementById('addNewsModal'));
        addModal.show();
    });

    // Form submission
    $('#addNewsForm').submit(function(e){
        e.preventDefault();
        alert('News Posted!');
        $('#addNewsModal').modal('hide');
        $('#addNewsForm')[0].reset();
    });

    // Edit existing news
    $('.edit-btn').click(function(){
        var card = $(this).closest('.news-card');
        $('#newsHeading').val(card.data('title'));
        $('#newsBody').val(card.data('desc'));
        var modal = new bootstrap.Modal(document.getElementById('addNewsModal'));
        modal.show();
    });
});
</script>

</body>
</html>