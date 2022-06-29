<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sukaii</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer"
	/>
	<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/bootstrap.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/bootstrap.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">

</head>
<style>
	@page {
		size: 7in 9.25in;
		margin: 27mm 16mm 27mm 16mm;
	}

	p {
		margin-bottom: 0%;
	}
	body{
		background-color: #fff;
	}
</style>

<body>
<?php //var_dump($patientData[0]); ?>
<div class="container">
	<div class="row">
		<div class="col-12 mb-4">
			<img src="<?php echo base_url('assets/mimages/sukaii_logo.PNG');?>" class="mt-3 w-25" alt="">
		</div>
	</div>
	<div class="row " style="margin-bottom: 4rem;">
		<div class="col-4">

			<p><b>SUKAII</b>,</p>
			<p> 513, b-Wing ,Arenja Corner,</p>
			<p>Vashi Sector -17,</p>
			<p> Mumbai-400000;</p>



		</div>
		<div class="col-4">

			<p><b><?= $patientData[0]->name ?></b></p>
			<p>PI : <b>D006GTY987</b></p>
			<p><?php
				if (isset($patientData[0]->age) && isset($patientData[0]->gender)){
					echo $patientData[0]->age .'/'. $patientData[0]->gender;
				}
				   ?></p>
			<p>ref: <?= isset($patientData[0]->ref) ? $patientData[0]->ref:''; ?></p>


		</div>
		<div class="col-4">

			<p>Requested : <span><?= $requested; ?></span></p>
			<p>Reported : <span class="ml-2"><?= $reported; ?></span></p>
			<p>Printed : <span class="ml-4"><?= $printed; ?></span></p>
			<p>lan : <span class="ml-5 pl-1"><?= $lan; ?></span></p>


		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<table class="table">
				<thead>
				<tr>
					<th scope="col">service</th>
					<th scope="col"></th>
					<th scope="col">RESULT</th>
					<th scope="col">UNIT</th>
					<th scope="col"> REF.RANGE</th>
				</tr>
				</thead>
				<tbody>
				<?php echo $orderDetails != '' ? $orderDetails :''; ?>

				</tbody>
			</table>
			<div class="range_dicription d-flex">
				<div class="range">
					<a href="#" class="font-weight-bold mb-3">INR RANGE</a>
					<p class="mb-1 font-weight-bold">2.0 - 3.0 :</p>
					<br>
					<p class="mb-1 font-weight-bold">2.5 - 3.5 :</p>
				</div>
				<div class="intro ml-5">
					<a href="#" class="font-weight-bold mb-3">INTRODUCTION</a>
					<P class="mb-0">Lorem ipsum dolor sit amet.</P>
					<P class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit.</P>
					<P class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Earum, quod.</P>
					<P class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing.</P>
				</div>
			</div>
		</div>
	</div>
</div>
</body>

</html>
