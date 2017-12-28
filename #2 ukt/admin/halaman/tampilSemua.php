<?php
include '../../lib/config.php';
$db = new config();
$table = 'nilai a INNER JOIN peserta b';
$field = 'a.*, b.*';
$on =" a.pesertaId = b.id";
$where = "";
$group ='';
$order ='';
$db->select($table,$field,$on,$where,$group,$order);
$hasil = $db->getResult();
$decode = json_decode($hasil,true);
$rowNilai = $decode['post'];
//print_r($decode);
echo count($rowNilai);
 ?>
 <link rel="stylesheet" href="../../admin/assets/bootstrap/css/bootstrap.css">
 <table class="table">
<tr>
  <th>No</th>
  <th>Nama</th>
  <th colspan="41">Nilai</th>
</tr>
<?php
  foreach ($rowNilai as $keyNilai => $valueNilai) {
?>
<tr>
  <td><?php echo ($keyNilai+1) ?></td>
  <td><?php echo $valueNilai['namePeserta']; ?></td>
  <?php
    $table = 'subkatjurus';
    $field = '*';
    $on ="";
    $where = "";
    $group ='';
    $order ='';
    $db->select($table,$field,$on,$where,$group,$order);
    $hasil = $db->getResult();
    $decode = json_decode($hasil,true);
    $rowJurus = $decode['post'];
    foreach ($rowJurus as $keyJurus => $valueJurus) {
      if ($valueNilai['subKatJurusId']==$valueJurus['id']) {?>
        <td><?php echo $keyJurus ?></td>
    <?php  }
      ?>

    <?php }
   ?>
</tr>
<?php
  }
 ?>
 </table>
