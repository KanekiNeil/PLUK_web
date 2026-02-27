<?php

// $availableDates = [
//     "2026-03-01",
//     "2026-03-03",
//     "2026-03-05",
//     "2026-03-08"
// ];

// $fullDates = [
//     "2026-03-02",
//     "2026-03-06"
// ];
// ?>

<!--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insurance Inquiry</title>
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
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark px-3">
        <a class="navbar-brand" href="#">
            <img src="https://via.placeholder.com/40" alt="Logo">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    <div class="container form-container">
        <div class="card shadow p-4">
            <h3 class="mb-4 text-center">Personal Information Form</h3>

            <form>
                ...
                (ALL YOUR FORM CONTENT HERE — still commented)
                ...
            </form>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
    // All JavaScript code here is also commented
</script>

</body>
</html>
-->

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sales1</title>
	<style>
		body {
			font-family: system-ui;
		}
		.absolute-box {
			position: absolute;
			bottom: 1px;
			right: -6px;
			left: -6px;
			height: 21px;
			align-self: stretch;
			background: #FFFFFF;
		}
		.absolute-box2 {
			position: absolute;
			top: 1px;
			left: 20px;
			width: 181px;
			height: 21px;
			background: #FFFFFF;
		}
		.absolute-box3 {
			position: absolute;
			bottom: -7px;
			left: 17px;
			width: 161px;
			height: 21px;
			background: #FFFFFF;
		}
		.box {
			flex: 1;
			align-self: stretch;
		}
		.box2 {
			width: 24px;
			box-sizing: border-box;
			height: 24px;
			box-sizing: border-box;
			background: #FFFFFF;
			border-radius: 1px;
			border: 1px solid #0000002E;
			box-shadow: 0px 0px 4px #00000040;
		}
		.button {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #FFFFFF;
			border-top-left-radius: 10px;
			border-bottom-left-radius: 10px;
			border: 1px solid #0000002E;
			padding: 21px 9px;
			margin-right: 12px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button2 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #FFFFFF;
			border-radius: 10px;
			border: 1px solid #0000002E;
			padding: 8px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button3 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #E2E0E0;
			border-radius: 10px;
			border: none;
			padding: 12px 36px;
			margin-right: 27px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button4 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #E2E0E0;
			border-radius: 10px;
			border: none;
			padding: 12px 38px;
			margin-right: 27px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button5 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #E2E0E0;
			border-radius: 10px;
			border: none;
			padding: 12px 36px;
			margin-right: 29px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button6 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #E2E0E0;
			border-radius: 10px;
			border: none;
			padding: 12px 37px;
			margin-right: 27px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button7 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #E2E0E0;
			border-radius: 10px;
			border: none;
			padding: 12px 39px;
			margin-right: 27px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button8 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #E2E0E0;
			border-radius: 10px;
			border: none;
			padding: 12px 40px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button9 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #E2DFDF;
			border-radius: 10px;
			border: none;
			padding: 12px 35px;
			margin-right: 24px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button10 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #E2E0E0;
			border-radius: 10px;
			border: none;
			padding: 12px 27px;
			margin-right: 27px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button11 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #E2E0E0;
			border-radius: 10px;
			border: none;
			padding: 12px 30px;
			margin-right: 29px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button12 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #E2E0E0;
			border-radius: 10px;
			border: none;
			padding: 12px 28px;
			margin-right: 27px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button13 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #E2E0E0;
			border-radius: 10px;
			border: none;
			padding: 12px 29px;
			margin-right: 27px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button14 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #E2E0E0;
			border-radius: 10px;
			border: none;
			padding: 12px 29px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button15 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #880318;
			border-radius: 10px;
			border: none;
			padding: 12px 29px;
			margin-right: 27px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button16 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #37FF00;
			border-radius: 10px;
			border: none;
			padding: 12px 27px;
			margin-right: 29px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button17 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #FFFFFF;
			border-radius: 10px;
			border: none;
			padding: 12px 27px;
			margin-right: 27px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button18 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #FFFFFF;
			border-radius: 10px;
			border: none;
			padding: 12px 26px;
			margin-right: 27px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button19 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #E2E0E0;
			border-radius: 10px;
			border: none;
			padding: 12px 30px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button20 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #E2DFDF;
			border-radius: 10px;
			border: none;
			padding: 12px 23px;
			margin-right: 27px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button21 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #FFFFFF;
			border-radius: 10px;
			border: none;
			padding: 12px 23px;
			margin-right: 27px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button22 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #FFFFFF;
			border-radius: 10px;
			border: none;
			padding: 12px 25px;
			margin-right: 27px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button23 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #FFFFFF;
			border-radius: 10px;
			border: none;
			padding: 12px 25px;
			margin-right: 29px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button24 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #FFFFFF;
			border-radius: 10px;
			border: none;
			padding: 12px 24px;
			margin-right: 27px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button25 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #FFFFFF;
			border-radius: 10px;
			border: none;
			padding: 12px 28px;
			margin-right: 27px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button26 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #E2E0E0;
			border-radius: 10px;
			border: none;
			padding: 12px 26px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button27 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #880318;
			border-radius: 30px;
			border: 1px solid #0000002E;
			padding: 13px 41px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button28 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #880318;
			border-radius: 30px;
			border: 1px solid #0000002E;
			padding: 13px 45px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.column {
			align-self: stretch;
			background: #FFFFFF;
			padding-bottom: 22px;
		}
		.column2 {
			align-self: stretch;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			padding-bottom: 23px;
			margin-bottom: 14px;
		}
		.column3 {
			max-width: 1275px;
			box-sizing: border-box;
			align-self: stretch;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #FFFFFF;
			border-radius: 10px;
			border: 1px solid #0000002E;
			padding-top: 17px;
			padding-bottom: 17px;
			margin-bottom: 17px;
			margin-left: auto;
			margin-right: auto;
			box-shadow: 0px 0px 4px #00000040;
		}
		.column4 {
			flex: 1;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
		}
		.column5 {
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			margin-left: 17px;
			position: relative;
		}
		.column6 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
		}
		.column7 {
			max-width: 1275px;
			box-sizing: border-box;
			align-self: stretch;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #FFFFFF;
			border-radius: 10px;
			border: 1px solid #0000002E;
			padding-top: 20px;
			padding-left: 19px;
			margin-bottom: 14px;
			margin-left: auto;
			margin-right: auto;
			box-shadow: 0px 0px 4px #00000040;
		}
		.column8 {
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			margin-bottom: 15px;
			position: relative;
		}
		.column9 {
			flex-shrink: 0;
			align-items: flex-start;
			position: relative;
		}
		.column10 {
			max-width: 1275px;
			box-sizing: border-box;
			align-self: stretch;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #FFFFFF;
			border-radius: 10px;
			border: 1px solid #0000002E;
			padding-top: 17px;
			margin-bottom: 77px;
			margin-left: auto;
			margin-right: auto;
			box-shadow: 0px 0px 4px #00000040;
		}
		.column11 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			gap: 2px;
		}
		.column12 {
			display: flex;
			flex-direction: column;
			align-items: center;
			background: #FFFFFF;
			border-radius: 30px;
			padding: 13px 3px;
			margin-bottom: 64px;
			margin-left: 102px;
			box-shadow: 0px 0px 4px #00000040;
		}
		.contain {
			display: flex;
			flex-direction: column;
			background: #FFFFFF;
		}
		.image {
			width: 252px;
			height: 38px;
			margin-left: 91px;
			object-fit: fill;
		}
		.image2 {
			width: 22px;
			height: 22px;
			margin-right: 37px;
			object-fit: fill;
		}
		.image3 {
			width: 86px;
			height: 98px;
			margin-left: 5px;
			object-fit: fill;
		}
		.image4 {
			width: 163px;
			height: 147px;
			margin-right: 115px;
			object-fit: fill;
		}
		.image5 {
			width: 25px;
			height: 25px;
			object-fit: fill;
		}
		.image6 {
			width: 17px;
			height: 17px;
			object-fit: fill;
		}
		.image7 {
			width: 20px;
			height: 15px;
			object-fit: fill;
		}
		.input {
			color: #000000;
			font-size: 20px;
			align-self: stretch;
			background: #FFFFFF;
			border-radius: 10px;
			border: 1px solid #0000002E;
			padding: 21px 19px;
			box-shadow: 0px 0px 4px #00000040;
		}
		.input2 {
			color: #000000;
			font-size: 20px;
			align-self: stretch;
			background: #FFFFFF;
			border-radius: 10px;
			border: 1px solid #0000002E;
			padding: 25px 23px;
			box-shadow: 0px 0px 4px #00000040;
		}
		.input3 {
			color: #000000;
			font-size: 20px;
			background: #FFFFFF;
			border-radius: 10px;
			border: 1px solid #0000002E;
			padding: 21px 22px;
			box-shadow: 0px 0px 4px #00000040;
		}
		.row-view {
			align-self: stretch;
			display: flex;
			align-items: center;
			background: #FFFFFF;
			border: 1px solid #0000002E;
			padding-top: 22px;
			padding-bottom: 22px;
			box-shadow: 0px 0px 4px #00000040;
		}
		.row-view2 {
			max-width: 1064px;
			align-self: stretch;
			display: flex;
			align-items: center;
			margin-bottom: 40px;
			margin-left: 23px;
			margin-right: 186px;
			gap: 29px;
		}
		.row-view3 {
			align-self: stretch;
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 28px;
			margin-left: 23px;
			margin-right: 23px;
		}
		.row-view4 {
			display: flex;
			align-items: flex-start;
			background: #FFFFFF;
			border-radius: 10px;
			border: 1px solid #0000002E;
			box-shadow: 0px 0px 4px #00000040;
		}
		.row-view5 {
			display: flex;
			align-items: center;
			background: #FFFFFF;
			border-radius: 10px;
			border: 1px solid #0000002E;
			padding: 8px 11px;
			margin-left: 23px;
			gap: 17px;
			box-shadow: 0px 0px 4px #00000040;
		}
		.row-view6 {
			display: flex;
			align-items: center;
			margin-bottom: 13px;
			gap: 12px;
		}
		.row-view7 {
			display: flex;
			align-items: center;
			margin-bottom: 12px;
			gap: 12px;
		}
		.row-view8 {
			display: flex;
			align-items: center;
			margin-bottom: 14px;
			gap: 12px;
		}
		.row-view9 {
			display: flex;
			align-items: center;
			margin-bottom: 59px;
			gap: 12px;
		}
		.row-view10 {
			display: flex;
			align-items: center;
			background: #FFFFFF;
			border: 1px solid #0000002E;
			padding: 11px 20px;
			margin-bottom: 12px;
			margin-left: 27px;
			gap: 17px;
			box-shadow: 0px 0px 4px #00000040;
		}
		.row-view11 {
			display: flex;
			align-items: center;
			background: #FFFFFF;
			border: 1px solid #0000002E;
			padding: 15px 8px;
			margin-bottom: 18px;
			margin-left: 27px;
			gap: 39px;
			box-shadow: 0px 0px 4px #00000040;
		}
		.row-view12 {
			display: flex;
			align-items: center;
			margin-bottom: 13px;
		}
		.row-view13 {
			display: flex;
			align-items: center;
			background: #880318;
			padding: 18px 48px;
			margin-bottom: 9px;
		}
		.row-view14 {
			display: flex;
			align-items: center;
			margin-bottom: 10px;
		}
		.row-view15 {
			display: flex;
			align-items: center;
			margin-bottom: 9px;
		}
		.row-view16 {
			display: flex;
			align-items: center;
		}
		.row-view17 {
			display: flex;
			align-items: center;
			margin-right: 125px;
			gap: 41px;
		}
		.text {
			color: #000000;
			font-size: 17px;
			font-weight: bold;
			margin-right: 242px;
		}
		.text2 {
			color: #000000;
			font-size: 40px;
			font-weight: bold;
			margin-bottom: 30px;
			margin-left: 149px;
		}
		.text3 {
			color: #000000;
			font-size: 20px;
			margin-left: 163px;
		}
		.text4 {
			color: #000000;
			font-size: 20px;
			font-weight: bold;
			margin-bottom: 41px;
			margin-left: 19px;
		}
		.text5 {
			color: #000000;
			font-size: 20px;
		}
		.text6 {
			color: #000000;
			font-size: 20px;
			margin-bottom: 15px;
		}
		.text7 {
			color: #000000;
			font-size: 20px;
			margin-top: 27px;
			margin-right: 151px;
		}
		.text8 {
			color: #000000;
			font-size: 20px;
			font-weight: bold;
			margin-bottom: 21px;
			margin-left: 23px;
		}
		.text9 {
			color: #000000;
			font-size: 15px;
		}
		.text10 {
			color: #000000;
			font-size: 20px;
			font-weight: bold;
			margin-bottom: 38px;
		}
		.text11 {
			color: #000000;
			font-size: 20px;
			font-weight: bold;
			margin-bottom: 17px;
			margin-left: 27px;
		}
		.text12 {
			color: #000000;
			font-size: 14px;
		}
		.text13 {
			color: #000000;
			font-size: 14px;
			margin-right: 90px;
		}
		.text14 {
			color: #880318;
			font-size: 40px;
			font-weight: bold;
			margin-right: 575px;
		}
		.text15 {
			color: #880318;
			font-size: 40px;
			font-weight: bold;
		}
		.text16 {
			color: #FFFFFF;
			font-size: 15px;
			font-weight: bold;
			margin-right: 59px;
		}
		.text17 {
			color: #FFFFFF;
			font-size: 15px;
			font-weight: bold;
			margin-right: 70px;
		}
		.text18 {
			color: #FFFFFF;
			font-size: 15px;
			font-weight: bold;
			margin-right: 51px;
		}
		.text19 {
			color: #FFFFFF;
			font-size: 15px;
			font-weight: bold;
			margin-right: 41px;
		}
		.text20 {
			color: #FFFFFF;
			font-size: 15px;
			font-weight: bold;
			margin-right: 63px;
		}
		.text21 {
			color: #FFFFFF;
			font-size: 15px;
			font-weight: bold;
			margin-right: 69px;
		}
		.text22 {
			color: #FFFFFF;
			font-size: 15px;
			font-weight: bold;
		}
		.text23 {
			color: #000000;
			font-size: 40px;
			font-weight: bold;
		}
		.text24 {
			color: #FFFFFF;
			font-size: 40px;
			font-weight: bold;
		}
		.text25 {
			color: #FFFFFF;
			font-size: 32px;
			font-weight: bold;
		}
		.view {
			align-self: stretch;
			display: flex;
			flex-direction: column;
			align-items: flex-end;
		}
		.view2 {
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #FFFFFF;
			padding: 2px 8px;
			margin-left: 10px;
		}
		.view3 {
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #FFFFFF;
			padding: 3px 7px;
			margin-left: 11px;
		}
		.view4 {
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #FFFFFF;
			padding: 2px 8px;
			margin-left: 10px;
			margin-right: 259px;
		}
		.view5 {
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #FFFFFF;
			border-radius: 10px;
			border: 1px solid #0000002E;
			padding-top: 27px;
			padding-left: 19px;
			padding-right: 118px;
			box-shadow: 0px 0px 4px #00000040;
		}
		.view6 {
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #FFFFFF;
			padding: 3px 8px;
			margin-left: 6px;
			margin-right: 173px;
		}
		.view7 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #E2DFDF;
			border-radius: 10px;
			padding: 12px 52px 12px 38px;
			margin-right: 27px;
			box-shadow: 0px 0px 4px #00000040;
		}
		.view8 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #E2DFDF;
			border-radius: 10px;
			padding: 12px 36px 12px 25px;
			margin-right: 27px;
			box-shadow: 0px 0px 4px #00000040;
		}
		.view9 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			background: #880318;
			border-radius: 10px;
			padding: 12px 37px 12px 26px;
			margin-right: 27px;
			box-shadow: 0px 0px 4px #00000040;
		}
	</style>
</head>
<body>
		<div class="contain">
		<div class="column">
			<div class="column2">
				<div class="row-view">
					<img
						src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/VEluO1e3Nv/s5qsna4x_expires_30_days.png" 
						class="image"
					/>
					<div class="box">
					</div>
					<span class="text" >
						Home
					</span>
					<img
						src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/VEluO1e3Nv/euld3dpl_expires_30_days.png" 
						class="image2"
					/>
				</div>
				<img
					src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/VEluO1e3Nv/9iirc7ex_expires_30_days.png" 
					class="image3"
				/>
				<div class="view">
					<img
						src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/VEluO1e3Nv/bqzvtdtt_expires_30_days.png" 
						class="image4"
					/>
				</div>
				<span class="text2" >
					Welcome to Alpha Aquila!
				</span>
				<span class="text3" >
					Follow these steps to successfully appoint your schedule:
				</span>
			</div>
			<div class="column3">
				<span class="text4" >
					Step 1: Fill Up Your Personal Information
				</span>
				<div class="row-view2">
					<div class="column4">
						<div class="view2">
							<span class="text5" >
								First Name:
							</span>
						</div>
						<input
							type="text"
							placeholder="Jane"
							class="input"
						/>
					</div>
					<div class="column4">
						<div class="view3">
							<span class="text5" >
								Last Name:
							</span>
						</div>
						<input
							type="text"
							placeholder="Doe"
							class="input2"
						/>
					</div>
					<div class="column4">
						<div class="column5">
							<span class="text5" >
								Middle Name:
							</span>
							<div class="absolute-box">
							</div>
						</div>
						<input
							type="text"
							placeholder="Cruz"
							class="input2"
						/>
					</div>
				</div>
				<div class="row-view3">
					<div class="column6">
						<div class="view4">
							<span class="text5" >
								Email:
							</span>
						</div>
						<div class="view5">
							<span class="text6" >
								jane_doe@gmail.com
							</span>
						</div>
					</div>
					<div class="column6">
						<div class="view6">
							<span class="text5" >
								Phone Number:
							</span>
						</div>
						<div class="row-view4">
							<button class="button"
								onclick="alert('Pressed!')"}>
								<span class="text5" >
									+63
								</span>
							</button>
							<span class="text7" >
								9123456789
							</span>
						</div>
					</div>
					<div class="column6">
						<div class="column5">
							<span class="text5" >
								Address:
							</span>
							<div class="absolute-box">
							</div>
						</div>
						<input
							type="text"
							placeholder="#168 Castueras Street Brgy.1 Calatagan Batangas"
							class="input3"
						/>
					</div>
				</div>
				<span class="text8" >
					Photo Verification
				</span>
				<div class="row-view5">
					<button class="button2"
						onclick="alert('Pressed!')"}>
						<img
							src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/VEluO1e3Nv/jzjr1w7z_expires_30_days.png" 
							class="image5"
						/>
					</button>
					<span class="text9" >
						Take a photo
					</span>
				</div>
			</div>
			<div class="column7">
				<span class="text10" >
					Step 2: Choose your Top 3 Priorities
				</span>
				<div class="column8">
					<span class="text5" >
						Priorities:
					</span>
					<div class="absolute-box2">
					</div>
				</div>
				<div class="row-view6">
					<div class="box2">
					</div>
					<span class="text5" >
						Protection
					</span>
				</div>
				<div class="row-view6">
					<div class="box2">
					</div>
					<span class="text5" >
						Education
					</span>
				</div>
				<div class="row-view7">
					<div class="column9">
						<div class="box2">
						</div>
						<div class="absolute-box3">
						</div>
					</div>
					<span class="text5" >
						Retirement
					</span>
				</div>
				<div class="row-view8">
					<div class="box2">
					</div>
					<span class="text5" >
						Medium to Long Term Goals
					</span>
				</div>
				<div class="row-view6">
					<div class="box2">
					</div>
					<span class="text5" >
						Ready Fund for Critical Illness
					</span>
				</div>
				<div class="row-view9">
					<div class="box2">
					</div>
					<span class="text5" >
						Estate Conservation
					</span>
				</div>
			</div>
			<div class="column10">
				<span class="text11" >
					Step 3: Schedule for Appointment
				</span>
				<div class="row-view10">
					<img
						src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/VEluO1e3Nv/tm0xtxl0_expires_30_days.png" 
						class="image6"
					/>
					<div class="column11">
						<span class="text12" >
							13 FEBRUARY 2026
						</span>
						<span class="text13" >
							Friday
						</span>
					</div>
				</div>
				<div class="row-view11">
					<span class="text12" >
						8:00 AM - 9:00 AM
					</span>
					<img
						src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/VEluO1e3Nv/v0jd2jmz_expires_30_days.png" 
						class="image7"
					/>
				</div>
				<div class="column12">
					<div class="row-view12">
						<span class="text14" >
							FEBRUARY
						</span>
						<span class="text15" >
							2026
						</span>
					</div>
					<div class="row-view13">
						<span class="text16" >
							SUNDAY
						</span>
						<span class="text17" >
							MONDAY
						</span>
						<span class="text18" >
							TUESDAY
						</span>
						<span class="text19" >
							WEDNESDAY
						</span>
						<span class="text20" >
							THURSDAY
						</span>
						<span class="text21" >
							FRIDAY
						</span>
						<span class="text22" >
							SATURDAY
						</span>
					</div>
					<div class="row-view14">
						<div class="view7">
							<span class="text23" >
								1
							</span>
						</div>
						<button class="button3"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								2
							</span>
						</button>
						<button class="button4"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								3
							</span>
						</button>
						<button class="button5"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								4
							</span>
						</button>
						<button class="button6"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								5
							</span>
						</button>
						<button class="button7"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								6
							</span>
						</button>
						<button class="button8"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								7
							</span>
						</button>
					</div>
					<div class="row-view12">
						<button class="button9"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								8
							</span>
						</button>
						<button class="button4"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								9
							</span>
						</button>
						<button class="button10"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								10
							</span>
						</button>
						<button class="button11"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								11
							</span>
						</button>
						<button class="button12"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								12
							</span>
						</button>
						<button class="button13"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								13
							</span>
						</button>
						<button class="button14"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								14
							</span>
						</button>
					</div>
					<div class="row-view15">
						<div class="view8">
							<span class="text23" >
								15
							</span>
						</div>
						<div class="view9">
							<span class="text24" >
								16
							</span>
						</div>
						<button class="button15"
							onclick="alert('Pressed!')"}>
							<span class="text24" >
								17
							</span>
						</button>
						<button class="button16"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								18
							</span>
						</button>
						<button class="button17"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								19
							</span>
						</button>
						<button class="button18"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								20
							</span>
						</button>
						<button class="button19"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								21
							</span>
						</button>
					</div>
					<div class="row-view16">
						<button class="button20"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								22
							</span>
						</button>
						<button class="button21"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								23
							</span>
						</button>
						<button class="button22"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								24
							</span>
						</button>
						<button class="button23"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								25
							</span>
						</button>
						<button class="button24"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								26
							</span>
						</button>
						<button class="button25"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								27
							</span>
						</button>
						<button class="button26"
							onclick="alert('Pressed!')"}>
							<span class="text23" >
								28
							</span>
						</button>
					</div>
				</div>
			</div>
			<div class="view">
				<div class="row-view17">
					<button class="button27"
						onclick="alert('Pressed!')"}>
						<span class="text25" >
							Cancel
						</span>
					</button>
					<button class="button28"
						onclick="alert('Pressed!')"}>
						<span class="text25" >
							Submit
						</span>
					</button>
				</div>
			</div>
		</div>
	</div>
</body>
</html>