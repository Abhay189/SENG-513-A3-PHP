<!DOCTYPE html>
<html>
<head>
    <title>My PHP Web Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: 300px;
        }
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            color: white;
            background-color: #007bff;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Please enter your username and password</h1>
    <form method="POST">
        <input type="text" name="username" placeholder="Enter Username">
        <input type="password" name="password" placeholder="Enter Password">
        <input type="submit" value="Submit">
    </form>

    <?php
    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Process form data
        $username = $_POST['username']; 
        $password = $_POST['password']; 
        
        if (empty($username)) {
            die("Username is required.");
        }
        if (empty($password)) {
            die("Password is required.");
        }

        $dbServername = "db"; 
        $dbUsername = "user";
        $dbPassword = "password";
        $database = "my_db";
        $port = 3306;
        $dsn = "mysql:host=$dbServername;dbname=$database;port=$port";
        
        try {
            $conn = new PDO($dsn, $dbUsername, $dbPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "<br>Database Connected successfully<br>";
        
            $sql = "SHOW TABLES";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

    } else {
        $message = "Fill in the form and submit.";
    }
    ?>
    
</body>
</html>
