<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>mail reader</title>
	<link rel="stylesheet" href="<?= base_url()?>assets/mcss/style.css">

	<style>
		.receipt {
			margin-top: 10px;
			box-shadow: 0px 0px 9px lightgrey;
			padding: 20px 27px;
		}

		@media only screen and (max-width: 700px) {

			.receipt {
				margin-top: 10px;
				box-shadow: none;
				padding: none;

			}
		}
	</style>

</head>

<body style="padding: 0px; margin: 0px;">
	<div style="display: flex; justify-content: space-between; padding: 0px 10px; box-shadow: 0px 1px 6px 0px lightgrey;">
		<a href="<?= base_url(); ?>"> <img src="<?= base_url(); ?>assets/images/sukaii_transparent_logo.png" alt="Sukaii" style="max-width: 125px; width: 100%; height: 53px;"></a>
		<h5>Total Amount : <span><?= $grandTotal; ?></span></h5>
	</div>
	<div class="container" style="margin: 0.25rem 0rem; border: 0px solid black;">
		<div class=" row" style="display: flex; justify-content: center;">
			<div class="col-md-10">
				<div class="receipt" style="background-color: white; padding: 1rem; border-radius: 3px;">
					<h6 class="name" style="margin:.5rem 0rem">Shipping Address</h6>
					<span style="font-size: 12px; color: rgba(0,0,0)!important;"><?= $userAddress; ?></span><br>

					<span style="font-size: 12px; color: rgba(0,0,0,.5)!important;">your order has been confirmed and will be shipped in two days</span>
					<hr>
					<div class="order-details" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
						<div><span style="display: block; font-size:12px; ">Order date</span><span><b style="font-family: var(--primaryText);" ><?= $orderDate; ?></b></span></div>
						<div><span style="display: block; font-size:12px; ">Order number</span><span><b style="font-family: var(--primaryText);" ><?= $orderNumber; ?></b></span></div>
						<div><span style="display: block; font-size:12px; ">Payment method</span><span><b style="font-family: var(--primaryText);" ><?= $paymentMode; ?></b></span></div>
					</div>
					<hr>
					<?php echo $service_det; ?>

					<div class="amount row" style="margin-top:1rem">
						<div class="col-sm-6" style="display: flex; justify-content: center;">
							<svg id="barcode" style="font-family: var(--primaryText);" ></svg>
							<?php
							?>
							<input type="hidden" name="orderIdNumber" id="orderIdNumber" value="<?= $orderNumber; ?>">
						</div>
						<div class="col-sm-6">
							<?= $total_div; ?>

						</div>
					</div>
					<span style="display: block; margin-top: 1rem; font-size: 15px; color: rgba(0,0,0,.5)!important;">We will be sending a service confirmation email when the service is completed!</span>
					<hr>
					<div class="footer" style="display: flex; justify-content: space-between; align-items: baseline;">
						<div class="thanks"><span style="display: block;"><b>Thanks for Book <br></b></span><span>Sukaii team</span></div>
						<div class="d-flex flex-column justify-content-end align-items-end" style="display: flex; justify-content: space-between; align-items: center;"><span style="display: block;"><b>Need Help?</b><br>Call - 974493933</span></div>
					</div>

				</div>
			</div>
		</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
	<script>
		var val = $("#orderIdNumber").val();
		JsBarcode("#barcode", val, {
			format: "CODE128B",
			ean128: true
		});
	</script>

</body>

</html>