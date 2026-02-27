<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SetAvailability</title>
	<style>
		body {
			font-family: system-ui;
		}
		.absolute-box {
			position: absolute;
			bottom: 15px;
			right: -30px;
			width: 110px;
			height: 18px;
			background: #FFFFFF;
		}
		.absolute-view {
			position: absolute;
			top: 100px;
			right: 4px;
			left: 4px;
			align-self: stretch;
			background: #880318;
			padding: 16px 33px 16px 47px;
		}
		.box {
			flex: 1;
			align-self: stretch;
		}
		.box2 {
			width: 135px;
			height: 1px;
			background: #880318;
		}
		.button {
			flex: 1;
			display: flex;
			flex-direction: column;
			align-items: center;
			background: #E2DFDF;
			border-radius: 10px;
			border: none;
			padding-top: 14px;
			padding-bottom: 14px;
			margin-right: 65px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button2 {
			flex: 1;
			display: flex;
			flex-direction: column;
			align-items: center;
			background: #E2DFDF;
			border-radius: 10px;
			border: none;
			padding-top: 14px;
			padding-bottom: 14px;
			margin-right: 77px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button3 {
			flex: 1;
			display: flex;
			flex-direction: column;
			align-items: center;
			background: #E2DFDF;
			border-radius: 10px;
			border: none;
			padding-top: 14px;
			padding-bottom: 14px;
			margin-right: 78px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button4 {
			flex: 1;
			display: flex;
			flex-direction: column;
			align-items: center;
			background: #E2DFDF;
			border-radius: 10px;
			border: none;
			padding-top: 14px;
			padding-bottom: 14px;
			margin-right: 59px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button5 {
			flex: 1;
			display: flex;
			flex-direction: column;
			align-items: center;
			background: #E2DFDF;
			border-radius: 10px;
			border: none;
			padding-top: 14px;
			padding-bottom: 14px;
			margin-right: 62px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button6 {
			flex: 1;
			display: flex;
			flex-direction: column;
			align-items: center;
			background: #E2DFDF;
			border-radius: 10px;
			border: none;
			padding-top: 14px;
			padding-bottom: 14px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button7 {
			align-self: stretch;
			display: flex;
			flex-direction: column;
			align-items: center;
			background: #E2DFDF;
			border-radius: 10px;
			border: none;
			padding-top: 14px;
			padding-bottom: 14px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button8 {
			flex: 1;
			display: flex;
			flex-direction: column;
			align-items: center;
			background: #880318;
			border-radius: 10px;
			border: none;
			padding-top: 24px;
			padding-bottom: 24px;
			margin-right: 77px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button9 {
			flex: 1;
			display: flex;
			flex-direction: column;
			align-items: center;
			background: #880318;
			border-radius: 10px;
			border: none;
			padding-top: 24px;
			padding-bottom: 24px;
			margin-right: 78px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button10 {
			flex: 1;
			display: flex;
			flex-direction: column;
			align-items: center;
			background: #37FF00;
			border-radius: 10px;
			border: none;
			padding-top: 24px;
			padding-bottom: 24px;
			margin-right: 77px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button11 {
			flex: 1;
			display: flex;
			flex-direction: column;
			align-items: center;
			background: #E2DFDF;
			border-radius: 10px;
			border: none;
			padding-top: 25px;
			padding-bottom: 25px;
			margin-right: 59px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button12 {
			flex: 1;
			display: flex;
			flex-direction: column;
			align-items: center;
			background: #E2DFDF;
			border-radius: 10px;
			border: none;
			padding-top: 15px;
			padding-bottom: 15px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button13 {
			flex: 1;
			display: flex;
			flex-direction: column;
			align-items: center;
			background: #E2DFDF;
			border-radius: 10px;
			border: none;
			padding-top: 24px;
			padding-bottom: 24px;
			margin-right: 77px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button14 {
			flex: 1;
			display: flex;
			flex-direction: column;
			align-items: center;
			background: #E2DFDF;
			border-radius: 10px;
			border: none;
			padding-top: 24px;
			padding-bottom: 24px;
			margin-right: 78px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.button15 {
			flex: 1;
			display: flex;
			flex-direction: column;
			align-items: center;
			background: #E2DFDF;
			border-radius: 10px;
			border: none;
			padding-top: 24px;
			padding-bottom: 24px;
			margin-right: 62px;
			box-shadow: 0px 0px 4px #00000040;
			text-align: left;
		}
		.column {
			align-self: stretch;
			background: #FFFFFF;
			padding-bottom: 76px;
		}
		.column2 {
			align-self: stretch;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			margin-bottom: 71px;
		}
		.column3 {
			flex-shrink: 0;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			margin-right: 31px;
			gap: 2px;
		}
		.column4 {
			align-self: stretch;
			margin-left: 81px;
			margin-right: 81px;
			position: relative;
		}
		.column5 {
			align-self: stretch;
			background: #FFFFFF;
			border-radius: 30px;
			padding-top: 31px;
			padding-bottom: 31px;
			box-shadow: 0px 0px 4px #00000040;
		}
		.column6 {
			flex: 1;
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			margin-right: 78px;
			position: relative;
		}
		.contain {
			display: flex;
			flex-direction: column;
			background: #FFFFFF;
		}
		.image {
			width: 252px;
			height: 38px;
			object-fit: fill;
		}
		.image2 {
			width: 36px;
			height: 38px;
			margin-right: 11px;
			object-fit: fill;
		}
		.image3 {
			width: 43px;
			height: 43px;
			margin-right: 4px;
			object-fit: fill;
		}
		.image4 {
			width: 9px;
			height: 9px;
			margin-right: 37px;
			object-fit: fill;
		}
		.image5 {
			width: 86px;
			height: 98px;
			margin-left: 5px;
			object-fit: fill;
		}
		.row-view {
			align-self: stretch;
			display: flex;
			align-items: center;
			background: #FFFFFF;
			border: 1px solid #00000040;
			padding-top: 18px;
			padding-bottom: 18px;
			box-shadow: 0px 0px 4px #00000040;
		}
		.row-view2 {
			align-self: stretch;
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 12px;
			margin-left: 45px;
			margin-right: 61px;
		}
		.row-view3 {
			align-self: stretch;
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 67px;
			margin-left: 71px;
			margin-right: 71px;
		}
		.row-view4 {
			align-self: stretch;
			display: flex;
			align-items: center;
			margin-bottom: 54px;
			margin-left: 51px;
			margin-right: 34px;
		}
		.row-view5 {
			align-self: stretch;
			display: flex;
			align-items: center;
			margin-bottom: 58px;
			margin-left: 51px;
			margin-right: 34px;
		}
		.row-view6 {
			align-self: stretch;
			display: flex;
			align-items: center;
			margin-bottom: 45px;
			margin-left: 51px;
			margin-right: 34px;
		}
		.row-view7 {
			align-self: stretch;
			display: flex;
			align-items: center;
			margin-left: 51px;
			margin-right: 34px;
		}
		.row-view8 {
			align-self: stretch;
			display: flex;
			align-items: center;
		}
		.text {
			color: #000000;
			font-size: 17px;
			font-weight: bold;
			margin-right: 40px;
		}
		.text2 {
			color: #000000;
			font-size: 17px;
			font-weight: bold;
			margin-right: 32px;
		}
		.text3 {
			color: #000000;
			font-size: 17px;
			font-weight: bold;
		}
		.text4 {
			color: #000000;
			font-size: 17px;
			font-weight: bold;
			margin-right: 39px;
		}
		.text5 {
			color: #000000;
			font-size: 17px;
			font-weight: bold;
			margin-right: 21px;
		}
		.text6 {
			color: #000000;
			font-size: 17px;
			margin-right: 20px;
			width: 161px;
		}
		.text7 {
			color: #880318;
			font-size: 48px;
			font-weight: bold;
		}
		.text8 {
			color: #FFFFFF;
			font-size: 32px;
			font-weight: bold;
		}
		.text9 {
			color: #000000;
			font-size: 48px;
			font-weight: bold;
		}
		.text10 {
			color: #FFFFFF;
			font-size: 48px;
			font-weight: bold;
		}
		.text11 {
			color: #FFFFFF;
			font-size: 32px;
			font-weight: bold;
			margin-right: 35px;
		}
		.text12 {
			color: #FFFFFF;
			font-size: 32px;
			font-weight: bold;
			text-align: center;
			margin-right: 38px;
			flex: 1;
		}
		.text13 {
			color: #FFFFFF;
			font-size: 32px;
			font-weight: bold;
			text-align: center;
			margin-right: 37px;
			flex: 1;
		}
		.text14 {
			color: #FFFFFF;
			font-size: 32px;
			font-weight: bold;
			text-align: center;
			margin-right: 32px;
			flex: 1;
		}
		.text15 {
			color: #FFFFFF;
			font-size: 32px;
			font-weight: bold;
			margin-right: 27px;
		}
		.text16 {
			color: #FFFFFF;
			font-size: 32px;
			font-weight: bold;
			text-align: center;
			flex: 1;
		}
	</style>
</head>
<body>
		<div class="contain">
		<div class="column">
			<div class="column2">
				<div class="row-view">
					<div class="box">
					</div>
					<img
						src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/s6A0b3ZqTp/33ppz0q8_expires_30_days.png" 
						class="image"
					/>
					<div class="box">
					</div>
					<span class="text" >
						Home
					</span>
					<span class="text2" >
						Insurance Inquiries
					</span>
					<div class="column3">
						<span class="text3" >
							Set  Availability
						</span>
						<div class="box2">
						</div>
					</div>
					<span class="text4" >
						Appointment List
					</span>
					<span class="text5" >
						Applicant List
					</span>
					<img
						src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/s6A0b3ZqTp/9at8qon6_expires_30_days.png" 
						class="image2"
					/>
					<span class="text6" >
						Levi De Guzman <br/>Junior Unit Manager
					</span>
					<img
						src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/s6A0b3ZqTp/63fzmw5m_expires_30_days.png" 
						class="image3"
					/>
					<img
						src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/s6A0b3ZqTp/sotpspzb_expires_30_days.png" 
						class="image4"
					/>
				</div>
				<img
					src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/s6A0b3ZqTp/s4aw7yny_expires_30_days.png" 
					class="image5"
				/>
			</div>
			<div class="column4">
				<div class="column5">
					<div class="row-view2">
						<span class="text7" >
							FEBRUARY
						</span>
						<span class="text7" >
							2026
						</span>
					</div>
					<div class="row-view3">
						<span class="text8" >
							Sun
						</span>
						<span class="text8" >
							Mon
						</span>
						<span class="text8" >
							Tue
						</span>
						<span class="text8" >
							Wed
						</span>
						<span class="text8" >
							Thur
						</span>
						<span class="text8" >
							Fri
						</span>
						<span class="text8" >
							Sat
						</span>
					</div>
					<div class="row-view4">
						<button class="button"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								1
							</span>
						</button>
						<button class="button2"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								2
							</span>
						</button>
						<button class="button3"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								3
							</span>
						</button>
						<button class="button2"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								4
							</span>
						</button>
						<button class="button4"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								5
							</span>
						</button>
						<button class="button5"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								6
							</span>
						</button>
						<button class="button6"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								7
							</span>
						</button>
					</div>
					<div class="row-view5">
						<button class="button"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								8
							</span>
						</button>
						<button class="button2"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								9
							</span>
						</button>
						<div class="column6">
							<button class="button7"
								onclick="alert('Pressed!')"}>
								<span class="text9" >
									10
								</span>
							</button>
							<div class="absolute-box">
							</div>
						</div>
						<button class="button2"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								11
							</span>
						</button>
						<button class="button4"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								12
							</span>
						</button>
						<button class="button5"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								13
							</span>
						</button>
						<button class="button6"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								14
							</span>
						</button>
					</div>
					<div class="row-view6">
						<button class="button"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								15
							</span>
						</button>
						<button class="button8"
							onclick="alert('Pressed!')"}>
							<span class="text10" >
								16
							</span>
						</button>
						<button class="button9"
							onclick="alert('Pressed!')"}>
							<span class="text10" >
								17
							</span>
						</button>
						<button class="button10"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								18
							</span>
						</button>
						<button class="button11"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								19
							</span>
						</button>
						<button class="button5"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								20
							</span>
						</button>
						<button class="button12"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								21
							</span>
						</button>
					</div>
					<div class="row-view7">
						<button class="button"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								22
							</span>
						</button>
						<button class="button13"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								23
							</span>
						</button>
						<button class="button14"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								24
							</span>
						</button>
						<button class="button13"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								25
							</span>
						</button>
						<button class="button11"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								26
							</span>
						</button>
						<button class="button15"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								27
							</span>
						</button>
						<button class="button12"
							onclick="alert('Pressed!')"}>
							<span class="text9" >
								28
							</span>
						</button>
					</div>
				</div>
				<div class="absolute-view">
					<div class="row-view8">
						<span class="text11" >
							SUNDAY
						</span>
						<span class="text12" >
							MONDAY
						</span>
						<span class="text13" >
							TUESDAY
						</span>
						<span class="text14" >
							WENESDAY
						</span>
						<span class="text13" >
							THURSDAY
						</span>
						<span class="text15" >
							FRIDAY
						</span>
						<span class="text16" >
							SATURDAY
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>