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
    ->setCellValue ( "H1", "Kaidah" )
    ->setCellValue ( "I1", "Tradisional" )
    ->setCellValue ( "J1", "Prasetya" )
    ->setCellValue ( "K1", "Beladiri Praktis" )
    ->setCellValue ( "L1", "Fisik Teknik" )
    ->setCellValue ( "M1", "Aerobik Tes" )
    ->setCellValue ( "N1", "Kuda-Kuda Dasar" )
    ->setCellValue ( "O1", "Serang Hindar" )
    ->setCellValue ( "P1", "Total" );
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
    $totalNilai = $_POST["totalNilai$i"];
    $s = 'G';
    $sheet	->setCellValue ( "A".($i+2), ($i+1) )
  ->setCellValue ( "B".($i+2), $noPeserta )
  ->setCellValue ( "C".($i+2), $namaPeserta )
  ->setCellValue ( "D".($i+2), $tempatLahir )
  ->setCellValue ( "E".($i+2), $tglLahir )
  ->setCellValue ( "F".($i+2), $tsAwal )
  ->setCellValue ( "G".($i+2), $tsAkhir );
    for ($x=0; $x < 8; $x++) {
      $value = ('value'.$i);
      $value = $_POST["$i$x"];
      $s = ( chr(ord($s) + 1));
      $sheet -> setCellValue ($s.($i+2), $value);
      //echo $s."</br>";
      //$isiSheet .= '->setCellValue '.'('.( chr(ord($s) + 1).($i+2).', '.$value.' )';
    }
    $sheet	->setCellValue ( "P".($i+2), $totalNilai );
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
