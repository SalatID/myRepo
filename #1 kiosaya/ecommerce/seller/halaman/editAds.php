<?php
	session_start();
	include('../../lib/config.php');
	$db=new configEcom();
	$userId = $_SESSION['userId'];
	$id=$_POST['rowid'];
	$pageName = $_POST['pageName'];
	$table = 'ads';
	$field = '*';
	$on = '';
	$where = 'id='.$id;
	$db->select($table,$field,$on,$where);
	$hasil = $db->getResult();
	$decode = json_decode($hasil,true);
	$row = $decode['post'];
?>
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="../css/style.css" />
	</head>
	<body>
		<form class="" action="halaman/updateAds.php" method="POST">
			<div id="edit-ads">
			<div class="clearfix">
			<input type="hidden" name="id" value="<?php echo $row[0]['id'];?>">
			<input type="hidden" name="pageName" value="<?php echo $pageName; ?>">
				<label class="edit-label col-sm-1">Title</label>
				<div class="col-sm-12">
					<input class="edit-input" name="title" id="focusedInput" type="text" value="<?php echo $row[0]['title'];?>">
				</div>
				<div class="clearfix"></div>

				<label class="edit-label col-sm-2">Category</label>
				<div class="col-sm-4">
					<select class="edit-select" name="category" id="category">
						<?php
							$table = "category";
							$field = "*";
							$order = "name";
							$where = "id=".$row[0]['categoryId'];
							$on = "";
							$db->select($table,$field,$on,$where,$order);
							$hasil = $db->getResult();
							$decode = json_decode($hasil,true);
							$rowCat = $decode['post'];
						?>

						<option value='<?php echo $row[0]['categoryId']?>'><?php echo $rowCat[0]['name']?></option>
						<?php
							$where = "id !=".$row[0]['categoryId'];
							$db->select($table,$field,$on,$where,$order);
							$hasil = $db->getResult();
							//echo $hasil;
							$decode = json_decode($hasil,true);
							$rowCat = $decode['post'];
							for ($r = 0; $r < count ($rowCat);$r++){
						?>
						<option value='<?php echo $rowCat[$r]['id']?>'><?php echo $rowCat[$r]['name']?></option>
						<?php
							}
						?>
					</select>
				</div>
				<div class="clearfix"></div>

				<label class="edit-label col-sm-2" >Sub Category</label>
				<div class="coba col-sm-4">
					<?php
						$table  ="subcategory";
						$field   = "*";
						$order  = "name";
						$where = "id=".$row[0]['subCategoryId'];
						$on="";
						$db->select($table,$field,$on,$where,$order);
						$hasil = $db->getResult();
						$decode = json_decode($hasil,true);
						$rowSub = $decode['post'];
					?>
					<select class="edit-select" name="subCategory" id="subCategory">
						<option value="<?php echo $row[0]['subCategoryId'];?>"><?php echo $rowSub[0]['name']?></option>
					<?php
						$where = "id !=".$row[0]['subCategoryId']." and categoryId=".$row[0]['categoryId'];
						$db->select($table,$field,$on,$where,$order);
						$hasil = $db->getResult();
						$decode = json_decode($hasil,true);
						$rowSub = $decode['post'];
					for ($r = 0; $r < count ($rowSub); $r++){
					?>
					<option value='<?php echo $rowSub[$r]['id']?>'><?php echo $rowSub[$r]['name']?></option>
					<?php
						}
					?>
					</select>
				</div>
				<div class="col-sm-1"></div>
				<div class="clearfix"></div>

				<?php
					$table = 'adsprice';
					$field = '*';
					$on = '';
					$where = 'adsId='.$id;
					$db->select($table,$field,$on,$where);
					$hasil = $db->getResult();
					//echo $hasil;
					$decode = json_decode($hasil,true);
					$rowPrice = $decode['post'];
				?>

				<label class="edit-label col-sm-2" >Price</label>
				<div class="col-sm-4">

					<input class="edit-input" id="focusedInput" name="priceId" type="hidden" value="<?php echo $rowPrice[0]['id'];?>">
					<input class="edit-input" id="focusedInput" name="price" type="text" value="<?php echo $rowPrice[0]['price'];?>" onkeypress="return hanyaAngka(event)">
				</div>
				<div class="clearfix"></div>

				<label class="edit-label col-sm-2" >Condition</label>
				<div class="col-sm-5">

						<label class="radiocond" for="rd1">
							<input type="radio" name="new" value=1
								<?php
									if ($row[0]['new']==1){
										echo 'checked';
									}
								?> id="rd1"><span> New</span>
						</label>

						<label class="radiocond" for="rd2">
							<input type="radio" name="new" value=0
								<?php
									if ($row[0]['new']==0){
										echo 'checked';
									}
								?> id="rd2"><span> Second</span>
						</label>

				</div>
				<div class="clearfix"></div>

				<label class="edit-label col-sm-1">Description</label>

				<div class="col-sm-12">
					<textarea name="description"><?php echo $row[0]['description'];?></textarea>
				</div>
				<div class="clearfix"></div>
				<input class="btn btn-danger" type="button" name="cancel" value="Cancel" data-dismiss="modal">
				<input class="btn btn-info" type="submit" name="edit" value="Edit">

			</div>
		</div>
	</form>
		<script type='text/javascript' src="../js/jquery.js"></script>
		<script type='text/javascript'>
			$(document).ready(function () {
					//$('select#subCategory').prop('disabled', true);

					$('select#category').click(function(){
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
					});
				});
			function hanyaAngka(evt) {
				var charCode = (evt.which) ? evt.which : event.keyCode
					if (charCode > 31 && (charCode < 48 || charCode > 57))

					return false;
				return true;
			}
		</script>

	</body>
</html>
