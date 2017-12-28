<?php
  session_start();
  include_once '../../lib/config.php';
	$db = new config();
  $userId = $_SESSION['userId'];
  $table = "slot";
	$field = "max(id) as maxId";
	$where = "";
	$on = "";
  $days = $_POST['days'];
  $date = $_POST['date'];
  $timeId = $_POST['timeId'];
  $adsId = $_POST['adsId'];
  $db->select($table,$field,$on,$where);
	$result = $db->getResult();
	$decode = json_decode($result,true);
	$maxId = $decode['post'][0]['maxId'];
	$maxId++;
  //echo "max".$maxId."</br>";

  //echo $days." ".$date." ".$timeId." ".$adsId;

  $data = array('id' => $maxId,
					'date' => $date,
					'days' => $days,
					'adsId' => $adsId,
          'timeId' => $timeId
				  );
  $table='slot';
  echo $db->insert($table,$data);

  $table = "showads";
	$field = "max(id) as maxId";
  $db->select($table,$field);
  $result = $db->getResult();
	$decode = json_decode($result,true);
	$showadsId = $decode['post'][0]['maxId'];
	$showadsId++;

  $data = array('id' => $showadsId,
                'adsId' => $adsId,
                'slotId' => $maxId,
                'adsPlacementId' => 1,
                'showStat' =>1
  );
  $table='showads';
  echo $db->insert($table,$data);

  //table Log
	$date = date('Y-m-d H:i:s');
	$table = "log";
	$logCode = "bookSlt-".$maxId;
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
