<?php
    session_start();
    include_once '../../lib/config.php';
    $userId=$_SESSION['userId'];
    $db = new configEcom();
    $adsId = $_POST['adsId'];
    $active = $_POST['enabled'];
    //echo $id;
    //echo $adsId;
    $tabel = 'ads';
    $updateField = array ('active' => $active
                          );
    $where = 'id ='.$adsId;
    echo $db->update($tabel,$updateField,$where);

    //table Log
  	$date = date('Y-m-d H:i:s');
  	$table = "log";
    if ($active == 0) {
      $logCode = "nonAtv-".$adsId;
    }else {
      $logCode = "active-".$adsId;
    }

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

 ?>
