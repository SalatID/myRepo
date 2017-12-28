<?php
	session_start();
	include('../../lib/config.php');
	$db=new config();
	$userId = $_SESSION['userId'];
	$id=$_POST['rowid'];
	$table = 'ads';
	$field = '*';
	$on = '';
	$where = 'id='.$id;
	$db->select($table,$field,$on,$where);
	$result = $db->getResult();
	$decode = json_decode($result,true);
	$pageName = $_POST['pageName'];
	$rowAds = $decode['post'];
?>
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="../css/style.css" />
	</head>
	<body>
		<form class="" action="halaman/updateAds.php" method="POST">
			<input type="hidden" name="pageName" value="<?php echo $pageName ?>">
			<div id="edit-ads">
			<div class="clearfix">
			<input type="hidden" name="adsId" value="<?php echo $rowAds[0]['id'];?>">
				<label class="edit-label col-sm-1">Title</label>
				<div class="col-sm-12">
					<input class="edit-input" name="title" id="focusedInput" type="text" value="<?php echo $rowAds[0]['title'];?>">
				</div>
				<div class="clearfix"></div>

				<label class="edit-label col-sm-2">Category</label>
				<div class="col-sm-4">
					<select class="edit-select" name="category" id="category">
						<?php
							$table = "category";
							$field = "*";
							$order = "name";
							$where = "id=".$rowAds[0]['categoryId'];
							$on = "";
							$db->select($table,$field,$on,$where,$order);
							$result = $db->getResult();
							$decode = json_decode($result,true);
							$rowCat = $decode['post'];
						?>

						<option value='<?php echo $rowAds[0]['categoryId']?>'><?php echo $rowCat[0]['name']?></option>
						<?php
							$where = "id !=".$rowAds[0]['categoryId'];
							$db->select($table,$field,$on,$where,$order);
							$result = $db->getResult();
							//echo $result;
							$decode = json_decode($result,true);
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
						$where = "id=".$rowAds[0]['subCategoryId'];
						$on="";
						$db->select($table,$field,$on,$where,$order);
						$result = $db->getResult();
						$decode = json_decode($result,true);
						$rowSub = $decode['post'];
					?>
					<select class="edit-select" name="subCategory" id="subCategory">
						<option value="<?php echo $rowAds[0]['subCategoryId'];?>"><?php echo $rowSub[0]['name']?></option>
					<?php
						$where = "id !=".$rowAds[0]['subCategoryId']." and categoryId=".$rowAds[0]['categoryId'];
						$db->select($table,$field,$on,$where,$order);
						$result = $db->getResult();
						$decode = json_decode($result,true);
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
				<div class="col-sm-12">
					<label class="edit-label col-sm-1">Redirect Link</label>
					<?php
							if (is_numeric($rowAds[0]['redirectLink'])) {
								$rowAds[0]['redirectLink'] = 'index.php?fstore=detail_ads&rowAdsid='.$rowAds[0]['redirectLink']; ?>
								<input readonly class="edit-input" name="redirectLink" id="focusedInput" type="text" value="<?php echo $rowAds[0]['redirectLink'];?>">
						<?php	}else { ?>
							<input  class="edit-input" name="redirectLink" id="focusedInput" type="text" value="<?php echo $rowAds[0]['redirectLink'];?>">
				<?php		}
					 ?>

				</div>
				<div class="clearfix"></div>
				<label class="edit-label col-sm-1">Description</label>

				<div class="col-sm-12">
					<textarea name="description"><?php echo $rowAds[0]['description'];?></textarea>
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
