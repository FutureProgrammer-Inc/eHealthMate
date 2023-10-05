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

                <h1 class="app-page-title">Reports</h1>
                <?php
                include 'print/print.php';
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


</body>

</html>