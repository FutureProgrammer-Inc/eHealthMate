<?php
session_start();
if (!isset($_SESSION['auth'])) {
	header('location: login.php');
}
include 'template\header.php';
require 'config\db_config.php';


$query = "SELECT * FROM tbl_medicine";
$result = $con->query($query);

$data = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	$data[] = $row;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$medName = $_POST['medName'];
	$description = $_POST['description'];
	$quantity = $_POST['quantity'];
	$price = $_POST['price'];
	$expiration = $_POST['expiration'];

	try {
		$insertQuery = "INSERT INTO tbl_medicine (MED_NAME, DESCRIPTION, QUANTITY, PRICE, EXPIRATION) 
                        VALUES (?, ?, ?, ?, ?)";
		$stmt = $con->prepare($insertQuery);
		$stmt->execute([$medName, $description, $quantity, $price, $expiration]);

		$_SESSION['message'] = "Medicine added successfully!";
		header('Location: inventory.php'); // Redirect to the inventory page
		exit();
	} catch (PDOException $e) {
		$_SESSION['message'] = "Error: " . $e->getMessage();
		header('Location: inventory.php'); // Redirect to the inventory page with an error message
		exit();
	}
}
?>


<body class="app">
	<header class="app-header fixed-top">
		<?php
		include 'partials/header.php';
		include 'partials/sidebar.php';
		?>
	</header><!--//app-header-->

	<div class="app-wrapper">
		<!-- checking error -->
		<?php if (!empty($_SESSION['message'])) : ?>
			<p><?php echo $_SESSION['message']; ?></p>
			<?php unset($_SESSION['message']); ?>
		<?php endif; ?>

		<div class="app-content pt-3 p-md-3 p-lg-4">
			<div class="container-xl">

				<h1 class="app-page-title">Inventory</h1>

				<?php
				include 'card-monitoring/card-inventory.php';
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
									<a class="btn app-btn-secondary" type="button" data-toggle="modal" data-target="#addMedicineModal">
										<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download me-1" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
											<path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
										</svg>
										Add Medicine
									</a>
								</div>

							</div><!--//row-->
						</div><!--//table-utilities-->
					</div><!--//col-auto-->
				</div><!--//row-->


				<div class="tab-content" id="orders-table-tab-content">
					<div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
						<div class="app-card app-card-orders-table shadow-sm mb-5">

							<!-- searching area with the table-->
							<div class="app-card-body">
								<?php
								include 'search_area\search_for_medicine.php';
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

<!-- Add Medicine Modal -->
<div class="modal fade" id="addMedicineModal" tabindex="-1" role="dialog" aria-labelledby="addMedicineModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addMedicineModalLabel">Add New Medicine</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<!-- Add form fields here for adding new medicine -->
				<form action="inventory.php" method="post">
					<div class="form-group">
						<label for="medName">Medicine Name</label>
						<input type="text" class="form-control" id="medName" name="medName" required>
					</div>
					<div class="form-group">
						<label for="description">Description</label>
						<textarea class="form-control" id="description" name="description" rows="3" required></textarea>
					</div>
					<div class="form-group">
						<label for="quantity">Quantity</label>
						<input type="number" class="form-control" id="quantity" name="quantity" required>
					</div>
					<div class="form-group">
						<label for="price">Price</label>
						<input type="number" class="form-control" id="price" name="price" required>
					</div>
					<div class="form-group">
						<label for="expiration">Expiration</label>
						<input type="date" class="form-control" id="expiration" name="expiration" required>
					</div>
					<button type="submit" class="btn btn-primary">Add Medicine</button>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- View Medicine Modal -->
<div class="modal fade" id="viewModal<?php echo $row['ID_MEDICINE']; ?>" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel<?php echo $row['ID_MEDICINE']; ?>" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="viewModalLabel<?php echo $row['ID_MEDICINE']; ?>">View Medicine Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<!-- Display medicine details here -->
				<p>Medicine ID: <?php echo $row['ID_MEDICINE']; ?></p>
				<p>Medicine Name: <?php echo $row['MED_NAME']; ?></p>
				<p>Description: <?php echo $row['DESCRIPTION']; ?></p>
				<p>Quantity: <?php echo $row['QUANTITY']; ?></p>
				<p>Price: <?php echo $row['PRICE']; ?></p>
				<p>Expiration: <?php echo $row['EXPIRATION']; ?></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script>
	// Function to clear the "Add Medicine" modal form fields when it is closed
	$('#addMedicineModal').on('hidden.bs.modal', function() {
		$('#addMedicineForm')[0].reset();
	});

	// Function to open the "View Medicine" modal when the view button is clicked
	$('.view-btn').on('click', function() {
		// Extract the medicine ID from the data attribute
		var medicineId = $(this).data('medicine-id');
		// Construct the ID of the corresponding "View Medicine" modal
		var modalId = '#viewModal' + medicineId;
		// Open the modal
		$(modalId).modal('show');
	});
</script>