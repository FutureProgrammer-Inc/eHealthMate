<?php
session_start();

require 'config/db_config.php'; // Adjust the path to your database config file
require 'student/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['import'])) {
    $allowed_ext = ['xls', 'csv', 'xlsx'];
    $inputFileNamePath = $_FILES['import_file']['tmp_name'];
    $spreadsheet = IOFactory::load($inputFileNamePath);
    $data = $spreadsheet->getActiveSheet()->toArray();
    $successCount = 0;

    try {
        $studentQuery = "INSERT INTO tbl_student (STUDENT_ID, FIRSTNAME, MIDDLENAME, LASTNAME, COURSE, YEAR, GENDER, ADDRESS, CONTACT_NO, CITIZENSHIP)
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($studentQuery);

        foreach ($data as $row) {
            list($STUDENT_ID, $FIRSTNAME, $MIDDLENAME, $LASTNAME, $COURSE, $YEAR, $GENDER, $ADDRESS, $CONTACT_NO, $CITIZENSHIP) = $row;
            if ($stmt->execute([$STUDENT_ID, $FIRSTNAME, $MIDDLENAME, $LASTNAME, $COURSE, $YEAR, $GENDER, $ADDRESS, $CONTACT_NO, $CITIZENSHIP])) {
                $successCount++;
            }
        }

        $_SESSION['message'] = ($successCount > 0) ? "Successfully Imported $successCount records" : "No records imported";
        header('Location: index.php'); // Redirect to the same page
        exit();
    } catch (PDOException $e) {
        $_SESSION['message'] = "Error: " . $e->getMessage();
        header('Location: index.php'); // Redirect to the same page
        exit();
    }
}

// Fetch data from the database
$query = "SELECT * FROM tbl_student";
$result = $con->query($query);

$data = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imported Data</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <h1>Imported Data</h1>



    <!-- Button to Open Import Modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importModal">Import Data</button>

    <!-- Display Imported Data -->
    <table class="table">
        <tr>
            <th>Student ID</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Course</th>
            <th>Year</th>
            <th>Gender</th>
            <th>Address</th>
            <th>Contact No</th>
            <th>Citizenship</th>
            <th>Operation</th>
        </tr>
        <?php if (!empty($_SESSION['message'])) : ?>
            <p><?php echo $_SESSION['message']; ?></p>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        <?php foreach ($data as $row) : ?>
            <tr>
                <td><?php echo $row['STUDENT_ID']; ?></td>
                <td><?php echo $row['FIRSTNAME']; ?></td>
                <td><?php echo $row['MIDDLENAME']; ?></td>
                <td><?php echo $row['LASTNAME']; ?></td>
                <td><?php echo $row['COURSE']; ?></td>
                <td><?php echo $row['YEAR']; ?></td>
                <td><?php echo $row['GENDER']; ?></td>
                <td><?php echo $row['ADDRESS']; ?></td>
                <td><?php echo $row['CONTACT_NO']; ?></td>
                <td><?php echo $row['CITIZENSHIP']; ?></td>
                <!-- Inside the foreach loop where you display the data -->
                <td>
                    <a href="#" class="btn btn-info view-btn" data-toggle="modal" data-target="#viewModal<?php echo $row['STUDENT_ID']; ?>">View</a>
                    <a href="#" class="btn btn-warning edit-btn" data-toggle="modal" data-target="#editModal<?php echo $row['STUDENT_ID']; ?>">Edit</a>
                    <a href="delete.php?id=<?php echo $row['STUDENT_ID']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                </td>

            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="index.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="import_file">Choose File:</label>
                            <input type="file" name="import_file" id="import_file">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="import">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Add modals for view and edit -->
    <?php foreach ($data as $row) : ?>

        <!-- View Modal -->
        <div class="modal fade" id="viewModal<?php echo $row['STUDENT_ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel<?php echo $row['STUDENT_ID']; ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel<?php echo $row['STUDENT_ID']; ?>">View Student Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Display student details here -->
                        <p>Student ID: <?php echo $row['STUDENT_ID']; ?></p>
                        <p>First Name: <?php echo $row['FIRSTNAME']; ?></p>
                        <p>Middle Name: <?php echo $row['MIDDLENAME']; ?></p>
                        <p>Last Name: <?php echo $row['LASTNAME']; ?></p>
                        <p>Course: <?php echo $row['COURSE']; ?></p>
                        <p>Year: <?php echo $row['YEAR']; ?></p>
                        <p>Gender: <?php echo $row['GENDER']; ?></p>
                        <p>Address: <?php echo $row['ADDRESS']; ?></p>
                        <p>Contact No: <?php echo $row['CONTACT_NO']; ?></p>
                        <p>Citizenship: <?php echo $row['CITIZENSHIP']; ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal<?php echo $row['STUDENT_ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $row['STUDENT_ID']; ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel<?php echo $row['STUDENT_ID']; ?>">Edit Student Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="edit.php?id=<?php echo $row['STUDENT_ID']; ?>" method="post">
                            <div class="form-group">
                                <label for="firstname">First Name:</label>
                                <input type="text" name="firstname" class="form-control" value="<?php echo $row['FIRSTNAME']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="middlename">Middle Name:</label>
                                <input type="text" name="middlename" class="form-control" value="<?php echo $row['MIDDLENAME']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name:</label>
                                <input type="text" name="lastname" class="form-control" value="<?php echo $row['LASTNAME']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="course">Course:</label>
                                <input type="text" name="course" class="form-control" value="<?php echo $row['COURSE']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="year">Year:</label>
                                <input type="text" name="year" class="form-control" value="<?php echo $row['YEAR']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender:</label>
                                <input type="text" name="gender" class="form-control" value="<?php echo $row['GENDER']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <input type="text" name="address" class="form-control" value="<?php echo $row['ADDRESS']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="contact_no">Contact No:</label>
                                <input type="text" name="contact_no" class="form-control" value="<?php echo $row['CONTACT_NO']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="citizenship">Citizenship:</label>
                                <input type="text" name="citizenship" class="form-control" value="<?php echo $row['CITIZENSHIP']; ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>