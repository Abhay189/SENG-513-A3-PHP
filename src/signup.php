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
        echo "<br>Database Connected successfully<br>";


        $stmt = $conn->prepare($sql);
        $stmt->execute(['username' => $username, 'password' => $password]);
        echo "Signup successful.";


        // Select and display all users
        $sql = "SELECT id, username, password FROM users";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "All users:<br>";
        foreach ($results as $row) {
            echo "Id: " . htmlspecialchars($row['id']) . " - Username: " . htmlspecialchars($row['username']) . " - Password: " . htmlspecialchars($row['password']) . "<br>";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>