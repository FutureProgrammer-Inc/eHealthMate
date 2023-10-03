<?php
session_start();
require_once('db_config.php');

$id = $_POST['id'];
$otp = $_POST['otp'];
$result = [];

try {
    $data_entry = [':id' => $id, ":otp" => $otp];
    $mysql_query = $con->prepare("SELECT * FROM otp WHERE otp_user_id =:id and otp = :otp");
    $query_result = $mysql_query->execute($data_entry);
    $fetchCount = $mysql_query->rowCount();

    if ($fetchCount > 0) {
        $mysql_query = $con->prepare("SELECT * FROM tbl_user WHERE ID_USER=" . $id);
        $userquery = $mysql_query->execute();
        $userCount = $mysql_query->rowCount();
        if ($userCount > 0) {
            $user = $mysql_query->fetch();
            $_SESSION['auth'] = $user;
        }
        $result = ['status' => true, 'message' => 'Login Successfully!'];
    } else {
        $result = ['status' => false, 'message' => 'Invalid username!'];
    }
} catch (PDOException $e) {
    $result = ['status' => false, 'message' => $e->getMessage()];
}
echo json_encode($result);
