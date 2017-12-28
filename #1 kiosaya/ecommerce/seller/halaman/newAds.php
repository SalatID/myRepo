<?php
	$tabel  ="category";
	$fild   = "*";
	$order  = "name";
	$where = "";
	$group = "";
	$db->select($tabel,$fild,$where,$group,$order);
	$hasil = $db->getResult();
	$decode = json_decode($hasil,true);
?>
<html>
	<head>
		<link href="../css/style.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="../js/jquery.min.js"></script>
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/bootstrap.js"></script>
		<script src="../js/bootstrap-datepicker.js"></script>
		<script src="../js/jquery.validate.min.js"></script>


	</head>
	<body>
		<form method="POST" class="form" action="halaman/inputAds.php"  enctype="multipart/form-data">
			<div id="ads">
			<h1> Post an Ads </h1><br>
				<input class="text-control" type="text" name="title" placeholder="Title" autofocus required><br>
				<input class="input-control curency" data-a-sep="." data-a-dec="," data-a-sign="€ " type="text" name="price"  placeholder="Price"  maxlength="16" required>
				<br><br><br>
				<select class="input-control" id="category" name="category" required>
					<option value="">--Select Category--</option>
					<?php
						for ($r = 0; $r < count ($decode['post']);$r++){
					?>
					<option value='<?php echo $decode['post'][$r]['id']?>'><?php echo $decode['post'][$r]['name']?></option>";
					<?php }
					?>
				</select>
				<select class="input-control" id="subCategory" name="subcategory">
					<option>--Select Sub Category--</option>
					<div id='divkedua'></div>
				</select>
				<div class="clearfix"></div>

				<div class="kondisi">
					<label class="edit-control col-sm-1">Condition</label>
					<div class="form-radio col-sm-1">
						<label for="rd1">
							<input type="radio" name="new" class="radioBtn" value=1 id="rd1" required><span> New</span>
						</label>
					</div>
					<div class="form-radio col-sm-2">
						<label for="rd2">
							<input type="radio" name="new" class="radioBtn" value=0 id="rd2"><span> Second</span>
						</label>
					</div>
				</div>

				<textarea class="adsdesc text-control"  name="description" placeholder="Ads Description"required></textarea><br>
				<div class="clearfix"></div>


				<?php if (isset($_GET['error'])) : ?>
						<div class="alert alert-warning alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<strong>Warning!</strong> <?=base64_decode($_GET['error']);?>
						</div>
				<?php endif;?>
				<div class="form-group">
					<div class="input-group">
					<input type="text" class="form-control input-lg" name="location[]" id="img1" size="40" placeholder="Upload Image" readonly required >
							<label class="input-group-btn">
								<span class="btn btn-info btn-lg">
									Browse <input type="file" accept="image/jpeg, image/png" id="media" name="media" style="display: none;" required>
								</span>
							</label>
					</div>
				</div>


			<!--<div class="form-group">
					<div class="input-group">
					<input type="text" class="form-control input-lg" name="location[]" id="img2" size="40" placeholder="Upload Gambar" readonly>
							<label class="input-group-btn">
								<span class="btn btn-info btn-lg">
									Browse <input type="file" accept="image/*" id="media" name="media" style="display: none;">
								</span>
							</label>
					</div>
				</div>

				<div class="form-group">
					<div class="input-group">
					<input type="text" class="form-control input-lg" size="40" placeholder="Upload Gambar" readonly>
							<label class="input-group-btn">
								<span class="btn btn-info btn-lg">
									Browse <input type="file" accept="image/*" id="media" name="media" style="display: none;">
								</span>
							</label>
					</div>
				</div>

				<div class="form-group">
					<div class="input-group">
					<input type="text" class="form-control input-lg" size="40" placeholder="Upload Gambar" readonly>
							<label class="input-group-btn">
								<span class="btn btn-info btn-lg">
									Browse <input type="file" accept="image/*" id="media" name="media" style="display: none;">
								</span>
							</label>
					</div>
				</div>

				<div class="form-group">
					<div class="input-group">
					<input type="text" class="form-control input-lg" size="40" placeholder="Upload Gambar" readonly >
							<label class="input-group-btn">
								<span class="btn btn-info btn-lg">
									Browse <input type="file" accept="image/*" id="media" name="media" style="display: none;" >
								</span>
							</label>
					</div>
				</div>
-->
					<div class="clearfix"></div>
				<input class="btn btn-danger" type="reset" name="reset" value="Reset" style="float: right; width: 80px; margin-left: 15px;">
				<input class="btn" type="submit" name="upload" id="Post" value="Post" style="float: right; width: 80px; background-color:#407496; color: #ffffff">


			</div>
		</form>
		<script type="text/javascript" src="../js/jquery.maskMoney.min.js"></script>
	<script>
			$(document).ready(function($){
			$('.curency').maskMoney({prefix:'Rp ',thousands:'.',decimal:',',precision:0});
				$('.form').submit(function(){
					var num = $('.curency').maskMoney('destroy').val()
				        .replace(/Rp\s|[.,]/g, '');
					$('.curency').val(num);
					$('input#media').each(function () {
						$(this).rules('add', {
						        required: true,
						        accept: "image/jpeg, image/pjpeg"
						    })
					})
				});
		});
		$(document).ready(function () {
				$('select#subCategory').prop('disabled', true);
				$('#Post').prop('disabled',true);
				$("#media").change(function() {
				      var val = $(this).val();
				      switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
				          case 'gif': case 'jpg': case 'png':case '':
				              $('#Post').prop('disabled',false);
				              break;
				          default:
				              $(this).val('');
				              $('#Post').prop('disabled',true);
				              swal ( "Sorry" ,  "only allowed formats JPG and PNG" ,  "error" )
				              break;
				      }
				  });


				$('#category').change(function(){
					var categoryId = $(this).val();
					$.ajax({
						type	: 'POST',
						url 	: 'halaman/getDataSubCategory.php',
						data 	: 'categoryId='+categoryId,
						success	: function(data){
							$('select#subCategory').html(data);
							$('select#subCategory').prop('disabled', false);
						}
					})
					if (categoryId == 7) {
						$('.kondisi').hide();
						$(".radioBtn").prop('required',false);
						$(".radioBtn").prop('checked',false);
					}else{
						$('.kondisi').show();
					}
				});
		function buatListGambar() {
			var input = document.getElementById("BSbtninfo");
			var hapus = "<input type=\"submit\" class=\"hps_btn\" value=\"\">"
			var ul = document.getElementById("listGambar");

			while (ul.hasChildNodes()) {
				ul.removeChild(ul.firstChild);
			}
			for (var i = 0; i < input.files.length; i++) {
				var li = document.createElement("li");
				li.innerHTML = input.files[i].name+hapus;
				ul.appendChild(li);
			}
		}


		$(function() {
	  $(document).on('change', ':file', function() {
		var input = $(this),
			numFiles = input.get(0).files ? input.get(0).files.length : 1,
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [numFiles, label]);
	  });

	  $(document).ready( function() {
		  $(':file').on('fileselect', function(event, numFiles, label) {

			  var input = $(this).parents('.input-group').find(':text'),
				  log = numFiles > 1 ? numFiles + ' files selected' : label;

			  if( input.length ) {
				  input.val(log);
			  } else {
				  if( log ) alert(log);
			  }

		  });
	  });

	});
});

	</script>
	</body>

</html>
