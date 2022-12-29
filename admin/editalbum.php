<?php
    include("../include/config.php");
	{
		$id = ($_GET["id"]);
        $q= "SELECT * FROM album Where id = $id;";
        $albumname=mysqli_query($sql,$q); 
    }

    if(isset($_POST['update']))
	{
        $id = ($_GET["id"]);
		#From Table to SQL
		$name = mysqli_real_escape_string($sql,$_POST['title']);
        $format = mysqli_real_escape_string($sql,$_POST['format']);
        $cat = mysqli_real_escape_string($sql,$_POST['cat']);
        $year = mysqli_real_escape_string($sql,$_POST['year']);
        $discogs = mysqli_real_escape_string($sql,$_POST['discogs']);
        $image = mysqli_real_escape_string($sql,$_POST['image']);
        $dateordered = mysqli_real_escape_string($sql,$_POST['dateordered']);
        $onorder = mysqli_real_escape_string($sql,$_POST['onorder']);
        $cost = mysqli_real_escape_string($sql,$_POST['cost']);
        $tracking = mysqli_real_escape_string($sql,$_POST['tracking']);
        $wanted = mysqli_real_escape_string($sql,$_POST['wanted']);

        $sql_insert =  "UPDATE album Set name = '$name', format = '$format', cat_number = '$cat', year = $year, discogs = '$discogs',  onorder = $onorder, cost = $cost, trackingnum = '$tracking', wanted = $wanted where id = '$id'";
		
		if(mysqli_query($sql,$sql_insert))
		{
			echo '<script>alert("Product added successfully")</script>';
		}
	}

?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $artname['name']; ?></title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <div class="container mt-5">
        <div class="row mt-4">
        <?php $qq=mysqli_fetch_array($albumname) ?>
        <form method="POST">
            <h1 class="white">Edit Album</h1>
            <h2 class="white"><label>Album Name :</label>
            <input type="text" name="title" value="<?php echo $qq['name'];?>"></h2>
            <!-- To update with pull down list -->
            <h2 class="white"><label>Format:</label>
            <input type="text" name="format" value="<?php echo $qq['format'];?>" ></h2>
            <h2 class="white"><label>Album Catalogue Number:</label>
            <input type="text" name="cat" value="<?php echo $qq['cat_number'];?>" ></h2>
            <h2 class="white"><label>Year:</label>
            <input type="number" min="0000" max="2099" name="year" value="<?php echo $qq['year'];?>" ></h2>
            <h2 class="white"><label>Discogs:</label>
            <input type="text" name="discogs" value="<?php echo $qq['discogs'];?>" ></h2>
            <h2 class="white"><label>Image:</label>
            <input type="text" name="image" value="<?php echo $qq['image'];?>" ></h2>
            <h2 class="white"><label>Date Ordered (To Fix):</label>
            <input type="date" name="dateordered" value="<?php echo $qq['dateordered'];?>"></h2>
            <h2 class="white"><label>On Ordered:</label>
            <input type="text" name="onorder" value="<?php echo $qq['onorder'];?>"></h2>
            <h2 class="white"><label>Cost:</label>
            <input type="number" step="any" name="cost" value="<?php echo $qq['cost'];?>"></h2>
            <h2 class="white"><label>Tracking:</label>
            <input type="text" name="tracking" value="<?php echo $qq['trackingnum'];?>"></h2>
            <h2 class="white"><label>Wanted:</label>
            <input type="text" name="wanted" value="<?php echo $qq['wanted'];?>"> </h2>
            <br><h2><input type="submit" value="Update" name="update"></h2>
        </form>        
            </div>
       </div>
       <h2 class=tal><a href="javascript:history.back()">Back</a></h2>
</body>

</html>