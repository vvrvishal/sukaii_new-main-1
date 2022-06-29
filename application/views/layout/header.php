<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sukaii</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
		  integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
		  crossorigin="anonymous" referrerpolicy="no-referrer"
	/>
	<link rel="stylesheet" href="<?= base_url('assets/bootstrap/bootstrap.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/bootstrap/bootstrap.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/mcss/style.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/mcss/partenarWithUs.css') ?>">
	<link rel="stylesheet" href="">
	<!-- box icons link  -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
			integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
			crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
			integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
			crossorigin="anonymous"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
			integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
			crossorigin="anonymous" referrerpolicy="no-referrer"></script>


	<script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>
	<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
		  integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
		  crossorigin="anonymous" referrerpolicy="no-referrer"
	/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
		  integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw=="
		  crossorigin="anonymous" referrerpolicy="no-referrer"
	/>
	<link rel="stylesheet" href="<?= base_url('assets/izitoast/css/iziToast.css') ?>"/>
	<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

</head>

<style>
	.activeSelection {
		background-color: #ec098d66;
	}

	.carousel_1_image {
		color: black !important;
		z-index: 10;
		position: absolute;
		top: 36%;
		left: 4%;
		font-size: 1rem;
	}

	.carousel_1_image h1 {
		font-size: 25px;
	}

	html {
		scroll-behavior: smooth;
	}
</style>

<body>
<header id="">
	<div class="align-items-center border-bottom row">
		<div class="col col-md-3 col-sm-6">
			<a href="<?= base_url() ?>"> <img src="<?= base_url('assets/sukaii_icons/SUKAII-Logo.png') ?>" alt="Sukaii"
											  class="p-2 logo_mobile"></a>
		</div>
		<div class="col-6 col-md-9 col-sm-6 hide_menu">
			<div class="d-md-block d-none justify-content-end login_row row w-100">
				<ul class="d-flex float-right list-unstyled mb-2">
					<?php
					if (isset($this->session->user_session)) {
						$username = $this->session->user_session->name;
						?>
						<a href="<?= base_url('logout') ?>" style="text-decoration: none;">
							<li class="font-weight-bold login_row_list px-3">Logout</li>
						</a>
						<?php
					} else { ?>
						<a href="<?= base_url('login') ?>" style="text-decoration: none;">
							<li class="font-weight-bold login_row_list px-3">Login</li>
						</a>
					<?php }
					?>
					<li class="login_row_list px-3"><span class="p-2"><i style="color: #0cb4b7;" class="fas fa-map-marker-alt"></i></span>Bangkok</li>
				</ul>
			</div>
			<!-- desktop header -->
			<div class="d-md-block d-none float-right row w-100">
				<ul class="d-flex float-right mb-0">
					<li class="menu_list px-3"><a href="<?= base_url() ?>" class="text-dark font-weight-bold">HOME</a></li>
					<li class="menu_list  px-3"><a href="<?= base_url('') ?>#desktopServices" class="text-dark font-weight-bold">SERVICES</a></li>
					<li class="menu_list px-3"><a href="<?= base_url() ?>" class="text-dark font-weight-bold">FAQ's</a></li>
					<li class="menu_list px-3"><a href="<?= base_url('partner_with_us') ?>" class="text-dark font-weight-bold">PARTNERS</a></li>
					<li class="menu_list px-3"><a href="<?= base_url() ?>" class="text-dark font-weight-bold">CONTACT US</a></li>
					<li class="menu_list px-3"><a href="<?= base_url() ?>" class="text-dark font-weight-bold">FOLLOW US</a></li>
					<li class="menu_list px-3"><a href="<?= base_url('user_profile_menus') ?>" class="text-dark font-weight-bold">MY ACCOUNT</a></li>
					
					
				</ul>
			</div>
		
			<div class="align-items-center d-flex justify-content-end mobile_menu">
				<div class="text-secondary d-block d-md-none" style="line-height:1;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
					<small>Hello</small>
					<br>
					<?php
					if (isset($this->session->user_session)) {
						echo "<STRONG>". $this->session->user_session->name."</STRONG>";

					} else { ?>
						<span><b><a href="<?= base_url('login') ?>" class="text-dark" style="text-decoration: none;">Sign in</a></b></span>
					<?php } ?>
				</div>
				<ul class="d-block d-md-none m-0" style="padding: 1rem; ">
					<li id="MenuIconBtn" class="tab_icon_menu_list list-unstyled" style="font-size: 20px;"><span><i
									style="color: #00b3b7;" class="fas fa-bars "></i></span></li>
				</ul>
			</div>
		</div>
		<!-- mobile header  -->
		<div class="tab_mobile_nav " id="MobileMenuSection" style="display: none;">
			<ul class="list-unstyled border-0 pb-3 px-0 form-control">
				<a href="<?= base_url('') ?>" style="text-decoration: none;" class="text-dark">
					<li class="border-0 form-control mobile_menu_list">HOME</li>
				</a>
					<a href="<?= base_url('') ?>#mobileServices" style="text-decoration: none;" class="text-dark">
						<li class="border-0 form-control mobile_menu_list">SERVICES</li>
					</a>
				<a href="<?= base_url('') ?>" style="text-decoration: none;" class="text-dark">
					<li class="border-0 form-control mobile_menu_list">FAQ's</li>
				</a>
				<?php
				if (isset($this->session->user_session)) {?>
				<a href="<?= base_url('user_profile_menus') ?>" style="text-decoration: none;" class="text-dark">
					<li class="border-0 form-control mobile_menu_list">MY ACCOUNT</li>
				</a>
				<?php }?>
				<a href="<?= base_url('partner_with_us') ?>" style="text-decoration: none;" class="text-dark">
					<li class="border-0 form-control mobile_menu_list">PARTNER WITH US</li>
				</a>
				<a href="<?= base_url('sukaii_help_center') ?>" style="text-decoration: none;" class="text-dark">
					<li class="border-0 form-control mobile_menu_list">CONTACT US</li>
				</a>
				<a href="<?= base_url('') ?>" style="text-decoration: none;" class="text-dark">
					<li class="border-0 form-control mobile_menu_list d-flex">FOLLOW US
						<div class="social_icons d-flex ml-2">
							<span>
								<a href="https://www.facebook.com/">
									<i class='bx bxl-facebook-square' style="font-size: 25px; color: #1e67e9;"></i>
								</a>
							</span>
							<span>
								<a href="https://www.instagram.com/?hl=en">
									<i class='bx bxl-instagram' style="font-size: 25px;  color: indianred;"></i>
								</a>
							</span>
						</div>
					</li>
				</a>
				<?php
				if (isset($this->session->user_session)) {?>
					<a href="<?=base_url('logout')?>" style="text-decoration: none;" class="text-dark">
						<li class="border-0 form-control mobile_menu_list">LOGOUT</li>
					</a>
				<?php }?>


			</ul>
		</div>
	</div>
</header>
<script>
	$("#MenuIconBtn").click(function () {
		$("#MobileMenuSection").slideDown();
	});
	$(document).mouseup(function (e) {
		var hideMenu = $("#MobileMenuSection");
		var hideMenubtn = $("#MenuIconBtn");

		if ((!hideMenu.is(e.target) && hideMenu.has(e.target).length === 0) && (!hideMenubtn.is(e.target) && hideMenubtn.has(e.target).length === 0)) {
			$('#MobileMenuSection').slideUp();
		}
	});

window.addEventListener("scroll", function(){
	$("#MobileMenuSection").slideUp();
});
</script>
