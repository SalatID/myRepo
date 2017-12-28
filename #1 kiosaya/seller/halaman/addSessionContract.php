<?php
  session_start();
  include_once '../../ecommerce/lib/config.php';
  include_once '../../lib/config.php';
  $config = isset ($_POST['config']) ? $_POST['config'] : null;
  $dataSession = array();
  if (!is_null($config)) {
    if ($config == 'config') {
      $dbe = new $config();
      $adsId = $_POST['adsId'];
      $table = 'ads';
      $field = 'id as adsId,title, categoryId,subCategoryId,redirectLink';
      $on = '';
      $where = 'id='.$adsId;
      $group ='';
      $dbe->select($table,$field,$on,$where,$group);
      $result = $dbe->getResult();
      $decode = json_decode($result,true);
      //print_r($decode);
      $rowAds = $decode['post'];
      $menu = 'recAds';
    } elseif ($config == 'configEcom') {
      $dbe = new $config();
      $adsId = $_POST['adsId'];
      $table = 'ads';
      $field = 'id as catalogueId,title, categoryId,subCategoryId, description';
      $on = '';
      $where = 'id='.$adsId;
      $group ='';
      $dbe->select($table,$field,$on,$where,$group);
      $result = $dbe->getResult();
      $decode = json_decode($result,true);
      //print_r($decode);
      $rowAds = $decode['post'];
      $menu = 'catalog';
      foreach ($rowAds as $keyAds => $valueAds) {
        $table = 'images';
        $field = 'id as imagesId,adsId,location';
        $on = '';
        $where = 'adsId='.$adsId;
        $group ='';
        $dbe->select($table,$field,$on,$where,$group);
        $result = $dbe->getResult();
        $decode = json_decode($result,true);
        $arrayImages = $decode['post'][0];
        print_r($arrayImages);
      }
    }
    foreach ($rowAds as $keyAds => $valueAds) {
      foreach ($valueAds as $lastKey => $lastValue) {
        $dataSession [$lastKey] = $lastValue;
        $dataSession['menu']=$menu;
      }
      $dataSession['images']=$arrayImages;
    }
    if(isset($_SESSION['contract'])){
      array_push($_SESSION['contract'],$dataSession);
    }
    else{
      $_SESSION['contract'] = [];
      array_push($_SESSION['contract'],$dataSession);
    }
  } else {
    if (isset($_SESSION['contract'])) {
      foreach ($_SESSION['contract'] as $keyCtr => $valueCtr) {
        $newAdsId=$valueCtr['newAdsid'];
      }
    }else {
      $newAdsId = '0';
    }
    $newAdsId++;
    $title = $_POST['title'];
    $category = $_POST['category'];
    $subCategory = $_POST['subcategory'];
    $redirectLink = $_POST['redirectLink'];
    $description = $_POST['description'];
    $images = $_FILES['media'];
    $dataSession['newAdsid']=$newAdsId;
    $dataSession['title']=$title;
    $dataSession['categoryId']=$category;
    $dataSession['subCategoryId']=$subCategory;
    $dataSession['redirectLink']=$redirectLink;
    $dataSession['description']=$description;
    $dataSession['menu']='newAds';
    $dataSession['images']=$images;
    if ($dataSession['images']==$_FILES['media']) {
      $db = new config ();
      $table = "images";
      $field = "max(id) as maxId";
      $where = "";
      $on = "";
      $location = $_POST['location'];
      $db->select($table,$field,$on,$where);
      $result = $db->getResult();
      $decode = json_decode($result, true);
      $maxImagesId = $decode['post'][0]['maxId'];
      $maxImagesId++;
      $rand = "-".rand(10,1000);
      $timeUpl = date('his');
      $table = "images";
      $temp = explode(".", $_FILES["media"]["name"]);
      $fileName = $timeUpl.$rand.".".$temp[1];
      //echo $fileName;
      $targetDir = "../../images/";
      $targetFile = $targetDir . $fileName;//get the file name

      $fileSize = $_FILES['media']['size']; //get the size
      $fileError = $_FILES['media']['error']; //get the error when upload
      if($fileSize > 0 || $fileError == 0){ //check if the file is corrupt or error
        $move = move_uploaded_file($_FILES['media']['tmp_name'],$targetFile); //save image to the folder
        if($move){
          $sources = $targetDir.$fileName;
          //echo $sources;
          $fileSize = getimagesize($sources);
          $width = $fileSize[0];
          $height = $fileSize[1];
          if ($width > 400 || $height > 400 ) {
            if ($width > $height) {
              if ($width > 400) {
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
            }
          }
            if ($temp[1] == 'jpg' || $temp[1] == 'JPG') {
              $original = imagecreatefromjpeg($sources);
            } elseif ($temp[1] == 'png' || $temp[1] == 'PNG') {
              $original = imagecreatefrompng($sources);
            } elseif ($temp[1] == 'gif') {
              $original = imagecreatefromgif($sources);
            }
            $images = imagecreatetruecolor($newWidth,$newHeight);
            imagecopyresampled($images, $original, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagejpeg($images, $sources );
            $location = $fileName;
            imagedestroy($original);
            imagedestroy($images);
          } else {
            $location = $fileName;
            //echo $location;
          }
          $data = array('id' => $maxImagesId,
                  'adsId'=> 0,
                  'location' => $location
                );
          $result = $db->insert($table,$data);
          if ($result) {
            $dataSession['images']=$maxImagesId;
          if(isset($_SESSION['contract'])){
            array_push($_SESSION['contract'],$dataSession);
          }else{
            $_SESSION['contract'] = [];
            array_push($_SESSION['contract'],$dataSession);
          }
          }
        }else{ echo "<h3>Failed! </h3>"; }

      } else {
      echo "Failed to Upload : ".$fileError;
      }
    }else {
      if(isset($_SESSION['contract'])){
        array_push($_SESSION['contract'],$dataSession);
      }
      else{
        $_SESSION['contract'] = [];
        array_push($_SESSION['contract'],$dataSession);
      }
    }
    header('location: ../index.php?modul=newContract');
  }

 ?>
