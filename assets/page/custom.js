const app = (function () {
	const validation = (formElement, rules, message, submitHandlerFunction,errorPlacement=null) => {
		$(`#${formElement}`).validate({
			rules: rules,
			messages: message,
			ignore: [],
			errorClass: 'text-danger small',
			errorElement: 'span',
			errorPlacement:errorPlacement,
			submitHandler: submitHandlerFunction,

		});
	}

	const jsonResponse = (string) => {
		return JSON.parse(atob(string));
	}

	const request = (url, formData) => {

		return new Promise((resolve, reject) => {
			$.ajax({
				type: "POST",
				url: baseURL + url,
				dataType: "json",
				data: formData,
				processData: false,
				contentType: false,
				success: function (result) {
					resolve(result);
				}, error: function (error) {
					reject(error);
				}
			});
		});
	}


	const successToast = (message) => {
		iziToast.success({
			position: 'topRight',
			message: message,
			transitionIn: 'flipInX',
			transitionOut: 'flipOutX',
		});
	}

	const errorToast = (message) => {
		iziToast.error({
			position: 'topRight',
			message: message,
			transitionIn: 'flipInX',
			transitionOut: 'flipOutX',
		});
	}

	const dataTable = (elementID, ajax = undefined, column = undefined, rowRenderCallback = undefined, initCompleteCallback = undefined) => {
		if (elementID !== undefined) {
			let object = {
				destroy: true,
				processing: true,
				serverSide: true,
				order: [],
				"pagingType": "simple_numbers",
			};

			if (ajax !== undefined) {
				var ajaxObject = {};
				if (ajax.hasOwnProperty('data'))
					ajaxObject.data = ajax.data;
				if (ajax.hasOwnProperty('url')) {
					ajaxObject.url = ajax.url;
					ajaxObject.type = "POST";
				}
				object.ajax = ajaxObject;
			}

			if (rowRenderCallback !== undefined)
				object.fnRowCallback = rowRenderCallback;

			if (initCompleteCallback !== undefined)
				object.initComplete = initCompleteCallback

			if (column !== undefined)
				object.columns = column

			$.fn.DataTable.ext.pager.numbers_length = 4;
			$(`#${elementID}`).DataTable(object);
		}
	}

	const dataTableResponsive = (elementID, ajax = undefined, column = undefined, rowRenderCallback = undefined, initCompleteCallback = undefined) => {
		if (elementID !== undefined) {
			let object = {
				destroy: true,
				responsive: true,
				processing: true,
				serverSide: true,
				order: [],
				"pagingType": "simple_numbers",
			};

			if (ajax !== undefined) {
				var ajaxObject = {};
				if (ajax.hasOwnProperty('data'))
					ajaxObject.data = ajax.data;
				if (ajax.hasOwnProperty('url')) {
					ajaxObject.url = ajax.url;
					ajaxObject.type = "POST";
				}
				object.ajax = ajaxObject;
			}

			if (rowRenderCallback !== undefined)
				object.fnRowCallback = rowRenderCallback;

			if (initCompleteCallback !== undefined)
				object.initComplete = initCompleteCallback

			if (column !== undefined)
				object.columns = column

			$.fn.DataTable.ext.pager.numbers_length = 4;
			$(`#${elementID}`).DataTable(object);
		}
	}

	return {
		jsonResponse: (string) => jsonResponse(string),
		dataTableResponsive: (elementID, ajax = undefined, column = undefined, rowRenderCallback = undefined, initCompleteCallback = undefined) => dataTableResponsive(elementID, ajax, column, rowRenderCallback, initCompleteCallback),
		dataTable: (elementID, ajax = undefined, column = undefined, rowRenderCallback = undefined, initCompleteCallback = undefined) => dataTable(elementID, ajax, column, rowRenderCallback, initCompleteCallback),
		successToast: (message) => successToast(message),
		errorToast: (message) => errorToast(message),
		request: (url, formData) => request(url, formData),
		validation: (formElement, rules, message, submitHandlerFunction,errorPlacement) => validation(formElement, rules, message, submitHandlerFunction,errorPlacement),
	}

})();
