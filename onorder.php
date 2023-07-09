<?php
    include("include/config.php");
	{
		$id = ($_GET["id"]); ?>
		<?php
        $q = "SELECT  DISTINCT (artist.name), album.name, artist.id, album.id AS albumid, album.image, album.onorder, album.dateordered, album.trackingnum, album.presale from album, artist where album.artist_id = artist.id And album.onorder LIKE '1' order by dateordered, artist.name, album.name";
        $wanted = mysqli_query($sql, $q);
    }
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>On Order</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <br>
        <h1>On Order</h1>
        <div class="container mt-5">
            <div class="row mt-4">
            <?php
                  while ($qq=mysqli_fetch_array($wanted))
                  {
             ?>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body1">
                                <h5 class="card-title">Title: <?php echo $qq['albumname']; ?></h5>
                                <h6 class="card-title">Artist: <?php echo $qq['artistname']; ?></h6>
                                <h5 class="card-title"><img src="<?php echo $qq['image'];?>" alt="<?php echo $qq['albumid'];?>" style="width:200px;height:200px;"></h5>
                        </div>
                      </div><br>
                </div>
                <?php } ?>
                <br>
            </div>
        </div>
    </body>
</html>