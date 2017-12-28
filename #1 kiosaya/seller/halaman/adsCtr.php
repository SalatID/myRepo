<?php
	session_start();
	include '../../lib/config.php';
	$db = new config();
	$userId = $_SESSION['userId'];
	$contractId = $_POST['idCtr'];
	//echo $contractId;die;
	$totalPage = 10;
	//echo "totalPage".$totalPage;
	$modul= isset($_GET['modul']) ? $_GET['modul'] : 'home';
	$page = isset($_GET["halaman"]) ? $_GET["halaman"] : 1;
	//echo "page".$page;
	$beginningPage = ($page - 1) * $totalPage;

	$table = 'campaign';
	$field = 'adsId';
	$on = '';
	$where = 'contractId = '.$contractId;
	$group ='';
	$db->select($table,$field,$on,$where,$group);
	$result = $db->getResult();
	$decode = json_decode($result,true);
	$rowCampaign = $decode['post'];
	//print_r($rowCampaign);die;
	$adsId = null;
	foreach ($rowCampaign as $keyCampaign => $valueCampaign) {
		if ($adsId == null) {
			$adsId = $valueCampaign['adsId'];
		}else {
			$adsId .= " , ".$valueCampaign['adsId'];
		}
	}

	$table = 'ads';
	$field = '*';
	$on = '';
	$where = 'userId='.$userId.' and (id) in ('.$adsId.')';
	$group ='';
	$order ='uploadDate desc';
	$limit = $beginningPage.", ".$totalPage;
	$db->select($table,$field,$on,$where,$group,$order,$limit);
	$result = $db->getResult();
	$decode = json_decode($result,true);
	$rowAds = $decode['post'];
	//print_r($rowAds);die;
	//echo count($rowAds);
 ?>
<html>
	<body>
		<div id="container">
			<div class="tab-content">
				<div class="tab-pane fade in active" id="adsActive">
					<div class="table-responsive">
						<div class="">
							<div class="" style="float: left;">
								<a href="index.php?modul=contract" class="btn btn-info"><i class="fa fa-chevron-left"></i> Back</a>
							</div>
							<div class="clearfix"></div>
						</div></br>
							<table class="table table-striped table-bordered">
								<thead>
									<tr class="info">
										<th class=" centerAlign">Upload Date</th>
										<th class=" centerAlign">Title</th>
										<th class=" centerAlign">Click</th>
										<th class=" centerAlign">Slot</th>
										<th class=" centerAlign">Action</th>
									</tr>
								</thead>
								<?php
								if (count($rowAds) < 1) {?>
									<tr>
										<td colspan="5"><h1 style="text-align: center;">You don't Have Any And</h1></td>
									</tr>
								<?php
							} else {?>
									<tr style="height : 10px">
									<?php
									foreach ($rowAds as $keyAds => $valueAds)  {
										?>

									<td><?php echo substr($valueAds['uploadDate'],-19,10); ?></td>
									<td><?php echo $valueAds['title']; ?></td>
									<td>
										<?php
										$table = 'countclick';
										$field = '*';
										$on = '';
										$where = 'contractId = '.$contractId.' and adsId= '.$valueAds['id'];
										$group ='';
										$order ='';
										$db->select($table,$field,$on,$where);
										$result = $db->getResult();
										$decode = json_decode($result,true);
										//print_r($decode);
										$rowCountClick = $decode['post'];
										 ?>
										 Click <b><?php echo count($rowCountClick) ?></b>
									</td>
									<?php
										$table = 'slot';
										$field = '*';
										$on = '';
										$where = 'adsId='.$valueAds['id'].' and contractId='.$contractId;
										$db->select($table,$field,$on,$where);
										$result = $db->getResult();
										$decode = json_decode($result,true);
										//print_r($decode);
										$decode = $decode['post'];
									 ?>
									<td>
										<?php
										$r=1;
										//print_r($valueAds);
											foreach ($decode as $keySlot => $valueSlot) {
													$table = 'showads';
													$field = '*';
													$on = '';
													$where = 'slotId='.$valueSlot['id'];
													$db->select($table,$field,$on,$where);
													$result = $db->getResult();
													$decode = json_decode($result,true);
													$rowShowAds = $decode['post'];
													//print_r($decode);
													$decode = $decode['post'];
													$month = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
													foreach ($rowShowAds as $keyShowAds => $valueShowAds) {
														$date = date_create($valueSlot['date']);
														if ($valueShowAds['showStat']==1) {
															?>
															<b><?php echo $r.". ".$valueSlot['days'].', '.date_format($date, "d").' '.$month[date_format($date, "n")].' '.date_format($date, "Y"); ?></b>
															<div class="activeSlot">
																active
															</div></br>
														<?php }else { ?>
															<b><?php echo $r.". ".$valueSlot['days'].', '.date_format($date, "d").' '.$month[date_format($date, "n")].' '.date_format($date, "Y"); ?></b>
															<div class="expiredSlot">
																expired
															</div></br>
													<?php	}
													}
													$table = 'time';
													$field = '*';
													$on = '';
													$where = 'id='.$valueSlot['timeId'];
													$db->select($table,$field,$on,$where);
													$result = $db->getResult();
													$decode = json_decode($result,true);
													$rowAds = $decode['post'];
													//print_r($decode);
													$decode = $decode['post'];
													foreach ($decode as $keyTime => $valueTime) {
														if ($valueTime['id']==$valueSlot['timeId']) {
															echo "&nbsp&nbsp&nbsp&nbsp".$valueTime['start'].' s.d '.$valueTime['end'].'</br>';
														}
													}

													$r++;
												}
										?>
									</td>
									<td class="centerAlign" style="vertical-align : middle">
										<div class="btn-group">
											<a class="btn btn-default btn-sm Detail" data-id="<?php echo $valueAds['id']?>" data-toggle="modal" href="#detailAds"><i class="fa fa-eye" aria-hidden="true"></i> Detail</a>
											<a name="111" class="btn btn-default btn-sm edit" data-toggle="modal" href="#editAds" data-id="<?php echo $valueAds['id']?>"><i class="fa fa-pencil" aria-hidden="true" ></i> Edit</a>
											<button class="_stop_camp btn btn-default btn-sm statistic" data-id="<?php echo $valueAds['id']?>"><i class="fa fa-bar-chart" aria-hidden="true"></i> Statistic</button>
											<input type="hidden" class="pageName" value="adsCtr">
											<input type="hidden" class="contractId" value="<?php echo $contractId ?>">
										</div>
									</td>
								</tr>
							<?php }
						} ?>
							</table>


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
					$('.statistic').click(function(){
 					 var adsId = $(this).data('id');
					 var contractId = $('.contractId').val();
 					 //alert(id);
 					 $.ajax({
 						 type : 'POST',
 						 url : 'halaman/statistic.php',
 						 data :  'adsId='+adsId+'&contractId='+contractId,
 						 success : function(data){
 						 $('.tableCtr').html(data);//menampilkan data ke dalam modal
 						 }
 					 });
 				 });
    });
  </script>
	</body>

</html>
