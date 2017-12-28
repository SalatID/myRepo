<?php
  include '../halaman/excel.php';
  $data = array();
  $count = $_POST['count'];
  for ($i=0; $i < $count ; $i++) {
    $namaPeserta = $_POST["namaPeserta$i"];
    $tempatLahir = $_POST["tempatLahir$i"];
    $tglLahir = $_POST["tglLahir$i"];
    $tsAwal = $_POST["tsAwal$i"];
    $pengujiId = $_POST["pengujiId$i"];
    $kaidah = $_POST["kaidah$i"];
    $tradisional = $_POST["tradisional$i"];
    $prasetya = $_POST["prasetya$i"];
    $bPraktis = $_POST["bPraktis$i"];
    $fisTek = $_POST["fisTek$i"];
    $aerobTes = $_POST["aerobTes$i"];
    $sHindar = $_POST["sHindar$i"];
    $data[$i]['NamaPeserta'] =$namaPeserta;
    $data[$i]['TempatLahir'] =$tempatLahir;
    $data[$i]['TanggalLahir'] =$tglLahir;
    $data[$i]['TsAwal'] = $tsAwal;
    $data[$i]['TsAkhir']= 0;
    $data[$i]['Penguji'] = $pengujiId;
    $data[$i]['Kaidah'] = $kaidah;
    $data[$i]['Tradisional'] = $tradisional;
    $data[$i]['Prasetya'] = $prasetya;
    $data[$i]['BeladiriPraktis'] = $bPraktis;
    $data[$i]['FisikTeknik'] = $fisTek;
    $data[$i]['AerobTes'] = $aerobTes;
    $data[$i]['SerangHindar'] = $sHindar;
  }
  //print_r($data)
  createExcel("keluarga",$data);
 ?>
