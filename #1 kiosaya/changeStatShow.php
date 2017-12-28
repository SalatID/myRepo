<?php
  include_once 'lib/config.php';
  $db = new config();
  //$userId = $_POST['userId'];
  //$adsId = $_POST['adsId'];
  //$showadsId = $_POST['showadsId'];
  //echo $userId;
  //echo $adsId;
  //echo $showadsId;
  $time = $_POST['time'];
  //$time = '15:00:00';
  $today = $_POST['today'];
  //$today = '2017-10-19';
  //echo $time;
  //echo $today;
  $table = 'slot a INNER JOIN time b';
  $field = "a.*,b.*, a.id as slotId";
	$where = "";
	$on = " a.timeId=b.id";
	$db->select($table,$field,$on,$where);
	$hasil = $db->getResult();
	$decode = json_decode($hasil, true);
  //print_r($decode);
  $rowSlot = $decode['post'];
  foreach ($rowSlot as $keySlot => $valueSlot) {
      $table = 'showads';
      $field = "id,showStat";
      $where = "slotId=".$valueSlot['slotId'];
      $on = "";
      $db->select($table,$field,$on,$where);
      $hasil = $db->getResult();
      $decode = json_decode($hasil, true);
      //print_r($decode);
      $rowShow = $decode['post'];
    if ($rowShow[0]['showStat']==1) {
      if ($today > $valueSlot['date']) {
        $updateAds = array ('showStat' => 0
      						);
        $table = 'showads';
        $where = 'slotId ='.$valueSlot['slotId'];
      	$resultYes = $db->update($table,$updateAds,$where);
      }elseif ($today==$valueSlot['date']) {
        $resultToday = 0;
        if ($time>=$valueSlot['end']) {
          $updateAds = array ('showStat' => 0
        						);
          $table = 'showads';
          $where = 'slotId ='.$valueSlot['slotId'];

      	$resultToday = $db->update($table,$updateAds,$where);
        }
      }
      $resultToday = isset($resultToday) ? $resultToday : 0;
      $resultYes = isset($resultYes) ? $resultYes : 0;
      if ($resultYes !=0 || $resultToday != 0) {
        $showadsId = $rowShow[0]['id'];
        //table Log
      	$date = date('Y-m-d H:i:s');
      	$table = "log";
        $userId="0";
      	$logCode = "disShwAds-".$showadsId;
      	$field = "max(id) as maxId";
      	$where = "";
      	$on = "";
      	$db->select($table,$field,$on,$where);
      	$hasil = $db->getResult();
      	$decode = json_decode($hasil, true);
        //print_r($decode);
      	$maxLogId = $decode['post'][0]['maxId'];
      	$maxLogId++;
      	$data = array('id' => $maxLogId,
      					'logCode' => $logCode,
      					'userId'=> $userId,
      					'date' => $date
      				);
      	$db->insert($table,$data);
      }
    }
    }



 ?>
