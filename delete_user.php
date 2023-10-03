<?php
// Include the database connection
include('config/db_config.php');

// Check if userId is set and not empty in the POST request
if (isset($_POST['userId']) && !empty($_POST['userId'])) {
    // Sanitize the userId to prevent SQL injection (assuming userId is an integer)
    $userId = intval($_POST['userId']);

    try {
        // Prepare and execute the SQL query to delete the user
        $query = $con->prepare("DELETE FROM tbl_user WHERE ID_USER = :userId");
        $query->bindParam(':userId', $userId, PDO::PARAM_INT);
        $query->execute();

        // Check if the deletion was successful
        if ($query->rowCount() > 0) {
            echo 'success'; // Return a success message
        } else {
            echo 'error'; // Return an error message if the user was not found or not deleted
        }
    } catch (PDOException $e) {
        echo 'error'; // Return an error message if there was a database error
    }
} else {
    echo 'error'; // Return an error message if userId is not provided or empty in the POST request
}
