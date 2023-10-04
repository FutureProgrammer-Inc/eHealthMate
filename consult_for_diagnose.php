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

                <h1>Consultation</h1>

                <?php if (!empty($_SESSION['message'])) : ?>
                    <p><?php echo $_SESSION['message']; ?></p>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>

                <!-- Your form for editing consultation information goes here -->
                <form action="consult_for_diagnose.php?id=<?php echo $studentID; ?>" method="post" onsubmit="return validateForm()">
                    <!-- Display student name and course -->
                    <div class="mb-3">
                        <label for="student_info">Student Information</label>
                        <input type="text" class="form-control" id="student_info" name="student_info" value="<?php echo $studentData['FIRSTNAME'] . ' ' . $studentData['LASTNAME'] . ' - ' . $studentData['COURSE']; ?>" disabled>
                    </div>

                    <!-- Input fields for consultation information -->
                    <div class="mb-3">
                        <label for="diagnosis">Diagnosis</label>
                        <textarea class="form-control" id="diagnosis" name="diagnosis" rows="4" required><?php echo isset($_POST['diagnosis']) ? $_POST['diagnosis'] : ''; ?></textarea>
                        <span id="diagnosisError" class="text-danger"></span> <!-- Error message placeholder -->
                    </div>

                    <div class="mb-3">
                        <label for="medicine">Select Medicine</label>
                        <select class="form-control" id="medicine" name="medicine" required>
                            <option value="">Select Medicine</option> <!-- Default empty option -->
                            <?php
                            // Fetch medicine data from the database
                            $medicineQuery = "SELECT * FROM tbl_medicine";
                            $medicineStmt = $con->query($medicineQuery);

                            // Get the selected medicine ID from the form data
                            $selectedMedicineID = isset($_POST['medicine']) ? $_POST['medicine'] : '';

                            // Populate the dropdown with medicine options
                            while ($medicineData = $medicineStmt->fetch(PDO::FETCH_ASSOC)) {
                                $medicineID = $medicineData['ID_MEDICINE'];
                                $medicineName = $medicineData['MED_NAME'];
                                // Check if the current medicine option matches the selected medicine ID
                                $selected = ($medicineID == $selectedMedicineID) ? 'selected' : '';
                                echo "<option value='$medicineID' $selected>$medicineName</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="dosage">Dosage</label>
                        <input type="text" class="form-control" id="dosage" name="dosage" value="<?php echo isset($_POST['dosage']) ? $_POST['dosage'] : ''; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="instructions">Instructions</label>
                        <textarea class="form-control" id="instructions" name="instructions" rows="4"><?php echo isset($_POST['instructions']) ? $_POST['instructions'] : ''; ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Consultation Information</button>
                </form>

            </div><!--//container-fluid-->
        </div><!--//app-content-->
    </div><!--//app-wrapper-->

    <?php
    include 'template/scripts.php';
    ?>

    <script>
        // JavaScript code for validation and other functions can be added here
        function validateForm() {
            // Get the value of the diagnosis textarea
            var diagnosis = document.getElementById("diagnosis").value;

            // Check if the diagnosis is empty
            if (diagnosis.trim() === "") {
                // Display an error message
                document.getElementById("diagnosisError").innerHTML = "Diagnosis cannot be empty";
                return false; // Prevent form submission
            }

            // Clear any previous error message
            document.getElementById("diagnosisError").innerHTML = "";

            // If validation passes, allow form submission
            return true;
        }
    </script>



</body>

</html>