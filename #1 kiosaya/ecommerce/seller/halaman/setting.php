  <center><h2>Setting</h2></center>
  <div class="panel-group" id="accordion">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Change Email</a>
        </h4>
      </div>
      <div id="collapse1" class="panel-collapse collapse">
        <div class="panel-body">
            <form class="" action="" method="post">
              <input type="hidden" name="userId" id="userId" value="<?php echo $userId;?>">
              <input type="email" class="form-control" id="previousEmail" name="previousEmail" placeholder="Enter Previous Email" autocomplete="off" maxlength="40">
              <div id="previousEmailMessage"></div></br>
              <input type="email" class="form-control" id="newEmail" name="newEmail" placeholder="Enter New Email" autocomplete="off" maxlength="40"></br>
              <input type="" id="changeEmail" class="btn btn-warning" name="" value="Change">
            </form>
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Change Password</a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body">
        <form class="" action="" method="post">
          <input type="hidden" name="id" id="id" value="<?php echo $userId;?>">
          <input type="text" class="form-control" name="previousPassword" id="previousPassword" placeholder="Enter Previous Password" autocomplete="off">
          <div id="previousPasswordMessage"></div></br>
          <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="Enter New Password" autocomplete="off">
          <div id="newPasswordMessage"></div></br>
          <input type="password" class="form-control" name="retypeNewPassword" id="retypeNewPassword" placeholder="Re-Enter New Password" autocomplete="off"></br>
          <input type="" class="btn btn-warning" name="" id="change" value="Change">
        </form>
      </div>
      </div>
    </div>
  </div>
</body>
</html>
<script type='text/javascript' src="../js/jquery.js"></script>
<script type='text/javascript'>
  $(document).ready(function () {
    $('input#changeEmail').prop('disabled',true);
    $('input#change').prop('disabled',true);
    $('#retypeNewPassword').prop('disabled',true);
    $('#newPassword').prop('disabled',true);
    $('#newEmail').prop('disabled',true);
      $('#previousPassword').keyup(function(){
        var previousPassword = $(this).val();
        var id = $("input#id").val();
        //alert(previousPassword);
        $.ajax({
          type	: 'POST',
					url 	: 'halaman/cekPreviousPass.php',
					data 	: 'previousPassword='+previousPassword+"&id="+id,
					success	: function(data){
            if (data==1) {
    					$('#previousPasswordMessage').html(" &#10004; Password Sama");
              $('#retypeNewPassword').prop('disabled',false);
              $('#newPassword').prop('disabled',false);
              $data = data;
    				}else {
    					$('#previousPasswordMessage').html(" &#10008; Password Tidak Sama");
              $('#retypeNewPassword').prop('disabled',true);
              $('#newPassword').prop('disabled',true);
    				}
          }
        })
      });
      $('#retypeNewPassword').keyup(function(){
        var newPassword = $('#newPassword').val();
				var retypeNew = $('#retypeNewPassword').val();
        //alert($data);
        //alert(previousPasswordMessage);
				if (newPassword==retypeNew && $data==1) {
					$('#newPasswordMessage').html(" &#10004; Password Sama");
          $('input#change').prop('disabled',false);
				}else {
					$('#newPasswordMessage').html(" &#10008; Password Tidak Sama");
          $('input#change').prop('disabled',true);
				}
      });
      $('#newPassword').click(function(){
        $('#retypeNewPassword').val("");
        $('input#change').prop('disabled',true);
      });
      $('#previousEmail').keyup(function(){
        var previousEmail = $(this).val();
        var userId = $('input#userId').val();
        //alert(userId);
        $.ajax({
          type	: 'POST',
					url 	: 'halaman/cekPreviousEmail.php',
					data 	: 'previousEmail='+previousEmail+"&userId="+userId,
					success	: function(data){
            if (data==1) {
    					$('#previousEmailMessage').html(" &#10004; Email Sama");
              $('#newEmail').prop('disabled',false);
              $('input#changeEmail').prop('disabled',false);
    				}else {
    					$('#previousEmailMessage').html(" &#10008; Email Tidak Sama");
              $('#newEmail').prop('disabled',true);
              $('input#changeEmail').prop('disabled',true);
    				}
            //alert(data);
          }
        })
      });
      $('input#changeEmail').click(function(){
        var newEmail = $('input#newEmail').val();
        var userId = $('input#userId').val();
        $.ajax({
          type	: 'POST',
					url 	: 'halaman/updateEmail.php',
					data 	: 'newEmail='+newEmail+"&userId="+userId,
					success	: function(data){
            if (data==11) {
              swal({
                title: "Thank You",
                 text: "Your Email Successfully Changed",
                  type: "success"
                },
                function(){
                  window.location.href ="index?modul=setting";
              });
    				}else {
              swal({
                title: "Sorry",
                 text: "Your Email Failed to Changed",
                  type: "error"
                },
                function(){
                  window.location.href ="index?modul=setting";
              });
    				}
            //alert(data);
          }
        })
      });
      $('input#change').click(function(){
        var newPassword = $('#retypeNewPassword').val();
        var id = $("input#id").val();
        $.ajax({
          type	: 'POST',
          url 	: 'halaman/updatePassword.php',
          data 	: 'newPassword='+newPassword+"&id="+id,
          success	: function(data){
            if (data==11) {
              swal({
                title: "Thank You",
                 text: "Your Password Successfully Changed",
                  type: "success"
                },
                function(){
                  window.location.href ="index?modul=setting";
              });
            }else {
              swal({
                title: "Sorry",
                 text: "Your Password Failed to Changed",
                  type: "error"
                },
                function(){
                  window.location.href ="index?modul=setting";
              });
            }
          }
        })
      });
      $('input#change').prop('disabled',true);
    });

</script>
