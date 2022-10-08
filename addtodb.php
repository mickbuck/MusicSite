<?php
// Setting up PHP/MY SQL Connection
include("include/config.php");
    {
		$id = ($_GET["id"]); ?>
		<?php
        $q= "SELECT * from artist order by UPPER(LTRIM(Replace(artist.name, 'The', '')))";
    }
    $wanted = mysqli_query($sql,$q);
	if(isset($_POST['submit']))
	{
		// Store the Product name in a "name" variable
		$name = mysqli_real_escape_string($sql,$_POST['Album']);
		//echo $name;
		// Store the Category ID in a "id" variable
		 $id = mysqli_real_escape_string($sql,$_POST['Artist']);
		
		// Creating an insert query using SQL syntax and
		// storing it in a variable.
	    $sql_insert =  "INSERT INTO wanted (album, artist_id) VALUES ('$name','$id')";
		// The following code attempts to execute the SQL query
		// if the query executes with no errors
		// a javascript alert message is displayed
		// which says the data is inserted successfully
		if(mysqli_query($sql,$sql_insert))
		{
			echo '<script>alert("Product added successfully")</script>';
		}
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add To Database</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
	<form method="POST">
        <h2 class="white"><label>Name of Album:</label></h2>
		<input type="text" name="Album" required>
		<h2 class="white"><label>Select a Artist</label></h2>
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
		<br>
		<input type="submit" value="submit" name="submit">
	</form>
	<br>
</body>
</html>
