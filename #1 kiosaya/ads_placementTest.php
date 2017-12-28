<?php
  session_start();
  include_once 'lib/config.php';
  $db = new config();
  $today=date('Y-m-d');
  $time = date('H:i:s');
  echo $time;
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
  for($i=0;$i<count($rowTime);$i++){?>
    <?php
    $timeId = $rowTime[$i]['id'];
    //echo 'ini time id'.$timeId;
    $table = "slot a INNER JOIN showads b";
    $field = "a.*, b.*";
    $where = "timeId =".$timeId;
    $on = "a.id=b.slotId";
    $db->select($table,$field,$on,$where);
    $hasil = $db->getResult();
    $decode = json_decode($hasil,true);
    //print_r($decode);
    $row = $decode['post'];
    $date= isset($row[0]['date']) ? $row[0]['date'] : $today;
    echo $date;
    $start = $rowTime[$i]['start'];
    $end = $rowTime[$i]['end'];
    //echo $start;
    //echo $end;
    //echo $time;
    if (isset($row[0])) {
      if ($today == $date) {
        //echo "hari sama";
        if($time > $start && $time <= $end){
          //echo "jam masih berlaku";
          $adsId=$row[0]['adsId'];
          $table = "ads";
          $field = "id,title, description";
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
         <img src="images/<?php echo $rowImg[0]['location'] ?>" class="img-responsive" alt=""></br>
           <a href="#" style="color: black;"><?php echo $rowAds[0]['title']; ?></a></br>
           <?php
             $table = "productprice";
             $field = "price";
             $where = "adsId=".$rowAds[0]['id'];
             $on = "";
             $db->select($table,$field,$on,$where);
             $hasil = $db->getResult();
             $decode = json_decode($hasil,true);
             //print_r($decode);
             $rowPrice = $decode['post'];
            ?>
           <a href="#" style="color: black;"><?php echo "Rp ".number_format($rowPrice[0]['price']); ?></a></br>
  <?php      }else {?>
      <h1>Tidak Ada Iklan pada Jam <?php echo $start;?> sampai <?php echo $end;?></h1>
          <?php
        }
      }else {?>
        <h1>Tidak Ada Iklan Pada Tanggal <?php echo $today;?></h1>
    <?php  }
  } else {?>
    <h1>Tidak Ada Iklan pada Tanggal <?php echo $today;?> Pukul <?php echo $start;?> sampai <?php echo $end;?></h1>
  <?php }

}
?>
