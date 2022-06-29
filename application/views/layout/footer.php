

</body>
<script src="<?=base_url('assets/mjs/javascript.js')?>"></script>
<script src="<?=base_url('assets/izitoast/js/iziToast.js')?>"></script>
<script src="<?=base_url('assets/jquery-validation/js/jquery.validate.js')?>"></script>
<script src="<?=base_url('assets/page/custom.js')?>"></script>
<?php $this->load->view("./layout/js");?>

<script>
	const baseURL= '<?=base_url()?>';
	$(function() {
		// $("#Header").load("header.html");
		// $("#footer").load("footer.html");
		// $("#bookIn3Step").load("bookin3steps.html");
	});



	$("#pws_service").click(function() {
		$("#pws_dd_service_value").slideToggle();
	});


</script>
<script>
	const mySelectedServices = [];
	// $(function() {
	//     // fetchServices();
	// });
</script>
<script>
	// $("#show_2nd_week").click(function() {
	//     $(".hidden_days").removeClass('animate__animated animate__bounceOutLeft');
	//     $(".hidden_days").addClass('animate__animated animate__fadeInRightBig');
	//     $(".visible_days").removeClass('animate__animated animate__fadeInRightBig');
	//     $(".visible_days").addClass('animate__animated animate__bounceOutLeft');
	//     $(".hidden_days").show();
	//     $("visible_days").hide();
	// });



	// $("#show_1nd_week").click(function() {
	//     $(".hidden_days").removeClass('animate__animated animate__fadeInRightBig');
	//     $(".hidden_days").addClass('animate__animated animate__bounceOutLeft');
	//     $(".visible_days").removeClass('animate__animated animate__bounceOutLeft');
	//     $(".visible_days").addClass('animate__animated animate__fadeInRightBig');
	// });


	$("#show_1nd_week").click(function() {
		$(".hidden_days").removeClass('animate__animated animate__bounceOutLeft');
		$(".hidden_days").addClass('animate__animated animate__fadeInRightBig');
		$(".visible_days").removeClass('animate__animated animate__fadeInRightBig');
		$(".visible_days").addClass('animate__animated animate__bounceOutLeft');
		$(".hidden_days").show();
		$("visible_days").hide();
	});

	// show_1nd_week

	$("#show_2nd_week").click(function() {
		$(".hidden_days").removeClass('animate__animated animate__fadeInRightBig');
		$(".hidden_days").addClass('animate__animated animate__bounceOutLeft');
		$(".visible_days").removeClass('animate__animated animate__bounceOutLeft');
		$(".visible_days").addClass('animate__animated animate__fadeInRightBig');
	});


	// $(".schedule_day").click(function() {
	//     $(".schedule_time").show();
	// })
	$("#serviceBookingLocation").click(function() {
		$("#servuceBooking_location_ddvalue").slideToggle();
	})


</script>

</html>
