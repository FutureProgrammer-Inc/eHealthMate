<?php
    $server = 'localhost'; //Server Name
    $username = 'root';    //database Username
    $db_password = '';     //database Password
    $db_name = 'db_emedrec_final';         

    try{
            $ATTR = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];
            //quotation always double ""
            $con = new PDO("mysql:host=$server;dbname=$db_name", $username, $db_password, $ATTR);
            ///echo 'Connection Success!'; //Display text if connected

       }    catch (PDOException $e) {
                $array = array('result' => true, 'msg' => "Connection Failed: " . $e->getMessage());
                echo json_encode($array);
       }
?>