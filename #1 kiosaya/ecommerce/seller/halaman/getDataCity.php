<?php
require_once '../../lib/config.php';
$db     = new configEcom();
$provincesId = $_POST['provincesId'];
$tabel  ="city";
$fild   = "*";
$order  = "name";
$where  = "province_id='$provincesId'";
$group = "";
$on="";
$db->select($tabel,$fild,$on,$where,$group,$order);
$hasil = $db->getResult();
$decode = json_decode($hasil,true);
?>
<!--</br></br><select class="form-control" name='kedua'>-->
  <?php
for($a=0;$a<count($decode['post']);$a++) { ?>
  <option value=<?php echo $decode['post'][$a]['id'];?>><?php echo $decode['post'][$a]['name'];?></option>";
  <?php
}
?>
<!--</select>-->
