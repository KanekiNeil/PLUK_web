<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - Alpha Aquila</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
        }

        .container {
            display: flex;
            width: 100%;
        }

        /* LEFT SIDE */
        .left-panel {
            width: 50%;
            background-color: #d71920;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .left-panel img {
            width: 90%;
            max-width: 600px;
        }

        /* RIGHT SIDE */
        .right-panel {
            width: 50%;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 80%;
            max-width: 400px;
            text-align: center;
        }

        .logo-title {
            color: #d71920;
            font-weight: bold;
            font-size: 30px;
            margin-bottom: 10px;
        }

        .welcome {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .google-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            padding: 10px;
            cursor: pointer;
            font-size: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: 100%;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .google-btn:hover{
            background-color: #f5f5f5;
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }

        .divider {
            margin: 15px 0;
            font-size: 12px;
            color: #777;
        }

        .divider::before,
        .divider::after {
            content: "";
            display: inline-block;
            width: 30%;
            height: 1px;
            background: #ccc;
            vertical-align: middle;
            margin: 0 10px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            font-size: 14px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-radius: 5px;
        }

        .forgot {
            text-align: right;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .forgot a {
            color: #555;
            text-decoration: none;
        }

        .forgot a:hover {
            text-decoration: underline;
        }

        .login-btn {
            width: 100%;
            padding: 10px;
            background: linear-gradient(90deg, #E90303, #830202);
            color: white;
            border: none;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .login-btn:hover {
            background: linear-gradient(90deg, #c40000, #8b0000);
            transform: scale(1.02);
        }

        @media (max-width: 900px) {
            .left-panel {
                display: none;
            }

            .right-panel {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <!-- LEFT SIDE -->
    <div class="left-panel">
        <!-- Replace with your actual logo path -->
        <img src="../assets/nobg_logo.png" alt="Alpha Aquila Logo">
    </div>

    <!-- RIGHT SIDE -->
    <div class="right-panel">
        <div class="login-box">

            <div class="logo-title">PRU LIFE UK</div>

            <div class="welcome">Welcome Alpha Aquila!</div>

            <button class="google-btn">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="20">
                Login with Google
            </button>

            <div class="divider">OR Login with Email</div>

                <form id="loginForm">
                    <div class="input-group">
                        <input type="email" id="email" placeholder="Email" required>
                    </div>

                    <div class="input-group">
                        <input type="password" id="password" placeholder="Password" required>
                    </div>

                    <div class="forgot">
                        <a href="#">Forgot Password?</a>
                    </div>

                    <button type="submit" class="login-btn">Login</button>
                </form>

        </div>
    </div>

</div>

<script>
document.getElementById("loginForm").addEventListener("submit", function(e) {
    e.preventDefault(); // 🚫 stop normal form submit

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    fetch("../php/login.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            email: email,
            password: password
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Login successful!");
            window.location.href = "dashboard.php";
        } else {
            alert(data.error || "Login failed");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Something went wrong");
    });
});
</script>
</body>
</html>