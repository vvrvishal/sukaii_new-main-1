<?php $this->load->view("./layout/header"); ?>
<!--<script src="https://www.google.com/recaptcha/enterprise.js?render=6LfiOiwgAAAAAEAekCYi91JBOtZDCZoMTj-raQpC"></script>-->
<!--<script>-->
<!--	grecaptcha.enterprise.ready(function() {-->
<!--		grecaptcha.enterprise.execute('6LfiOiwgAAAAAEAekCYi91JBOtZDCZoMTj-raQpC', {action: 'login'}).then(function(token) {-->
<!--		...-->
<!--		});-->
<!--	});-->
<!--</script>-->
<script type="text/javascript">
	var onloadCallback = function () {
		grecaptcha.render('html_element', {
			'sitekey': '6LeAdSwgAAAAABEujYqVpG7UuVqPzTgL5sSGIkqR'

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

</style>

<div class="container">
	<div class="row mt-3">
		<div class="col-9 pl-0 m-auto">
			<h4 class="border-bottom border-dark font-weight-bold pb-1 pl-4 sukaii_pink_color"
				style="font-family: var(--primaryText);">SAMPLE COLLECTORS</h4>
			<p class="pl-4 small normal_text" style="font-family: var(--secondryText);">At Sukaii, we respect your time
				and efforts. We know you deserve the best, so we strive to give you the best.</p>
		</div>
		<div class="col-3">
			<img src="<?= base_url('assets/sukaii_icons/Partner-with-us.png') ?>"
				 class="position-absolute parternerWsImages" alt="">
		</div>
	</div>
</div>
<div class="container px-4">
	<!-- form section inside a sample collector with us  -->
	<div class="row">
		<div class="col-md-8 col-12 m-md-auto">
			<form class="mt-3" id="SampleController_form" method="post" enctype="multipart/form-data">
				<input type="hidden" name="sampleId" id="sampleId">
				<div class="form-group mb-2">
					<label class="pwuFormlabel">NAME</label>
					<input type="text" class="form-control pwuForminput" name="name_input" placeholder="Name"
						   id="name_input" required>
				</div>
				<div class="form-group mb-2">
					<label class="pwuFormlabel">E-MAIL</label>
					<input type="email" class="form-control pwuForminput" name="email_input" placeholder="E-mail"
						   id="email_input">
				</div>
				<div class="form-group mb-2">
					<label class="pwuFormlabel">PHONE</label>
					<input type="number" class="form-control pwuForminput" name="phone_input" placeholder=" Phone"
						   id="phone_input">
				</div>
				<div class="form-group mb-2">
					<label class="pwuFormlabel">ADDRESS</label>
					<textarea name="sampleCollectorAddress" id="sampleCollectorAddress"
							  class="form-control pwuForminput" placeholder="Address"></textarea>
				</div>
				<div class="form-group mb-2">
					<label class="pwuFormlabel">ID PROOF</label>
					<input type="file" class="form-control pwuForminput" name="Proof" accept="" id="IDProof">
				</div>
				<div class="submitpwuForm text-center mt-4 mb-3">
					<input class="btn btn-sm font-weight-bold px-3 sukaii_pink_bgcolor text-center text-light"
						   type="button" id="submit" value="Save changes">
				</div>
			</form>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="pwusuccess" tabindex="-1" role="dialog" aria-labelledby="pwusuccess" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="m-auto modal-content w-75" style="background-color: var(--themeGreen);">
			<div class="modal-body">
				<h5 class="font-weight-bold text-center sukaii_pink_color" style="font-family: var(--primaryText);">
					THANK YOU !</h5>
				<p class="text-center text-light" style="font-family: var(--secondryText);">for enquiring with us. We
					shall connect with you shortly</p>
			</div>
		</div>
	</div>
</div>
<script>



	$("#submit").click(function () {
		let formd = document.getElementById('SampleController_form');
		let formData = new FormData(formd);
		$.ajax({
			url: "<?php echo base_url('OrdersController/SampleCollectorDetails'); ?>",
			async: true,
			cache: false,
			data: formData,
			dataType: "json",
			method: "post",
			contentType: false,
			processData: false,
			success: function (data) {

				var html = '';
				var i;
				for (i = 0; i < data.length; i++) {
					html += '<tr>' +
							'<td>' + data[i].name + '</td>' +
							'<td>' + data[i].email + '</td>' +
							'<td>' + data[i].mobile + '</td>' +
							'<td>' + data[i].address + '</td>' +
							'<td style="text-align:right;">' +
							'<a href="javascript:void(0);" class="btn btn-info btn-sm item_edit" data-product_code="' + data[i].product_code + '" data-product_name="' + data[i].product_name + '" data-price="' + data[i].product_price + '">Edit</a>' + ' ' +
							'<a href="javascript:void(0);" class="btn btn-danger btn-sm item_delete" data-product_code="' + data[i].product_code + '">Delete</a>' +
							'</td>' +
							'</tr>';
				}
				show_data();
			}
		});
		$('#SampleController_form')[0].reset();
	});

	function editForm(id) {
		$("#sampleId").val(id);
		$.ajax({
			url: "<?php echo site_url('OrdersController/editSampleCollector'); ?>",
			async: true,
			method: 'post',
			data: {id: id},
			dataType: 'json',
			success: function (data) {
				console.log(data);
				var html = '';
				// var msg = 'Data updated successfully..';
				var i;
				for (i = 0; i < data.length; i++) {
					html += '<input type="text" name="name_input" value="' + data[i].name + '">' +
							$("#name_input").val(data[i].name);
					//'<select></select><td>'+data[i].mode+'</td>'+
					$("#email_input").val(data[i].email);
					$("#phone_input").val(data[i].mobile);
					$("#sampleCollectorAddress").val(data[i].address);
					$("#IDProof").val(data[i].IDProof);
					html += '<input type="submit" id="submit" value="submit">';
					$("#submit").prop('id', 'update');
					// '<td>'+data[i].comments+'</td>'+
					$("#SampleController_form").val(html);
				}
				// $("#message").html(msg).fadeOut(4000);
			}
		});
		// return false;
		// $('#feedbackform')[0].reset();
	}


</script>
<?php $this->load->view("./layout/footer"); ?>
