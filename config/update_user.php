<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted form data
    $user_id = $_POST['user_id'];
    $role = $_POST['role'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
  

    // Update the student information in the database
    try {
        $updateQuery = "UPDATE tbl_user SET
            role = :role,
            firstname = :firstName,
            middlename = :middleName,
            lastname = :lastName,
            email = :email,
            username = :username,
            password = :password
            WHERE user_id = :user_id";

        $stmt = $con->prepare($updateQuery);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':middleName', $middleName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();

        // Redirect to a page (e.g., the student's profile page) after updating
        header('Location: student_profile.php?student_id=' . $user_id);
        exit();
    } catch (PDOException $e) {
        echo "Error updating student data: " . $e->getMessage();
        die();
    }
}