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
    $facebook = mysqli_real_escape_string($sql, $_POST['facebook']);
    $youtube = mysqli_real_escape_string($sql, $_POST['youtube']);
    $instagram = mysqli_real_escape_string($sql, $_POST['instagram']);
    $spotify = mysqli_real_escape_string($sql, $_POST['spotify']);
    $divas = mysqli_real_escape_string($sql, $_POST['divas']);
    $wikipedia = mysqli_real_escape_string($sql, $_POST['wikipedia']);
    $linktr = mysqli_real_escape_string($sql, $_POST['linktr']);
    $musicarc = mysqli_real_escape_string($sql, $_POST['musicarc']);
    $bandcamp = mysqli_real_escape_string($sql, $_POST['bandcamp']);

    $sql_insert =  "UPDATE artist Set name = '$name', MusicBrainz = '$musicbrainz', Image = '$image', officalsite = '$website', clear = '$clear', banner = '$banner', tolistento = '$tolistento', rating = '$rating', site = '$site', facebook = '$facebook', youtube = '$youtube', instagram = '$instagram', spotify = '$spotify', divas = '$divas', wikipedia = '$wikipedia', linktr = '$linktr', musicarc = '$musicarc', bandcamp = '$bandcamp' where id = '$id'";

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
            <h2 class="white"><label>Facebook:</label>
            <input type="text" name="facebook" value="<?php echo $qq['facebook']; ?>" style="width:500px">
            <h2 class="white"><label>Youtube:</label>
            <input type="text" name="youtube" value="<?php echo $qq['youtube']; ?>" style="width:500px">
            <h2 class="white"><label>Spotify:</label>
            <input type="text" name="spotify" value="<?php echo $qq['spotify']; ?>" style="width:500px">
            <h2 class="white"><label>Instagram:</label>
            <input type="text" name="instagram" value="<?php echo $qq['instagram']; ?>" style="width:500px">
            <h2 class="white"><label>Divas:</label>
            <input type="text" name="divas" value="<?php echo $qq['divas']; ?>" style="width:500px">
            <h2 class="white"><label>Wikipedia:</label>
            <input type="text" name="wikipedia" value="<?php echo $qq['wikipedia']; ?>" style="width:500px">
            <h2 class="white"><label>Linktr:</label>
            <input type="text" name="linktr" value="<?php echo $qq['linktr']; ?>" style="width:500px">
            <h2 class="white"><label>metal-archives:</label>
            <input type="text" name="musicarc" value="<?php echo $qq['musicarc']; ?>" style="width:500px">
            <h2 class="white"><label>Bandcamp:</label>
            <input type="text" name="bandcamp" value="<?php echo $qq['bandcamp']; ?>" style="width:500px">
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