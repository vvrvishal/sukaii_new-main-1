<?php $this->load->view('layout/header'); ?>
<div class="container">

</div>
<div class="container">
	<form id="formFileUpload" method="POST" enctype="multipart/form-data">
		Select image to upload:
		<input type="file" name="fileToUpload[]" id="fileToUpload">
		<input type="button" value="Upload" name="uploadExcelFile" id="uploadExcelFile">
	</form>
</div>

<?php $this->load->view('layout/footer'); ?>

<script>
	$(document).ready(function () {
		$("#uploadExcelFile").click(function () {
			let formData = document.getElementById("formFileUpload");
			$.ajax({
				url: baseURL + 'fileToUpload',
				type: "POST",
				processData: false,
				contentType: false,
				async: false,
				cache: false,
				data: new FormData(formData),
				dataType: "json",
				success: function (resp) {
					console.log(resp);
					if (resp.status === 200) {
						app.successToast(resp.msg);
						// window.location.href = baseURL + 'viewPaymentReciept/' + resp.order_id;
					} else {
						app.errorToast(resp.msg);
						window.location.href = baseURL;
					}
				},
				fail:function (error) {
					console.log(error);
				}
			});
		})
	})
</script>
