<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // require 'database.php'; // Assumes you have a database.php that initializes $conn

    // Database connection parameters
    $dbServername = "db";
    $dbUsername = "user";
    $dbPassword = "password";
    $database = "my_db";
    $port = 3306;
    $dsn = "mysql:host=$dbServername;dbname=$database;port=$port";


    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";

    try {
        $conn = new PDO($dsn, $dbUsername, $dbPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare($sql);
        $stmt->execute(['username' => $username, 'password' => $password]);
        
        // Start session and set session variables upon successful signup
        session_start();
        $_SESSION['user_logged_in'] = true;
        $_SESSION['username'] = $username;

        // Redirect to landingPage.php after successful signup
        header('Location: landingPage.php');
        exit();

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>