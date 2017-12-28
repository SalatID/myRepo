<?php
	$halaman = 5;
	//echo "halaman".$halaman;
	$modul= isset($_GET['modul']) ? $_GET['modul'] : 'home';
	$page = isset($_GET["halaman"]) ? $_GET["halaman"] : 1;
	//echo "page".$page;
	$mulai = ($page - 1) * $halaman;
	//echo "mulai".$mulai;
	$table = 'ads';
	$field = '*';
	$on = '';
	$where = 'userId='.$userId.' and active=1';
	$group ='';
	$order ='uploadDate desc';
	$limit = $mulai.", ".$halaman;
	$db->select($table,$field,$on,$where,$group,$order,$limit);
	$hasil = $db->getResult();
	$decode = json_decode($hasil,true);
	$rowAds = $decode['post'];
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
				<li class="active">
					<a href="index.php?modul=activeAds">Active</a>
				</li>
				<li>
					<a href="index.php?modul=nonActiveAds" style="color:#D2D3D4">Non Active</a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane fade in active" id="adsActive">
					<div class="table-responsive">
						<h2>My Active Ads</h2>
						<table class="table">
							<thead>
								<tr>
									<th>Upload Date</th>
									<th></th>
									<th>Title</th>
									<th>Price</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (count($rowAds) < 1) {?>
									<tr>
										<td colspan="5"><h1 style="text-align: center;">Anda Tidak Memiliki Iklan Aktif</h1></td>
									</tr>
								<?php
								} else {
										for ($i=0; $i < count($rowAds); $i++) {
											$table = 'adsprice';
											$field = '*';
											$on = '';
											$where = 'adsId='.$rowAds[$i]['id'];
											$db->select($table,$field,$on,$where);
											$hasil = $db->getResult();
											//echo $hasil;
											$decode = json_decode($hasil,true);
											$rowPrice = $decode['post'];
											?>
								<tr>
									<td rowspan="2"><?php echo substr($rowAds[$i]['uploadDate'],-19,10); ?></td>
									<div class="imageGrid" style="max-width: 120px; max-height: 120px;">
									<td rowspan="2">
										<?php
										$table = 'images';
										$field = '*';
										$on = '';
										$where = 'adsId='.$rowAds[$i]['id'];
										$db->select($table,$field,$on,$where);
										$hasil = $db->getResult();
										//echo $hasil;
										$decode = json_decode($hasil,true);
										$rowImages = $decode['post'];
										 ?>
										<img style="max-width: 120px; max-height: 120px; margin-left:auto;  margin-right:auto;" src="../../images/<?php echo $rowImages[0]['location'] ?>" class="img-responsive" alt="">
									</td>
									<td>
										<?php echo $rowAds[$i]['title']; ?><input type="hidden" id="pageName" value="active">
									</td>
									<td rowspan="2">Rp <?php echo number_format($rowPrice[0]['price']); ?></td>
									<td rowspan="2">
										<a data-toggle="modal" class="btn btn-danger" id="soldOut" style="width : 60%" data-id="<?php echo $rowAds[$i]['id']?>">Sold Out</a>
											<input type="hidden" id="adsId" name="adsId" value="<?php echo $rowAds[$i]['id'] ?>">
									</td>
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
										<li><a href="index.php?modul=<?php echo $modul;?>&halaman=1">First</a></li>
										<li><a href="index.php?modul=<?php echo $modul;?>&halaman=<?php echo $link_prev; ?>">&laquo;</a></li>
								<?php
								}
								?>

								<!-- LINK NUMBER -->
								<?php
								// Buat query untuk menghitung semua jumlah data
								$table = 'ads';
								$field = '*';
								$on = '';
								$where = 'userId='.$userId.' and active=1';
								$db->select($table,$field,$on,$where);
								$hasil = $db->getResult();
								//echo $hasil;
								$decode = json_decode($hasil, true);
								//print_r($decode);
								$rowSlot = $decode['post'];
								$total = count($rowSlot);
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
										<li <?php echo $link_active; ?>><a href="index.php?modul=<?php echo $modul;?>&halaman=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
										<li><a href="index.php?modul=<?php echo $modul;?>&halaman=<?php echo $link_next; ?>">&raquo;</a></li>
										<li><a href="index.php?modul=<?php echo $modul;?>&halaman=<?php echo $jumlah_page; ?>">Last</a></li>
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

				$('a#soldOut').click(function(){
					var adsId = $(this).data('id');
					var enabled = 0;
					swal({
					title: "Are you sure?",
					text: "you will disable this ads",
					type: "warning",
					showCancelButton: true,
					confirmButtonClass: "btn-danger",
					confirmButtonText: "Yes, disable it!",
					closeOnConfirm: false
				},
				function(){
					$.ajax({
							type : 'POST',
							url : 'halaman/changeOption.php',
							data :  "adsId="+adsId+'&enabled='+enabled,
							success : function(result){
								swal({
									title: "Thank You",
									 text: "Your Ads Successfully Disabled",
										type: "success"
									},
									function(){
										window.location.href ="index?modul=nonActiveAds";
								});
							}
						})
					});
				});
    });
  </script>
	</body>

</html>
