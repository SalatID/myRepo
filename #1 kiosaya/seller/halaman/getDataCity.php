<?php
require_once '../../lib/config.php';
$db     = new config();
$provincesId = $_POST['provincesId'];
$table  ="city";
$field   = "*";
$order  = "name";
$where  = "province_id='$provincesId'";
$group = "";
$on="";
$db->select($table,$field,$on,$where,$group,$order);
$result = $db->getResult();
$decode = json_decode($result,true);
?>
<!--</br></br><select class="form-control" name='kedua'>-->
  <?php
for($a=0;$a<count($decode['post']);$a++) { ?>
  <option value=<?php echo $decode['post'][$a]['id'];?>><?php echo $decode['post'][$a]['name'];?></option>";
  <?php
}
?>
<!--</select>-->
