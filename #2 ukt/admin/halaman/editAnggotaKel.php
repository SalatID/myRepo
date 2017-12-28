<?php
  $id = $_GET['id'];
  $explode = explode(",",$id);
  $idPeserta = $explode[0];
  $idKelompok = $explode[1];
  $updatePeserta = array ('kelompokId' => 0
						);
  $table = 'peserta';
  $where = 'id ='.$idPeserta;
  $result = $db->update($table,$updatePeserta,$where);
  echo $result;
  if ($result) {
    header('location:dashboard.php?modul=editKelompok&id='.$idKelompok);
  }
 ?>
