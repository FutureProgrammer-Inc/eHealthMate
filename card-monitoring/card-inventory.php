<!-- Pending Requests Card Example -->
<div class="row g-4 mb-4">
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-warning shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-uppercase mb-1">
							Medical Supply <br>
							<?php

							$query = $con->query('SELECT * FROM tbl_medicine');
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
							Medical Inventory<br>
							<?php
							include('config/db_config.php');

							$query = $con->query('SELECT * FROM tbl_medsup');
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


</div>