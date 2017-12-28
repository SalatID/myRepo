<?php
	include("../../lib/config.php");
	if (empty($_POST['username']) || empty($_POST['password'])) {
			header('location: ../index.php?error='.base64_encode('Username dan Password Belum Di Isi!!!'));
	}else{
		$db = new config();
		$username=$_POST['username'];
		$pass=md5($_POST['password']);
		$tabel = "admin";
		$fild  = "*";
		$where = "username='$username' and password='$pass'";
		$on="";
		$db->select($tabel,$fild,$on,$where);
		$hasil = $db->getResult();
		$decode = json_decode($hasil,true);
		//echo count($decode['post']);
		if (count($decode['post'])==1) {
			if ($username = $decode['post'][0]['username'] && $pass = $decode['post'][0]['password']) {
				//echo $decode['post'][0]['id'];
				$userId=$decode['post'][0]['id'];
				session_start();
				$_SESSION['userId']=$userId;
				//table Log
				header('location:dashboard.php?modul=home');
			}
		}else {
			header('location: ../index.php?error='.base64_encode('Username dan Password Invalid!!!'));
		}
	}


?>
