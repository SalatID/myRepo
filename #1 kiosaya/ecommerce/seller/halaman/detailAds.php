<html>
	<head>
	</head>
	<body>

		<div id="product-view col-xs-12">

			<?php
				session_start();
				include('../../lib/config.php');
				$db=new configEcom();
				$userId = $_SESSION['userId'];
				$id=$_POST['rowid'];
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

			<h2><?php echo $row[0]['title'];?></h2>
			<div class="img-grid">
				<?php
					$table = 'images';
					$field = '*';
					$on = '';
					$where = 'adsId='.$row[0]['id'];
					$db->select($table,$field,$on,$where);
					$hasil = $db->getResult();
					$decode = json_decode($hasil,true);
					$rowImages = $decode['post'];
					if(isset($rowImages[0]) ){?>
						<img class="img-responsive" src="../../images/<?php echo $rowImages[0]['location'] ?>">
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

			<label class="detail-control col-sm-2" type="text" name="price" readonly><?php echo "Rp ".number_format($rowPrice[0]['price']);?></label>
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
			<div class="clearfix"></div>

		</div>
	</body>
</html>
