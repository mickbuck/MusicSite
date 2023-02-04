$ScriptDir = Split-Path $script:MyInvocation.MyCommand.Path
. "$ScriptDir \variables.ps1"
Add-Type -Path "/home/michael/scripts/MySql.Data.dll"
[void][System.Reflection.Assembly]::LoadWithPartialName("MySql.Data")
$Connection = New-Object MySql.Data.MySqlClient.MySqlConnection
$ConnectionString = "server=$address port=$Port uid=$UserName pwd=$Password database=$Database"

$Connection.ConnectionString = $ConnectionString

#Find-AlbumArt
#Finding Album Image
$Connection.Open()
$Query = 'SELECT  ar.name AS "artist", al.name AS "record", al.image as "image", al.id AS "id" from album al, artist ar where al.artist_id = ar.id AND (al.image LIKE "" or  al.image IS NULL)'
$Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
$DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
$DataSet = New-Object System.Data.DataSet
$RecordCount = $dataAdapter.Fill($dataSet, "data")
$data = $dataSet.Tables[0]
ForEach ($test in $data){
$test
    $record=$test.record
    $artist = $test.artist
    $albumid = $test.id
    $out = $null
    $site = "https://musicbrainz.org/ws/2/release/?query=artist:$artist AND release:$record AND status:Official&fmt=json"
    $releases = Invoke-WebRequest $site | ConvertFrom-Json
    $releases = $releases| Select-Object -expand releases
    ForEach ($release in $releases){
    If(!(Test-Path "/var/www/html/images/albums/$albumid.jpg")) {
        $covers = $null
        $release = $release.id
        $cover = "https://coverartarchive.org/release/$release"
        $cover
        $covers = Invoke-WebRequest $cover | ConvertFrom-Json
        $cover = $covers.images.image
        If ($covers -notlike $null){
            #$cover
            Invoke-WebRequest -Uri "$cover" -OutFile "/var/www/html/images/albums/$albumid.jpg"
            $savepath = "https://mymusic.mickbuck.gq/images/albums/$albumid.jpg"
            If(Test-Path "/var/www/html/images/albums/$albumid.jpg") {
            $Query = "update album Set image = '$savepath' Where id = '$albumid'"
            $Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
            $DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
            $DataSet = New-Object System.Data.DataSet
            $RecordCount = $dataAdapter.Fill($dataSet, "data")
            $DataSet.Tables[0]
        }
    }

}
}
}
$Connection.Close()

<#find-ArtistArt

#Finding Artist Image
$Connection.Open()
$Query = 'Select * from artist where Image LIKE "" OR Image is NULL'
$Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
$DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
$DataSet = New-Object System.Data.DataSet
$RecordCount = $dataAdapter.Fill($dataSet, "data")
$data = $dataSet.Tables[0]
ForEach ($test in $data){
    $tofind=$test.name
    $update = $test.id
    $out = $null
    $site = "https://www.theaudiodb.com/api/v1/json/58424d43204d6564696120/search.php?s=$tofind"
    $out = Invoke-WebRequest $site | ConvertFrom-Json
    $art = $out| Select-Object -expand artists
    $artband = $art | Select-Object -expand strArtistThumb
    $artband = "$artband" + "/preview"
    IF(Test-path "/var/www/html/images/$update"){ }Else{
    New-item -Path "/var/www/html/images/$update" -ItemType Directory}

    If(!(Test-Path "/var/www/html/images/$update/band.jpg")){
    Invoke-WebRequest -Uri "$artband" -OutFile "/var/www/html/images/$update/band.jpg"
    $savepath = "https://mymusic.mickbuck.gq/images/$update/band.jpg"
    If(Test-Path "/var/www/html/images/$update/band.jpg") {
    $Query = "update artist Set Image = '$savepath' Where id = '$update'"
    $Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
    $DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
    $DataSet = New-Object System.Data.DataSet
    $RecordCount = $dataAdapter.Fill($dataSet, "data")
    $DataSet.Tables[0]
        }
}
}
$Connection.Close()

#finding Artist banner
$Connection.Open()
$Query = 'Select * from artist where banner LIKE "" OR banner is NULL'
$Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
$DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
$DataSet = New-Object System.Data.DataSet
$RecordCount = $dataAdapter.Fill($dataSet, "data")
$data = $dataSet.Tables[0]
ForEach ($test in $data){
    $tofind=$test.name
    $update = $test.id
    $out = $null
    $site = "https://www.theaudiodb.com/api/v1/json/58424d43204d6564696120/search.php?s=$tofind"
    $out = Invoke-WebRequest $site | ConvertFrom-Json
    $art = $out| Select-Object -expand artists
    $artband = $art | Select-Object -expand strArtistBanner
    IF(Test-path "/var/www/html/images/$update"){ }Else{
    New-item -Path "/var/www/html/images/$update" -ItemType Directory}
    Invoke-WebRequest -Uri "$artband" -OutFile "/var/www/html/images/$update/banner.jpg"
    $savepath = "https://mymusic.mickbuck.gq/images/$update/banner.jpg"
    If(Test-Path "/var/www/html/images/$update/banner.jpg") {
        $Query = "update artist Set banner = '$savepath' Where id = '$update'"
        $Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
        $DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
        $DataSet = New-Object System.Data.DataSet
        $RecordCount = $dataAdapter.Fill($dataSet, "data")
        $DataSet.Tables[0]
    }
}
$Connection.Close()


#finding Artist clear
$Connection.Open()
$Query = 'Select * from artist where clear LIKE "" OR clear is NULL'
$Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
$DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
$DataSet = New-Object System.Data.DataSet
$RecordCount = $dataAdapter.Fill($dataSet, "data")
$data = $dataSet.Tables[0]
ForEach ($test in $data){
    $tofind=$test.name
    $update = $test.id
    $out = $null
    $site = "https://www.theaudiodb.com/api/v1/json/58424d43204d6564696120/search.php?s=$tofind"
    $site
    $out = Invoke-WebRequest $site | ConvertFrom-Json
    $art = $out| Select-Object -expand artists
    $artband = $art | Select-Object -expand strArtistClearart
    IF(Test-path "/var/www/html/images/$update"){ }Else{
    New-item -Path "/var/www/html/images/$update" -ItemType Directory}
    Invoke-WebRequest -Uri "$artband" -OutFile "/var/www/html/images/$update/clear.jpg"
    $savepath = "https://mymusic.mickbuck.gq/images/images/$update/clear.jpg"
    If(Test-Path "/var/www/html/images/$update/clear.jpg") {
        $Query = "update artist Set clear = '$savepath' Where id = '$update'"
        $Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
        $DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
        $DataSet = New-Object System.Data.DataSet
        $RecordCount = $dataAdapter.Fill($dataSet, "data")
        $DataSet.Tables[0]
    }
}
$Connection.Close()

#Find-MusicBrainz

Add-Type -Path "/home/michael/scripts/MySql.Data.dll"
Get-Variable -Exclude PWD,*Preference | Remove-Variable -EA 0
[void][System.Reflection.Assembly]::LoadWithPartialName("MySql.Data")
$Connection = New-Object MySql.Data.MySqlClient.MySqlConnection
$ConnectionString = "server=" + "127.0.0.1" + ";port=3306;uid=" + "music" + ";pwd=" + "ptWp4TWTakNxwivIVF3m" + ";database="+"music"
$Connection.ConnectionString = $ConnectionString
$Connection.Open()
$Query = 'Select * from artist where MusicBrainz LIKE "" OR MusicBrainz is NULL'
$Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
$DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
$DataSet = New-Object System.Data.DataSet
$RecordCount = $dataAdapter.Fill($dataSet, "data")
ForEach ($test1 in $DataSet.Tables){
    ForEach ($test in $test1){
    $mb = $null
    $tofind=$test.name
    $update = $test.id
    $out = $null
    $site = "https://musicbrainz.org/ws/2/artist/?query=artist:$tofind&fmt=json"
    $out = Invoke-WebRequest $site | ConvertFrom-Json
    $out = $out| Select-Object -expand artists
    $mb = $out[0].id
    $mb = "https://musicbrainz.org/artist/$mb"
    $Query = "update artist Set MusicBrainz = '$mb' Where id = '$update'"
    $Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
    $DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
    $DataSet = New-Object System.Data.DataSet
    $RecordCount = $dataAdapter.Fill($dataSet, "data")
    $DataSet.Tables[0]
}
}
$Connection.Close()

#find-discogs

Add-Type -Path "/home/michael/scripts/MySql.Data.dll"
[void][System.Reflection.Assembly]::LoadWithPartialName("MySql.Data")
$Connection = New-Object MySql.Data.MySqlClient.MySqlConnection
$ConnectionString = "server=" + "127.0.0.1" + ";port=3306;uid=" + "music" + ";pwd=" + "ptWp4TWTakNxwivIVF3m" + ";database="+"music"
$Connection.ConnectionString = $ConnectionString
#Finding Album Discogs
$Connection.Open()
$Query = 'SELECT al.barcode As "barcode", ar.name AS "artist", al.cat_number AS "cat", al.discogs as "discogs", al.id AS "id" from album al,artist ar where al.artist_id = ar.id AND al.cat_number != " " AND (al.discogs = "" OR al.discogs IS NULL)'
$Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
$DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
$DataSet = New-Object System.Data.DataSet
$RecordCount = $dataAdapter.Fill($dataSet, "data")
$data = $dataSet.Tables[0]
ForEach ($test in $data){
    $readable = $null
    $record=$test.BarCode
    $albumid = $test.id
    $out = $null
    $site = "https://api.discogs.com/database/search?barcode=$record&per_page=1&type=release&key=hNkOvwwbbmSDEERuKmCp&secret=ZMATpdwhAcpQfFnqyzSMErUoUevpKYpy"
        $site
    $out = Invoke-WebRequest $site | ConvertFrom-Json
    $out = $out| Select-Object -expand results
    $id = $out | Select-Object -expand id
    $readable = $out.resource_url.replace('api.','www.').replace('releases','release')
    Start-Sleep -Seconds 1
     If ($readable -notlike $null){
            $Query = "update album Set discogs = '$readable' Where id = '$albumid'"
            $Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
            $DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
            $DataSet = New-Object System.Data.DataSet
            $RecordCount = $dataAdapter.Fill($dataSet, "data")
            $DataSet.Tables[0]
        }
}

#>