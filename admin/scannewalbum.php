<?php
// Setting up PHP/MY SQL Connection
include("../include/config.php"); {
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
		<h2 class="white"><label>Barcode:</label>
		<input type="number" name="Barcode" required><br>
		<label>Enter Cost:</label>
			<input type="number" step="any" name="cost">
		</h2>
		<h2 class="white"><label>Date Ordered:</label>
			<input type="date" name="dateordered" value="<?php echo date('Y-m-d'); ?>"> <br>
		</h2>
		<h2><input type="submit" value="submit" name="album"></h2><br>
	</form>