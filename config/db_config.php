<?php

$server = 'localhost';
$username = 'root';
$db_password = '';
$db_name = 'isu-ehealthmate_db';

try {
    $ATTR = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];
    // Use a DSN (Data Source Name) for better clarity
    $dsn = "mysql:host=$server;dbname=$db_name;charset=utf8mb4";

    // Create the PDO connection
    $con = new PDO($dsn, $username, $db_password, $ATTR);

    // You can optionally set the character set directly on the connection
    $con->exec("SET CHARACTER SET utf8mb4");

    // Uncomment the line below if you want to display a success message
    // echo 'Connection Success!';

} catch (PDOException $e) {
    $array = array('result' => false, 'msg' =>  "Connection failed: " . $e->getMessage());
    echo json_encode($array);
}
