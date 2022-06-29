<?php $this->load->view("./layout/header"); ?>

<div class="container" style="border-bottom: 2px solid gray;">
	<div class="row m-2">
		<div class="align-items-baseline col-md-12 d-flex justify-content-between px-0">
			<!-- <span style="padding: 6px 11px;" class="border-dark border rounded-circle"><i class="text-muted fa-solid fa-user"></i></span> -->
			<span class="sukaii_pink_color"><b>Saved Addresses</b></span>
			<!-- <span><i style="font-size: 20px; color: var(--themeGreen);" class="fa-solid fa-bars"></i></span> -->
			<input type="hidden" id="backToPage" value="<?= isset($backToOrder) ? $backToOrder : '' ?>"/>
		</div>
	</div>
</div>
<a href="<?= base_url('create_address') ?>" style="text-decoration:none;">
	<div class="container pt-3 pb-2" style="border-bottom: 2px solid gray;">
		<div class="row">
			<div class="align-items-center col-12 d-flex justify-content-between small" style="font-family: var(--primaryText);">
				<div class="test_name d-flex">
					<span><i class=" text-dark fa-solid fa-plus pr-1 sub_sub_heading "></i></span>
					<h6 class="font-weight-bold mb-0 sub_sub_heading text-dark">Add another address</h6>
				</div>
			</div>
		</div>
	</div>
</a>

<div class="container">
	<div class="row profile">
		<div class="col-md-12">
			<?php
			if (!isset($addressDetails)) {
				$addressDetails = array();
			}
			foreach ($addressDetails as $address) {
			?>
				<div class="text-dark" style="text-decoration: none;">
					<div class="align-items-baseline col-12 d-flex justify-content-between normal_text pb-2 pt-4 px-0" style="border-bottom: 2px solid gray;">
						<div class="align-items-center d-flex ">
							<input type="checkbox" name="selected_address" class="selected_address pr-2" id="selected_address" value="<?= $address->id ?>">
							<div class="pl-2">
								<h6 class="mb-0" style="font-weight: 600;"><?= $address->address_name ?></h6>
								<p><?= $address->line_1 ?> <?= $address->line_2 ?> <?= $address->line_3 ?> <?= $address->line_4 ?></p>
							</div>
						</div>
						<div class="dropdown ">
							<span role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical pr-1"></i></span>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
								<div class="dropdown-item" onclick="deleteAddress(<?= $address->id ?>)">Delete</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>

		</div>
	</div>
</div>

<div class="book_service text-center">
	<button onclick="process()" id="btn_process" class="px-3 btn btn-light btn-sm" style="margin-top: 3rem; background-color: var(--themePink); color: white; border-radius: 6px;"><b>PROCEED</b></button>
</div>

<?php $this->load->view("./layout/footer"); ?>
