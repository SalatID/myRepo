<?php
  include '../lib/configReport.php';
  $dbR = new configReport();
  $table = 'typeofreporting';
  $field = '*';
  $dbR->select($table,$field);
  $resultTypeOfReport = $dbR->getResult();
  $decode = json_decode($resultTypeOfReport,true);
  $rowTypeOfReport = $decode['response'];
  //print_r($resultTypeOfReport);

  $table = 'provinces';
  $field = '*';
  $order = 'name ASC';
  $dbR->select($table,$field,$on=null,$where=null,$group=null,$order);
  $resultProvince = $dbR->getResult();
  $decode = json_decode($resultProvince,true);
  //print_r($resultProvince);
  $rowProvince = $decode['response'];
  //echo count($rowTypeOfReport);
  if (count($rowTypeOfReport)!=0 && count($rowProvince)!=0) {
    $success = 'true';
    $arrayTypeOfReporting = $rowTypeOfReport;
    $arrayProvince = $rowProvince;
    $arrayMerge = array('response'=>array('success'=>$success,
                        'TypeOfReporting'=>$arrayTypeOfReporting,
                        'Province'=>$arrayProvince));
  }else {
    $success = 'false';
    $arrayMerge = array('response'=>array('success' => $success));
  }

  $result = json_encode($arrayMerge);
  print_r($result);
 ?>
