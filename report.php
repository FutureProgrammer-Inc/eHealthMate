<?php 
    session_start();
	if (!isset($_SESSION['username'])) {
		header("location:login.php");
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Report - E-Reserve</title>
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
    <link href="cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
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
</head>

<body>

    <?php include('Components/Navbar.php') ?>
    <?php include('Components/Sidebar.php') ?>


    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Report</h1>
        </div><!-- End Page Title -->

     
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Button States</h5>

              <div class="row g-3">
                    <div class="col-md-6">
                            <button type="button" class="btn btn-primary">Normal</button>
                    </div>
                    <div class="col-md-6">
                            <button type="button" class="btn btn-primary">Normal</button>
                    </div>
                    <div class="col-md-6">
                            <button type="button" class="btn btn-primary">Normal</button>
                    </div>
                    <div class="col-md-6">
                            <button type="button" class="btn btn-primary">Normal</button>
                    </div>
                    <div class="col-md-6">
                            <button type="button" class="btn btn-primary">Normal</button>
                    </div>
              <div>
            </div>
          </div>



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

    <script>
        function med_edit(_id){
            $('.modal-title').html('Update Medicine');
            $('#MedEdit').modal('show');
            console.log(_id);
            $.ajax({
                type: "POST",
                url: "functions/get_med.php",
                data: {get_id: _id},
                dataType: 'json',
                success: function(response){
                    if (response.status === true){
                        console.log(response);
                        $('#id').val(response.data[0].id);
                        $('#medicine_name').val(response.data[0].medicine_name);
                        $('#description').val(response.data[0].description);
                        $('#qty').val(response.data[0].qty);
                        $('#vaccine_brand').val(response.data[0].vaccine_brand);

                    }
                }
                
            })
        }
    </script>
</body>
</html>