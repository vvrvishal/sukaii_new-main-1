<?php $this->load->view("./layout/header"); ?>
<style>
.container{
		width: 60%;
	}
	@media only screen and (max-width: 700px)  {
		.container{
		width: unset;
	}
	}</style>

<div class="container pt-3 pb-4" style="border-bottom: 2px solid gray;">
				<?php
				if (!empty($this->session->getOrderDetails)) {
					$orderData = $this->session->getOrderDetails->data[0];
				}
				echo $servicesDataSummary;
				?>
	<div class="row">
		<div class=" col-12 d-flex justify-content-between">
			<div class="image_section ">
				<h6 class="sukaii_pink_color font-weight-bold mb-0">Thank you for choosing Sukaii</h6>
				<div class=""><small class="text-muted mb-2" style="font-size: 11px; "><?=  date('d-m-y h:i A',strtotime($orderDate)); ?></small></div>
				<a href="<?= base_url('viewPaymentRecieptDetails/' . $orderId); ?>"> <button type="button" class="btn px-3 mt-3 text-light sukaii_pink_bgcolor small btn-sm" style="padding: .15rem;"><small>View Receipt</small></button></a>
			</div>
			<div class="paid_stamp pl-3 w-25">
				<a href="<?= base_url('sukaii_help_center'); ?>">
					<button type="button" class="btn px-3 text-light sukaii_pink_bgcolor small btn-sm" style="padding: .15rem;">
						<small>Help</small>
					</button>
				</a>
			</div>
		</div>
	</div>
</div>
<div class="container py-3" style="border-bottom: 2px solid gray;">
	<div class="row">
		<h6 class="font-weight-bold mb-0" style="font-size: 16px;">You will be attended by</h6>
		<div class="align-items-center col-12 d-flex mt-2">
			<div class="image_section d-flex align-items-center">
				<?php echo $collectorDetails; ?>
			</div>
		</div>
	</div>

</div>


<?php $this->load->view("./layout/footer"); ?>
