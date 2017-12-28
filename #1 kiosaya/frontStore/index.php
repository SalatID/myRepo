<?php
session_start();
include_once '../ecommerce/lib/config.php';
$dbe = new configEcom();
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
  <div class="container-fluid" >
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><img style="max-height : 30px"src="../css/img/logo.png" alt=""></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="../index.php">Home</a></li>
        <li><a href="#">My Cart</a></li>
        <li><a href="#">Category</a></li>
        <li><a href="#">Help</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="../seller/login.php"><i class="glyphicon glyphicon-log-in"></i> Login</a></li>
      </ul>
    </div>
  </div>
</nav>


  <div class="container-fluid">
    <div id="content">
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
            include "halaman/detailAds.php";
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
        include "halaman/home.php";
      }
       ?>
    </div>

  </div>


<div class="clearfix"></div>
<footer class="footer">
			<div class="fTop">
				<div class="fLeft">
					<div class="fAdds">
						Supported By
						<span class="fLogo">Gemanusa</span><br>
						Tangcity Business Park D25<br>
						Jl. Jend Sudirman No.1<br>
						Tangerang – 15117<br>
						INDONESIA<br>
						Telp : +62-21-2923-9669<br>
						Fax : +62-21-2923-9672<br>
						<a href="http://www.gemanusa.co.id">www.gemanusa.co.id</a>
					</div>
				</div>
				<div class="fCenter">
					<ul>
						<li class="category">Category</li>
						<li><a href="">Elektronik</a></li>
						<li><a href="">Jasa</a></li>
						<li><a href="">Kantor dan Industri</a></li>
						<li><a href="">Kendaraan</a><li>
						<li><a href="">Keperluan Pribadi</a></li>
						<li><a href="">Properti</a></li>
						<li><a href="">Rumah Tangga</a></li>
					</ul>
				</div>
				<div class="fRight">
					Social Media
					<div class="fImg">
						<a href=""><span>Facebook</span><img src="img/f.png"></a>
						<a href=""><span>Instagram</span><img src="img/i.png"></a>
						<a href=""><span>Google+</span><img src="img/g.png"></a>
						<a href=""><span>Twitter</span><img src="img/t.png"></a>

					</div>
				</div>
			</div>
			<div class="fBottom">
				&copy Copyright 2017
			</div>
		</footer>

</body>
</html>
