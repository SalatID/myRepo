<?php
    session_start();
    include '../../lib/config.php';
    $db = new config();
    if (isset($_SESSION['userId'])) { ?>
      <!DOCTYPE html>
      <html lang="en">
      <head>
        <title>Admin - Sistem Penilaian UKT Online</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.min.css">
        <script type="text/javascript"src="../assets/js/jquery.js"></script>
        <script type="text/javascript" src="../assets/bootstrap/js/bootstrap.js"></script>
        <script src="../assets/bootstrap/js/bootstrap-datepicker.js"></script>
        <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap-datepicker3.css">
        <style>
          /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
          .row.content {height: 1500px}
          /* Set black background color, white text and some padding */
          footer {
            background-color: #555;
            color: white;
            padding: 15px;
          }

          /* On small screens, set height to 'auto' for sidenav and grid */
          @media screen and (max-width: 767px) {
            .sidenav {
              height: auto;
              padding: 15px;
            }
            .row.content {height: auto;}
          }
        </style>
      </head>
      <body>

      <div class="container-fluid">
        <div class="row content">
          <div class="col-sm-3 sidenav">
            <h4>Halaman Admin</h4>
            <ul class="nav nav-pills nav-stacked">
              <li class="active"><a href="dashboard.php?modul=home">Home</a></li>
              <li><a href="dashboard.php?modul=peserta">Peserta</a></li>
              <li><a href="dashboard.php?modul=nilai">Nilai</a></li>
              <li><a href="dashboard.php?modul=kelompok">Kelompok</a></li>
              <li><a href="halaman/logout.php">Logout</a></li>
            </ul><br>
          </div>

          <div class="col-sm-9">
            <?php
            if (isset($_GET['error'])) : ?>
          </br><div class="alert alert-warning alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <strong>Oops!!!</strong> <?=base64_decode($_GET['error']);?>
                </div>
            <?php endif;?>
            <div class="table-responsive">
              <div class="content">
                <div class="">
          				<a href="#" data-toggle="modal" data-target="#tambahPeserta" class="btn btn-warning" style="margin : 10px">
          					<i class="fa fa-plus-circle"></i> Tambah Peserta
          				</a>
          			</div>
                <?php
                   if(isset($_GET['modul'])){
                     $modul = $_GET['modul'];

                     switch ($modul) {
                       case 'home':
                         include "../halaman/home.php";
                         break;
                       case 'peserta':
                         include "../halaman/peserta.php";
                         break;
                       case 'kelompok':
                         include "../halaman/kelompok.php";
                         break;
                       case 'tambahKelompok':
                         include "../halaman/tambahKelompok.php";
                         break;
                       case 'tambahAnggotaKel':
                         include "../halaman/tambahAnggotaKel.php";
                         break;
                       case 'nilai':
                         include "../halaman/nilai.php";
                         break;
                       case 'editKelompok':
                         include "../halaman/editKelompok.php";
                         break;
                       case 'editAnggotaKel':
                         include "../halaman/editAnggotaKel.php";
                         break;
                       default:
                         echo "<center><h3>Maaf. Halaman tidak di temukan !</h3></center>";
                         break;
                     }
                   }else{
                     include "halaman/home.php";
                   }

               ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <footer class="container-fluid">
        <p>Footer Text</p>
      </footer>

      <!--Modal View Ads start here-->
      <div id="tambahPeserta" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- konten modal-->
        <div class="modal-content">
        <!-- heading modal -->
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Tambah Peserta</h4>
          </div>
          <!-- body modal -->
          <div class="modal-body">
            <?php include '../halaman/tambahPeserta.php' ?>
          </div>
        </div>
      </div>
      </div>
      </body>

      </html>
      <script type="text/javascript">
      $(document).ready(function(){
        $('.tambahPeserta').click(function(){
          //alert('hai');
        });
      });

      </script>
<?php
    }else {
      header('location: ../index.php');
    }
 ?>
