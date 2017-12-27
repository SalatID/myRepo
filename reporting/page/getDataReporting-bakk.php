<?php
    include 'engine.php';
    $getDataCity = new getDataCity();
    $reporting = new reporting();
    if (isset($_POST['provincesId'])) {
      $decode = json_decode($_POST['provincesId'], true);
      $provincesId = $decode['post']['provincesId'];
      print_r($getDataCity->select($provincesId));
    }elseif (isset($_POST['request'])) {
      $decode = json_decode($_POST['request'], true);
      $param=$decode['request'];
      //print_r($param);
      foreach ($param as $keyParam => $valueParam) {
        if ($valueParam['typeOfReportingId']==1) {
          $maxDate = $valueParam['maxDate'];
          $minDate = $valueParam['minDate'];
          $offset = $valueParam['offset'];
          $rows = $valueParam['rows'];
          //print_r(json_encode($valueParam['convertReporting']['convertReportingStat'])) ;
          if ($valueParam['convertReporting']['convertReportingStat']==true) {
            $result = $reporting->selectTrx($minDate,$maxDate,$offset,$rows);
            $decode = json_decode($result,true);
            $dataCell = $decode['response']['data'];
            if ($decode['response']['success']==true) {
              if ($valueParam['convertReporting']['typeReporting']=='pdf') {
                #setting judul laporan dan header tabel
                $judul = "LAPORAN DATA DATA TRANSAKSI IKLANIN AJA .COM";
                $header = array(
                		array("label"=>"NO", "length"=>30, "align"=>"C"),
                		array("label"=>"CONTRACT ID", "length"=>50, "align"=>"C"),
                		array("label"=>"PAYMENT DATE", "length"=>50, "align"=>"C"),
                    array("label"=>"TOTAL PAYMENT", "length"=>50, "align"=>"C")
                	);
                #sertakan library FPDF dan bentuk objek
                require_once ("../fpdf/fpdf.php");
                $pdf = new FPDF();
                $pdf->AddPage();

                #tampilkan judul laporan
                $pdf->SetFont('Arial','B','16');
                $pdf->Cell(0,20, $judul, '0', 1, 'C');

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
                	foreach ($dataCell as $keyCell => $cell) {
                    //print_r($cell['id']);
                    $pdf->Cell(30, 5, ($keyCell+1), 1, '0', 'L', $fill);
                    $pdf->Cell(50, 5, $cell['contractId'], 1, '0', 'L', $fill);
                    $pdf->Cell(50, 5, $cell['paymentDate'], 1, '0', 'L', $fill);
                		$pdf->Cell(50, 5, $cell['totalPayment']." ".$cell['curencyCode'], 1, '0', 'L', $fill);
                		$pdf->Ln();
                	}

                #output file PDF
                $pdf->Output('D','reporting.pdf');
              }elseif ($valueParam['convertReporting']['typeReporting']=='excel') {

                function convertToExcel(){
                  include '../lib/Classes/PHPExcel.php';
                  /*start - BLOCK PROPERTIES FILE EXCEL*/
                  $file = new PHPExcel ();
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
                  /* start - BLOCK MEMBUAT LINK DOWNLOAD*/
                    /*
                    header ( 'Content-Type: application/vnd.ms-excel' );
                    //namanya adalah keluarga.xls
                    header ( 'Content-Disposition: attachment;filename="nilai.xls"' );
                    //header ( 'Cache-Control: max-age=0' );

                    header ( 'Content-Transfer-Encoding: binary' );
                    header('Cache-Control: no-cache');
                    header('Pragma: no-cache');
                    header('Connection: close');
                    */
                    //header('Content-Type: application/x-download');

                    $writer = PHPExcel_IOFactory::createWriter ( $file, 'Excel5' );
                    //echo $writer;
                    //exit;
                  //  var_dump($objWriter);
                  header ( 'Content-Type: application/vnd.ms-excel' );
                  header('Content-Disposition: attachment; filename="nilai.xls"');
                  header('Cache-Control: private, max-age=0, must-revalidate');
                  $writer->save( 'php://output' );
                  /* start - BLOCK MEMBUAT LINK DOWNLOAD*/
                  //return false;
                }
                convertToExcel();
              }else {
                $rows = $valueParam ['rows'];
                $result = $reporting->selectTrx($minDate,$maxDate,$offset,$rows);
                print_r($result);
              }
            }
          }elseif ($valueParam['convertReporting']['convertReportingStat']==false) {
            $rows = $valueParam ['rows'];
            $result = $reporting->selectTrx($minDate,$maxDate,$offset,$rows);
            print_r($result);
          }
        }elseif ($valueParam['typeOfReportingId']==2) {
          $maxDate = $valueParam['maxDate'];
          $minDate = $valueParam['minDate'];
          $offset = $valueParam['offset'];
          $rows = $valueParam['rows'];
          if ($valueParam['convertReporting']['convertReportingStat']==true) {
            $result = $reporting->selectClick($minDate,$maxDate,$offset,$rows);
            $decode = json_decode($result,true);
            if ($decode['response']['success']==true) {
              if ($valueParam['convertReporting']['typeReporting']=='pdf') {
                #setting judul laporan dan header tabel
                $judul = "LAPORAN DATA DATA TRANSAKSI IKLANIN AJA .COM";
                $header = array(
                		array("label"=>"NO", "length"=>30, "align"=>"C"),
                		array("label"=>"ADS ID", "length"=>50, "align"=>"C"),
                		array("label"=>"DATE", "length"=>50, "align"=>"C"),
                    array("label"=>"TOTAL CLICK", "length"=>50, "align"=>"C")
                	);

                #sertakan library FPDF dan bentuk objek
                require_once ("../fpdf/fpdf.php");
                $pdf = new FPDF();
                $pdf->AddPage();

                #tampilkan judul laporan
                $pdf->SetFont('Arial','B','16');
                $pdf->Cell(0,20, $judul, '0', 1, 'C');

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
                $dataCell = $decode['response']['data'];
                //print_r($dataCell);
                	foreach ($dataCell as $keyCell => $cell) {
                    //print_r($cell);
                    $pdf->Cell(30, 5, ($keyCell+1), 1, '0', 'L', $fill);
                    $pdf->Cell(50, 5, $cell['adsId'], 1, '0', 'L', $fill);
                    $pdf->Cell(50, 5, $cell['date'], 1, '0', 'L', $fill);
                		$pdf->Cell(50, 5, $cell['totalClick'], 1, '0', 'L', $fill);
                		$pdf->Ln();
                	}

                #output file PDF
                $pdf->Output('D','reporting.pdf');
              }else {
                $rows = $valueParam ['rows'];
                $result = $reporting->selectClick($minDate,$maxDate,$offset,$rows);
                print_r($result);
              }
            }
          }elseif ($valueParam['convertReporting']['convertReportingStat']==false) {
            $rows = $valueParam ['rows'];
            $result = $reporting->selectClick($minDate,$maxDate,$offset,$rows);
            print_r($result);
          }
        }
      }
    }
 ?>
