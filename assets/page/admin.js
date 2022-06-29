function loadDetails(filterColumn = '', filterValue = '') {
    app.dataTable("tableOrderDetails", {
        url: baseURL + "getAllOrders",
        type: 'POST',
        data: { filterColumn: filterColumn, filterValue: filterValue }
    }, [{
            data: 'order_id'
        },
        {
            data: 'patient_name'
        },
        {
            data: "service_name"
        },
        {
            data: "schedule_time",
            render: (d, t, r, m) => {
                return `${r["schedule_date"]} - ${r["schedule_time"]}`
            }
        },
        {
            data: "location"
        },

        {
            data: "payment_mode",
            render: (d, t, r, m) => {
                if (d === "COD") {
                    return "<span class='badge badge-info'>COD</span>";
                } else {
                    return "<span class='badge badge-primary'>Card Payment</span>";
                }
            }
        },
        {
            data: "status",
            render: (d, t, r, m) => {
                let status = "";
                switch (parseInt(d)) {
                    case 1:
                    case 5:
                        status = "<span class='badge badge-danger'>Pending</span>";
                        break;
                    case 2:
                        status = "<span class='badge badge-success'>Completed</span>";
                        break;
                    case 3:
                        status = "<span class='badge badge-danger'>Cancel</span>";
                        break;
                    case 4:
                        status = "<span class='badge badge-danger'>Payment Failed</span>";
                        break;
                    case 6:
                    case 7:
                        status = "<span class='badge badge-info'>On Going</span>";
                        break;
                }
                return status;
            }
        },
        {
            data: "id",
            render: (d, t, r, m) => {
                let status = parseInt(r["status"]);
                if (status === 6) {
                    return `<button class="btn btn-behance btn-sm px-2 py-1 rounded-1" onclick="generateOtp(${d})">OTP</button>
							<button class="btn btn-danger btn-sm px-2 py-1 rounded-1" onclick="cancelAllocation(${d})"><i class="fa-solid fa-user-plus" style="margin-right: 0;"></i></button>
                        </div>`;
                } else {
                    return ``;
                }
            }
        },
        // <button class="btn btn-sm" disabled>Order Not Allocated</button>
        //                 </div>
        {
            data: "order_id",
            render: (d, t, r, m) => {
                let status = parseInt(r["status"]);
                // if (status === 1 || status === 5) {
                if (status === 7) {
                    return `
					<div class="align-items-end d-flex justify-content-end px-1">
						<form id="report_file_${d}" class="d-flex">
							<input type="file" name="report_file[]" id="report_${d}" class="d-none" onchange="reportFileUpload('${d}')" />
							<input type="hidden" name="order_id" id="order_id_${d}"  value="${d}" />
							<input type="hidden" name="patient_id" id="patient_id_${d}"  value="${r['patient_id']}" />
							
							<button type="button" class="btn btn-inverse-dark p-1" onclick="document.getElementById('report_${d}').click()"><i style="padding:5px;margin-right:0px;" class="mdi mdi-upload-multiple"></i></button>
							<button type="submit" id="report_btn_file_${d}" class="btn btn-inverse-dark px-2 py-1 btn-sm d-none"></button>
						</form>
						<button type="button" class="btn btn-inverse-dark px-2 py-1 rounded-3" style="margin-left:7px;"
						 onclick="deleteServiceOrder('${d}')"><i class="mdi mdi-delete"  style="margin-right:0px !important"></i></button>
					</div>`
                } else if (status === 2) {
                    return `
					<div class="btn btn-group float-end p-1">
					  <a href="${baseURL+"viewReciept/"+d+"/"+r['patient_id']}" class="btn btn-group btn-inverse-dark px-2 py-1 rounded-3" target="_blank"><i class="mdi mdi-download" style="margin-right: 0;"></i></a>					
				    </div>`
                } else {
                    return `
					<div class="align-items-end d-flex justify-content-end px-1">                   	  						
						<button class="btn btn-inverse-dark px-2 py-1 rounded-3" style="margin-left:7px;" onclick="deleteServiceOrder('${d}')"><i class="mdi mdi-delete" style="margin-right:0px !important"></i></button>
					</div>`
                }
            }
        },


    ], () => {

    });
    // $.fn.dataTable.ext.errMode = 'throw';
}


function loadFormValidation(id) {

    app.validation("report_file_" + id, {
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
}

function reportFileUpload(id) {
    // $("#report_file_"+id).
    let formData = document.getElementById("report_file_" + id);
    $.ajax({
        url: baseURL + 'fileToUpload',
        type: "POST",
        processData: false,
        contentType: false,
        async: false,
        cache: false,
        data: new FormData(formData),
        dataType: "json",
        success: function(resp) {
            console.log(resp);
            if (resp.status === 200) {
                updateOrderStatusOnUpload(id);
                loadDetails();
                app.successToast(resp.msg);
                reportUploadNotification(`${resp.order_id}`);
                // window.location.href = baseURL + 'viewPaymentReciept/' + resp.order_id;
            } else {
                app.errorToast(resp.msg);
                window.location.href = baseURL;
            }
        },
        fail: function(error) {
            console.log(error);
        }
    });
}

function reportUploadNotification(order_id) {
    $.ajax({
        url: baseURL + 'fileUploadNotification',
        type: "POST",
        data: { order_id: order_id },
        dataType: "json",
        success: function(resp) {
            console.log(resp);
            return false;
            if (resp.status === 200) {
                return true;
            } else {
                return false;
            }
        },
        fail: function(error) {
            console.log(error);
        }
    });
}

function updateOrderStatusOnUpload(id) {
    let formData = document.getElementById("report_file_" + id);
    $.ajax({
        url: baseURL + 'updateOrderStatusOnUpload',
        type: "POST",
        data: { orderID: id },
        dataType: "json",
        success: function(resp) {
            console.log(resp);
            if (resp.status === 200) {
                // app.successToast(resp.msg);
                // window.location.href = baseURL + 'viewPaymentReciept/' + resp.order_id;
            }
        },
        fail: function(error) {
            console.log(error);
        }
    });
}

function deleteServiceOrder(orderId) {
    let formData = new FormData();
    formData.set("id", orderId)
    app.request("deleteOrder", formData).then(response => {
        if (response.status === 200) {
            app.successToast(response.body);
            loadDetails('active_status','1');
        } else {
            app.errorToast(response.body)
        }
    })
}

function loadUserDetails() {
    app.dataTable("tableUserDetails", {
        url: baseURL + "getAllUser",
    }, [{
            data: 'name'
        },
        {
            data: 'email'
        },
        {
            data: "contact"
        },
        {
            data: "gender"
        },
        {
            data: "registration_type",
            render: (d, t, r, m) => {
                return d === "2" ? 'Google' : d === "1" ? 'Direct' : 'Facebook';

            }
        },
        {
            data: "create_on"
        },
        {
            data: "id",
            render: (d, t, r, m) => {
                return `<button class="btn btn-inverse-dark p-2" onclick="deleteUser(${d})"><i style="margin-right: 0;" class="fa fa-trash text-dark"></i></button>`;

            }
        },

    ], () => {

    });
}
//sample collector
function loadSampleDetails() {
    app.dataTable("collectorTable", {
        url: baseURL + "getSampleData",
    }, [{
            data: 'name'
        },
        {
            data: 'email'
        },
        {
            data: "username"
        },
        {
            data: "password"
        },
        {
            data: "mobile"
        },
        {
            data: "address"
        },
        {
            data: "locationName"
        },
        {
            data: "id_proof",
            render: (d, t, r, m) => {
                if (d !== "" && d !== null) {
                    return `<a class="btn btn-link btn-sm" href="${baseURL + "/" + d}" target="_blank" download><i class="fa fa-download"></i></a>`;
                } else {
                    return `-`;
                }

            }
        },
        {
            data: "id",
            render: (d, t, r, m) => {
                return `<div class="btn btn-action"><button class="btn btn-link btn-sm" onclick="editForm(${d})"><i class="fa fa-pencil text-primary"></i></button>
				<button class="btn p-2" style="background: gainsboro;" onclick="deleteSampleRecord(${d})"><i class="d-flex fa fa-trash justify-content-center" style=" margin-right: 0;"></i></button>
						</div>`;

            }
        },


    ], () => {

    });
}

function showForm() {
    document.getElementById('id01').style.display = 'block'
    $("#sampleId").val("");
    loadFormValidation();
}

function editForm(id) {
    document.getElementById('id01').style.display = 'block'
    let data = new FormData();
    data.set("id", id);
    $("#sampleId").val(id);
    app.request("getSampleCollector", data).then(response => {
        if (response.status === 200) {

            $("#name_input").val(response.body[0].name);
            $("#email_input").val(response.body[0].email);
            $("#password_input").val(response.body[0].password);
            $("#phone_input").val(response.body[0].mobile);
            $("#sampleCollectorAddress").val(response.body[0].address);
            let value = response.body[0].locationids;
            value = value.split(',');
            $("#allocated_location").val(value);
            $('#allocated_location').select2().trigger('change');
        }
    }).catch(error => console.log(error))
    loadFormValidation();
}

function deleteSampleCollector(id) {
    let text = "Are you sure want to delete.";
    if (confirm(text) == true) {
        let formData = new FormData();
        formData.set('id', id);
        app.request("deleteSampleCollector", formData).then(response => {
            if (response.status === 200) {
                app.successToast(response.body);
                loadSampleDetails();
            } else {
                app.errorToast(response.body);
            }
        }).catch(error => {
            console.log(error)
            app.errorToast("Something went wrong")
        });
    }
}

function loadFormValidation() {
    app.validation("SampleController_form", {
        name_input: 'required',
        email_input: 'required',
        password_input: 'required',
        phone_input: 'required',
    }, {
        name_input: 'Enter name',
        email_input: 'Enter email',
        password_input: 'Enter password',
        phone_input: 'Enter phone',
    }, (form) => {
        saveSampleCollector(new FormData(form))
    }, function(error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error)
        } else {
            error.insertAfter(element);
        }
    });
}

function deleteUser(id) {
    let text = "Are you sure want to delete.";
    if (confirm(text) == true) {
        let formData = new FormData();
        formData.set('id', id);
        app.request("deleteUser", formData).then(response => {
            if (response.status === 200) {
                app.successToast(response.body);
                loadUserDetails();
            } else {
                app.errorToast(response.body);
            }
        }).catch(error => {
            console.log(error)
            app.errorToast("Something went wrong")
        });
    }
}

function saveSampleCollector(form) {

    app.request("saveSampleCollector", form).then(response => {
        if (response.status === 200) {
            loadSampleDetails()
            document.getElementById('id01').style.display = 'none'

            $("#SampleController_form").trigger("reset");

            app.successToast(response.body);
        } else if(response.status === 202){
            app.errorToast(response.body);
        }
        else{
            app.errorToast(response.body);
        }
    }).catch(error => {
        console.log(error)
        app.errorToast("Something went wrong")
    })
}


function deleteSampleRecord(id) {
    let text = "Are you sure want to delete.";
    if (confirm(text) == true) {
        let formData = new FormData();
        formData.set('id', id);
        app.request("deleteSampleRecord", formData).then(response => {
            if (response.status === 200) {
                app.successToast(response.body);
                loadSampleDetails();
            } else {
                app.errorToast(response.body);
            }
        }).catch(error => {
            console.log(error)
            app.errorToast("Something went wrong")
        });
    }
}

function generateOtp(id) {
    var otp = Math.floor(100000 + Math.random() * 900000);
    $.ajax({
        url: baseURL + 'saveOtp',
        async: true,
        method: 'post',
        data: { otp: otp, id: id },
        dataType: 'json',
        // success: function (data) {
        // 	if(data.status==200){
        // 		$("#otp").html(otp);
        // 		modal.style.display = "block";
        // 	}
        // 	else{
        // 		app.errorToast("Something went wrong")
        // 	}
        // }
        success: function(data) {

            $("#viewOTPModel").modal('show');
            $("#otpOrderId").text(data.order_id);
            $("#otpDisplay").text(otp);
            $("#otpPatientName").text(data.patientName);
            // console.log(data);
        }
    });
    $("#id01").html("Otp for id " + id + "is " + otp);
    return otp;

}

function cancelAllocation(orderPrimaryId) {
    if (confirm('Are you sure you want to cancel Allocation for this order?')) {
        $.ajax({
            url: baseURL + 'cancelOrderAllocation',
            async: true,
            method: 'post',
            data: { orderPrimaryId: orderPrimaryId },
            dataType: 'json',
            success: function(data) {
                if (data.status === 200) {
                    loadDetails();
                    app.successToast(data.body);
                } else {
                    loadDetails();
                    app.errorToast(data.body);
                }
            }
        });
    } else {
        return false;
    }


}
