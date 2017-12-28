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
<label for="">Filter Berdasarkan Tingkatan Sabuk</label></br>
<select class="form-control filter" name="ts" style="width: 20%">
  <option value="">Tampilkan Semua</option>
  <?php
    foreach ($rowTs as $key => $value) {?>
      <option value="<?php echo $value['id']?>"><?php echo $value['tsName']; ?></option>
    <?php }
   ?>
</select></br>
<div class="isi" style="width : 100%">

</div>

<script type="text/javascript">
$(document).ready(function(){
  var filter = $('.filter').val();
  //alert(filter)
  if (filter == "") {
    $.ajax({
       type	: 'POST',
       url 	: '../halaman/tampilPeserta.php',
       data 	: 'filter='+filter,
       success	: function(data){
         //alert(data);
         $('.isi').html(data);
       }
     })
  }else {

  }
  $('.filter').change(function(){
    var filter = $(this).val();
    $.ajax({
       type	: 'POST',
       url 	: '../halaman/tampilPeserta.php',
       data 	: 'filter='+filter,
       success	: function(data){
         //alert(data);
         $('.isi').html(data);
       }
     })
  });
});

</script>
