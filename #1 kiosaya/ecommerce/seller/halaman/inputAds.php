<?php
	session_start();
	$today = date('ymd');

	include_once '../../lib/config.php';
	$db = new configEcom();

	//tabel iklan
	$table = "ads";
	$field = "max(id) as maxId";
	$where = "id like '$today%'";
	$on = "";
	$title = $_POST['title'];
	$category = $_POST['category'];
	$subcategory = $_POST['subcategory'];
	$description = $_POST['description'];
	$new = isset($_POST['new']) ? $_POST['new'] : "" ;
	$userId = $_SESSION['userId'];
	$uploadDate = date("Y-m-d h:i:s");
	$db->select($table,$field,$on,$where);
	$hasil = $db->getResult();
	$decode = json_decode($hasil, true);
	$maxId = $decode['post'][0]['maxId'];
	$active = 1;

	$substring = substr($maxId,6,4);
	$substring++;

  $newId = $today.sprintf('%04s',$substring);

	$data = array('id' => $newId,
					'title' => $title,
					'userId' => $userId,
					'categoryId' => $category,
					'subCategoryId' => $subcategory,
					'description' => $description,
					'new' => $new,
					'active' => $active,
					'uploadDate' => $uploadDate
				  );


	echo $db->insert($table,$data);

	//tabel adsprice
	$table = "adsprice";
	$field = "max(id) as maxId";
	$where = "";
	$on = "";
	$price = $_POST['price'];
	$db->select($table,$field,$on,$where);
	$hasil = $db->getResult();
	$decode = json_decode($hasil, true);
	$maxPriceId = $decode['post'][0]['maxId'];
	$maxPriceId++;
	$data = array('id' => $maxPriceId,
					'adsId'=> $newId,
					'price' => $price
				);
	echo $db->insert($table,$data)."<br>";

	//tabel images
	$table = "images";
	$field = "max(id) as maxId";
	$where = "";
	$on = "";
	$location = $_POST['location'];
	$db->select($table,$field,$on,$where);
	$hasil = $db->getResult();
	$decode = json_decode($hasil, true);
	$maxImagesId = $decode['post'][0]['maxId'];
	$maxImagesId++;
	$rand = "-".rand(10,1000);
	$timeUpl = date('his');
	$table = "images";
	$temp = explode(".", $_FILES["media"]["name"]);
	$fileName = $timeUpl.$rand.".".$temp[1];
	//echo $fileName;
	$target_dir = "../../../images/";
	$db_dir = $fileName;
	$target_file = $target_dir . $fileName;//get the file name

	$fileSize = $_FILES['media']['size']; //get the size
	$fileError = $_FILES['media']['error']; //get the error when upload
	if($fileSize > 0 || $fileError == 0){ //check if the file is corrupt or error
	  $move = move_uploaded_file($_FILES['media']['tmp_name'],$target_file); //save image to the folder
	  if($move){
			$sources = $target_dir.$fileName;
			//echo $sources;
			$data = getimagesize($sources);
			$width = $data[0];
			$height = $data[1];
			echo $width;
			echo $height;
			if ($width > 400 || $height > 400 ) {
				if ($width > $height) {
					if ($width > 400) {
						echo 'width';
					  $maxWidth = 400;
					  $ratio = $width / $maxWidth;
					  $newWidth = $width / $ratio;
					  $newHeight = $height / $ratio;
					}
				}else {
					if ($height > 400) {
 				  $maxHeight = 400;
 				  $ratio = $height / $maxHeight;
 				  $newHeight = $height / $ratio;
 				  $newWidth = $width / $ratio;
 					echo $newHeight;
 					echo $newWidth;
 				}
			}
				if ($temp[1] == 'jpg' || $temp[1] == 'JPG') {
					$original = imagecreatefromjpeg($sources);
				} elseif ($temp[1] == 'png' || $temp[1] == 'PNG') {
					$original = imagecreatefrompng($sources);
				} elseif ($temp[1] == 'gif') {
					$original = imagecreatefromgif($sources);
				}
				$img = imagecreatetruecolor($newWidth,$newHeight);
				imagecopyresampled($img, $original, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
				imagejpeg($img, $sources );
				$location = $fileName;
				imagedestroy($original);
				imagedestroy($img);
			} else {
				$location = $fileName;
				//echo $location;
			}


	    $data = array('id' => $maxImagesId,
	            'adsId'=> $newId,
	            'location' => $location
	          );
	    echo $db->insert($table,$data);
	  }else{ echo "<h3>Failed! </h3>"; }

	} else {
	echo "Failed to Upload : ".$fileError;
	}
	//table Log
	$date = date('Y-m-d H:i:s');
	$table = "log";
	$logCode = "addAds-".$newId;
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
	echo $db->insert($table,$data)."<br>";

	header('location:../index.php?modul=activeAds');
?>
