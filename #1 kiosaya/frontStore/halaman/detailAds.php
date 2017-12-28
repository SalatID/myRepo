<html>
	<head>
	</head>
	<body>

		<div classs="productView">
			<div class="col-md-7 leftView">
				<div class="col-xs-12 left">
					<div class="leftHeader">
						<?php
							$id=$_GET['rowId'];
							//echo $id;
							$table = 'ads';
							$field = '*';
							$on = '';
							$where = 'id='.$id;
							$dbe->select($table,$field,$on,$where);
							$hasil = $dbe->getResult();
							//echo $hasil;
							$decode = json_decode($hasil,true);
							//print_r($decode);
							$row = $decode['post'];
							$userId = $row[0]['userId'];
						?>

						<h2 class="fTitles"><?php echo $row[0]['title'];?></h2>
					</div>

					<div class="imgGrid">
						<?php
							$table = 'images';
							$field = 'location';
							$on = '';
							$where = 'adsId='.$id;
							$dbe->select($table,$field,$on,$where);
							$hasil = $dbe->getResult();
							$decode = json_decode($hasil,true);
							$rowImages = $decode['post'];
							if(isset($rowImages[0]) ){?>
								<img src="../images/<?php echo $rowImages[0]['location'] ?>" class="img-responsive" alt="">
					</div><br><br>
						<?php
						}
						?>
					<?php
						$categoryId = $row[0]['categoryId'];
						$table = "category";
						$field = "name";
						$order = "name";
						$where = "id=".$categoryId;
						$on = "";
						$dbe->select($table,$field,$on,$where,$order);
						$hasil = $dbe->getResult();
						$decode = json_decode($hasil,true);
						$rowCat = $decode['post'];

						$table = 'subcategory';
						$field = 'name';
						$on = '';
						$where = 'id='.$row[0]['subCategoryId'];
						$dbe->select($table,$field,$on,$where);
						$hasil = $dbe->getResult();
						$decode = json_decode($hasil,true);
						$rowSub = $decode['post'];
					?>

					<label type="text" class="cat detail-control col-xs-12" readonly> <?php echo $rowCat[0]['name']?> > <?php echo $rowSub[0]['name']?></label>
					<div class="clearfix"></div>

					<label class="label-control">Price</label>
						<?php
							$table = 'adsprice';
							$field = 'price';
							$on = '';
							$where = 'adsId='.$id;
							$dbe->select($table,$field,$on,$where);
							$hasil = $dbe->getResult();
							//echo $hasil;
							$decode = json_decode($hasil,true);
							$rowPrice = $decode['post'];
						 ?>

					<label class="detail-control col-xs-2" type="text" name="price" readonly><?php echo "Rp ".number_format($rowPrice[0]['price']);?></label>
					<div class="clearfix"></div>

					<?php if ($rowCat[0]['name'] == 'Jasa') {

					} else{ ?>
						<label class="label-control">Condition</label>
						<label class="detail-control col-sm-2" type="text" name="condition" readonly>
							<?php
								if ($row[0]['new']==1)
									echo "New";
								else
									echo "Second";
							?>
						</label>
					<?php }?>
					<div class="clearfix"></div>

					<label class="label-control">Description</label>
					<p class="desc" readonly> <?php echo nl2br(str_replace('','',htmlspecialchars($row[0]['description'])));?></p>
				</div>
			</div>

			<?php
				$table = 'profile';
				$field = '*';
				$on = '';
				$where = 'id='.$userId;
				$dbe->select($table,$field,$on,$where);
				$hasil = $dbe->getResult();
				$decode = json_decode($hasil,true);
				//print_r($decode);
				$rowUser = $decode['post'];
			 ?>

			<div class="col-md-5 rightView">
				<div class="col-xs-12 userAds">
					<h4 style="text-transform: capitalize;"><?php echo $rowUser[0]['name']; ?></h4>
					<?php
							$provinceId = $rowUser[0]['provinceId'];
							$city = $rowUser[0]['cityId'];
							$table = "provinces a INNER JOIN city b";
							$field = "a.name as provinceName, b.name";
							$where = "province_id =".$provinceId." and b.id=".$city;
							$on = "a.id = b.province_id";
							$dbe->select($table,$field,$on,$where);
							$hasil = $dbe->getResult();
							$decode = json_decode($hasil,true);
							//print_r($decode);
							$rowAddress = $decode['post'];
					 ?>
					<div class="fLocation"><i class="fa fa-map-marker" aria-hidden="true"></i>  <?php echo $rowAddress[0]['name']." - ".$rowAddress[0]['provinceName'] ?></div>
					<a href=#>See Another Ads!</a>
				</div>
				<div class="col-xs-12 contact">
					<h4>Interested in this Ad?<small> Contact the Seller!</small></h4>
					<h4><?php echo $rowUser[0]['phone']; ?></h4>
				</div>
				<div class="col-xs-12 contact">
					<?php
						if ($row[0]['active']==1) {
							echo '<h1>Ready Stock</h1>';
						} else {
							echo '<h1>Sold Out</h1>';
						}
					 ?>
				</div>

			</div>
		</div>
	</body>
</html>
