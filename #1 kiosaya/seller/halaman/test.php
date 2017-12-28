<?php
	$halaman = 5;
	//echo "halaman".$halaman;
	$page = isset($_GET["halaman"]) ? $_GET["halaman"] : 1;
	//echo "page".$page;
	$mulai = ($page - 1) * $halaman;
	//echo "mulai".$mulai;
	$table = 'slot a INNER JOIN ads b';
	$field = 'a.*, b.*, a.id as slotId';
	$on ='a.adsId = b.id';
	$where ='b.userId ='.$userId.' and active=1';
	$group ='';
	$order ='date desc';
	$limit = $mulai.", ".$halaman;
	$db->select($table,$field,$on,$where,$group,$order,$limit);
	$hasil = $db->getResult();
	//echo $hasil;
	$decode = json_decode($hasil, true);
	//print_r($decode);
	$row = $decode['post'];
 ?>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Iklan Aktif</title>

	</head>
	<body>
		<div id="container">
			<ul class="nav nav-tabs">
				<li>
					<a href="index.php?modul=active_ads"  style="color:#D2D3D4">Active</a>
				</li>
				<li>
					<a href="index.php?modul=nonActive_ads" style="color:#D2D3D4">Non Active</a>
				</li>
				<li class="active">
					<a href="index.php?modul=priority_ads">Priority</a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane fade in active" id="adsActive">
					<div class="table-responsive">
						<h2>My Priority Ads</h2>
						<table class="table">
							<thead>
								<tr class="info table-bordered table-striped" >
									<th rowspan="2">Date</th>
									<th colspan="2">Time</th>
									<th rowspan="2"></th>
									<th rowspan="2">Title</th>
									<th rowspan="2">Price</th>
									<th rowspan="2">Status</th>
								</tr>
									<tr class="info table-bordered table-striped">
										<th>Start</th>
										<th>End</th>
									</tr>
							</thead>
							<tbody>
								<?php
								if (count($row) < 1) {?>
									<tr>
										<td colspan="7"><h1 style="text-align: center;">Anda Tidak Memiliki Iklan Prioritas</h1></td>
									</tr>
								<?php
								} else {
										for ($i=0; $i < count($row); $i++) {
											$adsId = $row[$i]['adsId'];
											?>
								<tr>
									<td rowspan="2"><?php echo $row[$i]['date']; ?></td>
									<?php
									$timeId = $row[$i]['timeId'];
									$table = 'time';
									$field = '*';
									$on = '';
									$where = 'id='.$timeId;
									$db->select($table,$field,$on,$where);
									$hasil = $db->getResult();
									$decode = json_decode($hasil,true);
									//print_r($decode);
									$rowTime = $decode['post'];
									 ?>
									<td rowspan="2"><?php echo $rowTime[0]['start']; ?></td>
									<td rowspan="2"><?php echo $rowTime[0]['end']; ?></td>

									<div class="imageGrid" style="max-width: 120px; max-height: 120px;">
										<td rowspan="2">
											<?php
											$table = 'images';
											$field = '*';
											$on = '';
											$where = 'adsId='.$row[$i]['id'];
											$db->select($table,$field,$on,$where);
											$hasil = $db->getResult();
											//echo $hasil;
											$decode = json_decode($hasil,true);
											$rowImages = $decode['post'];
											 ?>
											<img style="max-width: 120px; max-height: 120px; margin-left:auto;  margin-right:auto;" src="../images/<?php echo $rowImages[0]['location'] ?>" class="img-responsive" alt="">
										</td>
									</div>
									<td><?php echo $row[$i]['title']; ?><input type="hidden" id="pageName" value="priority"></td>
									<td rowspan="2">Rp
										<?php
										$table = 'productprice';
										$field = '*';
										$on = '';
										$where = 'adsId='.$row[$i]['id'];
										$db->select($table,$field,$on,$where);
										$hasil = $db->getResult();
										//echo $hasil;
										$decode = json_decode($hasil,true);
										$rowPrice = $decode['post'];
										echo number_format($rowPrice[0]['price']);
										?>
									</td>
									<td rowspan="2">
										<?php
                      $table = 'showads';
                      $field = 'slotId, showStat';
                      $on = '';
                      $where = 'slotId='.$row[$i]['slotId'];
                      $db->select($table,$field,$on,$where);
                      $hasil = $db->getResult();
                      //echo $hasil;
                      $decode = json_decode($hasil,true);
                      //print_r($decode);
                      $rowShow = $decode['post'];
											if ($rowShow[0]['showStat'] == 0) {
												?>
												<form class="" action="index.php?modul=slot_available" method="post">
													<input type="hidden" id="adsId" name="adsId" value="<?php echo $row[$i]['id'] ?>">
													<input type="" name="" class="btn btn-danger" style="width : 60%" value="Expirerd" disabled></br>
													<input type="submit" name="" class="btn btn-info" style="width : 60%" value="Reactivate" >
												</form>
											<?php
											}else {?>
														<input type="" class="btn btn-info" name="" style="width : 60%" value="Active" disabled>
													<?php
												}
										 ?>
									</td>
								</tr>
								<tr>
									<td>
										<i class="fa fa-eye" aria-hidden="true"></i>
										<a data-toggle="modal" href="#detailAds" class="aksi" id="lihat" data-id="<?php echo $row[$i]['id']?>">Lihat</a>
										<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
										<a data-toggle="modal" href="#editAds" class="aksi" id="edit" data-id="<?php echo $row[$i]['id']?>">Edit</a>
									</td>
								</tr>
								<?php
							}
						}
							 ?>
							</tbody>
						</table>
						<ul class="pagination">
								<!-- LINK FIRST AND PREV -->
								<?php
								if ($page == 1) { // Jika page adalah pake ke 1, maka disable link PREV
								?>
										<li class="disabled"><a href="#">First</a></li>
										<li class="disabled"><a href="#">&laquo;</a></li>
								<?php
								} else { // Jika buka page ke 1
										$link_prev = ($page > 1) ? $page - 1 : 1;
								?>
										<li><a href="index.php?modul=priority_ads&halaman=1">First</a></li>
										<li><a href="index.php?modul=priority_ads&halaman=<?php echo $link_prev; ?>">&laquo;</a></li>
								<?php
								}
								?>

								<!-- LINK NUMBER -->
								<?php
								// Buat query untuk menghitung semua jumlah data
								$table = 'slot a INNER JOIN ads b';
								$field = 'a.*, b.*';
								$on ='a.adsId = b.id';
								$where ='b.userId ='.$userId;
								$group ='';
								$order ='';
								$db->select($table,$field,$on,$where,$group,$order);
								$hasil = $db->getResult();
								//echo $hasil;
								$decode = json_decode($hasil, true);
								//print_r($decode);
								$row = $decode['post'];
								$total = count($row);
								$get_jumlah = $total;
								//echo $get_jumlah;

								$jumlah_page = ceil($get_jumlah / $halaman); // Hitung jumlah halamanya
								//echo $jumlah_page;
								$jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
								$start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1; // Untuk awal link member
								$end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number

								for ($i = $start_number; $i <= $end_number; $i++) {
										$link_active = ($page == $i) ? 'class="active"' : '';
								?>
										<li <?php echo $link_active; ?>><a href="index.php?modul=priority_ads&halaman=<?php echo $i; ?>"><?php echo $i; ?></a></li>
								<?php
								}
								?>

								<!-- LINK NEXT AND LAST -->
								<?php
								// Jika page sama dengan jumlah page, maka disable link NEXT nya
								// Artinya page tersebut adalah page terakhir
								if ($page == $jumlah_page) { // Jika page terakhir
								?>
										<li class="disabled"><a href="#">&raquo;</a></li>
										<li class="disabled"><a href="#">Last</a></li>
								<?php
								} else { // Jika bukan page terakhir
										$link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page;
								?>
										<li><a href="index.php?modul=priority_ads&halaman=<?php echo $link_next; ?>">&raquo;</a></li>
										<li><a href="index.php?modul=priority_ads&halaman=<?php echo $jumlah_page; ?>">Last</a></li>
								<?php
								}
								?>
						</ul>
					</div>
				</div>
			</div>
		</div>


		<!--Modal View Ads start here-->
		<div id="detailAds" class="modal fade" role="dialog">
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
        $('a#lihat').click(function () {
					var rowid = $(this).data('id');
					$.ajax({
					    type : 'POST',
					    url : 'halaman/detail_ads.php',
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
 					    url : 'halaman/edit_ads.php',
 					    data :  'rowid='+rowid+"&pageName="+pageName,
 					    success : function(data){
 					    $('.modal-body').html(data);//menampilkan data ke dalam modal
 					    }
	 					})
          });

				$('a#soldOut').click(function(){
					var adsId = $(this).data('id');
					var enabled = 0;
					$.ajax({
				      type : 'POST',
				      url : 'halaman/changeOption.php',
				      data :  "adsId="+adsId+'&enabled='+enabled,
				      success : function(result){
				        //$('.modal-body').html(result);
				      window.location.href ="index?modul=nonActive_ads";//redirect to active_ads
				      }
				    })
				});
    });
	</script>
</body>

</html>
