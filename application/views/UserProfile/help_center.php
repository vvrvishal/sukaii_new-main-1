<?php $this->load->view("./layout/header");?>
<style>
	textarea[placeholder="Please tell us your issue"]{
		font-size: 14px;
	}
.container{
		width: 60%;
	}
	@media only screen and (max-width: 700px)  {
		.container{
		width: unset;
	}
	}
</style>
<div class="container pt-3 pb-2" style="border-bottom: 2px solid gray;">
	<div class="row">
		<div class="align-items-center col-12 d-flex justify-content-between small" style="font-family: var(--primaryText);">
			<div class="test_name d-flex">
				<span><a href="<?=$_SERVER['HTTP_REFERER']?>" class="text-dark">   <i class="fa-solid fa-left-long pr-3"></i></a></span>
				<h6 style="font-size: .9rem;" class="mb-0 font-weight-bold">Help Center</h6>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row pt-3" style="font-size:smaller">
		<div class="col-12 ">
			<p class="normal_text">We would request you write  your query or concern with us or connect to us via Line ID.
			</p>
			<textarea name="helpCenterIssue" placeholder="Please tell us your issue" id="helpCenterIssue" class="form-control" required></textarea>
		</div>
	</div>
</div>
<!-- Button trigger modal -->
<div class="mt-5 text-center">
	<button type="button" class="btn btn-sm font-weight-bold px-3 sukaii_pink_bgcolor text-center text-light" id="sendIssue">Send</button>
</div>

<!-- Modal -->
<!-- <div class="modal fade" id="help_confirm" tabindex="-1" role="dialog" aria-labelledby="help_confirm" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="m-auto modal-content w-75" style="background-color: var(--themeGreen);">
			<div class="modal-body">
				<h5 class="font-weight-bold text-center sukaii_pink_color" style="font-family: var(--primaryText);">Your massage send Successfuly</h5>
				<p class="text-center text-light" style="font-family: var(--secondryText);">We will Connect with you as soon as possible</p>
			</div>
		</div>
	</div>
</div> -->
<?php $this->load->view("./layout/footer");?>
<script>
	$("#sendIssue").click(function(){
		
		var issueText  = $("#helpCenterIssue").val();
		$.ajax({
        url: baseURL + 'sendIssue',
        async: true,
        method: 'post',
        data: { issueText: issueText },
        dataType: 'json',
        success: function(data) {
            if(data.status===202){
				app.errorToast(data.body);
				$("#help_confirm").hide();
			}
			else if(data.status===200){
				app.successToast(data.body);
				// $("#sendIssue").attr('data-target','#help_confirm');
				// $("#help_confirm").modal("show");
			}
			else{
				app.errorToast(data.body);
			}
        }
    });
	});
	
</script>
