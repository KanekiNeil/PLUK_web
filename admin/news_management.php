<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Alpha Aquila - News</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>

body{
background:#f5f6f8;
font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.container{
max-width:1200px;
margin-top:40px;
}

/* ADD BUTTON */

.add-news-wrapper{
display:flex;
justify-content:flex-end;
margin-bottom:30px;
}

.add-news-btn{
border-radius:25px;
padding:8px 18px;
font-weight:600;
display:flex;
align-items:center;
gap:6px;
}

/* NEWS CARDS */

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
transition:0.2s;
}

.news-card:hover{
transform:translateY(-6px);
box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

.news-card img{
width:100%;
height:100%;
object-fit:cover;
}

/* ACTION BUTTONS */

.card-actions{
position:absolute;
bottom:10px;
right:12px;
background:white;
padding:4px 10px;
border-radius:20px;
box-shadow:0 2px 8px rgba(0,0,0,0.15);
}

.card-actions i{
font-size:18px;
margin:0 5px;
cursor:pointer;
}

/* MODAL */

.modal-content{
border-radius:18px;
border:none;
}

.modal-header{
border-bottom:none;
padding:20px 25px;
}

.modal-title{
font-weight:700;
}

.modal-body{
padding:20px 30px;
}

.modal-footer{
border-top:none;
padding:15px 30px 25px;
}

/* FORM */

.form-label{
font-weight:600;
font-size:14px;
}

.custom-input{
border-radius:8px;
padding:9px;
font-size:14px;
}

/* IMAGE PREVIEW */

.image-preview{
width:100%;
height:180px;
border-radius:12px;
border:1px solid #ddd;
overflow:hidden;
display:flex;
align-items:center;
justify-content:center;
background:#fafafa;
margin-bottom:10px;
}

.image-preview img{
width:100%;
height:100%;
object-fit:cover;
}

/* UPLOAD BUTTON */

.upload-btn{
display:inline-flex;
align-items:center;
gap:6px;
padding:7px 14px;
border-radius:8px;
border:1px solid #ccc;
cursor:pointer;
font-size:14px;
background:#f8f8f8;
}

.upload-btn input{
display:none;
}

/* FOOTER BUTTONS */

.cancel-btn{
background:#8c0015;
color:white;
padding:7px 26px;
border-radius:20px;
border:none;
font-weight:600;
}

.save-btn{
background:#8c0015;
color:white;
padding:7px 30px;
border-radius:20px;
border:none;
font-weight:600;
}

.cancel-btn:hover,
.save-btn:hover{
background:#a3001c;
}

</style>
</head>

<body>

<div class="container">

<div class="add-news-wrapper">
<button class="btn btn-danger add-news-btn" id="addNewsBtn">
<i class="bi bi-plus-circle"></i> Add News
</button>
</div>

<div class="news-container">

<div class="news-card">

<img src="../assets/ro_hiring.jpg">

<div class="news-data d-none">
<h6 class="news-title">Top Financial Advisor</h6>
<p class="news-body">Congratulations to our outstanding financial advisor!</p>
</div>

<div class="card-actions">
<i class="bi bi-pencil text-success edit-btn"></i>
<i class="bi bi-trash text-danger delete-btn"></i>
</div>

</div>

</div>
</div>

<!-- ADD / EDIT NEWS MODAL -->

<div class="modal fade" id="addNewsModal">

<div class="modal-dialog modal-dialog-centered modal-lg">

<form id="addNewsForm">

<div class="modal-content">

<div class="modal-header">

<h4 class="modal-title">
<i class="bi bi-newspaper me-2 text-danger"></i>
Add News
</h4>

<button class="btn-close" data-bs-dismiss="modal"></button>

</div>

<div class="modal-body">

<div class="row">

<div class="col-md-7">

<div class="mb-3">
<label class="form-label">News Title</label>
<input type="text" class="form-control custom-input" id="newsHeading" required>
</div>

<div class="mb-3">
<label class="form-label">Description</label>
<textarea class="form-control custom-input" rows="4" id="newsBody" required></textarea>
</div>

<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">Date</label>
<input type="date" class="form-control custom-input" id="newsDate" required>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Time</label>
<input type="time" class="form-control custom-input" id="newsTime" required>
</div>

</div>

<div class="mb-3">
<label class="form-label">Location</label>
<input type="text" class="form-control custom-input" id="newsLocation" placeholder="Enter event location" required>
</div>

</div>

<div class="col-md-5">

<label class="form-label">News Poster</label>

<div class="image-preview">
<img id="previewImg" src="../assets/ro_hiring.jpg">
</div>

<label class="upload-btn">
<i class="bi bi-upload"></i> Upload Image
<input type="file" id="newsImage" required>
</label>

</div>

</div>

</div>

<div class="modal-footer">

<button type="button" class="cancel-btn" data-bs-dismiss="modal">
Cancel
</button>

<button type="submit" class="save-btn">
Save News
</button>

</div>

</div>

</form>

</div>
</div>

<!-- DELETE MODAL -->

<div class="modal fade" id="deleteModal">
<div class="modal-dialog modal-dialog-centered">

<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">
<i class="bi bi-exclamation-triangle text-danger me-2"></i>
Delete News
</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body text-center">
<p>Are you sure you want to delete this news?</p>
</div>

<div class="modal-footer">

<button class="btn btn-secondary" data-bs-dismiss="modal">
Cancel
</button>

<button class="btn btn-danger" id="confirmDelete">
Delete
</button>

</div>

</div>
</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script>

$(document).ready(function(){

let editCard = null;
let deleteCard = null;

/* OPEN ADD MODAL */

$('#addNewsBtn').click(function(){

editCard = null;

$('#addNewsForm')[0].reset();
$('#previewImg').attr('src',"../assets/ro_hiring.jpg");

var modal = new bootstrap.Modal(document.getElementById('addNewsModal'));
modal.show();

});

/* IMAGE PREVIEW */

$('#newsImage').on('change', function(e){

let file = e.target.files[0];

if(file){
let imgURL = URL.createObjectURL(file);
$('#previewImg').attr('src', imgURL);
}

});

/* SAVE NEWS */

$('#addNewsForm').submit(function(e){

e.preventDefault();

let title = $('#newsHeading').val().trim();
let body = $('#newsBody').val().trim();
let date = $('#newsDate').val();
let time = $('#newsTime').val();
let location = $('#newsLocation').val().trim();
let imageFile = $('#newsImage')[0].files[0];

if(title === "" || body === "" || date === "" || time === "" || location === "" || !imageFile){
alert("Please complete all fields before saving.");
return;
}

let img = URL.createObjectURL(imageFile);

if(editCard === null){

let card = `
<div class="news-card">

<img src="${img}">

<div class="news-data d-none">
<h6 class="news-title">${title}</h6>
<p class="news-body">${body}</p>
</div>

<div class="card-actions">
<i class="bi bi-pencil text-success edit-btn"></i>
<i class="bi bi-trash text-danger delete-btn"></i>
</div>

</div>
`;

$('.news-container').append(card);

}else{

editCard.find('.news-title').text(title);
editCard.find('.news-body').text(body);
editCard.find('img').attr('src', img);

}

$('#addNewsModal').modal('hide');
$('#addNewsForm')[0].reset();

});

/* EDIT NEWS */

$(document).on('click','.edit-btn',function(){

editCard = $(this).closest('.news-card');

let title = editCard.find('.news-title').text();
let body = editCard.find('.news-body').text();

$('#newsHeading').val(title);
$('#newsBody').val(body);

var modal = new bootstrap.Modal(document.getElementById('addNewsModal'));
modal.show();

});

/* DELETE NEWS */

$(document).on('click','.delete-btn',function(){

deleteCard = $(this).closest('.news-card');

var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
modal.show();

});

$('#confirmDelete').click(function(){

if(deleteCard){
deleteCard.remove();
}

$('#deleteModal').modal('hide');

});

});

</script>

</body>
</html>