<?php
    include("include/config.php");
	{
		$id = ($_GET["id"]); ?>
		<?php
        $q= "SELECT * FROM album Where artist_id = $id order by UPPER(LTRIM(Replace(name, 'The ', '')));";
        $albumname=mysqli_query($sql,$q); 
        $a= "SELECT * FROM artist Where id = $id order by UPPER(LTRIM(Replace(name, 'The ', '')));";
        $artistname=mysqli_query($sql,$a);      
    }
?>
<html>

    <?php 
    while ($artname=mysqli_fetch_array($artistname)) 
            { ?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $artname['name']; ?></title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
    <style> body {
        background-image: url('<?php echo $artname['clear']; ?>');
        background-repeat: no-repeat;
        background-position: right bottom;
        }
    </style>
        <br>
        <h1><img src="<?php echo $artname['banner'];?>" alt="" > </h1>
        
        <div class="container mt-5"> 
            <div class="row mt-4">
             <?php
                  while ($qq=mysqli_fetch_array($albumname)) 
                  {
             ?>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body2">
                            <?php  
                                $qart = $qq['artist_id'];
                                $lart = $qq['record_label_id'];
                            ?>
                            <?php $art = "SELECT * FROM artist WHERE id='$qart'"; 
                                  $artist=mysqli_query($sql,$art); ?>
                            <?php 
                                  while ($arts=mysqli_fetch_array($artist)) 
                                  {
                            ?>
                                    <h5 class="card-title"><?php echo $qq['name']; ?></h5>
                                    <img src="<?php echo $qq['image'];?>" alt="<?php echo $qq['id'];?>" style="width:200px;height:200px;"></h6>
                                    <b>Catalogue Number: <br></b><?php echo $qq['cat_number']; ?>
                                    <?php $lab = "SELECT * FROM record_label WHERE id='$lart'"; 
                                        $label=mysqli_query($sql,$lab); 
                                        $labs=mysqli_fetch_array($label)?><br>

                                    <?php $onorder = $qq['onorder'];
                                    if ($onorder > '0') {
                                        ?><b>On Order: </b>Yes <br>
                                        <b>Date Ordered: </b><?php echo $qq['dateordered'];?> 
                                        <?php
                                        }
                                    ?>
                                    <b>Record Label: <br></b><?php echo $labs['name'] ; ?></h6> <br>
                                    <?php $discogs = $qq['discogs'];
                                    if ($discogs > '0') {
                                        ?><br><a href="<?php echo $qq['discogs'];?>" target="_blank"><img src="images/discogs.png" style="height:50px;"></a><br>
                                        <?php
                                        }
                                    ?>
                                    <?php 
                                  }
                            ?> 
                        </div>
                      </div><br>
                </div>
                <?php
                  }
                ?>
                
            </div>
       </div>
       <h2 class=tal><a href="../">Back</a></h2><h2><a href="<?php echo $artname['MusicBrainz'] ; ?>" target="_blank"><img src="https://wiki.musicbrainz.org/images/a/a7/MusicBrainz_logo_135x135.png?e9e85" style="width:50px;height:50px;"></a></h2>
       <?php } 
                ?>
</body>

</html>