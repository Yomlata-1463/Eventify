<?php
session_start();
if (isset($_SESSION['register_error'])) {
    echo '<div class="error-message">' . $_SESSION['register_error'] . '</div>';
    echo '<script>
        setTimeout(function() {
            window.location.href = "signup.php";
        }, 2000); // 1 seconds
    </script>';
    unset($_SESSION['register_error']);
}
if (isset($_SESSION['register_success'])) {
    echo '<div class="success-message">' . $_SESSION['register_success'] . '</div>';
    unset($_SESSION['register_success']);
    echo '<script>
        setTimeout(function() {
            window.location.href = "login.php";
        }, 2000); // 2 seconds
    </script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventify</title>
    <link rel="stylesheet" href="registerstyle.css?v=<?php echo time(); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
    <h1>Eventify</h1>
    <div class="box">
        <div class="card" id="card">
            <div>
                <h2>Create<br>account</h2>
                <form action="login_register.php" method="post">
                    <div class="input-wrapper">
                        <input type="text" class="formInput" name="username" placeholder="Username">
                    </div>
                    <div class="input-wrapper">
                        <input type="text" class="formInput" name="email" placeholder="Email Address">
                    </div>
                    <div class="input-wrapper">
                        <input type="password" class="formInput" name="password" placeholder="Password" id="password">
                        <img src="./assets/icons8-closed-eye-24.png" alt="Toggle Password" class="eye-icon" id="togglePassword">
                    </div>
                    <div class="input-wrapper">
                        <input type="password" class="formInput" name="confirm" placeholder="Confirm Password" id="confirmPassword">
                        <img src="./assets/icons8-closed-eye-24.png" alt="Toggle Confirm Password" class="eye-icon" id="toggleConfirmPassword">
                    </div>
                    <div class="btn">
                        <button type="submit" class="formButton" name="register">Sign Up</button>
                        <button type="button" class="formButton" id="login-button">Login</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script src="./registerscript.js"></script>
</body>
</html>