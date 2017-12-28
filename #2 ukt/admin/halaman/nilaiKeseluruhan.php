<?php
    include '../../lib/config.php';
    $db = new config();
 ?>
 <div style="float : right;">
   <h1 style=" margin : 0"><?php echo date('D,d-m-Y'); ?></h1></br>
   <h2 style=" margin : 0; text-align : right"><?php echo date('H:i:s'); ?></h2>
 </div>
 <table class="table table-hover">
   <tr>
     <th rowspan="2" style="vertical-align : middle">NO</th>
     <th rowspan="2" style="vertical-align : middle">Nama Peserta</th>
     <th rowspan="2" style="vertical-align : middle">TS</th>
     <th colspan="9" style="text-align: center">Nilai</th>
   </tr>
   <tr>
     <th style="text-align : center;">St.SMI</th>
     <th style="text-align : center;">J.Trds</th>
     <th style="text-align : center;">Prastya</th>
     <th style="text-align : center;">B.Prak</th>
     <th style="text-align : center;">Fis.Tek</th>
     <th style="text-align : center;">Aerob.Tes</th>
     <th style="text-align : center;">Kk.Dasar</th>
     <th style="text-align : center;">S.Hindar</th>
     <th style="text-align : center;">Total</th>
   </tr>
   <form class="" action="../halaman/excelReporting.php" method="post">
   <?php
     $table = 'peserta';
     $field = '*';
     $on ="";
     $where = '';
     $group ='';
     $order ='namePeserta ASC';
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
         <td rowspan="2"><?php echo ($keyPeserta+1); ?></td>
         <td rowspan="2">
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
           $jumlah = array();
           for($i=0;$i<8;$i++){?>
             <td style="background-color : #E6E6E6; text-align : center;vertical-align : middle;">
               <?php
                $where = 'b.katJurusId ='.($i+1).' and pesertaId='.$valuePeserta['id'];
                $db->select($table,$field,$on,$where,$group,$order);
                $hasil = $db->getResult();
                $decode = json_decode($hasil,true);
                //print_r($decode);
                $rowNilai = ('rowNilai'.$i);
                $rowNilai = $decode['post'];
                echo $rowNilai[0]['jumNilai']>0 ? '<h2><b>'.number_format($rowNilai[0]['jumNilai'],1).'</b></h2>' : '<h2>'.number_format($rowNilai[0]['jumNilai'],1).'</h2>';
                $jumlah[$i]=$rowNilai[0]['jumNilai'];
               ?>
               <input type="hidden" name="<?php echo $keyPeserta.$i ?>" value="<?php echo number_format($rowNilai[0]['jumNilai'],1) ?>">
             </td>
           <?php }
           ?>
           <td style="background-color : #00C34F; text-align : center; vertical-align: middle;">
             <?php
              echo '<h1><strong>'.number_format(array_sum($jumlah),1).'</strong><h1>';
             ?>
             <input type="hidden" name="totalNilai<?php echo $keyPeserta ?>" value="<?php echo number_format(array_sum($jumlah),1) ?>">
           </td>
       </tr>
       <tr>
         <td><strong>Penguji</strong></td>
         <?php
         for($i=0;$i<8;$i++){
          $where = 'b.katJurusId ='.($i+1).' and pesertaId='.$valuePeserta['id'];
          $db->select($table,$field,$on,$where,$group,$order);
          $hasil = $db->getResult();
          $decode = json_decode($hasil,true);
          //print_r($decode);
          $rowNilai = ('rowNilai'.$i);
          $rowNilai = $decode['post'];

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
         <td style="text-align : center;"><?php echo isset($rowPenilai[0]['namePenilai']) ? '<b>'.$rowPenilai[0]['namePenilai'].'</b>' : '<i>BELUM DINILAI</i>'; ?></td>
         <?php
       }
         ?>
       </tr>
     <?php
   }
    ?>
  </form>
 </table>
