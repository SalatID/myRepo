<?php
  session_start();
  if (isset($_SESSION['userId'])) {
    header('location: index.php');
  }else {
    header('location: login.php');
  }
 ?>
