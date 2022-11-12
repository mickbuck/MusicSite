<?php
// Setting up PHP/MY SQL Connection
include("../include/config.php");
    {
		$id = ($_GET["id"]); ?>
		<?php
        $q= "SELECT * from artist order by UPPER(LTRIM(Replace(artist.name, 'The ', '')))";
		$f= "SELECT * from media";
		$l= "SELECT * from record_label order by UPPER(LTRIM(Replace(record_label.name, 'The ', '')))";
    }
        $wanted = mysqli_query($sql,$q);
		$format = mysqli_query($sql,$f);
		$label = mysqli_query($sql,$l);

	if(isset($_POST['album']))
	{
		#From Table to SQL
		$name = mysqli_real_escape_string($sql,$_POST['Album']);
		$artid = mysqli_real_escape_string($sql,$_POST['Artist']);
		$formatid = mysqli_real_escape_string($sql,$_POST['media']);
		$cost = mysqli_real_escape_string($sql,$_POST['cost']);
		$record = mysqli_real_escape_string($sql,$_POST['record']);
		$catno = mysqli_real_escape_string($sql,$_POST['Cat']);
		$year = mysqli_real_escape_string($sql,$_POST['year']);
		$sql_insert =  "INSERT INTO album (name, artist_id,format,cost,record_label_id,cat_number,year) VALUES ('$name','$artid','$formatid','$cost','$record','$catno','$year')";
		
		if(mysqli_query($sql,$sql_insert))
		{
			echo '<script>alert("Product added successfully")</script>';
		}
	}
    if(isset($_POST['artist']))
	{
        $artist = mysqli_real_escape_string($sql,$_POST['Art']);
		$sql_insert =  "INSERT INTO artist (name) VALUES ('$artist')";
		if(mysqli_query($sql,$sql_insert))
		{
			echo '<script>alert("Artist added successfully")</script>';
		}
	}
?>



<!--this is the display -->
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add To Database</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<!-- Adding Wanted Album to DB -->
    <form method="POST">
        <h1 class="white">Add New Album</h1>
        <h2 class="white"><label>Name of Album:</label></h2>
		<input type="text" name="Album" required>
		<h2 class="white"><label>Select a Artist:</label></h2>
		<select name="Artist">
			<?php
				while ($data = mysqli_fetch_array($wanted,MYSQLI_ASSOC)):;
			?>
				<option value="<?php echo $data["id"];
				?>">
					<?php echo $data["name"];
					?>
				</option>
			<?php
				endwhile;
			?>
		</select>
		
		<h2 class="white"><label>Enter Format and Album Catalogue Number:</label></h2>
		<select name="media">
			<?php
				while ($media = mysqli_fetch_array($format,MYSQLI_ASSOC)):;
			?>
				<option value="<?php echo $media["id"];
				?>">
					<?php echo $media["format"];
					?>
				</option>
			<?php
				endwhile;
			?>
		</select>

			<input type="text" name="Cat">
			<h2 class="white"><label>Select Record Label:</label></h2>
			<select name="record">
			<?php
				while ($record = mysqli_fetch_array($label,MYSQLI_ASSOC)):;
			?>
				<option value="<?php echo $record["id"];?>">
					<?php echo $record["name"];
					?><br>
				</option>
			<?php
				endwhile;
			?>
			</select>
		<br>
	<h2 class="white"><label>Enter Year:</label></h2>
	<input type="number" min="1900" max="2099" name="year">
	

	<h2 class="white"><label>Enter Cost:</label></h2>
	<input type="text" name="cost">

	<h2><input type="submit" value="submit" name="album"></h2><br>
	</form>