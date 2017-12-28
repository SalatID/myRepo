<link rel="stylesheet" href="css/own.css">
<link rel="stylesheet" href="css/style.css">
<link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/bootstrap-datepicker3.css">
<?php
  include_once 'lib/config.php';
  $db = new config();
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
    $rowSlot = $decode['post'];
    $date= isset($rowSlot[0]['date']) ? $rowSlot[0]['date'] : $today;
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
    if (isset($rowSlot[0])) {
		if ($today == $date) {
			//echo "hari sama";
			$minSec = date_create($end);
			date_add($minSec, date_interval_create_from_date_string('-1 seconds'));
			if($time > $start && $time <= date_format($minSec, 'H:i:s')){
				//echo "jam masih berlaku";
				$adsId=$rowSlot[0]['adsId'];
				//echo $adsId;
				$table = "ads";
				$field = "id,title, description, userId, redirectLink";
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
          <input type="hidden" class="adsId" value="<?php echo $rowAds[0]['id'] ?>">
          <input type="hidden" class="contractId" value="<?php echo $rowSlot[0]['contractId'] ?>">
					<input type="hidden" id="showadsId" value="<?php echo $row[0]['showadsId']?>">
					<?php echo $rowAds[0]['redirectLink'];//$time ?>
							<a class="adsPlacement" href="#">
									<div class="imageProduct">
										<img class="img-responsive" src="images/<?php echo $rowImg[0]['location'] ?>" class="img-responsive" alt="">
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
  						<div class="imageProduct">
  							<img src="images/myAds.jpg" class="img-responsive" alt="">
  						</div>
  					</a>
  				</div>
  			</div>

    <?php  }
  } else {?>
    <div class="rightBanner col-xs-12">
      <div class="tabPanel">
        <a href="seller/login.php">
            <div class="imageProduct">
              <img src="images/myAds.jpg" class="img-responsive" alt="">
          </div>
        </a>
      </div>
    </div>
<div id="test">

</div>

  <?php }

}
if (isset($rowAds[0])) {
  $redirectLink = is_numeric($rowAds[0]['redirectLink'])?'frontstore/index.php?fstore=detail_ads&rowId='.$rowAds[0]['redirectLink'] : $rowAds[0]['redirectLink'];
}else {
  $redirectLink = 'seller/login';
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

    $('.adsPlacement').click(function(){
      var adsId = $('.adsId').val();
      var contractId = $('.contractId').val();
      $.ajax({
        type    : 'POST',
        url     : 'countClick.php',
        data    :  "adsId="+adsId+"&contractId="+contractId,
        success : function (result){
          //alert(result);
          //$("#test").html(result);
          window.location.href ="<?php echo $redirectLink ?>";
        }
      })
    });
  });
</script>
