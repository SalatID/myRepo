<?php
	include 'header.php' ;
	$modulGet = (isset($_GET['modul'])) ? $_GET['modul'] : "home";
	$table = 'menu';
	$field = '*';
	$on="";
	$where="";
	$db->select($table,$field, $on, $where);
	$hasil = $db->getResult();
	//echo $hasil;
	$decode = json_decode($hasil, true);
	//print_r($decode);
	$rowMenu = $decode['post'];
?>
  <ul class="nav nav-pills nav-stacked" >
	<?php for ($i=0; $i < count($rowMenu) ; $i++) {
		$modulName = $rowMenu[$i]['modulName'];
		//echo "modul get ".$modulGet;
		$menu = $rowMenu[$i]['name'];
		if ($modulGet == $modulName) {
			//echo $modulName;
			$active ="class='active'";
		} else {
			$active ="";
			//echo $modulName;
		}
		if ($rowMenu[$i]['menuPlacement']==1) {?>
			<li <?php echo $active;?>>
				<a href="index.php?modul=<?php echo $rowMenu[$i]['modulName']?>">
					<i class="<?php echo $rowMenu[$i]['icon']?>" aria-hidden="true"></i>
					<?php echo $menu; ?>
				</a>
			</li>
			<?php }
			?>
			<?php  }
			?>
		</ul><br>

	</div>
</div>
<div class="main-panel">
	<nav class="nav navbar-default navbar-fixed">
		<div class="container-fluid">
			<div class="navbar-collapse">
				<div class="navbar-header" id="sidebarCollapse">
					<button type="button" class="nb-btn-toggle" id="sidebarCollapse">
						<span class="fa fa-bars"></span>
					</button>
				</div>
				<ul class="nav navbar-nav navbar-left" >
					<?php
						$where="modulName ="."'".$modulGet."'";
						$db->select($table,$field, $on, $where);
						$hasil = $db->getResult();
						//echo $hasil;
						$decode = json_decode($hasil, true);
						//print_r($decode);
						$rowHead = $decode['post'];
						echo $rowHead[0]['name'];
					?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">

						<a class="dropdown-toggle" data-toggle="dropdown" style="text-transform: capitalize;" href=#>
							<i class="fa fa-user-circle-o" aria-hidden="true" ></i>
							<span class="userName"><?php echo $row[0]['name']; ?></span>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu dropdown-menu-right">
							<li>
								<a href="index.php?modul=profile">Profile</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="index.php?modul=logout">Logout</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>
