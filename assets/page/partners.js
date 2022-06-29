function getServicesValue(event,value) {
	$("#company_services_input").val(value);
	$(".serviceValue.activeSelection").removeClass("activeSelection text-light");
	$(event).addClass("activeSelection text-light");
	$("#pws_dd_service_value").slideToggle();

}

app.validation("partner_form",
	{
		name_input: 'required',
		Company_name_input: 'required',
		company_email_input: 'required',
		company_phone_input: 'required',
		// company_services_input: 'required',
	}, {
		name_input: 'Enter Name',
		Company_name_input: 'Enter company name',
		company_email_input: 'Enter company email',
		company_phone_input: 'Enter company phone',
		// company_services_input: 'Select Services',
	}, (form) => {
		let captcha = grecaptcha.getResponse();
		if(captcha.length) {
			partnersSubmit(form);
			grecaptcha.reset();
		}

	});

function partnersSubmit(form) {
	app.request("addPartners", new FormData(form)).then(response => {
		if (response.status === 200) {
			$("#successPartner").click();
			$("#partner_form").trigger("reset");
		} else {
			app.errorToast(response.body);
		}
	}).catch(error => {
		console.log(error)
		app.errorToast("Something went wrong")
	})
}
