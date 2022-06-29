<?php $this->load->view("./layout/header");?>
<div class="basic_health_checkup">
	<div class="row" style="background-color : var(--iconbgColor);">
		<div class="col-12 col-md-10 mx-auto px-0">
			<h6 class="font-weight-bold mb-1 mt-3 text-center" style="font-family: var(--primaryText);">Stay Safe. Take the test</h6>
			<h6 class="text-center font-weight-bold mb-3" style="color: var(--themePink); font-family: var(--primaryText);">@Home</h6>
			<div class="row">
				<div class="align-items-center col-3 d-flex pl-0">
					<img src="<?= base_url('assets/sukaii_icons/BASIC-HEALTH-CHECK-UP-white.png')?>" class="service_detail_image" style="width: 115%;" alt="">
				</div>
				<div class="col-9 px-0">
					<div class="row mb-3">
						<div class="align-items-center col-6 d-flex px-0">
							<img src="<?= base_url('assets/mimages/Home icon.png')?>" class="mr-1 service_detail_icon_1" style="width: 25%;" alt="">
							<div class="small service_detail_text" style="font-size: 60%;">Sample Collection at Home</div>
						</div>
						<div class="align-items-center col-6 d-flex px-0">
							<img src="<?= base_url('assets/mimages/Shield Icon.png')?>" class="mr-1 service_detail_icon_2" style="width: 20%;" alt="">
							<small style="font-size: 60%;" class="service_detail_text">Strict safety & Hygeine measures</small>
						</div>
					</div>
					<div class="row mb-3" style="padding-left: 4px;">
						<div class="align-items-center col-6 d-flex px-0">
							<img src="<?= base_url('assets/mimages/reports-within-24-hrs.png')?>" class="mr-1 service_detail_icon_3" style="width: 18%;" alt="">
							<small style="font-size: 60%;" class="service_detail_text">Reports within 24 hours</small>
						</div>
						<div class="align-items-center col-6 d-flex px-0">
							<img src="<?= base_url('assets/	mimages/lab-approved.png')?>" class="mr-1 service_detail_icon_4" style="width: 22%;" alt="">
							<small style="font-size: 60%;" class="service_detail_text">xxxxx laboratory approved</small>
						</div>
					</div>
				</div>
			</div>
			<h6 style="color: var(--themePink);" class="font-weight-bold mb-3 pl-4 service_detail_name">BASIC HEALTH CHECK UP</h6>
		</div>
	</div>
	<div class="container pt-3 px- text-justify detail_container" style="padding:1rem 2rem">
		<p style="font-family: var(--secondryText); font-size: 14px;">Sukaii Basic Health Check is a thorough health check via a blood sample that covers all vital body functions and organs. This test is recommended annually for all healthy adults and more regularly for those with underlying concerns
		</p>
		<div class="row mb-4">
			<div class="col-4 pl-0 mb-2 service_info"><b>Sample Type</b></div>
			<div class="col-8 service_info_result"> <b>:</b> Blood</div>
			<div class="col-4 pl-0 mb-2 service_info"><b>Gender</b></div>
			<div class="col-8 service_info_result"> <b>:</b> All Adults</div>
			<div class="col-4 pl-0 mb-2 service_info"><b>Age group</b></div>
			<div class="col-8 service_info_result"> <b>:</b> 35 years & above</div>
		</div>
		<div class="details_btn">
			<button type="button" id="BasicHealthCheckupShow" class="btn btn-secondary btn-sm" style="border-radius: 6px;">View Details</button>
			<button type="button" id="BasicHealthCheckupHide" class="btn btn-secondary btn-sm" style="border-radius: 6px; display: none;">Close Details</button>
		</div>
		<div class="mt-4 show_services" id="BasicHealthCheckup" style="display: none;">
			<h6><small class="font-weight-bold sukaii_pink_color mb-2">Sukaii Basic Health Check Package Includes :</small></h6>
			<div class="row border border-dark border-bottom-0 sukaii_pink_bgcolor ">
				<div class="col-8 border border-dark py-1"></div>
				<div class="col-4 border border-dark text-center text-light small py-1" style="font-family: var(--primaryText);">Basic</div>
			</div>
			<div class="row sukaii_green_bgcolor text-light">
				<div class="col-8 border border-dark font-weight-bold small py-1">PRICE</div>
				<div class="col-4 border border-dark font-weight-bold text-center small py-1">THB 3000</div>
			</div>
			<div class="row ">
				<div class="border border-dark col-8 font-weight-bold small sukaii_pink_color py-1 " style="font-family: var(--primaryText);"> Complete Blood Count</div>
				<div class="col-4 border border-dark py-1 small text-center">Basic</div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Haemoglobin</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">PCV</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">MCV</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">MCH</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">MCHC</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Platelet Count</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">TWBC</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Differential Count</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Total RBC</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row " style="background-color: var(--iconbgColor);">
				<div class="border border-dark col-8 font-weight-bold small sukaii_pink_color py-1 " style="font-family: var(--primaryText); "> ESR (Sedimentation Rate)</div>
				<div class="col-4 border border-dark py-1 small text-center"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row " style="background-color: var(--iconbgColor);">
				<div class="border border-dark col-8 font-weight-bold small sukaii_pink_color py-1 " style="font-family: var(--primaryText);"> Blood Group</div>
				<div class="col-4 border border-dark py-1 small text-center"></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">ABO </div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Rhesus</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row " style="background-color: var(--iconbgColor);">
				<div class="border border-dark col-8 font-weight-bold small sukaii_pink_color py-1 " style="font-family: var(--primaryText);"> Diabetes</div>
				<div class="col-4 border border-dark py-1 small text-center"></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Glucose</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row " style="background-color: var(--iconbgColor);">
				<div class="border border-dark col-8 font-weight-bold small sukaii_pink_color py-1 " style="font-family: var(--primaryText);"> Kidney Function</div>
				<div class="col-4 border border-dark py-1 small text-center"></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Urea</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Creatinine</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Uric Acid </div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">eGFR</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Sodium</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Potassium</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Chloride</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Bicarbonate</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Calcium</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Inorganic Phosphate</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row " style="background-color: var(--iconbgColor);">
				<div class="border border-dark col-8 font-weight-bold small sukaii_pink_color py-1 " style="font-family: var(--primaryText);"> Liver Function</div>
				<div class="col-4 border border-dark py-1 small text-center"></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Total Protein</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Albumin</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Globulin </div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">A/G Ratio </div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Total Bilirubin</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">ALK</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">SGOT</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">SGPT</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">GGT</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row " style="background-color: var(--iconbgColor);">
				<div class="border border-dark col-8 font-weight-bold small sukaii_pink_color py-1 " style="font-family: var(--primaryText);"> Lipid Profile</div>
				<div class="col-4 border border-dark py-1 small text-center"></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Total Cholestrol </div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">HDL</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">LDL </div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Triglycerides </div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Total / HDL Ratio</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row " style="background-color: var(--iconbgColor);">
				<div class="border border-dark col-8 font-weight-bold small sukaii_pink_color py-1 " style="font-family: var(--primaryText);"> Thyroid</div>
				<div class="col-4 border border-dark py-1 small text-center"></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">T4 </div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">TSH</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row " style="background-color: var(--iconbgColor);">
				<div class="border border-dark col-8 font-weight-bold small sukaii_pink_color py-1 " style="font-family: var(--primaryText);"> Arthritis</div>
				<div class="col-4 border border-dark py-1 small text-center"></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">RA Factor</div>
				<div class="col-4 border border-dark text-center py-1"><i class="fa-solid fa-xmark"></i></div>
			</div>
			<div class="row " style="background-color: var(--iconbgColor);">
				<div class="border border-dark col-8 font-weight-bold small sukaii_pink_color py-1 " style="font-family: var(--primaryText);"> Cancer Markers</div>
				<div class="col-4 border border-dark py-1 small text-center"></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Liver Cancer (AFP) </div>
				<div class="col-4 border border-dark text-center py-1"></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Gastrointestinal (CEA) </div>
				<div class="col-4 border border-dark text-center py-1"></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Prostate (PSA) </div>
				<div class="col-4 border border-dark text-center py-1"></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Ovarian (CA-125) </div>
				<div class="col-4 border border-dark text-center py-1"></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Gastroint. Hepa. (CA19-9)</div>
				<div class="col-4 border border-dark text-center py-1"></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">CA15-3</div>
				<div class="col-4 border border-dark text-center py-1"></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">H Pylori IgG</div>
				<div class="col-4 border border-dark text-center py-1"></div>
			</div>
			<div class="row " style="background-color: var(--iconbgColor);">
				<div class="border border-dark col-8 font-weight-bold small sukaii_pink_color py-1 " style="font-family: var(--primaryText);"> Urine Analysis</div>
				<div class="col-4 border border-dark py-1 small text-center"></div>
			</div>
			<div class="row " style="background-color: var(--iconbgColor);">
				<div class="border border-dark col-8 font-weight-bold small sukaii_pink_color py-1 " style="font-family: var(--primaryText);"> Syphilis</div>
				<div class="col-4 border border-dark py-1 small text-center"></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">VDRL</div>
				<div class="col-4 border border-dark text-center py-1"></div>
			</div>
			<div class="row " style="background-color: var(--iconbgColor);">
				<div class="border border-dark col-8 font-weight-bold small sukaii_pink_color py-1 " style="font-family: var(--primaryText);"> Hepatitis B</div>
				<div class="col-4 border border-dark py-1 small text-center"></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">HBs Ab</div>
				<div class="col-4 border border-dark text-center py-1"></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">HBs Ag</div>
				<div class="col-4 border border-dark text-center py-1"></div>
			</div>
			<div class="row " style="background-color: var(--iconbgColor);">
				<div class="border border-dark col-8 font-weight-bold small sukaii_pink_color py-1 " style="font-family: var(--primaryText);"> Hepatitis A</div>
				<div class="col-4 border border-dark py-1 small text-center"></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">HAV IgG</div>
				<div class="col-4 border border-dark text-center py-1"></div>
			</div>
			<div class="row " style="background-color: var(--iconbgColor);">
				<div class="border border-dark col-8 font-weight-bold small sukaii_pink_color py-1 " style="font-family: var(--primaryText);"> Hepatitis C</div>
				<div class="col-4 border border-dark py-1 small text-center"></div>
			</div>
			<div class="row ">
				<div class="col-8 border border-dark small py-1">Anti-HCV</div>
				<div class="col-4 border border-dark text-center py-1"></div>
			</div>
			<div class="row " style="background-color: var(--iconbgColor);">
				<div class="border border-dark col-8 font-weight-bold small sukaii_pink_color py-1 " style="font-family: var(--primaryText);">HIV</div>
				<div class="col-4 border border-dark py-1 small text-center"></div>
			</div>



		</div>
		<div class="my-4 pl-4 price">
			<h6 class="font-weight-bold mb-2" style="font-size:1.2rem">PRICE :</h6>
			<h3 class="font-weight-bold mb-2" style="color: var(--themeGreen);">THB 3,000</h3>
		</div>
		<div class="book_service text-center">
			<a href="<?= base_url('serviceOrder/1482')?>">
				<button type="button" class="px-3 btn btn-light btn-sm" style="background-color: var(--themePink); color: white; border-radius: 6px;"><b>BOOK</b></button>
			</a>
		</div>
	</div>
</div>
<script>
	$("#BasicHealthCheckupShow").click(function() {
		$("#BasicHealthCheckup").slideDown();
		$("#BasicHealthCheckupHide").show();
		$(this).hide();
	});
	$("#BasicHealthCheckupHide").click(function() {
		$("#BasicHealthCheckup").slideUp();
		$(this).hide();
		$("#BasicHealthCheckupShow").show();
	});
</script>
<?php $this->load->view("./layout/footer");?>
