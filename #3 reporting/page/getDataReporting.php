<?php
    include 'engine.php';
    $getDataCity = new getDataCity();
    $reporting = new reporting();

    if (isset($_POST['provincesId'])) {
      $decode = json_decode($_POST['provincesId'], true);
      $provincesId = $decode['post']['provincesId'];
      print_r($getDataCity->select($provincesId));
    }elseif (file_get_contents("php://input")) {
      $json = file_get_contents("php://input");
      //print_r($json);die;
      $decode = json_decode($json, true);

      $param=$decode['param']['request'];
      //print_r($param);
        if ($param['typeOfReportingId']==1) {
          $maxDate = $param['filter']['maxDate'];
          $minDate = $param['filter']['minDate'];
          $rows = $param['limit']['rows'];
          $offset = (($param['limit']['offset']-1)*$rows);
          $result = $reporting->selectTrx($minDate,$maxDate,$offset,$rows);
          print_r($result);
        }elseif ($param['typeOfReportingId']==2) {
          $maxDate = $param['filter']['maxDate'];
          $minDate = $param['filter']['minDate'];
          $rows = $param['limit']['rows'];
          $offset = (($param['limit']['offset']-1)*$rows);
          $result = $reporting->selectClick($minDate,$maxDate,$offset,$rows);
          print_r($result);
          //file_put_contents($file, $result);
        }
    }
 ?>