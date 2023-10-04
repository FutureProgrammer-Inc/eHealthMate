<?php
session_start();
if (!isset($_SESSION['auth'])) {
    header('location: login.php');
}
include 'template/header.php';
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

                <h1 class="app-page-title">Consult</h1>
                <div class="row g-3 mb-4 align-items-center justify-content-between">

                    <!-- KEEP THIS TO MAKE IT CLEAN -->
                    <div class="col-auto">
                        <h1 class="app-page-title mb-0"></h1>
                    </div>
                    <!-- KEEP THIS TO MAKE IT CLEAN -->

                    <div class="col-auto">
                        <div class="page-utilities">
                            <div class="row g-2 justify-content-start justify-content-md-end align-items-center">

                                <div class="col-auto">
                                    <form class="table-search-form row gx-1 align-items-center">
                                        <div class="col-auto">
                                            <button type="button" class="btn app-btn-secondary" data-toggle="modal" data-target="#importModal"><i class="fa-solid fa-eye"></i>add diagnose</button>
                                        </div>
                                    </form>
                                </div><!--//col-->


                            </div><!--//row-->
                        </div><!--//table-utilities-->
                    </div><!--//col-auto-->
                </div><!--//row-->
                <?php
                include 'search_area/search_for_consultation.php';
                ?>

            </div><!--//container-fluid-->
        </div><!--//app-content-->

        <?php
        include 'partials/footer.php';
        ?>

    </div><!--//app-wrapper-->


    <?php
    include 'modal/logout.php';
    include 'template/scripts.php';
    ?>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="search-student">Search for Student:</label>
                        <input type="text" id="search-student" class="form-control" placeholder="Search">
                    </div>
                    <div class="form-group">
                        <label for="student-dropdown">Select Student:</label>
                        <select class="form-control" id="student-dropdown">
                            <option value="" disabled selected>Select a student</option>
                            <?php
                            foreach ($data as $row) {
                                echo '<option value="' . $row['STUDENT_ID'] . '">' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const $table = $('#student-table tbody');
            const $searchInput = $('#search-student');
            const $studentDetailsModal = $('#studentDetailsModal');
            const $studentDetails = $('#student-details');

            // Function to update the student details
            function updateStudentDetails(studentId) {
                // Fetch student details based on the studentId and display them
                $.ajax({
                    type: 'GET',
                    url: 'get_student_details.php', // Replace with the actual URL to fetch student details
                    data: {
                        studentId: studentId
                    },
                    success: function(response) {
                        $studentDetails.html(response);
                    },
                    error: function() {
                        $studentDetails.html('<p>Failed to fetch student details.</p>');
                    }
                });
            }

            // View button click event
            $table.on('click', '.view-btn', function() {
                const studentId = $(this).data('studentid');
                updateStudentDetails(studentId);
                $studentDetailsModal.modal('show');
            });

            // Search input keyup event
            $searchInput.on('keyup', function() {
                const searchTerm = $(this).val().toLowerCase();
                const filteredData = <?php echo json_encode($data); ?>.filter(row => {
                    const values = Object.values(row).map(value => value.toString().toLowerCase());
                    return values.some(value => value.includes(searchTerm));
                });
                updateTable(filteredData);
            });

            // Function to update the table content
            function updateTable(data) {
                $table.empty();
                data.forEach(row => {
                    const operationCell = `
                    <td class="cell">
                        <a class="btn btn-info view-btn" data-toggle="modal" data-target="#studentDetailsModal" data-studentid="${row.STUDENT_ID}">View</a>
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
        });
    </script>

</body>



</html>