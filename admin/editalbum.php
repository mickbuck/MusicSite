<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include("../include/config.php"); {
    $id = ($_GET["id"]);
    $q = "SELECT * FROM album Where id = $id;";
    $ao = "SELECT * from album_owner where album_id = $id;";
    $aon = "SELECT * from customers";
    $albumname = mysqli_query($sql, $q);
    $aowner = mysqli_query($sql, $ao);
    $aoname = mysqli_query($sql, $aon);
}
if (isset($_POST['update'])) {
    $id = ($_GET["id"]);
    #From Table to SQL
    $name = mysqli_real_escape_string($sql, $_POST['title']);
    $format = mysqli_real_escape_string($sql, $_POST['format']);
    $cat = mysqli_real_escape_string($sql, $_POST['cat']);
    $year = mysqli_real_escape_string($sql, $_POST['year']);
    $discogs = mysqli_real_escape_string($sql, $_POST['discogs']);
    $image = mysqli_real_escape_string($sql, $_POST['image']);
    $dateordered = mysqli_real_escape_string($sql, $_POST['dateordered']);
    $dateordered = date('Y-m-d', strtotime(str_replace('-', '/', $dateordered)));
    $onorder = mysqli_real_escape_string($sql, $_POST['onorder']);
    $cost = mysqli_real_escape_string($sql, $_POST['cost']);
    $tracking = mysqli_real_escape_string($sql, $_POST['tracking']);
    $wanted = mysqli_real_escape_string($sql, $_POST['wanted']);
    $barcode = mysqli_real_escape_string($sql, $_POST['barcode']);
    $recordlabel = mysqli_real_escape_string($sql, $_POST['recordlabel']);
    $owner = mysqli_real_escape_string($sql, $_POST['owner']);
    $sql_updateowner = "UPDATE album_owner Set album_owner = $owner where album_id = '$id'";
    $sql_insert =  "UPDATE album Set name = '$name', format = '$format', cat_number = '$cat', image = '$image', dateordered = '$dateordered', year = '$year', discogs = '$discogs',  onorder = '$onorder', cost = '$cost', trackingnum = '$tracking', wanted = '$wanted', barcode = '$barcode', record_label_id = '$recordlabel' where id = '$id'";
    if (mysqli_query($sql, $sql_insert)) {
        if (mysqli_query($sql, $sql_updateowner)) {
        echo '<script>alert("Album updated successfully")</script>';
        $place = "editalbum.php?id=$id"; // replace, duh.
        echo "<script>self.location='" . $place . "';</script>\n";
        }
    }
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Edit Album</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="center">
    <div class="container mt-5">
        <div class="row mt-4">
            <?php $qq = mysqli_fetch_array($albumname) ?>
            <?php $oq = mysqli_fetch_array($aowner) ?>
                <form method="POST">
                <h1 class="white">Edit Album</h1>
                <h2 class="white"><label>Album Name :</label>
                    <input type="text" name="title" value="<?php echo $qq['name']; ?>">
                </h2>
                <!-- To update with pull down list -->
                <h2 class="white"><label>Format:</label>
                    <input type="text" name="format" value="<?php echo $qq['format']; ?>">
                </h2>
                <h2 class="white"><label>Album Catalogue Number:</label>
                    <input type="text" name="cat" value="<?php echo $qq['cat_number']; ?>">
                </h2>
                <h2 class="white"><label>Year:</label>
                    <input type="number" min="0000" max="2099" name="year" value="<?php echo $qq['year']; ?>">
                </h2>
                <h2 class="white"><label>Record Label:</label>
                    <input type="number" name="recordlabel" value="<?php echo $qq['record_label_id']; ?>">
                </h2>
                <h2 class="white"><label>Discogs:</label>
                    <input type="text" name="discogs" value="<?php echo $qq['discogs']; ?>">
                </h2>
                <h2 class="white"><label>Image:</label>
                    <input type="text" name="image" value="<?php echo $qq['image']; ?>"> <br>
                    <img src="<?php echo $qq['image'];?>" style="width:250px;">
                </h2>
                <h2 class="white"><label>Date Ordered:</label>
                    <input type="date" name="dateordered" value="<?php echo $qq['dateordered']; ?>">
                </h2>
                <h2 class="white"><label>On Ordered:</label>
                    <input type="text" name="onorder" value="<?php echo $qq['onorder']; ?>">
                </h2>
                <h2 class="white"><label>Cost:</label>
                    <input type="number" step="any" name="cost" value="<?php echo $qq['cost']; ?>">
                </h2>
                <h2 class="white"><label>Tracking:</label>
                    <input type="text" name="tracking" value="<?php echo $qq['trackingnum']; ?>">
                </h2>
                <h2 class="white"><label>Wanted:</label>
                    <input type="text" name="wanted" value="<?php echo $qq['wanted']; ?>">
                </h2>
                <h2 class="white"><label>Bar Code:</label>
                    <input type="text" name="barcode" value="<?php echo $qq['barcode']; ?>">
                </h2>
                <h2 class="white"><label>Owner:</label>
                    <input type="text" name="owner" value="<?php echo $oq['album_owner']; ?>">
                </h2>
                <br>
                <h2><input type="submit" value="Update" name="update"></h2>
            </form>
        </div>
    </div>
    <h2 class=tal><a href="javascript:history.back()">Back</a></h2>
</body>
</html>