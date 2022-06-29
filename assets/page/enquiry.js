app.validation("enquiryForm",
	{
		enquiry_person_name: 'required',
		enquiry_person_mobile: 'required',
		enquiry_location_value: 'required',
		enquiry_services: 'required',
	}, {
		enquiry_person_name: 'Enter full name',
		enquiry_person_mobile: 'Enter mobile number',
		enquiry_location_value: 'Select location',
		enquiry_services: 'Select service',
	}, (form) => {
		app.request("save_enquiry", new FormData(form)).then(response => {
			if (response.status === 200) {
				$("#enquiry_book_now").click();
				$("#enquiryForm").trigger("reset");
			} else {
				app.errorToast(response.body);
			}
		}).catch(error => {
			console.log(error)
			app.errorToast("Something went wrong")
		})
	},function(error, element) {
		var placement = $(element).data('error');
		if (placement) {
			$(placement).append(error)
		} else {
			error.insertAfter(element);
		}
	});


function setEnquiryLocation(event,value) {
	$("#enquiry_location_value").val(value);
	$(".bankok_city.activeSelection").removeClass("activeSelection text-light");
	$(event).addClass("activeSelection text-light");
	$("#enquiry_ddvalue").slideToggle();
}

function setEnquiryService(event,value) {
	$("#enquiry_services").val(value);
	$(".enquiry_service.activeSelection").removeClass("activeSelection text-light");
	$(event).addClass("activeSelection text-light");
	$("#enquiry_dd_service_value").slideToggle();
}

$("#enquiry_location").click(function() {
	$("#enquiry_ddvalue").slideToggle();
});

$("#enquiry_service").click(function() {
	$("#enquiry_dd_service_value").slideToggle();
});
