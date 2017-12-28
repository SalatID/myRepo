<?php
include '../../lib/config.php';
$db = new config();
if (isset($_POST['filter'])) {
  $table = 'peserta';
  $field = '*, DATE_FORMAT(tglLahir," %d-%M-%Y") as tglLahir';
  $on ="";
  $where = $_POST['filter']=="" ? "" : 'tsAwal='.$_POST['filter'];
  $group ='';
  $order ='namePeserta ASC';
  $db->select($table,$field,$on,$where,$group,$order);
  $hasil = $db->getResult();
  $decode = json_decode($hasil,true);
  //print_r($decode);
  $rowPeserta = $decode['post'];?>
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
  $i=1;
  foreach ($rowPeserta as $key => $valuePeserta) {?>
    <tr>
      <td><?php echo $i ?></td>
      <td><?php echo $valuePeserta['namePeserta'] ?></td>
      <td>
        <?php
        $table = 'ts';
        $field = 'tsName';
        $on ="";
        $where = 'id='.$valuePeserta['tsAwal'];
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
      <td><?php
        $where = 'id='.$valuePeserta['tsAkhir'];
        $db->select($table,$field,$on,$where,$group,$order);
        $hasil = $db->getResult();
        $decode = json_decode($hasil,true);
        //print_r($decode);
        $rowTs = $decode['post'];
        echo isset($rowTs[0]) ? $rowTs[0]['tsName'] : 0;
       ?></td>
      <td>
        <?php
        $table = 'unit';
        $field = 'nameUnit';
        $on ="";
        $where = 'id='.$valuePeserta['unitId'];
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
      <td><?php echo $valuePeserta['tempatLahir'] ?></td>
      <td><?php echo $valuePeserta['tglLahir'] ?></td>
      <td>
        <a href="#" class="btn btn-danger hapus" data-id="<?php echo $valuePeserta['id'] ?>">Hapus</a>
        <a href="#editAds" data-toggle="modal" class="btn btn-info edit" data-id="<?php echo $valuePeserta['id'] ?>">Edit</a>
      </td>
    </tr>
  <?php
    $i++;
    }
  ?>
  </table>
<?php  } ?>
<!--Modal edit Ads start here-->
<div id="editAds" class="modal fade" role="dialog">
  <div class="modal-dialog">
  <!-- konten modal-->
  <div class="modal-content">
    <!-- heading modal -->
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Edit Advertise</h4>
    </div>
    <!-- body modal -->
    <div class="modal-body">

    </div>
  </div>
  </div>
</div>
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('a.edit').click(function () {
     var id = $(this).data('id');
     $.ajax({
         type : 'POST',
         url : '../halaman/editPeserta.php',
         data :  'id='+id,
         success : function(data){
         //alert(data);
         $('.modal-body').html(data);//menampilkan data ke dalam modal
         }
       })
     });
     $('a.hapus').click(function(){
       var id = $(this).data('id');
       $.ajax({
           type : 'POST',
           url : '../halaman/delete.php',
           data :  'idPeserta='+id,
           success : function(data){
            //alert(data);
           window.location.href ="dashboard.php?modul=peserta";
           }
         })
     });
  });
</script>
