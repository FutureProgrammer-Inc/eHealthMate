<div class="table-responsive">
    <table class="table app-table-hover mb-0 text-left" id="student-table">
        <!-- Table header -->
        <thead>
            <tr>
                <th>Medical Name</th>
                <th>Description</th>
                <th>Expiration</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
            <!-- Table rows will be generated here -->
            <?php
            include('config/db_config.php');

            // Fetch student data with course "BSIT"
            $query = $con->prepare("SELECT * FROM tbl_medicine");
            $query->execute();
            $data = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $row) :
            ?>
                <tr>
                    <td class="cell"><?php echo $row['MED_NAME']; ?></td>
                    <td class="cell"><?php echo $row['DESCRIPTION']; ?></td>
                    <td class="cell"><?php echo $row['EXPIRATION']; ?></td>
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
                    <h5 class="modal-title" id="viewModalLabel<?php echo $row['MED_NAME']; ?>">View Student Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Display student details here -->
                    <p><img src="img\isu-logo.ico" alt="picture" width="40px"></p>
                    <table>
                        <p>Medicine Name: <?php echo $row['MED_NAME']; ?></p>
                        <p>Description: <?php echo $row['DESCRIPTION']; ?></p>
                        <p>Expiration: <?php echo $row['EXPIRATION']; ?></p>
                    </table>
                </div>
                <div class="modal-footer">
                    <a href="view.php?id=<?php echo $row['MED_NAME']; ?>" class="btn btn-primary">Edit</a> <!-- Changed from "Save to Docs" to "View" -->
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
                        <td class="cell">${row.MED_NAME}</td>
                        <td class="cell">${row.DESCRIPTION}</td>
                        <td class="cell">${row.EXPIRATION}</td>
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