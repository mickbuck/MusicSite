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



<?php
Echo $barcode

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
            <h4><b>Title:</b><?php echo $album; ?><br> </a>
            <?php $artist = strstr($title,'-', true );
            $substr = ")";
            if (strpos($artist, $substr) !== false)
                {
                    $artist = strstr($artist,'(', true );  
                }
            else
                { } 
            ?>
            <b>Artist: </b><?php echo $artist; ?><br>
            <b>Release Year:</b> <?php echo $result['year']; ?><br>
            <b>Catalogue Number: </b><?php echo $result['catno']; ?><br>
            <b>Record Label: </b><?php echo $result['label'][0]; ?><br>
            <b>Discogs Link: </b><?php echo str_replace('api.discogs.com/releases','www.discogs.com/release', $result['resource_url']); ?> <br></h4>
            <b>Barcode: </b><?php echo $barcode; ?><br>;
            <?php $image = $result['cover_image'];?> 
            <img src=<?php echo $image ?> style="height:500px"><br>
        <?php } ?>                                
              
<?php
//$InsertQuery = "Insert into album (barcode,wanted,record_label_id,format,dateordered,cost) VALUES ('$album','$artistid',$year,'$catno','$discogs','$barcode','0','$labelid','$format','$Date','$cost')"

//$artist = $track[0].replace('*','').split('(')[0].trim()
?>

</body>
</html>
