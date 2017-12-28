<?php
    session_start();
    include_once '../../lib/config.php';
    $db = new configEcom();
    $password = $_POST['previousPassword'];
    $userId = $_POST['id'];
    $password = md5($password);
    $tabel  ="user";
    $fild   = "password";
    $where = "password = "."'".$password."'"." and id=".$userId;
    $on="";
    $db->select($tabel,$fild,$on,$where);
    $hasil = $db->getResult();
    $decode = json_decode($hasil,true);
    $count = count($decode['post']);
    echo $count;

 ?>
