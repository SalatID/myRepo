<?php
	include("../lib/config.php");
	if (empty($_POST['username']) || empty($_POST['password'])) {
			header('location:login.php?error='.base64_encode('Username dan Password Belum Di Isi!!!'));
	}else{
		$db = new config();
		$username=addslashes(trim($_POST['username']));
		$password=md5($_POST['password']);
		$password = addslashes(trim($password));
		$table = "user";
		$field  = "*";
		$where = "username='$username' and password='$password'";
		$on="";
		$db->select($table,$field,$on,$where);
		$result = $db->getResult();
		$decode = json_decode($result,true);
		//print_r($decode);die;
		//echo count($decode['post']);
		if (count($decode['post'])==1) {
			if ($username = $decode['post'][0]['username'] && $password = $decode['post'][0]['password']) {
				//echo $decode['post'][0]['id'];
				$userId=$decode['post'][0]['id'];
				session_start();
				$_SESSION['userId']=$userId;
				//table Log
				$today = date('Y-m-d H:i:s');
				$table = "log";
				$logCode = "lgnUsr-".$userId;
				$field = "max(id) as maxId";
				$where = "";
				$on = "";
				$db->select($table,$field,$on,$where);
				$result = $db->getResult();
				$decode = json_decode($result, true);
				$maxLogId = $decode['post'][0]['maxId'];
				$maxLogId++;
				$data = array('id' => $maxLogId,
								'logCode' => $logCode,
								'userId'=> $userId,
								'date' => $today
							);
				$db->insert($table,$data);
				//echo $_SESSION['userId'];
				header('location:index.php');
			}
		}else {
			header('location: login.php?error='.base64_encode('Username dan Password Invalid!!!'));
		}
	}


?>
