<?php

$server = 'mongodb+srv://ehealthmate-5c5c20f9.mongo.ondigitalocean.commongodb+srv://ehealthmate-5c5c20f9.mongo.ondigitalocean.com';
$username = 'doadmin';
$db_password = '162QR5Y870CVrcp9';
$db_name = 'isu-ehealthmate_db';
$port = '25060';

try {
    $ATTR = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];
    // Use a DSN (Data Source Name) for better clarity
    $dsn = "mysql:host=$server;dbname=$db_name;charset=utf8mb4;port=$port";

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
