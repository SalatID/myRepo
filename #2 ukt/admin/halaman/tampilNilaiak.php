<?php
    include '../../lib/config.php';
    $db = new config();
    $ts = $_POST['ts'];
    $jurus = $_POST['jurus'];
    $table = 'subkatjurus';
    $field = '*';
    $on ="";
    $where = "katJurusId =".$jurus." and tsId <=".$ts;
    $group ='';
    $order ='';
    $db->select($table,$field,$on,$where,$group,$order);
    $hasil = $db->getResult();
    $decode = json_decode($hasil,true);
    $rowJurus = $decode['post'];
    //print_r($decode);
 ?>
<table class="table">
  <tr>
    <th>No</th>
    <th>Nama Peserta</th>
    <th style="text-align : center">Tingkatan Sabuk</th>
    <?php
    $subKatJurusId = null;
     foreach ($rowJurus as $keyJurus => $valueJurus) {?>
       <th style="text-align : center;"><?php echo $valueJurus['nameSubKatJurus'] ?></th>
     <?php
     if ($subKatJurusId == null) {
       $subKatJurusId = $valueJurus['id'];
     }else {
       $subKatJurusId .= ','.$valueJurus['id'];
     }
   }
    ?>
  </tr>
  <?php
    $table = 'peserta';
    $field = '*';
    $on ="";
    $where = "tsAwal=".$ts;
    $group ='';
    $order ='';
    $db->select($table,$field,$on,$where,$group,$order);
    $hasil = $db->getResult();
    $decode = json_decode($hasil,true);
    $rowPeserta = $decode['post'];
    //print_r($decode);
    if (count($rowPeserta)==0) {?>
      <td colspan="<?php echo (count($rowJurus)+3) ?>" style="text-align : center"><h1>Tidak Ada Peserta Yang Tersedia</h1></td>
    <?php }
    foreach ($rowPeserta as $keyPeserta => $valuePeserta) {?>
      <tr>
        <td rowspan="2"><?php echo ($keyPeserta+1); ?></td>
        <td rowspan="2"><?php echo $valuePeserta['namePeserta']; ?></td>
        <td style="text-align : center;background-color : #E6E6E6">
          <?php
          $table = 'ts';
          $field = 'tsName';
          $on ="";
          $where = "id=".$valuePeserta['tsAwal'];
          $group ='';
          $order ='';
          $db->select($table,$field,$on,$where,$group,$order);
          $hasil = $db->getResult();
          $decode = json_decode($hasil,true);
          $rowTs = $decode['post'];
          echo $rowTs[0]['tsName'];
          ?>
        </td>
        <?php
          $table = 'nilai';
          $field = '*';
          $on ="";
          $where = "(subKatJurusId) IN (".$subKatJurusId.") and pesertaId=".$valuePeserta['id'];
          $group ='';
          $order ='';
          $db->select($table,$field,$on,$where,$group,$order);
          $hasil = $db->getResult();
          $decode = json_decode($hasil,true);
          $rowNilai = $decode['post'];
          //print_r($decode);
          for ($i=0;$i<count($rowJurus);$i++) {?>
            <td style="text-align : center; background-color : #E6E6E6"><?php echo isset($rowNilai[$i])?$rowNilai[$i]['nilai']:'<i>BELUM ADA NILAI</i>'; ?></td>
          <?php }
         ?>
      </tr>
      <tr>
        <td style="text-align : center"><strong>Penilai</strong></td>
        <?php
        $table = 'nilai';
          $field = '*';
          $on ="";
          $where = "(subKatJurusId) IN (".$subKatJurusId.") and pesertaId=".$valuePeserta['id'];
          $group ='';
          $order ='';
          $db->select($table,$field,$on,$where,$group,$order);
          $hasil = $db->getResult();
          $decode = json_decode($hasil,true);
          $rowNilai = $decode['post'];
          //print_r($decode);
          for ($i=0;$i<count($rowJurus);$i++) {

          if (isset($rowNilai[$i])) {
            $tablePenilai = 'penilai';
            $fieldPenilai = '*';
            $onPenilai ="";
            $wherePenilai = "id=".$rowNilai[$i]['pengujiId'];
            $groupPenilai ='';
            $orderPenilai ='';
            $db->select($tablePenilai,$fieldPenilai,$onPenilai,$wherePenilai,$groupPenilai,$orderPenilai);
            $hasil = $db->getResult();
            $decode = json_decode($hasil,true);
            $rowPenilai = $decode['post'];
            //print_r($decode);?>
              <td style="text-align : center"><?php echo isset($rowPenilai[0])?'<strong>'.$rowPenilai[0]['namePenilai'].'</strong>':'<i>BELUM ADA NILAI</i>'; ?></td>
            <?php
          }

          } ?>
      </tr>
    <?php }
   ?>
</table>
