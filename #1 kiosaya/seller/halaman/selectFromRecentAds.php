<html>
<div class="input-group">
  <input type="text" id="searchFromMyAds" class="form-control" placeholder="Search From My Ads..">
  <span class="input-group-btn">
    <button class="btn btn-default" type="button">
      <span class="glyphicon glyphicon-search"></span>
    </button>
  </span>
</div>
	<head>
	<body>
		<div id="container">
			<div class="tab-content">
				<div class="tab-pane fade in active" id="adsActive">
					<div class="table-responsive">
						<input type="hidden" id="userId" value="<?php echo $userId ?>">
						<table class="table">
							<thead>
								<tr>
									<th></th>
									<th>Title</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody id="tbodyRecentAds">
								<tr>
									<td colspan="4" style="text-align : center"><h1>Please Type an Ads Title</h1></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript">
    $(document).ready(function(){
				$('#searchFromMyAds').keyup(function(){
          var keyword = $(this).val();
          var userId = $('#userId').val();
          var arrayAds = JSON.stringify(<?php echo json_encode($arrayAds); ?>);
          //alert(arrayAds);
          $.ajax({
              type : 'POST',
              url : 'halaman/searchFromMyAds.php',
              data :  'keyword='+keyword+'&arrayAds='+arrayAds,
              success : function(data){
                //alert(data);
                $('#tbodyRecentAds').html(data);//menampilkan data ke dalam modal
              }
            })

				});
    });
  </script>
	</body>

</html>
