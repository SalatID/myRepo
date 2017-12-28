<?php
	$totalPage = 5;
	//echo "halaman".$totalPage;
	$modul= isset($_GET['modul']) ? $_GET['modul'] : 'home';
	$page = isset($_GET["halaman"]) ? $_GET["halaman"] : 1;
	//echo "page".$page;
	$beginningPage = ($page - 1) * $totalPage;
	//echo "mulai".$beginningPage;
	$table = 'contract';
	$field = '*';
	$on = '';
	$where = 'userId='.$userId;
	$group ='';
	$order ='contractDate DESC';
	$limit = $beginningPage.", ".$totalPage;
	$db->select($table,$field,$on,$where,$group,$order,$limit);
	$hasil = $db->getResult();
	$decode = json_decode($hasil,true);
	$rowAds = $decode['post'];
	//print_r($decode);
	$decode = $decode['post'];
	//print_r ($decode);
 ?>
<div class="table-responsif">
	<h1>Make it Priority</h1>
	<div class="pasangiklan">
		<a href="index.php?modul=newContract" class="btn btn-warning" style="background-color:#757ee6; border-color :#757ee6; ">
		<i class="fa fa-plus-circle"></i> New Contract
	</a>
	</div>
	<div class="" id="tableSlot">
				<?php if(count($decode)==0){?>
					<div class="" style="border : solid; border-color : #F2F2F8; border-radius : 10px;">
							<h1  style=" size: 40;text-align : center;color : #000">You Dont Have Contract</h1>
					</div>
				<?php
			}else {
				$no=1;
				foreach ($decode as $keyCtr => $valueCtr) {?>
							<div class="panel-group" id="accordion">
						    <div class="panel panel-default">
									<a data-toggle="collapse" data-parent="#accordion" style="text-decoration: none;" href="#collapse<?php echo $keyCtr?>">
						      <div class="panel-heading" style="background-color : #D9EDF7">
						        <table style="width : 100%">
						        	<tr style="color : black">
						        		<td>Contract Number : <?php echo $valueCtr['id']; ?></td>
												<td style="text-align : right">Contract Date : <?php echo $valueCtr['contractDate']; ?></td>
						        	</tr>
						        </table>
						      </div></a>
			      <div id="collapse<?php echo $keyCtr?>" class="panel-collapse collapse">
			        <div class="panel-body">
								<?php
								$table = 'ads';
								$field = '*';
								$on = '';
								$where = 'userId='.$userId.' and contractId='.$valueCtr['id'];
								$db->select($table,$field,$on,$where);
								$hasil = $db->getResult();
								$decode = json_decode($hasil,true);
								$rowAds = $decode['post'];
								//print_r($decode);
								$decode = $decode['post'];?>
								<div class="table-responsive">
									<table class="table table-bordered table-striped">
										<tr>
											<th class="centerAlign">No</th>
											<th class="centerAlign">Title</th>
											<th class="centerAlign">Redirect Link</th>
											<th class="centerAlign">Slot</th>
											<th class="centerAlign">Action</th>
										</tr>
									<?php
									$x=1;
									foreach ($decode as $keyAds => $valueAds) {
										if ($valueAds['contractId']==$valueCtr['id']) {
											?>
												<tr>
													<td class="centerAlign"><?php echo $x; ?></td>
													<td class="centerAlign"><?php echo $valueAds['title']; ?></td>
													<td class="centerAlign" style="width : 30%;">
														<a href="<?php echo !is_numeric($valueAds['redirectLink']) ? $valueAds['redirectLink'] : '../ecommerce/frontstore/index.php?fstore=detail_ads&rowid='.$valueAds['redirectLink']; ?>" style="color : black" target="_blank"><?php echo !is_numeric($valueAds['redirectLink']) ? $valueAds['redirectLink'] : 'index.php?fstore=detail_ads&rowid='.$valueAds['redirectLink']; ?></a>
													</td>
													<?php
													$table = 'slot';
													$field = '*';
													$on = '';
													$where = 'adsId='.$valueAds['id'].' and contractId='.$valueCtr['id'];
													$db->select($table,$field,$on,$where);
													$hasil = $db->getResult();
													$decode = json_decode($hasil,true);
													$rowAds = $decode['post'];
													//print_r($decode);
													$decode = $decode['post'];
													?>
													<td style="width : 250px"><?php
													$r=1;
														foreach ($decode as $keySlot => $valueSlot) {
															if ($valueSlot['adsId']==$valueAds['id']) {
																$table = 'showads';
																$field = '*';
																$on = '';
																$where = 'slotId='.$valueSlot['id'];
																$db->select($table,$field,$on,$where);
																$hasil = $db->getResult();
																$decode = json_decode($hasil,true);
																$rowShowAds = $decode['post'];
																//print_r($decode);
																$decode = $decode['post'];
																foreach ($rowShowAds as $keyShowAds => $valueShowAds) {
																	if ($valueShowAds['showStat']==1) { ?>
																		<b><?php echo $r.". ".$valueSlot['days'].', '.$valueSlot['date']; ?></b>
																		<div class="activeSlot">
																			active
																		</div></br>
																	<?php }else { ?>
																		<b><?php echo $r.". ".$valueSlot['days'].', '.$valueSlot['date']; ?></b>
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
																$hasil = $db->getResult();
																$decode = json_decode($hasil,true);
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
														}
													?></td>
													<td><a id="Detail" href="#detailAds" data-toggle="modal" data-id="<?php echo $valueAds['id']?>" class="btn btn-info">Detail Ads</a></td>
												</tr>

										<?php
										$x++;
										}
									}
									 ?></table>
								</div>
							</div>
			      </div>
			    </div>
			  </div>
			<?php
			$no++;
			}
		}
		?>

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
						<li><a href="index.php?modul=contract&halaman=1">First</a></li>
						<li><a href="index.php?modul=contract&halaman=<?php echo $link_prev; ?>">&laquo;</a></li>
				<?php
				}
				?>

				<!-- LINK NUMBER -->
				<?php
				// Buat query untuk menghitung semua jumlah data
				$table = 'contract';
				$field = '*';
				$on ='';
				$where ='userId='.$userId;
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

				$jumlah_page = ceil($get_jumlah / $totalPage); // Hitung jumlah halamanya
				//echo $jumlah_page;
				$jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
				$start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1; // Untuk awal link member
				$end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number

				for ($i = $start_number; $i <= $end_number; $i++) {
						$link_active = ($page == $i) ? 'class="active"' : '';
				?>
						<li <?php echo $link_active; ?>><a href="index.php?modul=contract&halaman=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
						<li><a href="index.php?modul=contract&halaman=<?php echo $link_next; ?>">&raquo;</a></li>
						<li><a href="index.php?modul=contract&halaman=<?php echo $jumlah_page; ?>">Last</a></li>
				<?php
				}
				?>
		</ul>
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
		 });

</script>
