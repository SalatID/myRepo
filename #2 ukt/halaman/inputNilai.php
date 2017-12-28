<?php
  include '../lib/config.php';
  session_start();
  $db = new config ();
  $count = $_POST['count'];
  //echo $count;
  $data = array ();
  for ($i=0; $i < $count; $i++) {
    $kelompok = $_POST['kelompok'];
    $penilai = $_POST['penilai'];
    $jurus = $_POST['jurus'];
    //echo $penilai.$jurus;
    $nilai = $_POST["nilai$i"];
    //echo $nilai."</br>";
    $pesertaId = $_POST["pesertaId$i"];
    //echo "peserta".$pesertaId."</br>";

    $table = "nilai";
  	$field = "max(id) as maxId";
  	$where = "";
  	$on = "";
  	$db->select($table,$field,$on,$where);
  	$hasil = $db->getResult();
  	$decode = json_decode($hasil, true);
    //print_r($decode);
  	$maxId = $decode['post'][0]['maxId'];
    $maxId = $maxId +1;
    $newId = sprintf('%03s',$maxId);
    //echo $newId;

    $data = array('id' => $newId,
  					'pengujiId' => $penilai,
  					'subKatJurusId' => $jurus,
  					'nilai' => $nilai,
            'kelompokId' => $kelompok,
  					'pesertaId' => $pesertaId
  				  );
    $result = $db->insert($table,$data);
  }
  if ($result) {
    $sudahDinilai = array();
    if(isset($_SESSION['sudahDinilai'])){
        $sudahDinilai['jurus'] = $jurus;
      array_push($_SESSION['sudahDinilai'],$sudahDinilai);
    }
    else{
      $_SESSION['sudahDinilai'] = [];
      $sudahDinilai['jurus'] = $jurus;
      array_push($_SESSION['sudahDinilai'],$sudahDinilai);
  }
  print_r($_SESSION['sudahDinilai']);
  header('location: dashboard.php?modul=home');
  }
 ?>
