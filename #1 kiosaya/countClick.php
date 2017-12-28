<?php
function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

function getMacAddress(){
  $server = $_SERVER['SERVER_ADDR'];
  $userIp = getUserIP();
  if($userIp == $server)
  {
      ob_start();
      system('ipconfig /all');
      $command  = ob_get_contents();
      ob_clean();
      $search = strpos($command, "Physical");
      $result = substr($command,($search+36),17);
      return $result;
  } else {
      $command = "arp -a $userIp";
      ob_start();
      system($command);
      $result = ob_get_contents();
      ob_clean();
      $search = strstr($result, $userIp);
      $explode = explode($userIp, str_replace(" ", "", $search));
      $result = substr($explode[1], 0, 17);
      return $result;
  }
}
$mac = getMacAddress();

//echo $userIp;
if (isset($mac)) {
  include 'lib/config.php';
  $db = new config();
  $adsId = $_POST['adsId'];
  $contractId = $_POST['contractId'];
  $date = date('Y-m-d H:i:s');
  $today = date('Y-m-d');
  //echo $today;
  $table = 'countclick';
  $field = 'max(id) as maxId, date, macAddress';
  $on = '';
  $where = '';
  $db->select($table,$field,$on,$where);
  $hasil = $db->getResult();
  $decode = json_decode($hasil,true);
  //print_r($decode);
  $rowCountClick = $decode['post'];
  $countClickId = isset($rowCountClick[0])?$rowCountClick[0]['maxId']:0;
  $countClickId++;

  $field = 'date, macAddress';
  $on = '';
  $where = 'adsId='.$adsId.' and substring(date,-19,10) = "'.$today.'"'.' and macAddress ='.'"'.$mac.'"';
  $db->select($table,$field,$on,$where);
  $hasil = $db->getResult();
  $decode = json_decode($hasil,true);
  //print_r($decode);
  $rowCountClick = $decode['post'];
  //print_r($rowCountClick);

  echo count($rowCountClick);
  if (count($rowCountClick)==0) {
          $data = array('id' => $countClickId,
        					'adsId' => $adsId,
                  'contractId'=>$contractId,
                  'macAddress' => $mac,
                  'date'=> $date
        				  );

          echo $db->insert($table,$data);
  }
}
 ?>
