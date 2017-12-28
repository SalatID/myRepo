<?php
session_start();
include("../lib/config.php");
$db = new config();
$db->logout();
header('location:../seller/login');

 ?>
