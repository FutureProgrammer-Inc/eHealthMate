<?php
session_start();
if (!isset($_SESSION['auth'])) {
    header('location: login.php');
}
include 'template/header.php';
require 'config/db_config.php';

// Get the medical equipment ID from the URL parameter
if (isset($_GET['id'])) {
    $medequipID = $_GET['id'];

    // Fetch medical equipment data from the database based on the ID
    $query = "SELECT * FROM tbl_medequip WHERE ID_MEDEQUIP = ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$medequipID]);

    $medequipData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$medequipData) {
        $_SESSION['message'] = "Medical equipment not found";
        header('Location: medequip.php'); // Redirect to the medical equipment listing page
        exit();
    }
} else {
    $_SESSION['message'] = "Invalid medical equipment ID";
    header('Location: medequip.php'); // Redirect to the medical equipment listing page
    exit();
}

// Check if the form was submitted for updating
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $medequip_name = $_POST['medequip_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Update the medical equipment data in the database
    $updateQuery = "UPDATE tbl_medequip SET MEDEQUIP_NAME = ?, DESCRIPTION = ?, PRICE = ? WHERE ID_MEDEQUIP = ?";
    $updateStmt = $con->prepare($updateQuery);
    $success = $updateStmt->execute([$medequip_name, $description, $price, $medequipID]);

    if ($success) {
        $_SESSION['message'] = "Medical equipment updated successfully!";
        header('Location: medequip.php'); // Redirect to the medical equipment listing page
        exit();
    } else {
        $_SESSION['message'] = "Error updating medical equipment";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include your HTML head content here -->
    <title>Edit Medical Equipment</title>
    <!-- Add your CSS and Bootstrap CDN links here -->
</head>

<body class="app">
    <header class="app-header fixed-top">
        <?php
        include 'partials/header.php';
        include 'partials/sidebar.php';
        ?>
    </header><!--//app-header-->

    <div class="app-wrapper">

        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">

                <h1>Edit Medical Equipment</h1>

                <?php if (!empty($_SESSION['message'])) : ?>
                    <p><?php echo $_SESSION['message']; ?></p>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>

                <form action="edit_medequip.php?id=<?php echo $medequipID; ?>" method="post">
                    <div class="mb-3">
                        <label for="medequip_name" class="form-label">Equipment Name</label>
                        <input type="text" class="form-control" id="medequip_name" name="medequip_name" value="<?php echo $medequipData['MEDEQUIP_NAME']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $medequipData['DESCRIPTION']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" value="<?php echo $medequipData['PRICE']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Medical Equipment</button>
                </form>

            </div><!--//container-fluid-->
        </div><!--//app-content-->

        <?php
        include 'partials/footer.php';
        ?>

    </div><!--//app-wrapper-->

    <!-- Include your JavaScript libraries and scripts here -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>