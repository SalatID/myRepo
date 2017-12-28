	<div class="table-responsive" style="widht : 100%;">
      <form class="" action="halaman/updateProfile.php" method="post">
        <table class="table" style="widht : 100%;">
                <tr>
                    <td>Nama Lengkap</td>
                    <td>:</td>
                    <td><input type="hidden" name="id" value="<?php echo $row[0]['id']; ?>">
												<input class="form-control" type="text" name="name" value="<?php echo $row[0]['name']; ?>">
										</td>
                </tr>
                <tr>
          <td>Alamat</td>
                    <td>:</td>
                    <td><input class="form-control" type="text" name="address" value="<?php echo $row[0]['address']; ?>"></td>
                </tr>
								<tr>
                    <td>Propinsi</td>
                    <td>:</td>
										<?php
										$tabel  ="provinces";
										$fild   = "id,name";
										$order  = "name";
										$where = "id=".$row[0]['provinceId'];
										$on="";
										$db->select($tabel,$fild,$on,$where,$order);
										$hasil = $db->getResult();
										$decode = json_decode($hasil,true);
										$rows = $decode['post'];?>
                    <td><select name='provinces' id="provinces" class="form-control">
										<option value="<?php echo $rows[0]['id']?>"><?php echo $rows[0]['name'];?></option>
						        <?php
										$where = "id !=".$row[0]['provinceId'];
										$db->select($tabel,$fild,$on,$where,$order);
										$hasil = $db->getResult();
										$decode = json_decode($hasil,true);
										$rows = $decode['post'];
						        for ($r = 0; $r < count ($rows);$r++){
						          ?>
						          <option value='<?php echo $rows[$r]['id']?>'><?php echo $rows[$r]['name']?></option>
						        <?php }
						        ?>
										</select></td>
                </tr>
                <tr>
                    <td>Kota</td>
                    <td>:</td>
										<?php
										$tabel  ="city";
										$fild   = "id,name";
										$order  = "name";
										$where = "id=".$row[0]['cityId'];
										$on="";
										$db->select($tabel,$fild,$on,$where,$order);
										$hasil = $db->getResult();
										//echo $hasil;
										$decode = json_decode($hasil,true);
										$rowCity = $decode['post'];
										?>

                    <td><select name='city' id="city" class="form-control">
												<option value="<?php echo $row[0]['cityId']?>"><?php echo $rowCity[0]['name']?></option>
										<?php
											$where = "id !=".$row[0]['cityId']." and province_id=".$row[0]['provinceId'];
											$db->select($tabel,$fild,$on,$where,$order);
											$hasil = $db->getResult();
											$decode = json_decode($hasil,true);
											$rows = $decode['post'];
								       for ($r = 0; $r < count ($rows);$r++){
								         ?>
								         <option value='<?php echo $rows[$r]['id']?>'><?php echo $rows[$r]['name']?></option>
								       <?php }
								       ?>
												</select>
										</td>
                </tr>
                <tr>
                    <td>No. Telepon</td>
                    <td>:</td>
                    <td><input class="form-control" type="text" name="phone" value="<?php echo $row[0]['phone']; ?>"></td>
                </tr>
                <tr>
                  <td colspan="3">
                    <input style="float : right; margin-left: 10px;" type="submit" class="btn btn-info" name="" value="Simpan">&ensp;
                    <input style="float : right;" type="reset" class="btn btn-default" data-dismiss="modal" value="Close">
                  </td>
                </tr>
            </table>
      </form>
			<script type='text/javascript'>
			$(document).ready(function () {
					//$('select#city').prop('disabled', true);
					$('input#daftar').prop('disabled', true);
					$('input#daftar').keypress('disabled', true);
					$('#provinces').click(function(){
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
					$('#retype').blur(function(){
						var password = $('#password').val();
						var retype = $('#retype').val();
						if (password==retype) {
							$('#pesan').html(" &#10004; Password Sama");
							$('input#daftar').prop('disabled', false);
							$('input#daftar').keypress('disabled', false);
						}else {
							$('#pesan').html(" &#10004; Password Tidak Sama");
							$('input#daftar').prop('disabled', true);
							$('input#daftar').keypress('disabled', false);
						}

					})
				});
			</script>
        </div>
