<?php
session_start();
include_once '../../lib/config.php';
$db = new config();
$profileId = $_POST['profileId'];
$userId = $_SESSION['userId'];
$name = $_POST['name'];
$address = $_POST['address'];
$province = $_POST['provinces'];
$city = $_POST['city'];
$phone = $_POST['phone'];

$table = 'profile';

$updateField = array ('id' => $id,
                      'userId' => $userId,
                      'phone' => $phone,
                      'name' => $name,
                      'address' => $address,
                      'provinceId' => $province,
                      'cityId' => $city,
                      );
  $where = 'userId ='.$userId;
  $db->update($table,$updateField,$where);

  //table Log
	$date = date('Y-m-d H:i:s');
	$table = "log";
	$logCode = "updPrf-".$userId;
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
					'date' => $date
				);
	$db->insert($table,$data)."<br>";
  header('location:../index.php?modul=profile');
 ?>
