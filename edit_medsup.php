<?php
session_start();
if (!isset($_SESSION['auth'])) {
    header('location: login.php');
}
include 'template/header.php';
require 'config/db_config.php';

// Get the medical supply ID from the URL parameter
if (isset($_GET['id'])) {
    $medsupID = $_GET['id'];

    // Fetch medical supply data from the database based on the ID
    $query = "SELECT * FROM tbl_medsup WHERE ID_MEDSUP = ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$medsupID]);

    $medsupData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$medsupData) {
        $_SESSION['message'] = "Medical supply not found";
        header('Location: medsup.php'); // Redirect to the medical supply listing page
        exit();
    }
} else {
    $_SESSION['message'] = "Invalid medical supply ID";
    header('Location: medsup.php'); // Redirect to the medical supply listing page
    exit();
}

// Check if the form was submitted for updating
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $medsup_name = $_POST['medsup_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Update the medical supply data in the database
    $updateQuery = "UPDATE tbl_medsup SET MEDSUP_NAME = ?, DESCRIPTION = ?, PRICE = ? WHERE ID_MEDSUP = ?";
    $updateStmt = $con->prepare($updateQuery);
    $success = $updateStmt->execute([$medsup_name, $description, $price, $medsupID]);

    if ($success) {
        $_SESSION['message'] = "Medical supply updated successfully!";
        header('Location: medsup.php'); // Redirect to the medical supply listing page
        exit();
    } else {
        $_SESSION['message'] = "Error updating medical supply";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include your HTML head content here -->
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

                <h1>Edit Medical Supply</h1>

                <?php if (!empty($_SESSION['message'])) : ?>
                    <p><?php echo $_SESSION['message']; ?></p>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>

                <form action="edit_medsup.php?id=<?php echo $medsupID; ?>" method="post">
                    <div class="mb-3">
                        <label for="medsup_name" class="form-label">Supply Name</label>
                        <input type="text" class="form-control" id="medsup_name" name="medsup_name" value="<?php echo $medsupData['MEDSUP_NAME']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $medsupData['DESCRIPTION']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" value="<?php echo $medsupData['PRICE']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Medical Supply</button>
                </form>

            </div><!--//container-fluid-->
        </div><!--//app-content-->

        <?php
        include 'partials/footer.php';
        ?>

    </div><!--//app-wrapper-->

    <?php
    include 'template/scripts.php';
    ?>

</body>

</html>