<?php
// Setting up PHP/MY SQL Connection
include("../include/config.php"); {
	$id = ($_GET["id"]); ?>
<?php
	# $q = "SELECT * from artist order by UPPER(LTRIM(Replace(artist.name, 'The ', '')))";
}
if (isset($_POST['artist'])) {
	$artist = mysqli_real_escape_string($sql, $_POST['Art']);
	$tolisten = mysqli_real_escape_string($sql, $_POST['tolisten']);
	$site = mysqli_real_escape_string($sql, $_POST['site']);
	if ($tolisten != '1') {
		$tolisten = '0';
	}
	$listenorder = mysqli_real_escape_string($sql, $_POST['listenorder']);
	if ($listenorder != '1') {
		$listenorder = '0';
	}
	$sql_insert =  "INSERT IGNORE INTO artist (name,tolistento,listenorder,site) VALUES ('$artist','$tolisten','$site')";
	#if (
        mysqli_query($sql, $sql_insert);#) {
        $sql_get = "Select id from artist where name like '$artist'";
        $artistid = mysqli_query($sql, $sql_get);
        $qq = mysqli_fetch_array($artistid);
        $newid = $qq['id'];
    #}
    $url='editartist.php?id=';

    echo '<script>window.location = "'.$url.$newid.'";</script>';
	#}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Add New Artist To Database</title>
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
	<!-- Adding new Artists to DB -->
	<form method="POST">
		<h1 class="white">Add New Artist</h1>
		<h2 class="white"><label>Artist name:</label>
		<input type="text" class="form-control" placeholder="Artist name" name="Art" /><br>
		<label>To Listen To:</label> 
		<input type="checkbox" name="tolisten" value="1"><br>
		<h2 class="white"><label>Random Site:</label>
        <input type="text" class="form-control" placeholder="Random site" name="site" style="width:500px">
		<div class="form-group">
		<input type="submit" value="submit" class="btn btn-danger" name="artist">
		</div>
	</form>
	<br>
</body>
</html>