<?php
    include '../../lib/config.php';
    $db = new config();
 ?>
 <div style="float : right;">
   <h1 style=" margin : 0"><?php echo date('D,d-m-Y'); ?></h1></br>
   <h2 style=" margin : 0; text-align : right"><?php echo date('H:i:s'); ?></h2>
 </div>
 <table class="table">
   <tr>
     <th rowspan="2" style="vertical-align : middle">NO</th>
     <th rowspan="2" style="vertical-align : middle">Nama Peserta</th>
     <th rowspan="2" style="vertical-align : middle">TS</th>
     <th rowspan="2" style="vertical-align : middle">Penilai</th>
     <th colspan="8" style="text-align: center">Nilai</th>
   </tr>
   <tr>
     <td>St.SMI</td>
     <td>J.Trds</td>
     <td>Prastya</td>
     <td>B.Prak</td>
     <td>Fis.Tek</td>
     <td>Aerob.Tes</td>
     <td>Kk.Dasar</td>
     <td>S.Hindar</td>
     <td>Total</td>
   </tr>
   <form class="" action="../halaman/excelReporting.php" method="post">
   <?php
     $table = 'peserta';
     $field = '*';
     $on ="";
     $where = '';
     $group ='';
     $order ='';
     $db->select($table,$field,$on,$where,$group,$order);
     $hasil = $db->getResult();
     $decode = json_decode($hasil,true);
     $rowPeserta = $decode['post'];
     //print_r($decode);?>
      <input type="hidden" name="count" value="<?php echo count($rowPeserta) ?>">
     <?php
     foreach ($rowPeserta as $keyPeserta => $valuePeserta) {
       $bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
       ?>
       <tr>
         <td><?php echo ($keyPeserta+1); ?></td>
         <td>
           <input type="hidden" name="noPeserta<?php echo $keyPeserta ?>" value="<?php echo $valuePeserta['id'] ?>">
           <input type="hidden" name="namaPeserta<?php echo $keyPeserta ?>" value="<?php echo $valuePeserta['namePeserta'] ?>">
           <input type="hidden" name="tempatLahir<?php echo $keyPeserta ?>" value="<?php echo $valuePeserta['tempatLahir']?>">
           <input type="hidden" name="tglLahir<?php echo $keyPeserta ?>" value="<?php $date = date_create($valuePeserta['tglLahir']);echo date_format($date, "d").' '.$bulan[date_format($date, "n")].' '.date_format($date, "Y")?>">
           <?php
           echo $valuePeserta['namePeserta'];
           ?>
         </td>
         <td>
           <?php
             $table = 'ts';
             $field = '*';
             $on ="";
             $where = 'id='.$valuePeserta['tsAwal'];
             $group ='';
             $order ='';
             $db->select($table,$field,$on,$where,$group,$order);
             $hasil = $db->getResult();
             $decode = json_decode($hasil,true);
             $rowTsAwal = $decode['post'];
            ?>
           <input type="hidden" name="tsAwal<?php echo $keyPeserta ?>" value="<?php echo $rowTsAwal[0]['tsName'] ?>">
           <?php
             $where = 'id='.$valuePeserta['tsAkhir'];
             $group ='';
             $order ='';
             $db->select($table,$field,$on,$where,$group,$order);
             $hasil = $db->getResult();
             $decode = json_decode($hasil,true);
             $rowTsAkhir = $decode['post'];
            ?>
           <input type="hidden" name="tsAkhir<?php echo $keyPeserta ?>" value="<?php echo isset($rowTsAkhir[0])?$rowTsAkhir[0]['tsName']:"Belum Ada TS Akhir" ?>">
           <?php echo $rowTsAwal[0]['tsName']; ?>
         </td>

           <?php
           $table = 'nilai a LEFT JOIN subkatjurus b';
           $field = 'a.*,b.*,AVG(nilai) as jumNilai, SUM(nilai) as totalNilai';
           $on ="a.subKatJurusId=b.id";
           $where = 'pesertaId='.$valuePeserta['id'];
           $group ='';
           $order ='';
           $db->select($table,$field,$on,$where,$group,$order);
           $hasil = $db->getResult();
           $decode = json_decode($hasil,true);
           //print_r($decode);
           $rowNilai = $decode['post'];
           ?>
         <td>
           <?php
             $tablePenilai = 'penilai';
             $fieldPenilai = 'namePenilai';
             $onPenilai ="";
             $wherePenilai = 'id='.$rowNilai[0]['pengujiId'];
             $groupPenilai ='';
             $orderPenilai ='';
             $db->select($tablePenilai,$fieldPenilai,$onPenilai,$wherePenilai,$groupPenilai,$orderPenilai);
             $hasilPenilai = $db->getResult();
             $decodePenilai = json_decode($hasilPenilai,true);
             //print_r($decode);
             $rowPenilai = $decodePenilai['post'];
            ?>
           <input type="hidden" name="pengujiId<?php echo $keyPeserta ?>" value="<?php echo isset($rowPenilai[0])?$rowPenilai[0]['namePenilai'] : 'BELUM DINILAI' ?>">
           <?php echo isset($rowPenilai[0])?$rowPenilai[0]['namePenilai'] : '<b>BELUM DINILAI</b>'?>
         </td>
         <td>
           <?php
            $where = 'b.katJurusId = 1 and pesertaId='.$valuePeserta['id'];
            $db->select($table,$field,$on,$where,$group,$order);
            $hasil = $db->getResult();
            $decode = json_decode($hasil,true);
            //print_r($decode);
            $rowNilai = $decode['post'];
            echo $rowNilai[0]['jumNilai']>0 ? '<b>'.number_format($rowNilai[0]['jumNilai'],1).'</b>' : number_format($rowNilai[0]['jumNilai'],1);
           ?>
           <input type="hidden" name="kaidah<?php echo $keyPeserta ?>" value="<?php echo number_format($rowNilai[0]['jumNilai'],1) ?>">
         </td>
         <td>
           <?php
            $where = 'b.katJurusId = 2 and pesertaId='.$valuePeserta['id'];
            $db->select($table,$field,$on,$where,$group,$order);
            $hasil = $db->getResult();
            $decode = json_decode($hasil,true);
            //print_r($decode);
            $rowNilai = $decode['post'];
            echo $rowNilai[0]['jumNilai']>0 ? '<b>'.number_format($rowNilai[0]['jumNilai'],1).'</b>' : number_format($rowNilai[0]['jumNilai'],1);
           ?>
           <input type="hidden" name="tradisional<?php echo $keyPeserta ?>" value="<?php echo number_format($rowNilai[0]['jumNilai'],1) ?>">
         </td>
         <td>
           <?php
            $where = 'b.katJurusId = 3 and pesertaId='.$valuePeserta['id'];
            $db->select($table,$field,$on,$where,$group,$order);
            $hasil = $db->getResult();
            $decode = json_decode($hasil,true);
            //print_r($decode);
            $rowNilai = $decode['post'];
            echo $rowNilai[0]['jumNilai']>0 ? '<b>'.number_format($rowNilai[0]['jumNilai'],1).'</b>' : number_format($rowNilai[0]['jumNilai'],1);
           ?>
           <input type="hidden" name="prasetya<?php echo $keyPeserta ?>" value="<?php echo number_format($rowNilai[0]['jumNilai'],1) ?>">
         </td>
         <td>
           <?php
            $where = 'b.katJurusId = 4 and pesertaId='.$valuePeserta['id'];
            $db->select($table,$field,$on,$where,$group,$order);
            $hasil = $db->getResult();
            $decode = json_decode($hasil,true);
            //print_r($decode);
            $rowNilai = $decode['post'];
            echo $rowNilai[0]['jumNilai']>0 ? '<b>'.number_format($rowNilai[0]['jumNilai'],1).'</b>' : number_format($rowNilai[0]['jumNilai'],1);
           ?>
           <input type="hidden" name="bPraktis<?php echo $keyPeserta ?>" value="<?php echo number_format($rowNilai[0]['jumNilai'],1) ?>">
         </td>
         <td>
           <?php
            $where = 'b.katJurusId = 5 and pesertaId='.$valuePeserta['id'];
            $db->select($table,$field,$on,$where,$group,$order);
            $hasil = $db->getResult();
            $decode = json_decode($hasil,true);
            //print_r($decode);
            $rowNilai = $decode['post'];
            echo $rowNilai[0]['jumNilai']>0 ? '<b>'.number_format($rowNilai[0]['jumNilai'],1).'</b>' : number_format($rowNilai[0]['jumNilai'],1);
           ?>
           <input type="hidden" name="fisTek<?php echo $keyPeserta ?>" value="<?php echo number_format($rowNilai[0]['jumNilai'],1) ?>">
         </td>
         <td>
           <?php
            $where = 'b.katJurusId = 6 and pesertaId='.$valuePeserta['id'];
            $db->select($table,$field,$on,$where,$group,$order);
            $hasil = $db->getResult();
            $decode = json_decode($hasil,true);
            //print_r($decode);
            $rowNilai = $decode['post'];
            echo $rowNilai[0]['jumNilai']>0 ? '<b>'.number_format($rowNilai[0]['jumNilai'],1).'</b>' : number_format($rowNilai[0]['jumNilai'],1);
           ?>
           <input type="hidden" name="aerobTes<?php echo $keyPeserta ?>" value="<?php echo number_format($rowNilai[0]['jumNilai'],1) ?>">
         </td>
         <td>
           <?php
            $where = 'b.katJurusId = 7 and pesertaId='.$valuePeserta['id'];
            $db->select($table,$field,$on,$where,$group,$order);
            $hasil = $db->getResult();
            $decode = json_decode($hasil,true);
            //print_r($decode);
            $rowNilai = $decode['post'];
            echo $rowNilai[0]['jumNilai']>0 ? '<b>'.number_format($rowNilai[0]['jumNilai'],1).'</b>' : number_format($rowNilai[0]['jumNilai'],1);
           ?>
           <input type="hidden" name="kDasar<?php echo $keyPeserta ?>" value="<?php echo number_format($rowNilai[0]['jumNilai'],1) ?>">
         </td>
         <td>
           <?php
            $where = 'b.katJurusId = 8 and pesertaId='.$valuePeserta['id'];
            $db->select($table,$field,$on,$where,$group,$order);
            $hasil = $db->getResult();
            $decode = json_decode($hasil,true);
            //print_r($decode);
            $rowNilai = $decode['post'];
            echo $rowNilai[0]['jumNilai']>0 ? '<b>'.number_format($rowNilai[0]['jumNilai'],1).'</b>' : number_format($rowNilai[0]['jumNilai'],1);
           ?>
           <input type="hidden" name="sHindar<?php echo $keyPeserta ?>" value="<?php echo number_format($rowNilai[0]['jumNilai'],1) ?>">
         </td>
         <td>
           <?php
            $where = 'pesertaId='.$valuePeserta['id'];
            $db->select($table,$field,$on,$where,$group,$order);
            $hasil = $db->getResult();
            $decode = json_decode($hasil,true);
            //print_r($decode);
            $rowNilai = $decode['post'];
            echo $rowNilai[0]['totalNilai']>0 ? '<b>'.number_format($rowNilai[0]['totalNilai'],1).'</b>' : number_format($rowNilai[0]['totalNilai'],1);
           ?>
           <input type="hidden" name="sHindar<?php echo $keyPeserta ?>" value="<?php echo number_format($rowNilai[0]['jumNilai'],1) ?>">
         </td>
       </tr>
     <?php
   }
    ?>
  </form>
 </table>
