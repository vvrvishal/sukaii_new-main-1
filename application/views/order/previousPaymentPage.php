<?php $this->load->view("./layout/header"); ?>
<div class="row mt-3">
	<div class="col-12">
		<h6 class="font-weight-bold">Previous payment methods</h6>
		<div class="row mb-3">
			<?=$card ? $card:'';?>



		</div>
		<div class="container">
			<div class="row mb-5">
				<div class="col-6 rounded">
					<a href="<?= base_url('addCardForm')?>"> <button type="button" class="pull-left btn  btn-sm" id="AddCardButton" style="margin-top: 4rem; background-color: var(--themePink); color: white; border-radius: 6px;" name="AddCardButton">Add Card</button></a>
				</div>
			</div>
			<div class="row mb-5">
				<div class="col-6 px-1 rounded">
					<label><input type="radio" id="paymentMode" name="paymentMode" value="COD" checked> COD</label>
				</div>
			</div>
			<h6 class="mb-0 font-weight-bold">Debit or Credit Card</h6>

			<div class="row pt-3 profile">
				<a href="<?= base_url(); ?>" class="text-dark w-100" style="text-decoration: none;">
					<div class="align-items-baseline col-12 d-flex justify-content-between pb-2 px-0" style="border-bottom: 2px solid #cfcece;">
                            <span>                            <img src="<?= base_url(); ?>assets/mimages/visa_CARD.png" alt="" style=" width: 58px;" class="rounded">
                                <span class="pl-4">....1234</span></span>
						<span><i class="fa-solid fa-caret-right pr-1" style="color: var(--themeGreen);"></i></span>
					</div>
				</a>
				<a href="#" class="text-dark w-100" style="text-decoration: none;">
					<div class="align-items-baseline col-12 d-flex justify-content-between pb-2 pt-3 px-0" style="border-bottom: 2px solid #cfcece;">
                            <span>                            <img src="<?= base_url(); ?>assets/mimages/master-card.png" alt="" class="rounded" style="width: 58px;">
                                <span class="pl-4">....5678</span></span>
						<span><i class="fa-solid fa-caret-right pr-1" style="color: var(--themeGreen);"></i></span>
					</div>
				</a>
				<a href="#" class="text-dark w-100" style="text-decoration: none;">
					<div class="align-items-baseline col-12 d-flex justify-content-between pb-2 pt-3 px-0" style="border-bottom: 2px solid #cfcece;">
                            <span>                            <img src="<?= base_url(); ?>assets/mimages/pay_pal.png" alt="" style="width: 58px;" class="rounded">
                                <span class="pl-4">....9012</span></span>
						<span><i class="fa-solid fa-caret-right pr-1" style="color: var(--themeGreen);"></i></span>
					</div>
				</a>
				<a href="#" class="text-dark w-100" style="text-decoration: none;">
					<div class="align-items-baseline col-12 d-flex justify-content-between pb-2 pt-3 px-0" style="border-bottom: 2px solid #cfcece;">
                            <span>                            <img src="<?= base_url(); ?>assets/mimages/true_moeny.png" alt="" style="width: 58px;" class="rounded">
                                <span class="pl-4">....3456</span></span>
						<span><i class="fa-solid fa-caret-right pr-1" style="color: var(--themeGreen);"></i></span>
					</div>
				</a>

			</div>
		</div>
	</div>
</div>
<?php $this->load->view("./layout/footer"); ?>
