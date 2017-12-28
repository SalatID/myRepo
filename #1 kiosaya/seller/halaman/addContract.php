<?php
  session_start();
  include '../../lib/config.php';
  $db = new config();
  $today = date('ymd');
  $uploadDate = date("Y-m-d h:i:s");
	$itemNumber = $_GET['item_number'];
	$txnId = $_GET['tx'];
	$paymentGross = $_GET['amt'];
	$currencyCode = $_GET['cc'];
	$paymentStatus = $_GET['st'];
	//echo $itemNumber.'-'.$txnId;
  if ($paymentStatus=='Pending' || $paymentStatus=='Success') {
    $table = "payment";
    $field = "max(id) as maxId";
    $where = "id like '$today%'";
    $on = "";
    $db->select($table,$field,$on,$where);
    $result = $db->getResult();
    $decode = json_decode($result, true);
    //print_r($decode);
    $maxId = $decode['post'][0]['maxId'];
    $substring = substr($maxId,6,4);
    $substring++;
    $paymentId = $today.sprintf('%04s',$substring);
    $data = array('id' => $paymentId,
            'contractId' => $itemNumber,
            'paymentMethode' => 'paypal',
            'txId' => $txnId,
            'totalPayment' => $paymentGross,
            'curencyCode' => $currencyCode,
            'paymentDate' => $uploadDate
            );
    $result = $db->insert($table,$data);
    if ($result) {
      $userId = $_SESSION['userId'];
      $dataContract = $_SESSION['contract'];
      $dataSlot = $_SESSION['slot'];
      //print_r($dataContract);

      $table = "contract";
      $field = "max(id) as maxId";
      $where = "id like '$today%'";
      $on = "";
      $contractDate = date("Y-m-d");
      $uploadDate = date("Y-m-d h:i:s");
      $db->select($table,$field,$on,$where);
      $result = $db->getResult();
      $decode = json_decode($result, true);
      //print_r($decode);
      $maxId = $decode['post'][0]['maxId'];
      $active = 1;

      $substring = substr($maxId,6,4);
      $substring++;
      $contractId = $today.sprintf('%04s',$substring);
      //echo $contractId;

      $data = array('id' => $contractId,
              'contractDate' => $contractDate,
              'userId' => $userId
              );
      $result = $db->insert($table,$data);
      if ($result) {
        foreach ($dataContract as $keyCtr => $valueCtr) {
          $adsIdSession = isset($valueCtr['catalogueId'])?$valueCtr['catalogueId']:null;
          $newAdsId = isset($valueCtr['newAdsid'])?$valueCtr['newAdsid']:null;
          //echo $adsIdSession;
          $menu = $valueCtr['menu'];
          $title = $valueCtr['title'];
          $categoryId = $valueCtr['categoryId'];
          $subCategoryId = $valueCtr['subCategoryId'];
          $active = 1;
          if ($menu == 'catalog' || $menu == 'newAds') {
          //input into table ads
          $description = $valueCtr['description'];
          $table = "ads";
        	$field = "max(id) as maxId";
        	$where = "id like '$today%'";
        	$on = "";
        	$redirectLink = isset($valueCtr['redirectLink']) ? $valueCtr['redirectLink'] : $valueCtr['catalogueId'];
          $images = isset($valueCtr['images'])?$valueCtr['images'] : null;
        	$userId = $_SESSION['userId'];
        	$uploadDate = date("Y-m-d h:i:s");
        	$db->select($table,$field,$on,$where);
        	$result = $db->getResult();
        	$decode = json_decode($result, true);
        	$maxId = $decode['post'][0]['maxId'];
        	$active = 1;

        	$substring = substr($maxId,6,4);
        	$substring++;

          $adsId = $today.sprintf('%04s',$substring);

        	$data = array('id' => $adsId,
        					'title' => $title,
        					'userId' => $userId,
        					'categoryId' => $categoryId,
        					'subCategoryId' => $subCategoryId,
        					'description' => $description,
        					'redirectLink' => $redirectLink,
                  'contractId' => $contractId,
        					'active' => $active,
        					'uploadDate' => $uploadDate
        				  );
        	$result = $db->insert($table,$data);
          if ($result) {
              if ($images!=null) {
                    if (isset($images['adsId']) && $images['adsId']==$adsIdSession) {
                      $table = "images";
                      $field = "max(id) as maxId";
                      $where = "";
                      $db->select($table,$field);
                      $result = $db->getResult();
                      $decode = json_decode($result, true);
                      //print_r($decode);
                      $maxId = $decode['post'][0]['maxId'];
                      $imagesId = $maxId+1;
                      $data = array('id' => $imagesId,
                              'adsId' => $adsId,
                              'location' => $images['location']
                              );
                      $result = $db->insert($table,$data);
                    }else {
                      $table='images';
                      $updateAds = array ('adsId' => $adsId,
                    						);
                    	$where = 'id ='.$images;
                      $result = $db->update($table,$updateAds,$where);
                    }
                    if ($result) {
                      $table='campaign';
                      $field = "max(id) as maxId";
                      $where = "id like '$today%'";
                      $on = "";
                      $db->select($table,$field,$on,$where);
                      $result = $db->getResult();
                      $decode = json_decode($result, true);
                      //print_r($decode);
                      $maxId = $decode['post'][0]['maxId'];
                      $substring = substr($maxId,6,4);
                      $substring++;
                      $campaignId = $today.sprintf('%04s',$substring);
                      $data = array('id' => $campaignId,
                              'adsId' => $adsId,
                              'contractId' => $contractId
                              );
                      $result = $db->insert($table,$data);
                    }
                  //print_r($images);
              }
            foreach ($dataSlot as $keySlot => $valueSlot) {
              if ($adsIdSession == $valueSlot['adsId'] || $newAdsId==$valueSlot['adsId']) {
                $table = "slot";
                $field = "max(id) as maxId";
                $where = "";
                $on = "";
                $dateSlot = $valueSlot['date'];
                $daysSlot = $valueSlot['days'];
                $priceId = $valueSlot['priceId'];
                //$adsId = $valueSlot['adsId'];
                $timeId = $valueSlot['timeId'];
                $db->select($table,$field,$on,$where);
                $result = $db->getResult();
                $decode = json_decode($result, true);
                //print_r($decode);
                $maxId = $decode['post'][0]['maxId'];
                $slotId = $maxId+1;
                //echo $contractId;

                $data = array('id' => $slotId,
                        'date' => $dateSlot,
                        'days' => $daysSlot,
                        'adsId'=> $adsId,
                        'timeId' => $timeId,
                        'slotPriceId' => $priceId,
                        'contractId' => $contractId
                        );
                $result = $db->insert($table,$data);
                if ($result) {
                  $table = "showads";
                  $field = "max(id) as maxId";
                  $where = "";
                  $on = "";
                  $db->select($table,$field,$on,$where);
                  $result = $db->getResult();
                  $decode = json_decode($result, true);
                  //print_r($decode);
                  $maxId = $decode['post'][0]['maxId'];
                  $showAdsId = $maxId+1;
                  $data = array('id' => $showAdsId,
                          'adsId' => $adsId,
                          'slotId' => $slotId,
                          'adsPlacementId'=> 1,
                          'showStat' => 1
                          );
                  $result = $db->insert($table,$data);
                }
              }
            }
          }
        }else if ($menu == 'recAds') {
          $adsId = $valueCtr['adsId'];
          $table='campaign';
          $field = "max(id) as maxId";
          $where = "id like '$today%'";
          $on = "";
          $db->select($table,$field,$on,$where);
          $result = $db->getResult();
          $decode = json_decode($result, true);
          //print_r($decode);
          $maxId = $decode['post'][0]['maxId'];
          $substring = substr($maxId,6,4);
          $substring++;
          $campaignId = $today.sprintf('%04s',$substring);
          $data = array('id' => $campaignId,
                  'adsId' => $adsId,
                  'contractId' => $contractId
                  );
          $result = $db->insert($table,$data);
          if ($result) {
            foreach ($dataSlot as $keySlot => $valueSlot) {
              if ($adsId == $valueSlot['adsId']) {
                $table = "slot";
                $field = "max(id) as maxId";
                $where = "";
                $on = "";
                $dateSlot = $valueSlot['date'];
                $daysSlot = $valueSlot['days'];
                $priceId = $valueSlot['priceId'];
                //$adsId = $valueSlot['adsId'];
                $timeId = $valueSlot['timeId'];
                $db->select($table,$field,$on,$where);
                $result = $db->getResult();
                $decode = json_decode($result, true);
                //print_r($decode);
                $maxId = $decode['post'][0]['maxId'];
                $slotId = $maxId+1;
                //echo $contractId;

                $data = array('id' => $slotId,
                        'date' => $dateSlot,
                        'days' => $daysSlot,
                        'adsId'=> $adsId,
                        'timeId' => $timeId,
                        'slotPriceId' => $priceId,
                        'contractId' => $contractId
                        );
                $result = $db->insert($table,$data);
                if ($result) {
                  $table = "showads";
                  $field = "max(id) as maxId";
                  $where = "";
                  $on = "";
                  $db->select($table,$field,$on,$where);
                  $result = $db->getResult();
                  $decode = json_decode($result, true);
                  //print_r($decode);
                  $maxId = $decode['post'][0]['maxId'];
                  $showAdsId = $maxId+1;
                  $data = array('id' => $showAdsId,
                          'adsId' => $adsId,
                          'slotId' => $slotId,
                          'adsPlacementId'=> 1,
                          'showStat' => 1
                          );
                  $result = $db->insert($table,$data);
                  }
                }
              }
            }
          }
        }
      }
    }
      unset($_SESSION['contract']);
      unset($_SESSION['slot']);
      header('location: ../index.php?modul=contract');
  }else {
    echo "SORRY SOMETHING WRONG";
  }


 ?>
