<?php
// Database configuration
$servername = "sql102.infinityfree.com";
$username = "if0_41133223";
$password = "gyPpjAEmJxIK4";
$dbname = "if0_41133223_healthsync_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
