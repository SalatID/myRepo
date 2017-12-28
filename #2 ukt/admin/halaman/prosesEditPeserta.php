<?php
  include '../../lib/config.php';
  $db = new config();
  $id = $_POST['id'];
  $namaLengkap = $_POST['namaLengkap'];
  $tempatLahir = $_POST['tempatLahir'];
  $tanggalLahir = $_POST['tanggalLahir'];
  $tsAwal = $_POST['tsAwal'];
  $tsAkhir = $_POST['tsAkhir'];
  $asalUnit = $_POST['unit'];

  $updatePeserta = array ('namePeserta' => $namaLengkap,
						'tempatLahir' => $tempatLahir,
						'tglLahir' => $tanggalLahir,
						'tsAwal' => $tsAwal,
            'tsAkhir' => $tsAkhir,
            'unitId' => $asalUnit
						);
  print_r($updatePeserta);
  $table = 'peserta';
  $where = 'id ='.$id;
  $result = $db->update($table,$updatePeserta,$where);
  echo $result;

  if ($result) {
    header('location: dashboard.php?modul=peserta');
  }else {
    header('location: dashboard.php?modul=home&error='.base64_encode('Something Wrong, Please Try Again'));
  }
 ?>
