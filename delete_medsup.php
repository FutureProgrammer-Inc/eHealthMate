<?php
include('config/db_config.php');

if (isset($_POST['medsupId'])) {
    $medsupId = $_POST['medsupId'];

    // Check if the medical supply exists in the database before deleting
    $checkQuery = $con->prepare("SELECT * FROM tbl_medsup WHERE ID_MEDSUP = :medsupId");
    $checkQuery->bindParam(':medsupId', $medsupId, PDO::PARAM_INT);
    $checkQuery->execute();
    $medsupExists = $checkQuery->rowCount();

    if ($medsupExists) {
        // Execute a DELETE query to remove the medical supply from the database
        $deleteQuery = $con->prepare("DELETE FROM tbl_medsup WHERE ID_MEDSUP = :medsupId");
        $deleteQuery->bindParam(':medsupId', $medsupId, PDO::PARAM_INT);

        if ($deleteQuery->execute()) {
            // Return a success message to the JavaScript code
            echo 'success';
        } else {
            // Return an error message to the JavaScript code
            echo 'error';
        }
    } else {
        // Return a message indicating that the medical supply does not exist
        echo 'not_found';
    }
} else {
    // Return a message indicating that the medsupId is not set in the POST request
    echo 'missing_medsupId';
}
