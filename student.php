<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Student - eHealth Mate</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/ISUlogo.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        table {
            counter-reset: tableCount;
        }
        .counterCell:before {
            font-weight: bold;
            content: counter(tableCount);
            counter-increment: tableCount;
        }
    </style>

    <!-- =======================================================
  * Template Name: NiceAdmin - v2.5.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <?php include('Components/Navbar.php') ?>
    <?php include('Components/Sidebar.php') ?>




    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Student</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <!-- Left side columns -->
                <div class="col-lg-12">
                    <div class="row">
                        <!-- Customers Card -->
                        <div class="col-xxl-4 col-xl-3">

                            <div class="card info-card customers-card">

                                <div class="card-body">
                                    <h5 class="card-title">1st Year</h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>101</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Customers Card -->

                        <!-- Customers Card -->
                        <div class="col-xxl-4 col-xl-3">

                            <div class="card info-card customers-card">

                                <div class="card-body">
                                    <h5 class="card-title">2nd Year</h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>74</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Customers Card -->

                        <!-- Customers Card -->
                        <div class="col-xxl-4 col-xl-3">

                            <div class="card info-card customers-card">

                                <div class="card-body">
                                    <h5 class="card-title">3rd Year</h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>68</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Customers Card -->

                        <!-- 4th Year Card -->
                        <div class="col-xxl-6 col-xl-3">

                            <div class="card info-card customers-card">


                                <div class="card-body">
                                <a class="dropdown-item d-flex align-items-center" href="student.php">
                                        <h5 class="card-title">4th Year</h5>
                                </a>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>
                                                <?php
                                                    include('Components/db_config.php');

                                                    $query = $con -> query('SELECT * FROM tbl_student');
                                                    if($query->rowCount()) {
                                                        echo $query->rowCount();
                                                    }
                                                    else
                                                    {
                                                        echo 'No result';
                                                    }
                                                ?>
                                            </h6>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div><!-- End of 4th Year Card -->

                    </div>

                </div><!-- End Right side columns -->

            </div>

            <div class="row">
                <!-- Table Card -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table id='record_table' class='table table-hover'>
                                            <thead>
                                                <tr>
                                                    <th scope='col'>#</th>
                                                    <th scope='col'>Name</th>
                                                    <th scope='col'>Course</th>
                                                    <th scope='col'>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="dataTable">
                                <?php 
                                        $servername = "localhost";
                                        $username = "root";
                                        $password = '';
                                        $dbname = "db_emedrec_final";
                                    
                                        // Create connection
                                        $conn = new mysqli($servername, $username, $password, $dbname);
                                        // Check connection
                                        if ($conn->connect_error) {
                                            die("Connection failed: " . $conn->connect_error);
                                        }
                                    
                                        $sql = "SELECT id, f_name, m_name, l_name, stud_no, course,year, height, weight FROM tbl_student";
                                        $id = "SELECT id FROM tbl_student";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {

                                            while($row = $result->fetch_assoc()) {
                                                echo "
                                                <tr>
                                                    <td class='counterCell'></td>
                                                    <td>
                                                        " . $row["f_name"] . " " . $row["m_name"] . " " . $row["l_name"] . "
                                                    </td>
                                                    <td>
                                                        " . $row["course"] . " " . $row["year"] . "
                                                    </td>
                                                    <td>
                                                    <button id=" . $row['id'] . " class='btn btn-success' onclick='EDIT(".$row['id'].")' data-bs-toggle='modal' data-bs-target='#EDIT'>ASSIGN</button>
                                                    <a class='btn btn-danger' href='functions/delete_student.php?id=".$row['id']."'>DELETE</a>
                                                    </td>
                                                </tr>";
                                            }
                                            // echo "</table>";
                                        } else {
                                            echo "0 results";
                                        }

                                        $conn->close();
                                ?>
                                <!-- Table with hoverable rows -->
                                </tbody>
                            </table>

                            <?php 
                            
                            ?>

                            <!-- EEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE -->
                            <!-- Add Student Record Button-->
                            <div class="row">
                                <!-- EDIT -->
                                <div class="modal fade" id="EDIT" tabindex="-1">
                                    <!-- <form id="add_student"> -->
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Add Record</h5>
                                                <button name='EDIT' type="button" class="btn-close"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <!-- <form id="update_student"> -->
                                            <div class="modal-body">
                                                <form id="add_student" action="functions/update_student.php" method="POST">
                                                    <!--Edit Record Inputs-->

                                                    <!-- No Labels Form -->
                                                    <div class="row g-3">

                                                        <div class="col-md-4">
                                                            <input id="id" name="get_id" hidden>
                                                            <input name="first_name" id="first_name" type="text" class="form-control"
                                                                placeholder="First Name">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input name="middle_name" id="middle_name" type="text" class="form-control"
                                                                placeholder="Middle Name">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input name="last_name" id="last_name" type="text" class="form-control"
                                                                placeholder="Last Name">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input name="student_number" id="student_no" type="text"
                                                                class="form-control" placeholder="Student Number">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input name="course" id="course" type="text" class="form-control"
                                                                placeholder="Course">
                                                        </div>

                                                        <div class="col-md-4">
                                                            <select name="year" id="year" id="inputState" class="form-select">
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="IRREG">IRREG</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <select name="gender" id="gender" id="inputState" class="form-select">
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <input name="birthdate" id="dob" type="date" class="form-control"
                                                                placeholder="Birthdate">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input name="age" id="age" type="text" class="form-control"
                                                                placeholder="Age">
                                                        </div>
                                                        <div class="col-12">
                                                            <input name="address" id="address" type="text" class="form-control"
                                                                placeholder="Address">
                                                        </div>
                                                        <div class="col-12">
                                                            <input name="contact" id="contact" type="text" class="form-control"
                                                                placeholder="Contact">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input name="height" id="height" type="text" class="form-control"
                                                                placeholder="Height">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input name="weight" id="weight" type="text" class="form-control"
                                                                placeholder="Weight">
                                                        </div>
                                                        <hr>

                                                    </div>

                                                    <div class="row g-3">
                                                        <h2>Vaccine</h2>
                                                        <p>1st Dose</p>
                                                        <div class="col-md-6">
                                                            <input name="vaccine_brand1" type="text"
                                                                class="form-control" placeholder="Vaccine Brand">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input name="vaccine_date1" type="text" class="form-control"
                                                                placeholder="Date">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <input name="vaccine_address1" type="date"
                                                                class="form-control" placeholder="Address">
                                                        </div>

                                                        <p></p>
                                                        <p>2nd Dose</p>
                                                        <div class="col-md-6">
                                                            <input name="vaccine_brand2" type="text"
                                                                class="form-control" placeholder="Vaccine Brand">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input name="vaccine_date2" type="text" class="form-control"
                                                                placeholder="Date">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <input name="vaccine_address2" type="date"
                                                                class="form-control" placeholder="Address">
                                                        </div>


                                                        <hr>
                                                    </div>
                                                    <hr>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                            </form>
                                        </div>


                                        <!-- End No Labels Form -->

                                        <!-- </form> -->
                                    </div>

                                </div>

                                <!-- /EDIT -->
                                <!-- /EEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE -->

                              


                                <!-- Add Student Record Button-->
                                <div class="row">
                                    <div class="col p-3 bg-white text-white"></div>
                                    <div class="col p-3 bg-white text-white"></div>
                                    <div class="col p-3 bg-white text-white"></div>
                                    <div class="col p-3 bg-pwhite text-white">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#verticalycentered">
                                            Add Record
                                        </button>
                                    </div>

                                </div>
                                <!-- End of Student Record Button -->



                                <!-- Vertically centered Modal -->
                                <div class="modal fade" id="verticalycentered" tabindex="-1">
                                    <!-- <form id="add_student"> -->
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Add Record</h5>
                                                <button name='add' type="button" class="btn-close"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <!-- <form id="add_student"> -->
                                            <div class="modal-body">
                                                <form action="functions/add_student.php" method="POST">
                                                    <!--Add Record Inputs-->

                                                    <!-- No Labels Form -->
                                                    <div class="row g-3">

                                                        <div class="col-md-4">
                                                            <input name="first_name" type="text" class="form-control"
                                                                placeholder="First Name">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input name="middle_name" type="text" class="form-control"
                                                                placeholder="Middle Name">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input name="last_name" type="text" class="form-control"
                                                                placeholder="Last Name">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input name="student_number" type="text"
                                                                class="form-control" placeholder="Student Number">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input name="course" type="text" class="form-control"
                                                                placeholder="Course">
                                                        </div>

                                                        <div class="col-md-4">
                                                            <select name="year" id="inputState" class="form-select">
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="IRREG">IRREG</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <select name="gender" id="inputState" class="form-select">
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <input name="birthdate" type="date" class="form-control"
                                                                placeholder="Birthdate">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input name="age" type="text" class="form-control"
                                                                placeholder="Age">
                                                        </div>
                                                        <div class="col-12">
                                                            <input name="address" type="text" class="form-control"
                                                                placeholder="Address">
                                                        </div>
                                                        <div class="col-12">
                                                            <input name="contact" type="text" class="form-control"
                                                                placeholder="Contact">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input name="height" type="text" class="form-control"
                                                                placeholder="Height">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input name="weight" type="text" class="form-control"
                                                                placeholder="Weight">
                                                        </div>
                                                        <!-- <hr> -->

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save
                                                            changes</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- End No Labels Form -->

                                            <!-- </form> -->
                                        </div>
                                    </div>
                                    <!-- </form> -->
                                </div>
                                <!-- </form> -->
                            </div><!-- End Vertically centered Modal-->
                            <!-- End Table with hoverable rows -->

                        </div>

                    </div>
                </div><!-- End Table Card -->



            </div><!-- End Right side columns -->

            </div>
        </section>

    </main><!-- End #main -->



    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
    <!-- BUTTONS -->
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>  
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    <!-- BUTTONS -->
    
    <script src="datatable.js"></script>
</body>


    <script>
        function edit(_id){
            $('.modal-title').html('Update Student');
            $('#EDIT').modal('show');
            console.log(_id);
            $.ajax({
                type: "POST",
                url: "functions/get_student.php",
                data: {get_id: _id},
                dataType: 'json',
                success: function(response){
                    if (response.status === true){
                        console.log(response);
                        $('#id').val(response.data[0].id);
                        $('#first_name').val(response.data[0].f_name);.
                        $('#middle_name').val(response.data[0].m_name);
                        $('#last_name').val(response.data[0].l_name);
                        $('#student_no').val(response.data[0].student_number);
                        $('#course').val(response.data[0].course);
                        $('#year').val(response.data[0].year);
                        $('#gender').val(response.data[0].gender);
                        $('#dob').val(response.data[0].dob);
                        $('#age').val(response.data[0].age);
                        $('#address').val(response.data[0].address);
                        $('#contact').val(response.data[0].contact);
                        $('#height').val(response.data[0].height);
                        $('#weight').val(response.data[0].weight);

                    }
                }
                
            })
        }

    </script>
</body>

</html>