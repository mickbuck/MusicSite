<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Setting up PHP/MY SQL Connection
include("../include/config.php"); {

	$q = "SELECT * from artist order by UPPER(LTRIM(Replace(artist.name, 'The ', '')))";
	$f = "SELECT * from media";
	$l = "SELECT * from record_label order by UPPER(LTRIM(Replace(record_label.name, 'The ', '')))";
    $aon = "SELECT * from customers";
    
    $aoname = mysqli_query($sql, $aon);
}
$wanted = mysqli_query($sql, $q);
$format = mysqli_query($sql, $f);
$label = mysqli_query($sql, $l);
if (isset($_POST['album'])) {
	#From Table to SQL
	$name = mysqli_real_escape_string($sql, $_POST['Album']);
	$artid = mysqli_real_escape_string($sql, $_POST['Artist']);
	$formatid = mysqli_real_escape_string($sql, $_POST['media']);
	$cost = mysqli_real_escape_string($sql, $_POST['cost']);
	if ($cost <= '0.01') {
		$cost = '0.00';
	}
	$record = mysqli_real_escape_string($sql, $_POST['record']);
	if ($record <= '1') {
		$record = '55';
	}
	$catno = mysqli_real_escape_string($sql, $_POST['Cat']);
	$year = mysqli_real_escape_string($sql, $_POST['year']);
	if ($year <= '1990') {
		$year = '0000';
	}
    $onorder = isset($_POST['onorder']) ? mysqli_real_escape_string($sql, $_POST['onorder']) : 0;
    $wanted = isset($_POST['wanted']) ? mysqli_real_escape_string($sql, $_POST['wanted']) : 0;
    $owner = mysqli_real_escape_string($sql, $_POST['Owner']);
	$dateordered = mysqli_real_escape_string($sql, $_POST['dateordered']);
	$dateordered = date('Y-m-d', strtotime(str_replace('-', '/', $dateordered)));
	$sql_insert =  "INSERT INTO album (name, artist_id, format, cat_number, year, record_label_id, onorder, cost, wanted, dateordered) 
                VALUES ('$name','$artid','$formatid','$catno','$year',$record,$onorder,$cost,$wanted,'$dateordered')";

$sql_get = "SELECT id FROM album WHERE artist_id = '$artid' AND name LIKE '$name' AND dateordered LIKE '$dateordered'";

if (mysqli_query($sql, $sql_insert)) {
    $result = mysqli_query($sql, $sql_get);
    if ($row = mysqli_fetch_assoc($result)) {
        $album_id = $row['id'];
        $sql_insetown = "INSERT INTO album_owner (album_owner, album_id) VALUES ('$owner', '$album_id')";
        mysqli_query($sql, $sql_insetown);
        echo '<script>
            alert("Product added successfully");
            window.location.href = window.location.href;
        </script>';
    } else {
        echo '<script>alert("Album ID not found")</script>';
    }
} else {
    echo '<script>alert("Album insert failed")</script>';
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
		<h2 class="white"><label>Enter Format and Album Catalogue Number:</label></h2>
		<select name="media">
			<?php
			while ($media = mysqli_fetch_array($format, MYSQLI_ASSOC)) :;
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
		<h2 class="white"><label>Select Record Label:</label>
			<select name="record">
				<?php
				while ($record = mysqli_fetch_array($label, MYSQLI_ASSOC)) :;
				?>
					<option value="<?php echo $record["id"]; ?>">
						<?php echo $record["name"];
						?><br>
					</option>
				<?php
				endwhile;
				?>
			</select>
		</h2>
		<h2 class="white"><label>Enter Year:</label>
			<input type="number" min="1950" max="2099" name="year">
		</h2>
		<h2 class="white"><label>Enter Cost:</label>
			<input type="number" step="any" name="cost">
		</h2>
		<h2 class="white"><label>Date Ordered:</label>
			<input type="date" name="dateordered" value="<?php echo date('Y-m-d'); ?>"> <br>
			<label>On Order:</label>
			<input type="checkbox" name="onorder" value="1"><br>
			<label>Wanted:</label>
			<input type="checkbox" name="wanted" value="1"><br>
            <label>Owner:</label>
        <select name="Owner">
			<?php
			while ($data = mysqli_fetch_array($aoname, MYSQLI_ASSOC)) :;
			?>
				<option value="<?php echo $data["customer_id"];
								?>">
					<?php echo $data["name"];
					?>
				</option>
			<?php
			endwhile;
			?>
		</select>
        </h2>
		<h2><input type="submit" value="submit" name="album"></h2><br>
	</form>