<?php $this->load->view("./layout/header");?>

<script type="text/javascript">
	var onloadCallback = function() {
		grecaptcha.render('html_element', {
			'sitekey' : '6LcXmMoeAAAAAMeOWc27EskoFlBIFIrF-3WZEp_X'
		});
	};
</script>

<div class="container">
	<div class="row mt-3">
		<div class="col-9 m-auto pl-0 pr-0">
			<h4 class="border-bottom border-dark font-weight-bold pb-1 pl-4 sukaii_pink_color" style="font-family: var(--primaryText);">PARTNER WITH US</h4>
			<p class="pl-4 small normal_text" style="font-family: var(--secondryText);">Thank you for your interest in working with Sukaii. Please compete the form below to tell us more about you and your company</p>
		</div>
		<div class="col-3 col-md-1 pl-0">
			<img src="<?=base_url('assets/sukaii_icons/Partner-with-us.png')?>" class="position-absolute parternerWsImages" alt="">
		</div>
	</div>
</div>
<div class="container px-4">
	<!-- form section inside a partners with us  -->
	<div class="row">
		<div class="col-md-8 col-12 m-md-auto">
			<form class="mt-3" id="partner_form" method="post">
				<div class="form-group ">
					<label for="name_input " class="pwuFormlabel">YOUR NAME</label>
					<input type="text" class="form-control pwuForminput" name="name_input" placeholder="Name" id="name_input">
					<!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
				</div>

				<div class="form-group ">
					<label for="Company_name_input" class="pwuFormlabel">COMPANY NAME</label>
					<input type="text" class="form-control pwuForminput" name="Company_name_input" placeholder="Company Name" id="Company_name_input">
				</div>
				<div class="form-group ">
					<label for="DESIGNATION " class="pwuFormlabel">DESIGNATION</label>
					<input type="text" class="form-control pwuForminput" name="designation_input" placeholder="Designation" id="designation_input">
				</div>
				<div class="form-group ">
					<label for="Conpany_email" class="pwuFormlabel">COMPANY E-MAIL</label>
					<input type="email" class="form-control pwuForminput" name="company_email_input" placeholder="Company E-mail" id="company_email_input">
				</div>
				<div class="form-group ">
					<label for="Conpany_phone" class="pwuFormlabel">COMPANY PHONE</label>
					<input type="number" class="form-control pwuForminput" name="company_phone_input" placeholder="Company Phone" id="company_phone_input">
				</div>

				<div class="form-group ">
					<!-- <label for="Conpany_email" class="pwuFormlabel" >Services</label> -->
					<label  class="pwuFormlabel">SERVICES</label>
					<div class="form-control form-group " id="pws_service" style="border-radius:7px; border: 2px solid; padding-bottom: 0px;">
						<div class="align-items-baseline d-flex selector">
							<input name="company_services_input" class="border-0 form-control pb-2 py-0" placeholder="Services" id="company_services_input"/>

							<i class="fa-solid fa-caret-down" style="color: var(--themeGreen);"></i>
						</div>
					</div>
				</div>
				<div class="select_location border p-2 mb-3 rounded" id="pws_dd_service_value" style="background: #ededed; width: 95%; margin: auto; display: none;">
					<p class="border-dark form-control mb-2 mx-auto serviceValue activeSelection text-light"
					   onclick="getServicesValue(this,'Diagnostic Lab')"
					   style="border-radius: 7px; width: 95%;">Diagnostic Lab</p>
					<p class="border-dark form-control mb-2 mx-auto serviceValue" style="border-radius: 7px; width: 95%;"
					   onclick="getServicesValue(this,'Nurse Service')">Nurse Service</p>
					<p class="border-dark form-control mb-2 mx-auto serviceValue" style="border-radius: 7px; width: 95%;"
					   onclick="getServicesValue(this,'Physiotherapy')">Physiotherapy</p>
					<p class="border-dark form-control mb-2 mx-auto serviceValue" style="border-radius: 7px; width: 95%;"
					   onclick="getServicesValue(this,'Elderly Care')">Elderly Care</p>
					<p class="border-dark form-control mb-2 mx-auto serviceValue" style="border-radius: 7px; width: 95%;"
					   onclick="getServicesValue(this,'Medical Equipment Rentals')">Medical Equipment Rentals</p>
				</div>
				<div class="form-group mb-2">
					<label for="Questions_comments" class="font-weight-bold mb-0 mt-1 pwuFormlabel text-dark rounded" style="font-size: larger; font-family: var(--primaryText);">QUESTIONS / COMMENTS</label>
					<textarea name="comment_input" id="Questions_comments" class="pwuForminput rounded form-control" rows="3"></textarea>
				</div>
				<div class="form-group mb-2">
					<p for="capcha" class="mb-0 text-dark" style="font-weight:600;"> CAPCHA</p>
					<div id="html_element" class=""></div>
				</div>

				<div class="submitpwuForm text-center mt-4 mb-3">
					<button type="submit" class="btn btn-sm font-weight-bold px-3 sukaii_pink_bgcolor text-center text-light" >Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- <button type="button"
		id="successPartner"
		data-toggle="modal"
		data-target="#pwusuccess"
		 ></button> -->

<!-- ssuccces form popup  -->
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="pwusuccess" tabindex="-1" role="dialog" aria-labelledby="pwusuccess" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="m-auto modal-content w-75" style="background-color: var(--themeGreen);">
			<div class="modal-body">
				<h5 class="font-weight-bold text-center sukaii_pink_color" style="font-family: var(--primaryText);">THANK YOU !</h5>
				<p class="text-center text-light" style="font-family: var(--secondryText);">for enquiring with us. We shall connect with you shortly</p>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view("./layout/footer");?>
