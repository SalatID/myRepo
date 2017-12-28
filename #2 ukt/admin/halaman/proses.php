<?php
  session_start();
  include '../../lib/config.php';
  $db = new config();
  if (isset($_POST['namaKelompok']) && isset($_POST['ts']) && isset($_POST['penilai'])) {
      $arrayKelompok = array ();
      if(isset($_SESSION['kelompok'])){
        foreach ($_SESSION['kelompok'] as $key => $value) {
          $arrayKelompok['namaKelompok'] = $_POST['namaKelompok'];
          $arrayKelompok['ts'] = $_POST['ts'];
          $arrayKelompok['penilai'] = $_POST['penilai'];
        }
        array_push($_SESSION['kelompok'],$arrayKelompok);
      }
      else{
        $_SESSION['kelompok'] = [];
        $arrayKelompok['namaKelompok'] = $_POST['namaKelompok'];
        $arrayKelompok['ts'] = $_POST['ts'];
        $arrayKelompok['penilai'] = $_POST['penilai'];
        array_push($_SESSION['kelompok'],$arrayKelompok);
  }
  $filterPenilai = null;
  foreach ($_SESSION['kelompok'] as $key => $value) {
    if ($filterPenilai == null) {
      $filterPenilai = $value['penilai'];
    }else {
      $filterPenilai .= ','.$value['penilai'];
    }
  }
  echo $filterPenilai;
}elseif (isset($_POST['tambahAnggotaKel'])) {
  $arrayPeserta = array ();
  echo $_POST['tambahAnggotaKel'];
  $explode = explode(",",$_POST['tambahAnggotaKel']);
  $idPeserta = $explode[0];
  $idKelompok = $explode[1];
  if(isset($_SESSION['peserta'])){
    foreach ($_SESSION['peserta'] as $key => $value) {
      $arrayPeserta['idPeserta'] = $idPeserta;
      $arrayPeserta['idKelompok'] = $idKelompok;
    }
    array_push($_SESSION['peserta'],$arrayPeserta);
  }
  else{
    $_SESSION['peserta'] = [];
    $arrayPeserta['idPeserta'] = $idPeserta;
    $arrayPeserta['idKelompok'] = $idKelompok;
    array_push($_SESSION['peserta'],$arrayPeserta);
}
}elseif (isset($_POST['idDeleteAnggotaSess'])) {
  $id = $_POST['idDeleteAnggotaSess'];
  echo $id;
  unset($_SESSION['peserta'][$id]);
}
 ?>
