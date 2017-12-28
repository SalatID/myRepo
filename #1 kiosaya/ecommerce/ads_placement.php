<link rel="stylesheet" href="../css/own.css">
<link rel="stylesheet" href="../css/style.css">
<link href="../css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/bootstrap.css">
<link rel="stylesheet" href="../css/bootstrap-datepicker3.css">
<?php
  include_once 'lib/config.php';
  $db = new configEcom();
  $today=date('Y-m-d');
  $time = date('H:i:s');
  //echo $time;
  $table = "time";
  $field = "*";
  $where = "start <= "."'".$time."'"." and end >= "."'".$time."'";
  $on = "";
  $db->select($table,$field,$on,$where);
  $hasil = $db->getResult();
  $decode = json_decode($hasil,true);
  //print_r($decode);
  $rowTime = $decode['post'];
  for($i=0;$i<count($rowTime);$i++){
    $timeId = $rowTime[$i]['id'];
    $table = "slot a INNER JOIN showads b";
    $field = "a.*, b.*, b.id as showadsId";
    $where = "timeId =".$timeId." and date ="."'".$today."'".' and showStat=1 and adsPlacementId = 1';
    $on = "a.id=b.slotId";
    $db->select($table,$field,$on,$where);
    $hasil = $db->getResult();
    $decode = json_decode($hasil,true);
    //print_r($decode);
    $row = $decode['post'];
    $date= isset($row[0]['date']) ? $row[0]['date'] : $today;
    $start = $rowTime[$i]['start'];
    $end = $rowTime[$i]['end'];
    $minSec = date_create($end);
    date_add($minSec, date_interval_create_from_date_string('-1 seconds'));
    ?>
    <input type="hidden" id="time" value="<?php echo $time ?>">
    <input type="hidden" id="today" value="<?php echo $today?>">
    <input type="hidden" id="end" value="<?php echo date_format($minSec, 'H:i:s');?>">
    <input type="hidden" id='date' value="<?php echo $date?>">
    <?php
    //echo $start;
    //echo $end;
    //echo $time;
    if (isset($row[0])) {
		if ($today == $date) {
			//echo "hari sama";
			$minSec = date_create($end);
			date_add($minSec, date_interval_create_from_date_string('-1 seconds'));
			if($time > $start && $time <= date_format($minSec, 'H:i:s')){
				//echo "jam masih berlaku";
				$adsId=$row[0]['adsId'];
				//echo $adsId;
				$table = "ads";
				$field = "id,title, description, userId";
				$where = "id=".$adsId;
				$on = "";
				$db->select($table,$field,$on,$where);
				$hasil = $db->getResult();
				$decode = json_decode($hasil,true);
				//print_r($decode);
				$rowAds = $decode['post'];
				$table = "images";
				$field = "location";
				$where = "adsId=".$rowAds[0]['id'];
				$on = "";
				$db->select($table,$field,$on,$where);
				$hasil = $db->getResult();
				$decode = json_decode($hasil,true);
				//print_r($decode);
				$rowImg = $decode['post'];
				//echo $rowAds[0]['title'];
			   ?>
				<div class="rightBanner col-xs-12">

					<input type="hidden" id="showadsId" value="<?php echo $row[0]['showadsId']?>">
					<?php echo $time ?>
						<div class="tabPanel">
							<a href="frontStore/index.php?fstore=detail_ads&rowid=<?php echo $adsId ?>">
								<div class="productGrid">
									<div class="imageProduct">
										<img class="img-responsive" src="../images/<?php echo $rowImg[0]['location'] ?>" class="img-responsive" alt="">
									</div>
									<div class="productSummary">
										<div class="fTitle"><?php echo $rowAds[0]['title']; ?></div>
											 <?php
												$adsId=$rowAds[0]['id'];
												$table = "adsprice";
												$field = "price";
												$where = "adsId=".$adsId;
												$on = "";
												$db->select($table,$field,$on,$where);
												$hasil = $db->getResult();
												$decode = json_decode($hasil,true);
												//print_r($decode);
												$rowPrice = $decode['post'];
											 ?>
										<div class="fPrice"><?php echo "Rp ".number_format($rowPrice[0]['price']); ?></div>
										<input type="hidden" id="adsId" value="<?php echo $adsId?>">
									</div>
								</div>
							</a>
							<?php
								$userId = $rowAds[0]['userId'];
								$table = "profile";
								$field = "name, cityId, provinceId";
								$where = "userId=".$userId;
								$on = "";
								$db->select($table,$field,$on,$where);
								$hasil = $db->getResult();
								$decode = json_decode($hasil,true);
								//print_r($decode);
								$rowUser = $decode['post'];
							 ?>
							<div class="detailProduct">
								<div class=fUser style="text-transform: capitalize;"><?php echo $rowUser[0]['name'] ?></div>
								<input type="hidden" id="userId" value="<?php echo $userId?>">
									<?php
										$provinceId = $rowUser[0]['provinceId'];
										$city = $rowUser[0]['cityId'];
										$table = "provinces a INNER JOIN city b";
										$field = "a.name as provinceName, b.name";
										$where = "province_id =".$provinceId." and b.id=".$city;
										$on = "a.id = b.province_id";
										$db->select($table,$field,$on,$where);
										$hasil = $db->getResult();
										$decode = json_decode($hasil,true);
										//print_r($decode);
										$rowAddress = $decode['post'];
									 ?>
								<div class="fLocation"><i class="fa fa-map-marker" aria-hidden="true"></i>  <?php echo $rowAddress[0]['name']." - ".$rowAddress[0]['provinceName'] ?></div>
							</div>
					</div>
				</div>
        <div id="test">
        </div>
	<?php
		}else {
		}
      }else {
	?>
        <div class="rightBanner col-xs-12">
  				<div class="tabPanel">
  					<a href="seller/login.php">
  						<div class="productGrid">
  							<div class="imageProduct">
  								<img src="../images/myAds.jpg" class="img-responsive" alt="">
  							</div>
  							<div class="productSummary">
  								<div class="fTitle">Pasang Iklan Murah?</div>
  								<div class="fPrice">Disini Aja.!!!</div>
  							</div>
  						</div>
  					</a>
  						<div class="detailProduct">
  							<div class=fUser>Kiosaya.com</div>
  							<div class="fLocation"><i class="fa fa-map-marker" aria-hidden="true"></i>  Tangerang</div>
  						</div>
  				</div>
  			</div>

    <?php  }
  } else {?>
    <div class="rightBanner col-xs-12">
      <div class="tabPanel">
        <a href="seller/login.php">
          <div class="productGrid">
            <div class="imageProduct">
              <img src="../images/myAds.jpg" class="img-responsive" alt="">
            </div>
            <div class="productSummary">
              <div class="fTitle">Pasang Iklan Murah?</div>
              <div class="fPrice">Disini Aja.!!!</div>
            </div>
          </div>
        </a>
          <div class="detailProduct">
            <div class=fUser>Kiosaya.com</div>
            <div class="fLocation"><i class="fa fa-map-marker" aria-hidden="true"></i>  Tangerang</div>
          </div>
      </div>
    </div>
<div id="test">

</div>

  <?php }

}
?>
<div class="clearfix"></div>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    var time = $('input#time').val();
    var end = $('input#end').val();
    var today = $('input#today').val();
    var date = $('input#date').val()
    //alert(time+" "+end+" "+date);

    if(today != null && date != null){
      if (date <= today ) {
        //var userId = $('input#userId').val();
        //var adsId = $('input#adsId').val();
        //var showadsId = $('input#showadsId').val();
        $.ajax({
          type    : 'POST',
          url     : 'changeStatShow.php',
          data    :  "time="+time+"&today="+today,
          success : function (result){
            $("#test").html(result);
            //window.location.href ="index.php";
          }
        })
      }
    }
  });
</script>
