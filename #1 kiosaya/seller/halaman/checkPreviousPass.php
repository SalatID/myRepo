<?php
    session_start();
    include_once '../../lib/config.php';
    $db = new config();
    $password = $_POST['previousPassword'];
    $userId = $_POST['id'];
    $password = md5($password);
    $table  ="user";
    $field   = "password";
    $where = "password = "."'".$password."'"." and id=".$userId;
    $on="";
    $db->select($table,$field,$on,$where);
    $result = $db->getResult();
    $decode = json_decode($result,true);
    $count = count($decode['post']);
    echo $count;

 ?>
