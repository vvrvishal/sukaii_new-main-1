<?php $this->load->view('layout/profile_header'); ?>
<style>
	text {
		transform: rotate(90deg);
	}

	.svg {
		align-self: center;
		height: 50px;
		width: 50px;
		transform: rotate(-90deg);
	}

	circle {
		animation: spin 60s linear forwards;
	}

	@keyframes spin {
		0% {
			stroke-dashoffset: 126;
		}

		100% {
			stroke-dashoffset: 0;
		}
	}

	.tab_mobile_nav {
		font-weight: 600;
		cursor: pointer;
		position: absolute;
		top: calc(0% + 56.5px) !important;
		box-shadow: 0px 0px 4px 1px lightgrey;
		z-index: 100;
	}

	.resendOTP {
		color: indianred;
		font-size: 12px;
	}

	.iD {
		/* animation: spin 60s linear forwards; */
		border: 2px solid black;
		width: 50px;
		height: 50px;
	}
	.allordersBody{
		margin: auto;
		width: 60%;
	}
	.tab_mobile_nav{
		width: 20% !important;
	}
	@media only screen and (max-width: 700px) {
		.allordersBody{
		margin: auto;
		width: unset;
	}
	.tab_mobile_nav{
		width: 50% !important;
	}
	}
</style>

<body>
	<header id="Header" class="d-none d-md-block"></header>

	<div class="container-fluid" style="border-bottom: 2px solid gray;">
		<div class="row m-2 my-3">
			<div class="align-items-baseline col-md-12 d-flex justify-content-between px-0">
				<span></span>
				<span style="font-family: var(--primaryText);"><b>All Orders</b></span>
				<span id="sampleCollectormenu"><i style="font-size: 20px; color: var(--themeGreen);" class="fa-solid fa-bars"></i></span>
			</div>
		</div>

	</div>
	<div class="allordersBody">
		<div class="container" style="border-bottom: 2px solid gray;">
			<div class="row my-1">
				<div class="col-12 small" style="font-family: var(--primaryText);">Order List</div>

			</div>
		</div>
		<div class="tab_mobile_nav  w-50" id="sampleMobileMenuSection" style="display: none;">
			<ul class="border-0 form-control list-unstyled mb-0 nav-tabs px-0" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<a class="nav-link active border-0 text-dark" id="AllOrders" data-toggle="tab" role="tab" aria-controls="AllOrdersSection" aria-selected="true" onclick="getMyBookings('a');">All Orders</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link border-0 text-dark" id="OngoingOrders" data-toggle="tab" href="#OngoingOrdersSection" role="tab" aria-controls="OngoingOrdersSection" aria-selected="false" onclick="getMyBookings('og');">On Going Orders</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link border-0 text-dark" id="PendingOrders" data-toggle="tab" href="#PendingOrdersSection" role="tab" aria-controls="PendingOrdersSection" aria-selected="false" onclick="getMyBookings('po');">Pending Orders</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link border-0 text-dark" id="CompleteOrders" data-toggle="tab" href="#CompleteOrdersSection" role="tab" aria-controls="CompleteOrdersSection" aria-selected="false" onclick="getMyBookings('co');">Complete Orders</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link border-0 text-dark">My Profile</a>
				</li>

				<li class="nav-item" role="presentation">
					<?php
					if (isset($this->session->user_session)) { ?>
						<a href="<?= base_url('logout') ?>" class="nav-link border-0 text-dark">Logout</a>
					<?php } ?>

					<!-- <a href="<?= base_url('logout') ?>" style="text-decoration: none;" class="nav-link border-0 text-dark">
						<li class="border-0 form-control mobile_menu_list">LOGOUT</li>
					</a>
				<?php ?> -->
				</li>
			</ul>
		</div>


		<div class="tab-content" id="myTabContent">

		</div>
	</div>
	<!-- <div class="container" style="border-bottom: 2px solid gray;">

	</div> -->
	<!-- model  -->
	<div class="modal fade" id="otpGn" tabindex="-1" role="dialog" aria-labelledby="pwusuccess" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="m-auto modal-content " style="background-color: var(--themeGreen);">
				<div class="align-items-center modal-body">
					<input type="hidden" id="hdnOrderId" name="hdnOrderId">
					<h5 class="font-weight-bold mb-0 my-5 sukaii_pink_color text-center" style="font-family: var(--primaryText);">OTP Generated Successfully</h5>
					<div class="align-items-center border-0 card d-flex justify-content-center p-2 text-center">
						<h6 class="font-weight-bold" style="color: #00b3b7;">Please enter the OTP to verify your Service</h6>
						<input type="hidden" id="order_primaryid" name="order_primaryid">
						<input type="hidden" id="order_id" name="order_id">
						<input type="hidden" id="patient_number" name="patient_number">
						<div> <span>A code has been sent to clients mobile number</span> <small id="mobileNo"></small> <br></div>
						<div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
							<input class="m-2 text-center form-control rounded" type="text" id="first" maxlength="1" autofocus />
							<input class="m-2 text-center form-control rounded" type="text" id="second" maxlength="1" />
							<input class="m-2 text-center form-control rounded" type="text" id="third" maxlength="1" />
							<input class="m-2 text-center form-control rounded" type="text" id="fourth" maxlength="1" />
							<input class="m-2 text-center form-control rounded" type="text" id="fifth" maxlength="1" />
							<input class="m-2 text-center form-control rounded" type="text" id="sixth" maxlength="1" />
						</div>
						<div class="mt-4"> <button id="getVerify" class="badge-pill btn font-weight-bold px-4 text-light validate" style="background-color:#ec0998">Validate</button> </div>
						<input type="hidden" data-toggle="modal" id="openSuccessModal" name="openSuccessModal" data-target="#velidateModel">
					</div>
					<div class="counter d-flex justify-content-end mt-2" id="otpDurationCounter">
					</div>
					<div class="counter" id="otpRegenerate">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="enterOTPModel" tabindex="-1" role="dialog" aria-labelledby="enterOTPModel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content border-0" style="background-color: transparent;">
				<div class="modal-body">
					<div class="container h-100 d-flex justify-content-center align-items-center">
						<div class="position-relative">
							<div class="align-items-center border-0 card d-flex justify-content-center p-2 text-center">
								<h6 class="" style="color: #00b3b7;">Please enter the OTP to verify your Service</h6>
								<input type="hidden" id="order_primaryid" name="order_primaryid">
								<input type="hidden" id="order_id" name="order_id">
								<input type="hidden" id="patient_number" name="patient_number">
								<div> <span>A code has been sent to</span> <small id="mobileNo">*******9897</small> <br></div>
								<div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
									<input class="m-2 text-center form-control rounded" type="text" id="first" maxlength="1" autofocus />
									<input class="m-2 text-center form-control rounded" type="text" id="second" maxlength="1" />
									<input class="m-2 text-center form-control rounded" type="text" id="third" maxlength="1" />
									<input class="m-2 text-center form-control rounded" type="text" id="fourth" maxlength="1" />
									<input class="m-2 text-center form-control rounded" type="text" id="fifth" maxlength="1" />
									<input class="m-2 text-center form-control rounded" type="text" id="sixth" maxlength="1" />
								</div>
								<div class="mt-4"> <button id="getVerify" class="badge-pill btn font-weight-bold px-4 sukaii_pink_color text-light validate">Validate</button> </div>
								<input type="hidden" data-toggle="modal" id="openSuccessModal" name="openSuccessModal" data-target="#velidateModel">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="modal fade" id="velidateModel" tabindex="-1" role="dialog" aria-labelledby="velidateModel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="m-auto modal-content w-75" style="background-color: var(--themeGreen);">
				<div class="modal-body">

					<p class="text-center text-light" id="modalMsg" style="font-family: var(--secondryText);">We will Connect with you as soon as possible</p>
				</div>
			</div>
		</div>
	</div>
</body>
<script>
	$("#sampleCollectormenu").click(function() {
		$("#sampleMobileMenuSection").slideToggle();
	});
	$(document).mouseup(function(e) {
		var hideMenu = $("#sampleMobileMenuSection");
		var hideMenubtn = $("#sampleCollectormenu");
		if (!hideMenu.is(e.target) && !hideMenubtn.is(e.target) && hideMenu.has(e.target).length === 0) {
			$('#sampleMobileMenuSection').slideUp();
		}
	});

	function timercount(id) {
		timer();

		function timer() {
			var sec = 60;
			updateSec();
			$("#btnOtp" + id).hide();

			function updateSec() {
				sec--;
				if (sec < 10) {
					document.querySelector(`#time${id}`).innerHTML = sec;
				} else {
					document.querySelector(`#time${id}`).innerHTML = sec;
				}
				if (sec === 0) {
					stopTimer();
					$("#btnOtp" + id).show();
					$("#btnOtp" + id).html('Resend OTP');
				}
			}


			var interval = setInterval(updateSec, 1000);

			function stopTimer() {
				clearInterval(interval);
			}
		}
		// });
	}
</script>
<script>
	$(document).ready(function() {
		getMyBookings('a');
	});

	function getMyBookings(filter = '') {
		$.ajax({
			url: baseURL + 'getsampleCollectorsOrder',
			type: 'POST',
			dataType: 'json',
			data: {
				filter: filter
			},
			success: function(result) {
				if (result.status == 200) {
					$("#myTabContent").empty();
					$("#myTabContent").append(result.data);

				} else {
					app.successToast(response.data);
					$("#myTabContent").empty();
					$("#myTabContent").append(result.data);
				}
			},
		});
	}


	function generateOtp(id, otpBtnTxt, orderId, mobileNumber) {
		let TimmerValue = `<div class="align-items-center d-flex iD justify-content-center rounded-circle" id="time${id}"> 60 </div>`;
		$("#otpDurationCounter").empty().append(TimmerValue);
		timercount(id);
		$('#otpDurationCounter').html = "";
		// alert(id);
		var otp = Math.floor(100000 + Math.random() * 900000);
		$.ajax({
			url: baseURL + 'saveOtp',
			async: true,
			method: 'post',
			data: {
				otp: otp,
				id: id
			},
			dataType: 'json',
			success: function(data) {
				if (data.status == 200) {
					verifyOtpModal(id, orderId, mobileNumber);
					$("#hdnOrderId").val(id);
				} else {
					// $("#"+otpBtnTxt).empty();
					// $("#"+otpBtnTxt).text('Resend OTP');
				}
				console.log(data);
			}
		});
		$("#id01").html("Otp for id " + id + "is " + otp);
		return otp;

	}

	function verifyOtpModal(id, orderId, mobileNumber) {
		$("#order_primaryid").val(id);
		$("#order_id").val(orderId);
		$("#patient_number").val(mobileNumber);
		let veryFuncText = `getVerify(${id},'${orderId}','${mobileNumber}')`;
		$("#getVerify").attr("onclick", veryFuncText);
	}

	function getVerify(id, orderId, mobileNumber) {
		var orderId = orderId;
		var id = id;
		var mobileNumber = mobileNumber;
		var first = $("#first").val();
		var second = $("#second").val();
		var third = $("#third").val();
		var fourth = $("#fourth").val();
		var fifth = $("#fifth").val();
		var sixth = $("#sixth").val();
		var otp = first + second + third + fourth + fifth + sixth;
		$.ajax({
			url: baseURL + 'verifyOtp',
			async: true,
			method: 'post',
			data: {
				otp: otp,
				id: id,
				orderId: orderId,
				mobileNumber: mobileNumber
			},
			dataType: 'json',
			success: function(data) {
				if (data.status == 200) {
					$("#otpGn").hide();
					$("#mismatched").hide();
					$("#enterOTPModel").hide();
					$(".modal-backdrop").hide();
					$("#verified").show();
					$("#velidateModel").show();
					// $('#velidateModel').modal('show');
					// $(".modal-backdrop").hide();
					$("#openSuccessModal").click();
					$("#modalMsg").text(data.body);
					getMyBookings();
				} else {
					$("#mismatched").show();
					$("#enterOTPModel").hide();
					$(".modal-backdrop").hide();
					$("#verified").hide();
					$("#openSuccessModal").click();
					$("#modalMsg").text(data.body);
					getMyBookings();
				}
			}
		});
	}

	document.addEventListener("DOMContentLoaded", function(event) {

		function OTPInput() {
			const inputs = document.querySelectorAll('#otp > *[id]');
			console.log(inputs);
			for (let i = 0; i < inputs.length; i++) {
				inputs[i].addEventListener('keydown', function(event) {
					if (event.key === "Backspace") {
						inputs[i].value = '';
						if (i !== 0) inputs[i - 1].focus();
					} else {
						if (i === inputs.length - 1 && inputs[i].value !== '') {
							return true;
						} else if ((event.keyCode > 47 && event.keyCode < 58) || (event.keyCode >= 96 && event.keyCode <= 105)) {
							inputs[i].value = event.key;
							if (i !== inputs.length - 1) inputs[i + 1].focus();
							event.preventDefault();
						} else if (event.keyCode > 64 && event.keyCode < 91) {
							inputs[i].value = String.fromCharCode(event.keyCode);
							if (i !== inputs.length - 1) inputs[i + 1].focus();
							event.preventDefault();
						}
					}
				});
			}
		}
		OTPInput();
	});
</script>
<?php $this->load->view('layout/footer'); ?>