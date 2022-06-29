<?php $this->load->view('layout/admin_header'); ?>
<style>
	.modal {
		/* display: none; */
		position: fixed;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		overflow: auto;
		background-color: rgb(0, 0, 0);
		background-color: rgba(0, 0, 0, 0.4);
		padding-top: 60px;
	}
	.dataTable th, .dataTable td{
		line-height: 36px !important;
	}
	.badge {
    padding: 0.175rem 0.625rem;
	}
	button.btn.btn-inverse-dark.px-2.py-1{
		box-shadow: none !important;
	}
	a.btn.btn-inverse-dark.px-2.py-1.rounded-3{
		box-shadow: none !important;
	}
	.filters{
		margin-left:55%;
		/* padding:10px; */
		margin-right:0px;
	}
	#statusFilter{
		margin-left:39px;
		margin-right:-10px;
	}
	span.select2-selection.select2-selection--single{
		padding: 0px !important;
	}
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<div class="modal fade" id="viewOTPModel" tabindex="-1" role="dialog" aria-labelledby="viewOTPModel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content border-0" style="background-color: transparent;">
			<div class="modal-body">
				<div class="container h-100 d-flex justify-content-center align-items-center">
					<div class="position-relative">
						<div class="card justify-content-center p-5 text-center" style="height: 200px;">
							<h6 class="mb-2" style="color: #00b3b7;">OTP for <span id="otpPatientName"></span></h6>
							<div> <span>OTP generated for order </span> <small id="otpOrderId"></small> <br></div>
							<div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
<!--								<input class="m-2 text-center form-control rounded font-weight-bold" readonly value="1" id="first" maxlength="1" />-->
<!--								<input class="m-2 text-center form-control rounded font-weight-bold" readonly type="text" value="2" id="second" maxlength="1" />-->
<!--								<input class="m-2 text-center form-control rounded font-weight-bold" readonly type="text" value="3" id="third" maxlength="1" />-->
<!--								<input class="m-2 text-center form-control rounded font-weight-bold" readonly type="text" value="4" id="fourth" maxlength="1" />-->
<!--								<input class="m-2 text-center form-control rounded font-weight-bold" readonly type="text" value="1" id="fifth" maxlength="1" />-->
<!--								<input class="m-2 text-center form-control rounded font-weight-bold" readonly type="text" value="5" id="sixth" maxlength="1" />-->
									<span id="otpDisplay" class="align-items-center card-title d-flex form-control justify-content-center mb-0 mt-2 p-0" style="border: 1px solid #16babd; letter-spacing: 2px;"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="DivOrderDetails">
	<div class="row">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<div class="filters">
				</div>
					<h4 class="card-title">Order Details</h4>

					<div class="pt-3">
						<div class="d-flex filters justify-content-end mb-2">
							<select class="w-25 form-control ml-3 text-black" name="locationFilter" id="locationFilter" onchange="loadDetails('location',this.value);" style="margin-right: 10px;">
								<option value="">--Select a location--</option>
								<option value="Watthana">Watthana</option>
								<option value="Khlong Toei">Khlong Toei</option>
								<option value="Bang Rak">Bang Rak</option>
								<option value="Sathon">Sathon</option>
								<option value="Pathum Wan">Pathum Wan</option>
							</select>
							<select  class="w-25  ml-3 form-control text-black" name="statusFilter" id="statusFilter" onchange="loadDetails('status',this.value);">
								<option value="">--Select a status--</option>
								<option value="5">Pending</option>
								<option value="2">Completed</option>
								<option value="3">Cancel</option>
								<option value="4">Payment Failed</option>
								<option value="7">On Going</option>
							</select>
						</div>
						<div class="table-responsive">
						<table class="dataTable border-top dataTable no-footer table-bordered text-center" id="tableOrderDetails" style="width: 100%; font-size: small !important;">
							<thead>
							<tr>
								<th>Order Id</th>
								<th>Patient Name</th>
								<th>Service Name</th>
								<th>Schedule Date Time</th>
								<th>Location</th>
								<th>Payment Mode</th>
								<th>status</th>
								<th>OTP</th>
								<th></th>
							</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		</div>

	</div>

<?php $this->load->view('layout/admin_footer'); ?>
<script
      src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
      integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer">
</script>
<script>
	$(document).ready(function () {
		if (localStorage.getItem("columnName") === null) {
			loadDetails('active_status','1');
		}else{
			loadDetails(localStorage.getItem('columnName'),localStorage.getItem('columnValue'));
			localStorage.clear();
		}

		// $("#locationFilter").select2({
		// 	allowClear:true,
		// });
	  	// $("#statusFilter").select2({
        // 		allowClear:true,
      	// });
		// $("#report_123").change(function () {
		// 	let formId = $(this).parent('form').attr('id');
		// 	let formData = document.getElementById(formId);
		// 	$.ajax({
		// 		url: baseURL + 'fileToUpload',
		// 		type: "POST",
		// 		processData: false,
		// 		contentType: false,
		// 		async: false,
		// 		cache: false,
		// 		data: new FormData(formData),
		// 		dataType: "json",
		// 		success: function (resp) {
		// 			console.log(resp);
		// 			if (resp.status === 200) {
		// 				app.successToast(resp.msg);
		// 				// window.location.href = baseURL + 'viewPaymentReciept/' + resp.order_id;
		// 			} else {
		// 				app.errorToast(resp.msg);
		// 				window.location.href = baseURL;
		// 			}
		// 		},
		// 		fail:function (error) {
		// 			console.log(error);
		// 		}
		// 	});
		// })
	})
</script>
