<div class="row g-4 mb-4">
	<?php
	include('config/db_config.php');

	for ($year = 1; $year <= 4; $year++) {
		$query = $con->prepare("SELECT COUNT(*) AS count FROM tbl_student WHERE YEAR = :year AND COURSE = 'BSIT'");
		$query->bindParam(':year', $year);
		$query->execute();

		$count = $query->fetch(PDO::FETCH_ASSOC)['count'];
	?>
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-warning shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-uppercase mb-1">
								<?php echo $year; ?> Year
							</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800">
								<?php echo $count; ?>
							</div>
						</div>
						<div class="col-auto">
							<i class="fa-solid fa-user fa-2xl"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
	?>
</div>