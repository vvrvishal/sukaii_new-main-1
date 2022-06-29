<?php $this->load->view('layout/admin_header'); ?>
<div>
	<div class="container-fluid">
		<div id="DivPartnerDetails">
			<div class="col-md-12 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Partners Details</h4>
						<div class="table-responsive pt-3">
							<table class="table table-bordered" id="tablePartnerDetails">
								<thead>
									<tr>
										<th>Name</th>
										<th>Company Name</th>
										<th>Designation</th>
										<th>Company Email</th>
										<th>Company Phone</th>
										<th>Company Services</th>
										<th>Comment</th>
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

<?php $this->load->view('layout/admin_footer'); ?>
<script>
	$(document).ready(function() {
		loadAllPartner();
	})
</script>
