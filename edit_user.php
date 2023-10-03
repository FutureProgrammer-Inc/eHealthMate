<?php
session_start();
if (!isset($_SESSION['auth'])) {
    header('location: login.php');
}
include 'template/header.php';
require 'config/db_config.php'; // Adjust the path to your database config file

// Get the user ID from the URL parameter
if (isset($_GET['id'])) {
    $userID = $_GET['id'];

    // Fetch user data from the database based on the ID
    $query = "SELECT * FROM tbl_user WHERE id_user = ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$userID]);

    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userData) {
        $_SESSION['message'] = "User not found";
        header('Location: user.php'); // Redirect to the user listing page
        exit();
    }
} else {
    $_SESSION['message'] = "Invalid user ID";
    header('Location: user.php'); // Redirect to the user listing page
    exit();
}

// Check if the form was submitted for updating
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $user_id = $_POST['user_id'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $firstName = $_POST['firstname'];
    $middleName = $_POST['middlename'];
    $lastName = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Update the user data in the database
    $updateQuery = "UPDATE tbl_user SET id_user = ?, role = ?, email = ?, firstname = ?, middlename = ?, lastname = ?, username = ?, password = ? WHERE id_user = ?";
    $updateStmt = $con->prepare($updateQuery);
    $success = $updateStmt->execute([$user_id, $role, $email, $firstName, $middleName, $lastName, $username, $password, $userID]);

    if ($success) {
        $_SESSION['message'] = "User updated successfully!";
        header('Location: user.php'); // Redirect to the user listing page
        exit();
    } else {
        $_SESSION['message'] = "Error updating user";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include your HTML head content here -->
</head>

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

                <h1>Edit User Information</h1>

                <?php if (!empty($_SESSION['message'])) : ?>
                    <p><?php echo $_SESSION['message']; ?></p>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>

                <!-- Your form for editing user information goes here -->
                <form action="edit_user.php?id=<?php echo $userID; ?>" method="post">
                    <div class="mb-3">
                        <label for="user_id">User ID</label>
                        <input type="text" class="form-control" id="user_id" name="user_id" value="<?php echo $userData['id_user']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="Doctor" <?php if ($userData['role'] === 'Doctor') echo 'selected'; ?>>Doctor</option>
                            <option value="Nurse" <?php if ($userData['role'] === 'Nurse') echo 'selected'; ?>>Nurse</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="firstname">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $userData['firstname']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="middlename">Middle Name</label>
                        <input type="text" class="form-control" id="middlename" name="middlename" value="<?php echo $userData['middlename']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="lastname">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $userData['lastname']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $userData['email']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $userData['username']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" value="<?php echo $userData['password']; ?>" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update User Information</button>
                </form>

            </div><!--//container-fluid-->
        </div><!--//app-content-->

        <?php
        include 'partials/footer.php';
        ?>

    </div><!--//app-wrapper-->

    <?php
    include 'template/scripts.php';
    ?>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const passwordInput = document.getElementById("password");
            const togglePasswordButton = document.querySelector(".toggle-password");

            togglePasswordButton.addEventListener("click", function() {
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                } else {
                    passwordInput.type = "password";
                }
            });
        });
    </script>


</body>

</html>