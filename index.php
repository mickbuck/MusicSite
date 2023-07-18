<?php
    include("include/config.php");
	{
    $q = "SELECT  DISTINCT (artist.name), artist.id, artist.Image from album, artist where album.artist_id = artist.id AND (album.wanted IS NULL OR album.wanted < '1') AND (album.format IS > '0') order by UPPER(LTRIM(Replace(artist.name, 'The ', '')))";
    $query=mysqli_query($sql,$q);
    }
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>My Music by Artists</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <br>
        <h1>My Music by Artists</h1>
        
        <div class="container mt-5"> 
            <div class="row mt-4">
             <?php
                  while ($qq=mysqli_fetch_array($query)) 
                  {
             ?>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body1">
                             <?php $qid = $qq['id'] ?>
                                <?php $t = "SELECT * from album WHERE artist_id=$qid AND (wanted IS NULL OR wanted != '1') ";
                                $cd = "SELECT * from album WHERE artist_id=$qid AND (onorder IS NULL OR onorder != '1')  AND (wanted IS NULL OR wanted != '1') AND FORMAT = '1'";
                                $vinyl = "SELECT * from album WHERE artist_id=$qid AND (onorder IS NULL OR onorder != '1')  AND (wanted IS NULL OR wanted != '1') AND FORMAT = '2'";
                                $order = "SELECT * from album WHERE artist_id=$qid AND onorder = '1'";
                                ?>
                            <h5 class="card-title"><?php echo $qq['name']; ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Total: 
                            <?php if ($result = mysqli_query($sql, $t)) {
                                $rowcount = mysqli_num_rows( $result );
                                printf("  %d\n", $rowcount);
                             } ?>
                             <br>  CD: <?php if ($result = mysqli_query($sql, $cd)) {
                                $rowcount = mysqli_num_rows( $result );
                                printf("  %d\n", $rowcount);
                             } ?>  Vinyl: <?php if ($result = mysqli_query($sql, $vinyl)) {
                                $rowcount = mysqli_num_rows( $result );
                                printf("  %d\n", $rowcount);
                             } ?>  
                             <?php if ($result = mysqli_query($sql, $order)) {
                                $rowcount = mysqli_num_rows( $result );
                                
                             
                             If ($rowcount > '0') { ?>
                             On Order: <?php printf("  %d\n", $rowcount);
                             } 
                            }
                            ?></h6>
    	        	        <h5 class="card-title">
                                <a href="byartist.php?id=<?php echo $qq['id'];?>"> <img src="<?php echo $qq['Image'];?>" alt="<?php echo $qq['name'];?>" style="width:200px;height:200px;"></a>
                            </h5>
                        </div>
                      </div><br>
                </div>
                <?php
                  }
                ?>
            </div>
       </div>
    </body>
</html>