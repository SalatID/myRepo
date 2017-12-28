<?php
    include '../../lib/config.php';
    $db = new config();
    $id = $_POST['id'];
    $table = 'peserta';
    $field = '*';
    $on ="";
    $where = 'id='.$id;
    $group ='';
    $order ='';
    $db->select($table,$field,$on,$where,$group,$order);
    $hasil = $db->getResult();
    $decode = json_decode($hasil,true);
    //print_r($decode);
    $rowPeserta = $decode['post'];

 ?>
<form class="" action="../halaman/prosesEditPeserta.php" method="post">
  <input type="hidden" name="id" value="<?php echo $rowPeserta[0]['id'] ?>">
  <table style="width : 100%">
    <tr>
      <td colspan="2" style="padding : 5px;"><input maxlength="50" class="form-control" type="text" name="namaLengkap" value="<?php echo $rowPeserta[0]['namePeserta'] ?>"></br></td>
    </tr>
    <tr>
      <td style="padding : 5px;"><input maxlength="40" class="form-control" type="text" name="tempatLahir" placeholder="Tempat Lahir" value="<?php echo $rowPeserta[0]['tempatLahir'] ?>"></br></td>
      <td style="padding : 5px;">
               <div class='input-group date' >
                   <input type='text' name="tanggalLahir" placeholder="Tanggal Lahir" id='datetimepicker' class="form-control" value="<?php echo $rowPeserta[0]['tglLahir'] ?>" readonly />
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
          $where = 'id='.$rowPeserta[0]['tsAwal'];
          $group ='';
          $order ='';
          $db->select($table,$field,$on,$where,$group,$order);
          $hasil = $db->getResult();
          $decode = json_decode($hasil,true);
          $rowTs = $decode['post'];
          //print_r($decode);
         ?>
        <select class="form-control" name="tsAwal">
          <option value="<?php echo $rowTs[0]['id']; ?>"><?php echo $rowTs[0]['tsName']; ?></option>
          <?php
            $where = 'id !='.$rowPeserta[0]['tsAwal'];
            $db->select($table,$field,$on,$where,$group,$order);
            $hasil = $db->getResult();
            $decode = json_decode($hasil,true);
            $rowTs = $decode['post'];
            foreach ($rowTs as $key => $value) {?>
              <option value="<?php echo $value['id']?>"><?php echo $value['tsName']; ?></option>
            <?php }
           ?>
        </select></br>
      </td>
      <td style="padding : 5px;">
        <?php
          $table = 'ts';
          $field = '*';
          $on ="";
          $where = 'id='.($rowPeserta[0]['tsAwal']+1);
          $group ='';
          $order ='';
          $db->select($table,$field,$on,$where,$group,$order);
          $hasil = $db->getResult();
          $decode = json_decode($hasil,true);
          $rowTs = $decode['post'];
          //print_r($decode);
         ?>
        <select class="form-control" name="tsAkhir">
          <option value="<?php echo $rowTs[0]['id']; ?>"><?php echo $rowTs[0]['tsName']; ?></option>
          <?php
            $where = 'id !='.($rowPeserta[0]['tsAwal']+1);
            $db->select($table,$field,$on,$where,$group,$order);
            $hasil = $db->getResult();
            $decode = json_decode($hasil,true);
            $rowTs = $decode['post'];
            foreach ($rowTs as $key => $value) {?>
              <option value="<?php echo $value['id']?>"><?php echo $value['tsName']; ?></option>
            <?php }
           ?>
        </select></br>
      </td>
      </tr>
      <tr>
        <td style="padding : 5px;" colspan="2">
          <?php
            $table = 'unit';
            $field = 'id, nameUnit';
            $on ="";
            $where = 'id='.$rowPeserta[0]['unitId'];
            $group ='';
            $order ='';
            $db->select($table,$field,$on,$where,$group,$order);
            $hasil = $db->getResult();
            $decode = json_decode($hasil,true);
            $rowUnit = $decode['post'];
            //print_r($decode);
           ?>
          <select class="form-control" name="unit">
            <option value="<?php echo $rowUnit[0]['id'] ?>"><?php echo $rowUnit[0]['nameUnit'] ?></option>
            <?php
              $where = 'id !='.$rowPeserta[0]['tsAwal'];
              $db->select($table,$field,$on,$where,$group,$order);
              $hasil = $db->getResult();
              $decode = json_decode($hasil,true);
              $rowUnit = $decode['post'];
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
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../assets/bootstrap/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
$(document).ready(function(){
  $('#datetimepicker').datepicker({
      format: "yyyy-mm-dd",
      autoclose:true
    });
});

</script>
