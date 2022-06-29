<?php $this->load->view("./layout/header");?>
<style>
	
    .myaccount{
		box-shadow: 0px 0px 9px 0px lightgray;
	}
	
	@media only screen and (max-width: 600px) {
		.myaccount{
		box-shadow: none;
	}
	}

</style>
<div class="container">
	<div class="row pt-3 profile">
		<div class="col-12 col-md-10 m-md-auto rounded px-0 px-md-5 py-md-3 myaccount">
		<a href="<?=base_url('')?>" class="text-dark w-100" style="text-decoration: none;">
			<div class="align-items-baseline col-12 d-flex justify-content-between pb-2 pt-3 px-0" style="border-bottom: 2px solid #cfcece;">
				<p class="mb-0">My Profile</p>
				<span><i class="fa-solid fa-caret-right pr-1" style="color: var(--themeGreen);"></i></span>
			</div>
		</a>
		<a href="<?=base_url('orderSummary')?>" class="text-dark w-100" style="text-decoration: none;">
			<div class="align-items-baseline col-12 d-flex justify-content-between pb-2 pt-3 px-0" style="border-bottom: 2px solid #cfcece;">
				<p class="mb-0">My Cart</p>
				<span><i class="fa-solid fa-caret-right pr-1" style="color: var(--themeGreen);"></i></span>
			</div>
		</a>
		<a href="<?=base_url('my_booking')?>" class="text-dark w-100" style="text-decoration: none;">
			<div class="align-items-baseline col-12 d-flex justify-content-between pb-2 pt-3 px-0" style="border-bottom: 2px solid #cfcece;">
				<p class="mb-0">My Bookings</p>
				<span><i class="fa-solid fa-caret-right pr-1" style="color: var(--themeGreen);"></i></span>
			</div>
		</a>
		<a href="<?=base_url('user_manage_address')?>" class="text-dark w-100" style="text-decoration: none;">
			<div class="align-items-baseline col-12 d-flex justify-content-between pb-2 pt-3 px-0" style="border-bottom: 2px solid #cfcece;">
				<p class="mb-0">Manage Addresses
				</p>
				<span><i class="fa-solid fa-caret-right pr-1" style="color: var(--themeGreen);"></i></span>
			</div>
		</a>
		<a href="#" class="text-dark w-100" style="text-decoration: none;">
			<div class="align-items-baseline col-12 d-flex justify-content-between pb-2 pt-3 px-0" style="border-bottom: 2px solid #cfcece;">
				<p class="mb-0">Settings</p>
				<span><i class="fa-solid fa-caret-right pr-1" style="color: var(--themeGreen);"></i></span>
			</div>
		</a>
		<a href="<?=base_url('sukaii_help_center')?>" class="text-dark w-100" style="text-decoration: none;">
			<div class="align-items-baseline col-12 d-flex justify-content-between pb-2 pt-3 px-0" style="border-bottom: 2px solid #cfcece;">
				<p class="mb-0">Help Center</p>
				<span><i class="fa-solid fa-caret-right pr-1" style="color: var(--themeGreen);"></i></span>
			</div>
		</a>
		</div>
		
	</div>
</div>
<div class="book_service text-center">
	<a href="<?=base_url('logout')?>"><button type="button" class="px-3 btn btn-light btn-sm" style="margin-top: 7rem; background-color: var(--themePink); color: white; border-radius: 6px;"><b>LOGOUT</b></button></a>
</div>
<div class="modal fade" id="pwusuccess" tabindex="-1" role="dialog" aria-labelledby="pwusuccess" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="m-auto modal-content w-75" style="background-color: var(--themeGreen);">
			<div class="modal-body">
				<h5 class="font-weight-bold text-center sukaii_pink_color" style="font-family: var(--primaryText);">Thank You for grtting in touch</h5>
				<p class="text-center text-light" style="font-family: var(--secondryText);">We will be back o you shortly.</p>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view("./layout/footer");?>
