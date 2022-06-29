<?php $this->load->view('layout/admin_header'); ?>
<div>
	<div id="DivUserEnquiryDetails">
		<div class="row">
			<div class="col-lg-12 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">User Enquiry Details</h4>
						<div class="table-responsive pt-3">
							<table class="table table-bordered" id="tableUserEnquiryDetails">
								<thead>
									<tr>
										<th>name</th>
										<th>mobile</th>
										<th>Email</th>
										<th>services</th>
										<th>location</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
<link rel="stylesheet" href="<?= base_url(); ?>assets/vendors/css/vendor.bundle.base.css">
<?php $this->load->view('layout/admin_footer'); ?>
<script>
	$(document).ready(function() {
		loadAllEnquiries();
	})
</script>
