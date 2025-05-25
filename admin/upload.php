<?php
include("../include/config.php");
$id = $_GET["id"] ?? null;

$band = $banner = $clear = 0;
$uploadOk = 1;

$target_dir = "../images/" . $id . "/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true); // create directory if missing
}

// Band
if (isset($_FILES["bandupload"]) && $_FILES["bandupload"]["error"] === 0) {
    $bandFileType = strtolower(pathinfo($_FILES["bandupload"]["name"], PATHINFO_EXTENSION));
    $band_file = $target_dir . "band." . $bandFileType;

    $check = getimagesize($_FILES["bandupload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $band_file . ".";
        if ($_FILES["bandupload"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if (file_exists($band_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        if (!in_array($bandFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        if ($uploadOk) {
            if (move_uploaded_file($_FILES["bandupload"]["tmp_name"], $band_file)) {
                resizeImage($band_file, 300, 300);
                $band = str_replace("../", "https://mymusic.mickbuck.com/", $band_file);
                $band_insert = "UPDATE artist SET Image = '$band' WHERE id = '$id'";
                mysqli_query($sql, $band_insert);
                echo "The band file has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading the band file.";
            }
        }
    } else {
        echo "File is not an image.";
    }
}

// Banner
if (isset($_FILES["bannerupload"]) && $_FILES["bannerupload"]["error"] === 0) {
    $bannerFileType = strtolower(pathinfo($_FILES["bannerupload"]["name"], PATHINFO_EXTENSION));
    $banner_file = $target_dir . "banner." . $bannerFileType;

    $check = getimagesize($_FILES["bannerupload"]["tmp_name"]);
    if ($check !== false) {
        if ($_FILES["bannerupload"]["size"] > 500000 || file_exists($banner_file) || !in_array($bannerFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "Sorry, banner file failed checks.";
        } else {
            if (move_uploaded_file($_FILES["bannerupload"]["tmp_name"], $banner_file)) {
                resizeImage($banner_file, 300, 300);
                $banner = str_replace("../", "https://mymusic.mickbuck.com/", $banner_file);
                $banner_insert = "UPDATE artist SET banner = '$banner' WHERE id = '$id'";
                mysqli_query($sql, $banner_insert);
                echo "The banner file has been uploaded.";
            }
        }
    }
}

// Clear
if (isset($_FILES["clearupload"]) && $_FILES["clearupload"]["error"] === 0) {
    $clearFileType = strtolower(pathinfo($_FILES["clearupload"]["name"], PATHINFO_EXTENSION));
    $clear_file = $target_dir . "clear." . $clearFileType;

    $check = getimagesize($_FILES["clearupload"]["tmp_name"]);
    if ($check !== false) {
        if ($_FILES["clearupload"]["size"] > 500000 || file_exists($clear_file) || !in_array($clearFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "Sorry, clear file failed checks.";
        } else {
            if (move_uploaded_file($_FILES["clearupload"]["tmp_name"], $clear_file)) {
                resizeImage($clear_file, 300, 300);
                $clear = str_replace("../", "https://mymusic.mickbuck.com/", $clear_file);
                $clear_insert = "UPDATE artist SET clear = '$clear' WHERE id = '$id'";
                mysqli_query($sql, $clear_insert);
                echo "The clear file has been uploaded.";
            }
        }
    }
}

// Resize function
function resizeImage($file, $width, $height) {
    list($originalWidth, $originalHeight, $type) = getimagesize($file);
    switch ($type) {
        case IMAGETYPE_JPEG: $src = imagecreatefromjpeg($file); break;
        case IMAGETYPE_PNG:  $src = imagecreatefrompng($file);  break;
        case IMAGETYPE_GIF:  $src = imagecreatefromgif($file);  break;
        default: return false;
    }
    $dst = imagecreatetruecolor($width, $height);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);
    switch ($type) {
        case IMAGETYPE_JPEG: imagejpeg($dst, $file); break;
        case IMAGETYPE_PNG:  imagepng($dst, $file);  break;
        case IMAGETYPE_GIF:  imagegif($dst, $file);  break;
    }
    imagedestroy($src);
    imagedestroy($dst);
}
?>
<h2 class=tal><a href="javascript:history.back()">Back</a></h2>
