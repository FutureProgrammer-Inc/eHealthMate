<div class="table-responsive">
    <table class="table app-table-hover mb-0 text-left" id="student-table">
        <!-- Table header -->
        <thead>
            <tr>
                <th>Student ID</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Course</th>
                <th>Year</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
            <!-- Table rows will be generated here -->
            <?php
            include('config/db_config.php');

            // Fetch student data with course "BSIT"
            $query = $con->prepare("SELECT * FROM tbl_student");
            $query->execute();
            $data = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $row) :
            ?>
                <tr>
                    <td class="cell"><?php echo $row['STUDENT_ID']; ?></td>
                    <td class="cell"><?php echo $row['FIRSTNAME']; ?></td>
                    <td class="cell"><?php echo $row['MIDDLENAME']; ?></td>
                    <td class="cell"><?php echo $row['LASTNAME']; ?></td>
                    <td class="cell"><?php echo $row['COURSE']; ?></td>
                    <td class="cell"><?php echo $row['YEAR']; ?></td>
                    <td class="cell">
                        <a class="btn btn-info view-btn" data-toggle="modal" data-target="#viewModal<?php echo $row['STUDENT_ID']; ?>">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modals --><!-- Modals for BSIT Students -->
<!-- Modals for BSIT Students -->
<?php foreach ($data as $row) : ?>
    <div class="modal fade" id="diagnoseModal<?php echo $row['STUDENT_ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="diagnoseModalLabel<?php echo $row['STUDENT_ID']; ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="diagnoseModalLabel<?php echo $row['STUDENT_ID']; ?>">Diagnose Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Student Information</h5>
                    <p><strong>Name:</strong> <?php echo $row['FIRSTNAME'] . ' ' . $row['LASTNAME']; ?></p>
                    <p><strong>Course:</strong> <?php echo $row['COURSE']; ?></p>
                    <p><strong>Year:</strong> <?php echo $row['YEAR']; ?></p>

                    <h5>Diagnosis</h5>
                    <!-- Display diagnosis, medicine, and instructions here -->
                    <p><strong>Diagnosis:</strong> <?php echo isset($_POST['diagnosis']) ? $_POST['diagnosis'] : ''; ?></p>
                    <p><strong>Medicine:</strong> <?php echo isset($_POST['medicine']) ? $_POST['medicine'] : ''; ?></p>
                    <p><strong>Instructions:</strong> <?php echo isset($_POST['instructions']) ? $_POST['instructions'] : ''; ?></p>

                    <!-- Diagnose form -->
                    <form action="consult_for_diagnose.php?id=<?php echo $row['STUDENT_ID']; ?>" method="post" onsubmit="return validateDiagnosisForm()">
                        <div class="mb-3">
                            <label for="diagnosis">Diagnosis</label>
                            <textarea class="form-control" id="diagnosis" name="diagnosis" rows="4" required></textarea>
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

                                while ($medicineData = $medicineStmt->fetch(PDO::FETCH_ASSOC)) {
                                    $medicineID = $medicineData['ID_MEDICINE'];
                                    $medicineName = $medicineData['MED_NAME'];
                                    echo "<option value='$medicineName'>$medicineName</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="instructions">Instructions</label>
                            <textarea class="form-control" id="instructions" name="instructions" rows="4"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Diagnose</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const $table = $('#student-table tbody');
        const $searchInput = $('#search-orders');
        const $searchButton = $('#search-button');
        const $showAllButton = $('#show-all-button');

        const initialData = <?php echo json_encode($data); ?>;
        let currentData = initialData;

        // Display initial data
        updateTable(currentData);

        // Search button click event
        $searchButton.click(function(e) {
            e.preventDefault();
            const searchTerm = $searchInput.val().toLowerCase();
            const filteredData = initialData.filter(row => {
                const values = Object.values(row).map(value => value.toString().toLowerCase());
                return values.some(value => value.includes(searchTerm));
            });
            updateTable(filteredData);
        });

        // Show All button click event
        $showAllButton.click(function() {
            currentData = initialData;
            updateTable(currentData);
        });

        // Function to update the table content
        function updateTable(data) {
            $table.empty();
            data.forEach(row => {
                const rowHtml = `
                    <tr>
                        <td class="cell">${row.STUDENT_ID}</td>
                        <td class="cell">${row.FIRSTNAME}</td>
                        <td class="cell">${row.MIDDLENAME}</td>
                        <td class="cell">${row.LASTNAME}</td>
                        <td class="cell">${row.COURSE}</td>
                        <td class="cell">${row.YEAR}</td>
                        <td class="cell">
                            <a class="btn btn-primary diagnose-btn" data-toggle="modal" data-target="#diagnoseModal${row.STUDENT_ID}">Diagnose</a>
                        </td>
                    </tr>`;
                $table.append(rowHtml);
            });
        }

        // Function to validate the diagnosis form
        function validateDiagnosisForm() {
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

    });
</script>