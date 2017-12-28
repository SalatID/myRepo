<?php
include '../../lib/config.php';
$db = new config();
if (isset($_POST['idPeserta'])) {
  $id = $_POST['idPeserta'];
  $tableAds ='peserta';
  $where = array("id" => $id);
  $result = $db->delete($tableAds, $where);
  echo $result;

  if ($result) {
    $tableAds ='nilai';
    $where = array("pesertaId" => $id);
    echo $db->delete($tableAds, $where);
  }
} elseif (isset($_POST['idKelompok'])) {
  $id= $_POST['idKelompok'];
  $table = 'kelompok';
  $where = array('id'=>$id);
  $result = $db->delete($table, $where);
  echo $result;
  if ($result) {
    $table = 'peserta';
    $updateAds = array ('kelompokId' => 0
              );
    $where = 'kelompokId ='.$id;
    //print_r($updateAds);
    $result = $db->update($table,$updateAds,$where);
    echo $result;
  }

}
 ?>
