<?php
    include("include/config.php");
	{
      $q= "SELECT * FROM artist order by UPPER(LTRIM(Replace(name, 'The', '')));";
      $query=mysqli_query($sql,$q);
    }
?>
</style>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>My Music by Artists</title>
        <!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
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
                             <?php  
                                $qid = $qq['id'] ?>
                            <?php $t = "SELECT * from album WHERE artist_id=$qid";
                                 $cd = "SELECT * from album WHERE artist_id=$qid AND format = '1'";
                                 $vinyl = "SELECT * from album WHERE artist_id=$qid AND format = '2'";
                            ?>
                            <h5 class="card-title"><?php echo $qq['name']; ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Total: 
                            <?php if ($result = mysqli_query($sql, $t)) {
                                $rowcount = mysqli_num_rows( $result );
                                printf("  %d\n", $rowcount);
                             } ?>  CD: <?php if ($result = mysqli_query($sql, $cd)) {
                                $rowcount = mysqli_num_rows( $result );
                                printf("  %d\n", $rowcount);
                             } ?>  Vinyl: <?php if ($result = mysqli_query($sql, $vinyl)) {
                                $rowcount = mysqli_num_rows( $result );
                                printf("  %d\n", $rowcount);
                             } ?></h6>
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
       <!--  <a href="add.php">Add New Artist</a> --> 
    </body>
</html>


