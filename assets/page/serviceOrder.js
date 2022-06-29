app.validation("formServiceOrder",
	{
		patient_name: 'required',
		patient_number: 'required',
		serviceBookingLocation: 'required',
		pic_schedule_date_h: 'required',
		pic_schedule_time_h: 'required',
		// company_services_input: 'required',
	}, {
		patient_name: 'Enter Name',
		patient_number: 'Enter Mobile',
		serviceBookingLocation: 'Enter Location',
		pic_schedule_date_h: 'Enter Schedule Date',
		pic_schedule_time_h: 'Enter Schedule Time',

		// company_services_input: 'Select Services',
	}, (form) => {

		app.request("placeOrder", new FormData(form)).then(response => {
			if (response.status === 201) {
				location.href = baseURL+'login';
			} else {
				location.href = baseURL+'viewCart';
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

