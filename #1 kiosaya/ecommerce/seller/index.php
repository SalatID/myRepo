<?php
include 'menu.php';
?>
<div class="content menu" id="content">
	<div class="container-fluid">
		<div class="row">
			<div class="pasangiklan col-xs-12">
				<a href="index.php?modul=newAds" class="btn btn-warning" style="background-color:#757ee6; border-color :#757ee6; ">
					<i class="fa fa-plus-circle"></i> New Ads
				</a>
			</div>
			<div class="isi col-xs-12">
				<?php
						if(isset($_GET['modul'])){
							$modul = $_GET['modul'];

							switch ($modul) {
								case 'home':
									include "halaman/home.php";
									break;
								case 'profile':
									include "halaman/profile.php";
									break;
								case 'activeAds':
									include "halaman/activeAds.php";
									break;
								case 'nonActiveAds':
									include "halaman/nonActiveAds.php";
									break;
								case 'priorityAds':
									include "halaman/priorityAds.php";
									break;
								case 'detailAds':
									include "halaman/detailAds.php";
									break;
								case 'setting':
									include "halaman/setting.php";
									break;
								case 'newAds':
									include "halaman/newAds.php";
									break;
                case 'slotAvailable':
                  include "halaman/slotAvailable.php";
                  break;
                case 'logout':
                  include "halaman/logout.php";
                  break;
                case 'contract':
                  include "halaman/contract.php";
                  break;
                case 'newContract':
                  include "halaman/newContract.php";
                  break;
                case 'test':
                  include "halaman/test.php";
                  break;
								default:
									echo "<center><h3>Maaf. Halaman tidak di temukan !</h3></center>";
									break;
							}
						}else{
							include "halaman/home.php";
						}

				?>
			</div>
		</div>
	</div>
</div>

<?php include 'footer.php'; ?>
