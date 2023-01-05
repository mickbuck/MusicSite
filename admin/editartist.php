<?php
    include("../include/config.php");
	{
		$id = ($_GET["id"]);
        $q= "SELECT * FROM artist Where id = $id;";
        $artistname=mysqli_query($sql,$q); 
    }


   if(isset($_POST['update']))
	{
        $id = ($_GET["id"]);
		#From Table to SQL
		$name = mysqli_real_escape_string($sql,$_POST['title']);
        $musicbrainz = mysqli_real_escape_string($sql,$_POST['musicbrainz']);
        $image = mysqli_real_escape_string($sql,$_POST['image']);
        $website = mysqli_real_escape_string($sql,$_POST['website']);
        $banner = mysqli_real_escape_string($sql,$_POST['banner']);
        $clear = mysqli_real_escape_string($sql,$_POST['clear']);
        $sql_insert =  "UPDATE artist Set name = '$name', MusicBrainz = '$musicbrainz', Image = '$image', officalsite = '$website', clear = '$clear', banner = '$banner' where id = '$id'";
		
		if(mysqli_query($sql,$sql_insert))
		{
			echo '<script>alert("Artist updated successfully")</script>';
            $place = "editartist.php?id=$id"; 
            echo "<script>self.location='".$place."';</script>\n";
		}
	}

?>
-->

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $artname['name']; ?></title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
       <!--  <div class="container mt-5">
         <div class="row mt-4"> -->
        <?php $qq=mysqli_fetch_array($artistname) ?>
        <form method="POST">
            <h1 class="white">Edit Name</h1>
            <h2 class="white"><label>Artist Name :</label>
            <input type="text" name="title" value="<?php echo $qq['name'];?>"></h2>
            <!-- To update with pull down list -->
            <h2 class="white"><label>MusicBrainz:</label>
            <input type="text" name="musicbrainz" value="<?php echo $qq['MusicBrainz'];?>" style="width:500px" ></h2>
            <h2 class="white"><label>Website:</label>
            <input type="text" name="website" value="<?php echo $qq['officalsite'];?>" style="width:500px" ></h2>
            <table class="center">
                <tr>
                    <th><h2 class="white">Artist Thumb</h2></th>
                    <th><h2 class="white">Artist Banner</h2></th>
                    <th><h2 class="white">Artist Clear Art</h2></th>
                </tr>
                <tr>
                    <td><input type="text" name="image" value="<?php echo $qq['Image'];?>" style="width:250px" ></td>
                    <td><input type="text" name="banner" value="<?php echo $qq['banner'];?>" style="width:500px" ></td>
                    <td><input type="text" name="clear" value="<?php echo $qq['clear'];?>" style="width:500px" ></td>
                </tr>
                <tr>
                    <td><img src="<?php echo $qq['Image'];?>" alt="<?php echo $qq['name'];?>"></td>
                    <td><img src="<?php echo $qq['banner'];?>" style="width:500px"></td>
                    <td><img src="<?php echo $qq['clear'];?>" style="width:500px"></td>
                </tr>
            </table>                                                                
        <br><input type="submit" value="Update" name="update"></h2>
        </form>        
            <!-- </div> 
       </div>-->
       <br>
       <h2 class=tal><a href="javascript:history.back()">Back</a></h2>
</body>

</html>