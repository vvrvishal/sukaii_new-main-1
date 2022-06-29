<?php $this->load->view('layout/profile_header'); ?>
<style>
	.card {
		width: 400px;
		height: 300px;
		box-shadow: 0px 5px 10px 0px #d2dae3;
		z-index: 1;
		border-radius: 15px;
	}

	.card h6 {
		font-size: 20px
	}

	.inputs input {
		width: 40px;
		height: 40px
	}

	input[type=number]::-webkit-inner-spin-button,
	input[type=number]::-webkit-outer-spin-button {
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none;
		margin: 0
	}

	.form-control:focus {
		box-shadow: none;
		border: 2px solid #00b3b7
	}

	.validate {
		height: 40px;
		background-color: #ec098d;
		width: 140px
	}
	.bookingHeader{
		width: 55%;
	}
	#divMyBookings{
		width: 55%;
		margin: auto;
	}
	/* .container, #divMyBookings{
		width: 50%;
		margin: auto;
	}*/
	@media only screen and (max-width: 900px)  {
		.bookingHeader{
		width: unset;
	}
	#divMyBookings{
		width: unset;
		margin: auto;
	}
	
	} 
</style>
<div class="container-fluid" style="border-bottom: 2px solid gray;">
        <div class="row m-2 my-3">
            <div class="align-items-baseline col-md-12 d-flex justify-content-between px-0">
				<span><a href="<?=base_url("user_profile_menus")?>" class="text-dark">   <i class="fa-solid fa-left-long pr-3"></i></a></span>
                <span style="font-family: var(--primaryText);"><b>My Bookings</b></span>
                <span><a href="<?php echo base_url('user_profile_menus'); ?>"><i style="font-size: 20px; color: var(--themeGreen);" class="fa-solid fa-bars" ></i></a></span>
            </div>
        </div>

    </div>
    <div class="container bookingHeader" style="border-bottom: 2px solid gray;">
        <div class="row my-1">
            <div class="col-12 sub_sub_heading" style="font-family: var(--primaryText);">My Bookings</div>
        </div>
    </div>
    <div id="divMyBookings">

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
								<input class="m-2 text-center form-control rounded" type="text" id="first" maxlength="1" autofocus/>
								<input class="m-2 text-center form-control rounded" type="text" id="second" maxlength="1" />
								<input class="m-2 text-center form-control rounded" type="text" id="third" maxlength="1" />
								<input class="m-2 text-center form-control rounded" type="text" id="fourth" maxlength="1" />
								<input class="m-2 text-center form-control rounded" type="text" id="fifth" maxlength="1" />
								<input class="m-2 text-center form-control rounded" type="text" id="sixth" maxlength="1" />
							</div>
							<div class="mt-4"> <button id="getVerify" class="badge-pill btn font-weight-bold px-4 text-light validate" >Validate</button> </div>
<!--							data-toggle="modal" data-target="#velidateModel" onclick="getVerify(id)"-->
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

<!--				<h5 class="font-weight-bold text-center sukaii_pink_color" style="font-family: var(--primaryText);">Your massage send Successfuly</h5>-->
				<p class="text-center text-light" id="modalMsg" style="font-family: var(--secondryText);">We will Connect with you as soon as possible</p>
			</div>
		</div>
	</div>
</div>
    <script>
        $(document).ready(function(){
            getMyBookings();
        });
        function getMyBookings(){
            $.ajax({
                url : baseURL+'getMyBookings',
                type : 'GET',
                dataType:'json',
                success : function(result) {
                    if (result.status == 200) {
						$("#divMyBookings").empty();
						$("#divMyBookings").append(result.data);

                    }else{
                        app.successToast(response.data);
						$("#divMyBookings").empty();
						$("#divMyBookings").append(result.data);
                    }
                },
            });
        }
    </script>
<script>
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

	$("#getVerify").click(function() {
		// $("#enterOTPModel").hide();
		// $('#enterOTPModel').modal('toggle');
		// $("#velidateModel").show();
		// myModal.hide()
	});
	function verifyOtpModal(id,orderId,mobileNumber){
		$("#order_primaryid").val(id);
		$("#order_id").val(orderId);
		$("#patient_number").val(mobileNumber);
		let veryFuncText = `getVerify(${id},'${orderId}','${mobileNumber}')`;
		$("#getVerify").attr("onclick",veryFuncText);
	}

	function getVerify(id,orderId,mobileNumber)
	{
		var orderId = orderId;
		var id = id;
		var mobileNumber = mobileNumber;
		var first = $("#first").val();
		var second = $("#second").val();
		var third = $("#third").val();
		var fourth = $("#fourth").val();
		var fifth = $("#fifth").val();
		var sixth = $("#sixth").val();
		var otp = first+second+third+fourth+fifth+sixth;
		$.ajax({
			url: baseURL + 'verifyOtp',
			async: true,
			method: 'post',
			data:{otp:otp,id:id,orderId:orderId,mobileNumber:mobileNumber},
			dataType: 'json',
			success: function (data) {
				if(data.status==200){

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
				}
				else{
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

	function openorderdetails(id){
		$("#"+id).slideToggle();
	}


	function cancelOrder(orderId){
		if(confirm('Are you sure?')){
			$.ajax({
			url: baseURL + 'cancelOrder',
			method: 'post',
			data:{orderId:orderId},
			dataType: 'json',
			success: function (data) {
				if(data.status==200){

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
				}
				else{
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
		
	}


</script>
    <?php $this->load->view('layout/footer'); ?>
