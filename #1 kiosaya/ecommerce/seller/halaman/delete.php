<?php
	session_start();
	include('../../lib/config.php');
	$db=new configEcom();
	$userId = $_SESSION['userId'];
	$adsId=$_POST['adsId'];

	echo $adsId;
	$tableAds ='ads';
	$where = array("id" => $adsId);
	echo $db->delete($tableAds, $where);

	$tableImages = 'images';
	$where = array('adsId'=> $adsId);
	echo $db->delete($tableImages, $where);

	$tablePrice = 'adsprice';
	$where = array('adsId'=> $adsId);
	echo $db->delete($tablePrice, $where);

	$tableSlot = 'slot';
	$where = array('adsId'=> $adsId);
	echo $db->delete($tableSlot, $where);

	$tableShowAds = 'showads';
	$where = array('adsId'=> $adsId);
	echo $db->delete($tableShowAds, $where);

	//table Log
	$date = date('Y-m-d H:i:s');
	$table = "log";
	$logCode = "delAds-".$adsId;
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

?>
