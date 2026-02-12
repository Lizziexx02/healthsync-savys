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
</head>
<body>

    <header>
        <div class="healthsync-logo">
            <img src="images/Logos/logo3.png" alt="HealthSync Logo" class="logo-img">
        </div>

        <nav>
            <ul>
                <li><a href="index.php" class="nav-item">Home</a></li>
                <li><a href="user-problem.php" class="nav-item active">Problem</a></li>
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

    <!-- Problem Hero Section with Text Overlay -->
    <section class="problem-hero-section">
        <h2>Why HealthSync?</h2>

        <p class="hero-caption">
            HealthSync is one of those smart watches that emphasizes more on an individual's wellbeing.
        </p>
    </section>

    <!-- Problem Content Section -->
    <section class="problem-content">
        
        <div class="problem-intro">
            <p>
                For individuals with sensory processing sensitivities, everyday environments can become overwhelming. 
                Traditional health monitoring devices focus solely on physical metrics like heart rate and steps, but fail 
                to account for the environmental factors that significantly impact wellbeing. HealthSync bridges this gap 
                by providing comprehensive sensory monitoring alongside vital health statistics.
            </p>
        </div>

        <!-- Problem Cards Section -->
        <div class="problem-grid">
            <div class="problem-card">
                <h3>Sensory Overload</h3>
                <p>Hypersensitive individuals often struggle to identify which environmental factors trigger discomfort. Loud sounds, bright lights, or temperature fluctuations can cause stress without clear awareness of the source.</p>
            </div>

            <div class="problem-card">
                <h3>Limited Awareness</h3>
                <p>Without real-time data, it's difficult to establish patterns and correlations between environmental conditions and personal wellbeing, making it challenging to create comfortable living and working spaces.</p>
            </div>

            <div class="problem-card">
                <h3>Reactive Rather Than Proactive</h3>
                <p>Most people only realize they're in an uncomfortable environment after symptoms appear. HealthSync enables proactive management by alerting users before sensory thresholds are exceeded.</p>
            </div>

            <div class="problem-card">
                <h3>Holistic Health Gap</h3>
                <p>Traditional fitness trackers ignore the crucial relationship between environmental factors and physical health, providing an incomplete picture of overall wellbeing and missing key triggers for stress responses.</p>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2026 HealthSync. All rights reserved.</p>
    </footer>

</body>
</html>
