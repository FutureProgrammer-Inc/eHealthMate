<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['equipmentId'])) {
    // Include the database connection file
    include('config/db_config.php');

    // Get the equipment ID to be deleted
    $equipmentId = $_POST['equipmentId'];

    // Prepare and execute the SQL query to delete the equipment
    $query = $con->prepare("DELETE FROM tbl_medequip WHERE ID_MEDEQUIP = :equipmentId");
    $query->bindParam(':equipmentId', $equipmentId, PDO::PARAM_INT);

    if ($query->execute()) {
        // Deletion was successful
        echo 'success';
    } else {
        // Error occurred during deletion
        echo 'error';
    }
} else {
    // Invalid request
    echo 'invalid';
}
