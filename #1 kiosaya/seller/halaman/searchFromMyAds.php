<?php
  include '../../lib/config.php';
  $db = new config();
  $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
  echo $keyword;
  $arrayAds = $_POST['arrayAds'];
  $decode = json_decode($arrayAds,true);
  $rowAds = $decode;
  //print_r($decode);
  $adsId = null;
  foreach ($rowAds as $keyAds => $valueAds) {
  $userId = $valueAds['userId'];
  if (isset($valueAds['adsId'])) {
    if ($adsId == null) {
      $adsId = $valueAds['adsId'];
    }else {
      $adsId .= " , ".$valueAds['adsId'];
      }
    }
  }
	$table = 'ads';
	$field = '*';
	$on = '';
  if(!isset($adsId)) {
    $where = 'userId='.$userId.' and active=1 and title like '."'%".$keyword."%'";
  } else {
    $where = 'userId='.$userId.' and active=1 and (id) NOT IN ('.$adsId.') and title like '."'%".$keyword."%'";
  }
  echo $where;
	$group ='';
	$order ='uploadDate desc';
	$db->select($table,$field,$on,$where,$group,$order);
	$result = $db->getResult();
	$decode = json_decode($result,true);
  print_r($decode);
	$rowAds = $decode['post'];
  if (!isset($rowAds[0])) {?>
    <tr>
      <td colspan="4" style="text-align : center"><h1>No Ads Available</h1></td>
    </tr>
  <?php
  }else {
    foreach ($rowAds as $keyAds => $valueAds) {?>
      <tr>
        <?php
            $table = 'images';
            $field = '*';
            $on = '';
            $where = 'adsId='.$valueAds['id'];
            $group ='';
            $db->select($table,$field,$on,$where,$group);
            $result = $db->getResult();
            $decode = json_decode($result,true);
            //print_r($decode);
            $rowImages = $decode['post'];
         ?>
        <td><img style="max-width: 120px; max-height: 120px; margin-left:auto;  margin-right:auto;" src="../images/<?php echo $rowImages[0]['location'] ?>" alt="images"></td>
        <td><?php echo $valueAds['title']; ?></td>
        <td>
          <a href="#" class="btn btn-info choose" data-id="<?php echo $valueAds['id'] ?>">Choose</a>
        </td>
      </tr>
    <?php
  }

  }
     ?>
     <script type="text/javascript" src="../js/jquery.js"></script>
     <script type="text/javascript">
       $(document).ready(function(){
         $('.choose').click(function(){
           var adsId = $(this).data('id');
           var config = 'config';
           $.ajax({
                  type : 'POST',
                  url : 'halaman/addSessionContract.php',
                  data :  'adsId='+adsId+"&config="+config,
                  success : function(data){
                    //alert(data);
                    window.location.href ="index?modul=newContract";
                  //$('.modal-body').html(data);//menampilkan data ke dalam modal
                  }
           })
         });
       });
     </script>
