function setAddressName(evnt) {
    $("#address_name_h").val(evnt.value);
}

$("#save_as_other").click(function() {
    $("#address_name").show();
    $("#address_name_h").val("");
});
$("#save_as_home").click(function() {
    $("#address_name").hide();
    $("#address_name_h").val("Home");
});


function process() {
	let backToPath = $("#backToPage").val();
    let length = $(".selected_address:checked").length;
    if (length > 1) {
        app.errorToast("Select One Address")
    }
    else if(length == 0){
        app.errorToast("Please select Atleast One Address")
    }
     else {
        let address = $(".selected_address:checked").val();
        // if (backToPath == "serviceOrder") {
            location.href = baseURL + "orderSummary/" + address;
        // } else {
            // location.href = baseURL + "create_address"; 
        // }
    }
}

let lat = 19.0717674;
let lng = 73.0016072;

function initMap() {
    const map = new google.maps.Map(document.getElementById("map"), {
        center: {
            lat: lat,
            lng: lng
        },
        zoom: 14,
        mapTypeId: 'roadmap',
        mapTypeControl: false,
    });

    $("#map_address_line").text('Palm Beach Rd, Sector 17, Vashi, Navi Mumbai, Maharashtra 400703');

    const input = document.getElementById("pac-input");
    const options = {
        fields: ["formatted_address", "geometry", "name"],
        strictBounds: false,
        types: ["establishment"],
    };

    const autocomplete = new google.maps.places.Autocomplete(input, options);

    autocomplete.bindTo("bounds", map);

    const infowindow = new google.maps.InfoWindow();
    const infowindowContent = document.getElementById("infowindow-content");

    infowindow.setContent(infowindowContent);

    const marker = new google.maps.Marker({
        map,
        anchorPoint: new google.maps.Point(0, -29),
    });

    autocomplete.addListener("place_changed", () => {
        infowindow.close();
        marker.setVisible(false);

        const place = autocomplete.getPlace();

        if (!place.geometry || !place.geometry.location) {
            window.alert("No details available for input: '" + place.name + "'");
            return;
        }

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
        console.log(`location ${place.geometry.location},name ${ place.name}.addredd ${place.formatted_address}`);
        $("#map_address_line").text(place.name + " " + place.formatted_address);
        $("#line_1").val(`${place.name}`);
        $("#line_2").val(`${place.formatted_address}`);
        var loc = `${place.geometry.location}`;
        var loc_long = loc.substr(1, 10, loc.indexOf(','));
        var loc_lat = loc.substr(13, 10);
        lng = loc_long;
        lat = loc_lat;
        $("#location_long").val(loc_long);
        $("#location_lat").val(loc_lat);
        $("#address_location").val(`${place.geometry.location}`);
    });
}

function deleteAddress(id) {
    let formData = new FormData();
    formData.set("address_id", id);
    app.request("delete_user_address", formData).then(response => {
        if (response.status === 200) {
            app.successToast(response.body);
            setTimeout(() => {
                location.href = baseURL + "user_manage_address";
            }, 500)
        } else {
            app.errorToast(response.body);
        }
    }).catch(error => {
        console.log(error);
        app.errorToast("Something went wrong")
    })
}

function changeAddress() {
    let address = $("#map_address_line").text();
    $("#line_1").val(`${address}`);
    $("#save_as_home").click();
    $("#location_long").val(lng);
    $("#location_lat").val(lat);
}

app.validation("save_customer_address", {
    line_1: 'required',
    address_name_h: 'required',
}, {
    line_1: 'Enter address',
    address_name_h: 'Enter address name',
}, (form) => {

    app.request("add_user_address", new FormData(form)).then(response => {
        if (response.status === 200) {
            app.successToast(response.body);
            $("#save_customer_address").trigger("reset");
            setTimeout(() => {
				let backToPath = $("#backToPage").val();
				if (backToPath == "serviceOrder") {
					location.href = baseURL + "user_manage_address/1";
				}else{
					location.href = baseURL + "user_manage_address";
				}

            }, 500)
        } else {
            app.errorToast(response.body);
        }
    }).catch(error => {
        console.log(error)
        app.errorToast("Something went wrong")
    })

});
