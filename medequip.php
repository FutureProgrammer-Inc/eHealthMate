<?php
session_start();
if (!isset($_SESSION['auth'])) {
	header('location: login.php');
}

include 'template/header.php';
require 'config/db_config.php';

// Fetch medical equipment data
$query = "SELECT * FROM tbl_medequip";
$result = $con->query($query);

$data = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	$data[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$medequipName = $_POST['medequipName'];
	$description = $_POST['description'];
	$quantity = $_POST['quantity'];
	$price = $_POST['price'];

	try {
		// Insert new medical equipment into the database
		$insertQuery = "INSERT INTO tbl_medequip (MEDEQUIP_NAME, DESCRIPTION, QUANTITY, PRICE) 
                        VALUES (?, ?, ?, ?)";
		$stmt = $con->prepare($insertQuery);
		$stmt->execute([$medequipName, $description, $quantity, $price]);

		$_SESSION['message'] = "Medical Equipment added successfully!";
		header('Location: medequip.php'); // Redirect to the medequip management page
		exit();
	} catch (PDOException $e) {
		$_SESSION['message'] = "Error: " . $e->getMessage();
		header('Location: medequip.php'); // Redirect to the medequip management page with an error message
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
		<?php
		include 'modal/check_error.php';
		?>

		<div class="app-content pt-3 p-md-3 p-lg-4">
			<div class="container-xl">

				<h1 class="app-page-title">Medical Equipment Management</h1>

				<?php
				include 'card-monitoring/card-medequip.php';
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
											<input type="text" id="search-medequip" class="form-control search-medequip" placeholder="Search">
										</div>
										<div class="col-auto">
											<button type="submit" class="btn app-btn-secondary" id="search-button"><i class="fa-solid fa-magnifying-glass"></i>Search</button>
										</div>
										<div class="col-auto">
											<button type="button" class="btn app-btn-secondary" id="show-all-medequip-button"><i class="fa-solid fa-eye"></i>Show All</button>
										</div>
									</form>
								</div><!--//col-->

								<div class="col-auto">
									<a class="btn app-btn-secondary" type="button" data-toggle="modal" data-target="#addMedequipModal">
										<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download me-1" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
											<path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
										</svg>
										Add Medical Equipment
									</a>
								</div>

							</div><!--//row-->
						</div><!--//table-utilities-->
					</div><!--//col-auto-->
				</div><!--//row-->


				<div class="tab-content" id="medequip-table-tab-content">
					<div class="tab-pane fade show active" id="medequip-all" role="tabpanel" aria-labelledby="medequip-all-tab">
						<div class="app-card app-card-medequip-table shadow-sm mb-5">

							<!-- searching area with the table-->
							<div class="app-card-body">
								<?php
								include 'search_area/search_for_medequip.php';
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

<!-- Add Medical Equipment Modal -->
<div class="modal fade" id="addMedequipModal" tabindex="-1" role="dialog" aria-labelledby="addMedequipModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addMedequipModalLabel">Add New Medical Equipment</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<!-- Add form fields here for adding new medical equipment -->
				<form action="medequip.php" method="post">
					<div class="form-group">
						<label for="medequipName">Medical Equipment Name</label>
						<input type="text" class="form-control" id="medequipName" name="medequipName" required>
					</div>
					<div class="form-group">
						<label for="description">Description</label>
						<textarea class="form-control" id="description" name="description" required></textarea>
					</div>
					<div class="form-group">
						<label for="quantity">Quantity</label>
						<input type="number" class="form-control" id="quantity" name="quantity" required>
					</div>
					<div class="form-group">
						<label for="price">Price</label>
						<input type="number" class="form-control" id="price" name="price" required>
					</div>
					<button type="submit" class="btn btn-primary">Add Medical Equipment</button>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- View Medical Equipment Modal -->
<?php foreach ($data as $row) : ?>
	<div class="modal fade" id="viewMedequipModal<?php echo $row['ID_MEDEQUIP']; ?>" tabindex="-1" role="dialog" aria-labelledby="viewMedequipModalLabel<?php echo $row['ID_MEDEQUIP']; ?>" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="viewMedequipModalLabel<?php echo $row['ID_MEDEQUIP']; ?>">View Medical Equipment Details</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<!-- Display medical equipment details here -->
					<table>
						<tr>
							<td>Medical Equipment ID:</td>
							<td><?php echo $row['ID_MEDEQUIP']; ?></td>
						</tr>
						<tr>
							<td>Medical Equipment Name:</td>
							<td><?php echo $row['MEDEQUIP_NAME']; ?></td>
						</tr>
						<tr>
							<td>Description:</td>
							<td><?php echo $row['DESCRIPTION']; ?></td>
						</tr>
						<tr>
							<td>Quantity:</td>
							<td><?php echo $row['QUANTITY']; ?></td>
						</tr>
						<tr>
							<td>Price:</td>
							<td><?php echo $row['PRICE']; ?></td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<a href="edit_medequip.php?id=<?php echo $row['ID_MEDEQUIP']; ?>" class="btn btn-primary">Edit</a>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>

<script>
	// Function to clear the "Add Medical Equipment" modal form fields when it is closed
	$('#addMedequipModal').on('hidden.bs.modal', function() {
		$('#addMedequipModal form')[0].reset();
	});

	// Function to open the "View Medical Equipment" modal when the view button is clicked
	$('.view-btn').on('click', function() {
		// Extract the medical equipment ID from the data attribute
		var medequipId = $(this).data('medequip-id');
		// Construct the ID of the corresponding "View Medical Equipment" modal
		var modalId = '#viewMedequipModal' + medequipId;
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