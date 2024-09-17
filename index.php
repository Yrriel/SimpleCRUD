<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <video autoplay muted loop id="myVideo">
        <source src="src/vid/background.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
    <div class="wrapper">
    <form action="register.php" method="POST" class="form-wrapper sign-up">
                <h1>Register</h1>
                <div class="input-box">
                    <input type="text" placeholder="Username" name="username" required>
                </div>
                <div class="input-box">
                    <input type="text" placeholder="email" name="email" required>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="password" name="password" required>
                </div>
                <div class="go-back-link">
                    <p>Already have an account?
                        <a href="#" class="signIn-link">Login</a>
                    </p>
                </div>
                <button type="submit" class="btn">Register</button>
            </form>

            <form action="forgot-password-backend.php" method="POST" class="form-wrapper forgot-in">
                <h1>Forgot Password</h1>
                <div class="input-box">
                    <input type="text" placeholder="email" name="email" required>
                </div>
                <div class="go-back-link">
                    <p>Already have an account?
                        <a href="#" class="signIn-link2">Login</a>
                    </p>
                </div>
                <button type="submit" class="btn">Send Email</button>
            </form>
        <form action="backend/backend.Login.php" method="POST" class="form-wrapper sign-in">
                <h1>Login</h1>
                <div class="input-box">
                    <input type="text" placeholder="Username" name="username" required>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Passsword" name="password" required>
                </div>
                <div class="go-back-link">
                    <p>
                        <a href="#" class="forgot-link">Forgot password?</a>
                    </p>
                </div>
                <button type="submit" class="btn">Login</button>

                <div class="go-back-link">
                    <p>Don't have an account?
                        <a href="#" class="signUp-link">Register</a>
                    </p>
                </div>
            </form>
    </div>
    <script src="style/script.js"></script>
</body>
</html>