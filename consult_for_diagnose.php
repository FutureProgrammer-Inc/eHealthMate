<?php
session_start();
if (!isset($_SESSION['auth'])) {
    header('location: login.php');
}
include 'template/header.php';
require 'config/db_config.php'; // Adjust the path to your database config file

// Get the student ID from the URL parameter
if (isset($_POST['student_id'])) {
    $studentID = $_POST['student_id'];

    // Fetch student data from the database based on the ID
    $query = "SELECT * FROM tbl_student WHERE STUDENT_ID = " . $_POST['student_id'];
    $stmt = $con->prepare($query);
    $stmt->execute();

    $studentData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$studentData) {
        $_SESSION['message'] = "Student not found";
        header('Location:consult.php?error=error'); // Redirect to the student listing pagerrrrrrr
        exit();
    }
} else {
    $_SESSION['message'] = "Invalid student ID";
    header('Location: index.php'); // Redirect to the student listing page
    exit();
}

// Check if the form was submitted for updating
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $student_id = $_POST['student_id'];
    $diagnose = $_POST['diagnosis'];
    $instruction = $_POST['instructions'];



    $query = "INSERT INTO `tbl_consult`(`DIAGNOSIS`, `INSTRUCTIONS`, `id_student`) VALUES ('$diagnose', '$instruction', '$student_id')";
    $stmt = $con->prepare($query);
    $stmt->execute();

    if ($stmt) {
        $_SESSION['message'] = "Diagnose!";
        header('Location: consult.php');
        exit();
    } else {
        $_SESSION['message'] = "Error Diagnose";
    }
}
