<?php
include("../include/config.php"); {
    $id = ($_GET["id"]);
}
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo $artname['name']; ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<?php

$target_dir = "../images/" . "$id" . "/";
$band_file = $target_dir . basename($_FILES["bandupload"]["name"]);
$banner_file = $target_dir . basename($_FILES["bannerupload"]["name"]);
$clear_file = $target_dir . basename($_FILES["clearupload"]["name"]);
$bandFileType = strtolower(pathinfo($band_file,PATHINFO_EXTENSION));
$bannerFileType = strtolower(pathinfo($banner_file,PATHINFO_EXTENSION));
$clearFileType = strtolower(pathinfo($clear_file,PATHINFO_EXTENSION));
$band_file = $target_dir . "band." . $bandFileType;
$banner_file = $target_dir . "banner." . $bannerFileType;
$clear_file = $target_dir . "clear." . $clearFileType;
$uploadOk = 1;


// Check if image file is a actual image or fake image
if(isset($_POST["band"])) {
  $check = getimagesize($_FILES["bandupload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $band_file . ".";
    $uploadOk = 1;
    $band = 1;
  } else {
    echo "File is not an image.";
   $uploadOk = 0;
  }
} 
if(isset($_POST["banner"])) {
    $check = getimagesize($_FILES["bannerupload"]["tmp_name"]);
    if($check !== false) {
      echo "File is an image - " . $banner_file . ".";
      $uploadOk = 1;
      $banner = 1;
    } else {
      echo "File is not an image.";
     $uploadOk = 0;
    }
  } 
  if(isset($_POST["clear"])) {
    $check = getimagesize($_FILES["clearupload"]["tmp_name"]);
    if($check !== false) {
      echo "File is an image - " . $clear_file . ".";
      $uploadOk = 1;
      $clear = 1;
    } else {
      echo "File is not an image.";
     $uploadOk = 0;
    }
  } 



// Check if file already exists
if (file_exists($band_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}
if (file_exists($banner_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }
  if (file_exists($clear_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }

//Check file size
 if ($_FILES["bandupload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}
if ($_FILES["bannerupload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
if ($_FILES["clearupload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }

// Allow certain file formats
if($bandFileType != "jpg" && $bandFileType != "png" && $bandFileType != "jpeg"
&& $bandFileType != "gif" && $bannerFileType != "jpg" && $bannerFileType != "png" && $bannerFileType != "jpeg"
&& $bannerFileType != "gif" && $clearFileType != "jpg" && $clearFileType != "png" && $clearFileType != "jpeg"
&& $clearFileType != "gif") {
   echo nl2br ("  
   Sorry, \n  only JPG, JPEG, PNG & GIF files are allowed.");
   $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($band == '1'){
 if ($uploadOk == 0) {
   echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
 } else {
   if (move_uploaded_file($_FILES["bandupload"]["tmp_name"], $band_file)) {
 //fileToUpload
    $band = str_replace("../","https://mymusic.mickbuck.com/","$band_file");
    $band_insert =  "UPDATE artist Set Image = '$band' where id = '$id'";
    if (mysqli_query($sql, $band_insert)) {
     echo "The file ". htmlspecialchars( basename( $_FILES["bandupload"]["name"])). " has been uploaded.";
    }
   } else {
    echo "Sorry, there was an error uploading your file.";
   }
 }
}

if ($banner == '1'){
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
   // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["bannerupload"]["tmp_name"], $banner_file)) {
    //fileToUpload
       $banner = str_replace("../","https://mymusic.mickbuck.com/","$banner_file");
       $banner_insert =  "UPDATE artist Set banner = '$banner' where id = '$id'";
       if (mysqli_query($sql, $banner_insert)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["bannerupload"]["name"])). " has been uploaded.";
       }
      } else {
       echo "Sorry, there was an error uploading your file.";
      }
    }
   }

   if ($clear == '1'){
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
   // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["clearupload"]["tmp_name"], $clear_file)) {
    //fileToUpload
       $clear = str_replace("../","https://mymusic.mickbuck.com/","$clear_file");
       $clear_insert =  "UPDATE artist Set clear = '$clear' where id = '$id'";
       if (mysqli_query($sql, $clear_insert)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["clearupload"]["name"])). " has been uploaded.";
       }
      } else {
       echo "Sorry, there was an error uploading your file.";
      }
    }
   }
?>
<h2 class=tal><a href="javascript:history.back()">Back</a></h2>