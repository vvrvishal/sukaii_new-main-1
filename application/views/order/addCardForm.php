<?php $this->load->view("./layout/header"); ?>
<style>
	#map #infowindow-content {
		display: inline;
	}

	.pac-controls {
		display: inline-block;
		padding: 5px 11px;
	}

	.pac-controls label {
		font-size: 13px;
		font-weight: 300;
	}

	#pac-input {
		border-top-right-radius: 0px;
		border-bottom-right-radius: 0px;
	}

	#pac-input:focus {
		border-color: none !important;
	}

	#title {
		font-size: 22px;
		font-weight: 500;
		padding: 17px 19px 7px;
	}

	::placeholder {
		font-size: 12px;
	}

	#curr {
		border-bottom-left-radius: 0px;
		border-top-left-radius: 0px;
	}
	.cardDetail{
		width: 40%;
    box-shadow: 1px 1px 9px lightgrey;
	}
</style>

<form id="save_customer_address" class="m-auto mt-md-5 py-3 rounded" method="post">
	<div class="container">
		<input type="text" id="cardHolderName" name="cardHolderName" class="form-control mb-2" placeholder="Card Holder Name">
		<input type="number" id="cardNumber" name="cardNumber" class="form-control mb-2" placeholder="cardNumber">
		<input type="date" id="cardExpiry" name="cardExpiry" class="form-control mb-2" placeholder="Card Expiry Date">

		<select name="cardType" id="cardType" class="form-control">
			<option value="">Please select card type</option>
			<option value="Debit">Debit</option>
			<option value="Credit">Credit</option>
		</select>
	</div>
	<div class="save_address text-center">
		<button type="button" onclick="addCard();" class="px-3 btn btn-light btn-sm" style="margin-top: 4rem; background-color: var(--themePink); color: white; border-radius: 6px;"><b>Save Card</b></button>
	</div>
</form>

<?php $this->load->view("./layout/footer"); ?>
<script>
	function addCard(){
		let formData = new FormData();
		formData.set("cardHolderName",$("#cardHolderName").val());
		formData.set("cardNumber",$("#cardNumber").val());
		formData.set("cardExpiry",$("#cardExpiry").val());
		formData.set("cardType",$("#cardType").val());
		app.request("addCardDetails",formData).then(response=>{
			if(response.status == 200){
				// app.successToast(response.body);
				// location.reload();
				window.location.href = baseURL+'previousPayment';
				// loadDetails();
			}else{
				// location.reload();
				app.errorToast(response.status);
			}
		}).catch(error=>{
			console.log(error);
		})
	}

</script>
