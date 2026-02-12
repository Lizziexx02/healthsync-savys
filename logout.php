<?php
session_start();
session_destroy();  // Destroy all session data
header('Location: admin-login.php');  // Redirect to login page
exit();
