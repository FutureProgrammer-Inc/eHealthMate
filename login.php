<?php
session_start();
if (isset($_SESSION['auth'])) {
	header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<?php
include 'template/header.php';
?>

<!-- Login -->

<body class="app app-login p-0">
	<div class="row g-0 app-auth-wrapper">
		<div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
			<div class="d-flex flex-column align-content-end">
				<div class="app-auth-body mx-auto">
					<div class="app-auth-branding mb-4"><a class="app-logo" href="index.html"><img class="logo-icon me-2" src="img/isu-logo.ico" alt="logo"></a></div>
					<h2 class="auth-heading text-center mb-5">Log in to eHealth Mate</h2>
					<div class="auth-form-container text-start">
						<form class="user" id="loginForm">
							<div class="form-group">
								<input type="text" name="username" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Username">
								<input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
							</div>
							<div class="form-group">
								<div class="custom-control custom-checkbox small">
									<input type="checkbox" class="custom-control-input" id="customCheck">
									<label class="custom-control-label" for="customCheck">Remember Me</label>
								</div>
							</div>
							<center>
								<button type="submit" class="btn btn-primary btn-user btn-block" id="loginButton">Login</button>
							</center>
							<hr>
						</form>
					</div><!--//auth-form-container-->

				</div><!--//auth-body-->
			</div><!--//flex-column-->

			<?php
			include 'template/scripts.php'; // Include your scripts file here
			include 'partials/footer.php'; // Include your footer file here
			?>
		</div><!--//auth-main-col-->
		<div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
			<div class="auth-background-holder">
			</div>
			<div class="auth-background-mask"></div>
			<div class="auth-background-overlay p-3 p-lg-5">
				<div class="d-flex flex-column align-content-end h-100">
					<div class="h-100"></div>
				</div>
			</div><!--//auth-background-overlay-->
		</div><!--//auth-background-col-->

	</div><!--//row-->

	<!-- Loading screen -->
	<div id="loading" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8); z-index: 9999;">
		<div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
			<div class="spinner-border" role="status">
				<span class="sr-only">Loading...</span>
			</div>
			<p>Loading...</p>
		</div>
	</div>

	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
		$('#loginForm').on('submit', function(e) {
			e.preventDefault();
			let formData = $(this).serialize();

			// Show the loading screen
			$('#loading').show();

			$.ajax({
				type: 'POST',
				url: '/config/Check_Login.php', // Replace with the correct path to your Check_Login.php file
				data: formData,
				dataType: 'json',
				success: function(response) {
					console.log(response);
					if (response.status === true) {
						// Redirect to the OTP page
						location.href = "otp.php?id=" + response.message;
					} else {
						alert(response.message);
					}
				},
				error: function(xhr, status, error) {
					console.error(xhr.responseText);
					alert("An error occurred during the AJAX request.");
				},
				complete: function() {
					// Hide the loading screen when the request is complete
					$('#loading').hide();
				}
			});
		});
	</script>
</body>

</html>
