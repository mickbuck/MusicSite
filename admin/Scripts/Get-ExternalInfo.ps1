#set-up needed for all scripts
Get-Variable -Exclude PWD,*Preference | Remove-Variable -EA 0
$ScriptDir = Split-Path $script:MyInvocation.MyCommand.Path
$OS = [System.Environment]::OSVersion.Platform
If ($OS -like "Unix"){
    Add-Type -Path "/home/michael/scripts/MySql.Data.dll"
    . "/var/www/html/admin/Scripts/variables.ps1"
    }
    Else 
    {
    . "$ScriptDir \variables.ps1"
    }

[void][System.Reflection.Assembly]::LoadWithPartialName("MySql.Data")
$Connection = New-Object MySql.Data.MySqlClient.MySqlConnection
$ConnectionString = "server=$address port=$Port uid=$UserName pwd=$Password database=$Database"
$Connection.ConnectionString = $ConnectionString
$Connection.Open()

#Finding External Links

$Query = 'SELECT * From artist Limit 3'
$Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
$DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
$DataSet = New-Object System.Data.DataSet
$RecordCount = $dataAdapter.Fill($dataSet, "data")
$data = $dataSet.Tables[0]
ForEach ($artist in $data){
$mb = $artist.MusicBrainz
$mb = $mb.Replace('https://musicbrainz.org/artist/','')
$id = $artist.id
$site = "https://musicbrainz.org/ws/2/artist/" + $mb + "?inc=url-rels&fmt=json"
$out = Invoke-WebRequest $site | ConvertFrom-Json
$out = $out| Select-Object -expand relations
   If ($artist.youtube -like "") {
            ForEach ($site in $out){
            If ($site.type -like "*youtube" )  {
            $youtube = $site.url.resource
            $Query = "update artist Set youtube = '$youtube' Where id = '$id'"
            $Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
            $DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
            $DataSet = New-Object System.Data.DataSet
            $RecordCount = $dataAdapter.Fill($dataSet, "data")
            $DataSet.Tables[0]
            }
        }
    }

    If ([string]::IsNullOrEmpty($artist.instagram)) {
            
            ForEach ($ig in $out){
                If ($ig.url -like "*instagram*" )  {
                $instagram = $ig.url.resource
                $Query = "update artist Set instagram = '$instagram' Where id = '$id'"
                $Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
                $DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
                $DataSet = New-Object System.Data.DataSet
                $RecordCount = $dataAdapter.Fill($dataSet, "data")
                $DataSet.Tables[0]
                }
            }
        }
     If ([string]::IsNullOrEmpty($artist.wikipedia)) {
            
            ForEach ($fb in $out){
                If ($fb.url -like "*facebook*" )  {
                $facebook = $fb.url.resource
                $Query = "update artist Set facebook = '$facebook' Where id = '$id'"
                $Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
                $DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
                $DataSet = New-Object System.Data.DataSet
                $RecordCount = $dataAdapter.Fill($dataSet, "data")
                $DataSet.Tables[0]
                }
            }
        }
    
}

#Finding Album Image

$Query = 'SELECT  ar.name AS "artist", al.name AS "record", al.image as "image", al.id AS "id" from album al, artist ar where al.artist_id = ar.id AND (al.image LIKE "" or  al.image IS NULL)'
$Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
$DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
$DataSet = New-Object System.Data.DataSet
$RecordCount = $dataAdapter.Fill($dataSet, "data")
$data = $dataSet.Tables[0]
ForEach ($album in $data){
    $record=$album.record
    $artist = $album.artist
    $artist = $artist.Replace('&','%26')
    $artist = $artist.Replace('+','%2B')
    $albumid = $album.id
    $out = $null
    $mbsite = "https://musicbrainz.org/ws/2/release/?query=artist:$artist AND release:$record AND status:Official&fmt=json"
    $releases = Invoke-WebRequest $mbsite | ConvertFrom-Json
    $releases = $releases| Select-Object -expand releases
    ForEach ($release in $releases){
    $query = $null

    If(!(Test-Path "$albumspath/$albumid.jpg")) {
        $downloadurl = $null
        $downloadurl = $cover + $release.id
        $covers = Invoke-WebRequest $downloadurl | ConvertFrom-Json -ErrorAction SilentlyContinue
        $covers = $covers.images.thumbnails.250
        If ($covers -notlike $null){
            Invoke-WebRequest -Uri "$covers" -OutFile "$albumspath\$albumid.jpg"
            If(Test-Path "$albumspath\$albumid.jpg") {
            $Query = "update album Set image = '$albumsavepath/$albumid.jpg' Where id = '$albumid'"
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

#Finding Artist Image
$Query = 'Select * from artist where Image LIKE "" OR Image is NULL'
$Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
$DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
$DataSet = New-Object System.Data.DataSet
$RecordCount = $dataAdapter.Fill($dataSet, "data")
$data = $dataSet.Tables[0]
ForEach ($test in $data){
    $tofind=$test.name
    $tofind = $tofind.Replace('&','%26')
    $tofind = $tofind.Replace('+','%2B')
    $update = $test.id
    $out = $null
    $site = $artistimage+$tofind
    $out = Invoke-WebRequest $site | ConvertFrom-Json
    $art = $out| Select-Object -expand artists
    $artband = $art | Select-Object -expand strArtistThumb
    #$artband = "$artband" + "/preview"
    IF(Test-path "$imagepath/$update"){ }Else{
    New-item -Path "$imagepath/$update" -ItemType Directory}
    If(!(Test-Path "$imagepath/$update/band.jpg")){
    Invoke-WebRequest -Uri "$artband" -OutFile "$imagepath/$update/band.jpg"
    $albumsavepath = "$imagestore/$update/band.jpg"
    If(Test-Path "$imagepath/$update/band.jpg") {
    $Query = "update artist Set Image = '$albumsavepath' Where id = '$update'"
    $Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
    $DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
    $DataSet = New-Object System.Data.DataSet
    $RecordCount = $dataAdapter.Fill($dataSet, "data")
    $DataSet.Tables[0]
        }
}
}

#finding Artist banner
$Query = 'Select * from artist where banner LIKE "" OR banner is NULL'
$Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
$DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
$DataSet = New-Object System.Data.DataSet
$RecordCount = $dataAdapter.Fill($dataSet, "data")
$data = $dataSet.Tables[0]
ForEach ($test in $data){
    $tofind=$test.name
    $tofind = $tofind.Replace('&','%26')
    $tofind = $tofind.Replace('+','%2B')
    $update = $test.id
    $out = $null
    $site = $artistimage+$tofind
    $out = Invoke-WebRequest $site | ConvertFrom-Json
    $art = $out| Select-Object -expand artists
    $artband = $art | Select-Object -expand strArtistBanner
    IF(Test-path "$imagepath/$update"){ }Else{
    New-item -Path "$imagepath/$update" -ItemType Directory}
    If ($artband -notlike $NULL){
    Invoke-WebRequest -Uri "$artband" -OutFile "$imagepath/$update/banner.jpg"
    $albumsavepath = "$imagestore/$update/banner.jpg"
    If(Test-Path "$imagepath/$update/banner.jpg") {
    Write-Host "Test"
        $Query = "update artist Set banner = '$albumsavepath' Where id = '$update'"
        $Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
        $DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
        $DataSet = New-Object System.Data.DataSet
        $RecordCount = $dataAdapter.Fill($dataSet, "data")
        $DataSet.Tables[0]
        }
    }
}

#finding Artist clear
$Query = 'Select * from artist where clear LIKE "" OR clear is NULL'
$Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
$DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
$DataSet = New-Object System.Data.DataSet
$RecordCount = $dataAdapter.Fill($dataSet, "data")
$data = $dataSet.Tables[0]
ForEach ($test in $data){
    $tofind=$test.name
    $tofind = $tofind.Replace('&','%26')
    $tofind = $tofind.Replace('+','%2B')
    $update = $test.id
    $out = $null
    $site = $artistimage+$tofind
    $out = Invoke-WebRequest $site | ConvertFrom-Json
    $art = $out| Select-Object -expand artists
    $artband = $art | Select-Object -expand strArtistClearart
    IF(Test-path "$imagepath/$update/"){ }Else{
    New-item -Path "$imagepath/$update/" -ItemType Directory}
    If ($artband -notlike $NULL){
    Invoke-WebRequest -Uri "$artband" -OutFile "$imagepath/$update/clear.jpg"
    $albumsavepath = "$imagestore/$update/clear.jpg"
    If(Test-Path "$imagepath/$update/clear.jpg") {
        $Query = "update artist Set clear = '$albumsavepath' Where id = '$update'"
        $Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
        $DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
        $DataSet = New-Object System.Data.DataSet
        $RecordCount = $dataAdapter.Fill($dataSet, "data")
        $DataSet.Tables[0]
        }
    }
}

#finding Artist clear
$Query = 'Select * from artist where clear LIKE "" OR clear is NULL'
$Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
$DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
$DataSet = New-Object System.Data.DataSet
$RecordCount = $dataAdapter.Fill($dataSet, "data")
$data = $dataSet.Tables[0]
ForEach ($test in $data){
    $tofind=$test.name
    $tofind = $tofind.Replace('&','%26')
    $tofind = $tofind.Replace('+','%2B')
    $update = $test.id
    $out = $null
    $site = $artistimage+$tofind
    $out = Invoke-WebRequest $site | ConvertFrom-Json
    $art = $out| Select-Object -expand artists
    $artband = $art | Select-Object -expand strArtistCutout
    IF(Test-path "$imagepath/$update/"){ }Else{
    New-item -Path "$imagepath/$update/" -ItemType Directory}
    If ($artband -notlike $NULL){
    Invoke-WebRequest -Uri "$artband" -OutFile "$imagepath/$update/clear.jpg"
    $albumsavepath = "$imagestore/$update/clear.jpg"
    If(Test-Path "$imagepath/$update/clear.jpg") {
        $Query = "update artist Set clear = '$albumsavepath' Where id = '$update'"
        $Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
        $DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
        $DataSet = New-Object System.Data.DataSet
        $RecordCount = $dataAdapter.Fill($dataSet, "data")
        $DataSet.Tables[0]
        }
    }
}

#Finding Offline Artist Image
$Connection.Open()
$Query = 'Select * from offlineartists where Image LIKE "" OR Image is NULL'
$Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
$DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
$DataSet = New-Object System.Data.DataSet
$RecordCount = $dataAdapter.Fill($dataSet, "data")
$data = $dataSet.Tables[0]
ForEach ($test in $data){
    $tofind=$test.name
    $tofind=$tofind.Replace('&','%26')
    $tofind=$tofind.Replace('+','%2B')
    $update = $test.id
    $out = $null
    $site = "https://www.theaudiodb.com/api/v1/json/58424d43204d6564696120/search.php?s=$tofind"
    $site
    $out = Invoke-WebRequest $site | ConvertFrom-Json 
    $art = $out| Select-Object -expand artists
    $artband = $art | Select-Object -expand strArtistThumb
    $artband = "$artband" + "/preview"

    If(!(Test-Path "\\192.168.20.3\ftp\site\images\artists\$update.jpg")){
    Invoke-WebRequest -Uri "$artband" -OutFile "\\192.168.20.3\ftp\site\images\artists\$update.jpg"  
    $savepath = "../images/artists/$update.jpg"
    If((Test-Path "\\192.168.20.3\ftp\site\images\artists\$update.jpg")){
    $Query = "update offlineartists Set Image = '$savepath' Where id = '$update'"
    $Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
    $DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
    $DataSet = New-Object System.Data.DataSet
    $RecordCount = $dataAdapter.Fill($dataSet, "data")
    $DataSet.Tables[0]}
    }
}
$Connection.Close()


#Find-MusicBrainz
$Query = 'Select * from artist where MusicBrainz LIKE "" OR MusicBrainz is NULL'
$Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
$DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
$DataSet = New-Object System.Data.DataSet
$RecordCount = $dataAdapter.Fill($dataSet, "data")
ForEach ($test1 in $DataSet.Tables){
    ForEach ($test in $test1){
    $mb = $null
    $tofind=$test.name
    $tofind = $tofind.Replace('&','%26')
    $tofind = $tofind.Replace('+','%2B')
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

#Finding Album Discogs
$Query = 'SELECT al.barcode As "barcode", ar.name AS "artist", al.cat_number AS "cat", al.discogs as "discogs", al.id AS "id" from album al,artist ar where al.artist_id = ar.id AND al.cat_number != " " AND (al.discogs = "" OR al.discogs IS NULL) AND (al.wanted = "0" AND al.onorder = "0")'
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

$Connection.Close()