<html>
<head>
	<meta http-equiv="Content-Type"
		content="text/html; charset=UTF-8">
	<title>Add Artist</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<div class="container mt-5">
		<h1>Add New Artist</h1>
		<form action="add.php" method="POST">
			<div class="form-group">
				<label>Artist name</label>
				<input type="text"
					class="form-control"
					placeholder="Artist name"
					name="artna" />
			</div>

			<div class="form-group">
				<label>Artist MusicBrainz Link</Link></label>
				<input type="text"
					class="form-control"
					placeholder="Artist MusicBrainz Link"
					name="artmb" />
			</div>

			<div class="form-group">
				<label>Artist Image Link</Link></label>
				<input type="text"
					class="form-control"
					placeholder="Artist Image Link"
					name="artim" />
			</div>

			<div class="form-group">
				<input type="submit"
					value="Add"
					class="btn btn-danger"
					name="btn">
			</div>
		</form>
	</div>

	<?php
		if(isset($_POST["btn"])) {
			include("include/config.php");
			$artna=$_POST['artna'];
			$artim=$_POST['artim'];
			$artmb=$_POST['artmb'];
			$q="INSERT INTO artist (name,MusicBrainz,Image) VALUES ('$artna','$artmb','$artim')";

			mysqli_query($sql,$q);
		}
	?>
</body>

</html>
