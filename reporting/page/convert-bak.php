<?php
include 'engine.php';
$getDataCity = new getDataCity();
$reporting = new reporting();
$decode = json_decode($_GET['request'], true);
$param=$decode['request'];
//print_r($param);
foreach ($param as $keyParam => $valueParam) {
if ($valueParam['convertReporting']['convertReportingStat']==true) {
  $typeOfReporting = $valueParam['typeOfReportingId'];
  $maxDate = $valueParam['maxDate'];
  $minDate = $valueParam['minDate'];
  $offset = $valueParam['offset'];
  $rows = $valueParam['rows'];
  $rows = $valueParam ['rows'];
  if ($typeOfReporting==1) {
    $result = $reporting->selectTrx($minDate,$maxDate,$offset,$rows);
  }elseif ($typeOfReporting==2) {
    $result = $reporting->selectClick($minDate,$maxDate,$offset,$rows);
  }
  $decode = json_decode($result,true);
  $dataCell = $decode['response'];
  if ($decode['response']['success']==true) {
    if ($valueParam['convertReporting']['typeReporting']=='pdf') {
      convertToPDF($typeOfReporting,$dataCell,$offset);
    }elseif ($valueParam['convertReporting']['typeReporting']=='excel') {
      convertToExcel($typeOfReporting,$dataCell,$offset);
    }else {
      $rows = $valueParam ['rows'];
      $result = $reporting->selectTrx($minDate,$maxDate,$offset,$rows);
      print_r($result);
    }
  }
}
}
function convertToPDF($typeOfReporting, $dataCell,$offset){
  if ($typeOfReporting==1) {
    #setting judul laporan dan header tabel
    $judul = "LAPORAN DATA DATA TRANSAKSI IKLANIN AJA .COM";
    $header = array(
        array("label"=>"NO", "length"=>8, "align"=>"C"),
        array("label"=>"CONTRACT ID", "length"=>50, "align"=>"C"),
        array("label"=>"PAYMENT DATE", "length"=>65, "align"=>"C"),
        array("label"=>"TOTAL PAYMENT", "length"=>65, "align"=>"C")
      );
  }elseif ($typeOfReporting==2) {
    $judul = "LAPORAN DATA JUMLAH KLIK IKLANIN AJA .COM";
    $header = array(
        array("label"=>"NO", "length"=>8, "align"=>"C"),
        array("label"=>"ADS ID", "length"=>50, "align"=>"C"),
        array("label"=>"DATE", "length"=>65, "align"=>"C"),
        array("label"=>"TOTAL CLICK", "length"=>65, "align"=>"C")
      );
  }

  #sertakan library FPDF dan bentuk objek
  require_once ("../fpdf/fpdf.php");
  $pdf = new FPDF();
  $pdf->AddPage();

  #tampilkan judul laporan
  $pdf->SetFont('Arial','B','16');
  $pdf->Ln();
  $pdf->Cell(0,20, $judul, '0', 1, 'C');
  $pdf->SetFont('Arial','','12');
  $pdf->Image('../css/img/logo.jpg',185,25,-300);
  $startDate = $dataCell['startDate'];
  $endDate = $dataCell['endDate'];
  if ($typeOfReporting==1) {
    $pdf->Cell(0,5, 'Jenis Reporting : Transaksi', '0', 1, 'L');
  }elseif ($typeOfReporting==2) {
    $pdf->Cell(0,5, 'Jenis Reporting : Click', '0', 1, 'L');
  }
  $pdf->Cell(0,5, "Start Date : $startDate", '0', 1, 'L');
  $pdf->Cell(0,5, "End Date : $endDate", '0', 1, 'L');
  $pdf->Ln();
  #buat header tabel
  $pdf->SetFont('Arial','','10');
  $pdf->SetFillColor(255,0,0);
  $pdf->SetTextColor(255);
  $pdf->SetDrawColor(128,0,0);
  foreach ($header as $valueHeader) {
    $pdf->Cell($valueHeader['length'], 5, $valueHeader['label'], 1, '0', $valueHeader['align'], true);
  }
  $pdf->Ln();

  #tampilkan data tabelnya
  $pdf->SetFillColor(224,235,255);
  $pdf->SetTextColor(0);
  $pdf->SetFont('');
  $fill=false;
  //print_r($dataCell);
  if ($typeOfReporting==1) {
      foreach ($dataCell['data'] as $keyCell => $valueCell) {
        //print_r($cell['id']);
        $pdf->Cell(8, 5, (($keyCell+1)+$offset), 1, '0', 'C', $fill);
        $pdf->Cell(50, 5, $valueCell['contractId'], 1, '0', 'C', $fill);
        $pdf->Cell(65, 5, $valueCell['paymentDate'], 1, '0', 'C', $fill);
        $pdf->Cell(65, 5, $valueCell['totalPayment']." ".$valueCell['curencyCode'], 1, '0', 'C', $fill);
        $pdf->Ln();
      }

  }elseif ($typeOfReporting==2) {
        foreach ($dataCell['data'] as $keyCell => $valueCell) {
        //print_r($cell['id']);
        $pdf->Cell(8, 5, (($keyCell+1)+$offset), 1, '0', 'C', $fill);
        $pdf->Cell(50, 5, $valueCell['adsId'], 1, '0', 'C', $fill);
        $pdf->Cell(65, 5, $valueCell['date'], 1, '0', 'C', $fill);
        $pdf->Cell(65, 5, $valueCell['totalClick'], 1, '0', 'C', $fill);
        $pdf->Ln();
      }

  }
  #output file PDF
  $pdf->Output('D','reporting.pdf');
}
function convertToExcel($typeOfReporting, $dataCell,$offset){
  if ($typeOfReporting==1) {
    #setting judul laporan dan header tabel
    $judul = "LAPORAN DATA DATA TRANSAKSI IKLANIN AJA .COM";
    $header = array("NO","CONTRACT ID","CONTRACT DATE","TOTAL PAYMENT");
  }elseif ($typeOfReporting==2) {
    $judul = "LAPORAN DATA JUMLAH KLIK IKLANIN AJA .COM";
    $header = array("NO","ADS ID","DATE","TOTAL CLICK");
  }
  include '../lib/Classes/PHPExcel.php';
  /*start - BLOCK PROPERTIES FILE EXCEL*/
  $file = new PHPExcel ();
  $FontColor = new PHPExcel_Style_Color();
/*end - BLOCK PROPERTIES FILE EXCEL*/

/*start - BLOCK SETUP SHEET*/
  $file->createSheet ( NULL,0);
  $file->setActiveSheetIndex ( 0 );
  $sheet = $file->getActiveSheet ( 0 );
  //memberikan title pada sheet
  $sheet->setTitle ( "Nilai" );
/*end - BLOCK SETUP SHEET*/
//print_r($dataCell);
/*start - BLOCK HEADER*/

$sheet->setCellValue ("A1",$judul);
$s = 'A';
//$color = $FontColor->setRGB('ce0303');
foreach ($header as $keyHeader => $valueHeader) {
  $cell = $s."6";
  $merge = $s."1";
  $sheet	->setCellValue ( $cell, $valueHeader );
  $s = chr(ord($s) + 1);
  $sheet->getStyle($cell)->getFill()->applyFromArray(
   array(
     'type' => PHPExcel_Style_Fill::FILL_SOLID,
     'startcolor' => array('rgb' => 'ff2d2d'),
     'font' => array('bold' => true)
     )
    );
}

$thin = array ();
$thin['borders']=array();
$thin['borders']['allborders']=array();
$thin['borders']['allborders']['style']=PHPExcel_Style_Border::BORDER_THIN ;

$sheet->mergeCells('A1:'.$merge);
$style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );
    $sheet->mergeCells('A3:B3');
    $sheet->mergeCells('A4:B4');
    $sheet->mergeCells('A5:B5');
    $sheet->getStyle('A1:'.$merge)->applyFromArray($style);
    $sheet->getStyle('A1:'.$merge)->getFont()->setSize(16);
    $sheet->getStyle('A1:'.$merge)->getFont()->setBold(true);
/*end - BLOCK HEADER*/
if ($typeOfReporting==1) {
  $sheet	->setCellValue ( "A3","Jenis Reporting : Transaksi");
  foreach ($dataCell['data'] as $keyCell => $valueCell) {
    $startCell = 'A'.($keyCell+7);
    $endCell = 'D'.($keyCell+7);
    //print_r($cell['id']);
    $sheet	->setCellValue ( "A".($keyCell+7), (($keyCell+1)+$offset))
    ->setCellValue ( "B".($keyCell+7), $valueCell['contractId'] )
    ->setCellValue ( "C".($keyCell+7), $valueCell['paymentDate'] )
    ->setCellValue ( "D".($keyCell+7), $valueCell['totalPayment']." ".$valueCell['curencyCode'] );
  }
  $sheet->getStyle ( 'A6:'.$endCell )->applyFromArray ($thin);
}elseif ($typeOfReporting==2) {
  $sheet->setCellValue ( "A3","Jenis Reporting : Click");
  foreach ($dataCell['data'] as $keyCell => $valueCell) {
    $startCell = 'A'.($keyCell+7);
    $endCell = 'D'.($keyCell+7);
    //print_r($cell['id']);
    $sheet->setCellValue ( "A".($keyCell+7), (($keyCell+1)+$offset) )
    ->setCellValue ( "B".($keyCell+7), $valueCell['adsId'] )
    ->setCellValue ( "C".($keyCell+7), $valueCell['date'] )
    ->setCellValue ( "D".($keyCell+7), $valueCell['totalClick'] );
  }
  $sheet->getStyle ( 'A6:'.$endCell )->applyFromArray ($thin);
}
$sheet	->setCellValue ( "A4",'Mulai Tanggal : '.$dataCell['startDate']);
$sheet	->setCellValue ( "A5",'Sampai Tanggal : '.$dataCell['endDate']);

//Mengatur lebar cell pada documen excel
$sheet->getColumnDimension('A')->setWidth(5);
$sheet->getColumnDimension('B')->setWidth(20);
$sheet->getColumnDimension('C')->setWidth(20);
$sheet->getColumnDimension('D')->setWidth(15);
$sheet->getStyle('A3:'.$endCell)->applyFromArray($style);

  $writer = PHPExcel_IOFactory::createWriter ( $file, 'Excel5' );

  header ( 'Content-Type: application/vnd.ms-excel' );
  header('Content-Disposition: attachment; filename="nilai.xls"');
  header('Cache-Control: private, max-age=0, must-revalidate');
  header ( 'Content-Transfer-Encoding: binary' );
  echo 'this->'.$writer->save( 'php://output' );
}
 ?>
