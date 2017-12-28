<?php
  include 'lib/config.php';
  $db = new config();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sistem Penilai UKT Online</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.css">
  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: 1500px}

    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }

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
        <form class="" action="halaman/proses.php" method="post">
          <table class="table">
            <tr>
              <td>
                <?php
                  $table = 'penilai';
                  $field = '*';
                  $on ="";
                  $where = '(tsId) in (5,6,7)';
                  $group ='';
                	$order ='namePenilai ASC';
                  $db->select($table,$field,$on,$where,$group,$order);
                  $hasil = $db->getResult();
                  $decode = json_decode($hasil,true);
                  $rowPenilai = $decode['post'];
                  //print_r($decode);
                 ?>
                <select class="form-control" name="penilai">
                  <option value="">Pilih Nama Penilai</option>
                  <?php
                    foreach ($rowPenilai as $key => $value) {?>
                      <option value="<?php echo $value['id']?>"><?php echo $value['namePenilai']; ?></option>
                  <?php  }
                   ?>
                </select>
              </td>
            </tr>
            <tr>
              <td>
                <input style="width : 100%" type="submit" class="btn btn-info"name="kirim" value="Masuk">
              </td>
            </tr>

          </table>
        </form>
      </div>
    </div>
  </div>
</div>

<footer class="container-fluid">
  <p>Footer Text</p>
</footer>

</body>
</html>
<?php
    session_start();
    session_destroy();
 ?>
