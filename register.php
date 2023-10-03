<div class="modal-body">
	<div class="auth-form-container text-start mx-auto">
		<form class="user" id="RegisterForm">
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
				<div class="col-sm-0 mb-3 mb-sm-2">
					<select name="role" class="form-control form-control-user">
						<option value="nurse">Nurse</option>
						<option value="doctor">Doctor</option>
					</select>
				</div>
				<div class="col-sm-0 mb-3 mb-sm-2">
					<input type="email" name="email" class="form-control form-control-user" placeholder="email">
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
	</div><!--//auth-form-container-->
</div>

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
					window.location.href = 'user.php'; // Corrected redirection
				} else {
					alert(response.message);
				}
			}
		});
	});
</script>

</html>