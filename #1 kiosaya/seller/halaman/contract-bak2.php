<?php
	$totalPage = 5;
	//echo "halaman".$totalPage;
	$modul= isset($_GET['modul']) ? $_GET['modul'] : 'home';
	$page = isset($_GET["halaman"]) ? $_GET["halaman"] : 1;
	//echo "page".$page;
	$beginningPage = ($page - 1) * $totalPage;
	echo "mulai".$beginningPage;
	$table = 'contract';
	$field = '*';
	$on = '';
	$where = 'userId='.$userId;
	$group ='';
	$order ='contractDate DESC';
	$limit = $beginningPage.", ".$totalPage;
	$db->select($table,$field,$on,$where,$group,$order,$limit);
	$result = $db->getResult();
	$decode = json_decode($result,true);
	$rowCtr = $decode['post'];
	//print_r ($decode);
 ?>
<div class="table-responsif">
	<h1>Contract</h1>
	<div class="pasangiklan">
		<a href="index.php?modul=newContract" class="btn btn-warning" style="background-color:#757ee6; border-color :#757ee6; margin : 0">
		<i class="fa fa-plus-circle"></i> New Contract
	</a>
	</div>
	<div class="tableCtr">
		<table class="table table-striped table-bordered">
			<thead>
				<tr class="info">
					<th class="centerAlign">No</th>
					<th class="centerAlign">Contract Number</th>
					<th class="centerAlign">Contract Date</th>
					<th class="centerAlign">Detail</th>
				</tr>
			</thead>
			<?php if(count($decode)==0){?>
				<tbody>
					<td colspan="4" class="centerAlign"><h1>You Dont Have Any Contract</h1></td>
				</tbody>
			<?php
		}else {
			$no=1;
			foreach ($rowCtr as $keyCtr => $valueCtr) {
				//echo $userId;
				$table = 'ads';
				$field = '*';
				$on = '';
				$where = 'userId='.$userId.' and contractId='.$valueCtr['id'];
				$group ='';
				$order ='uploadDate desc';
				$limit = $beginningPage.", ".$totalPage;
				$db->select($table,$field,$on,$where,$group,$order);
				$result = $db->getResult();
				$decode = json_decode($result,true);
				$rowAds = $decode['post'];
				echo count($rowAds);
			?>
			<tbody>
				<td class="centerAlign"><?php echo $no ?></td>
				<td class="centerAlign"><?php echo $valueCtr['id']; ?></td>
				<td class="centerAlign"><?php echo $valueCtr['contractDate']; ?></td>
				<td class="centerAlign">
					<div class="btn-group">
					<button class="_play_camp btn btn-warning btn-sm detailAds" data-id="<?php echo $valueCtr['id']?>"><i style="color : white" class="fa fa-buysellads" aria-hidden="true" ></i> Ads (<?php echo count($rowAds); ?>)</button>
					<button class="_stop_camp btn btn-default btn-sm statistic" data-id="<?php echo $valueCtr['id']?>"><i class="fa fa-bar-chart" aria-hidden="true"></i> Statistic</button>
				</div>
				</td>
			</tbody>
		<?php $no++;
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
						$prevLink = ($page > 1) ? $page - 1 : 1;
				?>
						<li><a href="index.php?modul=contract&halaman=1">First</a></li>
						<li><a href="index.php?modul=contract&halaman=<?php echo $prevLink; ?>">&laquo;</a></li>
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
				$result = $db->getResult();
				//echo $result;
				$decode = json_decode($result, true);
				//print_r($decode);
				$rowCtr = $decode['post'];
				$total = count($rowCtr);
				//echo $get_jumlah;

				$totalPage = ceil($total / $totalPage); // Hitung jumlah halamanya
				//echo $totalPage;
				$totalNumber = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
				$startNumber = ($page > $totalNumber) ? $page - $totalNumber : 1; // Untuk awal link member
				$endNumber = ($page < ($totalPage - $totalNumber)) ? $page + $totalNumber : $totalPage; // Untuk akhir link number

				for ($i = $startNumber; $i <= $endNumber; $i++) {
						$activeLink = ($page == $i) ? 'class="active"' : '';
				?>
						<li <?php echo $activeLink; ?>><a href="index.php?modul=contract&halaman=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
						<li><a href="index.php?modul=contract&halaman=<?php echo $nextLink; ?>">&raquo;</a></li>
						<li><a href="index.php?modul=contract&halaman=<?php echo $totalPage; ?>">Last</a></li>
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
			 $('.detailAds').click(function(){
				 var idCtr = $(this).data('id');
				 $.ajax({
					 type : 'POST',
					 url : 'halaman/adsCtr.php',
					 data :  'idCtr='+idCtr,
					 success : function(data){
					 $('.tableCtr').html(data);//menampilkan data ke dalam modal
					 }
				 });
			 });
			 $('.statistic').click(function(){
				 var ctrId = $(this).data('id');
				 //alert(id);
				 $.ajax({
					 type : 'POST',
					 url : 'halaman/statistic.php',
					 data :  'ctrId='+ctrId,
					 success : function(data){
					 $('.tableCtr').html(data);//menampilkan data ke dalam modal
					 //alert(data);
					 }
				 });
			 });
		 });

</script>
