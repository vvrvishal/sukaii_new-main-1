<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" integrity="sha512-10/jx2EXwxxWqCLX/hHth/vu2KY3jCF70dCQB8TSgNjbCVAC/8vai53GfMDrO2Emgwccf2pJqxct9ehpzG+MTw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- partial:partials/_navbar.html -->
<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
	<div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">

		<div>
			<?php if ($this->session->user_session->user_type == "1"){ ?>
			<a class="navbar-brand brand-logo mr-2" href="<?=base_url('dashboard')?>">
				<img src="<?= base_url('assets/sukaii_icons/SUKAII-Logo.png') ?>" alt="logo" />
			</a>
			<!-- <a class="navbar-brand brand-logo-mini" href="<?=base_url('dashboard')?>">
				<img src="<?= base_url('assets/sukaii_icons/SUKAII-Logo.png') ?>" alt="logo" />
			</a> -->
			<?php }else{ ?>
				<a class="navbar-brand brand-logo" href="<?=base_url()?>">
					<img src="<?= base_url('assets/sukaii_icons/SUKAII-Logo.png') ?>" alt="logo" />
				</a>
				<a class="navbar-brand brand-logo-mini" href="<?=base_url()?>">
					<img src="<?= base_url('assets/sukaii_icons/SUKAII-Logo.png') ?>" alt="logo" />
				</a>
			<?php }?>
		</div>
		<div class="me-2 mt-2">
			<button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
				<span class="icon-menu"></span>
			</button>
		</div>
	</div>
	<div class="navbar-menu-wrapper d-flex align-items-top">
		<ul class="navbar-nav">
			<li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
				<h1 class="welcome-text mb-0">Hello <span class="text-black fw-bold"><?= $this->session->user_session->name; ?></span></h1>
			</li>
		</ul>
		<ul class="navbar-nav ms-auto">

			<li class="nav-item dropdown d-none d-lg-block user-dropdown">
				<a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
				<i class="fa-solid fa-arrow-right-from-bracket menu-icon"></i>
					<!-- <i class="menu-icon mdi mdi-account-circle-outline"></i> -->
				<div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
<!--					<div class="dropdown-header text-center">-->
<!--						<img class="img-md rounded-circle" src="images/faces/face8.jpg" alt="Profile image">-->
<!--						<p class="mb-1 mt-3 font-weight-semibold">Allen Moreno</p>-->
<!--						<p class="fw-light text-muted mb-0">allenmoreno@gmail.com</p>-->
<!--					</div>-->
<!--					<a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile <span class="badge badge-pill badge-danger">1</span></a>-->
<!--					<a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-message-text-outline text-primary me-2"></i> Messages</a>-->
<!--					<a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-calendar-check-outline text-primary me-2"></i> Activity</a>-->
<!--					<a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-help-circle-outline text-primary me-2"></i> FAQ</a>-->
					<a class="dropdown-item" href="<?=base_url("logout")?>"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign Out</a>
				</div>
			</li>
		</ul>
		<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
			<span class="mdi mdi-menu"></span>
		</button>
	</div>
</nav>
<!--sidebar menu-->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
	<ul class="nav">
		<li class="nav-item">
			<a class="nav-link" href="<?= base_url('dashboard');?>">
				<i class="mdi mdi-grid-large menu-icon"></i>
				<span class="menu-title">Dashboard</span>
			</a>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="<?= base_url('orderDetails');?>">
				<i class="mdi mdi-cart-outline menu-icon"></i>
				<span class="menu-title">Order Details</span>
			</a>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="<?= base_url('orderAllocation');?>">
				<i class="mdi mdi-cart-outline menu-icon"></i>
				<span class="menu-title">Order Allocation</span>
			</a>
		</li>

		<li class="nav-item">
			<a class="nav-link" href="<?= base_url('userDetails');?>">

				<i class="menu-icon mdi mdi-account-circle-outline"></i>
				<span class="menu-title">User Details</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="<?= base_url('testForm');?>">

				<i class="menu-icon mdi mdi-account-circle-outline"></i>
				<span class="menu-title">Schedule Master Setup</span>
			</a>
		</li>

<!--		<li class="nav-item">-->
<!--			<a class="nav-link" href="--><?//= base_url('cardPaymentDetails');?><!--">-->
<!--				<i class="mdi mdi-grid-large menu-icon"></i>-->
<!--				<span class="menu-title">Card Payment Details</span>-->
<!--			</a>-->
<!--		</li>-->

<!--		<li class="nav-item">-->
<!--			<a class="nav-link" href="--><?//= base_url('customerAddressDetails');?><!--">-->
<!--				<i class="mdi mdi-grid-large menu-icon"></i>-->
<!--				<span class="menu-title">Customer Address Details</span>-->
<!--			</a>-->
<!--		</li>-->


<!--		<li class="nav-item">-->
<!--			<a class="nav-link" href="--><?//= base_url('packageDetails');?><!--">-->
<!--				<i class="mdi mdi-grid-large menu-icon"></i>-->
<!--				<span class="menu-title">Package Details</span>-->
<!--			</a>-->
<!--		</li>-->

		<li class="nav-item">
			<a class="nav-link" href="<?= base_url('partnerDetails');?>">
<!--				<i class="mdi mdi-grid-large menu-icon"></i>-->
				<i class="mdi mdi-account-multiple-outline menu-icon"></i>
				<span class="menu-title">Partner Details</span>
			</a>
		</li>

<!--		<li class="nav-item">-->
<!--			<a class="nav-link" href="--><?//= base_url('reportDetails');?><!--">-->
<!--				<i class="mdi mdi-grid-large menu-icon"></i>-->
<!--				<span class="menu-title">Report Details</span>-->
<!--			</a>-->
<!--		</li>-->

<!--		<li class="nav-item">-->
<!--			<a class="nav-link" href="--><?//= base_url('sampleCollecters');?><!--">-->
<!--				<i class="mdi mdi-grid-large menu-icon"></i>-->
<!--				<span class="menu-title">Sample Collecters</span>-->
<!--			</a>-->
<!--		</li>-->

<!--		<li class="nav-item">-->
<!--			<a class="nav-link" href="--><?//= base_url('servicesDetails');?><!--">-->
<!--				<i class="mdi mdi-grid-large menu-icon"></i>-->
<!--				<span class="menu-title">Services Details</span>-->
<!--			</a>-->
<!--		</li>-->

		<li class="nav-item">
			<a class="nav-link" href="<?= base_url('userEnquiryDetails');?>">
				<i class="mdi mdi-comment-question-outline menu-icon"></i>
				<span class="menu-title">User Enquiry Details</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="<?= base_url('sampleCollector');?>">
				<i class="mdi mdi-test-tube menu-icon"></i>
				<span class="menu-title">Sample Collector</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="<?= base_url('logout');?>">
				<i class="fa-solid fa-arrow-right-from-bracket menu-icon"></i>
				<span class="menu-title">logout</span>
			</a>
		</li>

	</ul>
</nav>
<div class="container-fluid mt-3">

