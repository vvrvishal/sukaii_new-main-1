<?php


$this->load->view('layout/header'); ?>
<style>
	.container{
		width: 60%;
	}
	@media only screen and (max-width: 700px)  {
		.container{
		width: unset !important;
	}
	}
</style>
<div class="container" >
	<div class="row pt-3 profile">
		<div class=" col-12 pb-2 pt-3 px-0" style="border-bottom: 2px solid gray;">
			<?php
			$alreadyInCartService = array();
			if (!empty($this->session->cart_session) > 0) {
				$orderServices = $this->session->cart_session;
				$tempOrderService = array();
				foreach ($orderServices as $row) {
					$tempOrderService[$row->service_id][] = $row;
				}
				foreach ($tempOrderService as $orderSummaryRow1) {
					$count = count($orderSummaryRow1);
					if ($count == 0) {
						continue;
					}
					$orderSummaryRow = $orderSummaryRow1[0];
					array_push($alreadyInCartService,$orderSummaryRow->service_name);

					?>
					<div class="row">
						<div class="d-flex align-items-center justify-content-between w-100 mb-2">
							<div class="">
								<h6 class="mb-0 font-weight-bold" style="font-family: var(--primaryText);"><span style="font-family: var(--primaryText);" class="sukaii_pink_color sub_sub_heading"><?= $orderSummaryRow->service_name; ?></span><br>
									@ <?= $orderSummaryRow->location; ?></h6>
								<small class="font-weight-bold"
									   style="font-family: var(--primaryText);">THB <?= $orderSummaryRow->service_sale_price; ?></small>
							</div>
							<div class="no_of_packages border d-flex border-dark rounded px-3"
								 style="background-color: var(--iconbgColor);">
								<span class=""
									  onclick='removeItemIntoCart(<?= $orderSummaryRow->service_id; ?>)'><b> - </b></span><span
										class="px-2"><b> <small><?= $count; ?></small> </b></span><span
										onclick='addItemIntoCart(<?= $orderSummaryRow->service_id; ?>,"<?= $orderSummaryRow->service_name; ?>","-",<?= $orderSummaryRow->service_price; ?>,<?= $orderSummaryRow->service_discount; ?>,<?= $orderSummaryRow->service_sale_price; ?>)'><b> + </b></span>
							</div>
						</div>
					</div>

				<?php }
			}
			$services = $serviceData->data;
			$isExistServiceCount = count($alreadyInCartService);

			?>

		</div>
<?php if (count($services) != $isExistServiceCount){?>
		<div class=" col-12 pb-2 pt-3 px-0">
			<h6 class="text-dark font-weight-bold sub_sub_heading">Additional Services :</h6>
			<?php

			foreach ($services as $serviceRow) {
				if($isExistServiceCount>0){
					$isExist = array_filter($alreadyInCartService,function ($item) use($serviceRow){
						return $item === $serviceRow->service_name;
					});

					if(count($isExist)>0){
						continue;
					}
				}
				?>
				<div class="mainServiceDiv align-items-center d-flex justify-content-between pb-1"
					 style="    border-bottom: 2px dashed gray;">
					<div class="serviceDiv sub_sub_heading">
						<p class="small mb-0"><b> Basic <span
										class="sukaii_pink_color "><?= $serviceRow->service_name; ?></b></span>
						</p>
						<p class="small mb-2"><b>@Home</b></p>
						<div class="d-flex align-items-center">
							<p class="mb-0" style="color: var(--themeGreen);font-size: 13px; font-weight: 600;">
								THB <?= $serviceRow->service_rate; ?></p>
							<!--										<p class="ml-5 mb-0" style="font-size: 13px;"> 30 min</p>-->
						</div>
					</div>
					<div class="book_service text-center">
						<button type="button" class="px-3 btn btn-light btn-sm addServiceIntoCart"
								style=" background-color: var(--iconbgColor); color: var(--themePink); border-radius: 6px;"
								attr-sId="<?= $serviceRow->id; ?>" attr-service_name="<?= $serviceRow->service_name; ?>"
								attr-service_id="<?= $serviceRow->service_id; ?>"
								attr-service_rate="<?= $serviceRow->service_rate; ?>"
								attr-discount="<?= $serviceRow->discount; ?>"
								attr-sale_price="<?= $serviceRow->sale_price; ?>"
								onclick='addItemIntoCart(<?= $serviceRow->id; ?>,"<?= $serviceRow->service_name; ?>","<?= $serviceRow->service_id; ?>",<?= $serviceRow->service_rate; ?>,<?= $serviceRow->discount; ?>,<?= $serviceRow->sale_price; ?>)'>
							<b>Add</b></button>
					</div>
				</div>
				<?php
				// echo $serviceRow->id;
				if ($serviceRow->id == 1481) { ?>
					<a href="<?php echo base_url('covid_pcr'); ?>" class="mb-0 sukaii_pink_color "><small>View
							Details</small></a>
				<?php } elseif ($serviceRow->id == 1482) { ?>
					<a href="<?php echo base_url('basic_health_test'); ?>" class="mb-0 sukaii_pink_color "><small>View
							Details</small></a>
				<?php } elseif ($serviceRow->id == 1483) { ?>
					<a href="<?php echo base_url('complete_health_test'); ?>" class="mb-0 sukaii_pink_color "><small>View
							Details</small></a>
				<?php } elseif ($serviceRow->id == 1484) { ?>
					<a href="<?php echo base_url('len_len_test'); ?>" class="mb-0 sukaii_pink_color "><small>View
							Details</small></a>
				<?php }
			}
			?>
		</div>
		<?php }?>
		<div class=" col-12 pb-2 pt-3 px-0">
			<div class="align-items-center justify-content-center row">
				<a href="<?= base_url("orderSummary") ?>"
				   class="btn btn-sm font-weight-bold px-3 sukaii_pink_bgcolor text-center text-light">
					PROCEED
				</a>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('layout/footer'); ?>
<script>
	function addItemIntoCart(hdnSId, hdnServiceName, hdnServiceId, hdnServiceRate, hdnServiceDiscount, hdnServiceSalePrice) {
		let formData = new FormData();
		formData.set("SId", hdnSId)
		formData.set("ServiceName", hdnServiceName)
		formData.set("ServiceId", hdnServiceId)
		formData.set("ServiceRate", hdnServiceRate)
		formData.set("ServiceDiscount", hdnServiceDiscount)
		formData.set("ServiceSalePrice", hdnServiceSalePrice)
		app.request("updateCart", formData).then(response => {
			if (response.status === 200) {
				window.location.href = baseURL + 'viewCart';
			} else {
				app.errorToast(response.status);
			}
		}).catch(error => {
			console.log(error);
		})
	}

	function removeItemIntoCart(hdnSId) {
		let formData = new FormData();
		formData.set("serviceID", hdnSId)
		app.request("removeCartItem", formData).then(response => {
			if (response.status === 200) {
				window.location.href = baseURL + 'viewCart';
			} else {
				app.errorToast(response.status);
			}
		}).catch(error => {
			console.log(error);
		})
	}
</script>
