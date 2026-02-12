<?php
session_start();

$is_logged_in = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - HealthSync</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="user-styles-1.css">
    <script src="script.js"></script>
</head>
<body>

    <header>
        <div class="healthsync-logo">
            <img src="images/Logos/logo3.png" alt="HealthSync Logo" class="logo-img">
        </div>

        <nav>
            <ul>
                <li><a href="index.php" class="nav-item active">Home</a></li>
                <li><a href="user-problem.php" class="nav-item">Problem</a></li>
                <li><a href="user-how.php" class="nav-item">How It Works</a></li>
                <li><a href="user-about.php" class="nav-item">About</a></li>
            </ul>
        </nav>

        <div class="right-nav">
            <?php if ($is_logged_in): ?>
                <a href="user-my-account.php" class="nav-item login-link">My Account</a>
            <?php else: ?>
                <a href="user-login.php" class="nav-item login-link">Log In</a>
            <?php endif; ?>
            <a href="user-buy-now.php" class="btn-buy-now">Buy Now</a>
        </div>
    </header>

    <section class="hero-section">
        <div class="text-content">
            <h1>Next-Gen Device<br>for Real-Time<br>Sensory<br>Monitoring</h1>
            <p>Designed specially for hypersensitive individuals</p>
        </div>
        <div class="image-content">
            <img src="images/device.png" alt="HealthSync Watch">
        </div>
    </section>

    <section class="features-section">
        <h2 class="features-title">Features</h2>
        
        <div class="features-grid">
            <div class="feature-card">
                <img src="images/Icons/icon-heart.png" alt="Heart Rate" class="feature-icon">
                <h3>Heart Rate Sensing</h3>
                <p>Real-time monitoring of your heart rate throughout the day</p>
            </div>

            <div class="feature-card">
                <img src="images/Icons/icon-sound.png" alt="Sound Monitoring" class="feature-icon">
                <h3>Sound Monitoring</h3>
                <p>Track ambient noise levels to avoid sensory overload</p>
            </div>

            <div class="feature-card">
                <img src="images/Icons/icon-light.png" alt="Light Detection" class="feature-icon">
                <h3>Light Detection</h3>
                <p>Monitor brightness levels for optimal comfort</p>
            </div>

            <div class="feature-card">
                <img src="images/Icons/icon-temp.png" alt="Temperature Tracking" class="feature-icon">
                <h3>Temperature Tracking</h3>
                <p>Stay aware of temperature changes in your environment</p>
            </div>
        </div>
    </section>

    <br>

    <footer>
        <p>&copy; 2026 HealthSync. All rights reserved.</p>
    </footer>
    
</body>
</html>
