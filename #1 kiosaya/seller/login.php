<?php
  session_start();
  if (isset($_SESSION['userId'])) {
    header('location: index.php');
  }else {
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Halaman Login Seller</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
  	<script type="text/javascript" src="../js/jquery-2.1.4.min.js"></script>
  	<script type="text/javascript" src="../js/bootstrap.js"></script>
  </head>
    <body>

    <div class="container">
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
          <?php
          /* handle error */
          if (isset($_GET['error'])) : ?>
              <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <strong>Warning!</strong> <?=base64_decode($_GET['error']);?>
              </div>
          <?php endif;?>
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title">Sign In</div>
                    </div>

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                        <form class="" action="prosesLogin.php" method="post">
                          <div style="margin-bottom: 25px" class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                      <input id="login-username" type="text" class="form-control" name="username" value="" placeholder="Username" required>
                                  </div>

                          <div style="margin-bottom: 25px" class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                      <input id="login-password" type="password" class="form-control" name="password" placeholder="password" required>
                                  </div>

                              <div style="margin-top:10px" class="form-group">
                                  <!-- Button -->

                                  <div class="col-sm-12 controls">
                                    <input type="submit" name="kirim" value="MASUK" id="btn-login" class="btn btn-success">
                            </form>
                                      <a id="btn btn-primary" data-target="#myModal" data-toggle="modal" class="btn btn-primary">DAFTAR</a>

                                    </div>
                                </div>
                                <div id="myModal" class="modal fade" role="dialog">
                              		<div class="modal-dialog">
                              			<!-- konten modal-->
                              			<div class="modal-content">
                              				<!-- heading modal -->
                              				<div class="modal-header">
                              					<button type="button" class="close" data-dismiss="modal">&times;</button>
                              					<h4 class="modal-title">Registrasi Pengguna Baru</h4>
                              				</div>
                              				<!-- body modal -->
                              				<div class="modal-body">
                                        <?php include '../seller/halaman/register.php'; ?>
                              				</div>

                              			</div>
                              		</div>
                              	</div>

                    </div>
                    </div>
        </div>

  </body>

</html>
<?php
}
 ?>
