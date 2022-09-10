<?php include('include/config.php'); ?>
<html>
	<head>
	<Title>Music Database</Title>
	</head>
	<Body>
	<?php
	$query = mysqli_query($sql, "SELECT * FROM artist WHERE name like 'Spiritbox'");
	while($row = mysqli_fetch_assoc($query))
	{
	$content = $row['name'];
	}?>
	<h1>My Physical Media</h1>
	<p><?php echo $content; ?></p>
	</Body>
</html>
