<?php
require_once '../../lib/config.php';
$db     = new config();
$categoryId = $_POST['categoryId'];
$table  ="subcategory";
$field   = "*";
$order  = "name";
$where  = "categoryId=$categoryId";
$group = "";
$on ="";
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
