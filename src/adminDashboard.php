<?php
// Start the session to check if the admin is logged in
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    // If the admin is not logged in, redirect to login page
    header('Location: admin_login.html');
    exit();
}

// Database connection parameters
$dbServername = getenv('DB_SERVERNAME');
$dbUsername = getenv('DB_USERNAME');
$dbPassword = getenv('DB_PASSWORD');
$database = getenv('DATABASE');
$port = getenv('DB_PORT');
$dsn = "mysql:host=$dbServername;dbname=$database;port=$port";

try {
    // Attempt to connect to the database
    $conn = new PDO($dsn, $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if a delete request was made
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteUserId'])) {
        $deleteSql = "DELETE FROM users WHERE id = :id";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bindParam(':id', $_POST['deleteUserId'], PDO::PARAM_INT);
        $deleteStmt->execute();
        
        echo "<p>User deleted successfully.</p>";
    }

    // Query to select all users
    $sql = "SELECT id, username FROM users";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        input[type="submit"] {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }
        h2 {
            color: #333;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>All Users</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Action</th>
        </tr>
        <?php foreach ($results as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td>
                    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                        <input type="hidden" name="deleteUserId" value="<?= $row['id'] ?>">
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
<?php
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
