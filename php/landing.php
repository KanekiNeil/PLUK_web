<?php
// Future PHP logic can go here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Alpha Aquila | Summit Life Insurance Agency</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>

<header>
    <div class="header-container">
        
        <div class="logo-title">
            <div class="logo-placeholder"></div>
            <h1>ALPHA AQUILA</h1>
        </div>

        <nav class="top-nav">
            <ul>
                <li><a href="#">Home</a></li>

                <li class="dropdown">
                    <a href="#">Work with Us</a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Sales</a></li>
                        <li><a href="#">Career</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#">Claim and Services</a>
                    <ul class="dropdown-menu">
                        <li><a href="#">PRUServices</a></li>
                        <li><a href="#">Make a Request</a></li>
                        <li><a href="#">Claims</a></li>
                        <li><a href="#">Policy Services Information</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#">Contact Us</a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Phone</a></li>
                        <li><a href="#">Email Address</a></li>
                        <li><a href="#">Address</a></li>
                    </ul>
                </li>

            </ul>
        </nav>

    </div>
</header>


<!-- ================= HERO SECTION ================= -->
<section class="hero">
    <div class="hero-content">
        <img src="../assets/logo.jpg" alt="Alpha Aquila Logo" class="hero-logo">

        <div class="hero-text">
            <h2>ALPHA AQUILA</h2>
            <h3>SUMMIT LIFE INSURANCE AGENCY</h3>
        </div>
    </div>
</section>

<!-- ================= PRIORITIES ================= -->
<section class="priorities-container">
    <h4>Priorities:</h4>

    <div class="priorities">
        <?php
        $priorities = [
            "PROTECTION",
            "EDUCATION",
            "RETIREMENT",
            "MEDIUM TO LONG TERM GOALS"
        ];

        foreach ($priorities as $title) {
            echo '
            <div class="priority-card">
                <div class="image-placeholder"></div>
                <p>'.$title.'</p>
            </div>
            ';
        }
        ?>
    </div>
</section>

<!-- ================= VIDEO SECTION ================= -->
<section class="video-section">
    <h4>Ready to seize the opportunity? 🌟</h4>
    <p>Discover how Pru Life UK can help you build a better future.</p>

    <div class="video-container">
        <iframe 
            src="https://www.youtube.com/embed/YOUR_VIDEO_ID"
            allowfullscreen>
        </iframe>
    </div>
</section>

<!-- ================= FOOTER ================= -->
<footer>
    <div class="footer-content">

        <div class="footer-column">
            <h5>PRU LIFE UK</h5>
            <p>
                Pru Life UK and Prudential plc are not affiliated with 
                Prudential Financial, Inc., a company whose principal place 
                of business is in the United States of America.
            </p>
        </div>

        <div class="footer-column">
            <h5>EXPLORE</h5>
            <a href="#">Careers</a>
            <a href="#">Corporate Social Responsibility</a>
            <a href="#">Build Your Business with PRU</a>
        </div>

        <div class="footer-column">
            <h5>CONNECT</h5>
            <a href="#">Facebook</a>
            <a href="#">LinkedIn</a>
        </div>

    </div>

    <div class="footer-bottom">
        Copyright © <?php echo date("Y"); ?> Pru Life UK. All rights reserved.
    </div>
</footer>



</body>
</html>