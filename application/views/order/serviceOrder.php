<?php $this->load->view('layout/header'); ?>
<style>
	.hidden_days {
		display: none;
		position: absolute;
		top: 0%;
		left: 0%;
		right: 0%;
	}

	.disableTime {
		background-color: #9f9f9f;
	}
	.schedule_time{
		width: 60%;
	}
	@media only screen and (max-width: 700px)  {
		.schedule_time{
		width: unset;
	}
	}
</style>
<?php $t = $this->session->cart_session;	 ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="text-center">
				<?php
				if (!isset($service_id) && !isset($service_name) && !isset($service_rate) && !isset($service_discount) && !isset($service_sale)) {
					redirect("/");
				}
				if ($service_id == 1481) { ?>
					<img src="<?php echo base_url('assets/sukaii_icons/Covid.png'); ?>" style="width: 33%;" class="mt-3 covid_pcr_Form_icon" alt="">
					<h6 style="color: var(--themePink); font-size:20px; font-family:var(--primaryText);" class="font-weight-bold mt-2 mb-3">COVID RT-PCR TEST</h6>
				<?php } else if ($service_id == 1482) { ?>
					<img src="<?php echo base_url('assets/sukaii_icons/BASIC-HEALTH-CHECK-UP.png'); ?>" style="width: 33%;" class="mt-3 covid_pcr_Form_icon" alt="">
					<h6 style="color: var(--themePink); font-size:20px;  font-family:var(--primaryText);" class="font-weight-bold mt-2 mb-3">BASIC HEALTH CHECK UP</h6>
				<?php } else if ($service_id == 1483) { ?>
					<img src="<?php echo base_url('assets/sukaii_icons/COMPLETE-HEALTH-CHECK-UP.png'); ?>" style="width: 33%;" class="mt-3 covid_pcr_Form_icon" alt="">
					<h6 style="color: var(--themePink); font-size:20px;  font-family:var(--primaryText);" class="font-weight-bold mt-2 mb-3">COMPLETE HEALTH CHECK
						UP</h6>
				<?php } else if ($service_id == 1484) { ?>
					<img src="<?php echo base_url('assets/sukaii_icons/LEN-LEN-TEST.png'); ?>" style="width: 33%;" class="mt-3 covid_pcr_Form_icon" alt="">
					<h6 style="color: var(--themePink); font-size:20px;  font-family:var(--primaryText);" class="font-weight-bold mt-2 mb-3">LEN-LEN TEST</h6>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php
	$patient_name = '';
	$patient_number = '';
	$hdnServiceId = '';
	$hdnscheduleTime = '';
	$hdnscheduleDate = '';
	$hdnLocation = '';
	$hdnscheduleFullDate = "";
	$hdnOrderPid = '';
	if (isset($this->session->page_session)) {
		$cartItems = $this->session->page_session;
		foreach ($cartItems as $serviceItems) {
			if ($serviceItems->service_id == $service_id) {
				$patient_name = $serviceItems->patient_name;
				$patient_number = $serviceItems->patient_number;
				$hdnLocation = $serviceItems->location;
				$hdnscheduleTime = $serviceItems->schedule_time;
				$hdnscheduleDate = $serviceItems->schedule_date;
				$hdnscheduleFullDate = $serviceItems->schedule_full_date;
				break;
			}
		}
	} else if (isset($this->session->user_session)) {
		$patient_name = $this->session->user_session->name;
		$patient_number = $this->session->user_session->contact;
	}
	$btnText = 'CONFIRM';
	$userId = 0;
	if ($action == 'edit'){
		$patient_name = $e_patient_name;
		$patient_number = $e_patient_number;
		$hdnLocation = $e_location;
		$hdnscheduleDate = $e_schedule_date;
		$hdnscheduleTime = $e_schedule_time;
		$hdnOrderPid = $e_orderPid;
		$userId = $e_userId;
		$btnText = 'UPDATE';
	}
	if ($action == 'edit'){ ?>
	<form id="formServiceOrderUpdate" method="post">
	<?php }else{ ?>
	<form id="formServiceOrder" method="post">
	<?php } ?>


		<div class="row mt-4  mb-3">
			<div class="col-12 px-0 col-md-7 mx-md-auto">

				<div class="row">
					<input type="hidden" id="hdnUserId" name="hdnUserId" value="<?= $userId; ?>">
					<input type="hidden" id="hdnServiceId" name="hdnServiceId" value="<?= $service_id; ?>">
					<input type="hidden" id="hdnServiceName" name="hdnServiceName" value="<?= $service_name; ?>">
					<input type="hidden" id="hdnServicePrice" name="hdnServicePrice" value="<?= $service_rate; ?>">
					<input type="hidden" id="hdnServiceDiscount" name="hdnServiceDiscount" value="<?= $service_discount; ?>">
					<input type="hidden" id="hdnServiceSalePrice" name="hdnServiceSalePrice" value="<?= $service_sale; ?>">
					<input type="hidden" id="hdnOrderPid" name="hdnOrderPid" value="<?= $hdnOrderPid; ?>">

					<div class="col-6 mb-3 pr-2">
						<p class="mb-0 small" style="font-weight: 500; font-size:16px;">NAME</p>
						<input type="text" name="patient_name" id="patient_name" placeholder="ENTER YOUR FULL NAME" class="form-control border-dark patient_details" value="<?= $patient_name ?>">
					</div>
					<div class="col-6 mb-3 pl-0">
						<p class="mb-0 small" style="font-weight: 500; font-size:16px;">NUMBER</p>
						<input type="number" name="patient_number" id="patient_number" placeholder="ENTER YOUR MOBILE NUMBER" class="form-control border-dark patient_details" maxlength="10" value="<?= $patient_number ?>">
					</div>
					<div class="col-12">
						<div class="form-group mb-0">
						</div>
						<div class="form-group mb-0">
							<label for="Conpany_email" style=" font-size:16px;" class="pwuFormlabel mb-0 small">LOCATION</label>

							<div class="form-control form-group m-0 rounded border-dark" id="pws_service" style="padding-bottom: 0px;">
								<div class="align-items-baseline d-flex selector">
									<input type="text" readonly style="background-color: transparent;" name="serviceBookingLocation" id="serviceBookingLocation" placeholder="<?= $hdnLocation !== "" ? $hdnLocation : 'SELECT DISTRICT'; ?>" value="<?= $hdnLocation !== "" ? $hdnLocation : ''; ?>" data-error="#location" class="border-0 form-control pb-2 pl-0 py-0 patient_details">
									<i class="fa-solid fa-caret-down" style="color: var(--themeGreen);"></i>
								</div>
							</div>
							<div id="location"></div>
						</div>
						<div class="select_location border p-2 mb-3" id="servuceBooking_location_ddvalue" style="border-radius: 7px; background: #ededed; width: 95%; margin: auto; display: none;" id="">
							<p class="option_location border-dark form-control mb-2 mx-auto text-dark" style="border-radius: 7px; width: 95%; font-size: 14px;" attr-status="1">Watthana</p>
							<p class="option_location border-dark form-control mb-2 mx-auto" style="border-radius: 7px; width: 95%; font-size: 14px;" attr-status="1">Khlong Toei</p>
							<p class="option_location border-dark form-control mb-2 mx-auto" style="border-radius: 7px; width: 95%; font-size: 14px;" attr-status="1">Bang Rak</p>
							<p class="option_location border-dark form-control mb-2 mx-auto" style="border-radius: 7px; width: 95%; font-size: 14px;" attr-status="1">Sathon</p>
							<p class="option_location border-dark form-control mb-2 mx-auto" style="border-radius: 7px; width: 95%; font-size: 14px;" attr-status="1">Pathum Wan</p>
							<p class="option_location border-dark form-control mb-2 mx-auto" style="border-radius: 7px; width: 95%; font-size: 14px; color: #a5a5a5 !important;" attr-status="0">Other</p>
							<!-- <p class="option_location border-dark form-control mb-2 mx-auto"
							   style="border-radius: 7px; width: 95%;" attr-status="0">Phuket</p> -->
						</div>
					</div>
					<div class="col-md-12 mt-3 mb-1">
						<div class="mb-2">
							<p class="mb-0 small" style="font-weight: 500;  font-size:16px;">SCHEDULE</p>
							<input type="hidden" id="pic_schedule_date_h" name="pic_schedule_date_h" value="<?= $hdnscheduleDate ?>" data-error="#date">
							<input type="hidden" id="pic_schedule_full_date_h" name="pic_schedule_full_date_h" value="<?= $hdnscheduleFullDate ?>">
							<input type="hidden" id="pic_schedule_time_h" name="pic_schedule_time_h" data-error="#time" value="<?= $hdnscheduleTime ?>">
							<div class="border-dark d-flex form-control justify-content-between patient_details" id="pic_schedule_time" style=" height: 34px; font-weight: 500;">
								<!-- <p class="mb-0" id="schdule_placeholder">Enter Schedule</p> -->
								<div>
									<span id="pic_schedule_date_text" style="font-size: 14px;">
										<?= $hdnscheduleDate ? $hdnscheduleDate : 'SELECT DATE & TIME'; ?>
									</span>
									<span id="pic_schedule_time_text" style="font-size: 14px;"><?= $hdnscheduleTime ?></span>
								</div>
								<i class="fa-solid fa-caret-down" style="color: var(--themeGreen);"></i>
							</div>
							<div class="d-flex align-items-center justify-content-around">
								<div id="date"></div>
								<div id="time"></div>
							</div>

							<small class="" style="color: #a9a9a9!important;">Your service will take approx 30
								mins.</small>

						</div>
					</div>

				</div>
				<div class="totalDAys position-relative" style="display: none;" id="schedule_date">
					<?php
					$count = 0;
					$Dcounter = 1;
					for ($i = 1; $i <= 12; $i++) {
						$date = date("Y-m-d", strtotime('+' . $i . 'day'));
						$currentDay = date("D", strtotime('+' . $i . 'day'));

						$currentDate = date("d", strtotime('+' . $i . 'day'));

						if ($count == 0) {
							$class = "hidden_days";
							if ($Dcounter == 1) {
								$class = "visible_days";
							}
					?>
							<div class="<?php echo $class ?>">
								<div class=" align-items-center d-flex justify-content-around schedule_day_div w-100">
								<?php $count = 1;
							} ?>
								<div class="font-weight-bold schedule_day text-center" attr-scheduleDay="<?= $date ?>" attr-scheuduleDate="<?= $currentDay . ' ' . $currentDate ?>">
									<p class="mb-0 date calendar_date"><?php echo $currentDay; ?>
										<br><?php echo $currentDate; ?>
									</p>
								</div>
								<?php if ($i % 6 == 0) { ?>
									<span><i id="show_<?php echo $Dcounter; ?>nd_week" class="fa-solid pl-1 fa-caret-right "></i></span>
								</div>
							</div>
					<?php $count = 0;
									$Dcounter = 2;
								}
							} ?>
					<?php $time = array('07.00 AM', '07.30 AM', '08.00 AM', '08.30 AM', '09.00 AM', '09.30 AM', '10.00 AM', '10.30 AM', '11.00 AM', '11.30 AM', '12.00 PM', '12.30 PM', '01.00 PM', '01.30 PM', '02.00 PM', '02.30 PM', '03.00 PM', '03.30 PM', '04.00 PM', '04.30 PM'); ?>
					<small class="schedule_time_text" style="color: #a9a9a9!important;">Free Cancellation before
						2hrs.</small>
				</div>
			</div>
			<?php if (!empty($orderData)) { ?>
				<div class="row mt-3 mx-md-auto  schedule_time">
				<?php } else { ?>
				<div class="row mt-3 mx-md-auto schedule_time" style="display: none;">
					<?php }
				if (!empty($orderData)) {
					if ($orderData['sessionScheduleTime'] == $row) {
						$time_status = 'active';
					} else {
						$time_status = '';
					}
				} else {
					$time_status = '';
				}
				$timeSchedule_status = 0;
					?>
					</div>

					<input type="hidden" name="hdnscheduleDate" id="hdnscheduleDate" value="<?= $hdnscheduleDate ?>">
					<input type="hidden" name="hdnscheduleTime" id="hdnscheduleTime" value="<?= $hdnscheduleTime ?>">

					<div class="w-100 submitpwuForm text-center mt-4">
						<!-- <button type="button" class="btn btn-sm font-weight-bold px-3 sukaii_pink_bgcolor text-center text-light" data-toggle="modal" data-target="#pwusuccess">CONFIRM</button> -->
						<!-- <a href="{{URL::to('invoice')}}"> -->
						<button type="submit" class="btn btn-sm font-weight-bold px-3 sukaii_pink_bgcolor text-center text-light">

							<?php echo $btnText; ?>
						</button>
						<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pwusuccess">Open Modal</button> -->
						<!-- </a> -->
					</div>


				</div>
		</div>

		<button id="noServiceModal" type="button" class="d-none" data-toggle="modal" data-target="#pwusuccess"></button>
		<!-- Modal -->
		<div class="modal fade" id="pwusuccess" tabindex="-1" role="dialog" aria-labelledby="pwusuccess" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="m-auto modal-content w-75" style="background-color: var(--themeGreen);">
					<div class="modal-body">
						<p class="text-center text-light" style="font-family: var(--secondryText);">We do not service your
							area at the moment.</p>
						<h5 class="font-weight-bold text-center sukaii_pink_color" style="font-family: var(--primaryText);">
							SEE YOU SOON !!!</h5>

					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	$('.close_modal').click(function() {
		$("#pwusuccess").removeClass('show').css('display', 'none');
	});
	$(".schedule_day").on("click", function() {
		let scheduleDateText = $(this).attr('attr-scheuduleDate');
		let previousSelected = $("#pic_schedule_date_h").val();
		if (previousSelected !== scheduleDateText) {
			$("#pic_schedule_time_text").text("");
		}



		$("#pic_schedule_date_text").text(scheduleDateText);
		$("#pic_schedule_date_h").val(scheduleDateText);
		let scheduleDate = $(this).attr('attr-scheduleDay');
		$("#pic_schedule_full_date_h").val(scheduleDate);
		let serviceId = $("#hdnServiceId").val();
		let hdnLocation = $("#serviceBookingLocation").val();
		if (hdnLocation === "Location") {
			app.errorToast("Select location");
		} else {
			let formData = new FormData();
			formData.set("scheduleDate", scheduleDate);
			formData.set("service_id", serviceId);
			formData.set("hdnLocation", hdnLocation);
			app.request("getTimeSlot", formData).then(response => {
				$(".schedule_time").show();
				$(".schedule_time").empty();
				$(".schedule_time").append(response.body)
			}).catch(error => {

			})
		}
	})

	$(".option_location").click(function() {
		let option_value = $(this).text();
		// console.log(option_value);
		if ($(this).attr('attr-status') == 1) {
			$("#pic_schedule_time").removeAttr("disabled");
			$("#schedule_date").show();
			// $(".schedule_time").show();
			$(".option_location").css('background', '#fff').css('color', '#000');
			$(this).css('background', '#ec098d66').css('color', '#fff');

			$("#serviceBookingLocation").val(option_value);
			$("#hdnLocation").val(option_value);
			$("#servuceBooking_location_ddvalue").slideToggle();
		} else {

			$("#pic_schedule_time").attr("disabled", "disabled");
			$("#schedule_date").hide();
			$(".schedule_time").hide();
			$("#hdnLocation").val("");
			$("#hdnscheduleTime").val("").val("0");
			$("#hdnscheduleDate").val("0");
			$("#pic_schedule_time").attr("placeholder", 'DATE AND TIME');
			$('#noServiceModal').click();
			$.ajax({
				url: '{{URL::to("saveLocation")}}',
				type: 'POST',
				data: {
					"_token": "{{ csrf_token() }}",
					'location': option_value,
				},
				dataType: 'json',
				success: function(result) {},
			});
		}

	});

	$("#pic_schedule_time").click(function() {
		$("#schedule_date").show();

	})

	$(".calendar_date").on("click", function() {
		let scheduleDate = $(this).text();
		$("#hdnscheduleDate").val("").val(scheduleDate);
	});

	function getScheduleTime(scheduleTime, timeSchedule_status, schedule_date, event, slotNotAllow) {
		if (timeSchedule_status === 0) {
			// checkOrderPerTimeSlotCount(timeSchedule_status);
			$("#pic_schedule_time_h").val(scheduleTime);
			$(".schudule_time.schudule_time_div.active").removeClass("active")
			$(event).addClass('active');
			$("#pic_schedule_time_text").text(scheduleTime);
		} else {
			$("#pic_schedule_time_text").text("");
			$("#pic_schedule_time_h").val("");
			// checkOrderPerTimeSlotCount(timeSchedule_status);
			$("#hdnscheduleTime").val("").val("0");
		}

	}

	$("#formServiceOrderUpdate").on("submit",function(e){
		e.preventDefault();
		let formData = new FormData();

		formData.set("hdnServiceId",$("#hdnServiceId").val());
		formData.set("hdnServiceName",$("#hdnServiceName").val());
		formData.set("hdnServicePrice",$("#hdnServicePrice").val());
		formData.set("hdnServiceDiscount",$("#hdnServiceDiscount").val());
		formData.set("hdnServiceSalePrice",$("#hdnServiceSalePrice").val());
		formData.set("hdnOrderPid",$("#hdnOrderPid").val());
		formData.set("patient_name",$("#patient_name").val());
		formData.set("patient_number",$("#patient_number").val());
		formData.set("serviceBookingLocation",$("#serviceBookingLocation").val());
		formData.set("pic_schedule_date_h",$("#pic_schedule_date_h").val());
		formData.set("pic_schedule_full_date_h",$("#pic_schedule_full_date_h").val());
		formData.set("pic_schedule_time_h",$("#pic_schedule_time_h").val());
		formData.set("hdnscheduleDate",$("#hdnscheduleDate").val());
		formData.set("hdnscheduleTime",$("#hdnscheduleTime").val());
		formData.set("hdnUserId",$("#hdnUserId").val());

		// formData.set("scheduleDate", scheduleDate);
		// formData.set("service_id", serviceId);
		// formData.set("hdnLocation", hdnLocation);
		app.request("updateOrder", formData).then(response => {
			if (response.status == 200){
				window.location.href = baseURL+'my_booking';
				app.successToast(response.data);
			}else{
				app.errorToast(response.data);
			}

		}).catch(error => {

		})
		// console.log($(this).serialize());
	});
</script>
<?php $this->load->view('layout/footer'); ?>
