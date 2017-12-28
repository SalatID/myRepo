<table style="width : 100%">
  <tr>
    <td style=" padding:5px;"><input type="text" class="form-control namaKelompok" placeholder="Nama Kelompok" value=""></td>
    <td style=" padding:5px;">
      <?php
        $table = 'ts';
        $field = '*';
        $on ="";
        $where = '';
        $group ='';
        $order ='';
        $db->select($table,$field,$on,$where,$group,$order);
        $hasil = $db->getResult();
        $decode = json_decode($hasil,true);
        $rowTs = $decode['post'];
        //print_r($decode);
       ?>
       <select class="form-control filter ts" >
         <option value="">--Tingkatan Sabuk--</option>
         <?php
           foreach ($rowTs as $key => $value) {?>
             <option value="<?php echo $value['id']?>"><?php echo $value['tsName']; ?></option>
           <?php }
          ?>
       </select>
    </td>
    <td>
      <?php
      $notIn =null;
        if (isset($_SESSION['kelompok'])) {
          foreach ($_SESSION['kelompok'] as $keyKel => $valueKel) {
            if ($notIn==null) {
              $notIn = $valueKel['penilai'];
            } else {
              $notIn .= ', '.$valueKel['penilai'];
            }
          }
        }
        $table = 'kelompok';
        $field = 'penilaiId';
        $on ="";
        $where = '';
        $group ='';
        $order ='';
        $db->select($table,$field,$on,$where,$group,$order);
        $hasil = $db->getResult();
        $decode = json_decode($hasil,true);
        $rowKel = $decode['post'];
        //print_r($decode);
        if ($rowKel !=0 || isset($rowKel)) {
          foreach ($rowKel as $keyKel => $valueKel) {
            if ($notIn==null) {
              $notIn = $valueKel['penilaiId'];
            } else {
              $notIn .= ', '.$valueKel['penilaiId'];
            }
          }
        }
        //echo $notIn;
        $table = 'penilai';
        $field = '*';
        $on ="";
        $where = $notIn ==null ? "" : "(id) NOT IN (".$notIn.")";
        $group ='';
        $order ='namePenilai ASC';
        $db->select($table,$field,$on,$where,$group,$order);
        $hasil = $db->getResult();
        $decode = json_decode($hasil,true);
        $rowPenilai = $decode['post'];
        //print_r($decode);
       ?>
      <select class="form-control penilai" name="penilai">
        <option value="">Pilih Nama Penilai</option>
        <?php
          foreach ($rowPenilai as $key => $value) {?>
            <option value="<?php echo $value['id']?>"><?php echo $value['namePenilai']; ?></option>
        <?php  }
         ?>
      </select>
    </td>
  </tr>
  <tr>
    <td colspan="3" style=" padding:5px;"><a style="width : 100%"href="#" class="btn btn-info buatKelompok">Buat Kelompok</a></td>
  </tr>
</table>
<div class="isi">

</div>
<table class="table table-striped">
  <tr>
    <th>NO</th>
    <th style="width : 20%">Nama Kelompok</th>
    <th style="width : 20%">Penilai</th>
    <th style="width : 15%">TS</th>
    <th style="width : 30%">Anggota</th>
    <th style="width : 10%">Aksi</th>
  </tr>
  <?php
  $i=1;
  if (isset($_SESSION['kelompok'])) {
    //print_r($_SESSION['kelompok']);
    //print_r($_SESSION['peserta']);
    foreach ($_SESSION['kelompok'] as $keyKel => $valueKel) {?>
      <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $valueKel['namaKelompok']; ?></td>
        <td>
          <?php
          $table = 'penilai';
          $field = 'namePenilai';
          $on ="";
          $where = 'id='.$valueKel['penilai'];
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
        <td>
          <?php
          $table = 'ts';
          $field = 'tsName';
          $on ="";
          $where = 'id='.$valueKel['ts'];
          $group ='';
          $order ='';
          $db->select($table,$field,$on,$where,$group,$order);
          $hasil = $db->getResult();
          $decode = json_decode($hasil,true);
          //print_r($decode);
          $rowTs = $decode['post'];
          echo $rowTs[0]['tsName']
           ?>
        </td>
        <td>
          <?php
            if(isset($_SESSION['peserta'])){
              $x=1;
              foreach ($_SESSION['peserta'] as $keyPeserta => $value) {
                if ($value['idKelompok'] == $keyKel) {
                  $table = 'peserta';
                  $field = 'namePeserta';
                  $on ="";
                  $where = 'id='.$value['idPeserta'];
                  $group ='';
                  $order ='';
                  $db->select($table,$field,$on,$where,$group,$order);
                  $hasil = $db->getResult();
                  $decode = json_decode($hasil,true);
                  //print_r($decode);
                  $rowPeserta = $decode['post'];
                  echo $x.". ".$rowPeserta[0]['namePeserta']."</br>";
                  $x++;
                }
              }
            }
           ?>
        </td>
        <td style="width : 25%">
          <input type="button" style="width : 100%" class="btn btn-danger" value="Delete">
          <a href="dashboard.php?modul=tambahAnggotaKel&data=<?php echo $keyKel.",".$valueKel['ts'].",tambahKelompok"; ?>" style="width : 100%" class="btn btn-info">Tambah Peserta</a>
        </td>
      </tr>
    <?php $i++;
    }
  }else {?>
    <tr>
      <td colspan="6" style="text-align: center; "><h1>Silahkan Masukan Nama Kelompok dan Tingkatan Sabuk</h1></td>
    </tr>
  <?php }
   ?>
   <tr>
     <td colspan="6"><a href="../halaman/input.php" class="btn btn-info" style="width : 100%">Simpan Kelompok</a></td>
   </tr>
   <tr>
     <td colspan="6"><a href="../halaman/reset.php" class="btn btn-danger" style="width : 100%">Reset</a></td>
   </tr>
</table>
<script type="text/javascript">
  $(document).ready(function(){
    $('.buatKelompok').click(function(){
      var namaKelompok = $('.namaKelompok').val();
      var ts = $('.ts').val();
      var penilai = $('.penilai').val();
      $.ajax({
        type	: 'POST',
        url 	: '../halaman/proses.php',
        data 	: 'namaKelompok='+namaKelompok+'&ts='+ts+'&penilai='+penilai,
        success	: function(data){
          //alert(data);
          //$('.isi').html(data);
          window.location.href ="dashboard.php?modul=tambahKelompok&penilai="+data;
        }
      })
    });
  });
</script>
