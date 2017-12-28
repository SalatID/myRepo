<?php
  include '../../lib/config.php';
  $db = new config();
  $namaLengkap = $_POST['namaLengkap'];
  $tempatLahir = $_POST['tempatLahir'];
  $tanggalLahir = $_POST['tanggalLahir'];
  $ts = $_POST['ts'];
  $asalUnit = $_POST['unit'];

  $table = "peserta";
	$field = "max(id) as maxId";
	$where = "";
	$on = "";
	$db->select($table,$field,$on,$where);
	$hasil = $db->getResult();
	$decode = json_decode($hasil, true);
  print_r($decode);
	$maxId = $decode['post'][0]['maxId'];
  $maxId = $maxId +1;
  $newId = sprintf('%03s',$maxId);
  echo $newId;

	$data = array('id' => $newId,
					'namePeserta' => $namaLengkap,
					'tsAwal' => $ts,
					'tsAkhir' => 0,
					'tglLahir' => $tanggalLahir,
					'tempatLahir' => $tempatLahir,
					'unitId' => $asalUnit
				  );


	$result = $db->insert($table,$data);
  if ($result) {
    header('location: dashboard.php?modul=peserta');
  }else {
    header('location: dashboard.php?modul=home&error='.base64_encode('Something Wrong, Please Try Again'));
  }
 ?>
