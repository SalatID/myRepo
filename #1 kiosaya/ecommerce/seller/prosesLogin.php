<?php
	include("../lib/config.php");
	if (empty($_POST['username']) || empty($_POST['password'])) {
			header('location: login.php?error='.base64_encode('Username dan Password Belum Di Isi!!!'));
	}else{
		$db = new configEcom();
		$username=mysql_real_escape_string(trim($_POST['username']));
		$pass=md5($_POST['password']);
		$pass = mysql_real_escape_string(trim($pass));
		$tabel = "user";
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
				$date = date('Y-m-d H:i:s');
				$table = "log";
				$logCode = "lgnUsr-".$userId;
				$field = "max(id) as maxId";
				$where = "";
				$on = "";
				$db->select($table,$field,$on,$where);
				$hasil = $db->getResult();
				$decode = json_decode($hasil, true);
				$maxLogId = $decode['post'][0]['maxId'];
				$maxLogId++;
				$data = array('id' => $maxLogId,
								'logCode' => $logCode,
								'userId'=> $userId,
								'date' => $date
							);
				echo $db->insert($table,$data);
				//echo $_SESSION['userId'];
				header('location:index.php');
			}
		}else {
			header('location: login.php?error='.base64_encode('Username dan Password Invalid!!!'));
		}
	}


?>
