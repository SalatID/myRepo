<?php
  session_start();
  include_once '../../lib/config.php';
	$db = new config();
  $userId = $_SESSION['userId'];
  $days = $_POST['days'];
  $date = $_POST['date'];
  $timeId = $_POST['timeId'];
  $explode = explode(',',$timeId);
  $timeId = $explode[0];
  $priceCode = $explode[1];
  $adsId = $_POST['adsId'];
  $table = 'slotprice';
  $field = 'id, price';
  $on ='';
  $where ='pricingCode ='.'"'.$priceCode.'"';
  $db->select($table,$field,$on,$where);
  $result = $db->getResult();
  $decode = json_decode($result, true);
  print_r($decode);
  $rowPrice = $decode['post'];
  $data = array('date' => $date,
					'days' => $days,
					'adsId' => $adsId,
          'timeId' => $timeId,
          'price' => $rowPrice[0]['price'],
          'priceId' => $rowPrice[0]['id']
        );
  $dataSlot = array();
  $i=0;
  foreach ($data as $keyData => $valueData) {
    $dataSlot [$keyData]=$valueData;
    $i++;
  }
  if(isset($_SESSION['slot'])){
    array_push($_SESSION['slot'],$dataSlot);
  }
  else{
    $_SESSION['slot'] = [];
    array_push($_SESSION['slot'],$dataSlot);
  }
  $result = isset($_SESSION['slot'])?1:null;
  echo $result;
 ?>
