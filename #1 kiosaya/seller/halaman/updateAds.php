<?php
	session_start();
	include_once '../../lib/config.php';
	$userId = $_SESSION['userId'];
	$db = new config();
	$adsId = $_POST['adsId'];
	$table = 'ads';
	$title = $_POST['title'];
	$category = $_POST['category'];
	$subCategory = $_POST['subCategory'];
	$description = $_POST['description'];
	$redirectLink = $_POST['redirectLink'];
	$pageName = $_POST['pageName'];

	$updateAds = array ('title' => $title,
						'categoryId' => $category,
						'subCategoryId' => $subCategory,
						'description' => $description,
						'redirectLink' => $redirectLink
						);
	foreach ($updateAds as $keyAds => $valueAds) {
	}
	$where = 'id ='.$adsId;
	$db->update($table,$updateAds,$where);



	//table Log
	$date = date('Y-m-d H:i:s');
	$table = "log";
	$logCode = "editAds-".$adsId;
	$field = "max(id) as maxId";
	$where = "";
	$on = "";
	$db->select($table,$field,$on,$where);
	$result = $db->getResult();
	$decode = json_decode($result, true);
	$maxLogId = $decode['post'][0]['maxId'];
	$maxLogId++;
	$data = array('id' => $maxLogId,
					'logCode' => $logCode,
					'userId'=> $userId,
					'date' => $date
				);
	$db->insert($table,$data);
	if ($pageName=='ads') {
		header('location:../index.php?modul=activeAds');
	}elseif ($pageName=='adsCtr') {
		header('location:../index.php?modul=contract');
	}

 ?>
