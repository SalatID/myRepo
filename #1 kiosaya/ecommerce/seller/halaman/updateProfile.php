<?php
session_start();
include_once '../../lib/config.php';
$db = new configEcom();
$id = $_POST['id'];
$userId = $_SESSION['userId'];
$name = $_POST['name'];
$address = $_POST['address'];
$province = $_POST['provinces'];
$city = $_POST['city'];
$phone = $_POST['phone'];

$tabel = 'profile';

$updateField = array ('id' => $id,
                      'userId' => $userId,
                      'phone' => $phone,
                      'name' => $name,
                      'address' => $address,
                      'provinceId' => $province,
                      'cityId' => $city,
                      );
  $where = 'userId ='.$userId;
  echo $db->update($tabel,$updateField,$where);

  //table Log
	$date = date('Y-m-d H:i:s');
	$table = "log";
	$logCode = "updPrf-".$userId;
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
  header('location:../index.php?modul=profile');
 ?>
