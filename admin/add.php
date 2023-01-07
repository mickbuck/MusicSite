<?php
// Setting up PHP/MY SQL Connection
include("../include/config.php"); {
	$id = ($_GET["id"]); ?>
<?php
	$q = "SELECT * from artist order by UPPER(LTRIM(Replace(artist.name, 'The ', '')))";
}
$wanted = mysqli_query($sql, $q);
if (isset($_POST['wanted'])) {
	$name = mysqli_real_escape_string($sql, $_POST['Album']);
	$id = mysqli_real_escape_string($sql, $_POST['Artist']);
	$sql_insert =  "INSERT INTO wanted (album, artist_id) VALUES ('$name','$id')";
	if (mysqli_query($sql, $sql_insert)) {
		echo '<script>alert("Product added successfully")</script>';
	}
}
if (isset($_POST['artist'])) {
	$artist = mysqli_real_escape_string($sql, $_POST['Art']);
	$sql_insert =  "INSERT INTO artist (name) VALUES ('$artist')";
	if (mysqli_query($sql, $sql_insert)) {
		echo '<script>alert("Artist added successfully")</script>';
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Add To Database</title>
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
	<!-- Adding Wanted Album to DB -->
	<form method="POST">
		<h1 class="white">Add New Wanted Album</h1>
		<h2 class="white"><label>Name of Album:</label></h2>
		<input type="text" name="Album" required>
		<h2 class="white"><label>Select a Artist</label></h2>
		<select name="Artist">
			<?php
			while ($data = mysqli_fetch_array($wanted, MYSQLI_ASSOC)) :;
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
		<br>
		<input type="submit" value="submit" name="wanted">
	</form>
	<!-- Adding new Artists to DB -->
	<form method="POST">
		<h1 class="white">Add New Artist</h1>
		<h2 class="white"><label>Artist name:</label></h2>
		<input type="text" class="form-control" placeholder="Artist name" name="Art" />
		<div class="form-group">
			<input type="submit" value="submit" class="btn btn-danger" name="artist">
		</div>
	</form>
	<br>
</body>
</html>