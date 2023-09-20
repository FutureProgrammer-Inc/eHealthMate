<?php
session_start();
if (!isset($_SESSION['auth'])) {
    header('location: login.php');
}
include 'template\header.php';
require 'config\db_config.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['import'])) {
    $allowed_ext = ['xls', 'csv', 'xlsx'];
    $inputFileNamePath = $_FILES['import_file']['tmp_name'];
    $spreadsheet = IOFactory::load($inputFileNamePath);
    $data = $spreadsheet->getActiveSheet()->toArray();
    $successCount = 0;

    try {
        $medicineQuery = "INSERT INTO tbl_medicine (ID_MEDICINE, MED_NAME, DESCRIPTION, QUANTITY, PRICE, EXPIRATION)
                          VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($medicineQuery);

        foreach ($data as $row) {
            list($ID_MEDICINE, $MED_NAME, $DESCRIPTION, $QUANTITY, $PRICE, $EXPIRATION) = $row;
            if ($stmt->execute([$ID_MEDICINE, $MED_NAME, $DESCRIPTION, $QUANTITY, $PRICE, $EXPIRATION])) {
                $successCount++;
            }
        }

        $_SESSION['message'] = ($successCount > 0) ? "Successfully Imported $successCount records" : "No records imported";
        header('Location: medicine.php'); // Redirect to the same page
        exit();
    } catch (PDOException $e) {
        $_SESSION['message'] = "Error: " . $e->getMessage();
        header('Location: medicine.php'); // Redirect to the same page
        exit();
    }
}

// Fetch data from the database
$query = "SELECT * FROM tbl_medicine";
$result = $con->query($query);

$data = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $row;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medName = $_POST['medName'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $expiration = $_POST['expiration'];

    try {
        $insertQuery = "INSERT INTO tbl_medicine (MED_NAME, DESCRIPTION, QUANTITY, PRICE, EXPIRATION) 
                        VALUES (?, ?, ?, ?, ?)";
        $stmt = $con->prepare($insertQuery);
        $stmt->execute([$medName, $description, $quantity, $price, $expiration]);

        $_SESSION['message'] = "Medicine added successfully!";
        header('Location: inventory.php'); // Redirect to the inventory page
        exit();
    } catch (PDOException $e) {
        $_SESSION['message'] = "Error: " . $e->getMessage();
        header('Location: inventory.php'); // Redirect to the inventory page with an error message
        exit();
    }
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

                <h1 class="app-page-title">Inventory</h1>

                <?php
                include 'card-monitoring/card-bsit-student.php';
                // include 'student/import_student.php';
                ?>
                <div class="row g-3 mb-4 align-items-center justify-content-between">
                    <div class="col-auto">
                        <h1 class="app-page-title mb-0"></h1>
                    </div>
                    <div class="col-auto">
                        <div class="page-utilities">
                            <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                                <div class="col-auto">
                                    <form class="table-search-form row gx-1 align-items-center">
                                        <div class="col-auto">
                                            <input type="text" id="search-orders" name="searchorders" class="form-control search-orders" placeholder="Search">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn app-btn-secondary">Search</button>
                                        </div>
                                    </form>

                                </div><!--//col-->
                                <div class="col-auto">

                                    <select class="form-select w-auto">
                                        <option selected value="option-1">All</option>
                                        <option value="option-2">This week</option>
                                        <option value="option-3">This month</option>
                                        <option value="option-4">Last 3 months</option>

                                    </select>
                                </div>


                                <div class="col-auto">
                                    <button type="button" class="btn app-btn-secondary" id="showAddMedicineModal" data-toggle="modal" data-target="#addMedicineModal">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus me-1" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                            <path fill-rule="evenodd" d="M8 1a1 1 0 0 1 1 1v6h6a1 1 0 0 1 0 2H9v6a1 1 0 0 1-2 0V9H1a1 1 0 0 1 0-2h6V2a1 1 0 0 1 1-1z" />
                                        </svg>
                                        Add Medicine
                                    </button>
                                </div>

                            </div><!--//row-->
                        </div><!--//table-utilities-->
                    </div><!--//col-auto-->
                </div><!--//row-->


                <?php if (!empty($_SESSION['message'])) : ?>
                    <p><?php echo $_SESSION['message']; ?></p>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>


                <div class="tab-content" id="orders-table-tab-content">
                    <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
                        <div class="app-card app-card-orders-table shadow-sm mb-5">
                            <div class="app-card-body">
                                <div class="table-responsive">
                                    <table class="table app-table-hover mb-0 text-left">
                                        <thead>
                                            <tr>
                                                <th>Medicine ID</th>
                                                <th>Medicine Name</th>
                                                <th>Description</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Expiration</th>
                                                <th>Operation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data as $row) : ?>
                                                <tr>
                                                    <td class="cell"><?php echo $row['ID_MEDICINE']; ?></td>
                                                    <td class="cell"><?php echo $row['MED_NAME']; ?></td>
                                                    <td class="cell"><?php echo $row['DESCRIPTION']; ?></td>
                                                    <td class="cell"><?php echo $row['QUANTITY']; ?></td>
                                                    <td class="cell"><?php echo $row['PRICE']; ?></td>
                                                    <td class="cell"><?php echo $row['EXPIRATION']; ?></td>
                                                    <!-- Inside the foreach loop where you display the data -->
                                                    <td class="cell">
                                                        <a class="btn btn-info view-btn" data-toggle="modal" data-target="#viewModal<?php echo $row['ID_MEDICINE']; ?>">View</a>
                                                    </td>

                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div><!--//table-responsive-->
                            </div><!--//app-card-body-->
                        </div><!--//app-card-->
                    </div><!--//tab-pane-->
                </div><!--//tab-content-->
            </div><!--//container-xl-->
        </div><!--//app-content-->
    </div><!--//app-wrapper-->


    <?php
    include 'partials/footer.php';
    include 'template/scripts.php';
    ?>

    <!-- Add Medicine Modal -->
    <div class="modal fade" id="addMedicineModal" tabindex="-1" role="dialog" aria-labelledby="addMedicineModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMedicineModalLabel">Add New Medicine</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add form fields here for adding new medicine -->
                    <form action="inventory.php" method="post">
                        <div class="form-group">
                            <label for="medName">Medicine Name</label>
                            <input type="text" class="form-control" id="medName" name="medName" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="expiration">Expiration</label>
                            <input type="date" class="form-control" id="expiration" name="expiration" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Medicine</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Medicine Modal -->
    <div class="modal fade" id="viewModal<?php echo $row['ID_MEDICINE']; ?>" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel<?php echo $row['ID_MEDICINE']; ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel<?php echo $row['ID_MEDICINE']; ?>">View Medicine Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Display medicine details here -->
                    <p>Medicine ID: <?php echo $row['ID_MEDICINE']; ?></p>
                    <p>Medicine Name: <?php echo $row['MED_NAME']; ?></p>
                    <p>Description: <?php echo $row['DESCRIPTION']; ?></p>
                    <p>Quantity: <?php echo $row['QUANTITY']; ?></p>
                    <p>Price: <?php echo $row['PRICE']; ?></p>
                    <p>Expiration: <?php echo $row['EXPIRATION']; ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    // Function to open the "Add Medicine" modal
    function openAddMedicineModal() {
        $('#addMedicineModal').modal('show');
    }

    // Call the function when the button is clicked
    document.getElementById('addMedicineBtn').addEventListener('click', openAddMedicineModal);

    // Handle form submission
    document.getElementById('submitMedicineBtn').addEventListener('click', function() {
        // Get form data and process it (e.g., send it to the server)
        // Close the modal after processing
        $('#addMedicineModal').modal('hide');
    });
</script>

</html>