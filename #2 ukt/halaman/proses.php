<?php
session_start();
include '../lib/config.php';
$db = new config ();
if (isset($_POST['kategoriJurus']) && isset($_POST['subKategoriJurus'])) {
  $kategoriJurus = $_POST['kategoriJurus'];
  $subKategoriJurus = $_POST['subKategoriJurus'];
  $jurus = array();
  $jurus['kategoriJurus'] = $kategoriJurus;
  $jurus['subKategoriJurus'] = $subKategoriJurus;
  $_SESSION['jurus']=$jurus;
  //print_r($_SESSION['jurus']);
  header('location: dashboard.php?modul=penilaian');
}
if (isset($_POST['penilai'])) {
  $penilai = $_POST['penilai'];
  $_SESSION['penilai'] = $penilai;
  header('location: dashboard.php?modul=home');
}
if (isset($_POST['idKatJurus'])) {
    $katJurusId = $_POST['idKatJurus'];
    $kelompokId = $_POST['idKelompok'];
    $table = 'nilai';
    $field = 'subKatJurusId';
    $on ="";
    $where = 'kelompokId='.$kelompokId;
    $group ='subKatJurusId';
    $order ='';
    $db->select($table,$field,$on,$where,$group,$order);
    $hasil = $db->getResult();
    $decode = json_decode($hasil,true);
    //print_r($decode);die;
    $rowNilai = $decode['post'];

    $table = 'kelompok';
    $field = '*';
    $on ="";
    $where = 'penilaiId='.$_SESSION['penilai'];
    $group ='';
    $order ='';
    $db->select($table,$field,$on,$where,$group,$order);
    $hasil = $db->getResult();
    $decode = json_decode($hasil,true);
    //print_r($decode);
    $rowKelompok = $decode['post'];

    $table = 'subkatjurus';
    $field = '*';
    $on ="";
    if (count($rowNilai) != 0) {
      $notIn = null;
      foreach ($rowNilai as $keyNilai => $valueNilai) {
        if ($notIn == null) {
          $notIn = $valueNilai['subKatJurusId'];
        }else {
          $notIn .= ','.$valueNilai['subKatJurusId'];
        }
      }
      $where = 'katJurusId ='.$katJurusId.' and (id) NOT IN ('.$notIn.') and tsId<='.$rowKelompok[0]['tsId'];
    }else {
      $where = 'katJurusId ='.$katJurusId.' and tsId<='.$rowKelompok[0]['tsId'];
    }
    //echo $where;
    $group ='';
    $order ='id ASC';
    $db->select($table,$field,$on,$where,$group,$order);
    $hasil = $db->getResult();
    $decode = json_decode($hasil,true);
    $rowSubKatJurus = $decode['post'];
    //print_r($decode);
    if (count($rowSubKatJurus)==0) {
      ?>
      <option value=""><b>--Jurus sudah Dinilai Semua--</b></option>
    <?php
    }
    foreach ($rowSubKatJurus as $keySubKat => $valueSubKat) {
        ?>
        <option value="<?php echo $valueSubKat['id'] ?>" ><?php echo $valueSubKat['nameSubKatJurus'];?></option>
      <?php

      }
}

 ?>
