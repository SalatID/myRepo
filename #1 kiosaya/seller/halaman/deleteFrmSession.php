<?php
  session_start();
  $idSessionContract = $_POST['idSessionContract'];
  $attr = $_POST['attr'] == "" ? "slot" : $_POST['attr'] ;
  if (isset($_POST['attr']) || isset($_POST['idSessionContract'])) {
    //echo $idSessionContract;
    $explode = explode(",",$idSessionContract);
    print_r($explode);
    $idSessionContract=$explode[0];
    echo $idSessionContract;

    if ($attr=='slot') {
      unset($_SESSION['slot'][$idSessionContract]);
    }else {
      unset($_SESSION['contract'][$idSessionContract]);
      if (isset($_SESSION['slot'])) {
        foreach ($_SESSION['slot'] as $keySlot => $valueSlot) {
          if ($valueSlot['adsId']==$explode[1]) {
            unset($_SESSION['slot'][$keySlot]);
          }
        }
        if (isset($explode[2])) {
          include '../../lib/config.php';
          $db = new config ();
          $table = "images";
          $field = "*";
          $where = "id=".$explode[2];
          $on = "";
          $db->select($table,$field,$on,$where);
          $result = $db->getResult();
          $decode = json_decode($result, true);
          $decode = $decode['post'];
          $path = "../../images/".$decode[0]['location'];
          echo $path;
          $result = unlink($path);
          echo $result;
          if ($result) {
            $where = array('id'=> $explode[2]);
          	echo $db->delete($table, $where);
          }
        }
      }

    }
  }else {
    unset($_SESSION['slot']);
    unset($_SESSION['contract']);
    header('location: ../index.php?modul=newContract');
  }


 ?>
