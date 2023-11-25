<?php

$sname = "localhost"; #servername
$unaem = "root";
$password = "hemusql1026";

$db_name = "sports_ground";

$conn = mysqli_connect($sname, $unaem, $password, $db_name);

if(!$conn){
    echo "Connection Failed";
}