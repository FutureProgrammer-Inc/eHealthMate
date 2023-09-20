<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Inventory - eHealth Mate</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
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
            <h1>Inventory</h1>
        </div><!-- End Page Title -->

            <div class="row">
                <!-- Table Card -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table id='record_table' class='table table-hover'>
                                            <thead>
                                                <tr>
                                                    <th scope='col'>#</th>
                                                    <th scope='col'>Medical Item</th>
                                                    <th scope='col'>Current Total</th>
                                                    <th scope='col'>Additional Medical Item</th>
                                                    <th scope='col'>Total</th>
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
                                    
                                        $sql = "SELECT id, medicine_item, curr_total, add_med_item, total FROM tbl_med_inventory";
                                        $id = "SELECT id FROM tbl_medical_item";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {

                                            while($row = $result->fetch_assoc()) {
                                                echo "
                                                <tr>
                                                    <td class='counterCell'></td>
                                                    <td>
                                                        " . $row["medicine_item"] . "
                                                    </td>
                                                    <td>
                                                        " . $row["curr_total"] . "
                                                    </td>
                                                    <td>
                                                    " . $row["add_med_item"] . "
                                                    </td>
                                                    <td>
                                                    " . $row["total"] . "
                                                    </td>
                                                    <td>
                                                    <button id=" . $row['id'] . " class='btn btn-success' onclick='EDIT(".$row['id'].")' data-bs-toggle='modal' data-bs-target='#EDIT'>EDIT</button>
                                                    <a class='btn btn-danger' href='functions/delete_med.php?id=".$row['id']."'>DELETE</a>
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
                                    <!-- <form id="add_medicine_item"> -->
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit</h5>
                                                <button name='EDIT' type="button" class="btn-close"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <!-- <form id="update_student"> -->
                                            <div class="modal-body">
                                                <form id="update_inventory" action="functions/update_inventory.php" method="POST">
                                                    <!--Edit Record Inputs-->

                                                    <!-- No Labels Form -->
                                                    
                                                        
                                                        <div class="row g-3">

                                            <div class="col-md-4">
                                                <input name="medicine_item" type="text" class="form-control"
                                                    placeholder="Medical Item">
                                            </div>

                                            <div class="col-md-4">
                                                <input name="curr_total" type="text" class="form-control"
                                                    placeholder="Current Total">
                                            </div>

                                            <div class="col-md-4">
                                                <input name="add_med_item" type="text" class="form-control"
                                                    placeholder="Additional Medical Supply">
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <input name="total" type="text"
                                                    class="form-control" placeholder="Total">
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

                                <!-- /EDIT Medical Item -->

                              


                                <!-- Start of Medical Item Record Button-->
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
                                <!-- End of ADD Medical Item Record Button -->



                                <!-- ADD MEDICAL ITEM -->
                                <div class="modal fade" id="verticalycentered" tabindex="-1">
                                    <!-- <form id="add_medicine item"> -->
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Add Medical Item</h5>
                                                <button name='add' type="button" class="btn-close"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <!-- <form id="add_med_item"> -->
                                            <div class="modal-body">
                                                <form action="functions/add_inventory.php" method="POST">
                                                    <!--Add Medical Item Inputs-->

                                                    <!-- No Labels Form -->
                                                        
                                                    <div class="row g-3">

                                                        <div class="col-md-4">
                                                            <input id="id" name="get_id" hidden>
                                                            <input name="medicine_item" id="medicine_item" type="text" class="form-control"
                                                                placeholder="Medical Item Name">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input name="qty" id="qty" type="text" class="form-control"
                                                                placeholder="Qty">
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
                            </div><!-- END OF ADD MEDICAL ITEM-->
                            
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
            $('.modal-title').html('Update Inventory');
            $('#EDIT').modal('show');
            console.log(_id);
            $.ajax({
                type: "POST",
                url: "functions/get_inventory.php",
                data: {get_id: _id},
                dataType: 'json',
                success: function(response){
                    if (response.status === true){
                        console.log(response);
                        $('#id').val(response.data[0].id);
                        $('#medicine_item').val(response.data[0].medicine_item);.
                        $('#curr_total').val(response.data[0].curr_total);
                        $('#add_med_item').val(response.data[0].add_med_item);
                        $('#total').val(response.data[0].total);
                        $('#qty').val(response.data[0].qty);
                    }
                }
                
            })
        }

    </script>
</body>

</html>