<?php
include("../include/config.php"); {
    $q = "SELECT (artist.name), artist.id, artist.Image, artist.rating, artist.site, artist.onlardarr, artist.officalsite FROM artist LEFT JOIN album ON album.artist_id = artist.id WHERE album.artist_id IS NULL and artist.name NOT LIKE '' order by UPPER(LTRIM(Replace(artist.name, 'The ', '')))";
    $query = mysqli_query($sql, $q);
}
?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>My Music by Artists</title>
    <link rel="stylesheet" href="../css/stylenew.css">
</head>

<body class="center">
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
                            <h5><?php echo $qq['name']; ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Rating:
                            <?php echo $qq['rating']; ?>
                            </h6>
                            <h5 class="card-title">
                            <a href="../byartist.php?id=<?php echo $qq['id']; ?>"> <img src="<?php echo $qq['Image']; ?>" alt="<?php echo $qq['name']; ?>" style="width:98%;"></a>
                            <?php $other = $qq['site'] ?>
                            <?php $lidarr = $qq['onladarr'] ?>
                            <?php $officalsite = $qq['officalsite'] ?>
                            
                            <?php if ($lidarr > '0') { ?>
                                <h6 class="card-title"><b>On Lidarr: </b>
                                    <?php echo $tracking; ?><img src="emojis/tick.png" style="height:25px;"><br>
                                <?php } ?>
                                <?php if ($lidarr == '0') { ?>
                                <h6 class="card-title"><b>On Lidarr: </b>
                                    <?php echo $tracking; ?><img src="emojis/cross.png" style="height:25px;"><br>
                                <?php } ?>
                                <?php if ($officalsite > '0') {
                                ?><a href="<?php echo $qq['officalsite']; ?>" target="_blank"><img src="../images/site.png" style="height:100px;"></a>
                                <?php
                                } ?>
                                <?php if ($other > '0') {
                                    if (str_contains($other, 'youtube')) {
                                ?><a href="<?php echo $qq['site']; ?>" target="_blank"><img src="../images/youtube.png" style="height:100px;"></a>
                                    <?php
                                    }
                                }
                                if (str_contains($other, 'facebook')) {
                                    ?><a href="<?php echo $qq['site']; ?>" target="_blank"><img src="../images/facebook.png" style="height:25%;"></a>
                                <?php
                                }
                                if (str_contains($other, 'instagram')) {
                                    ?><a href="<?php echo $qq['site']; ?>" target="_blank"><img src="../images/instagram.png" style="height:100px;"></a>
                                <?php
                                }
                                if (str_contains($other, 'spotify')) {
                                    ?><a href="<?php echo $qq['site']; ?>" target="_blank"><img src="../images/spotify.png" style="height:100px;"></a>
                                <?php
                                }
                                if (str_contains($other, 'divas')) {
                                    ?><a href="<?php echo $qq['site']; ?>" target="_blank"><img src="../images/dark-divas.png" style="height:100px;"></a>
                                <?php
                                }
                                if (str_contains($other, 'wikipedia')) {
                                    ?><a href="<?php echo $qq['site']; ?>" target="_blank"><img src="../images/wikipedia.png" style="height:100px;"></a>
                                <?php
                                }
                                if (str_contains($other, 'linktr')) {
                                    ?><a href="<?php echo $qq['site']; ?>" target="_blank"><img src="../images/linktr.png" style="height:100px;"></a>
                                <?php
                                }
                                if (str_contains($other, 'archives')) {
                                    ?><a href="<?php echo $qq['site']; ?>" target="_blank"><img src="../images/metal-archives.png" style="height:100px;"></a>
                                <?php
                                }
                                if (str_contains($other, 'bandcamp')) {
                                    ?><a href="<?php echo $qq['site']; ?>" target="_blank"><img src="../images/bandcamp.png" style="height:100px;"></a>
                                <?php
                                }
                                ?>
                            
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