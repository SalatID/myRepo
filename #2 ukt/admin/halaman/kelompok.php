<table class="table">
  <tr>
    <th>NO</th>
    <th>Nama Kelompok</th>
    <th>Tingkatan Sabuk</th>
    <th>Penilai</th>
    <th>Anggota</th>
    <th>Aksi</th>
  </tr>
  <?php
    $table = 'kelompok';
    $field = '*';
    $on ="";
    $where = '';
    $group ='';
    $order ='';
    $db->select($table,$field,$on,$where,$group,$order);
    $hasil = $db->getResult();
    $decode = json_decode($hasil,true);
    //print_r($decode);
    $rowKelompok = $decode['post'];
    $i=1;
    if (count($rowKelompok)==0) {?>
      <tr>
        <td colspan="6" style="text-align: center"><h1>Belum Ada Kelompok Yang Dibuat</h1></td>
      </tr>
      <?php $href = 'dashboard.php?modul=tambahKelompok'; ?>
    <?php }else {
      $penilai = null;
    foreach ($rowKelompok as $keyKel => $valueKel) {?>
      <tr>
        <td><?php echo $i ?></td>
        <td><?php echo $valueKel['nameKelompok'] ?></td>
        <td>
          <?php
          $table = 'ts';
          $field = 'tsName';
          $on ="";
          $where = 'id='.$valueKel['tsId'];
          $group ='';
          $order ='';
          $db->select($table,$field,$on,$where,$group,$order);
          $hasil = $db->getResult();
          $decode = json_decode($hasil,true);
          //print_r($decode);
          $rowTs = $decode['post'];
          echo $rowTs[0]['tsName'] ?>
        </td>
        <td>
          <?php
          $table = 'penilai';
          $field = 'namePenilai';
          $on ="";
          $where = 'id='.$valueKel['penilaiId'];
          $group ='';
          $order ='';
          $db->select($table,$field,$on,$where,$group,$order);
          $hasil = $db->getResult();
          $decode = json_decode($hasil,true);
          //print_r($decode);
          $rowPenilai = $decode['post'];
          echo $rowPenilai[0]['namePenilai']
           ?>
        </td>
        <td>
          <?php
          $table = 'peserta';
          $field = 'namePeserta';
          $on ="";
          $where = 'kelompokId='.$valueKel['id'];
          $group ='';
          $order ='namePeserta ASC';
          $db->select($table,$field,$on,$where,$group,$order);
          $hasil = $db->getResult();
          $decode = json_decode($hasil,true);
          //print_r($decode);
          $rowPeserta = $decode['post'];
          $no=1;
          foreach ($rowPeserta as $key => $value) {
            echo $no.". ".$value['namePeserta'].'</br>';
            $no++;
          }
          ?>
        </td>
        <td>
          <a href="dashboard.php?modul=editKelompok&id=<?php echo $valueKel['id']?>" class="btn btn-info">Edit</a>
          <a data-id="<?php echo $valueKel['id']?>" class="btn btn-danger delete">Delete</a>
        </td>
      </tr>
    <?php
    $i++;

  }

  }
   ?>
<tr>
  <td colspan="6">
    <a href="dashboard.php?modul=tambahKelompok"  class="btn btn-warning" style="margin : 0 10px;width: 96%">
      <i class="fa fa-plus-circle"></i> Tambah Kelompok
    </a>
  </td>
</tr>
</table>
<script type="text/javascript">
$(document).ready(function(){
  $('.delete').click(function(){
    var id = $(this).data('id');
    $.ajax({
       type	: 'POST',
       url 	: '../halaman/delete.php',
       data 	: 'idKelompok='+id,
       success	: function(data){
         //alert(data);
         window.location.href ="dashboard.php?modul=kelompok";
       }
     })
  });
});

</script>
