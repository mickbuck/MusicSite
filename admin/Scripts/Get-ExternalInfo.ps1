$ScriptDir = Split-Path $script:MyInvocation.MyCommand.Path
$ScriptDir += "\variables.json"
#Getting information from the json file
#The we pass the output from Get-Content to ConvertFrom-Json Cmdlet
$JsonObject = Get-Content $ScriptDir | ConvertFrom-Json
 
#Right now we have an array which means that we have to index
#an element to use it
$JsonObject.SQL[0]
 
#When indexed we can call the attributes of the elements
Write-Host "Attributes individually printed"
$JsonObject.Users[0].Name
$JsonObject.Users[0].Age
$JsonObject.Users[0].City
$JsonObject.Users[0].Country
$JsonObject.Users[0].UserId