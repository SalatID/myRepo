<html>
	<head>
	</head>
	<body>

		<div id="product-view col-xs-12">

			<?php
				session_start();
				include('../../lib/config.php');
				$db=new config();
				$userId = $_SESSION['userId'];
				$adsId=$_POST['adsId'];
				$table = 'ads';
				$field = '*';
				$on = '';
				$where = 'id='.$adsId;
				$db->select($table,$field,$on,$where);
				$result = $db->getResult();
				//echo $result;
				$decode = json_decode($result,true);
				$rowAds = $decode['post'];
				//print_r($rowAds);die;
			?>

			<h2><?php echo $rowAds[0]['title'];?></h2>
			<div class="img-grid">
				<?php
					$table = 'images';
					$field = '*';
					$on = '';
					$where = 'adsId='.$rowAds[0]['id'];
					$db->select($table,$field,$on,$where);
					$result = $db->getResult();
					$decode = json_decode($result,true);
					$rowImages = $decode['post'];
					if(isset($rowImages[0]) ){?>
						<img class="img-responsive" src="../images/<?php echo $rowImages[0]['location'] ?>">
						</div><br><br>
				<?php
				}
				?>
				<?php
					$categoryId = $rowAds[0]['categoryId'];
					$table = "category";
					$field = "*";
					$order = "name";
					$where = "id=".$categoryId;
					$on = "";
					$db->select($table,$field,$on,$where,$order);
					$result = $db->getResult();
					$decode = json_decode($result,true);
					$rowCat = $decode['post'];

					$table = 'subcategory';
					$field = '*';
					$on = '';
					$where = 'id='.$rowAds[0]['subCategoryId'];
					$db->select($table,$field,$on,$where);
					$result = $db->getResult();
					$decode = json_decode($result,true);
					$rowSub = $decode['post'];
					$rowAds[0]['redirectLink'] = !is_numeric($rowAds[0]['redirectLink']) ? $rowAds[0]['redirectLink'] : 'index.php?fstore=detail_ads&rowid='.$rowAds[0]['redirectLink'];
				?>

			<label type="text" class="cat detail-control col-xs-12" readonly> <?php echo $rowCat[0]['name']?> > <?php echo $rowSub[0]['name']?></label>
			<div class="clearfix"></div>
			<label class="label-control">Redirect Link</label>
			<label class="rdl label-control"><?php echo $rowAds[0]['redirectLink'];?></label>
			<div class="clearfix"></div>

			<label class="label-control">Description</label>
			<p class="desc" readonly> <?php echo nl2br(str_replace('','',htmlspecialchars($rowAds[0]['description'])));?></p>
			<div class="clearfix"></div>

		</div>
	</body>
</html>
