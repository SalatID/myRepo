<?php
  include '../../lib/config.php';
  $db = new config();
    if (isset($_POST['ctrId'])) { ?>
      <?php
      $ctrId = $_POST['ctrId'];
      $table = 'ads';
      $field = 'id, title';
      $on = '';
      $where = 'contractId='.$ctrId;
      $group ='';
      $order ='';
      $db->select($table,$field,$on,$where);
      $result = $db->getResult();
      $decode = json_decode($result,true);
      $rowAds = $decode['post'];
      //print_r($decode);
      $rowAds = $decode['post'];
      //print_r ($decode);
      $arrayAds = array();
      $totalClick = array();
      $i=0;
      foreach ($rowAds as $keyAds => $valueAds) {
        $arrayAds[$i]['id'] = $valueAds['id'];
        $arrayAds[$i]['title'] = $valueAds['title'];
        $table = 'countclick';
        $field = 'id';
        $on = '';
        $where = 'adsId='.$valueAds['id'];
        $group ='';
        $order ='';
        $db->select($table,$field,$on,$where);
        $result = $db->getResult();
        $decode = json_decode($result,true);
        $rowCountClick = $decode['post'];
        //print_r($decode);
        //echo count($rowCountClick).'</br>';
        $totalClick [$i]['adsId'] = $valueAds['id'];
        $totalClick [$i]['totalClick'] = count($rowCountClick);
        $i++;
      }
      //print_r($totalClick);
      ?>
      <div class="container">
        <canvas id="myChart" ></canvas>
      </div>
      <script>
         var ctx = document.getElementById("myChart");
         var myChart = new Chart(ctx, {
             type: 'bar',
             data: {
                 labels: [<?php foreach ($arrayAds as $keyAds => $valueAds) {echo '"' . $valueAds['title'] . '",';} ?>],
                 datasets: [{
                         label: '# of Votes',
                         data: [<?php foreach ($totalClick as $keyClick => $valueClick) {echo '"' . $valueClick['totalClick'] . '",';} ?>],
                         backgroundColor: [
                             'rgba(255, 99, 132, 0.2)',
                             'rgba(54, 162, 235, 0.2)',
                             'rgba(255, 206, 86, 0.2)',
                             'rgba(75, 192, 192, 0.2)',
                             'rgba(153, 102, 255, 0.2)',
                             'rgba(255, 159, 64, 0.2)'
                         ],
                         borderColor: [
                             'rgba(255,99,132,1)',
                             'rgba(54, 162, 235, 1)',
                             'rgba(255, 206, 86, 1)',
                             'rgba(75, 192, 192, 1)',
                             'rgba(153, 102, 255, 1)',
                             'rgba(255, 159, 64, 1)'
                         ],
                         borderWidth: 1
                     }]
             },
             options: {
                 scales: {
                     yAxes: [{
                             ticks: {
                                 beginAtZero: true
                             }
                         }]
                 }
             }
         });
     </script>
  <?php  } elseif (isset($_POST['monthId']) && is_numeric($_POST['monthId'])) {
    $adsId = $_POST['adsId'];
    $ctrId = $_POST['contractId'];
    $calendar = CAL_GREGORIAN;
    $monthId = $_POST['monthId'];
    //echo $monthId;
    $year = date('Y');
      $totalDays = cal_days_in_month($calendar,$monthId,$year);
    //echo $totalDays;
    $now = strtotime(date('Y-m'.'-1'));
    $dateCreate = date_create($year.'-'.$monthId.'-1');
    $now = date_format($dateCreate, "d");

      ?>
          <div class="container">
              <canvas id="myChart" ></canvas>
          </div>
      <?php
      $table = 'ads';
      $field = 'id, title';
      $on = '';
      $where = 'id='.$adsId;
      $group ='';
      $order ='';
      $db->select($table,$field,$on,$where);
      $result = $db->getResult();
      $decode = json_decode($result,true);
      $rowAds = $decode['post'];
      //print_r($decode);
      $rowAds = $decode['post'];
      //print_r ($decode);
      $totalClick = array();
      $arrayDate = array();
      $i=0;

      for ($i=0; $i < $totalDays; $i++) {
        $date = date_format($dateCreate, "Y").'-'.date_format($dateCreate, "m").'-'.sprintf('%02s',(date_format($dateCreate, "d")+$i));;
        $arrayDate[$i]['adsId'] = $adsId;
        $arrayDate[$i]['date'] = $date;

        $table = 'countclick';
        $field = 'substring(date,-19,10) as date';
        $on = '';
        $where = 'adsId='.$rowAds[0]['id'].' and substring(date,-19,10)='.'"'.$date.'"';
        $group ='';
        $order ='';
        $db->select($table,$field,$on,$where,$group);
        $result = $db->getResult();
        $decode = json_decode($result,true);
        //print_r($decode);
        $rowCountClick = $decode['post'];
        //echo count($rowCountClick);
        $totalClick[$i]['date'] = $date;
        $totalClick[$i]['click'] = count($rowCountClick);
      }

      //print_r($arrayDate);die;
    //print_r($arrayDate);
    ?>
    <input type="hidden" class="idCtr" value="<?php echo $ctrId ?>">
    <script>
       var ctx = document.getElementById("myChart");
       var myChart = new Chart(ctx, {
           type: 'line',
           data: {
               labels: [<?php foreach ($arrayDate as $keyArrayDate => $valueArrayDate) {echo '"' . $valueArrayDate['date'] . '",';} ?>],
               datasets: [{
                       label: '# of Votes',
                       data: [<?php foreach ($totalClick as $keyClick => $valueClick) {echo '"' . $valueClick['click'] . '",';} ?>],
                       borderWidth: 1,
                       pointBackgroundColor: 'rgba(255,0,4,1)'
                   }]
           },
           options: {
               scales: {
                   yAxes: [{
                           ticks: {
                               beginAtZero: true
                           }
                       }]
               }
           }
       });
   </script>
 <?php  } elseif ($_POST['adsId'] || !is_numeric($_POST['monthId'])) {
   $adsId = $_POST['adsId'];
   $ctrId = $_POST['contractId'];
   $now = strtotime(date('Y-m-d'));
   ?>
       <div class="container">
           <canvas id="myChart" ></canvas>
       </div>
   <?php
   $table = 'ads';
   $field = 'id, title';
   $on = '';
   $where = 'id='.$adsId;
   $group ='';
   $order ='';
   $db->select($table,$field,$on,$where);
   $result = $db->getResult();
   $decode = json_decode($result,true);
   $rowAds = $decode['post'];
   //print_r($decode);
   $rowAds = $decode['post'];
   //print_r ($decode);
   $totalClick = array();
   $arrayDate = array();
   $i=0;

   for ($i=0; $i <= 7; $i++) {
     $date = date('Y-m-d', strtotime("-$i day", $now));
     $arrayDate[$i]['adsId'] = $adsId;
     $arrayDate[$i]['date'] = $date;

     $table = 'countclick';
     $field = 'substring(date,-19,10) as date';
     $on = '';
     $where = 'adsId='.$rowAds[0]['id'].' and substring(date,-19,10)='.'"'.$date.'"';
     $group ='';
     $order ='';
     $db->select($table,$field,$on,$where,$group);
     $result = $db->getResult();
     $decode = json_decode($result,true);
     //print_r($decode);
     $rowCountClick = $decode['post'];
     //echo count($rowCountClick);
     $totalClick[$i]['date'] = $date;
     $totalClick[$i]['click'] = count($rowCountClick);
   }

   //print_r($arrayDate);die;
 //print_r($arrayDate);
 ?>
 <input type="hidden" class="idCtr" value="<?php echo $ctrId ?>">
 <script>
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [<?php foreach ($arrayDate as $keyArrayDate => $valueArrayDate) {echo '"' . $valueArrayDate['date'] . '",';} ?>],
            datasets: [{
                    label: '# of Votes',
                    data: [<?php foreach ($totalClick as $keyClick => $valueClick) {echo '"' . $valueClick['click'] . '",';} ?>],
                    borderWidth: 1,
                    pointBackgroundColor: 'rgba(255,0,4,1)'
                }]
        },
        options: {
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
            }
        }
    });
 <?php }

 ?>
