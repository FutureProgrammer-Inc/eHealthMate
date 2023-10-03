<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <!-- Add your CSS and Bootstrap CDN links here -->
</head>

<body>
    <div class="table-responsive">
        <table class="table app-table-hover mb-0 text-left" id="user-table">
            <!-- Table header -->
            <thead>
                <tr>
                    <th>Role</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>
                <!-- Table rows will be generated here -->
                <?php
                include('config/db_config.php');

                // Fetch user data
                $query = $con->prepare("SELECT * FROM tbl_user");
                $query->execute();
                $userData = $query->fetchAll(PDO::FETCH_ASSOC);

                foreach ($userData as $user) :
                ?>
                    <tr>
                        <td class="cell"><?php echo $user['ROLE']; ?></td>
                        <td class="cell"><?php echo $user['FIRSTNAME']; ?></td>
                        <td class="cell"><?php echo $user['MIDDLENAME']; ?></td>
                        <td class="cell"><?php echo $user['LASTNAME']; ?></td>
                        <td class="cell"><?php echo $user['EMAIL']; ?></td>
                        <td class="cell"><?php echo $user['USERNAME']; ?></td>
                        <td class="cell">
                            <a class="btn btn-info view-btn" data-toggle="modal" data-target="#viewUserModal<?php echo $user['ID_USER']; ?>">View</a>
                            <button class="btn btn-danger delete-btn" data-userid="<?php echo $user['ID_USER']; ?>">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modals for User Data -->
    <?php foreach ($userData as $user) : ?>
        <div class="modal fade" id="viewUserModal<?php echo $user['ID_USER']; ?>" tabindex="-1" role="dialog" aria-labelledby="viewUserModalLabel<?php echo $user['ID_USER']; ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewUserModalLabel<?php echo $user['ID_USER']; ?>">View User Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Display user details here -->
                        <table>
                            <tr>
                                <td>User ID:</td>
                                <td><?php echo $user['ID_USER']; ?></td>
                            </tr>
                            <tr>
                                <td>Role:</td>
                                <td><?php echo $user['ROLE']; ?></td>
                            </tr>
                            <tr>
                                <td>First Name:</td>
                                <td><?php echo $user['FIRSTNAME']; ?></td>
                            </tr>
                            <tr>
                                <td>Middle Name:</td>
                                <td><?php echo $user['MIDDLENAME']; ?></td>
                            </tr>
                            <tr>
                                <td>Last Name:</td>
                                <td><?php echo $user['LASTNAME']; ?></td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td><?php echo $user['EMAIL']; ?></td>
                            </tr>
                            <tr>
                                <td>Username:</td>
                                <td><?php echo $user['USERNAME']; ?></td>
                            </tr>
                            <tr>
                                <td>Password:</td>
                                <td><?php echo $user['PASSWORD']; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <a href="edit_user.php?id=<?php echo $user['ID_USER']; ?>" class="btn btn-primary">Edit</a>
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
            const $table = $('#user-table tbody');
            const $searchInput = $('#search-users');
            const $searchButton = $('#search-button');
            const $showAllButton = $('#show-all-users-button');

            const initialData = <?php echo json_encode($userData); ?>;
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
                const userId = $(this).data('userid');

                if (confirm('Are you sure you want to delete this user?')) {
                    $.ajax({
                        type: 'POST',
                        url: 'delete_user.php',
                        data: {
                            userId: userId
                        },
                        success: function(response) {
                            if (response === 'success') {
                                $(this).closest('tr').remove();
                                alert('User deleted successfully.');
                            } else {
                                alert('Error deleting user. Please try again.');
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
                        <a class="btn btn-info view-btn" data-toggle="modal" data-target="#viewUserModal${row.ID_USER}">View</a>
                        <button class="btn btn-danger delete-btn" data-userid="${row.ID_USER}">Delete</button>
                    </td>`;
                    const rowHtml = `
                    <tr>
                        <td class="cell">${row.ROLE}</td>
                        <td class="cell">${row.FIRSTNAME}</td>
                        <td class="cell">${row.MIDDLENAME}</td>
                        <td class="cell">${row.LASTNAME}</td>
                        <td class="cell">${row.EMAIL}</td>
                        <td class="cell">${row.USERNAME}</td>
                        ${operationCell}
                    </tr>`;
                    $table.append(rowHtml);
                });
            };
        });
    </script>
</body>

</html>