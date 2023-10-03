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

<!-- Modals -->
<!-- Modals for BSIT Students -->
<?php foreach ($data as $row) : ?>
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
                    <table>
                        <tr>
                            <td>Student ID:</td>
                            <td><?php echo $row['STUDENT_ID']; ?></td>
                        </tr>
                        <tr>
                            <td>First Name:</td>
                            <td><?php echo $row['FIRSTNAME']; ?></td>
                        </tr>
                        <tr>
                            <td>Middle Name:</td>
                            <td><?php echo $row['MIDDLENAME']; ?></td>
                        </tr>
                        <tr>
                            <td>Last Name:</td>
                            <td><?php echo $row['LASTNAME']; ?></td>
                        </tr>
                        <tr>
                            <td>Course:</td>
                            <td><?php echo $row['COURSE']; ?></td>
                        </tr>
                        <tr>
                            <td>Year:</td>
                            <td><?php echo $row['YEAR']; ?></td>
                        </tr>
                        <tr>
                            <td>Gender:</td>
                            <td><?php echo $row['GENDER']; ?></td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td><?php echo $row['ADDRESS']; ?></td>
                        </tr>
                        <tr>
                            <td>Contact No:</td>
                            <td><?php echo $row['CONTACT_NO']; ?></td>
                        </tr>
                        <tr>
                            <td>Citizenship:</td>
                            <td><?php echo $row['CITIZENSHIP']; ?></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <a href="edit_student.php?id=<?php echo $row['ID_STUDENT']; ?>" class="btn btn-primary">Edit</a>
                    <a href="edit_student.php?id=<?php echo $row['ID_STUDENT']; ?>" class="btn btn-success">Print</a>
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
                const operationCell = `
                    <td class="cell">
                        <a class="btn btn-info view-btn" data-toggle="modal" data-target="#viewModal${row.STUDENT_ID}">View</a>
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
        };

    });
</script>