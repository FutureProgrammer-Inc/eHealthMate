<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Start a PHP session
session_start();

// Include your database configuration file
require_once('db_config.php');

// Include the PHPMailer library
require '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the username and password from the POST data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Initialize the result array
    $result = [];

    try {
        // Prepare and execute a database query to fetch user data
        $data_entry = [':username' => $username];
        $mysql_query = $con->prepare("SELECT * FROM tbl_user WHERE USERNAME=:username");
        $query_result = $mysql_query->execute($data_entry);
        $fetchCount = $mysql_query->rowCount();

        if ($fetchCount > 0) {
            // Fetch user data
            $hasUser = $mysql_query->fetch();
            $userPassword = $hasUser['PASSWORD'];
            $userid = $hasUser['ID_USER'];
            $to = $hasUser['EMAIL'];
            $username = $hasUser['FIRSTNAME'];

            // Generate a random OTP
            $otp = rand(100000, 999999);

            // Check if there are existing OTP records and delete them
            $otp_query = $con->prepare("DELETE FROM otp WHERE otp_user_id=:userid");
            $otp_query->bindParam(":userid", $userid, PDO::PARAM_INT);
            $otp_query->execute();

            // Insert the new OTP
            $otp_query = $con->prepare("INSERT INTO `otp`(`otp_user_id`, `otp`) VALUES (:userid, :otp)");
            $otp_query->bindParam(":userid", $userid, PDO::PARAM_INT);
            $otp_query->bindParam(":otp", $otp, PDO::PARAM_INT);
            $otp_query->execute();

            // Send the OTP to the user
            $mail_status = sendMail($to, $otp);
            if ($mail_status === true) {
                $result = ['status' => true, 'message' => $userid];
            } else {
                $result = ['status' => false, 'message' => 'Failed to send OTP!'];
            }
        } else {
            $result = ['status' => false, 'message' => 'Invalid username!'];
        }
    } catch (PDOException $e) {
        $result = ['status' => false, 'message' => $e->getMessage()];
    }

    // Encode the result array as JSON and send it as a response
    header('Content-Type: application/json');
    echo json_encode($result);
} else {
    http_response_code(405); // Method Not Allowed
    echo "Method Not Allowed";
}

function sendMail($to, $otp)
{
    try {

        $mail = new PHPMailer(true);
        // Configure SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'eHealthmate086@gmail.com'; // Replace with your email
        $mail->Password   = 'otzailcofofpuwvc'; // Replace with your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Set email sender and recipient
        $mail->setFrom('eHealthmate086@gmail.com', 'eHealthmate Verification'); // Replace with your name and email
        $mail->addAddress($to);

        // Compose email content
        $mail->isHTML(true);
        $mail->Subject = 'Email Verification';
        $mail->Body    = 'OTP: ' . $otp;

        $mail->send();

        return true;
    } catch (Exception $e) {
        return false;
    }
}
