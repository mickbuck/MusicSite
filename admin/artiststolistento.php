<?php
include("../include/config.php"); {
    $q = "SELECT (artist.name), artist.id, artist.Image, artist.rating FROM artist LEFT JOIN album ON album.artist_id = artist.id WHERE album.artist_id IS NULL and artist.name NOT LIKE '' order by UPPER(LTRIM(Replace(artist.name, 'The ', '')))";
    $query = mysqli_query($sql, $q);
}
?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>My Music by Artists</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <br>
    <h1>My Music by Artists</h1>

    <div class="container mt-5">
        <div class="row mt-4">
            <?php
            while ($qq = mysqli_fetch_array($query)) {
            ?>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body1">
                            <?php $qid = $qq['id'] ?>
                            <h5 class="card-title"><?php echo $qq['name']; ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Rating:
                            <?php echo $qq['rating']; ?>
                            </h6>
                            <h5 class="card-title">
                                <a href="../byartist.php?id=<?php echo $qq['id']; ?>"> <img src="<?php echo $qq['Image']; ?>" alt="<?php echo $qq['name']; ?>" style="width:98%;"></a>
                            </h5>
                        </div>
                    </div><br>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>
</html>