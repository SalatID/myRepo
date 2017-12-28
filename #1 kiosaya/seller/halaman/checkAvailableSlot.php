<?php
    require_once '../../lib/config.php';
    session_start();
    $db = new config();
    $datePicker= $_POST['datePicker'];
    $explode = explode(",",$datePicker);
    $days = $explode[0];
    //echo $days."<br/>";
    $date = $explode[1];
    $adsId = $_POST['adsId'];
    //print_r($_SESSION['slot'])
    //echo "$adsId";
    //echo $date."<br/>";
    //$month = 1;
    //echo 'ini'.$month;
    ?>
      <table class="table table-responsive table-bordered table-striped" id="tableSlot" >
        <tr class="info">
  				<th rowspan="2" class = "centerAlign" style="vertical-align: middle;">No</th>
    			<th rowspan="2" class = "centerAlign" style="vertical-align: middle;">Date</th>
    			<th rowspan="2" class = "centerAlign" style="vertical-align: middle;">Days</th>
    			<th colspan="2" class = "centerAlign">Time</th>
          <th rowspan="2" class = "centerAlign" style="vertical-align: middle;">Price</th>
          <th rowspan="2" class = "centerAlign" style="vertical-align: middle;">Status</th>
    		</tr>
        <tr class="info">
          <th class = "centerAlign">Start</th>
          <th class = "centerAlign">End</th>
        </tr>
            <?php
            $bookedSlot = null;
            if (isset($_SESSION['slot'])) {
              foreach ($_SESSION['slot'] as $keySlot => $valueSlot) {
                if ($bookedSlot==null) {
                  $bookedSlot = $valueSlot['timeId'];
                }else {
                  $bookedSlot .= ','.$valueSlot['timeId'];
                }
              }
            }

            //print_r($bookedSlot);
            $table = 'time';
            $field = '*';
            $on ='';
            $where ='';
            $group ="";
            $order = "end asc";
            $db->select($table,$field,$on,$where,$group,$order);
            $result = $db->getResult();
            //echo $result;
            $decode = json_decode($result, true);
            //print_r($decode);
            $rowTime = $decode['post'];
             ?>
          <?php
          for ($i=0; $i < count($rowTime); $i++) {
            //echo $rowTime[$i]['id'].$adsId;

            $table = 'slot';
        		$field = 'timeId,date,days';
        		$on ='';
        		$where ='date = '."'".$date."'"." AND timeId =".$rowTime[$i]['id'];

            $db->select($table,$field,$on,$where);
            $result = $db->getResult();
            //echo $result;
            $decode = json_decode($result, true);
            //print_r($decode);
            $rowSlot = $decode['post'];
            //echo "timeID".$rowSlot[0]['timeId'];

            ?>
            <tr>
            <input type="hidden" id="adsId" value="<?php echo $adsId; ?>">
            <td class = "centerAlign"><?php echo ($i+1); ?></td>
            <td class = "centerAlign"><?php echo $date; ?><input type="hidden" id="date" value="<?php echo $date; ?>"></td>
            <td class = "centerAlign"><?php echo $days; ?><input type="hidden" id="days" value="<?php echo $days; ?>"></td>
            <td class = "centerAlign"><?php echo date('H:i',strtotime($rowTime[$i]['start'])); ?><input type="hidden" id="id"></td>
            <td class = "centerAlign"><?php echo date('H:i',strtotime($rowTime[$i]['end'])); ?></td>
            <?php
              $table = 'slotprice';
              $field = '*';
              $on ='';
                if ($days == 'Monday'|| $days == 'Tuesday'|| $days == 'Wednesday'|| $days == 'Thursday' || $days == 'Friday' ) {
                  $daysCode = 'WD';
                  if (date('H:i',strtotime($rowTime[$i]['start'])) >= '04:00' && date('H:i',strtotime($rowTime[$i]['start'])) < '09:00') {
                    $priceCode = 'A-'.$daysCode;
                    $where ='pricingCode = "'.$priceCode.'"';
                    $db->select($table,$field,$on,$where);
                    $result = $db->getResult();
                    $decode = json_decode($result, true);
                    $rowPrice = $decode['post'];
                    foreach ($rowPrice as $keyPrice => $valuePrice) {?>
                    <td style="text-align : right;"><?php echo "Rp ".number_format($valuePrice['price']); ?></td>
                  <?php
                    }
                  }elseif (date('H:i',strtotime($rowTime[$i]['start'])) >= '09:00' && date('H:i',strtotime($rowTime[$i]['start'])) < '15:00'){
                    $priceCode = 'B-'.$daysCode;
                    $where ='pricingCode = "'.$priceCode.'"';
                    $db->select($table,$field,$on,$where);
                    $result = $db->getResult();
                    $decode = json_decode($result, true);
                    $rowPrice = $decode['post'];
                    foreach ($rowPrice as $keyPrice => $valuePrice) {?>
                    <td style="text-align : right;"><?php echo "Rp ".number_format($valuePrice['price']); ?></td>
                  <?php
                    }
                  }elseif (date('H:i',strtotime($rowTime[$i]['start'])) >= '15:00' && date('H:i',strtotime($rowTime[$i]['start'])) < '18:00'){
                    $priceCode = 'C-'.$daysCode;
                    $where ='pricingCode = "'.$priceCode.'"';
                    $db->select($table,$field,$on,$where);
                    $result = $db->getResult();
                    $decode = json_decode($result, true);
                    $rowPrice = $decode['post'];
                    foreach ($rowPrice as $keyPrice => $valuePrice) {?>
                    <td style="text-align : right;"><?php echo "Rp ".number_format($valuePrice['price']); ?></td>
                  <?php
                    }
                  }elseif (date('H:i',strtotime($rowTime[$i]['start'])) >= '18:00' && date('H:i',strtotime($rowTime[$i]['start'])) < '23:59'){
                    $priceCode = 'D-'.$daysCode;
                    $where ='pricingCode = "'.$priceCode.'"';
                    $db->select($table,$field,$on,$where);
                    $result = $db->getResult();
                    $decode = json_decode($result, true);
                    $rowPrice = $decode['post'];
                    foreach ($rowPrice as $keyPrice => $valuePrice) {?>
                    <td style="text-align : right;"><?php echo "Rp ".number_format($valuePrice['price']); ?></td>
                  <?php
                    }
                  }elseif (date('H:i',strtotime($rowTime[$i]['start'])) >= '00:00' && date('H:i',strtotime($rowTime[$i]['start'])) < '04:00'){
                    $priceCode = 'E-'.$daysCode;
                    $where ='pricingCode = "'.$priceCode.'"';
                    $db->select($table,$field,$on,$where);
                    $result = $db->getResult();
                    $decode = json_decode($result, true);
                    $rowPrice = $decode['post'];
                    foreach ($rowPrice as $keyPrice => $valuePrice) {?>
                    <td style="text-align : right;"><?php echo "Rp ".number_format($valuePrice['price']); ?></td>
                  <?php
                    }
                  }
                } elseif ($days == 'Saturday'|| $days == 'Sunday') {
                  $daysCode = 'WE';
                  if (date('H:i',strtotime($rowTime[$i]['start'])) >= '04:00' && date('H:i',strtotime($rowTime[$i]['start'])) < '09:00') {
                    $priceCode = 'A-'.$daysCode;
                    $where ='pricingCode = "'.$priceCode.'"';
                    $db->select($table,$field,$on,$where);
                    $result = $db->getResult();
                    $decode = json_decode($result, true);
                    $rowPrice = $decode['post'];
                    foreach ($rowPrice as $keyPrice => $valuePrice) {?>
                    <td style="text-align : right;"><?php echo "Rp ".number_format($valuePrice['price']); ?></td>
                  <?php
                    }
                  }elseif (date('H:i',strtotime($rowTime[$i]['start'])) >= '09:00' && date('H:i',strtotime($rowTime[$i]['start'])) < '15:00'){
                    $priceCode = 'B-'.$daysCode;
                    $where ='pricingCode = "'.$priceCode.'"';
                    $db->select($table,$field,$on,$where);
                    $result = $db->getResult();
                    $decode = json_decode($result, true);
                    $rowPrice = $decode['post'];
                    foreach ($rowPrice as $keyPrice => $valuePrice) {?>
                    <td style="text-align : right;"><?php echo "Rp ".number_format($valuePrice['price']); ?></td>
                  <?php
                    }
                  }elseif (date('H:i',strtotime($rowTime[$i]['start'])) >= '15:00' && date('H:i',strtotime($rowTime[$i]['start'])) < '18:00'){
                    $priceCode = 'C-'.$daysCode;
                    $where ='pricingCode = "'.$priceCode.'"';
                    $db->select($table,$field,$on,$where);
                    $result = $db->getResult();
                    $decode = json_decode($result, true);
                    $rowPrice = $decode['post'];
                    foreach ($rowPrice as $keyPrice => $valuePrice) {?>
                    <td style="text-align : right;"><?php echo "Rp ".number_format($valuePrice['price']); ?></td>
                  <?php
                    }
                  }elseif (date('H:i',strtotime($rowTime[$i]['start'])) >= '18:00' && date('H:i',strtotime($rowTime[$i]['start'])) < '23:59'){
                    $priceCode = 'D-'.$daysCode;
                    $where ='pricingCode = "'.$priceCode.'"';
                    $db->select($table,$field,$on,$where);
                    $result = $db->getResult();
                    $decode = json_decode($result, true);
                    $rowPrice = $decode['post'];
                    foreach ($rowPrice as $keyPrice => $valuePrice) {?>
                    <td style="text-align : right;"><?php echo "Rp ".number_format($valuePrice['price']); ?></td>
                  <?php
                    }
                  }elseif (date('H:i',strtotime($rowTime[$i]['start'])) >= '00:00' && date('H:i',strtotime($rowTime[$i]['start'])) < '04:00'){
                    $priceCode = 'E-'.$daysCode;
                    $where ='pricingCode = "'.$priceCode.'"';
                    $db->select($table,$field,$on,$where);
                    $result = $db->getResult();
                    $decode = json_decode($result, true);
                    $rowPrice = $decode['post'];
                    foreach ($rowPrice as $keyPrice => $valuePrice) {?>
                    <td style="text-align : right;"><?php echo "Rp ".number_format($valuePrice['price']); ?></td>
                  <?php
                    }
                  }
              }
             ?>
            <?php
            $today = date('Y-m-d');
            $time = date('H:i:s');
            $timeId=null;
            if(isset($_SESSION['slot'])){
              foreach ($_SESSION['slot'] as $keySlot => $valueSlot) {
                if ($valueSlot['timeId']==$rowTime[$i]['id'] && $valueSlot['date']==$date) {?>
                  <td class = "centerAlign"><a class="btn btn-danger" disabled>Booked</a></td>
              <?php
                  $timeId = $valueSlot['timeId'];
                }
              }
            }
            if (isset($rowSlot[0]) && $rowSlot[0]['timeId'] == $rowTime[$i]['id']) {?>
              <td class = "centerAlign"><a class="btn btn-danger" disabled>Booked</a></td>
            <?php
            }elseif ($today > $date && !isset($timeId)) {?>
              <td class = "centerAlign"><a class="btn btn-warning" data-toggle="modal" data-id="<?php echo $rowTime[$i]['id']; ?>" disabled>Not Available</a></td>
            <?php
            }elseif ($today >= $date && date('H:i',strtotime($rowTime[$i]['start'])) < $time && !isset($timeId)) {?>
                  <td class = "centerAlign"><a class="btn btn-warning" data-toggle="modal" data-id="<?php echo $rowTime[$i]['id']; ?>" disabled>Not Available</a></td>
            <?php
            }elseif (!isset($timeId)) {
              ?>
                <td class = "centerAlign"><a class="btn btn-info bookNow" data-toggle="modal" data-id="<?php echo $rowTime[$i]['id'].",".$priceCode; ?>">Book Now</a></td>
            <?php
            }  ?>

            </tr>
          <?php
          }
          ?>

      </table>
      <script src="../js/jquery.min.js"></script>
      <script src="../js/jquery-3.2.1.min.js"></script>
      <script src="../js/bootstrap-datepicker.js"></script>
      <script src="../js/sweetalert.js"></script>
      <script type="text/javascript">
      	$(document).ready(function() {
          $('.bookNow').click(function(){
            var timeId = $(this).data('id');
            var days = $('input#days').val();
            var date =$('input#date').val();
            var adsId =$('input#adsId').val();
            //alert(timeId);
            swal({
            title: "Are you sure?",
            text: "Your will book this slot.",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, book now!",
            closeOnConfirm: false
          },
          function(){
            $.ajax({
              type	: 'POST',
              url		: 'halaman/addSessionSlot.php',
              data	: 'timeId='+timeId+"&adsId="+adsId+"&days="+days+"&date="+date,
              success	: function(result){
                //alert(result);
                if (result!=null) {
                  swal({
                    title: "Thank You",
                     text: "Your Slot Successfully Booked",
                      type: "success"
                    },
                    function(){
                      var datePicker = $('#datetimepicker').val();
                			var adsId = $('#adsId').val();
                      $.ajax({
                				type	: 'POST',
                				url		: 'halaman/checkAvailableSlot.php',
                				data	: 'datePicker='+datePicker+"&adsId="+adsId,
                				success	: function(result){
                					$("#tableSlot").html(result);
                				}
                			})
                  });
                }else {
                  swal({
                    title: "Sorry",
                     text: "Your slot failed to booked",
                      type: "error"
                    },
                    function(){
                      window.location.href ="index?modul=priorityAds";
                  });
                }
              }
            })
          });
          });
      		});
      </script>
