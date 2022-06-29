<?php $this->load->view('layout/header'); ?>

<?php ini_set('memory_limit', '-1'); ?>



<?php
$service_total = 0;
$discount_total = 0;
$grand_total = 0;
$orderAddressDetails = '';
$personArray = array();
if (!empty($this->session->cart_session) > 0) {
?>

	<div class="container pt-3 pb-2" style="border-bottom: 2px solid gray;">
		<div class="row">
			<div class="align-items-center col-12 d-flex justify-content-between small sub_heading"
				 style="font-family: var(--primaryText);">
				<div class="test_name d-flex">
                    <span>
                       	 <a href="<?= base_url('/') ?>" class="text-dark">
                            <i class="fa-solid fa-left-long pr-3"></i>
                        </a>
                    </span>

					<h6 class="mb-0 font-weight-bold sub_heading">Summary</h6>
				</div>
			</div>
		</div>
	</div>
<div class="container" style="border-bottom: 2px solid gray;">
<div class="row pt-3" style="font-size:smaller; ">
<div class="col-12 ">
<h6 class="font-weight-bold">Service</h6>
<?php

	foreach ($this->session->cart_session as $orderSummaryRow) {

		$service_total += (int)$orderSummaryRow->service_sale_price;
		$discount_total += (int)$orderSummaryRow->service_discount;
		?>
		<div class="s_total d-flex align-items-center justify-content-between">
			<p class="mb-0 normal_text">
				<button class="btn btn-link btn-sm"
						onclick="removeItemIntoCart(<?= $orderSummaryRow->service_id ?>)"><i
							class="fa fa-times small"></i></button>
				<?php echo $orderSummaryRow->service_name; ?>

			</p>
			<p class="mb-0 normal_text">THB <?php echo $orderSummaryRow->service_sale_price; ?></p>
		</div>
		<?php
		if ($orderSummaryRow->schedule_date) {
			$personArray[$orderSummaryRow->patient_name . '-' . $orderSummaryRow->schedule_date . '-' . $orderSummaryRow->schedule_time][] = array($orderSummaryRow->patient_name, $orderSummaryRow->schedule_date, $orderSummaryRow->schedule_time);
		}

	}

	$grand_total = $service_total - $discount_total;

?>
<h6 class="font-weight-bold">Payment summary</h6>
<div class="s_total d-flex align-items-center justify-content-between">
	<p class="mb-2 normal_text" >Service Total</p>
	<p class=" mb-2 normal_text">THB <?= $service_total; ?></p>
</div>
<div class="s_total d-flex align-items-center justify-content-between">
	<p class="mb-2 normal_text">Discount</p>
	<p class="sukaii_pink_color mb-2 normal_text">- THB <?= $discount_total; ?></p>
</div>
<div class="s_total d-flex align-items-center justify-content-between">
	<p class="mb-0 normal_text">Convenience & Safety Fee</p>
	<p class="mb-0 normal_text	">THB 0.00</p>
</div>

		</div>
	</div>
</div>

<div class="container" style="border-bottom: 2px solid gray;">
	<div class="row pt-1" style="font-size:smaller; ">
		<div class="col-12 ">
			<!-- <h6 class="font-weight-bold">TOTAL</h6> -->
			<div class="s_total d-flex align-items-center justify-content-between">
				<h6 class="font-weight-bold sukaii_pink_color sub_sub_heading"  style="font-family: var(--primaryText);">Service Total</h6>
				<h6 class="font-weight-bold sukaii_pink_color sub_sub_heading"  style="font-family: var(--primaryText);">THB <?= $grand_total; ?></h6>
			</div>
		</div>
	</div>
</div>

<div class="container mt-3">
	<p class="border mb-0 p-2 normal_text rounded small py-2 text-center sukaii_pink_color"
	   style="background-color: var(--iconbgColor);">Yay ! You have saved THB <?= $discount_total ?> on final Bill</p>
</div>

<div class="container">
	<div class="row pt-3 profile">
		<?php
		foreach ($personArray as $person) {
			if(count($person)==0){
				continue;
			}
			$pAddress=$person[0];
			$orderAddressDetails .= '<a href="#" class="text-dark w-100" style="text-decoration: none;">
                <div class="align-items-baseline col-12 d-flex justify-content-between pb-2 pt-3 px-0" style="border-bottom: 2px solid gray;">
                    <div class="d-flex ">
                        <span><i class="fa-solid fa-user normal_text" style="color: var(--themePink);"></i></span>
                        <p class="text-capitalize mb-0 pl-3 small normal_text">
                            <b class="">' . $pAddress[0] . '</b> for ' . $pAddress[1] . ' ' . $pAddress[2] . '</p>
                    </div>
                    <span><i class="fa-solid fa-caret-right pr-1" style="color: var(--themeGreen);"></i></span>
                </div>
            </a>';
		}
		echo $orderAddressDetails;
		?>
		<?php
		$address_id = 0;
		if (isset($userAddress)) {
			if ($userAddress->totalCount == 0) {
				?>
				<a href="<?= base_url("user_manage_address/1") ?>" class="text-dark w-100"
				   style="text-decoration: none;">
					<div class="align-items-baseline col-12 d-flex justify-content-between pb-2 pt-3 px-0"
						 style="border-bottom: 2px solid gray;">
						<div class="d-flex ">
							<span><i class="fa-solid fa-location-dot" style="color: var(--themePink);"></i></span>
							<p class="text-capitalize mb-0 pl-3 small sukaii_pink_color"> Add Address</p>
						</div>
						<span><i class="fa-solid fa-caret-right pr-1" style="color: var(--themeGreen);"></i></span>
					</div>
				</a>
				<?php
			} else {
				$address = $userAddress->data;
				$address_id = $address->id;
				?>
				<a href="<?= base_url("user_manage_address/one") ?>" class="text-dark w-100"
				   style="text-decoration: none;">
					<div class="align-items-baseline col-12 d-flex justify-content-between pb-2 pt-3 px-0"
						 style="border-bottom: 2px solid gray;">
						<div class="d-flex ">
							<span><i class="fa-solid fa-location-dot" style="color: var(--themePink);"></i></span>
							<p class="text-capitalize mb-0 pl-3 small normal_text">
								<b><?= $address->address_name ?></b> <?= $address->line_1 . " " . $address->line_2 ?>
							</p>
						</div>
						<span><i class="fa-solid fa-caret-right pr-1" style="color: var(--themeGreen);"></i></span>
					</div>
				</a>
				<?php
			}
		}
		?>

		<a href="#" class="text-dark w-100" style="text-decoration: none;">
			<div class="align-items-baseline col-12 d-flex justify-content-between pb-2 pt-3 px-0"
				 style="border-bottom: 2px solid gray;">
				<div class="align-items-center d-flex">
					<!--                        <p class="border font-weight-bold mb-0 p-2 rounded small" style="color: #0150a3;">VISA</p>-->
					<!--                        <small class="pl-3">.....8765</small>-->
					<label><input type="radio" checked name="paymentMode" id="paymentMode" value="COD"
								  checked="checked"> COD</label> &nbsp; &nbsp;
					<label><input type="radio"  name="paymentMode" id="paymentMode" value="Card"> Credit
						Card</label>
				</div>
				<div class="book_service text-center">
					                       <a href="<?php echo base_url('insertOrder'); ?><!--">
					<button id="btnPayment" type="button" class="px-3 btn btn-light small btn-sm"
							style="background-color: var(--themePink); color: white; border-radius: 6px;"><b style="font-family: var(--primaryText); ">Pay
							THB <?= $grand_total; ?></b></button>
					<!--						</a>-->
				</div>
			</div>
		</a>
	</div>
</div>
<input type="hidden" id="card_holde_name" name="card_holde_name" value="0">
<input type="hidden" id="card_expiry" name="card_expiry" value="0">
<input type="hidden" id="card_number" name="card_number" value="0">
<input type="hidden" id="card_type" name="card_type" value="0">
<input type="hidden" id="selectedAddress" name="selectedAddress" value="<?= $address_id ?>">

<div class="container mt-3">
	<p class="border mb-0 p-2 rounded small py-2 text-center sukaii_pink_color normal_text"
	   style="background-color: var(--iconbgColor)">
		By proceeding, you agree to our T & C, Privacy & Cancellation policy</p>
</div>
<?php }else{?>
	<div class="container mt-3">
		<p class="border mb-0 p-2 rounded small py-2 text-center sukaii_pink_color normal_text"
		   style="background-color: var(--iconbgColor)">
			Empty Cart</p>
	</div>
<?php } ?>
<script>
	$(document).ready(function () {
		$("#btnPayment").click(function () {
			let paymentMode = $('input[name="paymentMode"]:checked').val();
			// $("input[name=paymentMode]").val();
			let addID = $("#selectedAddress").val();
			let card_holde_name = $("#card_holde_name").val();
			let card_expiry = $("#card_expiry").val();
			let card_number = $("#card_number").val();
			let card_type = $("#card_type").val();
			if (addID == 0) {
				app.errorToast("Address not selected");
			} else {
				$.ajax({
					url: baseURL + 'insertOrder',
					type: "POST",
					data: {
						paymentMode: paymentMode, card_holde_name: card_holde_name, card_expiry:
						card_expiry, card_number: card_number, card_type: card_type,
						address_id: addID
					},
					dataType: "json",
					success: function (resp) {
						if (resp.status === 200) {
							app.successToast(resp.msg);
							if(resp.redirect!==""){
								window.location.href = baseURL + resp.redirect;
							}else{
								window.location.href = baseURL + 'viewPaymentReciept/' + resp.order_id;
							}

						} else {
							app.errorToast(resp.msg);
							window.location.href = baseURL;
						}
					}
				});
			}
		})
	})

	function removeItemIntoCart(hdnSId) {
		let formData = new FormData();
		formData.set("serviceID", hdnSId)
		app.request("removeCartItem", formData).then(response => {
			if (response.status === 200) {
				location.reload();
			} else {
				app.errorToast(response.status);
			}
		}).catch(error => {
			console.log(error);
		})
	}
</script>
<?php $this->load->view('layout/footer'); ?>
