<?php
    include("include/config.php");
	{
		$id = ($_GET["id"]); ?>
		<?php
        $q = "SELECT  DISTINCT (artist.name), album.name, artist.id, album.image, album.onorder, album.dateordered from album, artist where album.artist_id = artist.id And album.onorder LIKE '1' order by UPPER(LTRIM(Replace(artist.name, 'The ', '')))";
        $wanted=mysqli_query($sql,$q); 
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
             <?php $ordered = $qq['dateordered'] ?>

                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body1">
                                <h5 class="card-title"><?php echo $qq['name']; ?></h5>                             
                                <h5 class="card-title"><img src="<?php echo $qq['image'];?>" alt="<?php echo $qq['id'];?>" style="width:200px;height:200px;"></h5>
                                <h6 class="card-title"><b>Date Ordered: </b><?php echo $ordered; ?></h6>
                         </div>
                      </div><br>
                </div>
                <?php } ?>
                <br>
            </div>
        </div>
    </body>
</html>