<?php
		$adsId = $_GET['adsId'];
		//echo $adsId;
		if(!isset($adsId)){
			header('location:index.php?modul=activeAds');
		}else{
 ?>
<div class="table-responsif">
	<h1>Make it Priority</h1>
	<table>
		<tr>
			<td><label for=""><h4>Please Select a Date</h2></label></td>
		</tr>
		<tr >
			<td>
					 <input type="hidden" id="adsId" value="<?php echo $adsId; ?>">
				 <div class="form-group">
                <div class='input-group date' >
                    <input type='text' id='datetimepicker' class="form-control" readonly />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
			</td>
			<td style="vertical-align : top; padding-left : 5%;">
					<a href="index.php?modul=newContract" class="btn btn-info" style="margin-letf : 10%;">Finish</a>
			</td>
		</tr>
	</table>
	<div class="table-responsive" id="tableSlot">
		<table class="table table-responsive table-bordered table-striped" id="tableSlot">
			<tr class="info">
				<th rowspan="2" class = "centerAlign" style="vertical-align: middle;">No</th>
  			<th rowspan="2" class = "centerAlign" style="vertical-align: middle;">Date</th>
  			<th rowspan="2" class = "centerAlign" style="vertical-align: middle;">Days</th>
  			<th colspan="2" class = "centerAlign">Time</th>
				<th rowspan="2" class = "centerAlign" style="vertical-align: middle;">Price</th>
        <th rowspan="2" class = "centerAlign" style="vertical-align: middle;">Status</th>
  		</tr>
      <tr class="info">
        <th class = "centerAlign">Start</th>
        <th class = "centerAlign">End</th>
      </tr>
			<tr>
				<td colspan="7" class = "centerAlign"><h1>Please Select a Date</h1></td>
			</tr>
		</table>
	</div>

</div>
<script src="../js/jquery.min.js"></script>
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		var date = new Date();
		var month = date.getMonth();
		var today = new Date('2017-10-28');
		$('#datetimepicker').datepicker({
				format: "DD,yyyy-mm-dd",
        autoclose:true,
				startDate: '+0d'
    	});
		$('#datetimepicker').change(function(){
			var datePicker = $('#datetimepicker').val();
			var adsId = $('#adsId').val();
			//alert (today);
			$.ajax({
				type	: 'POST',
				url		: 'halaman/checkAvailableSlot.php',
				data	: 'datePicker='+datePicker+"&adsId="+adsId,
				success	: function(result){
					$("#tableSlot").html(result);
				}
			})
		});
		});
</script>
<?php
	}
 ?>
