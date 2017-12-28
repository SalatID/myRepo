<?php
	include_once '../../lib/config.php';
	$db = new configEcom();
	$table='user';
	$field = 'max(id) as maxId';
	$on = '';
	$where = "";
	//$userId=$_POST['userId'];
	$username=$_POST['username'];
	$password=$_POST['retype'];
	$password=md5($password);
	$db->select($table,$field,$on,$where);
	$hasil = $db->getResult();
	$decode = json_decode($hasil,true);
	$maxId = $decode['post'][0]['maxId'];
	$userId = $maxId+1;
	$data = array( 'id' => $userId,
								'username' => $username,
								 'password' => $password
							);
	echo $db->insert($table,$data);

	$table		='profile';
	$field 		= 'max(id) as maxId';
	$on 			= '';
	$where 		= "";
	$name 		= $_POST['name'];
	$address 	= $_POST['address'];
	$provinces =$_POST['provinces'];
	$city 		= $_POST['city'];
	$phone 		= $_POST['phone'];
	$email 		= $_POST['email'];
	$joined 	= $_POST['joined'];
	$db->select($table,$field,$on,$where);
	$hasil 		= $db->getResult();
	$decode 	= json_decode($hasil,true);
	$maxId 		= $decode['post'][0]['maxId'];
	$profileId = $maxId+1;
	$data 		= array( 'id' => $profileId,
								'userId' => $userId,
								 'phone' => $phone,
								 'name' => $name,
								 'email' => $email,
								 'address' => $address,
								 'provinceId' => $provinces,
								 'cityId' => $city,
								 'joined' => $joined
							);
	echo $db->insert($table,$data);

	//table Log
	$date = date('Y-m-d H:i:s');
	$table = "log";
	$logCode = "regUsr-".$userId;
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
	echo $db->insert($table,$data)."<br>";
	header('location:../login.php');

?>
