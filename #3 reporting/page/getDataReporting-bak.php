<?php
    include 'engine.php';
    $getDataCity = new getDataCity();
    $reporting = new reporting();
    if (isset($_POST['provincesId'])) {
      $decode = json_decode($_POST['provincesId'], true);
      $provincesId = $decode['post']['provincesId'];
      print_r($getDataCity->select($provincesId));
    }elseif (isset($_POST['request'])) {
      $decode = json_decode($_POST['request'], true);
      $param=$decode['request'];
      //print_r($param);
      foreach ($param as $keyParam => $valueParam) {
        if ($valueParam['typeOfReportingId']==1) {
          $maxDate = $valueParam['maxDate'];
          $minDate = $valueParam['minDate'];
          $offset = $valueParam['offset'];
          $rows = $valueParam ['rows'];
          $result = $reporting->selectTrx($minDate,$maxDate,$offset,$rows);
          print_r($result);
          //print_r(json_encode($valueParam['convertReporting']['convertReportingStat'])) ;
          if ($valueParam['convertReporting']['convertReportingStat']==true) {

          }
        }elseif ($valueParam['typeOfReportingId']==2) {
          $maxDate = $valueParam['maxDate'];
          $minDate = $valueParam['minDate'];
          $offset = $valueParam['offset'];
          $rows = $valueParam ['rows'];
          print_r($reporting->selectClick($minDate,$maxDate,$offset,$rows));
        }
      }
    }
 ?>
