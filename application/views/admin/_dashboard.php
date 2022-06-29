<?php $this->load->view('layout/admin_header'); ?>
<link rel="stylesheet" href="assets/modules/bootstrap-daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="assets/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.min.js" integrity="sha512-tMabqarPtykgDtdtSqCL3uLVM0gS1ZkUAVhRFu1vSEFgvB73niFQWJuvviDyBGBH22Lcau4rHB5p2K2T0Xvr6Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="assets/modules/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<input type="date" id="fromDate" name="fromDate">
			<input type="date" id="toDate" name="toDate">
			<button type="button" value="Search" onclick="search()" id="search" style="background:green;color:white;border-radius:5px;">Search</button>
			<!-- <div class="form-group">
                      <label class="d-block">Date Range Picker With Button</label>
                      <a href="javascript:;" class="btn btn-primary daterange-btn icon-left btn-icon"><i class="fas fa-calendar"></i> Choose Date
                      </a>
                    </div> -->
<div class="row">
		<!-- <div class="col-sm-12 col-md-4 ">
			<div class="card">
				<div class="card-body py-3">
					<div class="statistics-details d-flex align-items-center justify-content-between">
						<div>
							<p class="statistics-title">Users</p>
							<h3 class="rate-percentage"><?= $user ?></h3>
						</div>
						<img src="<?php echo base_url('assets/mimages/admin_user_logo.png') ?>" class="w-25" alt="">
					</div>
				</div>
			</div>
		</div> -->
		<!-- <div class="col-sm-12 col-md-4">
			<div class="card">
				<div class="card-body py-3">
					<div class="statistics-details d-flex align-items-center justify-content-between">
						<div>
							<p class="statistics-title">Partners</p>
							<h3 class="rate-percentage"><?= $user ?></h3>
						</div>
						<img src="<?php echo base_url('assets/mimages/bussiness_partener.png') ?>" class="w-25" alt="">
					</div>
				</div>
			</div>
		</div> -->
		<!-- <div class="col-sm-12 col-md-4">
			<div class="card">
				<div class="card-body py-3">
					<div class="statistics-details d-flex align-items-center justify-content-between">
						<div>
							<p class="statistics-title">Enquiries</p>
							<h3 class="rate-percentage"><?= $enquiry ?></h3>
						</div>
						<img src="<?php echo base_url('assets/mimages/inquiry(2).png') ?>" class="w-25" alt="">
					</div>
				</div>
			</div>
		</div> -->
</div>
<div class="row mt-4">
		<div class="col-sm-12 col-md-4">
			<div class="card">
				<div class="card-body py-3">
					<div class="statistics-details d-flex align-items-center justify-content-between">
						<div>
						<p class="statistics-title">Orders</p>
									<h3 class="rate-percentage" id="orders"></h3>
						</div>
						<img src="<?php echo base_url('assets/mimages/sales-order.jpg') ?>" class="w-25" alt="">
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 col-md-4">
			<div class="card">
				<div class="card-body py-3">
					<div class="statistics-details d-flex align-items-center justify-content-between">
						<div>
						<p class="statistics-title">Pending Orders</p>
									<h3 class="rate-percentage" id="pending_orders"></h3>
						</div>
						<img src="<?php echo base_url('assets/mimages/pending.png') ?>" class="w-25" alt="">
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 col-md-4">
			<div class="card">
				<div class="card-body py-3">
					<div class="statistics-details d-flex align-items-center justify-content-between">
						<div>
						<p class="statistics-title">Ongoing Orders</p>
									<h3 class="rate-percentage" id="ongoing_orders"></h3>
						</div>
						<img src="<?php echo base_url('assets/mimages/ongoing_leb_test.jpg') ?>" class="w-25" alt="">
					</div>
				</div>
			</div>
		</div>
</div>
<div class="row mt-4">
		<div class="col-sm-12 col-md-4">
			<div class="card">
				<div class="card-body py-3">
					<div class="statistics-details d-flex align-items-center justify-content-between">
						<div>
						<p class="statistics-title">Complete Orders</p>
									<h3 class="rate-percentage" id="complete_orders"></h3>
						</div>
						<img src="<?php echo base_url('assets/mimages/order-complete-.png') ?>" class="w-25" alt="">
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 col-md-4">
			<div class="card">
				<div class="card-body py-3">
					<div class="statistics-details d-flex align-items-center justify-content-between">
						<div>
						<p class="statistics-title">Cancel Orders</p>
								<h3 class="rate-percentage" id="cancle_orders"></h3>
						</div>
						<img src="<?php echo base_url('assets/mimages/cancelled.png') ?>" style='width:32%;' alt="">
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 col-md-4">
			<div class="card">
				<div class="card-body py-3">
					<div class="statistics-details d-flex align-items-center justify-content-between">
						<div>
						<p class="statistics-title">Payment Failed</p>
							<h3 class="rate-percentage" id="payment_failed"></h3>
						</div>
						<img src="<?php echo base_url('assets/mimages/payment-alert.png') ?>" class="w-25" alt="">
					</div>
				</div>
			</div>
		</div>
</div><br>
<div class="col-sm-12 col-md-7">
			<div class="card">
				<div class="card-body py-3">
					<div class="statistics-details d-flex align-items-center justify-content-between">
						<div class="w-100">

						<h4>List of ongoing orders</h4>
			<table class="table">
				<thead>
					<tr>
						<th>Order id</th>
						<th>Location</th>
						<th>Schedule date</th>
						<th>Schedule Time</th>
						<th>View</th>
					</tr>
				</thead>
				<?php foreach($ongoing->data as $key=>$row){ ?>
				<tbody>
					<!-- <a href="orderDetails"> -->
						<tr id="tableRow">
							<td><?php echo $row->order_id; ?></td>
							<td><?php echo $row->location; ?></td>
							<td><?php echo $row->schedule_date; ?></td>
							<td><?php echo $row->schedule_time; ?></td>
							<td>
								<a href="orderDetails"><button class="btn btn-light rounded btn-sm" style="background-color: lightgray; color:black;"> <span><i class="fa-solid fa-eye"></i></span>
								</a>
							</td>
						</tr>
					<!-- </a> -->

				<?php } ?></a>
				</tbody>
			</table>

						</div>
					</div>
				</div>
			</div>
		</div><br>
		<div class="col-sm-12 col-md-7">
			<div class="card">
				<div class="card-body py-3">
					<div class="statistics-details d-flex align-items-center justify-content-between">
						<div class="w-100">

						<h4>List of completed Reports</h4>
			<table class="table">
				<thead>
					<tr>
						<th>Order id</th>
						<th>Location</th>
						<th>Schedule date</th>
						<th>Schedule Time</th>
						<th>View</th>
					</tr>
				</thead>
				<?php foreach($completed->data as $key=>$row){ ?>
				<tbody>
					<!-- <a href="orderDetails"> -->
						<tr id="tableRow">
							<td><?php echo $row->order_id; ?></td>
							<td><?php echo $row->location; ?></td>
							<td><?php echo $row->schedule_date; ?></td>
							<td><?php echo $row->schedule_time; ?></td>
							<td>
								<a href="orderDetails"><button class="btn btn-light rounded btn-sm" style="background-color: lightgray; color:black;"> <span><i class="fa-solid fa-eye"></i></span>

							</button></a></td>
						</tr>
					<!-- </a> -->

				<?php } ?></a>
				</tbody>
			</table>

						</div>
					</div>
				</div>
			</div>
		</div>
<script>
	$(document).ready(function(){
		$.ajax({
			url: "<?php echo site_url('AdminController/dashboardData'); ?>",
			async: true,
			method: 'post',
			dataType: 'json',
			success: function (data) {
				var html = '';
				$("#payment_failed").html(data.payment_failed);
				$("#cancle_orders").html(data.cancel);
				$("#complete_orders").html(data.completed);
				$("#ongoing_orders").html(data.ongoing);
				$("#pending_orders").html(data.pending);
				$("#orders").html(data.orders);
			}
		});
	});
function search(){
	 var date_from = $("#fromDate").val();
	 var date_to = $("#toDate").val();
	$.ajax({
			url: "<?php echo site_url('AdminController/search'); ?>",
			async: true,
			method: 'post',
			data: {
				date_from:date_from,date_to:date_to
			},
			dataType: 'json',
			success: function (data) {
				var html = '';
				$("#payment_failed").html(data.payment_failed);
				$("#cancle_orders").html(data.cancel);
				$("#complete_orders").html(data.completed);
				$("#ongoing_orders").html(data.ongoing);
				$("#pending_orders").html(data.pending);
				$("#orders").html(data.orders);
				html+='<div class="col-sm-12 col-md-4">'+
			'<div class="card">'+
				'<div class="card-body py-3">'+
					'<div class="statistics-details d-flex align-items-center justify-content-between">'+
						'<div>'+
						'<p class="statistics-title">Payment Failed</p>'+

						'</div>'+
						'<img src="<?php echo base_url('assets/mimages/payment-alert.png') ?>" class="w-25" alt="">'+
					'</div>'+
				'</div>'+
			'</div>'+
		'</div>';
			}
	});
}
function tableRow(){
	// $("#tableRow").css("color","blue");
}
</script>
<?php $this->load->view('layout/admin_footer'); ?>

<!-- <div id="DivOrderDetails">
		<div class="col-lg-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="statistics-details d-flex align-items-center justify-content-between">
								<div>
									<p class="statistics-title">Users</p>
									<h3 class="rate-percentage"><?= $user ?></h3>
								</div>
								<div>
									<p class="statistics-title">Partners</p>
									<h3 class="rate-percentage"><?= $user ?></h3>
								</div>
								<div>
									<p class="statistics-title">Enquiries</p>
									<h3 class="rate-percentage"><?= $enquiry ?></h3>
								</div>
								<div class="d-none d-md-block">
									<p class="statistics-title">Orders</p>
									<h3 class="rate-percentage"><?= $orders ?></h3>
								</div>
								<div class="d-none d-md-block">
									<p class="statistics-title">Pending Orders</p>
									<h3 class="rate-percentage"><?= $pending ?></h3>
								</div>
								<div class="d-none d-md-block">
									<p class="statistics-title">Ongoing Orders</p>
									<h3 class="rate-percentage"><?= $ongoing ?></h3>
								</div>
								<div class="d-none d-md-block">
									<p class="statistics-title">Complete Orders</p>
									<h3 class="rate-percentage"><?= $completed ?></h3>
								</div>
								<div class="d-none d-md-block">
									<p class="statistics-title">Cancel Orders</p>
									<h3 class="rate-percentage"><?= $cancel ?></h3>
								</div>
								<div class="d-none d-md-block">
									<p class="statistics-title">Payment Failed</p>
									<h3 class="rate-percentage"><?= $payment_failed ?></h3>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div> -->
