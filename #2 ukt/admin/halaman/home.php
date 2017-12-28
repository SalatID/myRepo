<form class="" action="../halaman/excelReporting.php" method="post">
  <div id="showNilai">

  </div>
  <input type="submit" class="btn btn-danger" name="" value="Download Laporan (ms.excel)" style="width : 100%; margin : 2% 0;">
</form>
<script type="text/javascript">
$(document).ready(function() {
  setInterval(function(){$('#showNilai').load('nilaiKeseluruhan.php');},1000);
});
</script>
