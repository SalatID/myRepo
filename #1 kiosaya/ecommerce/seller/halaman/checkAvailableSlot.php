<?php
    require_once '../../lib/config.php';
    $db = new configEcom();
    $value = $_POST['value'];
    $explode = explode(",",$value);
    $days = $explode[0];
    //echo $days."<br/>";
    $date = $explode[1];
    $adsId = $_POST['adsId'];
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
          <th rowspan="2" class = "centerAlign" style="vertical-align: middle;">Status</th>
    		</tr>
        <tr class="info">
          <th class = "centerAlign">Start</th>
          <th class = "centerAlign">End</th>
        </tr>
            <?php
            $table = 'time';
            $field = '*';
            $on ='';
            $where ='';
            $group ="";
            $order = "end asc";
            $db->select($table,$field,$on,$where,$group,$order);
            $hasil = $db->getResult();
            //echo $hasil;
            $decode = json_decode($hasil, true);
            //print_r($decode);
            $rowTime = $decode['post'];
             ?>
          <?php
          for ($i=0; $i < count($rowTime); $i++) {
            //echo $rowTime[$i]['id'].$adsId;
            $table = 'slot';
        		$field = 'timeId';
        		$on ='';
        		$where ='date = '."'".$date."'"." AND timeId =".$rowTime[$i]['id'];

            $db->select($table,$field,$on,$where);
            $hasil = $db->getResult();
            //echo $hasil;
            $decode = json_decode($hasil, true);
            //print_r($decode);
            $row = $decode['post'];
            //echo "timeID".$row[0]['timeId'];
            ?>
            <tr>
            <input type="hidden" id="adsId" value="<?php echo $adsId; ?>">
            <td class = "centerAlign"><?php echo ($i+1); ?></td>
            <td class = "centerAlign"><?php echo $date; ?><input type="hidden" id="date" value="<?php echo $date; ?>"></td>
            <td class = "centerAlign"><?php echo $days; ?><input type="hidden" id="days" value="<?php echo $days; ?>"></td>
            <td class = "centerAlign"><?php echo date('H:i',strtotime($rowTime[$i]['start'])); ?><input type="hidden" id="id"></td>
            <td class = "centerAlign"><?php echo date('H:i',strtotime($rowTime[$i]['end'])); ?></td>
            <?php
            $today = date('Y-m-d');
            $time = date('H:i:s');
            if (isset($row[0]) && $row[0]['timeId'] == $rowTime[$i]['id']) {?>
              <td class = "centerAlign"><a class="btn btn-danger" disabled>Booked</a></td>
            <?php
          }elseif ($today > $date) {?>
            <td class = "centerAlign"><a class="btn btn-warning" data-toggle="modal" data-id="<?php echo $rowTime[$i]['id']; ?>" disabled>Not Available</a></td>
          <?php
        }elseif ($today >= $date && date('H:i',strtotime($rowTime[$i]['start'])) < $time) {?>
            <td class = "centerAlign"><a class="btn btn-warning" data-toggle="modal" data-id="<?php echo $rowTime[$i]['id']; ?>" disabled>Not Available</a></td>
          <?php
          }else{?>
              <td class = "centerAlign"><a class="btn btn-info bookNow" data-toggle="modal" data-id="<?php echo $rowTime[$i]['id']; ?>">Book Now</a></td>
          <?php
        }
           ?>

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
              url		: 'halaman/addSlot.php',
              data	: 'timeId='+timeId+"&adsId="+adsId+"&days="+days+"&date="+date,
              success	: function(result){
                //alert(result);
                if (result==111) {
                  swal({
                    title: "Thank You",
                     text: "Your Slot Successfully Booked",
                      type: "success"
                    },
                    function(){
                      window.location.href ="index?modul=priorityAds";
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
