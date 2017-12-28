<?php
	session_start();
	include_once '../../lib/config.php';
	$userId = $_SESSION['userId'];
	$db = new configEcom();
	$id = $_POST['id'];
	$pageName = $_POST['pageName'];
	$table = 'ads';
	$title = $_POST['title'];
	$category = $_POST['category'];
	$subCategory = $_POST['subCategory'];
	$new = $_POST['new'];
	$description = $_POST['description'];

	$updateAds = array ('title' => $title,
						'categoryId' => $category,
						'subCategoryId' => $subCategory,
						'new' => $new,
						'description' => $description
						);
	foreach ($updateAds as $row => $value) {
		echo $row.'=>'.$value.'</br>';
	}
	$where = 'id ='.$id;
  echo $db->update($table,$updateAds,$where);

  $table = 'adsprice';
  $priceId = $_POST['priceId'];
  $price = $_POST['price'];
  $updatePrice = array('price' =>$price);
  $where = 'id='.$priceId;
  echo $db->update($table,$updatePrice,$where);

	//table Log
	$date = date('Y-m-d H:i:s');
	$table = "log";
	$logCode = "editAds-".$id;
	$field = "max(id) as maxId";
	$where = "";
	$on = "";
	$db->select($table,$field,$on,$where);
	$hasil = $db->getResult();
	$decode = json_decode($hasil, true);
	$maxLogId = $decode['post'][0]['maxId'];
	$maxLogId++;
	$data = array('id' => $maxLogId,
					'logCode' => $logCode,
					'userId'=> $userId,
					'date' => $date
				);
	echo $db->insert($table,$data);
if ($pageName=="nonActive"){
	  header('location:../index.php?modul=nonActiveAds');
  } elseif ($pageName=="active"){
		header('location:../index.php?modul=activeAds');
  } else {
	  header('location:../index.php?modul=priorityAds');
  }
 ?>
