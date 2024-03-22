<?php
// Database connection parameters
$dbServername = "db";
$dbUsername = "user";
$dbPassword = "password";
$database = "my_db";
$port = 3306;
$dsn = "mysql:host=$dbServername;dbname=$database;port=$port";

try {
    // Attempt to connect to the database
    $conn = new PDO($dsn, $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to select all users
    $sql = "SELECT id, username, password FROM users";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display all users
    echo "<h2>All Users</h2>";
    echo "<table border='1'><tr><th>ID</th><th>Username</th></tr>";
    foreach ($results as $row) {
        echo "<tr><td>" . htmlspecialchars($row['id']) . "</td><td>" . htmlspecialchars($row['username']) . "</td></tr>";
    }
    echo "</table>";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>