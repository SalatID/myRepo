taruh di login php
------------------------
<?php
  session_start();
  if(isset($_SESSION['username'])){
    header('location:index');
  }
 ?>
 
 taruh di index.php
 ------------------------
 <?php
		session_start();
		if(!isset($_SESSION['username'])){
			header('location:login');
		}
 ?>