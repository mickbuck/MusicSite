<!DOCTYPE html>
<?php
include("../include/config.php"); {
    $barcode = ($_POST["barcode"]); 
}
?>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Barcode</title>
    <link rel="stylesheet" href="../css/style.css">
    </head>
<body>
<br>
    <h1>Album from Barcode</h1>
<?php
$connect_api_url = "https://api.discogs.com/database/search?barcode=$barcode&per_page=1&type=release&$discogs";
$connect_api_key = "Mozilla/5.0 (Windows NT 10.0; Win64; x64)";
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $connect_api_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    "User-Agent:" . $connect_api_key
));
$json = curl_exec($curl);
$data = json_decode($json, true);
foreach ($data['results'] as $result) { ?>
            <?php $title = $result['title'];
            $album = strstr($title, '-');
            $album = str_replace('-', "", $album);?>
            <h2 class="white"><label>Album:</label>
            <input type="text" name="album" value="<?php echo $album; ?>" style="width:250px"></br>
            <?php $artist = strstr($title,'-', true );
            $substr = ")";
            if (strpos($artist, $substr) !== false)
                {
                    $artist = strstr($artist,'(', true );
                }
            else
                {}
            ?>
            <label>Artist:</label>
            <input type="text" name="artist" value="<?php echo $artist; ?>" style="width:250px"></br>
            <b>Release Year:</b> <?php echo $result['year']; ?><br>
            <label>Catalogue Number:</label>
            <input type="text" name="catno" value="<?php echo $result['catno']; ?>" style="width:250px"></br>
            <label>Record Label:</label>
            <input type="text" name="catno" value="<?php echo $result['label'][0]; ?>" style="width:250px"></br>
            <label>Discogs Link:</label>
            <input type="text" name="catno" value="<?php echo str_replace('api.discogs.com/releases','www.discogs.com/release', $result['resource_url']); ?>" style="width:250px"></br>
            <label>Barcode:</label>
            <input type="text" name="catno" value="<?php echo $barcode; ?>" style="width:250px"></br>
                        
            <?php $image = $result['cover_image'];?></h2>
            <img src=<?php echo $image ?> style="height:500px"><br>
        <?php } 
    ?>
              
<?php
//$InsertQuery = "Insert into album (barcode,wanted,record_label_id,format,dateordered,cost) VALUES ('$album','$artistid',$year,'$catno','$discogs','$barcode','0','$labelid','$format','$Date','$cost')"
//$artist = $track[0].replace('*','').split('(')[0].trim()
?>
</body>
</html>
