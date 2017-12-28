<?php
    $table = 'nilai';
    $field = 'subKatJurusId';
    $on ="";
    $where = 'subKatJurusId='.$_SESSION['jurus']['subKategoriJurus'].' and pengujiId='.$_SESSION['penilai'];
    $group ='';
    $order ='';
    $db->select($table,$field,$on,$where,$group,$order);
    $hasil = $db->getResult();
    $decode = json_decode($hasil,true);
    //print_r($decode);
    $rowJurus = $decode['post'];
    //echo count($rowJurus);
    if (count($rowJurus)==0) {
          if(isset($_SESSION['jurus'])){
            //print_r($_SESSION);
            $table = 'kelompok';
            $field = '*';
            $on ="";
            $where = 'penilaiId='.$_SESSION['penilai'];
            $group ='';
            $order ='';
            $db->select($table,$field,$on,$where,$group,$order);
            $hasil = $db->getResult();
            $decode = json_decode($hasil,true);
            //print_r($decode);
            $rowKelompok = $decode['post'];
         ?>
        <table class="table" border="0">
          <tr>
            <th style="width : 20%">Penilai  </th>
            <td style="width : 20%">:
              <?php
              $table = 'penilai';
              $field = 'namePenilai';
              $on ="";
              $where = 'id='.$_SESSION['penilai'];
              $group ='';
              $order ='';
              $db->select($table,$field,$on,$where,$group,$order);
              $hasil = $db->getResult();
              $decode = json_decode($hasil,true);
              //print_r($decode);
              $rowPenilai = $decode['post'];
              echo $rowPenilai[0]['namePenilai'];
               ?>
             </td>
            <td rowspan="2" style="width : 40%">
              <b>Catatan :<b/></br>
              1. Range Nilai 5-9</br>
              2. Setiap pengulangan diberi waktu istirahat 30 detik</br>
            </td>
          </tr>
          <tr>
            <th>Nama Kelompok </th>
            <td>: <?php echo $rowKelompok[0]['nameKelompok']; ?></td>
          </tr>
          <tr>
            <th style="text-align : center; text-transform : uppercase;"colspan="3">
              <h1>
                Materi :
                <?php
                $table = 'subkatjurus';
                $field = 'nameSubKatJurus';
                $on ="";
                $where = 'id='.$_SESSION['jurus']['subKategoriJurus'];
                $group ='';
                $order ='';
                $db->select($table,$field,$on,$where,$group,$order);
                $hasil = $db->getResult();
                $decode = json_decode($hasil,true);
                //print_r($decode);
                $rowJurus = $decode['post'];
                echo $rowJurus[0]['nameSubKatJurus'];
                ?>
              </h1>
            </th>
          </tr>
        </table>
         <table class="table">
           <tr>
             <th>No</th>
             <th>No.Peserta</th>
             <th>Nama</th>
             <th>TS</th>
             <th style="width : 15%">Nilai</th>
           </tr>
           <?php
               $table = 'peserta';
               $field = 'id, namePeserta, tsAwal';
               $on ="";
               $where = 'kelompokId='.$rowKelompok[0]['id'];
               $group ='';
               $order ='namePeserta ASC';
               $db->select($table,$field,$on,$where,$group,$order);
               $hasil = $db->getResult();
               $decode = json_decode($hasil,true);
                //print_r($decode);
               $rowPeserta = $decode['post'];
               $no=1;?>
               <form class="" action="inputNilai.php" method="post">
                 <input type="hidden" name="count" value="<?php echo count($rowPeserta)?>">
                 <input type="hidden" name="penilai" value="<?php echo $_SESSION['penilai'] ?>">
                 <input type="hidden" name="kelompok" value="<?php echo $rowKelompok[0]['id'] ?>">
                 <input type="hidden" name="jurus" value="<?php echo $_SESSION['jurus']['subKategoriJurus'] ?>">
               <?php
               foreach ($rowPeserta as $key => $value) {?>
                <tr>
                  <td><?php echo $no ?></td>
                  <td><input type="hidden" name="pesertaId<?php echo $key?>" value="<?php echo $value['id'] ?>"> <?php echo sprintf('%03s',$value['id']) ?></td>
                  <td><?php echo $value['namePeserta'] ?></td>
                  <td>
                    <?php
                    $table = 'ts';
                    $field = 'tsCode';
                    $on ="";
                    $where = 'id='.$value['tsAwal'] ;
                    $group ='';
                    $order ='';
                    $db->select($table,$field,$on,$where,$group,$order);
                    $hasil = $db->getResult();
                    $decode = json_decode($hasil,true);
                    //print_r($decode);
                    $rowTs = $decode['post'];
                    echo $rowTs[0]['tsCode']
                    ?>
                  </td>
                  <td style="width : 20%"><input class="form-control nilai" type="number" onKeyPress="if(this.value.length==1) return false;" name="nilai<?php echo $key?>" value="" min="5" max="9" required></td>
                </tr>
               <?php
               $no++;
             }
            ?>
           <tr>
             <td></td>
           </tr>
           <tr>
             <td colspan="5"><input type="submit" class="btn btn-info simpan" name="" value="Simpan" style="width: 100%"></td>
           </tr>
         </form>
         </table>
         <?php
          }else {
            header('location: dashboard.php?modul=home');
          }
    } else {
      header('location: dashboard.php?modul=home');
    }
?>
