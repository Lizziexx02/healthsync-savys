<?php
session_start();

$is_logged_in = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>How It Works - HealthSync</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="user-styles-1.css">
    <script>
        function toggleStep(step) {
            var stepImage = document.getElementById('how-it-works-img');
            
            switch(step) {
                case 1:
                    stepImage.src = "images/login.jpg";
                    break;
                case 2:
                    stepImage.src = "images/connect.jpg"; 
                    break;
                case 3:
                    stepImage.src = "images/assessment.jpg"; 
                    break;
                case 4:
                    stepImage.src = "images/dashboard.jpg"; 
                    break;
                default:
                    stepImage.src = "images/device.png"; 
                    break;
            }

          
            document.querySelectorAll('.step-content').forEach(function(content) {
                content.style.display = 'none'; 
            });
            document.getElementById('step-' + step).style.display = 'block';
        }
    </script>
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
                <li><a href="user-how.php" class="nav-item active">How It Works</a></li>
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

    <section class="process-section">
        <div class="process-header">
            <h2>Data Flow Process</h2>
            <p>From device to cloud, then to app, HealthSync ensures seamless data synchronization and real-time updates.</p>
        </div>
        
        <div class="process-container">
            <div class="process-step">
                <img src="Images/device.png" alt="HealthSync Smart Watch" class="step-img watch-img">
                <p class="process-text">Step 1: HealthSync Smart Watch collects real-time data like heart rate and environmental sensors.</p>
            </div>

            <div class="process-arrow">
                <img src="Images/DoubleEndArrow.png" alt="Double End Arrow" class="arrow-img">
            </div>

            <div class="process-step">
                <img src="images/Firebase.png" alt="Cloud Data Processing" class="step-img cloud-img">
                <p class="process-text">Step 2: The data is processed and analyzed in the cloud (e.g., Firebase or similar service).</p>
            </div>

            <div class="process-arrow">
                <img src="Images/DoubleEndArrow.png" alt="Double End Arrow" class="arrow-img">
            </div>

            <div class="process-step">
                <img src="images/phone.png" alt="Mobile App Interface" class="step-img phone-img">
                <p class="process-text">Step 3: Processed data is sent back to the mobile app for real-time monitoring and feedback.</p>
            </div>
        </div>
    </section>

    <section class="how-it-works-section">
        <div class="how-it-works-left">
            <img id="how-it-works-img" src="images/device.png" alt="How It Works" class="how-it-works-img">
        </div>

        <div class="how-it-works-right">
            <h2>How It Works</h2>
            <p>From setup to everyday use, we’ve made automation effortless.</p>

            <div class="steps">
                <div class="step">
                    <button class="step-btn" onclick="toggleStep(1)">
                        <span>Step 1: Create an Account</span>
                    </button>
                    <div id="step-1" class="step-content" style="display:none;">
                        <p>Create an account by filling in your email, password, and confirming your password. If you already have an account, simply click "Have an account? Sign In" below the confirm password field.</p>
                    </div>
                </div>

                <div class="step">
                    <button class="step-btn" onclick="toggleStep(2)">
                        <span>Step 2: Connect Device to the App</span>
                    </button>
                    <div id="step-2" class="step-content" style="display:none;">
                        <p>Read the device ID on the back of the device or on the manual that comes with the device. Input the device ID and wait for it to connect successfully.</p>
                    </div>
                </div>

                <div class="step">
                    <button class="step-btn" onclick="toggleStep(3)">
                        <span>Step 3: Customize your Device</span>
                    </button>
                    <div id="step-3" class="step-content" style="display:none;">
                        <p>Answer the sound sensitivity assessment, light sensitivity assessment, and temperature sensitivity assessment in order to customize the device according to your needs.</p>
                    </div>
                </div>

                <div class="step">
                    <button class="step-btn" onclick="toggleStep(4)">
                        <span>Step 4: Enjoy Intelligent Living</span>
                    </button>
                    <div id="step-4" class="step-content" style="display:none;">
                        <p>Enjoy the comfort of a real-time sensory factor monitoring device and its integration with the HealthSync application made for alerts and customization.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 HealthSync. All rights reserved.</p>
    </footer>

</body>
</html>
