<?php
session_start(); // Start or resume an existing session

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: login.html'); // Redirect to login page
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Landing Page</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>This is the landing page, accessible only to logged-in users.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
