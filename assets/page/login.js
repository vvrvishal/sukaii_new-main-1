app.validation("loginForm", {
	email: 'required',
	password: 'required',
	// company_services_input: 'required',
}, {
	email: 'Enter Name',
	password: 'Enter Password',
	// company_services_input: 'Select Services',
}, (form) => {
	loginVerification(new FormData(form))
});

function loginVerification(form) {
	app.request("loginVerification", form).then(response => {
		if (response.status === 200) {
			if (parseInt(response.userType) == 2) {
				let redirect = document.getElementById("redirectTo").value;
				if (redirect !== "" && redirect != undefined) {
					location.href = baseURL +"/serviceOrder/"+redirect;
				} else {
					location.href = baseURL;
				}
			}else if (parseInt(response.userType) == 3) {
				// let redirect = document.getElementById("redirectTo").value;
				// if (redirect !== "") {
					location.href = baseURL +"sampleCollectersOrders";
				// } else {
				// 	location.href = baseURL;
				// }
			}else{
				location.href = baseURL + 'dashboard';
			}

		} else {
			app.errorToast(response.body);
		}
	}).catch(error => {
		console.log(error)
		app.errorToast("Something went wrong")
	})
}

let googleUser = {};
let startApp = function () {
	gapi.load('auth2', function () {
		auth2 = gapi.auth2.init({
			// client_id: '960428125912-9933haipr2vv5e6l0vck7ssgmubr3fdh.apps.googleusercontent.com',
			client_id: '757389060404-srpfa7j2cc7jbodjjcqc6p9co6fbmogr.apps.googleusercontent.com',
			cookiepolicy: 'single_host_origin',
		});
		auth2.isSignedIn.listen(getUser);
		attachSignin(document.getElementById('customBtn'));
	});
};

function attachSignin(element) {
	console.log(element.id);
	auth2.attachClickHandler(element, {},
		function (googleUser) {
			let form = new FormData();
			form.set("email", googleUser.getBasicProfile().getEmail())
			form.set("name", googleUser.getBasicProfile().getName());
			form.set("token_id", googleUser.getBasicProfile().getId())
			form.set("registrationType", 2);
			loginVerification(form)
		},
		function (error) {
			console.log(JSON.stringify(error, undefined, 2));
			// app.errorToast("Something went wrong.")
		});
}

function getUser() {
	if (auth2.isSignedIn.get()) {
		const profile = auth2.currentUser.get().getBasicProfile();
		console.log('ID: ' + profile.getId());
		console.log('Full Name: ' + profile.getName());
		console.log('Given Name: ' + profile.getGivenName());
		console.log('Family Name: ' + profile.getFamilyName());
		console.log('Image URL: ' + profile.getImageUrl());
		console.log('Email: ' + profile.getEmail());
		let form = new FormData();
		form.set("email", profile.getEmail());
		form.set("token_id", profile.getId());
		form.set("name", profile.getName());

		form.set("registrationType", 2);
		// loginVerification(form)

	}
}

function signOut() {
	const auth2 = gapi.auth2.getAuthInstance();
	auth2.signOut().then(function () {
		console.log('User signed out.');
	});
}

startApp();
