<?php
include("../include/config.php"); {
    $q = "SELECT  DISTINCT (artist.name), album.name, artist.id, album.id AS albumid, album.image, album.onorder, album.dateordered, artist.name AS artistname, album.trackingnum, album.presale from album, artist where album.artist_id = artist.id And album.onorder LIKE '1' order by dateordered, artist.name, album.name";
    $wanted = mysqli_query($sql, $q);
}
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>On Order</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="center">
    <br>
    <h1>On Order</h1>
    <div class="container mt-5">
        <div class="row mt-4">
            <?php
            while ($qq = mysqli_fetch_array($wanted)) {
            ?>
                <?php $ordered = $qq['dateordered'] ?>
                <?php $tracking = $qq['trackingnum'] ?>
                <?php $presale = $qq['presale'] ?>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body1">
                            <h5 class="card-title">Title: <?php echo $qq['name']; ?></h5>
                            <h6 class="card-title">Artist: <?php echo $qq['artistname']; ?></h6>
                            <h5 class="card-title"><img src="<?php echo $qq['image']; ?>" alt="<?php echo $qq['id']; ?>" style="width:98%;"></h5>
                            <h6 class="card-title"><b>Date Ordered: </b><?php echo $ordered; ?></h6>
                            <?php if ($tracking > '0') { ?>
                                <h6 class="card-title"><b>Tracking: </b>
                                    <a href="<?php echo $tracking; ?>" target="_blank"><img src="../images/site.png" style="height:50px;"><br> </a>
                                <?php } ?>
                            <?php if ($presale > '0') {
                                ?>
                                <h6 class="card-title"><b>Release Date: </b><?php echo $presale; ?></h6>
                                <?php } ?>                                
                                <br><input type="button" onclick="window.location='editalbum.php?id=<?php echo $qq['albumid']; ?>'" class="Redirect" value="Click Here To Edit" />

                        </div>
                    </div><br>
                </div>
            <?php } ?>
            <br>
        </div>
    </div>
</body>

</html>