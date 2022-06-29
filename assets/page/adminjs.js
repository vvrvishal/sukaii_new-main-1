function loadAllEnquiries() {
    app.dataTable("tableUserEnquiryDetails", {
        url: baseURL + "getAllEnquiries",
    }, [{
            data: 'name'
        },
        {
            data: 'mobile'
        },
        {
            data: 'email'
        },
        {
            data: 'services'
        },
        {
            data: 'location'
        },
        {
            data: "id",
            render: (d, t, r, m) => {
                return `<button class="btn p-2" style="background: gainsboro;" onclick="deleteEnquiry(${d})"><i class="d-flex fa fa-trash justify-content-center" style=" margin-right: 0;"></i></button>`;

            }
        },

    ], () => {

    });
}

function loadAllPartner() {
    app.dataTable("tablePartnerDetails", {
        url: baseURL + "getAllPartner",
    }, [{
            data: 'name'
        },
        {
            data: 'company_name'
        },
        {
            data: 'designation'
        },
        {
            data: 'company_name'
        },
        {
            data: 'company_phone'
        },
        {
            data: 'company_services'
        },
        {
            data: 'comment'
        },
        {
            data: "id",
            render: (d, t, r, m) => {
                return `<button class="btn p-2" style="background: gainsboro;" onclick="deletePartner(${d})"><i class="d-flex fa fa-trash justify-content-center" style=" margin-right: 0;"></i></button>`;

            }
        },
    ], () => {

    });
}
// $route['getAllEnquiries'] = 'UserController/getAllEnquiries';
// $route['getAllPartner'] = 'UserController/getAllPartner';

// Delete Partner
function deletePartner(id) {
    let text = "Are you sure want to delete.";
    if (confirm(text) == true) {
        let formData = new FormData();
        formData.set('id', id);
        app.request("deletePartner", formData).then(response => {
            if (response.status === 200) {
                app.successToast(response.body);
                loadAllPartner();
            } else {
                app.errorToast(response.body);
            }
        }).catch(error => {
            console.log(error)
            app.errorToast("Something went wrong")
        });
    }
}
//Delete Enquiry
function deleteEnquiry(id) {
    let text = "Are you sure want to delete?";
    if (confirm(text) == true) {
        let formData = new FormData();
        formData.set('id', id);
        app.request("deleteEnquiry", formData).then(response => {
            if (response.status === 200) {
                app.successToast(response.body);
                loadAllEnquiries();
            } else {
                app.errorToast(response.body);
            }
        }).catch(error => {
            console.log(error)
            app.errorToast("Something went wrong")
        });
    }
}