<?php
include("../include/config.php"); {
    $id = ($_GET["id"]);
    $sql_insert =  "UPDATE artist Set Image = '$image' where id = '$id'";
}

$target_dir = "../images/" . "$id" . "/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$target_file = $target_dir . "band." . $imageFileType;

$uploadOk = 1;


// Check if image file is a actual image or fake image
if(isset($_POST["thumb"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $target_file . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

//Check file size
 if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
   echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
   $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
 if ($uploadOk == 0) {
   echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
 } else {
   if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

    $band = str_replace("../","https://mymusic.mickbuck.com/","$target_file");
    $sql_insert =  "UPDATE artist Set Image = '$band' where id = '$id'";
    if (mysqli_query($sql, $sql_insert)) {
     echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    }
   } else {
    echo "Sorry, there was an error uploading your file.";
   }
 }
?>