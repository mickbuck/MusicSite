<?php
include("../include/config.php"); {
    $q = "SELECT (artist.name), artist.id, artist.Image, artist.rating, artist.site, artist.onlardarr, artist.officalsite, artist.youtube, artist.facebook, artist.instagram, artist.spotify, artist.divas, artist.wikipedia, artist.linktr, artist.musicarc, artist.bandcamp FROM artist LEFT JOIN album ON album.artist_id = artist.id WHERE album.artist_id IS NULL and artist.name NOT LIKE '' order by UPPER(LTRIM(Replace(artist.name, 'The ', '')))";
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
                                <?php 
                                    if ($officalsite > '0') {
                                        ?><a href="<?php echo $qq['officalsite']; ?>" target="_blank"><img src="../images/site.png" style="height:75px;"></a>
                                        <?php
                                    }
                                    if (str_contains($qq['youtube'], 'youtube')) {
                                        ?><a href="<?php echo $qq['youtube']; ?>" target="_blank"><img src="../images/youtube.png" style="height:75px;"></a>
                                        <?php
                                    }
                                    if (str_contains($qq['facebook'], 'facebook')) {
                                        ?><a href="<?php echo $qq['facebook']; ?>" target="_blank"><img src="../images/facebook.png" style="height:75px;"></a>
                                        <?php
                                    }
                                    if (str_contains($qq['instagram'], 'instagram')) {
                                        ?><a href="<?php echo $qq['instagram']; ?>" target="_blank"><img src="../images/instagram.png" style="height:75px;"></a>
                                    <?php
                                    }
                                    if (str_contains($qq ['spotify'], 'spotify')) {
                                        ?><a href="<?php echo $qq ['spotify']; ?>" target="_blank"><img src="../images/spotify.png" style="height:75px;"></a>
                                    <?php
                                    }
                                    if (str_contains($qq ['divas'], 'divas')) {
                                        ?><a href="<?php echo $qq ['divas']; ?>" target="_blank"><img src="../images/dark-divas.jpg" style="height:75px;"></a>
                                    <?php
                                    }
                                    if (str_contains($qq ['wikipedia'], 'wikipedia')) {
                                        ?><a href="<?php echo $qq ['wikipedia']; ?>" target="_blank"><img src="../images/wikipedia.png" style="height:75px;"></a>
                                    <?php
                                    }
                                    if (str_contains($qq ['linktr'], 'linktr')) {
                                        ?><a href="<?php echo $qq ['linktr']; ?>" target="_blank"><img src="../images/linktr.png" style="height:75px;"></a>
                                    <?php
                                    }
                                    if (str_contains($qq ['musicarc'], 'metal-archives')) {
                                        ?><a href="<?php echo $qq ['musicarc']; ?>" target="_blank"><img src="../images/metal-archives.png" style="height:75px;"></a>
                                    <?php
                                    }
                                    if (str_contains($qq ['bandcamp'], 'bandcamp')) {
                                        ?><a href="<?php echo $qq ['bandcamp']; ?>" target="_blank"><img src="../images/bandcamp.png" style="height:75px;"></a>
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