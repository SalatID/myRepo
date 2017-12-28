<?php
  include '../../lib/config.php';
  session_start();
  $userId = $_SESSION['userId'];
  echo $userId;
  $db = new config();
  $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
  echo $keyword;
  $active = $_POST['active'];
	$table = 'ads';
	$field = '*';
	$on = '';
  $where = 'userId='.$userId.' and active='.$active.' and title like '.'"'.$keyword.'%"';
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
