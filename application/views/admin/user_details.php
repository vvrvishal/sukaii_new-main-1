<?php $this->load->view('layout/admin_header'); ?>
<style>
	button.btn.btn-inverse-dark.p-2:active, button.btn.btn-inverse-dark.p-2:focus{
		background-color: #d2d4d8;
		box-shadow: none;

	}
</style>
<div>

	<div id="DivUsersList">
		<div class="col-lg-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">User Details</h4>
					<div class="table-responsive pt-3">
						<table class="table table-bordered" id="tableUserDetails" style="width:100% !important;">
							<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Mobile</th>
								<th>Gender</th>
								<th>Register Mode</th>
								<th>Register Datetime</th>
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
<?php $this->load->view('layout/admin_footer'); ?>
<script>
	$(document).ready(function () {
		loadUserDetails();
	})
</script>
