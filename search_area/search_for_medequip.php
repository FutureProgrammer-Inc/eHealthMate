<body>
    <div class="table-responsive">
        <table class="table app-table-hover mb-0 text-left" id="medequip-table">
            <!-- Table header -->
            <thead>
                <tr>
                    <th>MedEquip Name</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>
                <!-- Table rows will be generated here -->
                <?php
                include('config/db_config.php');

                // Fetch medequip data
                $query = $con->prepare("SELECT * FROM tbl_medequip");
                $query->execute();
                $medequipData = $query->fetchAll(PDO::FETCH_ASSOC);

                foreach ($medequipData as $equipment) :
                ?>
                    <tr>
                        <td class="cell"><?php echo $equipment['MEDEQUIP_NAME']; ?></td>
                        <td class="cell"><?php echo $equipment['DESCRIPTION']; ?></td>
                        <td class="cell"><?php echo $equipment['QUANTITY']; ?></td>
                        <td class="cell"><?php echo $equipment['PRICE']; ?></td>
                        <td class="cell">
                            <a class="btn btn-info view-btn" data-toggle="modal" data-target="#viewMedEquipModal<?php echo $equipment['ID_MEDEQUIP']; ?>">View</a>
                            <button class="btn btn-danger delete-btn" data-equipmentid="<?php echo $equipment['ID_MEDEQUIP']; ?>">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modals for MedEquip Data -->
    <?php foreach ($medequipData as $equipment) : ?>
        <div class="modal fade" id="viewMedEquipModal<?php echo $equipment['ID_MEDEQUIP']; ?>" tabindex="-1" role="dialog" aria-labelledby="viewMedEquipModalLabel<?php echo $equipment['ID_MEDEQUIP']; ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewMedEquipModalLabel<?php echo $equipment['ID_MEDEQUIP']; ?>">View MedEquip Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Display medequip details here -->
                        <table>
                            <tr>
                                <td>MedEquip ID:</td>
                                <td><?php echo $equipment['ID_MEDEQUIP']; ?></td>
                            </tr>
                            <tr>
                                <td>MedEquip Name:</td>
                                <td><?php echo $equipment['MEDEQUIP_NAME']; ?></td>
                            </tr>
                            <tr>
                                <td>Description:</td>
                                <td><?php echo $equipment['DESCRIPTION']; ?></td>
                            </tr>
                            <tr>
                                <td>Quantity:</td>
                                <td><?php echo $equipment['QUANTITY']; ?></td>
                            </tr>
                            <tr>
                                <td>Price:</td>
                                <td><?php echo $equipment['PRICE']; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <a href="edit_medequip.php?id=<?php echo $equipment['ID_MEDEQUIP']; ?>" class="btn btn-primary">Edit</a>
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
            const $table = $('#medequip-table tbody');
            const $searchInput = $('#search-medequip');
            const $searchButton = $('#search-button');
            const $showAllButton = $('#show-all-medequip-button');

            const initialData = <?php echo json_encode($medequipData); ?>;
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
                const equipmentId = $(this).data('equipmentid');

                if (confirm('Are you sure you want to delete this equipment?')) {
                    $.ajax({
                        type: 'POST',
                        url: 'delete_medequip.php',
                        data: {
                            equipmentId: equipmentId
                        },
                        success: function(response) {
                            if (response === 'success') {
                                $(this).closest('tr').remove();
                                alert('Equipment deleted successfully.');
                            } else {
                                alert('Error deleting equipment. Please try again.');
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
                        <a class="btn btn-info view-btn" data-toggle="modal" data-target="#viewMedEquipModal${row.ID_MEDEQUIP}">View</a>
                        <button class="btn btn-danger delete-btn" data-equipmentid="${row.ID_MEDEQUIP}">Delete</button>
                    </td>`;
                    const rowHtml = `
                    <tr>
                        <td class="cell">${row.MEDEQUIP_NAME}</td>
                        <td class="cell">${row.DESCRIPTION}</td>
                        <td class="cell">${row.QUANTITY}</td>
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