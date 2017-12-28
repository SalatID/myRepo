<?php
    session_start();
    include '../lib/config.php';
    $db = new config ();
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
   <title>Sistem Penilaian UKT Online</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="../css/bootstrap.css">
   <link rel="stylesheet" href="../css/own.css">
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
       <h4>Penilaian Ujian Kenaikan Tingkat Online</h4>
     </div>
     <div class="col-sm-9">
       <div class="table-responsive">
         <div class="content">
           <?php
   						if(isset($_GET['modul'])){
   							$modul = $_GET['modul'];

   							switch ($modul) {
   								case 'home':
   									include "../halaman/home.php";
   									break;
                  case 'penilaian':
     								include "../halaman/penilaian.php";
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

 </body>
 </html>
 <script type="text/javascript" src="../js/jquery.js"></script>
 <script type="text/javascript">

 </script>
