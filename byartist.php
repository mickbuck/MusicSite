<?php
include("include/config.php"); {
    $id = ($_GET["id"]);
    $q = "SELECT * FROM album Where artist_id = $id AND (wanted IS NULL OR wanted != '1') AND album.format > '0' AND (album.sold NOT LIKE '1' OR album.sold IS NULL) order by UPPER(LTRIM(Replace(name, 'The ', '')));";
    $albumname = mysqli_query($sql, $q);
    $a = "SELECT * FROM artist Where id = $id order by UPPER(LTRIM(Replace(name, 'The ', '')));";
    $artistname = mysqli_query($sql, $a);
}
?>
<html>

<?php
$mb = "";
while ($artname = mysqli_fetch_array($artistname)) { ?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $artname['name']; ?></title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body class="center">
        <style>
            body {
                background-image: url('<?php echo $artname['clear']; ?>');
                background-repeat: no-repeat;
                background-position: right bottom;
            }
        </style>
        <h1><img src="<?php echo $artname['banner']; ?>" alt=""> </h1>
        <?php $banner = $artname['banner'];
        if ($banner < '0') { ?>
            <h1><b><?php echo $artname['name']; ?></b> </h1>
        <?php
        }
        ?>
        <div class="container mt-5">
            <div class="row mt-4">
                <?php
                while ($qq = mysqli_fetch_array($albumname)) {
                ?>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body2">
                                <?php
                                $qart = $qq['artist_id'];
                                $lart = $qq['record_label_id'];
                                $wart = isset($qq['officesite']) ? $qq['officesite'] : null;
                                $trademe = isset($qq['ontrademe']) ? $qq['ontrademe'] : null;
                                ?>
                                <?php $art = "SELECT * FROM artist WHERE id='$qart'";
                                $artist = mysqli_query($sql, $art); ?>
                                <?php
                                while ($arts = mysqli_fetch_array($artist)) {
                                ?>
                                    <h5 class="card-title"><?php echo $qq['name']; ?></h5>
                                    <img src="<?php echo $qq['image']; ?>" alt="<?php echo $qq['id']; ?>" style="width:98%;"></h6>
                                    <b>Catalogue Number: <br></b><?php echo $qq['cat_number']; ?><br>
                                    <?php
                                    $formats = $qq['format'];
                                    if ($formats == '1') { ?>
                                        <b>Format: </b> CD
                                    <?php
                                    }
                                    if ($formats == '2') { ?>
                                        <b>Format:</b> Vinyl
                                    <?php
                                    }
                                    if ($formats == '3') { ?>
                                        <b>Format:</b> DVD
                                    <?php
                                    }
                                    if ($formats == '4') { ?>
                                        <b>Format:</b> USB
                                    <?php
                                    }
                                    ?>
                                    <?php $lab = "SELECT * FROM record_label WHERE id='$lart'";
                                    $label = mysqli_query($sql, $lab);
                                    $labs = mysqli_fetch_array($label) ?><br>

                                    <?php $onorder = $qq['onorder'];
                                    if ($onorder > '0') {
                                    ?><b>On Order: </b>Yes <br>
                                        <b>Date Ordered: </b><?php echo $qq['dateordered']; ?>
                                    <?php
                                    }
                                    ?>
                                    <?php $cost = $qq['cost'];
                                    if ($cost != '0' ) {
                                    ?><b>Cost: </b>$<?php echo $qq['cost']; ?><br>
                                    <?php
                                    }
                                    ?>
                                    <b>Record Label: <br></b><?php echo $labs['name']; ?></h6> <br>
                                    <b>
                                    <?php $trademe = $qq['ontrademe'];
                                    if ($trademe > '0') {
                                    ?><br><img src="images/trademe.png" style="height:50px;"></a><br>
                                    <?php
                                    }
                                    ?>
                                    </b>
                                    <?php $discogs = $qq['discogs'];
                                    if ($discogs > '0') {
                                    ?><br><a href="<?php echo $qq['discogs']; ?>" target="_blank"><img src="images/discogs.png" style="height:50px;"></a><br>
                                    <?php
                                    }
                                    ?>
                                <?php
                                }
                                ?>
                            </div>
                        </div><br>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        <h2><?php $site = $artname['officalsite'];
            $other = $artname['site'];
            if ($site > '0') {
            ?><a href="<?php echo $artname['officalsite']; ?>" target="_blank"><img src="images/site.png" style="height:75px;"></a>
            <?php
            } ?>

            <a href="<?php echo $artname['MusicBrainz']; ?>" target="_blank"><img src="https://wiki.musicbrainz.org/images/a/a7/MusicBrainz_logo_135x135.png?e9e85" style="width:100px;height:75px;"></a>
            <?php 
            if (isset($artname['youtube']) && str_contains($artname['youtube'], 'youtube')) {
                ?><a href="<?php echo $artname['youtube']; ?>" target="_blank"><img src="images/youtube.png" style="height:75px;"></a>
                <?php
            }
            if (isset($artname['facebook']) && str_contains($artname['facebook'], 'facebook')) {
                ?><a href="<?php echo $artname['facebook']; ?>" target="_blank"><img src="images/facebook.png" style="height:75px;"></a>
            <?php
            }
            if (isset($artname['instagram']) && str_contains($artname['instagram'], 'instagram')) {
                ?><a href="<?php echo $artname['instagram']; ?>" target="_blank"><img src="images/instagram.png" style="height:75px;"></a>
            <?php
            }
            if (isset($artname['spotify']) && str_contains($artname['spotify'], 'spotify')) {
                ?><a href="<?php echo $artname['spotify']; ?>" target="_blank"><img src="images/spotify.png" style="height:75px;"></a>
            <?php
            }
            if (isset($artname['divas']) && str_contains($artname['divas'], 'divas')) {
                ?><a href="<?php echo $artname['divas']; ?>" target="_blank"><img src="images/dark-divas.png" style="height:75px;"></a>
            <?php
            }
            if (isset($artname['wikipedia']) && str_contains($artname['wikipedia'], 'wikipedia')) {
                ?><a href="<?php echo $artname['wikipedia']; ?>" target="_blank"><img src="images/wikipedia.png" style="height:75px;"></a>
            <?php
            }
            if (isset($artname['linktr']) && str_contains($artname['linktr'], 'linktr')) {
                ?><a href="<?php echo $artname['linktr']; ?>" target="_blank"><img src="images/linktr.png" style="height:75px;"></a>
            <?php
            }
            if (isset($artname['musicarc']) && str_contains($artname['musicarc'], 'metal-archives')) {
                ?><a href="<?php echo $artname['musicarc']; ?>" target="_blank"><img src="images/metal-archives.png" style="height:75px;"></a>
            <?php
            }
            if (isset($artname['bandcamp']) && str_contains($artname['bandcamp'], 'bandcamp')) {
                ?><a href="<?php echo $artname['bandcamp']; ?>" target="_blank"><img src="images/bandcamp.png" style="height:75px;"></a>
            <?php
            }
            $mb = $artname['MusicBrainz'];
            ?>
            <br>
        </h2>
    <?php } ?><br>
    <h2 class=white>MusicBrainz Album Releases by This Artist:</h2>
    <?php
    //Getting release information from MusicBrainz
    $mb = strrchr($mb, '/');
    $mb = str_replace('/', "", $mb);
    $connect_api_url = "http://musicbrainz.org/ws/2/artist/$mb?inc=release-groups&fmt=json";
    $connect_api_key = "Mozilla/5.0 (Windows NT 10.0; Win64; x64)";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $connect_api_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "User-Agent:" . $connect_api_key
    ));
    $json = curl_exec($curl);
    $data = json_decode($json, true);
    $data = $data['release-groups'];
    echo "<table border='1' align='center' style='color:#F5F5F5'>";
    foreach ($data as $stand) if ($stand['primary-type'] == 'Album' && empty($stand['secondary-types'])) {
        $title = $stand['title'];
        $type = $stand['primary-type'];
        $date = $stand['first-release-date'];
        // Output a row
        echo "<tr>";
        echo "<td>$title  </td>";
        echo "<td>Format:  $type   </td>";
        echo "<td>Release Date:  $date  </td>"; ?>
    <?php
        echo "</tr>";
    }
    echo "</table>"; ?>
    <br>
    <h2 class=tal><a href="javascript:history.back()">Back</a></h2>
    </body>
</html>