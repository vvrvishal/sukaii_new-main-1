<?php $this->load->view("./layout/header"); ?>

<style>
	.register a {
		color: #ea088b;;
	}

	.submit_btn button {
		background-color: #ea088b;
	}

	.register_btn button {
		background-color: #949090;
	}

	.login_register form input {
		border: 2 ox solid black !important;
	}


	#userGender:focus {
		box-shadow: unset;
	}

	#Location:focus {
		box-shadow: 0px 0px 0px 0px !important;
	}
	.regis_form[placeholder]{
		font-size: 14px;
	}
	.label_R{
		font-size: 16px;
		font-weight: 500;
	}
	.registerpage {
		box-shadow: 0px 0px 9px lightgrey;
	}

	@media only screen and (max-width: 600px) {
		.registerpage {
			box-shadow: none;
		}
	}
</style>

<div class="container">
	<div class="row">
		<!-- <div class="col-1"></div> -->
		<div class="col-12 col-lg-6 m-auto mt-md-5 px-md-5 rounded registerpage">
			<div class="login_register">
				<h5 class="mb-4 mt-5 text-center text-dark font-weight-bold" style="font-family:var(--primaryText)">SIGN
					UP</h5>
				<form method="POST" id="registration_form" autocomplete="off">
					<div class="user_name mb-3">
						<p class="mb-0 text-dark label_R">FULL NAME</p>
						<input type="text" name="full_name" autocomplete="false" id="full_name" placeholder="Full Name" class="regis_form border-dark form-control">
					</div>
					<div class="user_mobile mb-3">
						<p class="mb-0 text-dark label_R">MOBILE NUMBER</p>
						<input type="number" name="mobile" autocomplete="false" id="mobile" placeholder="Mobile Number" class="regis_form border-dark form-control">
					</div>
					<div class="user_email mb-3">
						<p class="mb-0 text-dark label_R">E-MAIL ID</p>
						<input type="email" name="email" AutoCompleteType="Disabled" id="email" placeholder="E-mail" class="regis_form border-dark form-control">
					</div>
					<div class="form-group mb-0 mt-3">
						<label for="Conpany_email " class="pwuFormlabel mb-0 label_R">Gender</label>
						<div class="form-control form-group rounded border-dark mb-0 selectGender"
							 style="padding-bottom: 0px;">
							<div class="align-items-baseline d-flex selector">
								<input name="gender" id="gender" readonly  class="border-0 bg-transparent form-control pb-2 pl-0 py-0 regis_form" placeholder="Gender"
									   data-error="#gendererror"/>
								<i class="fa-solid fa-caret-down" style="color: var(--themeGreen);"></i>
							</div>
						</div>
						<div id="gendererror"></div>
					</div>
					<div class="select_location border p-2 mb-3 rounded" id="gender_value"
						 style="background: #ededed; width: 95%; margin: auto; display: none;" id="">
						<p class="border-dark form-control mb-2 mx-auto text-light genderValue activeSelection" onclick="genderValue(this,'Male');"
						   style="border-radius: 7px; width: 95%; ">Male</p>
						<p class="border-dark form-control mb-2 mx-auto   genderValue" onclick="genderValue(this,'Female');"
						   style="border-radius: 7px; width: 95%;">Female</p>
						<p class="border-dark form-control mb-2 mx-auto genderValue" onclick="genderValue(this,'Other');"
						   style="border-radius: 7px; width: 95%;">Other</p>
					</div>
					<div class="password mt-3 mb-3">
						<p class="mb-0 text-dark label_R">PASSWORD</p>
						<div class="align-items-center rounded border border-dark d-flex input pr-2">
							<input type="password" name="password" id="password" placeholder="Password" class=" regis_form border-0 form-control"
								   data-error="#pass">
							<span><i class="fa-solid fa-lock sukaii_pink_color"></i></span>
						</div>
						<div id="pass"></div>
					</div>
					<div class="confirm_password mb-3">
						<p class="mb-0 text-dark label_R">CONFIRM PASSWORD</p>
						<div class="align-items-center rounded border border-dark d-flex input pr-2">
							<input type="password" name="cmf_password" id="cmf_password" placeholder="Confirm Password" class="regis_form border-0 form-control"
								   data-error="#comfirm-pass">
							<span><i class="fa-solid fa-lock sukaii_pink_color"></i></span>
						</div>
						<div id="comfirm-pass"></div>
					</div>
					<div class="submit_btn my-4 text-center">
						<button type="submit" class="btn text-light btn-sm" style="font-family:var(--primaryText)"><b>REGISTER</b>
						</button>
					</div>
				</form>
				<p style="font-weight: 500;" class="text-center normal_text">Already have an account? <a
							href="<?php echo base_url('login'); ?>"  style="text-decoration:none; font-family: var(--secondryText);"
							class="sukaii_pink_color">Login here</a></p>
			</div>
		</div>
		<!-- <div class="col-1"></div> -->
	</div>
	<div id="footer"></div>

</div>


<?php $this->load->view("./layout/footer"); ?>

