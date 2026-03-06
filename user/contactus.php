<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $policyowner = $_POST['policyowner'] ?? "";
    $name = $_POST['name'] ?? "";
    $email = $_POST['email'] ?? "";
    $messageText = $_POST['message'] ?? "";

    // Example processing (you can connect to database or send email)
    $message = "Thank you for contacting us, $name! We received your message.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Contact Us</title>

<style>

body{
    font-family: Arial, sans-serif;
    background:#f5f5f5;
    margin:0;
}

.container{
    width:1100px;
    margin:auto;
    padding:40px 0;
}

h1{
    text-align:center;
    background:#d9dde2;
    padding:15px;
}

.contact-wrapper{
    display:flex;
    gap:40px;
    margin-top:40px;
}

.left{
    flex:1;
}

.right{
    flex:1;
}

.right img{
    width:100%;
    border-radius:6px;
}

.radio-group{
    margin:10px 0 20px;
}

form input, form textarea{
    width:100%;
    padding:10px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:4px;
}

button{
    background:#8b0000;
    color:white;
    padding:10px 20px;
    border:none;
    cursor:pointer;
}

.contact-info{
    margin-top:40px;
    display:flex;
    justify-content:space-between;
}

.contact-info div{
    width:30%;
}

.success{
    background:#d4edda;
    padding:10px;
    margin-bottom:15px;
}

</style>
</head>

<body>

<h1>Contact Us</h1>

<div class="container">

<?php if($message != ""){ ?>
<div class="success"><?php echo $message; ?></div>
<?php } ?>

<div class="contact-wrapper">

<div class="left">

<h2>We'd love to hear from you</h2>

<form method="POST">

<label>Are you a Pru Life UK policyowner? *</label>

<div class="radio-group">
<input type="radio" name="policyowner" value="Yes"> Yes
<input type="radio" name="policyowner" value="No"> No
</div>

<input type="text" name="name" placeholder="Your Name" required>

<input type="email" name="email" placeholder="Your Email" required>

<textarea name="message" placeholder="Your Message" rows="5"></textarea>

<button type="submit">Send Message</button>

</form>

<p>Thank you for reaching out to us!</p>
<p>
For product or service inquiries, our support team is ready to assist you at  
<strong>+63 (2) 8887 5433</strong> or <strong>1-800-10-7785465</strong>.
</p>

</div>

<div class="right">
<img src="meeting.jpg" alt="meeting">
</div>

</div>

<div class="contact-info">

<div>
<h3>Phone</h3>
<p>PLDT Metro Manila<br>+63 (2) 8887 5433</p>

<p>Domestic Toll-free<br>
1 800 10 PRULINK (1 800 10 7785465)
</p>

<p>Globe Metro Manila<br>
+63 (2) 7793-5433
</p>
</div>

<div>
<h3>Email Address</h3>
<p style="color:red;">contact.us@prulifeuk.com.ph</p>
</div>

<div>
<h3>Address</h3>
<p>
Head Office<br>
9/F Uptown Place Tower 1,<br>
1 East 11th Drive,<br>
Uptown Bonifacio, Taguig City 1634,<br>
Metro Manila<br>
+63 (2) 8683 9000
</p>
</div>

</div>

</div>

</body>
</html>