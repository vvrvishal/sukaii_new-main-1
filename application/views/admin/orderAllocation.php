<?php $this->load->view('layout/admin_header'); ?>
<div id="DivOrderAllocation">
	<div class="row">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Order Allocation</h4>
					<div class="pt-3">
						<div class="row form-group">
							<div class="col-3"><input type="date" class="form-control" name="currentDate" value="<?php echo date('Y-m-d'); ?>" id="currentDate" min="<?php echo date("Y-m-d"); ?>" onchange="getOrdersTimeSlots();"></div>
							<div class="col-3"></div>
							<div class="col-6 d-flex justify-content-around align-items-center">
								<div class="notAllocated"><button class="btn border" style="background-color:#a3e2e3"></button><span class="small" style="margin-left: 4px;">Not Allocated</span></div>
								<div class="partialyAllocated"><button class="btn border"style="background-color:#ffa500"></button><span class="small" style="margin-left: 4px;">partially Allocated</span></div>
								<div class="allAllocated"><button class="btn border " style="background-color: grey;"></button><span class="small" style="margin-left: 4px;">All Allocated</span></div>
							</div>
							<!-- <div class="col-3"></div> -->
						</div>

						<div class="row form-group" id="divTimeSlots">
						</div>

						<!-- Modal -->
						<div class="modal fade" id="modalOrderAllocation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header" style="padding: 8px 26px;">
										<h5 class="card-title m-0 modal-title" id="exampleModalLongTitle">Order Allocation</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal('modalOrderAllocation')">
											<span aria-hidden="true"><i class="fa-solid fa-xmark"></i></span>
										</button>
									</div>
									<div class="modal-body" style="padding: 11px 26px 15px;">
										<div id="divOrderTableAllocation"></div>
									</div>
<!--									<div class="modal-footer">-->
<!--										<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal('modalOrderAllocation')">Close</button>-->
<!--										<button type="button" class="btn btn-primary">Save changes</button>-->
<!--									</div>-->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<?php $this->load->view('layout/admin_footer'); ?>
<script>
	$(document).ready(function () {
		getOrdersTimeSlots();
	})
	function getOrdersTimeSlots() {
		let selectedDate = $("#currentDate").val();
		$.ajax({
			url: 'getOrdersTimeSlots',
			type: 'POST',
			data: {selectedDate: selectedDate},
			dataType: 'json',
			success: function (result) {
				if (result.status == 200){
					$("#divTimeSlots").html("");
					$("#divTimeSlots").html(result.timeSchedule);
				}else{
					$("#divTimeSlots").html("");
					$("#divTimeSlots").html(result.timeSchedule);
				}
			},
		});
	}

	function getScheduleOrders(id,slot,date,thisDiv) {
		let selectedDate = $("#currentDate").val();
		$.ajax({
			url: 'getOrdersForAllocation',
			type: 'POST',
			data: {date: date,slot:slot},
			dataType: 'json',
			success: function (result) {
				if (result.status == 200){
					$("#"+id).modal("show");
					$("#divOrderTableAllocation").html(result.orderTableAllocation);
				}else{
					app.errorToast(result.body);
				}
			},
		});
	}
	function getNurse(order_id,count,date,slot,btnId,nurseBtnIdTd,user_id =''){
		$.ajax({
			url: 'getSampleCollectorDropdown',
			type: 'POST',
			data: {user_id:user_id,order_id:order_id,count:count,date:date,slot:slot},
			dataType: 'json',
			success: function (result) {
				if (result.status == 200){
					$("#"+btnId).hide();
					$("#"+nurseBtnIdTd).html(result.body);
					// $("#"+id).modal("show");
					// $("#divOrderTableAllocation").html(result.orderTableAllocation);
				}else{
					app.errorToast(result.body);
				}
			},
		});
	}

	function setAllocationValue(checkBoxId,selectId,orderId,selectInputId,date,slot){
		let sampleCollector = $("#"+selectInputId).val();
		let onClickFunction = `userAllocateToOrder('${selectId}','${orderId}','${sampleCollector}','${selectInputId}','${date}','${slot}')`;
		$("#"+checkBoxId).attr("onclick",onClickFunction);
	}	

	function userAllocateToOrder(selectId,orderId,sampleCollector,selectInputId,date,slot) {
		$.ajax({
			url: 'SetOrderAllocationToSampleCollector',
			type: 'POST',
			data: {orderId: orderId,sampleCollector:sampleCollector},
			dataType: 'json',
			success: function (result) {
				if (result.status == 200){
					// $('.close').click();
					getOrdersTimeSlots();
					getScheduleOrders('modalOrderAllocation',slot,date,'');
					// getOrdersForAllocation();
					app.successToast(result.body);
					// closeModal("modalOrderAllocation");
					// getOrdersTimeSlots();
				}else{
					app.errorToast(result.body);
				}
			},
		});
		// console.log("test");
	}


	function closeModal(id){
		$("#"+id).modal("hide");
	}
</script>
