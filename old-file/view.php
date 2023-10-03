<?php
session_start();
if (!isset($_SESSION['auth'])) {
    header('location: login.php');
}
include 'template\header.php';
require 'config/db_config.php'; // Adjust the path to your database config file

// Get the student ID from the URL parameter
if (isset($_GET['id'])) {
    $studentID = $_GET['id'];

    // Fetch student data from the database based on the student ID
    $query = "SELECT * FROM tbl_student WHERE STUDENT_ID = ?";
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

                <h1>Student Details</h1>

                <?php if (!empty($_SESSION['message'])) : ?>
                    <p><?php echo $_SESSION['message']; ?></p>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>
                <div class="table-responsive">
                    <table class="table app-table-hover mb-0 text-left">
                        <tr>
                            <th>Attribute</th>
                            <th>Value</th>
                        </tr>
                        <tr>
                            <td>Student ID:</td>
                            <td><?php echo $studentData['STUDENT_ID']; ?></td>
                        </tr>
                        <tr>
                            <td>First Name:</td>
                            <td><?php echo $studentData['FIRSTNAME']; ?></td>
                        </tr>
                        <tr>
                            <td>Middle Name:</td>
                            <td><?php echo $studentData['MIDDLENAME']; ?></td>
                        </tr>
                        <tr>
                            <td>Last Name:</td>
                            <td><?php echo $studentData['LASTNAME']; ?></td>
                        </tr>
                        <tr>
                            <td>Course:</td>
                            <td><?php echo $studentData['COURSE']; ?></td>
                        </tr>
                        <tr>
                            <td>Year:</td>
                            <td><?php echo $studentData['YEAR']; ?></td>
                        </tr>
                        <tr>
                            <td>Gender:</td>
                            <td><?php echo $studentData['GENDER']; ?></td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td><?php echo $studentData['ADDRESS']; ?></td>
                        </tr>
                        <tr>
                            <td>Contact No:</td>
                            <td><?php echo $studentData['CONTACT_NO']; ?></td>
                        </tr>
                        <tr>
                            <td>Citizenship:</td>
                            <td><?php echo $studentData['CITIZENSHIP']; ?></td>
                        </tr>
                    </table>
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