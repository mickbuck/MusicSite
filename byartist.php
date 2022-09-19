<?php
    include("include/config.php");
	{
		$id = ($_GET["id"]); ?>
		<?php
        $q= "SELECT * FROM album Where artist_id = $id order by UPPER(LTRIM(Replace(name, 'The', '')));";
        $albumname=mysqli_query($sql,$q); 
        $a= "SELECT * FROM artist Where id = $id order by UPPER(LTRIM(Replace(name, 'The', '')));";
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
        <link rel="stylesheet" href="css/bootstrap.min.css"> 
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <br>
        <h1><?php echo $artname['name']; ?></h1>
        <h2><a href=<?php echo $artname['MusicBrainz'] ; ?> target="_blank">Music Brainz</a></h2>
        <div class="container mt-5"> 
            <div class="row mt-4">
             <?php
                  while ($qq=mysqli_fetch_array($albumname)) 
                  {
             ?>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
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
                                    <h6 class="card-title"><?php echo $arts['name']; ?></h6>                             
                                    <h5 class="card-title"><img src="<?php echo $qq['image'];?>" alt="<?php echo $qq['id'];?>" style="width:200px;height:200px;"></h5>
                                    <br>
                                    <h6>Catalogue Number:</h6> <h7 class="card-title"><?php echo $qq['cat_number']; ?></h7><br><br>
                                    <?php $lab = "SELECT * FROM record_label WHERE id='$lart'"; 
                                        $label=mysqli_query($sql,$lab); 
                                        $labs=mysqli_fetch_array($label)?>
                                    <h6>Record Label:</h6> <h7 class="card-title"><?php echo $labs['name'] ; ?></h7>   
                                     
                                    <?php 
                                  }  
                            ?> 
                        </div>
                      </div>
                </div>
                <?php
                  }
                ?>
                <?php } 
                ?>
            </div>
       </div>
    </body>
</html>