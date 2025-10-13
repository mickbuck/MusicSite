<?php header('Content-Type: text/html; charset=utf-8'); ?>

<?php
include("../include/config.php"); {
    $q = "SELECT * from artist WHERE tolistento = '1' AND (rating = '9') AND id > 1919 ORDER BY RAND(), UPPER(LTRIM(Replace(name, 'The ', ''))) LIMIT 1;";
    $query = mysqli_query($sql, $q);
}
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>My Music by Artists</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="center">
    <br>
    <h1>My Music by Artists</h1>
    <div class="container mt-5">
        <div class="row mt-4">

            <?php
            while ($qq = mysqli_fetch_array($query)) {
            ?>
            <?php $lidarr = isset($_POST['onlidarr']) ? (int)$_POST['onlidarr'] : 0?>
            <?php $officalsite = $qq['officalsite'] ?>
            <?php $other = $qq['site'] ?>
                <div class="col-md-1 offset-md-1
                        text-center bg-success">
                    <div class="card">
                        <div class="card-body2">
                            <?php $qid = $qq['id'] ?>
                            <h5 class="card-title"><?php echo $qq['name']; ?>
                                <a href="../byartist.php?id=<?php echo $qq['id']; ?>">
                                <img src="<?php echo $qq['Image']; ?>" alt="<?php echo $qq['name']; ?>" style="width:98%;"> <br></a>
                                <?php if ($lidarr > '0') { ?>
                                <h6 class="card-title"><b>On Lidarr: </b>
                                    <img src="emojis/tick.png" style="height:25px;"><br>
                                <?php } ?>
                                <?php if ($lidarr == '0') { ?>
                                <h6 class="card-title"><b>On Lidarr: </b>
                                    <img src="emojis/cross.png" style="height:25px;"><br>
                                <?php } ?>
                                <?php 
                                    if ($officalsite > '0') {
                                        ?><a href="<?php echo $qq['officalsite']; ?>" target="_blank"><img src="../images/site.png" style="height:75px;"></a>
                                        <?php
                                    }
                                    if (!empty($qq['youtube']) && str_contains($qq['youtube'], 'youtube')) {
                                        ?><a href="<?php echo $qq['youtube']; ?>" target="_blank"><img src="../images/youtube.png" style="height:75px;"></a>
                                        <?php
                                    }
                                    if (!empty($qq['facebook']) && str_contains($qq['facebook'], 'facebook')) {
                                        ?><a href="<?php echo $qq['facebook']; ?>" target="_blank"><img src="../images/facebook.png" style="height:75px;"></a>
                                        <?php
                                    }
                                    if (!empty($qq['instagram']) && str_contains($qq['instagram'], 'instagram')) {
                                        ?><a href="<?php echo $qq['instagram']; ?>" target="_blank"><img src="../images/instagram.png" style="height:75px;"></a>
                                    <?php
                                    }
                                    if (!empty($qq['spotify']) && str_contains($qq ['spotify'], 'spotify')) {
                                        ?><a href="<?php echo $qq ['spotify']; ?>" target="_blank"><img src="../images/spotify.png" style="height:75px;"></a>
                                    <?php
                                    }
                                    if (!empty($qq['divas']) && str_contains($qq ['divas'], 'divas')) {
                                        ?><a href="<?php echo $qq ['divas']; ?>" target="_blank"><img src="../images/dark-divas.jpg" style="height:75px;"></a>
                                    <?php
                                    }
                                    if (!empty($qq['wikipedia']) && str_contains($qq ['wikipedia'], 'wikipedia')) {
                                        ?><a href="<?php echo $qq ['wikipedia']; ?>" target="_blank"><img src="../images/wikipedia.png" style="height:75px;"></a>
                                    <?php
                                    }
                                    if (!empty($qq['linktr']) && str_contains($qq ['linktr'], 'linktr')) {
                                        ?><a href="<?php echo $qq ['linktr']; ?>" target="_blank"><img src="../images/linktr.png" style="height:75px;"></a>
                                    <?php
                                    }
                                    if (!empty($qq['twitter']) && str_contains($qq['twitter'], 'twitter')) {
                                        ?><a href="<?php echo $qq ['twiiter']; ?>" target="_blank"><img src="../images/twitter.png" style="height:75px;"></a>
                                    <?php
                                    }
                                    if (!empty($qq['twitter']) && str_contains($qq['twitter'], 'x.com')) {
                                        ?><a href="<?php echo $qq ['twitter']; ?>" target="_blank"><img src="../images/twitter.png" style="height:75px;"></a>
                                    <?php
                                    }
                                    if (!empty($qq['musicarc']) && str_contains($qq ['musicarc'], 'metal-archives')) {
                                        ?><a href="<?php echo $qq ['musicarc']; ?>" target="_blank"><img src="../images/metal-archives.png" style="height:75px;"></a>
                                    <?php
                                    }
                                    if (!empty($qq['bandcamp']) && str_contains($qq ['bandcamp'], 'bandcamp')) {
                                        ?><a href="<?php echo $qq ['bandcamp']; ?>" target="_blank"><img src="../images/bandcamp.png" style="height:75px;"></a>
                                    <?php
                                    }

                                ?> 
                                <br><input type="button" onclick="window.location='editartist.php?id=<?php echo $qq['id']; ?>'" class="Redirect" value="Click Here To Edit"  />
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