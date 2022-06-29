<?php $this->load->view("./layout/header"); ?>
<div class="header_desktop_carousel  row mb-3">
	<div class="col-md-12 px-0">
		<div id="mobile_carousel" class="carousel slide" data-ride="carousel">

			<div class="carousel-inner">
				<div class="carousel-item active">
					<img class="d-block w-100 carousel_image" src="<?= base_url('assets/mimages/banner-1.jpg') ?>" alt="First slide">
				</div>
				<div class="carousel-item">
					<img class="d-block w-100 carousel_image" src="<?= base_url('assets/mimages/banner-2.jpg') ?>" alt="Second slide">
				</div>
				<div class="carousel-item">
					<img class="d-block w-100 carousel_image" src="<?= base_url('assets/mimages/banner-3.jpg') ?>" alt="Third slide">
				</div>
			</div>
			<a class="carousel-control-prev" href="#mobile_carousel" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#mobile_carousel" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	</div>

</div>
<div class="container-fluid d-md-flex d-sm-block mb-3">
	<div class="col-md-5 col-sm-12 m-auto thb300_fpr_laptop">
		<div class="mb-4 mb-lg-3 row w-100 m-auto thb300">
			<img src="<?= base_url('assets/mimages/{A416F097-35CC-4863-BEA1-AADFA17B3F09}.png.jpg') ?>" class="w-100 px-0" alt="">
		</div>

	</div>
</div>
<div id="bookIn3Step"></div>

<div class="modal fade" id="pwusuccess" tabindex="-1" role="dialog" aria-labelledby="pwusuccess" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="m-auto modal-content w-75" style="background-color: var(--themeGreen);">
			<div class="modal-body">
				<h5 class="font-weight-bold text-center sukaii_pink_color" style="font-family: var(--primaryText);">
					Thank You for grtting in touch</h5>
				<p class="text-center text-light" style="font-family: var(--secondryText);">We will be back to you
					shortly.</p>
			</div>
		</div>
	</div>
</div>
<!-- @include('components.mob_footer') -->
<div class="row" id="WeMadeItsImple">
	<div class="bn3step_img_parent col-12 px-0">
		<img src="<?= base_url('assets/sukaii_icons/Book-Now-Banner.png') ?>" class="w-100 bn3step_img" alt="">
	</div>
</div>

<!-- servises for mobile  -->
<div class="container-fluid px-1 mt-5 d-md-none" id="mobileServices">
	<div class=" row">
		<div class="border-dark border-right col-6 px-2 text-center">
			<img src="<?= base_url('assets/sukaii_icons/Covid.png') ?>" style="width: 75%;" class=" mb-3 services_images" alt="">
			<h6 class="font-weight-bold small text-center">COVID RT-PCR TEST</h6>
		</div>
		<div class="border-dark border-left col-6 px-2 text-center">
			<img src="<?= base_url('assets/sukaii_icons/BASIC-HEALTH-CHECK-UP.png') ?>" style="width: 75%;" class="mb-3 services_images" alt="">
			<h6 class="font-weight-bold small text-center">BASIC HEALTH CHECK</h6>
		</div>
	</div>
	<div class="row border-bottom border-dark">
		<div class="col-6 pt-2 text-center border-right border-dark">
			<a href="<?= base_url('covid_pcr') ?>">
				<button type="button" class="btn btn-sm font-weight-bold px-3 sukaii_pink_bgcolor text-center text-light mb-3">BOOK</button>
			</a>
		</div>
		<div class="col-6 pt-2 text-center border-left border-dark">
			<a href="<?= base_url('basic_health_test') ?>">
				<button type="button" class="btn btn-sm font-weight-bold px-3 sukaii_pink_bgcolor text-center text-light mb-3">BOOK</button>
			</a>
		</div>
	</div>
	<div class=" border-top border-dark row">
		<div class="border-dark border-right col-6 px-2 text-center pt-3">
			<img src="<?= base_url('assets/sukaii_icons/COMPLETE-HEALTH-CHECK-UP.png') ?>" style="width: 75%;" class="mb-3 services_images" alt="">
			<h6 class="font-weight-bold small text-center">COMPLETE HEALTH CHECK</h6>
		</div>
		<div class="border-dark border-left col-6 px-2 text-center pt-3">
			<img src="<?= base_url('assets/sukaii_icons/LEN-LEN-TEST.png') ?>" style="width: 75%;" class=" mb-3 services_images" alt="">
			<h6 class="font-weight-bold small text-center">LEN-LEN TEST</h6>
		</div>
	</div>
	<div class="row">
		<div class="col-6 pt-2 text-center border-right border-dark">
			<a href="<?= base_url('complete_health_test') ?>">
				<button type="button" class="btn btn-sm font-weight-bold px-3 sukaii_pink_bgcolor text-center text-light mb-3">BOOK</button>
			</a>
		</div>
		<div class="col-6 pt-2 text-center border-left border-dark">
			<a href="<?= base_url('len_len_test') ?>">
				<button type="button" class="btn btn-sm font-weight-bold px-3 sukaii_pink_bgcolor text-center text-light mb-3">BOOK</button>
			</a>
		</div>
	</div>
</div>
<!-- servises for desktop  -->

<div class="container-fluid px-1 mb-5 mt-5 d-none d-md-block" id="desktopServices">
	<div class=" row">
		<div class="border-dark border-right col-md-3 col-6 px-2 text-center">
			<img src="<?= base_url('assets/sukaii_icons/Covid.png') ?>" style="width: 75%;" class=" mb-3 services_images" alt="">
			<h6 class="font-weight-bold small text-center">COVID RT-PCR TEST</h6>
		</div>
		<div class="border-dark border-right col-md-3 col-6 px-2 text-center">
			<img src="<?= base_url('assets/sukaii_icons/BASIC-HEALTH-CHECK-UP.png') ?>" style="width: 75%;" class="mb-3 services_images" alt="">
			<h6 class="font-weight-bold small text-center">BASIC HEALTH CHECK</h6>
		</div>
		<div class="border-dark border-right col-md-3 col-6 px-2 text-center ">
			<img src="<?= base_url('assets/sukaii_icons/COMPLETE-HEALTH-CHECK-UP.png') ?>" style="width: 75%;" class="mb-3 services_images" alt="">
			<h6 class="font-weight-bold small text-center">COMPLETE HEALTH CHECK</h6>
		</div>
		<div class=" col-md-3 col-6 px-2 text-center">
			<img src="<?= base_url('assets/sukaii_icons/LEN-LEN-TEST.png') ?>" style="width: 75%;" class=" mb-3 services_images" alt="">
			<h6 class="font-weight-bold small text-center">LEN-LEN TEST</h6>
		</div>
	</div>
	<div class="row ">
		<div class="col-6 col-md-3 pt-2 text-center border-right border-dark">
			<a href="<?= base_url('covid_pcr') ?>">
				<button type="button" class="btn btn-sm font-weight-bold px-3 sukaii_pink_bgcolor text-center text-light mb-3">BOOK</button>
			</a>
		</div>
		<div class="col-6 col-md-3 pt-2 text-center border-right border-dark">
			<a href="<?= base_url('basic_health_test') ?>">
				<button type="button" class="btn btn-sm font-weight-bold px-3 sukaii_pink_bgcolor text-center text-light mb-3">BOOK</button>
			</a>
		</div>
		<div class="col-6 col-md-3 pt-2 text-center border-right border-dark">
			<a href="<?= base_url('complete_health_test') ?>">
				<button type="button" class="btn btn-sm font-weight-bold px-3 sukaii_pink_bgcolor text-center text-light mb-3">BOOK</button>
			</a>
		</div>
		<div class="col-6 col-md-3 pt-2 text-center ">
			<a href="<?= base_url('len_len_test') ?>">
				<button type="button" class="btn btn-sm font-weight-bold px-3 sukaii_pink_bgcolor text-center text-light mb-3">BOOK</button>
			</a>
		</div>
	</div>
</div>
<?php $this->load->view("./layout/footer"); ?>