<table class="table table-striped">
  <tr>
    <th>NO</th>
    <th style="width : 20%">Nama Kelompok</th>
    <th style="width : 20%">Penilai</th>
    <th style="width : 15%">TS</th>
    <th style="width : 30%">Anggota</th>
    <th style="width : 10%">Aksi</th>
  </tr>
  <form class="" action="../halaman/prosesEditKelompok.php" method="post">
  <?php
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
      $table = 'kelompok';
      $field = '*';
      $on ="";
      $where = 'id='.$id;
      $group ='';
      $order ='';
      $db->select($table,$field,$on,$where,$group,$order);
      $hasil = $db->getResult();
      $decode = json_decode($hasil,true);
      //print_r($decode);
      $rowKelompok = $decode['post'];
    $i=1;
    if (count($rowKelompok)!=0) {
      foreach ($rowKelompok as $keyKel => $valueKel) {?>
        <tr>
          <td><?php echo $i; ?></td>
          <td>
            <input type="hidden" name="id" value="<?php echo $valueKel['id']; ?>">
            <input class="form-control" type="text" name="namaKelompok" value="<?php echo $valueKel['nameKelompok']; ?>">
          </td>
          <td>
            <?php
            $notIn = null;
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
              foreach ($rowKel as $keyNotIn => $valueNotIn) {
                if ($notIn==null) {
                  $notIn = $valueNotIn['penilaiId'];
                } else {
                  $notIn .= ', '.$valueNotIn['penilaiId'];
                }
              }
            }
            //echo $notIn;

            $table = 'penilai';
            $field = 'id, namePenilai';
            $on ="";
            $where = 'id='.$valueKel['penilaiId'];
            $group ='';
            $order ='namePenilai asc';
            $db->select($table,$field,$on,$where,$group,$order);
            $hasil = $db->getResult();
            $decode = json_decode($hasil,true);
            //print_r($decode);
            $row = $decode['post'];
            $where = $notIn == null ? 'id !='.$valueKel['penilaiId'] : 'id!= '.$valueKel['penilaiId'].' and (id) NOT IN ('.$notIn.')';
            $db->select($table,$field,$on,$where,$group,$order);
            $hasil = $db->getResult();
            $decode = json_decode($hasil,true);
            $rowPenilai = $decode['post'];
             ?>
             <select class="form-control penilai" name="penilai">
               <option value="<?php echo $valueKel['penilaiId'] ?>"><?php echo $row[0]['namePenilai']; ?></option>
               <?php
                 foreach ($rowPenilai as $key => $value) {?>
                   <option value="<?php echo $value['id']?>"><?php echo $value['namePenilai']; ?></option>
               <?php  }
                ?>
             </select>
          </td>
          <td>
            <?php
            $table = 'ts';
            $field = 'id,tsName';
            $on ="";
            $where = 'id='.$valueKel['tsId'];
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
                $table = 'peserta';
                $field = 'id, namePeserta';
                $on ="";
                $where = 'kelompokId='.$valueKel['id'];
                $group ='';
                $order ='namePeserta ASC';
                $db->select($table,$field,$on,$where,$group,$order);
                $hasil = $db->getResult();
                $decode = json_decode($hasil,true);
                //print_r($decode);
                $rowPeserta = $decode['post'];
                $x=1;
                foreach ($rowPeserta as $keyPeserta => $valuePeserta) {?>
                    <?php echo $x.". ".$valuePeserta['namePeserta']; ?><a href='dashboard.php?modul=editAnggotaKel&id=<?php echo $valuePeserta['id'].', '.$valueKel['id']?>' style="float : right; color : black"><i class='fa fa-times' aria-hidden='true'></i></a></br>
            <?php  $x++;  }
                if(isset($_SESSION['peserta'])){
                //print_r($_SESSION['peserta']);
                foreach ($_SESSION['peserta'] as $keyPeserta => $valuePeserta) {
                  $table = 'peserta';
                  $field = 'id, namePeserta';
                  $on ="";
                  $where = 'id='.$valuePeserta['idPeserta'];
                  $group ='';
                  $order ='namePeserta ASC';
                  $db->select($table,$field,$on,$where,$group,$order);
                  $hasil = $db->getResult();
                  $decode = json_decode($hasil,true);
                  //print_r($decode);
                  $rowPeserta = $decode['post'];?>
                  <?php echo $x.". ".$rowPeserta[0]['namePeserta']; ?><a href="#" data-id = "<?php echo $keyPeserta ?>" class="deleteAnggotaKel" style="float : right; color : black"><i class='fa fa-times' aria-hidden='true'></i></a></br>
              <?php
                  $x++;
                  }
                }
             ?>

          </td>
          <td style="width : 25%">
            <a href="dashboard.php?modul=tambahAnggotaKel&data=<?php echo $valueKel['id'].",".$valueKel['tsId'].",editKelompok"; ?>" style="width : 100%" class="btn btn-info">Tambah Peserta</a>
          </td>
        </tr>
        <tr>
          <td colspan="6"><input type="submit" class="btn btn-info" style="width : 100%" name="" value="Simpan"></td>
        </tr>
      <?php $i++;
      }
    }?>
    </form>
  </table>
<?php  }
    ?>
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
    $('.deleteAnggotaKel').click(function(){
      var id = $(this).data('id');
      //var adsid1= $(this).val();
      var attr = $(this).text();
      //alert(attr);
      $.ajax({
        type	: 'POST',
        url		: '../halaman/proses.php',
        data	: 'idDeleteAnggotaSess='+id,
        success	: function(result){
          //alert(result);
          window.location.href ="dashboard.php?modul=editKelompok&id="+<?php echo $id; ?>;
        }
      })
    });
  });
</script>
