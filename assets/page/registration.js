$("#gender").click(function () {
	$("#gender_value").slideToggle();
});

function genderValue(event,gender) {
	$("#gender").val(gender);
	$(".genderValue.activeSelection").removeClass("activeSelection text-light");
	console.log($(event));
	$(event).addClass("activeSelection text-light");
	$("#gender_value").slideToggle();

}






app.validation("registration_form",
	{
		full_name: 'required',
		email: 'required',
		mobile: 'required',
		gender: 'required',
		password: {
			required:true,
			minlength : 5
		},
		cmf_password: {
			required: true,
			minlength : 5,
			equalTo: "#password"
		}
		// company_services_input: 'required',
	}, {
		full_name: 'Enter Name',
		email: 'Enter email',
		mobile: 'Enter mobile',
		gender: 'Select gender',
		password: {
			required:'Enter password',
		},
		cmf_password:{
			required:'Enter Confirm Password'
		}
		// company_services_input: 'Select Services',
	}, (form) => {

		app.request("registerUser", new FormData(form)).then(response => {
			if (response.status === 200) {
				console.log(response);
				location.href=baseURL;
				app.successToast(response.body);
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
