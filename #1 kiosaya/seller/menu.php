<?php
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
			$active ="class='active'";
		} else {
			$active ="";
			//echo $modulName;
		}
		if ($rowMenu[$i]['menuPlacement']==1) {?>
			<li <?php echo $active;?>>
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
								<a href="index.php?modul=logout">Logout</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>
