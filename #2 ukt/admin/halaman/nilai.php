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

 <table style="width : 50%">
   <tr>
     <td colspan="2" style="text-align : center;"><b>Filter Berdasarkan</b></td>
   </tr>
   <tr>
     <td style="padding : 5px;">
       <select class="form-control ts" name="ts" style="width: 100%">
       <option value="">--Tingkatan Sabuk--</option>
       <?php
         foreach ($rowTs as $key => $value) {?>
           <option value="<?php echo $value['id']?>"><?php echo $value['tsName']; ?></option>
         <?php }
        ?>
     </select>
   </td>
   <td style="padding : 5px;">
     <?php
       $table = 'katjurus';
       $field = '*';
       $on ="";
       $where = '';
       $group ='';
       $order ='';
       $db->select($table,$field,$on,$where,$group,$order);
       $hasil = $db->getResult();
       $decode = json_decode($hasil,true);
       $rowJurus = $decode['post'];
       //print_r($decode);
      ?>
     <select class="form-control jurus" name="jurus" style="width: 100%">
       <option value="">--Jurus--</option>
       <?php
         foreach ($rowJurus as $key => $value) {?>
           <option value="<?php echo $value['id']?>"><?php echo $value['nameKatJurus']; ?></option>
         <?php }
        ?>
     </select>
   </td>
   </tr>
   <tr>
     <td colspan="2"><input type="button" class="btn btn-info filter" style="width : 100%" name="" value="Filter"></td>
   </tr>
 </table>
 <div class="isi">

 </div>
 <script type="text/javascript">
   $(document).ready(function(){
     $('.filter').click(function(){
       var ts = $('.ts').val();
       var jurus = $('.jurus').val();
       if (ts=="" || jurus =="") {
         alert('Harap pilih Tingkatan Sabuk atau Jurus');
       }else {
         $.ajax({
            type	: 'POST',
            url 	: '../halaman/tampilNilai.php',
            data 	: 'ts='+ts+'&jurus='+jurus,
            success	: function(data){
              //alert(data);
              $('.isi').html(data);
            }
          })
       }
     });
   });
 </script>
