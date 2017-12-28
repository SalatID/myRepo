<?php
    if(isset($_SESSION['penilai'])){ ?>
      <form class="" action="proses.php" method="post">
        <table class="table">
          <tr>
            <td>
              <?php
                //echo $_SESSION['penilai'];
                $table = 'kelompok';
                $field = 'id';
                $on ="";
                $where = 'penilaiId='.$_SESSION['penilai'];
                $group ='';
                $order ='';
                $db->select($table,$field,$on,$where,$group,$order);
                $hasil = $db->getResult();
                $decode = json_decode($hasil,true);
                $rowKatKelompok = $decode['post'];

                $table = 'katjurus';
                $field = '*';
                $on ="";
                $where = '';
                $group ='';
                $order ='nameKatJurus ASC';
                $db->select($table,$field,$on,$where,$group,$order);
                $hasil = $db->getResult();
                $decode = json_decode($hasil,true);
                $rowKatJurus = $decode['post'];
                //print_r($decode);
               ?>
               <input type="hidden" class="kelompokId" name="kelompokId" value="<?php echo $rowKatKelompok[0]['id']?>">
              <select class="form-control katJurus" name="kategoriJurus">
                <option value="">Pilih Kategori Jurus</option>
                <?php
                    foreach ($rowKatJurus as $key => $value) { ?>
                      <option value="<?php echo $value['id'] ?>"><?php echo $value['nameKatJurus']; ?></option>
                  <?php  }
                 ?>
              </select>
            </td>
          </tr>
          <tr>
            <td>
              <select class="form-control subKategoriJurus" name="subKategoriJurus">
                <option value="">Pilih Sub Kategori Jurus</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>
                <input style="width : 100%" type="submit" name="kirim" class="btn btn-info kirim"value="Pilih">
            </td>
          </tr>
        </table>
      </form>
      <script type="text/javascript" src="../js/jquery.js"></script>
      <script type="text/javascript">
       $(document).ready(function(){
         $('.kirim').prop('disabled', true);
         $('.subKategoriJurus').prop('disabled',true);
         $('.katJurus').change(function(){
           var idKatJurus = $(this).val();
           var idKelompok = $('.kelompokId').val();
           $.ajax({
              type	: 'POST',
              url 	: '../halaman/proses.php',
              data 	: 'idKatJurus='+idKatJurus+'&idKelompok='+idKelompok,
              success	: function(data){
                //alert(data);
                  $('.subKategoriJurus').html(data);
                  $('.subKategoriJurus').prop('disabled', false);
                  var subKatJurusId = $('.subKategoriJurus').val();
                  if (subKatJurusId=="") {
                     $('.kirim').prop('disabled', true);
                  }else {
                     $('.kirim').prop('disabled', false);
                  }
              }
            })
         })
       });
      </script>
  <?php  }else {
      header('location: ../index.php');
    }
 ?>
