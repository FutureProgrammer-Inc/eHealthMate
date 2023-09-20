<?php
session_start();
if (!isset($_SESSION['auth'])) {
	header('location: login.php');
}
include 'template\header.php';
require 'config\db_config.php';
require 'vendor/autoload.php';
include 'config/student_import_data.php';
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

				<h1 class="app-page-title">Bachelor of Science in Agriculture</h1>

				<?php
				include 'card-monitoring/card-bsa-student.php';
				// include 'student/import_student.php';
				?>
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
											<input type="text" id="search-orders" name="searchorders" class="form-control search-orders" placeholder="Search">
										</div>
										<div class="col-auto">
											<button type="submit" class="btn app-btn-secondary" id="search-button"> <i class="fa-solid fa-magnifying-glass"></i>Search</button>
										</div>
										<div class="col-auto">
											<button type="button" class="btn app-btn-secondary" id="show-all-button"><i class="fa-solid fa-eye"></i>Show All</button>
										</div>
									</form>
								</div><!--//col-->

								<div class="col-auto">
									<a class="btn app-btn-secondary" type="button" data-toggle="modal" data-target="#importModal">
										<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download me-1" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
											<path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
										</svg>
										Import Data
									</a>
								</div>

							</div><!--//row-->
						</div><!--//table-utilities-->
					</div><!--//col-auto-->
				</div><!--//row-->

				<!-- checking error -->
				<?php if (!empty($_SESSION['message'])) : ?>
					<p><?php echo $_SESSION['message']; ?></p>
					<?php unset($_SESSION['message']); ?>
				<?php endif; ?>


				<div class="tab-content" id="orders-table-tab-content">
					<div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
						<div class="app-card app-card-orders-table shadow-sm mb-5">

							<!-- searching area with the table-->
							<div class="app-card-body">
								<?php
								include 'search_area\search_for_bsa.php';
								?>
							</div>


						</div><!--//app-content-->
					</div>
				</div>


			</div><!--//app-wrapper-->
			<?php
			include 'partials/footer.php';
			include 'template/scripts.php';
			include 'modal/logout.php';
			?>

		</div>
	</div>





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
				<form action="bsit-student.php" method="post" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-group">
							<label for="import_file">Choose File:</label>
							<input type="file" name="import_file" id="import_file">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" name="import">Import</button>
					</div>
				</form>
			</div>
		</div>
	</div>



</body>

</html>