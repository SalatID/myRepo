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
     *
     */
    class reporting
    {
      private $db;
      function selectTrx($minDate, $maxDate,$limit){
        $this->db = new config();
        $table  ="payment";
        $field   = "*";
        $where  = "(paymentDate) between '$minDate' and '$maxDate' ";
        $this->db->select($table,$field,$on=null,$where,$group=null,$order=null,$limit);
        $result = $this->db->getResult();
        //echo $where;
        return $result;
      }
      function selectClick($minDate, $maxDate,$limit){
        $this->db = new config();
        $table  ="countclick";
        $field   = "*, substring(date,-19,10) as date";
        $order  = "substring(date,-19,10) asc";
        $where  = "(date) between '$minDate' and '$maxDate' ";
        $group = "adsId, substring(date,-19,10)";
        $this->db->select($table,$field,$on=null,$where,$group,$order,$limit);
        $result = $this->db->getResult();
        $decode=json_decode($result,true);
        $rowCountClick = $decode['post'];
        $arrayResult = array();
        $i=0;
        foreach ($rowCountClick as $keyCountClick => $valueCountClick) {
          $where  = 'adsId = '.$valueCountClick['adsId'].' and substring(date,-19,10) ='.'"'.$valueCountClick['date'].'"';
          $group = "";
          $on="";
          $this->db->select($table,$field,$on,$where,$group,$order);
          $result = $this->db->getResult();
          $decode=json_decode($result,true);
          $rowCountClick = $decode['post'];
          $arrayResult ['post'][$i]['adsId'] = $valueCountClick['adsId'];
          $arrayResult ['post'][$i]['date'] = $valueCountClick['date'];
          $arrayResult ['post'][$i]['totalClick'] = count($rowCountClick);
          $i++;
        }
        $result = json_encode($arrayResult);
        return $result;
      }
    }


 ?>
