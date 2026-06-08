$ErrorActionPreference = 'SilentlyContinue'
#Cleaning out Old Variables/Add in paths etc
Get-Variable -Exclude PWD,*Preference | Remove-Variable -EA 0
Add-Type -AssemblyName System.Web
#setting path for Script
$ScriptDir = Split-Path $script:MyInvocation.MyCommand.Path
$OS = [System.Environment]::OSVersion.Platform
If ($OS -like "Unix"){
    Add-Type -Path "/home/michael/scripts/MySql.Data.dll"
    . "/var/www/html/admin/Scripts/variables.ps1"
    }
    Else #Generally A Windows OS
    {
    [System.Reflection.Assembly]::LoadFrom("C:\Users\Michael\Desktop\MP3 Player\MP3\net6.0\MySql.Data.dll") | Out-Null
    [void][System.Reflection.Assembly]::LoadWithPartialName("MySql.Data") 
    . "$ScriptDir \variables.ps1"
    }

#Connect to DB
$Connection = New-Object MySql.Data.MySqlClient.MySqlConnection
$ConnectionString = "server=$address port=$Port uid=$UserName pwd=$Password database=$Database"
$Connection.ConnectionString = $ConnectionString

try {
    $Connection.Open()
    Function Post-ToDB {
    param (
    [string]$Query
    )
    $Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
    $DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
    $DataSet = New-Object System.Data.DataSet
    $RecordCount = $dataAdapter.Fill($dataSet, "data")
    $dataSet.Tables[0]
    $Query = $null
    
    }

    Function Get-MusicBrainz {
        #Get Musicbrainz info for Artist.
        #$global:Query = 'Select * from artist where name like "Lana Del Rey"'
        $Query = 'Select * from artist where MusicBrainz LIKE "" OR MusicBrainz is NULL ORDER BY rand() LIMIT 50'
        $Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
        $DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
        $DataSet = New-Object System.Data.DataSet
        $RecordCount = $dataAdapter.Fill($dataSet, "data")
            ForEach ($Artists in $DataSet.Tables){
                ForEach ($artist in $Artists){
                    $tofind = $null
                    $mbsite = $null
                    $tofind = $artist.name
                    $tofind = $tofind.Replace('&','%26')
                    $tofind = $tofind.Replace('+','%2B').Replace(' ','%20')
                    $update = $artist.id
                    $mbsite = "https://musicbrainz.org/ws/2/artist/?query=artist:`"$tofind`"&fmt=json"
                    try {
                            $result = Invoke-RestMethod $mbsite -ErrorAction Stop
                        }
                        catch {
                            $result = $null
                        }
                    $result = $result| Select-Object -expand artists
                    If ($result -ne $null) {
                        $mbsite = $result[0].id
                        $mbsite = "https://musicbrainz.org/artist/$mbsite"
                        $Query = "update artist Set MusicBrainz = '$mbsite' Where id = '$update'"
                        $Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
                        $DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
                        $DataSet = New-Object System.Data.DataSet
                        $RecordCount = $dataAdapter.Fill($dataSet, "data")
                        $DataSet.Tables[0]
                      } Else {
                        Write-Host "$tofind not found"
                      }
                }
            }
        }

        Function Get-ArtistImages {
            $Query = 'Select * from artist where Image LIKE "" OR Image is NULL OR banner LIKE "" OR banner is NULL OR clear LIKE "" OR clear is NULL ORDER BY rand() LIMIT 50 '
            #$Query = 'Select * from artist where name like "Lana Del Rey"'
            $Command = New-Object MySql.Data.MySqlClient.MySqlCommand($Query, $Connection)
            $DataAdapter = New-Object MySql.Data.MySqlClient.MySqlDataAdapter($Command)
            $DataSet = New-Object System.Data.DataSet
            $RecordCount = $dataAdapter.Fill($dataSet, "data")
            $data = $dataSet.Tables[0]
           
            ForEach ($Image in $data){
                $bandid = $Image.id
                $image.name
                If ($image.banner -eq ""){
                    $artband = $null
                    $tofind = $image.name.Replace('+','%2B').Replace(' ','%20').Replace('&','%26')
                    $Search = $artistimage+$tofind
                    $ArtistBannerLink = Invoke-RestMethod $Search | Select-Object -expand artists 
                    $ArtistBanner = $ArtistBannerLink | Select-Object -expand strArtistBanner
                    $ArtistLogo = $ArtistBannerLink| Select-Object -expand strArtistLogo
                    if ($ArtistLogo) {
                        $savepath = "$imagepath\$bandid\banner.png"
                        $filetype = "banner.png"
                        $artband =  $ArtistLogo
                        
                        }
                    if ($ArtistBanner -and !$ArtistLogo) {
                        $savepath = "$imagepath\$bandid\banner.jpg"
                        $filetype = "banner.jpg"
                        $artband =  $ArtistBanner
                        
                        }
                    if ($artband){
                        IF(!(Test-path "$imagepath\$bandid")){
                            New-item -Path "$imagepath\$bandid" -ItemType Directory
                            }
                        If(!(Test-Path "$albumsavepath")){
                             Invoke-WebRequest -Uri "$artband" -OutFile $savepath
                            }
                        If(Test-Path "$savepath") {
                            $global:UpdateQuery = "update artist Set banner = '$imagestore/$bandid/$filetype' Where id = '$bandid'"
                            Post-ToDB -Query $global:UpdateQuery 
                            }
                        }
                    }
               If ($image.clear -eq ""){
                    $tofind = $image.name.Replace('+','%2B').Replace(' ','%20').Replace('&','%26')
                    $Search = $artistimage+$tofind
                    $bandclear = Invoke-RestMethod $Search | Select-Object -expand artists | Select-Object -expand strArtistClearart
                     If ($bandclear -ne $null) {
                        IF(!(Test-path "$imagepath/$bandid")){
                            New-item -Path "$imagepath/$bandid" -ItemType Directory
                            }
                        If(!(Test-Path "$imagepath/$bandid/clear.png")){
                             Invoke-WebRequest -Uri "$bandclear" -OutFile "$imagepath\$bandid\clear.png"
                            }
                        If(Test-Path "$imagepath\$bandid\clear.png") {
                            $global:UpdateQuery = "update artist Set clear = '$imagestore/$bandid/clear.png' Where id = '$bandid'"
                            Post-ToDB -Query $global:UpdateQuery 
                            }
                        }
                    }
                If ($image.Image -eq ""){
                    $tofind = $image.name.Replace('+','%2B').Replace(' ','%20').Replace('&','%26')
                    $Search = $artistimage+$tofind
                    $bandimage = Invoke-RestMethod $Search | Select-Object -expand artists | Select-Object -expand strArtistThumb
                     If ($bandimage -ne $null) {
                        $bandimage = $bandimage + "/preview"
                        IF(!(Test-path "$imagepath/$bandid")){
                            New-item -Path "$imagepath/$bandid" -ItemType Directory
                            }
                        If(!(Test-Path "$imagepath/$bandid/band.jpg")){
                             Invoke-WebRequest -Uri "$bandimage" -OutFile "$imagepath\$bandid\band.jpg"
                            }
                        If(Test-Path "$imagepath\$bandid\band.jpg") {
                            $global:UpdateQuery = "update artist Set Image = '$imagestore/$bandid/band.jpg' Where id = '$bandid'"
                            Post-ToDB -Query $global:UpdateQuery 
                            }
                        }
                    }
                }

        }

        Get-MusicBrainz  #Getting missing MusicBrainz Links 
        Get-ArtistImages
        }

finally {
    if ($Connection.State -eq 'Open') {
        $Connection.Close()
    }
}