<?php
    include '../../lib/config.php';
    $db = new config ();
    session_start();
    $id = $_POST['id'];
    $namaKelompok = $_POST['namaKelompok'];
    $penilai = $_POST['penilai'];
    $updateKelompok = array ('nameKelompok' => $namaKelompok,
  						'penilaiId' => $penilai
  						);
    print_r($updateKelompok);
    $table = 'kelompok';
    $where = 'id ='.$id;
    $result = $db->update($table,$updateKelompok,$where);
    echo $result;

      foreach ($_SESSION['peserta'] as $keyPeserta => $valuePeserta) {
          $table = 'peserta';
          $idPeserta = $valuePeserta['idPeserta'];
          $updateAds = array ('kelompokId' => $id
                    );
          $where = 'id ='.$idPeserta;
          print_r($updateAds);
          $result = $db->update($table,$updateAds,$where);
          if ($result) {
            unset($_SESSION['peserta']);
          }
      }
      header('location: dashboard.php?modul=kelompok')

 ?>
