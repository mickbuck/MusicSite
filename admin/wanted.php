<?php
    include("include/config.php");
	{
		$id = ($_GET["id"]); ?>
		<?php
        $q= "SELECT  artist.id, album.id AS albumid, album.name AS albumname, artist.name AS artistname, album.image from album, artist where album.artist_id = artist.id and album.onorder not like '1' and wanted like '1' order by UPPER(LTRIM(Replace(album.name, 'The ', '')))";
        $wanted=mysqli_query($sql,$q);
    }
?>


<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Wanted Media</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <br>
        <h1>Wanted Media</h1>
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
                                <br><input type="button" onclick="window.location='admin/editalbum.php?id=<?php echo $qq['albumid'];?>'" class="Redirect" value="Click Here To Edit"/>
                                <?php
                            ?>
                        </div>
                      </div><br>
                </div>
                <?php } ?>
                <br>
            </div>
        </div>
    </body>
</html>