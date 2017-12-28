<?php
	session_start();
	include_once '../../lib/config.php';
	$db = new config();
	$id=$_GET['rowid'];
	$table = 'ads';
	$field = '*';
	$on = '';
	$where = 'id='.$id;
	$db->select($table,$field,$on,$where);
	$hasil = $db->getResult();
	//echo $hasil;
	$decode = json_decode($hasil,true);
	$row = $decode['post'];
?>
<html>
	<head>
	<link rel="stylesheet" type="text/css" href="../../css/style.css" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="../../css/bootstrap.css">
	</head>
	<body>


	<div id="productView">

			<div class="col-md-7 leftView">	<div class="leftHeader">
					<h2><?php echo $row[0]['title'];?></h2>
					<p>Lokasi | Added at 06:55 pm, Ad ID: 987654321</p>
				</div>
				<div class="imgGrid" style="width : 300px; max-height : 300px">
					<?php
						$table = 'images';
						$field = '*';
						$on = '';
						$where = 'adsId='.$row[0]['id'];
						$db->select($table,$field,$on,$where);
						$hasil = $db->getResult();
						$decode = json_decode($hasil,true);
						$rowImages = $decode['post'];
            $im = imagecreatefrompng("'../../images/'.$rowImages[0]['location']");
            $size = min(imagesx($im), imagesy($im));
            $im2 = imagecrop($im, ['x' => 0, 'y' => 0, 'width' => $size, 'height' => $size]);
            if ($im2 !== FALSE) {
                imagepng($im2, 'example-cropped.png');
            }
						if(isset($rowImages[0]) ){?>
							<img style="max-width : 300px; max-height:300px; margin: 0 auto;" src="../../images/<?php echo $rowImages[0]['location'] ?>" class="img-responsive" alt="">
				</div><br><br>
					<?php
						}
					?>
					<?php
						$categoryId = $row[0]['categoryId'];
						$table = "category";
						$field = "*";
						$order = "name";
						$where = "id=".$categoryId;
						$on = "";
						$db->select($table,$field,$on,$where,$order);
						$hasil = $db->getResult();
						$decode = json_decode($hasil,true);
						$rowCat = $decode['post'];

						$table = 'subcategory';
						$field = '*';
						$on = '';
						$where = 'id='.$row[0]['subCategoryId'];
						$db->select($table,$field,$on,$where);
						$hasil = $db->getResult();
						$decode = json_decode($hasil,true);
						$rowSub = $decode['post'];
					?>


				<label type="text" class="cat detail-control col-xs-12" readonly> <?php echo $rowCat[0]['name']?> > <?php echo $rowSub[0]['name']?></label>

				<div class="clearfix"></div>

				<label class="label-control">Price</label>
					<?php
						$table = 'productprice';
						$field = '*';
						$on = '';
						$where = 'adsId='.$id;
						$db->select($table,$field,$on,$where);
						$hasil = $db->getResult();
						//echo $hasil;
						$decode = json_decode($hasil,true);
						$rowPrice = $decode['post'];
					 ?>

				<label class="detail-control col-xs-2" type="text" name="price" readonly><?php echo "Rp ".number_format($rowPrice[0]['price']);?></label>
				<div class="clearfix"></div>

				<label class="label-control">Condition</label>
				<label class="detail-control " type="text" name="condition" readonly>
					<?php
						if ($row[0]['new']==1)
							echo "New";
						else
							echo "Second";
					?>
				</label>
				<div class="clearfix"></div>

				<label class="label-control">Description</label>
				<p class="desc" readonly> <?php echo $row[0]['description'];?></p>
				<div class="clearfix"></div>
			</div>

				<div class="col-md-5 rightView">
					<div class="col-xs-12 userAds">
						<h4>Yasinta Addaafiah</h4>
						<a href=#>See Another Ads!</a>
					</div>
					<div class="col-xs-12 contact">
						<h4>Interested in this Ad?<small> Contact the Seller!</small></h4>
						<h4>08123456789</h4>
					</div>
				</div>
		</div>

	</body>
</html>
