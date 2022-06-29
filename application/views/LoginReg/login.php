<?php $this->load->view("./layout/header"); ?>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
<script src="https://apis.google.com/js/api:client.js"></script>

<style type="text/css">
	#customBtn {
		display: inline-block;
		background: white;
		color: #444;
		border-radius: 5px;
		border: thin solid #888;
		box-shadow: 1px 1px 1px grey;
		white-space: nowrap;
	}

	#customBtn:hover {
		cursor: pointer;
	}

	span.label {
		font-family: serif;
		font-weight: normal;
	}

	span.icon {
		background: url('/identity/sign-in/g-normal.png') transparent 5px 50% no-repeat;
		display: inline-block;
		vertical-align: middle;
		width: 42px;
		height: 42px;
	}

	span.buttonText {
		display: inline-block;
		vertical-align: middle;
		padding-left: 42px;
		padding-right: 42px;
		font-size: 14px;
		font-weight: bold;

	}
</style>

<style>
	.modal {
		display: none;
		position: fixed;
		z-index: 1;
		padding-top: 100px;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		overflow: auto;
		background-color: rgb(0, 0, 0);
		background-color: rgba(0, 0, 0, 0.4);
	}

	.modal-content {
		background-color: #fefefe;
		margin: auto;
		padding: 20px;
		border: 1px solid #888;
		width: 80%;
	}

	/* The Close Button */
	.close {
		color: #aaaaaa;
		float: right;
		font-size: 28px;
		font-weight: bold;
	}

	.close:hover,
	.close:focus {
		color: #000;
		text-decoration: none;
		cursor: pointer;
	}
</style>

<style>
	/* login */

	.register a {
		color: #ea088b;
		;
	}

	.submit_btn button {
		background-color: #ea088b;
	}

	.register_btn button {
		background-color: #949090;
	}

	.label_L {
		font-size: 16px;
		font-weight: 500;
	}

	.login_input[placeholder] {
		font-size: 14px;
	}

	.loginpage {
		box-shadow: 0px 0px 9px lightgrey;
	}

	@media only screen and (max-width: 600px) {
		.loginpage {
			box-shadow: none;
		}
	}
</style>

<!-- Loginform  -->

<div class="container">
	<div class="row">
		<div class="col-12 col-lg-6 m-auto mt-md-5 px-md-5 rounded loginpage">
			<div class="login_register">
				<h5 class="mb-4 mt-5 text-center font-weight-bold" style="font-family:var(--primaryText)">LOGIN</h5>
				<input type="hidden" id="redirectTo" value="<?= isset($redirectTo) ? $redirectTo : '' ?>" />
				<form method="post" id="loginForm">
					<div class="user_name mb-3">
						<p class="mb-0 label_L">EMAIL</p>
						<input type="text" name="email" placeholder="E-mail" id="email" class=" login_input form-control">
					</div>
					<div class="password ">
						<p class="mb-0 label_L">PASSWORD</p>
						<input type="password" name="password" placeholder="Password" id="password" class="login_input form-control">
						<p class="mb-0 small text-muted text-right normal_text" id="forgotPassword" style="cursor: pointer; font-family:var(--secondryText); font-size:14px;">Forgot your password?</p>
					</div>
					<div class="reminder d-block">
						<input type="checkbox" id="reminde_me" name="reminder" value="">
						<label for="reminde_me" class="mb-0 small text-muted text-right normal_text" style="font-family:var(--secondryText); font-size:14px;">Remember Password</label>
					</div>
					<div class="submit_btn my-4 text-center">
						<button type="submit" class="btn text-light btn-sm" style="font-family:var(--primaryText)"><b>SIGN IN</b></button>
					</div>
				</form>
				<div class="loginWith">
					<p class="mb-2 mt-5 small text-dark text-center" style="font-family:var(--secondryText)">Or Login With</p>
				</div>
				<div class="row mb-5">
					<div class="col-6 text-center">
						<button type="button" class="btn text-light btn-sm " style="background-color: #0054b5; font-family:var(--primaryText)"><b>FACEBOOK</b></button>
					</div>
					<div class="col-6 text-center">
						<a class="btn text-light btn-sm px-3" style="background-color: #ff4040; font-family:var(--primaryText)" id="customBtn"><b>GOOGLE</b></a>
					</div>
				</div>
				<p style="font-weight: 500; " class="text-center normal_text">Don’t have an account? <a href="<?php echo base_url('register'); ?>" style="font-family: var(--secondryText); text-decoration:none;" class="sukaii_pink_color">Register NOW !</a> </p>
			</div>
		</div>
	</div>
	<div id="footer"></div>

</div>
<div id="name"></div>
<div class="container-fluid" id="forgotPasswordField" style="display:none;">
<div class="row">
	<div class="col-12 col-lg-6 loginpage m-auto py-md-5 rounded">
	<div class="lockImage text-center">
		<img src="<?= base_url()?>assets/mimages/forget_password.png" alt="">
	</div>
	<h4 class="text-center mb-4" style="color: #ec098d;">Ohh! Forget Your Password</h4>
	<p class="mb-3 mx-auto small text-center text-muted" style="width: 90%;">No Worries! Enter your email and we will send you a reset</p>
	<div id="sendRequestInput" class="align-items-baseline border-left-0 border-right-0 border-top-0 d-flex email mx-auto rounded-0 w-75" style="border-bottom: 2px solid lightblue;">
		<span class="ml-2" style="color: #00b3b7;"><i class="fa-solid fa-envelope"></i></span>
		<input type="email" placeholder="example@gmail.com" class="border-0 form-control" name="forgetPassword_email" id="forgetPassword_email">
	</div>
	<div id="pass_change_input" class="align-items-baseline border-left-0 border-right-0 border-top-0 d-flex email mx-auto rounded-0 w-75" style="display: none !important; border-bottom: 2px solid lightblue;">
		<span class="ml-2" style="color: #00b3b7;"><i class="fa-solid fa-key"></i></span>
		<input type="password" placeholder="Enter password" class="border-0 form-control" name="reset_password" id="reset_password">
	</div>
	<div id="confirm_pass_change_input" class="align-items-baseline border-left-0 border-right-0 border-top-0 d-flex email mx-auto rounded-0 w-75" style="display: none !important; border-bottom: 2px solid lightblue;">
		<span class="ml-2" style="color: #00b3b7;"><i class="fa-solid fa-key"></i></span>
		<input type="password" placeholder="Confirm password" class="border-0 form-control" name="confirm_reset_password" id="confirm_reset_password">
	</div>
	<div class=" text-center mt-5">
		<button type="button" id="cancleRequest" class="btn text-light font-weight-bold btn-sm text-center" style="background-color: #ea088b;">Cancel</button>
		<button type="button" id="sendRequest" class="btn text-light font-weight-bold btn-sm text-center" style="background-color: #ea088b;">Send Request</button>
		<button type="button" id="pass_change" class="btn text-light font-weight-bold btn-sm text-center" style="display: none; background-color: #ea088b;" onclick="changePassword()">Change password</button>
	</div>
	</div>
</div>
	
</div>
<div class="d-none" id="notRegistered" tabindex="-1" role="dialog" aria-labelledby="notRegistered" aria-hidden="true">
	<div class="m-auto modal-content w-75" style="background-color: var(--themeGreen);">
		<div class="modal-body">
			<h5 id="verified" class="font-weight-bold text-center sukaii_pink_color" style="font-family: var(--primaryText);">OTP Verified Successfuly</h5>
		</div>
	</div>
</div>

<div id="myModal" class="modal">
	<div class="modal-content w-75">
		<span class="close text-right text-dark">&times;</span>
		<h5 class="font-weight-bold text-center sukaii_pink_color" style="font-family: var(--primaryText);">User not registered..please register first</h5>
		<div class="text-center">
			<a style="background-color:#ec098d" class="btn px-3 btn-sm font-weight-bold mb-2 mt-4 text-light" href="<?php echo base_url(); ?>">Register</a>
		</div>
	</div>

</div>
<script>
	// Get the modal
	var modal = document.getElementById("myModal");

	var span = document.getElementsByClassName("close")[0];

	span.onclick = function() {
		modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}
	$("#sendRequest").click(function() {
		// $("#notRegistered").toggle();
		var email = $("#forgetPassword_email").val();
		$.ajax({
			url: "<?php echo site_url('UserController/forgotPassword'); ?>",
			async: true,
			method: 'post',
			data: {
				email: email
			},
			dataType: 'json',
			success: function(data) {
				if (data.status == 200) {
					$('#pass_change_input').show();
					$('#confirm_pass_change_input').show();
				} else if (data.status == 202) {
					$('#pass_change').hide();
					$("#sendRequest").show();
					app.errorToast("Email should not blank");
				} else {
					modal.style.display = "block";
					$('#pass_change').hide();
					$("#sendRequest").show();
				}
			}
		});


		$(this).hide();
		$('#sendRequestInput').hide();
		$('#pass_change').show();
	});
	$("#forgotPassword").click(function() {
		$("#forgotPasswordField").show();
		$(".login_register").hide();
	});
	$("#cancleRequest").click(function() {
		$("#forgotPasswordField").hide();
		$(".login_register").show();
	});

	function changePassword() {
		var email = $("#forgetPassword_email").val();
		var newPassword = $("#reset_password").val();
		var confirmPassword = $("#confirm_reset_password").val();

		if (newPassword == "" || confirmPassword == "") {
			app.errorToast("Password should not be blank.");
		} else if (newPassword.length < 5 || confirmPassword < 5) {
			app.errorToast("Password length should be more than 5.");
		} else {
			if (newPassword === confirmPassword) {
				$.ajax({
					url: "<?php echo site_url('UserController/changePassword'); ?>",
					async: true,
					method: 'post',
					data: {
						newPassword: newPassword,
						email: email
					},
					dataType: 'json',
					success: function(data) {
						if (data.status == 201) {
							alert("error");
						}
						if (data.status == 200) {
							app.successToast(data.body);
							window.location = baseURL + "login";
						}
					}
				});
			} else {
				app.errorToast("Passwords does not match..");
			}
		}
	}
</script>



<?php $this->load->view("./layout/footer"); ?>