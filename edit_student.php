<?php
session_start();
if (!isset($_SESSION['auth'])) {
    header('location: login.php');
}
include 'template/header.php';
require 'config/db_config.php'; // Adjust the path to your database config file

// Get the student ID from the URL parameter
if (isset($_GET['id'])) {
    $studentID = $_GET['id'];

    // Fetch student data from the database based on the ID
    $query = "SELECT * FROM tbl_student WHERE ID_STUDENT = ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$studentID]);

    $studentData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$studentData) {
        $_SESSION['message'] = "Student not found";
        header('Location: index.php'); // Redirect to the student listing page
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
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $course = $_POST['course'];
    $year = $_POST['year'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $address = $_POST['address'];
    $contact_no = $_POST['contact_no'];
    $citizenship = $_POST['citizenship'];

    // Update the student data in the database
    $updateQuery = "UPDATE tbl_student SET STUDENT_ID = ?, FIRSTNAME = ?, MIDDLENAME = ?, LASTNAME = ?, COURSE = ?, YEAR = ?, GENDER = ?, BIRTHDATE = ?, ADDRESS = ?, CONTACT_NO = ?, CITIZENSHIP = ? WHERE ID_STUDENT = ?";
    $updateStmt = $con->prepare($updateQuery);
    $success = $updateStmt->execute([$student_id, $firstname, $middlename, $lastname, $course, $year, $gender, $birthdate, $address, $contact_no, $citizenship, $studentID]);

    if ($success) {
        $_SESSION['message'] = "Student updated successfully!";
        // Determine the course and redirect accordingly
        if ($course === 'BSIT') {
            header('Location: bsit-student.php'); // Redirect to the BSIT student listing page
        } elseif ($course === 'BSA') {
            header('Location: bsa-student.php'); // Redirect to the BSA student listing page
        } else {
            header('Location: index.php'); // Redirect to a default page if the course is neither BSIT nor BSA
        }
        exit();
    } else {
        $_SESSION['message'] = "Error updating student";
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

                <h1>Edit Student Information</h1>

                <?php if (!empty($_SESSION['message'])) : ?>
                    <p><?php echo $_SESSION['message']; ?></p>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>

                <!-- Your form for editing student information goes here -->
                <form action="edit_student.php?id=<?php echo $studentID; ?>" method="post">
                    <div class="mb-3">
                        <label for="student_id">Student ID</label>
                        <input type="text" class="form-control" id="student_id" name="student_id" value="<?php echo $studentData['STUDENT_ID']; ?>" required pattern="[0-9]*">
                    </div>
                    <div class="mb-3">
                        <label for="firstname">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $studentData['FIRSTNAME']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="middlename">Middle Name</label>
                        <input type="text" class="form-control" id="middlename" name="middlename" value="<?php echo $studentData['MIDDLENAME']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="lastname">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $studentData['LASTNAME']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="course">Course</label>
                        <select class="form-control" id="course" name="course" required>
                            <option value="BSIT" <?php if ($studentData['COURSE'] === 'BSIT') echo 'selected'; ?>>BSIT</option>
                            <option value="BSA" <?php if ($studentData['COURSE'] === 'BSA') echo 'selected'; ?>>BSA</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="year">Year</label>
                        <select class="form-control" id="year" name="year" required>
                            <option value="1" <?php if ($studentData['YEAR'] === '1') echo 'selected'; ?>>1</option>
                            <option value="2" <?php if ($studentData['YEAR'] === '2') echo 'selected'; ?>>2</option>
                            <option value="3" <?php if ($studentData['YEAR'] === '3') echo 'selected'; ?>>3</option>
                            <option value="4" <?php if ($studentData['YEAR'] === '4') echo 'selected'; ?>>4</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="Male" <?php if ($studentData['GENDER'] === 'Male') echo 'selected'; ?>>Male</option>
                            <option value="Female" <?php if ($studentData['GENDER'] === 'Female') echo 'selected'; ?>>Female</option>
                            <option value="Other" <?php if ($studentData['GENDER'] === 'Other') echo 'selected'; ?>>Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="birthdate">Birthdate</label>
                        <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo $studentData['BIRTHDATE']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo $studentData['ADDRESS']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact_no">Contact No</label>
                        <input type="text" class="form-control" id="contact_no" name="contact_no" value="<?php echo $studentData['CONTACT_NO']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="citizenship">Citizenship</label>
                        <input type="text" class="form-control" id="citizenship" name="citizenship" value="<?php echo $studentData['CITIZENSHIP']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Student Information</button>
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



    <script>
        // for student id
        document.addEventListener("DOMContentLoaded", function() {
            const studentIdInput = document.getElementById("student_id");

            studentIdInput.addEventListener("input", function() {
                let inputValue = studentIdInput.value;

                // Remove non-numeric characters
                inputValue = inputValue.replace(/[^0-9]/g, '');

                // Ensure the input contains exactly seven digits
                if (inputValue.length > 7) {
                    inputValue = inputValue.substring(0, 7);
                }

                studentIdInput.value = inputValue; // Update the input value
            });
        });

        // for alphabet
        document.addEventListener("DOMContentLoaded", function() {
            const firstNameInput = document.getElementById("firstname");
            const middleNameInput = document.getElementById("middlename");
            const lastNameInput = document.getElementById("lastname");
            const citizenshipInput = document.getElementById("citizenship");

            function validateAlphabeticInput(input) {
                let inputValue = input.value;

                // Remove non-alphabetic characters
                inputValue = inputValue.replace(/[^A-Za-z]/g, '');

                input.value = inputValue; // Update the input value
            }

            firstNameInput.addEventListener("input", function() {
                validateAlphabeticInput(firstNameInput);
            });

            middleNameInput.addEventListener("input", function() {
                validateAlphabeticInput(middleNameInput);
            });

            lastNameInput.addEventListener("input", function() {
                validateAlphabeticInput(lastNameInput);
            });

            citizenshipInput.addEventListener("input", function() {
                validateAlphabeticInput(citizenshipInput);
            });
        });

        // for phone number
        document.addEventListener("DOMContentLoaded", function() {
            const contactNoInput = document.getElementById("contact_no");

            contactNoInput.addEventListener("input", function() {
                let inputValue = contactNoInput.value;

                // Remove non-numeric characters
                inputValue = inputValue.replace(/[^0-9]/g, '');

                // Ensure the input contains exactly 11 digits
                if (inputValue.length > 11) {
                    inputValue = inputValue.substring(0, 11);
                }

                contactNoInput.value = inputValue; // Update the input value
            });
        });
    </script>



</body>

</html>