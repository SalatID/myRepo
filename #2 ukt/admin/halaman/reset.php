<?php
  session_start();
  unset($_SESSION['kelompok']);
  unset($_SESSION['peserta']);
  header('location: dashboard.php?modul=tambahKelompok');
 ?>
