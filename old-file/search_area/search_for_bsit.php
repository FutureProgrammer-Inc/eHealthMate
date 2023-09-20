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
            $query = $con->prepare("SELECT * FROM tbl_student WHERE COURSE = 'BSIT'");
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
                        <a class="btn btn-info view-btn" data-toggle="modal" data-target="#viewModal" data-student-id="<?php echo $row['STUDENT_ID']; ?>">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<?php foreach ($data as $row) : ?>
    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
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
                    <p><img src="img\isu-logo.ico" alt="picture" width="40px"></p>
                    <table>
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
                    </table>
                </div>
                <div class="modal-footer">
                    <a href="view.php?id=<?php echo $row['STUDENT_ID']; ?>" class="btn btn-success">View</a> <!-- Changed from "Save to Docs" to "View" -->
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
        const $viewModal = $('#viewModal');

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
                const operationCell = `
                    <td class="cell">
                        <a class="btn btn-info view-btn" data-toggle="modal" data-target="#viewModal" data-student-id="${row.STUDENT_ID}">View</a>
                    </td>`;
                const rowHtml = `
                    <tr>
                        <td class="cell">${row.STUDENT_ID}</td>
                        <td class="cell">${row.FIRSTNAME}</td>
                        <td class="cell">${row.MIDDLENAME}</td>
                        <td class="cell">${row.LASTNAME}</td>
                        <td class="cell">${row.COURSE}</td>
                        <td class="cell">${row.YEAR}</td>
                        ${operationCell}
                    </tr>`;
                $table.append(rowHtml);
            });
        }

        // View button click event
        $viewModal.on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const studentId = button.data('student-id');
            // Additional code to load modal content based on studentId...
        });
    });
</script>