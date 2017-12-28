<?php
    session_start();
    include_once '../../lib/config.php';
    $db = new config();
    $email = $_POST['previousEmail'];
    $userId = $_POST['userId'];
    $table  ="profile";
    $field   = "email";
    $where = "email = "."'".$email."'"." and userId=".$userId;
    $on="";
    $db->select($table,$field,$on,$where);
    $result = $db->getResult();
    $decode = json_decode($result,true);
    $count = count($decode['post']);
    echo $count;

 ?>
