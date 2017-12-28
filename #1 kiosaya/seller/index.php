<?php
	error_reporting(1);
	session_start();
	if (!isset($_SESSION['userId'])) {
		header('location:login.php');
	}else{
	include('../lib/config.php');
	$db     = new config();
	$userId = $_SESSION['userId'];
	$table = 'profile';
	$field = '*';
	$on = '';
	$where = 'userId='.$userId;
	$db->select($table,$field,$on,$where);
	$result = $db->getResult();
	$decode = json_decode($result,true);
	$rowProfile = $decode['post'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Iklanin Aja</title>
	<link rel="stylesheet" href="../css/own.css">
	<link href="../css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/bootstrap-datepicker3.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css" />
	<link rel="stylesheet" type="text/css" href="../css/sweetalert.css" />
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/jquery.js"></script>
  <script src="../js/sweetalert.js"></script>
</head>
<body>
	<div class="wrapper">
		<div id="frontSidebar">

			<div class="sidebar-wrapper">
				<div class="logo">
					<img class="img-responsive" src="../css/img/logo.png">
				</div>
<?php
	$modulGet = (isset($_GET['modul'])) ? $_GET['modul'] : "home";
	$table = 'menu';
	$field = '*';
	$on="";
	$where="";
	$db->select($table,$field, $on, $where);
	$result = $db->getResult();
	//echo $result;
	$decode = json_decode($result, true);
	//print_r($decode);
	$rowMenu = $decode['post'];
?>
  <ul class="nav nav-pills nav-stacked" >
	<?php for ($i=0; $i < count($rowMenu) ; $i++) {
		$modulName = $rowMenu[$i]['modulName'];
		//echo "modul get ".$modulGet;
		$menu = $rowMenu[$i]['name'];
		if ($modulGet == $modulName) {
			//echo $modulName;
			$activeClass ="class='active'";
		} else {
			$activeClass ="";
			//echo $modulName;
		}
		if ($rowMenu[$i]['menuPlacement']==1) {?>
			<li <?php echo $activeClass;?>>
				<a href="index.php?modul=<?php echo $rowMenu[$i]['modulName']?>">
					<i class="<?php echo $rowMenu[$i]['icon']?>" aria-hidden="true"></i>
					<?php echo $menu; ?>
				</a>
			</li>
			<?php }
			?>
			<?php  }
			?>
		</ul><br>

	</div>
</div>
<div class="main-panel">
	<nav class="nav navbar-default navbar-fixed">
		<div class="container-fluid">
			<div class="navbar-collapse">
				<div class="navbar-header" id="sidebarCollapse">
					<button type="button" class="nb-btn-toggle" id="sidebarCollapse">
						<span class="fa fa-bars"></span>
					</button>
				</div>
				<ul class="nav navbar-nav navbar-left" >
					<?php
						$where="modulName ="."'".$modulGet."'";
						$db->select($table,$field, $on, $where);
						$result = $db->getResult();
						//echo $result;
						$decode = json_decode($result, true);
						//print_r($decode);
						$rowHead = $decode['post'];
						echo $rowHead[0]['name'];
					?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">

						<a class="dropdown-toggle" data-toggle="dropdown" style="text-transform: capitalize;" href=#>
							<i class="fa fa-user-circle-o" aria-hidden="true" ></i>
							<span class="userName"><?php echo $rowProfile[0]['name']; ?></span>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu dropdown-menu-right">
							<li>
								<a href="index.php?modul=profile">Profile</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="halaman/logout.php">Logout</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>
<div class="content menu" id="content">
	<div class="container-fluid">
		<div class="row">
			<div class="pasangiklan col-xs-12">
				<a href="index.php?modul=newAds" class="btn btn-warning" style="background-color:#757ee6; border-color :#757ee6; ">
					<i class="fa fa-plus-circle"></i> New Ads
				</a>
			</div>
			<div class="isi col-xs-12">
				<?php
					
						if(isset($_GET['modul'])){
							$modul = $_GET['modul'];
							switch ($modul) {
								case 'home':
									include "halaman/home.php";
									break;
								case 'profile':
									include "halaman/profile.php";
									break;
								case 'activeAds':
									include "halaman/activeAds.php";
									break;
								case 'nonActiveAds':
									include "halaman/nonActiveAds.php";
									break;
								case 'priorityAds':
									include "halaman/priorityAds.php";
									break;
								case 'detailAds':
									include "halaman/detailAds.php";
									break;
								case 'setting':
									include "halaman/setting.php";
									break;
								case 'newAds':
									include "halaman/newAds.php";
									break;
								case 'slotAvailable':
									include "halaman/slotAvailable.php";
									break;
								case 'contract':
									include "halaman/contract.php";
									break;
								case 'newContract':
									include "halaman/newContract.php";
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
	</div>
</div>
<footer style="position : relatif; bottom :0;">
	<p>Footer Text</p>
</footer>
</div>
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/bootstrap.js"></script>
<script src="../js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
		$(document).ready(function () {
				$('#sidebarCollapse').on('click', function () {
		$('#frontSidebar').toggleClass('active');
		$('.main-panel').toggleClass('active');
	});
});
</script>
</html>
<?php
}
?>
