<?php $this->load->view("./layout/header"); ?>
<div class="basic_health_checkup">
	<div class="row" style="background-color : var(--iconbgColor);">
		<div class="col-12 col-md-10 mx-auto px-0">
			<h6 class="font-weight-bold mb-1 mt-3 text-center bg_heading" style="font-family: var(--primaryText);">Stay Safe. Take the test</h6>
			<h6 class="text-center font-weight-bold mb-3 bg_heading" style="color: var(--themePink); font-family: var(--primaryText);">@Home</h6>
			<div class="row">
				<div class="align-items-baseline col-3 d-flex justify-content-md-end pl-0">
					<img src="<?= base_url('assets/sukaii_icons/Covid-white.png') ?>" class="service_detail_image" style="width: 115%;" alt="">
				</div>
				<div class="col-9 px-0">
					<div class="row mb-3">
						<div class="align-items-center col-6 d-flex px-0">
							<img src="<?= base_url('assets/mimages/Home icon.png') ?>" class="mr-1 service_detail_icon_1" style="width: 25%;" alt="">
							<div class="small service_detail_text">Sample Collection at Home</div>
						</div>
						<div class="align-items-center col-6 d-flex px-0">
							<img src="<?= base_url('assets/mimages/Shield Icon.png') ?>" class="mr-1 service_detail_icon_2" style="width: 20%;" alt="">
							<small class="service_detail_text">Strict safety & Hygeine measures</small>
						</div>
					</div>
					<div class="row mb-3" style="padding-left: 4px;">
						<div class="align-items-center col-6 d-flex px-0">
							<img src="<?= base_url('assets/mimages/reports-within-24-hrs.png') ?>" class="mr-1 service_detail_icon_3" style="width: 18%;" alt="">
							<small class="service_detail_text">Reports within 24 hours</small>
						</div>
						<div class="align-items-center col-6 d-flex px-0">
							<img src="<?= base_url('assets/	mimages/lab-approved.png') ?>" class="mr-1 service_detail_icon_4" style="width: 22%;" alt="">
							<small class="service_detail_text">xxxxx laboratory approved</small>
						</div>
					</div>
				</div>
			</div>
			<h6 style="color: var(--themePink);" class="font-weight-bold mb-3 pl-4 service_detail_name">COVID RT-PCR TEST</h6>
		</div>
	</div>
	<div class="container pt-3 px- text-justify detail_container" style="padding:1rem 2rem">
		<div class="row">
			<div class="col-md-8 m-md-auto px-0">
				<p style="font-family: var(--secondryText); font-size: 15px;">Our RT-PCR test is one of the most accurate tests for Covid-19 and recommended for anyone who suspects they may have Covid-19 or been exposed to a Covid-19 positive person. It can also be used for official purposes where a Covid-19 test certificate
					is required.
				</p>
				<!-- <div class="col-md-3"></div> -->
				<div class="row mb-4">
					<div class="col-4 pl-0 mb-2 service_info"><b>Sample Type</b></div>
					<div class="col-8 service_info_result normal_text"> <b>:</b> Nasal Swab</div>
					<div class="col-4 pl-0 mb-2 service_info normal_text"><b>Gender</b></div>
					<div class="col-8 service_info_result"> <b>:</b> All </div>
					<div class="col-4 pl-0 mb-2 service_info normal_text"><b>Age group</b></div>
					<div class="col-8 service_info_result"> <b>:</b> All </div>
				</div>

				<div class="my-4 pl-4 price">
					<h6 class="font-weight-bold mb-2" style="font-size:1.05rem">PRICE :</h6>
					<h5 class="font-weight-bold text-muted mb-2" style=" text-decoration: line-through;">THB 2,500</h5>
				</div>
				<div class="my-4 pl-4 price">
					<h6 class="font-weight-bold mb-2" style="font-size:1.05rem">CURRENT OFFER PRICE :</h6>
					<h5 class="font-weight-bold mb-2" style=" color: var(--themeGreen);">THB 2,000</h5>
				</div>
				<div class="book_service text-center">
					<a href="<?= base_url('serviceOrder/1481') ?>"><button type="button" class="px-3 btn btn-light btn-sm" style="background-color: var(--themePink); color: white; border-radius: 6px;"><b>BOOK</b></button></a>
				</div>
			</div>
		</div>

	</div>
</div>
<?php $this->load->view("./layout/footer"); ?>