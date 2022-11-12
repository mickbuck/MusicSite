<?php
    include("../include/config.php");
	{
		$id = ($_GET["id"]); ?>
		<?php
        $q= "SELECT  * from wanted, artist where wanted.artist_id = artist.id and purchased not like '1' order by UPPER(LTRIM(Replace(wanted.album, 'The ', '')))";
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
                                <h5 class="card-title"><?php echo $qq['album']; ?></h5>
                                <h6 class="card-title"><?php echo $qq['name']; ?></h6>
                                <h5 class="card-title"><img src="../<?php echo $qq['image'];?>" alt="<?php echo $qq['id'];?>" style="width:200px;height:200px;"></h5>
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
