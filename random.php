<?php header('Content-Type: text/html; charset=utf-8'); ?>

<?php
include("include/config.php"); {
    $q = "SELECT * FROM album WHERE (FORMAT LIKE '1' OR FORMAT LIKE '2') ORDER BY RAND() LIMIT 1;";
    $query = mysqli_query($sql, $q);
}
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>My Music by Artists</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="center">
    <br>
    <h1>My Music by Artists</h1>
    <div class="container mt-5">
        <div class="row mt-4">

            <?php
            while ($qq = mysqli_fetch_array($query)) {
            ?>
                <div class="col-md-1 offset-md-1
                        text-center bg-success">
                    <div class="card">
                        <div class="card-body2">
                            <?php $qid = $qq['id'] ?>
                            <h5 class="card-title"><?php echo $qq['name']; ?>
                                <a href="../byartist.php?id=<?php echo $qq['id']; ?>">
                                <img src="<?php echo $qq['image']; ?>" alt="<?php echo $qq['name']; ?>" style="width:98%;"> <br></a>
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