<?php
session_start();

$is_logged_in = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthSync - About</title>
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
                <li><a href="user-problem.php" class="nav-item">Problem</a></li>
                <li><a href="user-how.php" class="nav-item">How It Works</a></li>
                <li><a href="user-about.php" class="nav-item active">About</a></li>
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

    <section id="about">
        <div class="project-background">
            <img src="images/team-picture.jpg" alt="HealthSync Team" class="team-picture">
            <h2>Project Background</h2>
            <p>Our team recognized a critical gap in the health technology market: while countless devices track physical metrics, none adequately address the needs of individuals with sensory processing sensitivities. 
                HealthSync was born from the understanding that environmental factors play a crucial role in overall wellbeing, particularly for those who experience the world with heightened sensitivity. By combining 
                advanced sensor technology with an intuitive mobile interface, we've created a comprehensive solution that empowers users to take control of their sensory environment and make informed decisions about 
                their health and comfort.</p>
        </div>

        <div class="meet-the-team">
            <h2>Meet the team behind HealthSync's innovation</h2>
            <div class="team-members">
                <div class="team-member">
                    <img src="images/team/raf.jpg" alt="Donn Rafael T. Valle" class="member-img">
                    <p>Valle, Donn Rafael T.</p>
                </div>

                <div class="team-member">
                    <img src="images/team/roi.jpg" alt="Roinier V. Abellera" class="member-img">
                    <p>Abellera, Roinier V.</p>
                </div>

                <div class="team-member">
                    <img src="images/team/liz.jpg" alt="Rachelle Elizabeth P. Ylagan" class="member-img">
                    <p>Ylagan, Rachelle Elizabeth P.</p>
                </div>

                <div class="team-member">
                    <img src="images/team/franz.jpg" alt="Franz B. Sambrano" class="member-img">
                    <p>Sambrano, Franz B.</p>
                </div>

                <div class="team-member">
                    <img src="images/team/fergo.png" alt="Emson A. Salalac" class="member-img">
                    <p>Salalac, Emson A.</p>
                </div>
            </div>
        </div>
    </section>
    
    <footer>
        <p>Wearable Device for Real-Time Monitoring of Sensory Factors and Heart Rate with Mobile Application by Team SAVYS</p>
    </footer>
</body>
</html>