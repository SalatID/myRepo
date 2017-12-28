<?php
    include '../ecommerce/lib/config.php';
    $dbe = new configEcom();
    $db = new config();
    $today = date('ymd');
    $table = "contract";
  	$field = "max(id) as contractNumber";
  	$where = "id like '".$today."%'";
  	$on = "";
  	$db->select($table,$field,$on,$where);
  	$result = $db->getResult();
  	$decode = json_decode($result, true);
    //print_r($decode);
  	$maxCtrNumber = isset($decode['post'][0]) ? $decode['post'][0]['contractNumber'] : 0;
  	$substring = substr($maxCtrNumber,6,4);
  	$substring++;
    $ctrNumber = $today.sprintf('%04s',$substring);
    //echo $ctrNumber;
    $today = date('Y-m-d');
?>
    <div class="table-responsive">
		<table style="width: 100%; border : 0">
			<tr>
				<td style="text-align : left; font-size:20px;">Contract Date : <?php echo $today;?></td>
				<td style="text-align : right; font-size:20px;">Contract Number : <?php echo $ctrNumber;?></td>
				<input type="hidden" id="ctrNumber" value="<?php echo $ctrNumber;?>">
			</tr>
		</table></br>
		<div class='input-group' >
			<label for="">Add an ads :</label>
			<div class="dropdown">
				<a class="dropdown-toggle btn btn-info" data-toggle="dropdown" style="text-transform: capitalize;" href=#>
					<i class="fa fa-plus-circle"></i>
					Add Ads
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
					<li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" class="addAds" data-id="newAds" data-target="#newAds" href="#">New Ads</a></li>
					<li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" class="addAds" data-id="recentAds" data-target="#addFrmRecent"href="#">Select From My Ads</a></li>
					<li role="presentation"><a role="menuitem" tabindex="-1" href="#" data-toggle="modal" class="addAds" data-id="catalog" data-target="#addFrmCatalogue">Select From Catalog</a></li>
				</ul>
			</div>
		</div></br>
        <table class="table table-responsive table-bordered table-striped" id="tableSlot" >
			<tr class="info">
				<th class = "centerAlign" style="vertical-align: middle; width : 1px">No</th>
				<th class = "centerAlign" style="vertical-align: middle; width : 200px">Ads Name</th>
				<th class = "centerAlign" style="vertical-align: middle; width : 150px">Category</th>
				<th class = "centerAlign" style="vertical-align: middle; width : 150px">Sub Category</th>
				<th class = "centerAlign" style="vertical-align: middle; width : 200px">Redirect Link</th>
				<th class = "centerAlign" style="vertical-align: middle;">Selected Slot</th>
        <th class = "centerAlign" style="vertical-align: middle; width : 50px;" >Action</th>
			</tr>
			<?php

        //print_r($_SESSION['slot']);
        $arrayAds = array();
        $arrayCatalogue = array();
        $sessionContract = isset($_SESSION['contract']) ? $_SESSION['contract'] : 0;
				//print_r($sessionContract);
				if($sessionContract==0 || !isset($sessionContract) || count($sessionContract)==0){
					$arrayAds [0]['userId']= $userId;
					$arrayCatalogue [0]['userId']= $userId;
             ?>
             <tr>
                <td class = "centerAlign" colspan="8" ><h1>You Have Not Added Any Ads</h1></td>
             </tr>
             </table>
			<?php  }else {
				$rowAds = $_SESSION['contract'];
				//print_r($rowAds);
				$i=1;
				foreach ($rowAds as $keyAds => $valueAds) {
					$redirectLink = isset($valueAds['redirectLink']) ? $valueAds['redirectLink'] : $valueAds['catalogueId'];
			?>
			<tr>
        <?php
					if (isset($valueAds['adsId'])) {
						$arrayAds [$i]['adsId']= $valueAds['adsId'];
						$arrayAds [$i]['userId']= $userId;
						$arrayAds [$i]['config']= 'config';
					}elseif (!isset($valueAds['adsId'])) {
						$arrayAds [0]['userId']= $userId;
					}
          //print_r($arrayAds);
					if(isset($valueAds['catalogueId'])) {
						$arrayCatalogue [$i]['catalogueId']= $valueAds['catalogueId'];
						$arrayCatalogue [$i]['userId']= $userId;
						$arrayCatalogue [$i]['config']= 'configEcom';
					}elseif(!isset($valueAds['catalogueId'])) {
						$arrayCatalogue [0]['userId']= $userId;
					}
				?>
				<input type="hidden" class="menu" data-id="<?php echo $valueAds['menu'];?>">
				<td> <?php echo $i;?></td>
				<td><input type="hidden" name="title" value="<?php echo $valueAds['title'];?>"> <?php echo $valueAds['title'];?></td>
				<td>
          <input type="hidden" name="categoryId" value="<?php echo $valueAds['categoryId'];?>">
          <?php
          $table = "category";
        	$field = "name";
        	$where = "id=".$valueAds['categoryId'];
        	$on = "";
        	$db->select($table,$field,$on,$where);
        	$result = $db->getResult();
        	$decode = json_decode($result, true);
          //print_r($decode);
          $rowCategory = $decode['post'];
          echo $rowCategory[0]['name'];
          ?>
        </td>
				<td>
          <input type="hidden" name="subCategoryId" value="<?php echo $valueAds['subCategoryId'];?>">
          <?php
          $table = "subcategory";
        	$field = "name";
        	$where = "id=".$valueAds['subCategoryId'];
        	$on = "";
        	$db->select($table,$field,$on,$where);
        	$result = $db->getResult();
        	$decode = json_decode($result, true);
          //print_r($decode);
          $rowSubCategory = $decode['post'];
          echo $rowSubCategory[0]['name'];
          ?>
        </td>
				<td>
          <input type="hidden" name="redirectLink" value="<?php echo $redirectLink ?>">
          <a href="<?php echo !is_numeric($redirectLink) ? $redirectLink : '../ecommerce/frontstore/index.php?fstore=detail_ads&rowid='.$redirectLink; ?>" style="color : black" target="_blank"><?php echo !is_numeric($redirectLink) ? $redirectLink : 'index.php?fstore=detail_ads&rowid='.$redirectLink; ?></a>
        </td>
        <td style="width:21%">
            <?php
              if (isset($valueAds['catalogueId'])) {
                $adsId = $valueAds['catalogueId'];
              } elseif (isset($valueAds['adsId'])) {
                $adsId = $valueAds['adsId'];
              } elseif (isset($valueAds['newAdsid'])) {
                $adsId = $valueAds['newAdsid'];
              }
              if (isset($_SESSION['slot'])) {
                $totalPayment = array();
                $x=1;
                foreach ($_SESSION['slot'] as $keySlot => $valueSlot) {
                  if ($valueSlot['adsId']==$adsId) {
                    $table = 'time';
                    $field = "id,start,end";
            				$where = "id=".$valueSlot['timeId'];
            				$on = "";
            				$db->select($table,$field,$on,$where);
            				$result = $db->getResult();
            				$decode = json_decode($result, true);
                    //print_r($decode);
                    $rowTime = $decode['post'];
                    ?>
                    <?php
                    if (isset($_GET['key'])) {
                      $getKey = base64_decode($_GET['key']);
                      $decodeError = json_decode($getKey, true);
                      //print_r($decodeError);
                      foreach ($decodeError as $keyDecode => $valueDecode) {
                        if (isset($_GET['error']) && isset($getKey) && $valueDecode== $keySlot) { ?>
                            <b><?php echo $x.". ".$valueSlot['days'].", ".$valueSlot['date']; ?></b><a href="#" class="deleteFrmSession" data-id="<?php echo $keySlot ?>" style="color:black; float: right;"><i class='fa fa-times' aria-hidden='true'></i></a></br>
                            &nbsp&nbsp&nbsp&nbsp<?php echo $rowTime[0]['start']." s.d ".$rowTime[0]['end']?></br>
                            <div class="alert alert-warning alert-dismissible" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                              <strong>Warning!</strong> <?=base64_decode($_GET['error']);?>
                            </div></br>
                        <?php
                        $x++;
                      }
                      }
                      //print_r($decode);
                    }else{
                      ?>
                        <b><?php echo $x.". ".$valueSlot['days'].", ".$valueSlot['date']; ?></b><a href="#" class="deleteFrmSession" data-id="<?php echo $keySlot ?>" style="color:black; float: right;"><i class='fa fa-times' aria-hidden='true'></i></a></br>
                        &nbsp&nbsp&nbsp&nbsp<?php echo $rowTime[0]['start']." s.d ".$rowTime[0]['end']?></br>
                        <div style="text-align : left">
                            <i><b><?php echo 'Rp '.number_format($valueSlot['price'])?></b></i></br></br>
                        </div>
                      <?php
                      $x++;
                    }

                  }
                  $totalPayment [$keySlot] = $valueSlot['price'];
                }
                //print_r($totalPayment);
              }
             ?>
        </td>
				<td style="padding-left: 15px;">
          <a href="index.php?modul=slotAvailable&adsId=<?php echo $adsId ?>" class="btn btn-info" style="margin-left:auto; margin-right:auto; margin-top: 10px; width: 95px;">Select Slot</a>
          <input type="hidden" class="adsId" value="<?php echo $adsId ?>">
          <a href="#" class="btn btn-danger deleteFrmSession" style="margin-left:auto; margin-right:auto;  margin-top: 10px; width: 95px;" value="<?php echo $adsId ?> " data-id="[<?php echo is_numeric($valueAds['images']) ? $keyAds.', '.$adsId.', '.$valueAds['images'] : $keyAds.', '.$adsId ?>]">Delete</a>
        </td>
            </tr>

          <?php $i++;
				} $totalPayment = isset($totalPayment)?$totalPayment:[0]?>
        <tr>
          <td colspan="5"><h4>Value Added Tax (VAT) : </h4></td>
          <td colspan="2" style="text-align : right;"><h4> <?php $PPN = array_sum($totalPayment)*10/100; echo 'Rp '.number_format($PPN); ?></h4></td>
        </tr>
        <tr>
          <td colspan="5"><h1>Total Payment : </h1></td>
          <td colspan="2" style="text-align : right;"><h2> <?php $amount = array_sum($totalPayment)+$PPN; echo 'Rp '.number_format($amount); ?></h2></td>
        </tr>
        </table>
        <form class="" action="halaman/payments.php" method="post">
          <input type="hidden" name="amount" value="<?php echo ($amount*0.000074) ?>">
          <input type="hidden" name="ctrId" value="<?php echo $ctrNumber ?>">
          <input type="hidden" name="cmd" value="_xclick" />
      		<input type="hidden" name="no_note" value="1" />
      		<input type="hidden" name="lc" value="UK" />
      		<input type="hidden" name="currency_code" value="USD" />
      		<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
      		<input type="hidden" name="first_name" value="Customer's First Name"  />
      		<input type="hidden" name="last_name" value="Customer's Last Name"  />
      		<input type="hidden" name="payer_email" value="seller@kiosaya.com"  />
      		<input type="hidden" name="item_number" value="<?php echo $ctrNumber ?>" / >
      		<input type="submit" class="btn btn-info"name="submit" value="Create Contract"/>
          <a href="halaman/deleteFrmSession.php" class="btn btn-danger">Reset</a>
        </form>
		<?php	}

           ?>



        <!--<a href="halaman/addContract.php" class="btn btn-info">Create Contract</a>-->

        <!--Modal View Ads start here-->
    		<div id="newAds" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<!-- konten modal-->
					<div class="modal-content">
						<!-- heading modal -->
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">New Ads</h4>
						</div>
						<!-- body modal -->
						<div class="modal-body">
							<?php include 'halaman/newAdsCtr.php' ?>
						</div>
					</div>
				</div>
    		</div>

        <!--Modal View Ads start here-->
    		<div id="addFrmRecent" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<!-- konten modal-->
					<div class="modal-content">
					<!-- heading modal -->
					<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Select From My Ads</h4>
						</div>
						<!-- body modal -->
						<div class="modal-body">
							<?php include 'halaman/selectFromRecentAds.php' ?>
						</div>
					</div>
				</div>
    		</div>
    </div>

        <!--Modal View Ads start here-->
    		<div id="addFrmCatalogue" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<!-- konten modal-->
					<div class="modal-content">
					<!-- heading modal -->
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Select From Catalogue</h4>
						</div>
						<!-- body modal -->
						<div class="modal-body">
							<?php include 'halaman/selectFromCatalog.php' ?>
						</div>
					</div>
				</div>
    		</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('.deleteFrmSession').click(function(){
      var idSessionContract = $(this).data('id');
      //var adsid1= $(this).val();
      var attr = $(this).text();
      //alert(attr);
      $.ajax({
        type	: 'POST',
				url		: 'halaman/deleteFrmSession.php',
				data	: 'idSessionContract='+idSessionContract+"&attr="+attr,
				success	: function(result){
          //alert(result);
          window.location.href ="index?modul=newContract";
				}
      })
    });
  });
</script>
