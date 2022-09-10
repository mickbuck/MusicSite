<?php
    include("include/config.php");
    if (isset($_POST['btn']))
    {
      $date=$_POST['idate'];
      $q="SELECT * FROM album order by UPPER(LTRIM(Replace(name, 'The', '')));";
      $query=mysqli_query($sql,$q);
    } 
	else 
	{
        //$id = (int)$_GET['id'];$path = parse_url($url, PHP_URL_PATH);
        //$pathFragments = explode('/', $path);
        //$end = end($pathFragments);
		$id = ($_GET["id"]); ?>
		<?php
        $q= "SELECT * FROM album Where artist_id = $id order by UPPER(LTRIM(Replace(name, 'The', '')));";
      
      // $q= "SELECT * FROM album order by artist_id;";
     $query=mysqli_query($sql,$q);
    }
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Albums</title>
        <link rel="stylesheet" href="css/bootstrap.min.css"> 
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <h1>Albums</h1>
        <a href="addalbum.php">Add New album</a>
        <div class="container mt-5"> 
            <div class="row mt-4">
            <h5 class="card-title"><?php echo $qq['name']; ?></h5>     
             <?php
                  while ($qq=mysqli_fetch_array($query)) 
                  {
             ?>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <?php  
                                $qart = $qq['artist_id'];
                            ?>
                            <?php $art = "SELECT name FROM artist WHERE id='$qart'"; 
                                  $artist=mysqli_query($sql,$art); ?>
                            <?php 
                                  while ($arts=mysqli_fetch_array($artist)) 
                                  {
                                    ?>

                                    <h5 class="card-title"><?php echo $qq['name']; ?></h5>      
                                    <h6 class="card-title"><?php echo $arts['name']; ?></h6>
                            <?php 
                                  }  
                            ?>
                            <h5 class="card-title"><img src="<?php echo $qq['image'];?>" alt="<?php echo $qq['id'];?>" style="width:200px;height:200px;"></h5>
			                <br>
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
