<?php
include("../include/config.php"); {
    $id = ($_GET["id"]);
    $q = "SELECT * FROM artist Where id = $id;";
    $artistname = mysqli_query($sql, $q);
}

if (isset($_POST['update'])) {
    $id = ($_GET["id"]);
    #From Table to SQL
    $name = mysqli_real_escape_string($sql, $_POST['title']);
    $musicbrainz = mysqli_real_escape_string($sql, $_POST['musicbrainz']);
    $image = mysqli_real_escape_string($sql, $_POST['image']);
    $website = mysqli_real_escape_string($sql, $_POST['website']);
    $banner = mysqli_real_escape_string($sql, $_POST['banner']);
    $clear = mysqli_real_escape_string($sql, $_POST['clear']);
    $tolistento = mysqli_real_escape_string($sql, $_POST['tolistento']);
    $rating = mysqli_real_escape_string($sql, $_POST['rating']);
    $site = mysqli_real_escape_string($sql, $_POST['site']);
    $sql_insert =  "UPDATE artist Set name = '$name', MusicBrainz = '$musicbrainz', Image = '$image', officalsite = '$website', clear = '$clear', banner = '$banner', tolistento = '$tolistento', rating = '$rating', site = '$site' where id = '$id'";

    if (mysqli_query($sql, $sql_insert)) {
        echo '<script>alert("Artist updated successfully")</script>';
        $place = "editartist.php?id=$id";
        echo "<script>self.location='" . $place . "';</script>\n";
    }
}

?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo $artname['name']; ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="center">

    <?php $qq = mysqli_fetch_array($artistname) ?>
    <form method="POST">
        <h1 class="white">Edit Name</h1>
        <h2 class="white"><label>Artist Name :</label>
            <input type="text" name="title" value="<?php echo $qq['name']; ?>">
        </h2>
        <!-- To update with pull down list -->
        <h2 class="white"><label>MusicBrainz:</label>
            <input type="text" name="musicbrainz" value="<?php echo $qq['MusicBrainz']; ?>" style="width:500px">
        </h2>
        <h2 class="white"><label>Website:</label>
            <input type="text" name="website" value="<?php echo $qq['officalsite']; ?>" style="width:500px">
        </h2>
        <h2 class="white"><label>To Listen To:</label>
            <input type="number" max="1" min="0" name="tolistento" value="<?php echo $qq['tolistento']; ?>">
            <label>Rating (0-5):</label>
            <input type="number" max="9" min="0" name="rating" value="<?php echo $qq['rating']; ?>">
            <h2 class="white"><label>Random Site:</label>
            <input type="text" name="site" value="<?php echo $qq['site']; ?>" style="width:500px">
        </h2>   
        <table class="center">
            <tr>
                <th>
                    <h2 class="white">Artist Thumb</h2>
                </th>
                <th>
                    <h2 class="white">Artist Banner</h2>
                </th>
                <th>
                    <h2 class="white">Artist Clear Art</h2>
                </th>
            </tr>
            <tr>
                <td><input type="text" name="image" value="<?php echo $qq['Image']; ?>" style="width:98%;"></td>
                <td><input type="text" name="banner" value="<?php echo $qq['banner']; ?>" style="width:98%;"></td>
                <td><input type="text" name="clear" value="<?php echo $qq['clear']; ?>" style="width:98%;"></td>
            </tr>
            <tr>
            </form>
                <td><img src="<?php echo $qq['Image']; ?>" alt="<?php echo $qq['name']; ?>" style="width:98%;">
                    <form action="upload.php?id=<?php echo $qq['id']; ?>" method="post" enctype="multipart/form-data">
                    <h4 class="white">Select image to upload:<br>
                    <input type="file" name="bandupload" id="bandupload"><br>
                    <input type="submit" value="Upload Image" name="band"></h4>
                    </form>
                </td>
                <td><img src="<?php echo $qq['banner']; ?>" style="width:98%;">
                    </form>
                        <form action="upload.php?id=<?php echo $qq['id']; ?>" method="post" enctype="multipart/form-data">
                        <h4 class="white">Select image to upload:<br>
                        <input type="file" name="bannerupload" id="bannerupload"><br>
                        <input type="submit" value="Upload Image" name="banner"></h4>
                    </form>
                </td>
                
                <td><img src="<?php echo $qq['clear']; ?>" style="width:98%;">
                    </form>
                        <form action="upload.php?id=<?php echo $qq['id']; ?>" method="post" enctype="multipart/form-data">
                        <h4 class="white">Select image to upload:<br>
                        <input type="file" name="clearupload" id="clearupload"><br>
                        <input type="submit" value="Upload Image" name="clear"></h4>
                    </form>
                </td>
                 

            </tr>
        </table>
        <br><input type="submit" value="Update" name="update"></h2>
    </form>
    <br>
    <h2 class=tal><a href="javascript:history.back()">Back</a></h2>
</body>

</html>