<?php
  session_start();
  include '../../lib/config.php';
  $db = new config();

  if (isset($_SESSION['kelompok']) && isset($_SESSION['peserta'])) {
    foreach ($_SESSION['kelompok'] as $keyKel => $valueKel) {
      $table = "kelompok";
    	$field = "max(id) as maxId";
    	$where = "";
    	$on = "";
    	$db->select($table,$field,$on,$where);
    	$hasil = $db->getResult();
    	$decode = json_decode($hasil, true);
      //print_r($decode);
    	$maxId = $decode['post'][0]['maxId'];
      $maxId = $maxId +1;

      $nameKelompok = $valueKel['namaKelompok'];
      $tsId = $valueKel['ts'];
      $penilaiId = $valueKel['penilai'];

    	$data = array('id' => $maxId,
    					'nameKelompok' => $nameKelompok,
    					'tsId' => $tsId,
    					'penilaiId' => $penilaiId
    				  );
    	$result = $db->insert($table,$data);
      //echo $result;
      if ($result) {
        foreach ($_SESSION['peserta'] as $keyPeserta => $valuePeserta) {
          if ($keyKel == $valuePeserta['idKelompok']) {
            $table = 'peserta';
            $id = $valuePeserta['idPeserta'];
            $updateAds = array ('kelompokId' => $maxId
          						);
          	$where = 'id ='.$id;
            print_r($updateAds);
            $result = $db->update($table,$updateAds,$where);
          }
        }
      }
    }
      unset($_SESSION['kelompok']);
      unset($_SESSION['peserta']);
      header('location: dashboard.php?modul=kelompok');
  }
 ?>
