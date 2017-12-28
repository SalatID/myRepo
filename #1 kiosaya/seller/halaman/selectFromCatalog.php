<html>
<div class="input-group">
  <input type="text" id="searchCatalogue" class="form-control" placeholder="Search Catalog..">
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
						<input type="hidden" id="userId" value="<?php echo $userId?>">
						<table class="table">
							<thead>
								<tr>
									<th></th>
									<th>Title</th>
									<th>Price</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody id="tbodyCatalogue">
								<tr>
									<td colspan="4" style="text-align : center"><h1>Please Type an Catalogue Title</h1></td>
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
     $('#searchCatalogue').keyup(function(){
         var keyword = $(this).val();
         var userId = $('#userId').val();
         var arrayCatalogue = JSON.stringify(<?php echo json_encode($arrayCatalogue); ?>);
         $.ajax({
             type : 'POST',
             url : 'halaman/searchCatalogue.php',
             data :  'keyword='+keyword+'&arrayCatalogue='+arrayCatalogue,
             success : function(data){
             $('#tbodyCatalogue').html(data);//menampilkan data ke dalam modal
             //alert(data);
             }
           })
       });
    });
  </script>
	</body>

</html>
