<?php
session_start();
if (isset($_SESSION['login_error'])) {
    echo '<div class="error-message">' . $_SESSION['login_error'] . '</div>';
    echo '<script>
        setTimeout(function() {
            window.location.href = "login.php";
        }, 2000); // 1 seconds
    </script>';
    unset($_SESSION['login_error']);
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
                <h2  id="h2-padding">Login</h2>
                <form action="login_register.php" method="post">
                    <div class="input-wrapper">
                        <input type="text" class="formInput" name="login_id" placeholder="Username or Email Address">
                    </div>
                    <div class="input-wrapper">
                        <input type="password" class="formInput" name="password" placeholder="Password" id="password">
                        <img src="./assets/icons8-closed-eye-24.png" alt="Toggle Password" class="eye-icon" id="togglePassword">
                    </div>
                    <div class="btn">
                        <button name="login" type="submit" class="formButton">Login</button>
                        <button type="button" class="formButton" id="sign-up-button">Sign Up</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script src="./registerscript.js"></script>
</body>
</html>