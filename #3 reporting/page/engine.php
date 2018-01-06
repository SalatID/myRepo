<?php
    /**
     * Get Data City : mengambil data kota berdasarkan provinsi yang dipilih
     */
    include '../lib/configReport.php';
    include '../lib/config.php';
    class getDataCity {
      private $dbR;
      function select($provincesId)
      {
          $this->dbR = new configReport();
          $table  ="city";
          $field   = "*";
          $order  = "name";
          $where  = "provincesId='$provincesId'";
          $group = "";
          $on="";
          $this->dbR->select($table,$field,$on,$where,$group,$order);
          $result = $this->dbR->getResult();
          $decode = json_decode($result,true);
          $rowCity = $decode['response'];
          //$result = count($rowCity);
          if (count($rowCity)!=0) {
            $success = 'true';
            $dataArray = array('response'=>
                            array('success'=>$success,
                                  'data'=>$rowCity
                          ));
          }else {
            $success = 'false';
            $dataArray = array ('response'=>
                            array('success'=>$success));
          }
          $result = json_encode($dataArray);
          return $result;
      }
    }
    /**
     * reporting : to get data reporting
     */
    class reporting
    {
      private $db;
      function selectTrx($minDate,$maxDate,$offset,$rows,$order=null){
        $this->db = new config();
        $table  ="payment";
        $field   = "*";
        $where  = "(paymentDate) between '$minDate' and '$maxDate' ";
        $this->db->select($table,$field,$on=null,$where,$group=null,$order);
        $result = $this->db->getResult();
        $decode = json_decode($result,true);
        $totalRow = $decode['response'];
        $limit = $rows != -1 ? $offset.', '.$rows : $offset;
        //echo $limit;die;
        $this->db->select($table,$field,$on=null,$where,$group=null,$order,$limit);
        $result = $this->db->getResult();
        $decode = json_decode($result,true);
        $rowTrx = $decode['response'];
        //$result = count($rowTrx);
        try {
          if ($minDate != null && $maxDate != null) {
            if ($minDate <= $maxDate) {
              if (count($rowTrx)!=0) {
                $order = explode(' ',$order);
                $error =0;
                $generateDate = date('Y-m-d H:i:s ').'GMT'.date('P');
                $title = 'LAPORAN DATA TRANSAKSI IKLANINAJA.COM';
                $arrayHeader = array ();
                $arrayHeader = array (array("col"=>"NO","fieldName"=>"id"),
                                      array("col"=>"CONTRACT ID","fieldName"=>"contractId"),
                                      array("col"=>"PAYMENT DATE","fieldName"=>"paymentDate"),
                                      array("col"=>"TOTAL PAYMENT","fieldName"=>"totalPayment"));
                $dataArray = array('response'=>
                                  array('error'=>$error,
                                        'totalRow'=>count($totalRow),
                                        'limit'=>array('rows'=>$rows,
                                                       'offset'=>$offset),
                                        'docAttribute'=>array('startDate'=>$minDate,
                                                              'endDate'=>$maxDate,
                                                              'title'=>$title,
                                                              'generateDate'=>$generateDate,
                                                              'typeOfReporting'=> 'Transaction'),
                                        'order'=>array('fieldName'=>$order[0],
                                                       'type'=>$order[1]),
                                        'tableHeader'=>$arrayHeader,
                                        'data'=>$rowTrx)
                                    );
              }else {
                throw new Exception("Oops! Data Not Found", 1);
              }
            }else{
              throw new Exception("Oops! Your Start Date is Greater than End Date",2);
            }
          }else {
            throw new Exception("Oops! Your Start Date and End Date is Empty", 3);
          }

        } catch (Exception $e) {
          $errorCode =$e->getCode();
          $message=$e->getMessage();
          switch ($errorCode) {
            case 1:
                $debuging = 'Please Cek Your Start Date and End Date';
              break;
            case 2:
                $debuging = 'Please Cek Your Start Date and End Date, Your Start Date is Greater than End Date';
              break;
            case 3:
                $debuging = 'Please Fill in The Date';
              break;
            default:
              $debuging = 'Please Contact Your Administrator admin[at]kiosaya.com';
              break;
          }

          $dataArray = $result;
          $dataArray=array('response'=>
                        array('error'=>$errorCode,
                              'detail'=>array('message'=>$message,
                                               'debuging'=>$debuging)));
        }
        $result = json_encode($dataArray);
        return $result;
        }
      function selectClick($minDate, $maxDate,$offset,$rows=null,$order=null){
        $this->db = new config();
        $table  ="countclick";
        $field   = "*, substring(date,-19,10) as date";
        $where  = "(substring(date,-19,10)) between '$minDate' and '$maxDate' ";
        $group = "adsId, substring(date,-19,10)";
        $this->db->select($table,$field,$on=null,$where,$group,$order);
        $result = $this->db->getResult();
        $decode=json_decode($result,true);
        $totalRow = $decode['response'];
        $limit = $rows != -1 ? $offset.', '.$rows : $offset;
        $this->db->select($table,$field,$on=null,$where,$group,$order,$limit);
        $result = $this->db->getResult();
        $decode=json_decode($result,true);
        $rowCountClick = $decode['response'];
        //$dataArray = array();
        $arrayData = array();
        //$count = count($rowCountClick);
        try {
          if (count($rowCountClick) !=0 ) {
            if ($minDate <= $maxDate) {
              if (count($totalRow)!=0) {
                $error = 0;
                $generateDate = date('Y-m-d H:i:s ').'GMT'.date('P');
                $i=0;
                foreach ($rowCountClick as $keyCountClick => $valueCountClick) {
                  $where  = 'adsId = '.$valueCountClick['adsId'].' and substring(date,-19,10) ='.'"'.$valueCountClick['date'].'"';
                  $group = "";
                  $on="";
                  $this->db->select($table,$field,$on,$where,$group,$order);
                  $result = $this->db->getResult();
                  $decode=json_decode($result,true);
                  $rowCountClick = $decode['response'];
                  $arrayData [$i]['adsId'] = $valueCountClick['adsId'];
                  $arrayData [$i]['date'] = $valueCountClick['date'];
                  $arrayData [$i]['totalClick'] = count($rowCountClick);
                  $i++;
                }
                $order = explode(' ',$order);
                //print_r($order);die;
                $title = 'LAPORAN TOTAL CLICK IKLANINAJA.COM';
                $arrayHeader = array (array("col"=>"NO","fieldName"=>"id"),
                                      array("col"=>"ADS ID","fieldName"=>"adsId"),
                                      array("col"=>"DATE","fieldName"=>"date"),
                                      array("col"=>"TOTAL CLICK","fieldName"=>"totalClick"));
                $dataArray = array('response'=>
                                      array('error'=>$error,
                                            'totalRow'=>count($totalRow),
                                            'limit'=>array('rows'=>$rows,
                                                           'offset'=>$offset),
                                            'docAttribute'=>array('startDate'=>$minDate,
                                                                  'endDate'=>$maxDate,
                                                                  'title'=>$title,
                                                                  'generateDate'=>$generateDate,
                                                                  'typeOfReporting'=> 'Total Click'),
                                            'order'=>array('fieldName'=>$order[0],
                                                           'type'=>$order[1]),
                                            'tableHeader'=>$arrayHeader,
                                            'data'=>$arrayData));

              }else {
                throw new Exception("Oops! Data Not Found", 1);
              }
            }else {
              throw new Exception("Oops! Your Start Date is Greater than End Date",2);
            }
          }else {
            throw new Exception("Oops! Your Start Date and End Date is Empty", 3);
          }
        } catch (Exception $e) {
          $errorCode =$e->getCode();
          $message=$e->getMessage();
          switch ($errorCode) {
            case 1:
                $debuging = 'Please Cek Your Start Date and End Date';
              break;
            case 2:
                $debuging = 'Please Cek Your Start Date and End Date, Your Start Date is Greater than End Date';
              break;
            case 3:
                $debuging = 'Please Fill in The Date';
              break;
            default:
              $debuging = 'Please Contact Your Administrator admin[at]kiosaya.com';
              break;
          }

          $dataArray = $result;
          $dataArray=array('response'=>
                        array('error'=>$errorCode,
                              'detail'=>array('message'=>$message,
                                               'debuging'=>$debuging)));
        }
        $result = json_encode($dataArray);
        return $result;
      }
    }
 ?>
