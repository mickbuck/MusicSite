<?php header('Content-Type: text/html; charset=utf-8'); ?>

<?php
include("../include/config.php"); {
    $q = "SELECT * from artist WHERE tolistento = '1' AND (rating is NULL OR rating = '' OR rating = '0') order by UPPER(LTRIM(Replace(name, 'The ', '')));";
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
            <?php $rating = $qq['rating'] ?>
            <?php if($rating == NULL) {
            $rating = '0';
            } ?>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body1">
                            <?php $qid = $qq['id'] ?>
                            <h5 class="card-title"><?php echo $qq['name']; ?>
                                <a href="../byartist.php?id=<?php echo $qq['id']; ?>">
                                <img src="<?php echo $qq['Image']; ?>" alt="<?php echo $qq['name']; ?>" style="width:200px;height:200px;"> <br></a> 
                                <br><img src="emojis/<?php echo $rating ?>.png" style="width: 25px;height:25px;"><br>
                                <br><input type="button" onclick="window.location='editartist.php?id=<?php echo $qq['id']; ?>'" class="Redirect" value="Click Here To Edit" />
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