// index.html query form location section 
var BankokCityName = document.querySelectorAll(".bankok_city");


console.log(BankokCityName);
for (let i = 0; i < BankokCityName.length; i++) {
    BankokCityName[i].addEventListener('click', select_location.bind(this, BankokCityName[i]));
}

function select_location(location) {
    const selected_city_name = location.innerHTML;
    console.log(selected_city_name);
}

// =================================================== covid pcr booking form =========================================================================== 
// schudle date section 
var selected_date = document.querySelectorAll(".schedule_day");
for (let i = 0; i < selected_date.length; i++) {
    selected_date[i].addEventListener('click', select_appoint_date.bind(this, selected_date[i]));
}

function select_appoint_date(days) {
    $(".schedule_day").removeClass('active');
    $(days).addClass('active');
}
// schudle time section 

var selected_time = document.querySelectorAll(".schudule_time");
for (let i = 0; i < selected_time.length; i++) {
    selected_time[i].addEventListener('click', select_appoint_time.bind(this, selected_time[i]));
}

function select_appoint_time(time) {
    $(".schudule_time").removeClass('active');
    $(time).addClass('active');
}
// =================================================== covid pcr booking form =========================================================================== 

// fatch address page

// var x = document.getElementById("demo");

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        console.log("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    console.log("Latitude: " + position.coords.latitude +
        "<br>Longitude: " + position.coords.longitude);
}