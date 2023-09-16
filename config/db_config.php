<?php
// Define database credentials
$username = "doadmin";
$password = "AVNS_Gu-KdKHprSL7KLYvWd8";
$host = "db-ehealthmate-do-user-14609104-0.b.db.ondigitalocean.com";
$port = "25060";
$database = "defaultdb";
$sslmode = "required";

try {
    // Create a PDO database connection
    $dsn = "pgsql:host=$host;port=$port;dbname=$database;sslmode=$sslmode";
    $pdo = new PDO($dsn, $username, $password);

    // Set PDO to throw exceptions on errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected successfully<br>";

    // Example: Execute a query to retrieve data from the users table
    $sql = "SELECT * FROM your_table_name"; // Replace your_table_name with your actual table name
    $stmt = $pdo->query($sql);
    
    // Fetch and display results
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "User ID: " . $row['user_id'] . ", Username: " . $row['username'] . "<br>";
    }

    // Close the PDO connection when done
    $pdo = null;
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
