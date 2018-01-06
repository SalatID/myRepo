<?php
include 'engine.php';
$getDataCity = new getDataCity();
$reporting = new reporting();
$decode = json_decode($_GET['request'], true);
$param=$decode['request'];
//print_r($param);
if ($param['properties']['convertReportingStat']==true) {
  $typeOfReporting = $param['properties']['typeOfReportingId'];
  $maxDate = $param['filter']['maxDate'];
  $minDate = $param['filter']['minDate'];
  $rows = $param['limit']['rows'];
  $offset = (($param['limit']['offset']-1)*$rows);
  $order = $param['order']['fieldName'].' '.$param['order']['type'];
    if ($typeOfReporting==1) {
    $result = $reporting->selectTrx($minDate,$maxDate,$offset,$rows,$order);
  }elseif ($typeOfReporting==2) {
    $result = $reporting->selectClick($minDate,$maxDate,$offset,$rows,$order);
  }
  $decode = json_decode($result,true);
  $dataCell = $decode['response'];
  if ($decode['response']['error']==0) {
    if ($param['properties']['typeReporting']=='pdf') {
      convertToPDF($typeOfReporting,$dataCell,$offset);
    }elseif ($param['properties']['typeReporting']=='excel') {
      convertToExcel($typeOfReporting,$dataCell,$offset);
    }else {
      $rows = $param['limit']['rows'];
      $result = $reporting->selectTrx($minDate,$maxDate,$offset,$rows);
      print_r($result);
    }
  }
}
function convertToPDF($typeOfReporting, $dataCell,$offset){
  require_once ("../lib/fpdf/fpdf.php");
  class PDF extends FPDF
{
    function Footer()
    {
      $generateDate = date('Y-m-d H:i:s ').'GMT'.date('P');
      //atur posisi 1.5 cm dari bawah
      $this->SetY(-15);
      //buat garis horizontal
      $this->Line(10,$this->GetY(),200,$this->GetY());
      //Arial italic 9
      $this->SetFont('Arial','I',9);
      //nomor halaman
      $this->Cell(0,10,'Generate Date : '.$generateDate,0,0,'L');
      $this->Cell(0,10,$this->PageNo().' of {nb}',0,0,'R');
    }
}
  #output file PDF
  $pdf = new PDF();
  $pdf->AliasNbPages();
  $judul = $dataCell['docAttribute']['title'];
  $header = array();
  $length = 8;
  foreach ($dataCell['tableHeader'] as $keyData => $valueData) {
    $header[] = array("label"=>$valueData['col'], "length"=>$length, "align"=>"C");
    switch ($length) {
      case 8:
        $length = 50;
        break;
      case 50:
        $length = 65;
        break;
      case 65:
        $length = 65;
        break;
      default:
        $length=8;
        break;
    }
  }
  $pdf->AddPage();
  #tampilkan judul laporan
  $pdf->SetFont('Arial','B','16');
  $pdf->Ln();
  $pdf->Cell(0,20, $judul, '0', 1, 'C');
  $pdf->SetFont('Arial','','12');
  $pdf->Image('../css/img/logo.jpg',185,25,-300);
  $startDate = $dataCell['docAttribute']['startDate'];
  $endDate = $dataCell['docAttribute']['endDate'];
  $pdf->SetFillColor(230, 230, 230);
  $pdf->Cell(40,5, 'Type Of Reporting ', '0', '0', 'L', true);
  $fill=false;
  $pdf->Cell(40,5, ': '.$dataCell['docAttribute']['typeOfReporting'], '0', '0', 'L', $fill);
  $pdf->Ln();
  $pdf->SetFillColor(230, 230, 230);
  $pdf->Cell(40,5, "Start Date ", '0', '0', 'L', true);
  $fill=false;
  $pdf->Cell(40,5,': '.$dataCell['docAttribute']['startDate'], '0', '0', 'L', $fill);
  $pdf->Ln();
  $pdf->SetFillColor(230, 230, 230);
  $pdf->Cell(40,5, "End Date ", '0', '0', 'L', true);
  $fill=false;
  $pdf->Cell(40,5,': '.$dataCell['docAttribute']['endDate'], '0', '0', 'L', $fill);
  $pdf->Ln();
  $pdf->Cell(40,5,' ');
  $pdf->Ln();
  #buat header tabel
  $pdf->SetFont('Arial','','10');
  $pdf->SetFillColor(122, 215, 255);
  $pdf->SetTextColor(0, 0, 0);
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

  $pdf->Output('D','reporting.pdf');
}
function convertToExcel($typeOfReporting, $dataCell,$offset){
  $generateDate = date('Y-m-d H:i:s ').'GMT'.date('P');
  $judul = $dataCell['docAttribute']['title'];
  $header = array();
  foreach ($dataCell['tableHeader'] as $keyData => $valueData) {
    $header[] = $valueData['col'];
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
  $cell = $s."9";
  $merge = $s."1";
  $sheet->setCellValue ( $cell, $valueHeader );
  $sheet->getStyle($cell)->getFont()->setBold(true);
  $s = chr(ord($s) + 1);
  $sheet->getStyle($cell)->getFill()->applyFromArray(
   array(
     'type' => PHPExcel_Style_Fill::FILL_SOLID,
     'startcolor' => array('rgb' => '7AD7FF'),
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
    $sheet->mergeCells('A4:B4');
    $sheet->mergeCells('A5:B5');
    $sheet->mergeCells('A6:B6');
    $sheet->mergeCells('A7:B7');
    $sheet->getStyle('A1:'.$merge)->applyFromArray($style);
    $sheet->getStyle('A1:'.$merge)->getFont()->setSize(16);
    $sheet->getStyle('A1:'.$merge)->getFont()->setBold(true);
/*end - BLOCK HEADER*/
$sheet->setCellValue ( "A4","Type Of Reporting");
$sheet->setCellValue ( "C4",': '.$dataCell['docAttribute']['typeOfReporting']);
$sheet->setCellValue ( "A5",'Mulai Tanggal');
$sheet->setCellValue ( "C5",': '.$dataCell['docAttribute']['startDate']);
$sheet->setCellValue ( "A6",'Sampai Tanggal');
$sheet->setCellValue ( "C6",': '.$dataCell['docAttribute']['endDate']);
$sheet->setCellValue ( "A7",'Generate Date : ');
$sheet->setCellValue ( 'C7',': '.$generateDate);
$style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        )
    );
$sheet->getStyle('A4:C7')->applyFromArray($style);
$color = array(
  'type' => PHPExcel_Style_Fill::FILL_SOLID,
  'startcolor' => array('rgb' => 'E6E6E6'),
  'font' => array('bold' => true)
);
  $sheet->getStyle('A4')->getFill()->applyFromArray($color);
  $sheet->getStyle('A4')->getFont()->setBold(true);
  $sheet->getStyle('A5')->getFill()->applyFromArray($color);
  $sheet->getStyle('A5')->getFont()->setBold(true);
  $sheet->getStyle('A6')->getFill()->applyFromArray($color);
  $sheet->getStyle('A6')->getFont()->setBold(true);
  $sheet->getStyle('A7')->getFill()->applyFromArray($color);
  $sheet->getStyle('A7')->getFont()->setBold(true);
if ($typeOfReporting==1) {
  foreach ($dataCell['data'] as $keyCell => $valueCell) {
    $startCell = 'A'.($keyCell+10);
    $endCell = 'D'.($keyCell+10);
    //print_r($cell['id']);
    $sheet	->setCellValue ( "A".($keyCell+10), (($keyCell+1)+$offset))
    ->setCellValue ( "B".($keyCell+10), $valueCell['contractId'] )
    ->setCellValue ( "C".($keyCell+10), $valueCell['paymentDate'] )
    ->setCellValue ( "D".($keyCell+10), $valueCell['totalPayment']." ".$valueCell['curencyCode'] );
  }
  $sheet->getStyle ( 'A9:'.$endCell )->applyFromArray ($thin);
}elseif ($typeOfReporting==2) {
  foreach ($dataCell['data'] as $keyCell => $valueCell) {
    $startCell = 'A'.($keyCell+10);
    $endCell = 'D'.($keyCell+10);
    //print_r($cell['id']);
    $sheet->setCellValue ( "A".($keyCell+10), (($keyCell+1)+$offset) )
    ->setCellValue ( "B".($keyCell+10), $valueCell['adsId'] )
    ->setCellValue ( "C".($keyCell+10), $valueCell['date'] )
    ->setCellValue ( "D".($keyCell+10), $valueCell['totalClick'] );
  }
  $sheet->getStyle ( 'A9:'.$endCell )->applyFromArray ($thin);
}
//Mengatur lebar cell pada documen excel
$sheet->getColumnDimension('A')->setWidth(5);
$sheet->getColumnDimension('B')->setWidth(30);
$sheet->getColumnDimension('C')->setWidth(30);
$sheet->getColumnDimension('D')->setWidth(15);
$sheet->getStyle('A3:'.$endCell)->applyFromArray($style);

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('test_img');
$objDrawing->setDescription('test_img');
$objDrawing->setPath('../css/img/logo.jpg');
$objDrawing->setCoordinates('D3');
$objDrawing->setWidth(50);
$objDrawing->setResizeProportional(true);
$objDrawing->setWorksheet($sheet);
$style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );
    $sheet->getStyle('D4')->applyFromArray($style);

  $writer = PHPExcel_IOFactory::createWriter ( $file, 'Excel5' );

  header ( 'Content-Type: application/vnd.ms-excel' );
  header('Content-Disposition: attachment; filename="nilai.xls"');
  header('Cache-Control: private, max-age=0, must-revalidate');
  header ( 'Content-Transfer-Encoding: binary' );
  echo 'this->'.$writer->save( 'php://output' );
}
 ?>
