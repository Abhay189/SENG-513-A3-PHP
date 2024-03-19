<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Database connection parameters
    $dbServername = "db";
    $dbUsername = "user";
    $dbPassword = "password";
    $database = "my_db";
    $port = 3306;
    $dsn = "mysql:host=$dbServername;dbname=$database;port=$port";

    try {
        $conn = new PDO($dsn, $dbUsername, $dbPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL to fetch the admin user by username
        $sql = "SELECT username, password FROM admins WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        if ($stmt->rowCount() == 1) {
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify the password
            if (password_verify($password, $admin['password'])) {
                // Password is correct, start a new session
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $admin['username'];
                
                // Redirect to the admin dashboard or homepage
                header('Location: admin.php');
                exit();
            } else {
                // Password is not correct
                echo "The password you entered was not valid.";
            }
        } else {
            echo "No account found with that username.";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redirect back to the login form if the method is not POST
    header("Location: admin_login.html");
    exit();
}
?>
