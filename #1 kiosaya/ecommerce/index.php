<?php
session_start();
include_once 'lib/config.php';
$db = new configEcom();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Iklanin Aja</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/own.css">
	<link rel="stylesheet" href="../css/style.css">
	<link href="../css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/bootstrap-datepicker3.css">
	<style>
		/* Add a gray background color and some padding to the footer */
		footer {
		  background-color: #555;
		  padding: 25px;
		}

		.carousel-inner img {
		  width: 100%; /* Set width to 100% */
		  min-height: 200px;
		}

		/* Hide the carousel text when the screen is less than 600 pixels wide */
		@media (max-width: 600px) {
		  .carousel-caption {
			display: none;
		  }
		}
	</style>
</head>
<body>

	<nav class="navbar navbar-inverse">
    <div class="container-fluid" style="background-color:#86AEDD;">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"><img style="max-height : 30px"src="css/img/logo.png" alt=""></a>
      </div>
			<div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="index.php">Home</a></li>
          <li><a href="#">My Cart</a></li>
          <li><a href="#">Category</a></li>
          <li><a href="#">Help</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="seller/login.php" style="color : #fff"><i style="color:#fff"class="glyphicon glyphicon-log-in"></i> Login</a></li>
        </ul>
			</div>
		</div>
	</nav>

	<div class="frontContent">
		<div class="col-sm-8">
			<?php
			if(isset($_GET['fstore'])){
			  $modul = $_GET['fstore'];
			  switch ($modul) {
				case 'home':
				  include "halaman/home.php";
				  break;
				case 'profile':
				  include "halaman/profile.php";
				  break;
				case 'active_ads':
				  include "halaman/active_ads.php";
				  break;
				case 'nonActive_ads':
				  include "halaman/nonActive_ads.php";
				  break;
				case 'priority_ads':
				  include "halaman/priority_ads.php";
				  break;
				case 'detail_ads':
				  include "frontStore/halaman/detail_ads.php";
				  break;
				case 'view_contract':
				  include "halaman/view_ads.php";
				  break;
				case 'setting':
				  include "halaman/setting.php";
				  break;
				case 'new_ads':
				  include "halaman/new_ads.php";
				  break;
				case 'invoice':
				  include "halaman/invoice.php";
				  break;
				case 'edit_profile':
				  include "halaman/edit_profile.php";
				  break;
				case 'new_contract':
				  include "halaman/new_contract.php";
				  break;
				case 'slot_available':
				  include "halaman/slot_available.php";
				  break;
				case 'test':
				  include "halaman/test.php";
				  break;
				default:
				  echo "<center><h3>Maaf. Halaman tidak di temukan !</h3></center>";
				  break;
			  }
			}else{
			  include "../frontStore/halaman/home.php";
			}
			 ?>
		</div>
		<div class="col-sm-4" id="adsPlacement">
			<?php include('ads_placement.php') ?>
		</div>

		<hr>

	</div>

<footer class="container-fluid text-center">
  <p>Footer Text</p>
</footer>

</body>
</html>
<script src="js/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  setInterval(function(){$('#adsPlacement').load('ads_placement.php');},1000);
});
</script>
