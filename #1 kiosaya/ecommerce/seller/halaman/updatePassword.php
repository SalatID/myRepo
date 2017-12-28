<?php
  session_start();
  include_once '../../lib/config.php';
  $db = new configEcom();
  $userId=$_POST['id'];
  $newPassword =md5($_POST['newPassword']);
  $table = 'user';
  $updateField = array ('password' => $newPassword);
  $where = 'id ='.$userId;
  echo $db->update($table,$updateField,$where);

  //table Log
	$date = date('Y-m-d H:i:s');
	$table = "log";
	$logCode = "updPass-".$userId;
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
