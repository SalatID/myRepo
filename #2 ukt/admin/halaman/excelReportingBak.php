<?php
  include '../../lib/Classes/PHPExcel.php';
  /*start - BLOCK PROPERTIES FILE EXCEL*/
	$file = new PHPExcel ();
	$file->getProperties ()->setCreator ( "SMI" );
	$file->getProperties ()->setLastModifiedBy ( "SMI" );
	$file->getProperties ()->setTitle ( "Nilai UKT" );
	$file->getProperties ()->setSubject ( "Nilai UKT 2017" );
	$file->getProperties ()->setDescription ( "Ujian Kenaikan Tingkat 2017" );
	$file->getProperties ()->setKeywords ( "Nilai UKT" );
	$file->getProperties ()->setCategory ( "UKT" );
/*end - BLOCK PROPERTIES FILE EXCEL*/

/*start - BLOCK SETUP SHEET*/
	$file->createSheet ( NULL,0);
	$file->setActiveSheetIndex ( 0 );
	$sheet = $file->getActiveSheet ( 0 );
	//memberikan title pada sheet
	$sheet->setTitle ( "Nilai" );
/*end - BLOCK SETUP SHEET*/

/*start - BLOCK HEADER*/
	$sheet	->setCellValue ( "A1", "No" )
    ->setCellValue ( "B1", "No. Peserta" )
    ->setCellValue ( "C1", "Nama" )
		->setCellValue ( "D1", "Tempat Lahir" )
		->setCellValue ( "E1", "Tanggal Lahir" )
		->setCellValue ( "F1", "TS Awal" )
		->setCellValue ( "G1", "TS Akhir" )
    ->setCellValue ( "H1", "Penguji" )
    ->setCellValue ( "I1", "Kaidah" )
    ->setCellValue ( "J1", "Tradisional" )
    ->setCellValue ( "K1", "Prasetya" )
    ->setCellValue ( "L1", "Beladiri Praktis" )
    ->setCellValue ( "M1", "Fisik Teknik" )
    ->setCellValue ( "N1", "Aerobik Tes" )
    ->setCellValue ( "O1", "Kuda-Kuda Dasar" )
    ->setCellValue ( "P1", "Serang Hindar" );
/*end - BLOCK HEADER*/
  $data = array();
  $count = $_POST['count'];
  for ($i=0; $i < $count ; $i++) {
    $noPeserta =sprintf('%03s',$_POST["noPeserta$i"]);
    $namaPeserta = $_POST["namaPeserta$i"];
    $tempatLahir = $_POST["tempatLahir$i"];
    $tglLahir = $_POST["tglLahir$i"];
    $tsAwal = $_POST["tsAwal$i"];
    $tsAkhir = $_POST["tsAkhir$i"];
    $pengujiId = $_POST["pengujiId$i"];
    $kaidah = $_POST["kaidah$i"];
    $tradisional = $_POST["tradisional$i"];
    $prasetya = $_POST["prasetya$i"];
    $bPraktis = $_POST["bPraktis$i"];
    $fisTek = $_POST["fisTek$i"];
    $aerobTes = $_POST["aerobTes$i"];
    $kDasar = $_POST["kDasar$i"];
    $sHindar = $_POST["sHindar$i"];
    $sheet	->setCellValue ( "A".($i+2), ($i+1) )
  ->setCellValue ( "B".($i+2), $noPeserta )
  ->setCellValue ( "C".($i+2), $namaPeserta )
  ->setCellValue ( "D".($i+2), $tempatLahir )
  ->setCellValue ( "E".($i+2), $tglLahir )
  ->setCellValue ( "F".($i+2), $tsAwal )
  ->setCellValue ( "G".($i+2), $tsAkhir )
  ->setCellValue ( "H".($i+2), $pengujiId )
  ->setCellValue ( "I".($i+2), $kaidah )
  ->setCellValue ( "J".($i+2), $tradisional )
  ->setCellValue ( "K".($i+2), $prasetya )
  ->setCellValue ( "L".($i+2), $bPraktis )
  ->setCellValue ( "M".($i+2), $fisTek )
  ->setCellValue ( "N".($i+2), $aerobTes )
  ->setCellValue ( "O".($i+2), $kDasar )
  ->setCellValue ( "P".($i+2), $sHindar );
  }
  /* start - BLOCK MEMBUAT LINK DOWNLOAD*/
  	header ( 'Content-Type: application/vnd.ms-excel' );
  	//namanya adalah keluarga.xls
  	header ( 'Content-Disposition: attachment;filename="nilai.xls"' );
  	header ( 'Cache-Control: max-age=0' );
  	$writer = PHPExcel_IOFactory::createWriter ( $file, 'Excel5' );
  	$writer->save ( 'php://output' );
  /* start - BLOCK MEMBUAT LINK DOWNLOAD*/
 ?>
