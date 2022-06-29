<?php $this->load->view("layout/admin_header"); ?>


<script type="text/javascript">
	var onloadCallback = function() {
		grecaptcha.render('html_element', {
			'sitekey': '6LcXmMoeAAAAAMeOWc27EskoFlBIFIrF-3WZEp_X'
		});
	};
</script>
<style>
	#sampleCollectorAddress[name="sampleCollectorAddress"] {
		height: 36px !important;
	}

	#sampleCollectorAddress[name="sampleCollectorAddress"]:focus {
		height: 60px !important;
	}

	#AnyQuery[name="comment_input"] {
		height: 36px !important;
	}

	#AnyQuery[name="comment_input"]:focus {
		height: 60px !important;
	}

	.activeSelection {
		background-color: #ec098d66;
	}

	.carousel_1_image {
		color: black !important;
		z-index: 10;
		position: absolute;
		top: 36%;
		left: 4%;
		font-size: 1rem;
	}

	.carousel_1_image h1 {
		font-size: 25px;
	}

	html {
		scroll-behavior: smooth;
	}

	#submit {
		background: #e8108e;
		font-weight: bold;
		border: none;
		border-radius: 3px;
	}

	.pwuFormlabel {
		font-weight: bold;
		margin-bottom: 0px;
	}

	.pwuForminput {
		color: darkgray;
		font-weight: 500;
	}
	.select2-selection__choice__display{
		font-size:16px;
		padding: 8px 5px;
	}
	.select2-container--default .select2-selection--multiple .select2-selection__choice__display {
		cursor: default;
		padding-left: 7px;
		padding-right: 11px;
	}
</style>
<style>
	.modal {
		display: none;
		position: fixed;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		overflow: auto;
		background-color: rgb(0, 0, 0);
		background-color: rgba(0, 0, 0, 0.4);
		padding-top: 60px;
		z-index:999;
	}

	/* Modal Content/Box */
	.modal-content {
		margin: auto;
		border: 1px solid #888;
		width: 50%;
	}

	/* The Close Button (x) */
	.close {
		position: absolute;
		right: 25px;
		top: 0;
		color: #000;
		font-size: 35px;
		font-weight: bold;
	}

	.close:hover,
	.close:focus {
		color: red;
		cursor: pointer;
	}

	/* Add Zoom Animation */
	.animate {
		-webkit-animation: animatezoom 0.6s;
		animation: animatezoom 0.6s
	}

	@-webkit-keyframes animatezoom {
		from {
			-webkit-transform: scale(0)
		}

		to {
			-webkit-transform: scale(1)
		}
	}

	@keyframes animatezoom {
		from {
			transform: scale(0)
		}

		to {
			transform: scale(1)
		}
	}

	/* Change styles for span and cancel button on extra small screens */
	@media screen and (max-width: 300px) {
		span.psw {
			display: block;
			float: none;
		}

		.cancelbtn {
			width: 100%;
		}
	}

	.pwuFormlabel {
		margin-bottom: 0px !important;
	}
</style>

<div class="card">
	<div class="card-body">
		<div class="container-fluid">
			<div class="row mt-3">
				<div class="align-items-baseline col-12 d-flex justify-content-between m-auto pl-0">
					<h4 class="card-title mb-1">SAMPLE COLLECTORS</h4>
					<button type="button" class="btn fa fa-plus btn-sm" id="openSCF" onclick="showForm()" style="background-color: #d9d9d9; border-radius: 4px !important;"></button>
				</div>
				<div class="col-12 mt-4">
					<div class="table-responsive w-100">
						<table class="table table-bordered w-100" style="width: unset !important;" id="collectorTable">
							<thead>
								<tr>
									<th>Name</th>
									<th>Email</th>
									<th>Username</th>
									<th>Password</th>
									<th>Mobile</th>
									<th>Address</th>
									<th>Location</th>
									<th>Id Proof</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>

				</div>
				<div id="id01" class="modal">

					<form class="modal-content animate" id="SampleController_form" method="post" enctype="multipart/form-data">
						<div class="imgcontainer">
							<span onclick="document.getElementById('id01').style.display='none'" id="close_model" class="close" title="Close Modal">&times;</span>
						</div>

						<div class="" id="collector_form">
							<div class="card-tital pt-4 px-4" style="font-size: 20px; font-weight: 600;">Sample
								Collector
							</div>
							<div class="row ">
								<div class="col-md-11 mt-2 mb-3 m-auto" style="  padding: 6px 30px;">
									<input type="hidden" name="sampleId" id="sampleId">
									<div class="form-group mb-3">
										<label class="pwuFormlabel">NAME</label>
										<input type="text" class="form-control pwuForminput" style="margin-top: 1px;" name="name_input" placeholder="Name" id="name_input" required>
									</div>
									<div class="form-group mb-3">
										<label class="pwuFormlabel">E-MAIL</label>
										<input type="email" class="form-control pwuForminput" name="email_input" placeholder="E-mail" id="email_input">
									</div>
									<div class="form-group mb-3">
										<label class="pwuFormlabel">PASSWORD</label>
										<input type="password" class="form-control pwuForminput" name="password_input" placeholder="Password" id="password_input">
									</div>
									<div class="form-group mb-3">
										<label class="pwuFormlabel">PHONE</label>
										<input type="number" class="form-control pwuForminput" name="phone_input" placeholder=" Phone" id="phone_input">
									</div>
									<div class="form-group mb-3">
										<label class="pwuFormlabel">ADDRESS</label>
										<textarea name="sampleCollectorAddress" id="sampleCollectorAddress" class="form-control pwuForminput" placeholder="Address"></textarea>
									</div>
									<div class="form-group mb-3">
											<label class="pwuFormlabel">ALLOCATED LOCATION</label>
												<select class="selectLocation" style="height:40px;width:100%;z-index:99999999999;"
												name="allocated_location[]" id="allocated_location"
													   multiple="multiple">
													  <?php foreach($location->data as $locations){  ?>
														<option style="width:50px;" value="<?php echo $locations->id; ?>"><?php echo $locations->location_name; ?></option><?php } ?>
												</select>
									</div>
									<div class="form-group mb-3">
										<label class="pwuFormlabel">ID PROOF</label>
										<input type="file" class="form-control pwuForminput py-2" name="IDProof[]" id="IDProof">
									</div>
									<button class="btn btn-sm float-end rounded-1 text-light" style="background: #0db4b7; font-weight: 700;">Save changes</button>
								</div>
							</div>

						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<?php $this->load->view("layout/admin_footer"); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
	$(document).ready(function () {
		loadSampleDetails();
		loadFormValidation();
		$('#allocated_location').select2();
	});
</script>
