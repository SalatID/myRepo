<?php
  $data=$_GET['data'];
  $explode = explode(",",$data);
  $kelompokId = $explode[0];
  $tsId = $explode[1];
  $modulRedirect = $explode[2];

  //print_r($explode);
  $table = 'peserta';
  $field = '*, DATE_FORMAT(tglLahir," %d-%m-%Y") as tglLahir';
  $on ="";
  if (isset($_SESSION['peserta'])) {
    $notIn = null;
    foreach ($_SESSION['peserta'] as $keySession => $valueSession) {
      if ($notIn == null) {
        $notIn = $valueSession['idPeserta'];
      }else{
      $notIn .= ",".$valueSession['idPeserta'];
    }
    }
    //print_r($notIn);
    $where = 'tsAwal='.$tsId.' and (id) NOT IN ('.$notIn.') and kelompokId = 0';
  }else {
    $where = 'tsAwal='.$tsId.' and kelompokId = 0';
  }

  $group ='';
  $order ='namePeserta ASC';
  $db->select($table,$field,$on,$where,$group,$order);
  $hasil = $db->getResult();
  $decode = json_decode($hasil,true);
  //print_r($decode);
  $rowPeserta = $decode['post'];
  ?>
  <table class="table table-strip">
    <tr>
      <th>NO</th>
      <th>Nama</th>
      <th>TS Awal</th>
      <th>TS Akhir</th>
      <th>Asal Unit</th>
      <th>Tempat Lahir</th>
      <th>Tanggal Lahir</th>
      <th>Aksi</th>
    </tr>
  <?php
  if (count($rowPeserta) == 0) {?>
    <td colspan="8" style="text-align: center"><h1>Tidak Ada Peserta yang Bisa Ditambahkan</h1></td>
  <?php }else {
  $i=1;
  foreach ($rowPeserta as $key => $value) {?>
    <tr>
      <td><?php echo $i ?></td>
      <td><?php echo $value['namePeserta'] ?></td>
      <td>
        <?php
        $table = 'ts';
        $field = 'tsName';
        $on ="";
        $where = 'id='.$value['tsAwal'];
        $group ='';
        $order ='';
        $db->select($table,$field,$on,$where,$group,$order);
        $hasil = $db->getResult();
        $decode = json_decode($hasil,true);
        //print_r($decode);
        $rowTs = $decode['post'];
        echo $rowTs[0]['tsName'];
        ?>
      </td>
      <td>
        <?php
        $table = 'ts';
        $field = 'tsName';
        $on ="";
        $where = 'id='.$value['tsAkhir'];
        $group ='';
        $order ='';
        $db->select($table,$field,$on,$where,$group,$order);
        $hasil = $db->getResult();
        $decode = json_decode($hasil,true);
        //print_r($decode);
        $rowTs = $decode['post'];
        echo isset($rowTs[0]) ? $rowTs[0]['tsName'] : "Belum Ada";
        ?>
      </td>
      <td>
        <?php
        $table = 'unit';
        $field = 'nameUnit';
        $on ="";
        $where = 'id='.$value['unitId'];
        $group ='';
        $order ='';
        $db->select($table,$field,$on,$where,$group,$order);
        $hasil = $db->getResult();
        $decode = json_decode($hasil,true);
        //print_r($decode);
        $rowUnit = $decode['post'];
        echo $rowUnit[0]['nameUnit'];
        ?>
      </td>
      <td><?php echo $value['tempatLahir'] ?></td>
      <td><?php echo $value['tglLahir'] ?></td>
      <td>
        <a href="#" class="btn btn-info tambahkan" data-id="<?php echo $value['id'].",".$kelompokId ?>">Tambahkan</a>
      </td>
    </tr>
  <?php
    $i++;
    }
  }
  if ($modulRedirect == 'editKelompok') {
    $href = "dashboard.php?modul=editKelompok&id=".$kelompokId;
  } elseif ($modulRedirect == 'tambahKelompok') {
    $href = "dashboard.php?modul=tambahKelompok&id=".$kelompokId;
  }
  ?>
  <tr>
    <td colspan="8"><a href="<?php echo $href?>" class="btn btn-info" style="width : 100%">Selesai</a></td>
  </tr>
  </table>
  <script type="text/javascript">
    $(document).ready(function(){
      $('.tambahkan').click(function(){
          var id = $(this).data('id');
          $.ajax({
             type	: 'POST',
             url 	: '../halaman/proses.php',
             data 	: 'tambahAnggotaKel='+id,
             success	: function(data){
               //alert(data);
               window.location.href ="dashboard.php?modul=tambahAnggotaKel&data=<?php echo $data?>";
             }
           })
      });
    });
  </script>
