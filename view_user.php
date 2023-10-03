<?php
session_start();
if (!isset($_SESSION['auth'])) {
    header('location: login.php');
}
include 'template\header.php';
require 'config/db_config.php';

// Get the student ID from the URL parameter
if (isset($_GET['id'])) {
    $studentID = $_GET['id'];

    // Fetch student data from the database based on the student ID
    $query = "SELECT * FROM tbl_user WHERE id_user = ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$studentID]);

    $studentData = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $_SESSION['message'] = "Invalid student ID";
    header('Location: index.php'); // Redirect to the main page
    exit();
}
?>

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

                <h1>Edit User</h1>

                <?php if (!empty($_SESSION['message'])) : ?>
                    <p><?php echo $_SESSION['message']; ?></p>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>
                <div class="table-responsive">
                <form action="config/update_user.php" method="post">
                    <div class="form-group">
                        <label for="editFirstName">First Name:</label>
                        <input type="text" class="form-control" id="editFirstName" name="editFirstName" value="<?php echo $studentData['firstname']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="editMiddleName">Middle Name:</label>
                        <input type="text" class="form-control" id="editMiddleName" name="editMiddleName" value="<?php echo $studentData['middlename']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="editLastName">Last Name:</label>
                        <input type="text" class="form-control" id="editLastName" name="editLastName" value="<?php echo $studentData['lastname']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="editCourse">Username:</label>
                        <input type="text" class="form-control" id="editCourse" name="editCourse" value="<?php echo $studentData['username']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="editYear">Password:</label>
                        <input type="text" class="form-control" id="editYear" name="editYear" value="<?php echo $studentData['password']; ?>">
                    </div>
                    <input type="hidden" name="studentId" value="<?php echo $studentData['id_user']; ?>">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
                </div>

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