<?php $this->load->view('layout/admin_header'); ?>
<style></style>
<link rel="stylesheet" href="assets/modules/bootstrap-daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="assets/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.min.js" integrity="sha512-tMabqarPtykgDtdtSqCL3uLVM0gS1ZkUAVhRFu1vSEFgvB73niFQWJuvviDyBGBH22Lcau4rHB5p2K2T0Xvr6Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquerSy.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<style>
	.daterangepicker .ranges li.active {
		background-color: #0fb5b8;
		color: #fff;
	}

	.btn-primary:hover,
	.btn-primary:focus {
		background: #e81390;
		color: #ffffff;
		border: #e81390;
	}

	.btn-primary {
		background: #e81390;
		color: #ffffff;
		border: #e81390;
	}

	.daterangepicker td.active,
	.daterangepicker td.active:hover {
		background-color: #1fb9bc;
		border-color: transparent;
		color: #fff;
	}
</style>
<div class="container-fluid d-flex justify-content-end mb-3">
	<div class="align-items-center d-flex float-end justify-content-between rounded-3" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;width:24%">
		<div class="">
		<i class="fa fa-calendar" style="color:#1fb9bc;"></i>&nbsp;
		<span id="reportrange"></span>
		</div> 
		<i class="fa fa-caret-down" style="color: #1fb9bc;"></i>
	</div>
<!-- 	<button type="button" value="Search" onclick="search()" id="search" class="border border-dark btn btn-sm rounded-1" style="margin-left: 10px;">Search</button> -->
</div>
<div class="row mb-4">
	<div class="col-md-12">
		<div class="card">

			<div class="differOders">
				<div class="card">
					<div class="container-fluid">
						<div class="align-items-baseline d-flex justify-content-start month mt-3">
							<h5 style="font-weight: 800; ">Order Statistic - </h5>
							<div class="currentMonth" style="margin-left: 12px;"> Current Month</div>
						</div>


					</div>
					<div class="align-items-center d-flex justify-content-around my-4">
						<div class="statistics-details d-flex align-items-center justify-content-between">
							<div>
								<p class="statistics-title text-center" style="font-weight: 700;">Pending Orders</p>
								<h3 class="rate-percentage text-center" id="pending_orders"></h3>
							</div>

						</div>
						<div class="statistics-details d-flex align-items-center justify-content-between">
							<div>
								<p class="statistics-title  text-center" style="font-weight: 700;">Ongoing Orders</p>
								<h3 class="rate-percentage text-center" id="ongoing_orders"></h3>
							</div>

						</div>
						<div class="statistics-details d-flex align-items-center justify-content-between">
							<div>
								<p class="statistics-title  text-center" style="font-weight: 700;">Complete Orders</p>
								<h3 class="rate-percentage text-center" id="complete_orders"></h3>
							</div>
						</div>

						<div class="statistics-details d-flex align-items-center justify-content-between">
							<div>
								<p class="statistics-title  text-center" style="font-weight: 700;">Cancel Orders</p>
								<h3 class="rate-percentage text-center" id="cancle_orders"></h3>
							</div>
						</div>

						<div class="statistics-details d-flex align-items-center justify-content-between">
							<div>
								<p class="statistics-title  text-center" style="font-weight: 700;">Payment Failed</p>
								<h3 class="rate-percentage text-center" id="payment_failed"></h3>
							</div>
						</div>
					</div>
					<div class="total_order">
						<div class="container-fluid">
							<div class="statistics-details d-flex">
								<div class="icon">
									<span class="align-items-center border d-flex justify-content-center mb-3 rounded text-center" style="font-size: xx-large;width: 65px;height: 65px;color: #e80b8c; background: #0db4b757;margin-right: 17px;">
										<i class="fa-solid fa-bag-shopping"></i>
									</span>
								</div>
								<div>
									<p class="statistics-title">Orders</p>
									<h3 class="rate-percentage" id="orders"></h3>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	var start = moment();
	var end = moment().add(29, 'days');

	function cb(start, end) {
		$('#reportrange').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
	}

	$('#reportrange').daterangepicker({
		startDate: start,
		endDate: end,
		ranges: {
			'Today': [moment(), moment()],
			'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'Last 7 Days': [moment().subtract(6, 'days'), moment()],
			'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			'This Month': [moment().startOf('month'), moment().endOf('month')],
			'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
			},
	},function(start, end, label) {
		$('#reportrange').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  				search(start, end);
	});
	
	cb(start, end);
</script>

<div class="col-sm-12 col-md-12 mb-4">

	<div class="row">
		<div class="col-sm-12 col-md-6">

			<div class="card">
				<div class="card-body py-3">
					<div class="statistics-details d-flex align-items-center justify-content-between">
						<div class="w-100">

							<h4>List of ongoing orders</h4>
							<div class="table-responsive">
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
									<?php foreach ($ongoing->data as $key => $row) { ?>
										<tbody>
											<!-- <a href="orderDetails"> -->
											<tr id="tableRow">
												<td><?php echo $row->order_id; ?></td>
												<td><?php echo $row->location; ?></td>
												<td><?php echo $row->schedule_date; ?></td>
												<td><?php echo $row->schedule_time; ?></td>
												<td>
													<a onclick="redirectToOrderDetails('id','<?= $row->id; ?>');"><button class="btn btn-light rounded btn-sm" style="background-color: lightgray; "> <span><i class="fa-solid fa-eye" style="color:black;"></i></span>
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
			</div>
		</div><br>
		<div class="col-sm-12 col-md-6">
			<div class="card">
				<div class="card-body py-3">
					<div class="statistics-details d-flex align-items-center justify-content-between">
						<div class="w-100">

							<h4>List of completed Reports </h4>
							<div class="table-responsive">

								<table class="table">
									<thead>
										<tr>
											<th scope="col">Order id</th>
											<th scope="col">Location</th>
											<th scope="col">Schedule date</th>
											<th scope="col">Schedule Time</th>
											<th scope="col">View</th>
										</tr>
									</thead>
									<?php foreach ($completed->data as $key => $row) { ?>
										<tbody>
											<!-- <a href="orderDetails"> -->
											<tr id="tableRow">
												<td scope="row"><?php echo $row->order_id; ?></td>
												<td><?php echo $row->location; ?></td>
												<td><?php echo $row->schedule_date; ?></td>
												<td><?php echo $row->schedule_time; ?></td>
												<td>
													<a onclick="redirectToOrderDetails('id','<?= $row->id; ?>');"><button class="btn btn-light rounded btn-sm" style="background-color: lightgray; color:black;"> <span><i class="fa-solid fa-eye"></i></span>

														</button></a>
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
			</div>
		</div>
	</div>

</div>

<script>
	$(document).ready(function() {
		$.ajax({
			url: "<?php echo site_url('AdminController/dashboardData'); ?>",
			async: true,
			method: 'post',
			dataType: 'json',
			success: function(data) {
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

	function redirectToOrderDetails(filterColumn,filterValue) {
		localStorage.clear();
		localStorage.columnName=filterColumn;
		localStorage.columnValue=filterValue;
		window.location.href = baseURL+'orderDetails';
	}

	function search() {
		//  var date_from = $("#fromDate").val();
		//  var date_to = $("#toDate").val();
		var d = $("#reportrange")[0].innerText;
		var d = d.split("-");

		var dt = new Date(d[0]);
		var month = '' + (dt.getMonth() + 1);
		var day = '' + dt.getDate();
		var year = dt.getFullYear();

		if (month.length < 2)
			month = '0' + month;
		if (day.length < 2)
			day = '0' + day;

		var dt1 = new Date(d[1]);
		var month1 = '' + (dt1.getMonth() + 1);
		var day1 = '' + dt1.getDate();
		var year1 = dt1.getFullYear();

		if (month1.length < 2)
			month1 = '0' + month1;
		if (day1.length < 2)
			day1 = '0' + day1;

		var date_to = [year1, month1, day1].join('-');
		var date_from = [year, month, day].join('-');

		$.ajax({
			url: "<?php echo site_url('AdminController/search'); ?>",
			async: true,
			method: 'post',
			data: {
				date_from: date_from,
				date_to: date_to
			},
			dataType: 'json',
			success: function(data) {
				var html = '';
				$("#payment_failed").html(data.payment_failed);
				$("#cancle_orders").html(data.cancel);
				$("#complete_orders").html(data.completed);
				$("#ongoing_orders").html(data.ongoing);
				$("#pending_orders").html(data.pending);
				$("#orders").html(data.orders);
				html += '<div class="col-sm-12 col-md-4">' +
					'<div class="card">' +
					'<div class="card-body py-3">' +
					'<div class="statistics-details d-flex align-items-center justify-content-between">' +
					'<div>' +
					'<p class="statistics-title">Payment Failed</p>' +

					'</div>' +
					'<img src="<?php echo base_url('assets/mimages/payment-alert.png') ?>" class="w-25" alt="">' +
					'</div>' +
					'</div>' +
					'</div>' +
					'</div>';
			}
		});
	}

	function tableRow() {
		// $("#tableRow").css("color","blue");
	}
</script>
<script>
const month = ["January","February","March","April","May","June","July","August","September","October","November","December"];

const d = new Date();
let current_Month = month[d.getMonth()];
let current_year = d.getFullYear();
$(".currentMonth").html(`${current_Month} - ${current_year}`);
// document.getElementById("demo").innerHTML = current_Month;
</script>

<?php $this->load->view('layout/admin_footer'); ?>
