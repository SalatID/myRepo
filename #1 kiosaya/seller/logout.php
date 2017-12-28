<?php
session_start();
include("../lib/config.php");
$db = new config();
$result = $db->logout();
if($result){
header('location:../login.php');
exit;	
}
 ?>
