<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Database connection parameters
    $dbServername = "db";
    $dbUsername = "user";
    $dbPassword = "password";
    $database = "my_db";
    $port = 3306;
    $dsn = "mysql:host=$dbServername;dbname=$database;port=$port";
    
    // Process form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Basic validation
    if (empty($username) || empty($password)) {
        die("Username and password are required.");
    }

    try {
        // Attempt to connect to the database
        $conn = new PDO($dsn, $dbUsername, $dbPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT username, password FROM users WHERE username = :username";
       
        $stmt = $conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_start(); // Start the session
            $_SESSION['user_logged_in'] = true; // Set a session variable
            $_SESSION['username'] = $username; // Optionally, store the username
            header('Location: landingPage.php');
            exit();
        } else {
            echo "Login failed. Invalid username or password.";
        }
        
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

} else {
    // Redirect back to the form if the method is not POST
    header("Location: index.html");
    exit();
}
?>
