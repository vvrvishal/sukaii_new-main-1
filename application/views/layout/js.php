<?php if ($this->uri->segment(1) == "partner_with_us") { ?>
	<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
			async defer>
	</script>
	<script src="<?php echo base_url(); ?>assets/page/partners.js"></script>
<?php } ?>


<?php if ($this->uri->segment(1) == "login") { ?>
	<script src="<?php echo base_url(); ?>assets/page/login.js"></script>
<?php } ?>

<?php if ($this->uri->segment(1) == "register") { ?>
	<script src="<?php echo base_url(); ?>assets/page/registration.js"></script>
<?php } ?>

<?php if ($this->uri->segment(1) == "create_address") { ?>
	<script src="<?php echo base_url(); ?>assets/page/address.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyUheX8uRbF-htWMLzI6n4ENhFLIRpN1Q&callback=initMap&libraries=places&v=weekly"
			async defer></script>

<?php } ?>
<?php if ($this->uri->segment(1) == "serviceOrder") { ?>
	<script src="<?php echo base_url(); ?>assets/page/serviceOrder.js"></script>
<?php } ?>
<?php if ($this->uri->segment(1) == "user_manage_address") { ?>
	<script src="<?php echo base_url(); ?>assets/page/address.js"></script>
<?php } ?>

<?php if ($this->uri->segment(1) == ""|| $this->uri->segment(1) == "/") { ?>
	<script src="<?php echo base_url(); ?>assets/page/enquiry.js"></script>
<?php } ?>


<?php if ($this->uri->segment(1) == "dashboard" || $this->uri->segment(1) == "cardPaymentDetails"
		|| $this->uri->segment(1) == "customerAddressDetails"|| $this->uri->segment(1) == "packageDetails"
		|| $this->uri->segment(1) == "partnerDetails"|| $this->uri->segment(1) == "reportDetails"
		|| $this->uri->segment(1) == "sampleCollecters" || $this->uri->segment(1) == "userEnquiryDetails" || $this->uri->segment(1) == "orderAllocation" ) { ?>
	<script src="<?php echo base_url(); ?>assets/page/adminjs.js"></script>
<?php } ?>

<?php if ($this->uri->segment(1) == "orderDetails" || $this->uri->segment(1) =="userDetails" || $this->uri->segment(1) =="sampleCollector") { ?>
	<script src="<?php echo base_url(); ?>assets/page/admin.js"></script>
<?php } ?>
<?php if ($this->uri->segment(1) =="sampleCollector") { ?>
	<script src="<?php echo base_url(); ?>assets/page/collector.js"></script>
<?php } ?>
