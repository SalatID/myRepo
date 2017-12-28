<?php
	$totalPage = 10;
	//echo "totalPage".$totalPage;
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
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Iklan Aktif</title>

	</head>
	<body>
		<div id="container">
			<div class="tab-content">
				<div class="tab-pane fade in active" id="adsActive">
					<div class="table-responsive">
						<div class="">
							<div class="" style="float: left;">
								<h2>My Ads</h2>
							</div>
							<div class="input-group" style="float:right; width : 30%;margin-top : 2%;">
							  <input type="text" class="form-control searchActiveAds" placeholder="Input Title..">
							  <span class="input-group-btn">
							    <button class="btn btn-default" type="button">
							      <span class="glyphicon glyphicon-search"></span>
							    </button>
							  </span>
							</div>
						</div>
							<table class="table table-striped table-bordered">
								<thead>
									<tr class="info">
										<th class=" centerAlign">Upload Date</th>
										<th class=" centerAlign">Title</th>
										<th class=" centerAlign">Click</th>
										<th class=" centerAlign">Action</th>
									</tr>
								</thead>
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
										$result = $db->getResult();
										//echo $result;
										$decode = json_decode($result,true);
										$rowPrice = $decode['post'];
										?>
								<tr style="height : 10px">
									<td><?php echo substr($rowAds[$i]['uploadDate'],-19,10); ?></td>
									<td><?php echo $rowAds[$i]['title']; ?></td>
									<td>
										<?php
										$table = 'countclick';
										$field = '*';
										$on = '';
										$where = 'adsId='.$rowAds[$i]['id'];
										$db->select($table,$field,$on,$where);
										$result = $db->getResult();
										$decode = json_decode($result,true);
										//print_r($decode);
										$rowCountClick = $decode['post'];
										 ?>
										 Click <b><?php echo count($rowCountClick) ?></b>
									</td>
									<td class="centerAlign">
										<div class="btn-group">
											<?php
												if($rowAds[$i]['active'] == 1){?>
													<button class="_play_camp btn btn-default btn-sm active actived" disabled ><i style="color : #00ff39" class="fa fa-power-off " aria-hidden="true" ></i> Enable</button>
													<button class="_stop_camp btn btn-default btn-sm soldOut" data-id="<?php echo $rowAds[$i]['id']?>"><i style="color : gray" class="fa fa-power-off " aria-hidden="true"></i> Disabled</button>
											<?php	} else {?>
													<button class="_play_camp btn btn-default btn-sm actived" data-id="<?php echo $rowAds[$i]['id']?>"><i style="color : gray" class="fa fa-power-off " aria-hidden="true" ></i> Enable</button>
													<button class="_stop_camp btn btn-default btn-sm soldOut active" data-id="<?php echo $rowAds[$i]['id']?>" disabled><i style="color : Red" class="fa fa-power-off " aria-hidden="true"></i> Disabled</button>
											<?php }
											 ?>

											<a class="btn btn-default btn-sm Detail" data-id="<?php echo $rowAds[$i]['id']?>" data-toggle="modal" href="#detailAds"><i class="fa fa-eye" aria-hidden="true"></i> Detail</a>
											<a name="111" class="btn btn-default btn-sm edit" data-toggle="modal" href="#editAds" data-id="<?php echo $rowAds[$i]['id']?>"><i class="fa fa-pencil" aria-hidden="true" ></i> Edit</a>
											<input type="hidden" class="pageName" value="ads">
											<button class="_remove_camp btn btn-danger btn-sm delete"  data-id="<?php echo $rowAds[$i]['id']?>"><i class="fa fa-trash-o" aria-hidden="true"></i> Remove</button>
										</div>
									</td>
								</tr>
							<?php } } ?>
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
										$prevLink = ($page > 1) ? $page - 1 : 1;
								?>
										<li><a href="index.php?modul=<?php echo $modul;?>&halaman=1">First</a></li>
										<li><a href="index.php?modul=<?php echo $modul;?>&halaman=<?php echo $prevLink; ?>">&laquo;</a></li>
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
								$result = $db->getResult();
								//echo $result;
								$decode = json_decode($result, true);
								//print_r($decode);
								$rowSlot = $decode['post'];
								$total = count($rowSlot);
								//echo $total;

								$totalPage = ceil($total / $totalPage); // Hitung jumlah halamanya
								//echo $totalPage;
								$totalNumber = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
								$startNumber = ($page > $totalNumber) ? $page - $totalNumber : 1; // Untuk awal link member
								$endNumber = ($page < ($totalPage - $totalNumber)) ? $page + $totalNumber : $totalPage; // Untuk akhir link number

								for ($i = $startNumber; $i <= $endNumber; $i++) {
										$activeLink = ($page == $i) ? 'class="active"' : '';
								?>
										<li <?php echo $activeLink; ?>><a href="index.php?modul=<?php echo $modul;?>&halaman=<?php echo $i; ?>"><?php echo $i; ?></a></li>
								<?php
								}
								?>

								<!-- LINK NEXT AND LAST -->
								<?php
								// Jika page sama dengan jumlah page, maka disable link NEXT nya
								// Artinya page tersebut adalah page terakhir
								if ($page == $totalPage) { // Jika page terakhir
								?>
										<li class="disabled"><a href="#">&raquo;</a></li>
										<li class="disabled"><a href="#">Last</a></li>
								<?php
								} else { // Jika bukan page terakhir
										$nextLink = ($page < $totalPage) ? $page + 1 : $totalPage;
								?>
										<li><a href="index.php?modul=<?php echo $modul;?>&halaman=<?php echo $nextLink; ?>">&raquo;</a></li>
										<li><a href="index.php?modul=<?php echo $modul;?>&halaman=<?php echo $totalPage; ?>">Last</a></li>
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
        $('.Detail').click(function () {
					var adsId = $(this).data('id');
					$.ajax({
					    type : 'POST',
					    url : 'halaman/detailAds.php',
					    data :  'adsId='+adsId,
					    success : function(data){
					    $('.modal-body').html(data);//menampilkan data ke dalam modal
					    }
						})
         });
				 $('.edit').click(function () {
 					var rowid = $(this).data('id');
					var pageName = $(".pageName").val();
 					$.ajax({
 					    type : 'POST',
 					    url : 'halaman/editAds.php',
 					    data :  'rowid='+rowid+"&pageName="+pageName,
 					    success : function(data){
 					    $('.modal-body').html(data);//menampilkan data ke dalam modal
 					    }
	 					})
          });

				$('.soldOut').click(function(){
					var adsId = $(this).data('id');
					var enabled = 0;
					//alert(adsId)
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
										window.location.href ="index?modul=activeAds";
								});
							}
						})
					});
				});
				$('.actived').click(function(){
 				 var adsId = $(this).data('id');
 				 var enabled = 1;
 				 swal({
 				 title: "Are you sure?",
 				 text: "you will enable this ads",
 				 type: "warning",
 				 showCancelButton: true,
 				 confirmButtonClass: "btn-danger",
 				 confirmButtonText: "Yes, enable it!",
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
 									text: "Your Ads Successfully Enable",
 									 type: "success"
 								 },
 								 function(){
 									 window.location.href ="index?modul=activeAds";
 							 });
 						 }
 					 })
 				 });
 			 });
			 $('.delete').click(function(){
				 var adsId = $(this).data('id');
				 swal({
				 title: "Are you sure?",
				 text: "Your will delete this ads.",
				 type: "warning",
				 showCancelButton: true,
				 confirmButtonClass: "btn-danger",
				 confirmButtonText: "Yes, delete it!",
				 closeOnConfirm: false
			 },
			 function(){
				 $.ajax({
						 type : 'POST',
						 url : 'halaman/delete.php',
						 data :  "adsId="+adsId,
						 success : function(result){
							 swal({
								 title: "Thank You",
									text: "Your Ads Successfully Deleted",
									 type: "success"
								 },
								 function(){
									 window.location.href ="index?modul=activeAds";
							 });
						 }
					 })
				 });
			 });
				$('.searchActiveAds').keyup(function(){
					var keyword = $('.searchActiveAds').val();
					alert (keyword);
				});
    });
  </script>
	</body>

</html>
