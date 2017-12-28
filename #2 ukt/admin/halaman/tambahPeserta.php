<form class="" action="../halaman/prosesTambahPeserta.php" method="post">
  <table style="width : 100%">
    <tr>
      <td colspan="2" style="padding : 5px;"><input maxlength="50" class="form-control" type="text" name="namaLengkap" placeholder="Nama Lengkap Peserta" value=""></br></td>
    </tr>
    <tr>
      <td style="padding : 5px;"><input maxlength="40" class="form-control" type="text" name="tempatLahir" placeholder="Tempat Lahir" value=""></br></td>
      <td style="padding : 5px;">
               <div class='input-group date' >
                   <input type='text' name="tanggalLahir" placeholder="Tanggal Lahir" id='datetimepicker' class="form-control" readonly />
                   <span class="input-group-addon">
                       <span class="glyphicon glyphicon-calendar"></span>
                   </span>
               </div>
        </br>
      </td>
    </tr>
    <tr>
      <td style="padding : 5px;">
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
        <select class="form-control" name="ts">
          <option value="">Tingkatan Sabuk</option>
          <?php
            foreach ($rowTs as $key => $value) {?>
              <option value="<?php echo $value['id']?>"><?php echo $value['tsName']; ?></option>
            <?php }
           ?>
        </select></br>
      </td>
      <td style="padding : 5px;">
        <?php
          $table = 'unit';
          $field = 'id, nameUnit';
          $on ="";
          $where = '';
          $group ='';
          $order ='';
          $db->select($table,$field,$on,$where,$group,$order);
          $hasil = $db->getResult();
          $decode = json_decode($hasil,true);
          $rowUnit = $decode['post'];
          //print_r($decode);
         ?>
        <select class="form-control" name="unit">
          <option value="">Asal Unit</option>
          <?php
            foreach ($rowUnit as $key => $value) {?>
              <option value="<?php echo $value['id']?>"><?php echo $value['nameUnit']; ?></option>
            <?php }
           ?>
        </select></br>
      </td>
    </tr>
    <tr>
      <td colspan="2"><input style="width : 100%"type="submit" class="btn btn-info" name="submit" value="Simpan"></td>
    </tr>
  </table>
</form>
<script type="text/javascript">
$(document).ready(function(){
  $('#datetimepicker').datepicker({
      format: "yyyy-mm-dd",
      autoclose:true
    });
});

</script>
