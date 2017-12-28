<?php
    include '../../lib/config.php';
    $logCode = 'lgnUsr-1';
    $userId = '1';
    class log extends config{
      public function tampilLog(){
        return parent::select($table,$field,$on,$where);
      }
      public function insertLog(){
        return parent::insert($table,$data);
      }
      public function log ($logCode,$userId){
        echo "log code=".$logCode." userId=".$userId;
        return;
      }
    }
    $log = new log();
    $log->log($logCode,$userId);
 ?>
