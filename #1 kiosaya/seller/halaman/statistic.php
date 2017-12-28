<?php
session_start();
include '../../lib/config.php';
$db = new config();
if (isset($_POST['ctrId'])) { ?>
  <input type="hidden" class="id" name="ctrId" value="<?php echo $_POST['ctrId'] ?>">
<?php } elseif (isset($_POST['adsId'])) {?>
  <input type="hidden" class="id" name="adsId" value="<?php echo $_POST['adsId'] ?>">
  <input type="hidden" class="ctrId" name="ctrId" value="<?php echo $_POST['contractId'] ?>">
<?php }
 ?>
<html>
    <head>
        <script src="../js/Chart.bundle.js"></script>
        <style type="text/css">
            .container {
                width: 100%;
                margin: 15px auto;
            }
        </style>
    </head>
    <div class="container">
      <div class="" style="float: left; margin-right : 2%;">
        <a class="btn btn-info back" data-id="<?php echo isset($_POST['adsId'])?$_POST['contractId']:null ?>"><i class="fa fa-chevron-left"></i> Back</a></br>
      </div>
      <?php
      $table = 'month';
      $field = 'id, name';

      $db->select($table,$field);
      $result = $db->getResult();
      $decode = json_decode($result,true);
      $rowMonth = $decode['post'];
      //print_r($decode);
       ?>
     <select style="width : 20%;" class="form-control month" name="month">
        <option value="null">--Pilih Bulan--</option>
        <?php
          foreach ($rowMonth as $keyMonth => $valueMonth) {?>
            <option value="<?php echo $valueMonth['id'] ?>"><?php echo $valueMonth['name'] ?></option>
          <?php }
         ?>
      </select>
      <div class="statistic">

      </div>

    </div>

    </body>
</html>
<script type="text/javascript">
  $(document).ready(function(){
    var id = $('.id').val();
    var name= $('.id').attr('name');
    var monthId = $('.month').val();
    if (name == 'ctrId') {
      //alert(id+'month->'+monthId);
      //$('.tableCtr').html('data')
      $.ajax({
        type : 'POST',
        url : 'halaman/getDataStatistic.php',
        data :  'ctrId='+id,
        success : function(data){
        $('.statistic').html(data);
        //alert(data);
         }
       });
    }else if (name=='adsId') {

      var ctrId = $('.ctrId').val();
      //alert(name+'ctrId->'+ctrId);
      $.ajax({
        type : 'POST',
        url : 'halaman/getDataStatistic.php',
        data :  'adsId='+id+'&contractId='+ctrId,
        success : function(data){
        $('.statistic').html(data);
        //alert(data);
         }
       });
    }
    $('.back').click(function(){
      var ctrId = $(this).data('id');
      //alert(ctrId);
      if (ctrId=="") {
        window.location.href ="index.php?modul=contract";
      }else {
        var idCtr = $(this).data('id');
        $.ajax({
          type : 'POST',
          url : 'halaman/adsCtr.php',
          data :  'idCtr='+idCtr,
          success : function(data){
          $('.tableCtr').html(data);//menampilkan data ke dalam modal
          //alert(data);
           }
         });
      }
      //alert(ctrId);
    });
    $('.month').change(function(){
      var monthId = $(this).val();
      var ctrId = $('.ctrId').val();
      var adsId = $('.adsId').val();
      //alert(monthId);
      if (monthId=="") {
        $.ajax({
          type : 'POST',
          url : 'halaman/getDataStatistic.php',
          data :  'adsId='+id+'&contractId='+ctrId,
          success : function(data){
          $('.statistic').html(data);
          //alert(data);
           }
         });
      }else {
        $.ajax({
          type : 'POST',
          url : 'halaman/getDataStatistic.php',
          data :  'adsId='+id+'&contractId='+ctrId+'&monthId='+monthId,
          success : function(data){
          $('.statistic').html(data);
          //alert(data);
           }
         });
      }

    });
  });
</script>
