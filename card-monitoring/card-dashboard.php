<!-- Pending Requests Card Example -->
<div class="row g-4 mb-4">
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-warning shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-uppercase mb-1">
							User <br>
							<?php
							include('config/db_config.php');

							$query = $con->query('SELECT * FROM tbl_user');
							if ($query->rowCount()) {
								echo $query->rowCount();
							} else {
								echo 'No result';
							}
							?>
						</div>
					</div>
					<div class="col-auto">
						<i class="fa-solid fa-user fa-2xl"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-warning shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-uppercase mb-1">
							All Student <br>
							<?php
							include('config/db_config.php');

							$query = $con->query('SELECT * FROM tbl_student');
							if ($query->rowCount()) {
								echo $query->rowCount();
							} else {
								echo 'No result';
							}
							?>
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

	$courses = array("BSIT", "BSA"); // Add more courses if needed

	foreach ($courses as $course) {
		$query = $con->prepare("SELECT COUNT(*) AS count FROM tbl_student WHERE COURSE = :course");
		$query->bindParam(':course', $course);
		$query->execute();

		$count = $query->fetch(PDO::FETCH_ASSOC)['count'];
	?>
		<div class="col-xl-3 col-md-6 mb-4">
			<div class="card border-left-warning shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-uppercase mb-1">
								<?php echo $course; ?> Students <br>
								<?php echo $count; ?> </div>
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


</div>