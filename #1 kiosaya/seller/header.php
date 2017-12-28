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
