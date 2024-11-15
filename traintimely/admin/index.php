<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminLogin</title>
    <!-- Google Fonts Link For Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <span class="hamburger-btn material-symbols-rounded">menu</span>
            <a href="#" class="logo">
                <img src="logo.jpeg" alt="logo">
                <h2>TRAIN TIMELY</h2>
            </a>
            <h1 style="color: white;">Admin Login</h1>
            <ul class="links">
                <span class="close-btn material-symbols-rounded">close</span>
                <li><a href="test.html"></a></li>
                <li><a href="Contact.html"></a></li>
            </ul>
            <button class="login-btn">LOG IN</button>
        </nav>
    </header>

    <div class="blur-bg-overlay"></div>
    <div class="form-popup">
        <span class="close-btn material-symbols-rounded">close</span>
        <div class="form-box login">
            <div class="form-details">
                <h2>Welcome Back</h2>
                <p>Please log in using your personal information to stay connected with us.</p>
            </div>
            <div class="form-content">
                <h2>LOGIN</h2>
                <form action="login.php" method="post">
                    <div class="input-field">
                        <input id="admin_email" name="admin_email" type="text" required>
                        <label>Email</label>
                    </div>
                    <div class="input-field">
                        <input id="admin_password" name="admin_password" type="password" required>
                        <label>Password</label>
                    </div>
                    <button type="submit">Log In</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>