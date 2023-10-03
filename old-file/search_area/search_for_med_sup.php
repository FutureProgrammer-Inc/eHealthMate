<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Supplies Management</title>
    <!-- Add your CSS and Bootstrap CDN links here -->
</head>

<body>
    <div class="table-responsive">
        <table class="table app-table-hover mb-0 text-left" id="medsup-table">
            <!-- Table header -->
            <thead>
                <tr>
                    <th>Medical Supply Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>
                <!-- Table rows will be generated here -->
                <?php
                include('config/db_config.php');

                // Fetch medical supply data
                $query = $con->prepare("SELECT * FROM tbl_medsup");
                $query->execute();
                $medsupData = $query->fetchAll(PDO::FETCH_ASSOC);

                foreach ($medsupData as $medsup) :
                ?>
                    <tr>
                        <td class="cell"><?php echo $medsup['MEDSUP_NAME']; ?></td>
                        <td class="cell"><?php echo $medsup['DESCRIPTION']; ?></td>
                        <td class="cell"><?php echo $medsup['PRICE']; ?></td>
                        <td class="cell">
                            <a class="btn btn-info view-btn" data-toggle="modal" data-target="#viewMedSupModal<?php echo $medsup['ID_MEDSUP']; ?>">View</a>
                            <button class="btn btn-danger delete-btn" data-medsupid="<?php echo $medsup['ID_MEDSUP']; ?>">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modals for Medical Supplies -->
    <?php foreach ($medsupData as $medsup) : ?>
        <div class="modal fade" id="viewMedSupModal<?php echo $medsup['ID_MEDSUP']; ?>" tabindex="-1" role="dialog" aria-labelledby="viewMedSupModalLabel<?php echo $medsup['ID_MEDSUP']; ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewMedSupModalLabel<?php echo $medsup['ID_MEDSUP']; ?>">View Medical Supply Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Display medical supply details here -->
                        <table>
                            <tr>
                                <td>Medical Supply ID:</td>
                                <td><?php echo $medsup['ID_MEDSUP']; ?></td>
                            </tr>
                            <tr>
                                <td>Medical Supply Name:</td>
                                <td><?php echo $medsup['MEDSUP_NAME']; ?></td>
                            </tr>
                            <tr>
                                <td>Description:</td>
                                <td><?php echo $medsup['DESCRIPTION']; ?></td>
                            </tr>
                            <tr>
                                <td>Price:</td>
                                <td><?php echo $medsup['PRICE']; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <a href="edit_medsup.php?id=<?php echo $medsup['ID_MEDSUP']; ?>" class="btn btn-primary">Edit</a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- JavaScript code -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const $table = $('#medsup-table tbody');
            const $searchInput = $('#search-medsup');
            const $searchButton = $('#search-medsup-button');
            const $showAllButton = $('#show-all-medsup-button');

            const initialData = <?php echo json_encode($medsupData); ?>;
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

            // Delete button click event
            $table.on('click', '.delete-btn', function() {
                const medsupId = $(this).data('medsupid');

                if (confirm('Are you sure you want to delete this medical supply?')) {
                    $.ajax({
                        type: 'POST',
                        url: 'delete_medsup.php',
                        data: {
                            medsupId: medsupId
                        },
                        success: function(response) {
                            if (response === 'success') {
                                $(this).closest('tr').remove();
                                alert('Medical supply deleted successfully.');
                            } else if (response === 'not_found') {
                                alert('Medical supply not found.');
                            } else {
                                alert('Error deleting medical supply. Please try again.');
                            }
                        }.bind(this) // Bind the 'this' context to access the button inside the callback
                    });
                }
            });

            // Function to update the table content
            function updateTable(data) {
                $table.empty();
                data.forEach(row => {
                    const operationCell = `
                    <td class="cell">
                        <a class="btn btn-info view-btn" data-toggle="modal" data-target="#viewMedSupModal${row.ID_MEDSUP}">View</a>
                        <button class="btn btn-danger delete-btn" data-medsupid="${row.ID_MEDSUP}">Delete</button>
                    </td>`;
                    const rowHtml = `
                    <tr>
                        <td class="cell">${row.MEDSUP_NAME}</td>
                        <td class="cell">${row.DESCRIPTION}</td>
                        <td class="cell">${row.PRICE}</td>
                        ${operationCell}
                    </tr>`;
                    $table.append(rowHtml);
                });
            };
        });
    </script>
</body>

</html>