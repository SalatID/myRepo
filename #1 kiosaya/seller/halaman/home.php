<?php
	$totalPage = 5;
	//echo "halaman".$totalPage;
	$modul= isset($_GET['modul']) ? $_GET['modul'] : 'home';
	$page = isset($_GET["halaman"]) ? $_GET["halaman"] : 1;
	//echo "page".$page;
	$beginningPage = ($page - 1) * $totalPage;
	//echo "mulai".$beginningPage;
	$table = 'ads';
	$field = '*';
	$on = '';
	$where = 'userId='.$userId;
	$group ='';
	$order ='uploadDate desc';
	$limit = $beginningPage.", ".$totalPage;
	$db->select($table,$field,$on,$where,$group,$order,$limit);
	$result = $db->getResult();
	$decode = json_decode($result,true);
	$rowAds = $decode['post'];
 ?>


<html>
<link rel="stylesheet" href="../css/style.css">

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">


<h1 align="center">Latest Ads</h1>

	<?php
		if (count($rowAds) < 1) {?>
		<h1 style="text-align: center; color: grey;">No Ads</h1>
		<?php
	} else {?>
	<div class="row">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th style="width:110px;">Upload Date</th>
							<th style="width:200px;"></th>
							<th style="width:300px;">Title</th>
							<th>Redirect Link</th>
							<th>Status</th>
							<th></th>
						<tr>
					</thead>
					<tbody>

					<?php

							for ($i=0; $i < count($rowAds); $i++) {
								$table = 'adsprice';
								$field = '*';
								$on = '';
								$where = 'adsId='.$rowAds[$i]['id'];
								$db->select($table,$field,$on,$where);
								$result = $db->getResult();
								//echo $result;
								$decode = json_decode($result,true);
								$rowPrice = $decode['post'];
					?>
							<tr>
								<td rowspan="2"><?php echo substr($rowAds[$i]['uploadDate'],-19,10); ?></td>
								<td rowspan="2">
                                	<?php
										$table = 'images';
										$field = '*';
										$on = '';
										$where = 'adsId='.$rowAds[$i]['id'];
										$db->select($table,$field,$on,$where);
										$result = $db->getResult();
										//echo $result;
										$decode = json_decode($result,true);
										$rowImages = $decode['post'];
										 ?>
										<img style="max-width: 120px; max-height: 120px; margin-left:auto;  margin-right:auto;" src="../images/<?php echo $rowImages[0]['location'] ?>" class="img-responsive" alt="">
                                </td>
								<td>
                                	<?php echo $rowAds[$i]['title']; ?><input type="hidden" id="pageName" value="active">
                                </td>

								<td rowspan="2"> <?php echo $rowAds[$i]['redirectLink']; ?></td>
								<?php if ($rowAds[$i]['active']==1) {
									echo "<td><h3>Active</h3></td>";
								}else {
									echo "<td><h3>Non Active</h3></td>";
								}?>
							</tr>
							<tr>
								<td>
									<i class="fa fa-eye" aria-hidden="true"></i>
									<a data-toggle="modal" href="#detailAds" class="aksi" id="Detail" data-id="<?php echo $rowAds[$i]['id']?>">Detail</a>
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
									<a data-toggle="modal" href="#editAds" class="aksi" id="edit" data-id="<?php echo $rowAds[$i]['id']?>">Edit</a>
								</td>
							</tr>
								<?php
							}
						}
							 ?>
						</tbody>
					</table>
                    <a class="btn btn-default" href="index.php?modul=activeAds">See All Ads</a>
				</div>
	</div>
</html>
<!--Modal View Ads start here-->
<div id="detailAds" class="modal fade" role="dialog" style="padding:0;">
	<div class="modal-dialog">
	<!-- konten modal-->
	<div class="modal-content">
		<!-- heading modal -->
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Detail Advertise</h4>
		</div>
		<!-- body modal -->
		<div class="modal-body">

		</div>
	</div>
	</div>
</div>
<!--Modal edit Ads start here-->
<div id="editAds" class="modal fade" role="dialog">
	<div class="modal-dialog">
	<!-- konten modal-->
	<div class="modal-content">
		<!-- heading modal -->
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Edit Advertise</h4>
		</div>
		<!-- body modal -->
		<div class="modal-body">

		</div>
	</div>
	</div>
</div>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	var adsId = $('#adsId').val();
		$('a#Detail').click(function () {
			var rowid = $(this).data('id');
			$.ajax({
					type : 'POST',
					url : 'halaman/detailAds.php',
					data :  'rowid='+rowid,
					success : function(data){
					$('.modal-body').html(data);//menampilkan data ke dalam modal
					}
				})
		 });
		 $('a#edit').click(function () {
			var rowid = $(this).data('id');
			var pageName = $("input#pageName").val();
			$.ajax({
					type : 'POST',
					url : 'halaman/editAds.php',
					data :  'rowid='+rowid+"&pageName="+pageName,
					success : function(data){
					$('.modal-body').html(data);//menampilkan data ke dalam modal
					}
				})
			});
});
</script>
