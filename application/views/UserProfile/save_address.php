<?php $this->load->view("./layout/header"); ?>
<style>
	#map #infowindow-content {
		display: inline;
	}

	.pac-controls {
		display: inline-block;
		padding: 5px 11px;
	}

	.pac-controls label {
		font-size: 13px;
		font-weight: 300;
	}

	#pac-input {
		border-top-right-radius: 0px;
		border-bottom-right-radius: 0px;
	}

	#pac-input:focus {
		border-color: none !important;
	}

	#title {
		font-size: 22px;
		font-weight: 500;
		padding: 17px 19px 7px;
	}

	::placeholder {
		font-size: 12px;
	}

	#curr {
		border-bottom-left-radius: 0px;
		border-top-left-radius: 0px;
	}
	input[placeholder="Eg. John’s home, Mom’s place etc"]{
		font-size: 14px;
	}
	#map{
		height: 400px;
	}
	@media only screen and (max-width: 600px) {
		#map{
		height: 200px;
	}
	}
</style>
<div id="map">
</div>
<input type="hidden" id="backToPage" value="<?= isset($backToOrder) ? $backToOrder : '' ?>"/>
<div class="bg-light border-0 mt-2 mx-auto overflow-hidden pac-card rounded " id="pac-card" style="box-shadow: darkgrey -1px 1px 3px;; width: 90%;">
	<div id="pac-container" class="d-flex ">
		<input id="pac-input" type="text" class="form-control border-right-0" placeholder="Enter a location" />
		<button type="button" id="curr" onclick="getLocation()" class="bg-white border btn btn-link"><i class="fa-solid fa-location-crosshairs"></i></button>
	</div>
</div>

<div class="container">
	<div class="row profile">
		<div class="col-12 d-flex justify-content-between pb-2 pt-4 px-0" style="border-bottom: 2px solid gray;">
			<!-- <input type="checkbox" name="" class="pr-2" id=""> -->
			<div class="pl-2 normal_text">
				<h6 class="mb-0" style="font-weight: 600;">Home</h6>
				<p class="mb-0" id="map_address_line"></p>
			</div>
			<div class="changes_address pt-2">
				<button type="button" onclick="changeAddress()" style="text-decoration: none;" class="border-dark btn btn-light btn-link btn-sm text-dark">Change</button>
			</div>
		</div>


	</div>
</div>
<form id="save_customer_address" class="py-3" method="post">
<div class="container">
		<input type="text" id="line_1" name="line_1" class="form-control mb-2" placeholder="Line 1">
		<input type="text" id="line_2" name="line_2" class="form-control mb-2" placeholder="Line 2">
		<input type="text" id="line_3" name="line_3" class="form-control mb-2" placeholder="Line 3">
		<input type="text" id="line_4" name="line_4" class="form-control mb-2" placeholder="Line 4">
		<input type="hidden" name="location_long" id="location_long">
		<input type="hidden" name="location_lat" id="location_lat">
		<input type="hidden" name="user_id" id="user_id" value="<?=$this->session->user_session->id?>">
</div>
<div class="container">
	<small><b>Save As</b></small>
	<div class="btns mt-2">
		<button type="button" style="text-decoration: none;" id="save_as_home" class="px-3 border-dark btn btn-light btn-link btn-sm text-dark"><small>Home</small></button>
		<input type="hidden" name="address_name_h" class="form-control mt-2" id="address_name_h" value="Home" data-error="#address-name-error">
		<button type="button" id="save_as_other" style="text-decoration: none; background-color: lightgray;" class="px-3 ml-2  btn btn-light btn-sm text-dark"><small>Other</small></button>
		<input type="text" name="address_name" id="address_name" class="form-control mt-2" style="display: none;" onchange="setAddressName(this)" placeholder="Eg. John’s home, Mom’s place etc">
	</div>
	<div id="address-name-error"></div>
</div>
<div id="infowindow-content" style="display: none;">
	<span id="place-name" class="title font-weight-bold"></span><br />
	<span id="place-address"></span>
</div>
<div class="save_address text-center">
	<button type="submit" class="px-3 btn btn-light btn-sm" style="margin-top: 4rem; background-color: var(--themePink); color: white; border-radius: 6px;"><b>Save address</b></button>
</div>
</form>

<?php $this->load->view("./layout/footer"); ?>
