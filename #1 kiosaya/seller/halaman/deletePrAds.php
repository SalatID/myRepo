<?php
	session_start();
	include('../../lib/config.php');
	$db=new config();
	$userId = $_SESSION['userId'];
	$adsId=$_POST['adsId'];

	$tableSlot = 'slot';
	$where = array('adsId'=> $adsId);
	echo $db->delete($tableSlot, $where);

	$tableShowAds = 'showads';
	$where = array('adsId'=> $adsId);
	echo $db->delete($tableShowAds, $where);

	//table Log
	$date = date('Y-m-d H:i:s');
	$table = "log";
	$logCode = "delPrAds-".$adsId;
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
	echo $db->insert($table,$data);

?>
