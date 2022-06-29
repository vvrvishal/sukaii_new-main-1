<?php $this->load->view('layout/admin_header'); ?>

<div>
	<div id="DivCardPaymentList">
		<div class="col-lg-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Card Payment Details</h4>
					<div class="table-responsive pt-3">
						<table class="table table-bordered" id="tableCardDetailsDetails">
							<thead>
							<tr>
								<th>order_id</th>
								<th>amount</th>
								<th>card_holde_name</th>
								<th>card_expiry</th>
								<th>card_number</th>
								<th>card_type</th>
								<th>transaction_date</th>
								<th>transaction_status</th>
							</tr>
							</thead>
							<tbody>
							<tr>
								<td>1</td>
								<td>3000</td>
								<td>Avinash</td>
								<td>2025-02-25</td>
								<td>123123132</td>
								<td>Credit</td>
								<td>2022-03-08</td>
								<td>pending</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

</script>
<?php $this->load->view('layout/admin_footer'); ?>
