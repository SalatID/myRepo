<?php
    session_start();
    include_once '../../lib/config.php';
    $db = new configEcom();
    $email = $_POST['previousEmail'];
    $userId = $_POST['userId'];
    $tabel  ="profile";
    $fild   = "email";
    $where = "email = "."'".$email."'"." and userId=".$userId;
    $on="";
    $db->select($tabel,$fild,$on,$where);
    $hasil = $db->getResult();
    $decode = json_decode($hasil,true);
    $count = count($decode['post']);
    echo $count;

 ?>
