<?php
session_start();
if (!isset($_SESSION['auth'])) {
    header('location: login.php');
    exit(); // Exit immediately after redirect
}

include 'template/header.php';
require 'config/db_config.php';

// Fetch user data
$query = "SELECT * FROM tbl_user";
$result = $con->query($query);

$data = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Insert new user into the database
        $insertQuery = "INSERT INTO tbl_user (firstname, middlename, lastname, role, email, username, password) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($insertQuery);
        $stmt->execute([$firstname, $middlename, $lastname, $role, $email, $username, $password]);

        $_SESSION['message'] = "User added successfully!";
        header('Location: user.php'); // Redirect to the user management page
        exit();
    } catch (PDOException $e) {
        $_SESSION['message'] = "Error: " . $e->getMessage();
        header('Location: user.php'); // Redirect to the user management page with an error message
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include your HTML head content here, such as title and meta tags -->
</head>

<body class="app">
    <header class="app-header fixed-top">
        <?php
        include 'partials/header.php';
        include 'partials/sidebar.php';
        ?>
    </header><!--//app-header-->

    <div class="app-wrapper">
        <?php
        include 'modal/check_error.php';
        ?>

        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">

                <h1 class="app-page-title">User Management</h1>

                <?php
                include 'card-monitoring/card-user.php';
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
                                            <input type="text" id="search-users" class="form-control search-users" placeholder="Search">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn app-btn-secondary" id="search-button"><i class="fa-solid fa-magnifying-glass"></i>Search</button>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn app-btn-secondary" id="show-all-users-button"><i class="fa-solid fa-eye"></i>Show All</button>
                                        </div>
                                    </form>
                                </div><!--//col-->

                                <div class="col-auto">
                                    <a class="btn app-btn-secondary" type="button" data-toggle="modal" data-target="#addUserModal">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download me-1" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                            <path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                                        </svg>
                                        Add User
                                    </a>
                                </div>

                            </div><!--//row-->
                        </div><!--//table-utilities-->
                    </div><!--//col-auto-->
                </div><!--//row-->


                <div class="tab-content" id="users-table-tab-content">
                    <div class="tab-pane fade show active" id="users-all" role="tabpanel" aria-labelledby="users-all-tab">
                        <div class="app-card app-card-users-table shadow-sm mb-5">

                            <!-- searching area with the table-->
                            <div class="app-card-body">
                                <?php
                                include 'search_area/search_for_user.php';
                                ?>
                            </div>

                        </div><!--//app-content-->
                    </div>
                </div>

            </div><!--//app-wrapper-->

        </div>
    </div>

</body>

<?php
include 'partials/footer.php';
include 'template/scripts.php';
?>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add form fields here for adding new user -->
                <form action="user.php" method="post">
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" required>
                    </div>
                    <div class="form-group">
                        <label for="middlename">Middle Name</label>
                        <input type="text" class="form-control" id="middlename" name="middlename" required>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="doctor">Doctor</option>
                            <option value="nurse">Nurse</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- View User Modal -->
<?php foreach ($data as $row) : ?>
    <div class="modal fade" id="viewUserModal<?php echo $row['ID_USER']; ?>" tabindex="-1" role="dialog" aria-labelledby="viewUserModalLabel<?php echo $row['ID_USER']; ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewUserModalLabel<?php echo $row['ID_USER']; ?>">View User Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Display user details here -->
                    <table>
                        <tr>
                            <td>User ID:</td>
                            <td><?php echo $row['ID_USER']; ?></td>
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
                            <td>Role:</td>
                            <td><?php echo $row['ROLE']; ?></td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td><?php echo $row['EMAIL']; ?></td>
                        <tr>
                            <td>Username:</td>
                            <td><?php echo $row['USERNAME']; ?></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <a href="edit_user.php?id=<?php echo $row['ID_USER']; ?>" class="btn btn-primary">Edit</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    // Function to clear the "Add User" modal form fields when it is closed
    $('#addUserModal').on('hidden.bs.modal', function() {
        $('#addUserModal form')[0].reset();
    });

    // Function to open the "View User" modal when the view button is clicked
    $('.view-btn').on('click', function() {
        // Extract the user ID from the data attribute
        var userId = $(this).data('user-id');
        // Construct the ID of the corresponding "View User" modal
        var modalId = '#viewUserModal' + userId;
        // Open the modal
        $(modalId).modal('show');
    });

    <?php if (!empty($_SESSION['message'])) : ?>
        // Set the message content and show the modal
        var messageContent = "<?php echo $_SESSION['message']; ?>";
        $("#messageContent").text(messageContent);
        $("#messageModal").modal("show");
        // Remove the message from the session
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
</script>
</body>

</html>