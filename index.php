
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Alpha Aquila | Summit Life Insurance Agency</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    

</head>
<body>

<?php include 'components/user_header.php'; ?>


<!-- ================= HERO SECTION ================= -->
<section class="hero">
    <div class="hero-content">
        <img src="assets/logo.jpg" alt="Alpha Aquila Logo" class="hero-logo">

        <div class="hero-text">
            <h2>ALPHA AQUILA</h2>
            <h3>SUMMIT LIFE INSURANCE AGENCY</h3>
        </div>
    </div>
</section>

<!-- ================= TOP SLIDE MODAL ================= -->
<div id="topModal" class="top-modal">
    <div class="top-modal-content">
        <span class="close-btn">&times;</span>

        <h2>ALPHA AQUILA</h2>

        <img src="assets/poster.jpg" alt="Top Financial Advisor Awarding">

        <h3>NEWS!</h3>
        <p><strong>TOP FINANCIAL ADVISOR AWARDING</strong></p>
        <p>March 15, 2026</p>
        <p>ATEL GLOBAL CORPORATE CENTER 20TH FLOOR</p>

        <p class="description">
            BREAKING: Top Financial Advisors of the Year Award ceremony celebrates excellence 
            in wealth management. Join us for an evening of recognition, networking, 
            and insights from industry leaders.
        </p>
    </div>
</div>


<!-- ================= PRIORITIES ================= -->
<section class="priorities-container">
    <h2>Priorities:</h2>

    <div class="carousel-wrapper">
        <button class="arrow left-arrow">&#10094;</button>

        <div class="priorities-carousel">
            <?php
            $priorities = [
                ["title" => "PROTECTION", "image" => "assets/Protection.png"],
                ["title" => "EDUCATION", "image" => "assets/Education.png"],
                ["title" => "RETIREMENT", "image" => "assets/Retirement.png"],
                ["title" => "MEDIUM TO LONG TERM GOALS", "image" => "assets/Goals.png"]
            ];

            foreach ($priorities as $priority) {
                echo '
                <div class="priority-card">
                    <img src="'.$priority['image'].'" 
                         class="priority-image" 
                         data-title="'.$priority['title'].'">

                    <p>'.$priority['title'].'</p>
                </div>
                ';
            }
            ?>
        </div>

        <button class="arrow right-arrow">&#10095;</button>
    </div>
</section>

<section>
<!-- PRIORITY MODAL -->
<div id="priorityModal" class="priority-modal">

  <div class="priority-modal-content">

    <span class="close-modal">&times;</span>

    <!-- HEADER -->
    <div class="priority-header">

        <div class="priority-text">
            <h3 id="modalTitle">PROTECTION</h3>

            <p id="modalDesc">
            A 2-year pay investment-linked insurance plan designed
            to protect high potential individuals in their prime
            investment flexibility for long-term security.
            </p>

            <button class="info-btn">See for more info</button>
        </div>

        <img id="modalImage" src="assets/protection.png">

    </div>


    <!-- ACCORDION PRODUCTS -->
    <div class="accordion">

    <!-- ITEM 1 -->
    <div class="accordion-item">

        <div class="accordion-header">
            PRULove for Life
            <span class="toggle-icon">+</span>
        </div>

        <div class="accordion-body">
            <p>
                Affordable premiums, payable in as easy as 5 years.
                Whole life insurance with guaranteed coverage up to age 100.
                This plan provides lifetime protection and financial security
                for you and your family.
            </p>
        </div>

    </div>


    <!-- ITEM 2 -->
    <div class="accordion-item">

        <div class="accordion-header">
            PRULifetime Income
            <span class="toggle-icon">+</span>
        </div>

        <div class="accordion-body">
            <p>
                A plan that provides guaranteed yearly income while
                maintaining protection and savings benefits.
            </p>
        </div>

    </div>


    <!-- ITEM 3 -->
    <div class="accordion-item">

        <div class="accordion-header">
            PRUSteady Income
            <span class="toggle-icon">+</span>
        </div>

        <div class="accordion-body">
            <p>
                Designed to help build a steady source of income for
                future financial needs.
            </p>
        </div>

    </div>


    <!-- ITEM 4 -->
    <div class="accordion-item">

        <div class="accordion-header">
            PRUWealth 10
            <span class="toggle-icon">+</span>
        </div>

        <div class="accordion-body">
            <p>
                A 10-year investment-linked plan designed to help grow
                your wealth while keeping you protected.
            </p>
        </div>

    </div>

</div>
</section>

<!-- ================= VIDEO SECTION ================= -->
<section class="video-section">
    <h4>Ready to seize the opportunity? 🌟</h4>
    <p>Discover how Pru Life UK can help you build a better future.</p>

    <div class="video-container">
        <iframe 
            width="100%" 
            height="400"
            src="https://www.youtube.com/embed/Eb6dL_XEwBU?autoplay=1&mute=1"
            frameborder="0"
            allow="autoplay; encrypted-media"
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



<script src="js/landing.js"></script>

</body>
</html>