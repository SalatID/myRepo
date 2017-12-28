<?php
include('../../lib/config.php');
$db     = new config();
$tabel  ="provinces";
$fild   = "id,name";
$order  = "name";
$where = "";
$on="";
$db->select($tabel,$fild,$on,$where,$order);
$hasil = $db->getResult();
$decode = json_decode($hasil,true);
?>

<html>
	<head>
		<title>Registrasi</title>
		<link href="../css/style.css" rel="stylesheet" type="text/css"/>
	</head>

	<body>

		<div class="regis">
		<form action="halaman/prosesRegister.php" method="post">
				<input class="form-control" type="text" id="username" name="username" placeholder="Username" maxlength="15"><br><br>
				<input type="hidden" name="joined" id="joined" value="<?php echo date('Y-m-d');?>">
				<input class="form-control" id="name"type="text" name="name" placeholder="Nama Lengkap" maxlength="40"><br><br>
				<textarea class="form-control" id="address" name="address" placeholder="address" ></textarea><br><br>
				<select name='provinces' id="provinces" class="form-control">
				<option>--Pilih Provinsi--</option>
        <?php
        for ($r = 0; $r < count ($decode['post']);$r++){
          ?>
          <option value='<?php echo $decode['post'][$r]['id']?>'><?php echo $decode['post'][$r]['name']?></option>";
        <?php }
        ?>
				</select></br></br>

			<select name='city' id="city" class="form-control">
						<option>--Pilih Kota--</option>
			</select></br></br>

				<input class="form-control" type="tel" id="phone" name="phone" placeholder="Nomor Telepon" autocomplete="off" maxlength="13"><div class="alert alert-warning alert-dismissible" id="errmsg" style="margin:0; text-align: center;"></div><br><br>
				<input class="form-control" type="email" id="email" name="email" placeholder="Email" maxlength="40"><br><br>
				<input class="form-control" type="password" id="password" name="password" placeholder="Password" maxlength="40">
				<div id="pesan"></div><br><br>
				<input class="form-control" type="password" id="retype" name="retype" placeholder="ReType Password" maxlength="40"><br><br>

				<!-- footer modal -->
				<div class="modal-footer">
					<input type="submit"class="btn btn-primary" id="daftar" value="Daftar" align="right">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
		</form>
		</div>
	</body>

	<script type='text/javascript'>
	$(document).ready(function () {
		$("#errmsg").fadeOut("slow");
			$('select#city').prop('disabled', true);
			$('input#daftar').prop('disabled', true);
			$('input#daftar').keypress('disabled', true);
			$("#phone").keypress(function (e) {
     		//if the letter is not digit then display error and don't type anything
		     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		        //display error message
		        $("#errmsg").html("Digits Only").show("fast");
		               return false;
		    }else {
		    	$("#errmsg").fadeOut("slow");
		    }
			});
			$('#provinces').change(function(){
				var provincesId = $(this).val();
				$.ajax({
					type	: 'POST',
					url 	: 'halaman/getDataCity.php',
					data 	: 'provincesId='+provincesId,
					success	: function(data){
						$('select#city').html(data);
						$('select#city').prop('disabled', false);
					}
				})
			});
			$('#retype').keyup(function(){
				var password = $('#password').val();
				var retype = $('#retype').val();
				if (password==retype) {
					$('#pesan').html(" &#10004; Password Sama");
					$('input#daftar').prop('disabled', false);
					$('input#daftar').keypress('disabled', false);
				}else {
					$('#pesan').html(" &#10008; Password Tidak Sama");
					$('input#daftar').prop('disabled', true);
					$('input#daftar').keypress('disabled', false);
				}

			});
			$('#password').keyup(function(){
				$('#retype').val("");
				$('input#daftar').prop('disabled', true);
				$('input#daftar').keypress('disabled', true);

			});

		});
	</script>
</html>
