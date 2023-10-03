<!DOCTYPE html>
<html lang="en">
<?php
$title = "Login";
include 'template/Header.php';
session_start();
if (isset($_SESSION['auth'])) {
	header('location: index.php');
}
?>

<body class="app app-signup p-0">
	<div class="row g-0 app-auth-wrapper">
		<div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
			<div class="d-flex flex-column align-content-end">
				<div class="app-auth-body mx-auto">
					<div class="app-auth-branding mb-4"><a class="app-logo"><img class="logo-icon me-2" src="img/isu-logo.ico" alt="logo"></a></div>
					<h2 class="auth-heading text-center mb-4">Sign up to eHealth Mate</h2>

					<div class="auth-form-container text-start mx-auto">
						<form class="user" id="RegisterForm">
							<div style="text-align:center">
								<img src="img\isu-logo.ico" alt="icon" width="40">
								<h3>ISABELA STATE UNIVERSITY</h3>
								<H6>Santiago City</H6>
							</div>
							<div class="form-group row">
								<div class="col-sm-0 mb-3 mb-sm-2">
									<input type="text" name="firstName" class="form-control form-control-user" placeholder="First Name">
								</div>
								<div class="col-sm-0 mb-3 mb-sm-2">
									<input type="text" name="middleName" class="form-control form-control-user" placeholder="Middle Name">
								</div>
								<div class="col-sm-0 mb-3 mb-sm-2">
									<input type="text" name="lastName" class="form-control form-control-user" placeholder="Last Name">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-6 mb-3 mb-sm-0">
									<input type="text" name="username" class="form-control form-control-user" placeholder="Username">
								</div>
								<div class="col-sm-6 mb-2 mb-sm-0">
									<input type="password" name="password" class="form-control form-control-user" placeholder="Password">
								</div>
							</div>
							<center>
								<button type="submit" class="btn btn-primary btn-user btn-block">Register Account</button>
							</center>
							<hr>
						</form>
						<hr>
						<div class="text-center">
							<a class="small" href="login.php">Already have an account? Login!</a>
						</div>
					</div><!--//auth-form-container-->

				</div><!--//auth-body-->
			</div><!--//flex-column-->
			<?php
			include 'partials/footer.php';
			?>
		</div><!--//auth-main-col-->
		<div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
			<div class="auth-background-holder">
			</div>
			<div class="auth-background-mask"></div>
			<div class="auth-background-overlay p-3 p-lg-5">
				<div class="d-flex flex-column align-content-end h-100">
					<div class="h-100"></div>
					<!-- <div class="overlay-content p-3 p-lg-4 rounded">
					    <h5 class="mb-3 overlay-title">Explore Portal Admin Template</h5>
					    <div>Portal is a free Bootstrap 5 admin dashboard template. You can download and view the template license <a href="https://themes.3rdwavemedia.com/bootstrap-templates/admin-dashboard/portal-free-bootstrap-admin-dashboard-template-for-developers/">here</a>.</div>
				    </div> -->
				</div>
			</div><!--//auth-background-overlay-->
		</div><!--//auth-background-col-->

	</div><!--//row-->

</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
	$('#RegisterForm').on('submit', function(e) {
		e.preventDefault();
		let formData = $(this).serialize();
		console.log(formData);
		$.ajax({
			type: "POST",
			url: "config/register.php",
			data: formData,
			dataType: 'json',
			success: function(response) {
				console.log(response);
				if (response.status === true) {
					alert(response.message);
					window.location.href = 'login.php'; // Corrected redirection
				} else {
					alert(response.message);
				}
			}
		});
	});
</script>

</html>