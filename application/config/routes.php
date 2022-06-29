<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


// Login and registration

$route['login'] = 'UserController/login';
$route['loginVerification'] = 'UserController/loginVerification';
$route['register'] = 'UserController/register';
$route['registerUser'] = 'UserController/registerUser';
$route['logout'] = 'UserController/logout';

// profile
$route['user_profile_menus'] = 'UserController/userProfileMenus';
$route['user_manage_address'] = 'UserController/userManageAddress';
$route['user_manage_address/(:any)'] = 'UserController/userManageAddress/$1';
$route['create_address'] = 'UserController/createAddress';
$route['add_user_address'] = 'UserController/addUserAddress';
$route['delete_user_address'] = 'UserController/deleteUserAddress';
$route['sukaii_help_center'] = 'UserController/helpCenter';
$route['sendIssue'] = 'AdminController/sendIssue';

// enquiry
$route['save_enquiry'] = 'EnquiryController/saveEnquiry';
$route["deleteEnquiry"] = "EnquiryController/deleteEnquiry";

// Orders route
$route['serviceOrder/(:num)'] = 'OrdersController/serviceOrder/$1';
$route['placeOrder'] = 'OrdersController/placeOrder';
$route['insertOrder'] = 'OrdersController/insertOrder';
$route['updateOrderStatus'] = 'OrdersController/updateOrderStatus';
$route['getTimeSlot'] = 'OrdersController/getTimeSlot';
$route["viewCart"]="OrdersController/viewCart";
$route['orderSummary'] = 'OrdersController/orderSummary';
$route['orderSummary/(:num)'] = 'OrdersController/orderSummary/$1';
$route['rescheduleOrder/(:num)/(:num)/(:any)'] = 'OrdersController/rescheduleOrder/$1/$2/$3';
$route['updateOrder'] = 'OrdersController/updateOrder';


$route["my_booking"]="OrdersController/myBookings";
$route["getMyBookings"]="OrdersController/getMyBookings";
$route["viewReport"]="ExcelController/getExcelData";
$route["viewReciept/(:any)/(:any)"]="OrdersController/viewReciept/$1/$2";
$route["viewPaymentReciept/(:any)"]="OrdersController/viewPaymentReciept/$1";
$route["viewPaymentRecieptDetails/(:any)"]="OrdersController/viewPaymentRecieptDetails/$1";
$route["updateOrderStatusOnUpload"]="OrdersController/updateOrderStatusOnUpload";

$route["updateCart"]="OrdersController/updateCart";
$route["removeCartItem"]="OrdersController/removeCartItem";

// Card Route

$route["previousPayment"] = "CardController/previousPayment";
$route["addCardForm"] = "CardController/addCardForm";
$route["addCardDetails"] = "CardController/addCardDetails";
// admin

$route['getAllOrders'] = 'OrdersController/getAllOrders';
$route['getAllUser'] = 'UserController/getAllUser';
$route['getAllEnquiries'] = 'EnquiryController/getAllEnquiries';
$route['getAllPartner'] = 'PartnersController/getAllPartner';
$route['logout'] = 'UserController/logout';
$route['deletePartner'] = 'PartnersController/deletePartner';


// partner
$route["partner_with_us"]="PartnersController/index";
$route["addPartners"]="PartnersController/addPartners";


// My profile
// Service
$route["covid_pcr"]="OrdersController/covidPCRHome";
$route["basic_health_test"]="OrdersController/basicHealthTest";
$route["complete_health_test"]="OrdersController/completeHealthTest";
$route["len_len_test"]="OrdersController/lenLenTest";


//Admin routes
$route["dashboard"]="AdminController/dashboard";
$route["orderDetails"]="AdminController/orderDetails";
$route["deleteOrder"]="OrdersController/deleteOrder";

//user routes
$route["userDetails"]="AdminController/userDetails";
$route["cardPaymentDetails"]="AdminController/cardPaymentDetails";
$route["customerAddressDetails"]="AdminController/customerAddressDetails";
$route["deleteUser"]="UserController/deleteUser";


$route["packageDetails"] = "AdminController/packageDetails";
$route["partnerDetails"] = "AdminController/partnerDetails";
$route["reportDetails"] = "AdminController/reportDetails";
$route["sampleCollecters"] = "AdminController/sampleCollecters";
$route["servicesDetails"] = "AdminController/servicesDetails";
$route["userEnquiryDetails"] = "AdminController/userEnquiryDetails";


// sample collector form
$route['sampleCollectorForm'] = 'AdminController/sampleCollectorForm';

//file upload

$route['uploadExcel'] = 'OrdersController/uploadExcelFile';
$route['fileToUpload'] = 'ExcelController/fileToUpload';

// sample collector

$route['saveSampleCollector'] = 'AdminController/saveSampleCollector';
$route['deleteSampleRecord'] = 'AdminController/deleteSampleRecord';
$route['getSampleCollector'] = 'AdminController/getSampleCollector';
$route['sampleCollector'] = 'OrdersController/sampleCollector';
$route['getSampleData'] = 'OrdersController/getSampleData';
$route['SampleCollectorDetails'] = 'OrdersController/SampleCollectorDetails';

// Card Route

$route["previousPayment"] = "CardController/previousPayment";
$route["addCardForm"] = "CardController/addCardForm";
$route["addCardDetails"] = "CardController/addCardDetails";

//order Allocation route
$route["orderAllocation"] = "AdminController/orderAllocation";
$route["getOrdersTimeSlots"] = "AdminController/getOrdersTimeSlots";
$route["getOrdersForAllocation"] = "AdminController/getOrdersForAllocation";
$route["SetOrderAllocationToSampleCollector"] = "AdminController/SetOrderAllocationToSampleCollector";
$route["cancelOrderAllocation"] = "AdminController/cancelOrderAllocation";

//heramb route
$route['testForm'] = 'AdminController/testForm';
$route['getScheduleData'] = 'AdminController/getScheduleData';
// $route['testForm'] = 'OrdersController/testForm';
$route['saveFormData'] = 'AdminController/saveFormData';
$route['saveOtp'] = 'AdminController/saveOtp';

// ----
$route['sampleCollectersOrders'] = 'OrdersController/sampleCollectersOrders';
$route['getsampleCollectorsOrder'] = 'OrdersController/getsampleCollectorsOrder';

$route['verifyOtp'] = 'OrdersController/verifyOtp';
$route['forgetPasswordLink/([a-z]+)'] = 'UserController/forgetPasswordLink/$1';
$route['fileUploadNotification'] = 'AdminController/fileUploadNotification';

$route['timeslot'] = 'AdminController/timeslot';
$route['getSampleCollectorDropdown'] = 'AdminController/getSampleCollectorDropdown';

// payment geteway
$route["create-checkout-session/(:any)/(:any)"]="PaymentController/paymentGetaway/$1/$2";
$route["onsuccess"]="PaymentController/onsuccess";
$route["oncancel"]="PaymentController/oncancel";


$route["cancelOrder"]="OrdersController/cancelOrder";

