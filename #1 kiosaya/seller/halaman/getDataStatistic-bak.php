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
      $hasil = $db->getResult();
      $decode = json_decode($hasil,true);
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
        $hasil = $db->getResult();
        $decode = json_decode($hasil,true);
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
  <?php  } elseif (isset($_POST['adsId'])) {
      $adsId = $_POST['adsId'];
      $ctrId = $_POST['contractId'];
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
      $hasil = $db->getResult();
      $decode = json_decode($hasil,true);
      $rowAds = $decode['post'];
      //print_r($decode);
      $rowAds = $decode['post'];
      //print_r ($decode);
      $totalClick = array();
      $arrayDate = array();
      $i=0;

      $table = 'countclick';
      $field = 'substring(date,-19,10) as date';
      $on = '';
      $where = 'adsId='.$rowAds[0]['id'];
      $group ='substring(date,-19,10)';
      $order ='';
      $db->select($table,$field,$on,$where,$group);
      $hasil = $db->getResult();
      $decode = json_decode($hasil,true);
      print_r($decode);
      $rowCountClick = $decode['post'];
      foreach ($rowCountClick as $keyClick => $valueClick) {
        //echo $valueClick['date'];
        $arrayDate[$i]['adsId'] = $adsId;
        $arrayDate[$i]['date'] = $valueClick['date'];
        $where = 'adsId='.$rowAds[0]['id'].' and substring(date,-19,10)='.'"'.$valueClick['date'].'"';
        $db->select($table,$field,$on,$where);
        $hasil = $db->getResult();
        $decode = json_decode($hasil,true);
        //print_r($decode);
        $rowTotalClick = $decode['post'];
        $totalClick[$i]['date'] = $valueClick['date'];
        $totalClick[$i]['click'] = count($rowTotalClick);
        echo count($rowTotalClick);
        $i++;
      }

    //print_r($arrayDate);
    ?>
    <input type="hidden" class="idCtr" value="<?php echo $ctrId ?>">
    <script>
       var ctx = document.getElementById("myChart");
       var myChart = new Chart(ctx, {
           type: 'bar',
           data: {
               labels: [<?php foreach ($arrayDate as $keyArrayDate => $valueArrayDate) {echo '"' . $valueArrayDate['date'] . '",';} ?>],
               datasets: [{
                       label: '# of Votes',
                       data: [<?php foreach ($totalClick as $keyClick => $valueClick) {echo '"' . $valueClick['click'] . '",';} ?>],
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
       $('.back').click(function(){
         var idCtr = $(this).data('id');
         //alert(idCtr);
        $.ajax({
          type : 'POST',
          url : 'halaman/adsCtr.php',
          data :  'idCtr='+idCtr,
          success : function(data){
          $('.tableCtr').html(data);//menampilkan data ke dalam modal
          //alert(data);
           }
         });
       });
   </script>
  <?php  }

 ?>
