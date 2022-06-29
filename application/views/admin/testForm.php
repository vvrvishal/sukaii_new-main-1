<?php $this->load->view("layout/admin_header"); ?>


<script type="text/javascript">
	var onloadCallback = function() {
		grecaptcha.render('html_element', {
			'sitekey': '6LcXmMoeAAAAAMeOWc27EskoFlBIFIrF-3WZEp_X'
		});
	};
</script>
<style>
	#sampleCollectorAddress[name="sampleCollectorAddress"] {
		height: 36px !important;
	}

	#sampleCollectorAddress[name="sampleCollectorAddress"]:focus {
		height: 60px !important;
	}

	#AnyQuery[name="comment_input"] {
		height: 36px !important;
	}

	#AnyQuery[name="comment_input"]:focus {
		height: 60px !important;
	}

	.activeSelection {
		background-color: #ec098d66;
	}

	.carousel_1_image {
		color: black !important;
		z-index: 10;
		position: absolute;
		top: 36%;
		left: 4%;
		font-size: 1rem;
	}

	.carousel_1_image h1 {
		font-size: 25px;
	}

	html {
		scroll-behavior: smooth;
	}

	#submit {
		background: #e8108e;
		font-weight: bold;
		border: none;
		border-radius: 3px;
	}

	.pwuFormlabel {
		font-weight: bold;
		margin-bottom: 0px;
	}

	.pwuForminput {
		color: darkgray;
		font-weight: 500;
	}
</style>
<style>
	.modal {
		display: none;
		position: fixed;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		overflow: auto;
		background-color: rgb(0, 0, 0);
		background-color: rgba(0, 0, 0, 0.4);
		padding-top: 60px;
	}

	/* Modal Content/Box */
	.modal-content {
		margin: auto;
		border: 1px solid #888;
		width: 50%;
	}

	/* The Close Button (x) */
	.close {
		position: absolute;
		right: 25px;
		top: 0;
		color: #000;
		font-size: 35px;
		font-weight: bold;
	}

	.close:hover,
	.close:focus {
		color: red;
		cursor: pointer;
	}

	/* Add Zoom Animation */
	.animate {
		-webkit-animation: animatezoom 0.6s;
		animation: animatezoom 0.6s
	}

	@-webkit-keyframes animatezoom {
		from {
			-webkit-transform: scale(0)
		}

		to {
			-webkit-transform: scale(1)
		}
	}

	@keyframes animatezoom {
		from {
			transform: scale(0)
		}

		to {
			transform: scale(1)
		}
	}

	/* Change styles for span and cancel button on extra small screens */
	@media screen and (max-width: 300px) {
		span.psw {
			display: block;
			float: none;
		}

		.cancelbtn {
			width: 100%;
		}
	}

	.pwuFormlabel {
		margin-bottom: 0px !important;
	}

	input[type="time"]::-webkit-time-picker-indicator {
		color: #0db4b7;
	}
</style>
<div class="card" style="margin-bottom:20px;">
	<div class="card-body" id="scheduler_from" style="display:none;">
		<div class="container-fluid">
			<div class="row mt-3">
				<div class=" col-12  pl-0">
					<div id="id01">
						<form class="" id="testForm" method="post" enctype="multipart/form-data">
							<div class="imgcontainer">
								<span onclick="document.getElementById('scheduler_from').style.display='none'" id="close_model" class="close" title="Close Modal">&times;</span>
							</div>

							<div class="" style="display:none;" id="newForm">
								<div class="card-tital pt-4 px-4" style="font-size: 20px; font-weight: 600;">Schedule Setup Master
								</div>
								<div class="row ">
									<div class="col-md-12 mt-2 m-auto justify-content-around" style="display:flex;padding: 6px 30px;">
										<input type="hidden" name="sampleId" id="sampleId">
										<div class="form-group col-md-2">
											<label class="pwuFormlabel">Schedule start time</label>
											<!-- <input type="text" class="form-control pwuForminput"
												   style="margin-top: 1px;margin-right:10px;" name="schedule_start_time"
												   id="schedule_start_time"> -->
											<input type="time" class="form-control pwuForminput" style="margin-top: 1px;margin-right:10px;" name="schedule_start_time" id="schedule_start_time">
										</div>
										<div class="form-group col-md-2">
											<label class="pwuFormlabel">Schedule end time</label>
											<input type="time" class="form-control pwuForminput" name="schedule_end_time" style="margin-left:10px;" id="schedule_end_time">
										</div>
										<div class="form-group col-md-2">
											<label class="pwuFormlabel">Slot duration</label>
											<input type="text" class="form-control pwuForminput" name="slot_duration" style="margin-right:10px;" id="slot_duration">
										</div>
										<div class="form-group col-md-2">
											<label class="pwuFormlabel">Per slot count</label>
											<input type="text" class="form-control pwuForminput" name="per_slot_count" style="margin-right:10px;" id="per_slot_count">
										</div>
										<!-- <div class="form-group mb-2">
											<label class="pwuFormlabel">ID PROOF</label>
											<input type="file" class="form-control pwuForminput py-2" name="IDProof[]"
												   id="IDProof">
										</div> -->
										<div class="form-group col-md-2">
											<button class="btn btn-sm rounded-1 text-light" id="saveChanges" style="margin-left:10px;margin-top: 21px;font-weight: 800;background: #0db4b7;">UPDATE</button>
										</div>
									</div>
								</div>

							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<div class="container-fluid">
			<div class="row mt-3">
				<div class="align-items-baseline col-12 d-flex justify-content-between m-auto pl-0">
					<!-- <h4 class="card-title mb-1">Test Form</h4> -->
					<!-- <button type="button" class="btn fa fa-plus btn-sm" id="openSCF"
							onclick="showTestForm()"
							style="background-color: #d9d9d9; border-radius: 4px !important;">
					</button> -->
				</div>

				<div class="col-12 mt-4">
					<div id="show_table"></div>
					<!-- <table class="table table-bordered" id="show_table">
						<thead>
						<tr>
							<th>Schedule start time</th>
							<th>Schedule end time</th>
							<th>Slot duration</th>
							<th>Per slot count</th>
						</tr>
						</thead>
						<tbody id="tableData">
								 <td><?php print_r($data->data->schedule_start_time); ?></td>
								<td><?php print_r($data->data->schedule_end_time); ?></td>
								<td><?php print_r($data->data->slot_duration); ?></td>
								<td><?php print_r($data->data->per_slot_count); ?></td>
									<td><button class="btn btn-link btn-sm" onclick="editForm()"><i class="fa fa-pencil text-primary"></i></button></td> -->
					<!-- </tbody>
					</table> -->

				</div>

			</div>
		</div>
	</div>
</div>


<?php $this->load->view("layout/admin_footer"); ?>
<script>
	$(document).ready(function() {
		// loadTestDetails();
		loadFormValidation();
		tableData();
	});

	// function showTestForm(){
	// 	document.getElementById('id01').style.display='block';
	// 	loadFormValidation();
	// }

	function loadFormValidation() {
		app.validation("testForm", {
			schedule_start_time: 'required',
			schedule_end_time: 'required',
			slot_duration: 'required',
			per_slot_count: 'required',
			status: 'required',
			// update_on:'required',
			// updated_by:'required'
		}, {
			schedule_start_time: 'Enter schedule start time',
			schedule_end_time: 'Enter schedule end time',
			slot_duration: 'Enter slot',
			per_slot_count: 'Enter per slot count',
			status: 'Enter status',
			// update_on:'Enter update on',
			// updated_by:'Enter updated by'
		}, (form) => {
			saveTestForm(new FormData(form))
		}, function(error, element) {
			var placement = $(element).data('error');
			if (placement) {
				$(placement).append(error)
			} else {
				error.insertAfter(element);
			}
		});
	}

	// heramb-test-form
	function saveTestForm(form) {
		app.request("saveFormData", form).then(response => {
			if (response.status === 200) {
				tableData();
				$("#testForm").trigger("reset");
				$("#scheduler_from").hide();
				// document.getElementById('id01').style.display='none'
				app.successToast(response.body);
			} else {
				app.errorToast(response.body);
			}
		}).catch(error => {
			console.log(error);
			app.errorToast("Something went wrong");
		})
	}

	function tableData() {
		$.ajax({
			url: "<?php echo site_url('AdminController/tableData'); ?>",
			async: true,
			method: 'post',
			dataType: 'json',
			success: function(data) {
				var html = '';
				html += '<table class="table table-bordered" border="1">' +
					'<thead><th class="text-center">Schedule Start Time</th><th class="text-center">Schedule End Time</th><th class="text-center">Slot Duration</th><th class="text-center">Per Slot Count</th><th class="text-center">Edit</th>' +
					'</thead>' +
					'<tbody><td class="text-center">' + data.body.schedule_start_time + '</td><td class="text-center">' + data.body.schedule_end_time + '</td><td class="text-center">' + data.body.slot_duration + '</td><td class="text-center">' + data.body.per_slot_count + '</td><td class="text-center"><button class="btn btn-link btn-sm" onclick="editForm()"><i class="fa fa-pencil text-primary"></i></button></td>' +
					'</tbody>' +
					'</table>';
				$("#show_table").html(html);
			}
		});
	}

	function editForm() {
		$("#newForm").show();
		$("#scheduler_from").show();
		let data = new FormData();
		// data.set("id",id);
		// $("#sampleId").val(id);
		app.request("getScheduleData", data).then(response => {
			if (response.status === 200) {
				$("#schedule_start_time").val(response.body.schedule_start_time);
				$("#schedule_end_time").val(response.body.schedule_end_time);
				$("#slot_duration").val(response.body.slot_duration);
				$("#per_slot_count").val(response.body.per_slot_count);
				$("#status").val(response.body.status);
				$("#update_on").val(response.body.update_on);
				$("#updated_by").val(response.body.updated_by);
			}
		}).catch(error => console.log(error))
		loadFormValidation();
	}

	function deleteSampleRecord(id) {
		let text = "Are you sure want to delete.";
		if (confirm(text) == true) {
			let formData = new FormData();
			// formData.set('id', id);
			app.request("deleteSampleRecord", formData).then(response => {
				if (response.status === 200) {
					app.successToast(response.body);
					// loadTestDetails();
				} else {
					app.errorToast(response.body);
				}
			}).catch(error => {
				console.log(error)
				app.errorToast("Something went wrong")
			});
		}
	}
</script>