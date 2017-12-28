<?php
  include '../../ecommerce/lib/config.php';
  $dbe = new configEcom();
  $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : " ";
  echo $keyword;
  $arrayCatalogue = $_POST['arrayCatalogue'];
  $catalogue = json_decode($arrayCatalogue, true);
  //print_r($decode);
  $catalogueId = null;
  foreach ($catalogue as $keyCatalogue => $valueCatalogue) {
    $userId = $valueCatalogue['userId'];
    if (isset($valueCatalogue['catalogueId'])) {
      if ($catalogueId == null) {
        $catalogueId = $valueCatalogue['catalogueId'];
      }else {
        $catalogueId .= " , ".$valueCatalogue['catalogueId'];
      }
    }
  }
  $table = 'ads';
  $field = '*';
  $on = '';
    if(!isset($catalogueId)) {
      $where = 'userId='.$userId.' and title like '."'%".$keyword."%'";
    } else {
      $where = 'userId='.$userId.' and (id) NOT IN ('.$catalogueId.') and title like '."'%".$keyword."%'";
    }
    echo $where;
  //echo $keyword;
  //echo $userId;
	$group ='';
	$order ='uploadDate desc';
	$dbe->select($table,$field,$on,$where,$group,$order);
	$result = $dbe->getResult();
	$decode = json_decode($result,true);
  print_r($decode);
	$rowAds = $decode['post'];
  if (!isset($rowAds[0])) {?>
    <tr>
      <td colspan="4" style="text-align : center"><h1>No Catalogue Available</h1></td>
    </tr>
  <?php
  }else {
    foreach ($rowAds as $keyAda => $valueAds) {?>
      <tr>
        <?php
            $table = 'images';
            $field = '*';
            $on = '';
            $where = 'adsId='.$valueAds['id'];
            $group ='';
            $dbe->select($table,$field,$on,$where,$group);
            $result = $dbe->getResult();
            $decode = json_decode($result,true);
            //print_r($decode);
            $rowImages = $decode['post'];
         ?>
        <td><img style="max-width: 120px; max-height: 120px; margin-left:auto;  margin-right:auto;" src="../images/<?php echo $rowImages[0]['location'] ?>" alt="images"></td>
        <td><?php echo $valueAds['title']; ?></td>
        <?php
            $table = 'adsprice';
            $field = '*';
            $on = '';
            $where = 'adsId='.$valueAds['id'];
            $group ='';
            $dbe->select($table,$field,$on,$where,$group);
            $result = $dbe->getResult();
            $decode = json_decode($result,true);
            print_r($decode);
            $rowPrice = $decode['post'];
         ?>
        <td><?php echo $rowPrice[0]['price']; ?></td>
        <td>
          <input type="hidden" id="adsId" value="<?php echo $valueAds['id'] ?>">
          <a href="#" class="btn btn-info choose"  data-id="<?php echo $valueAds['id'] ?>">Choose</a>
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
           var config = 'configEcom';
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
