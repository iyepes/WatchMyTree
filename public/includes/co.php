<?php
$host		= "localhost";
$user		= "mytreedb";
$password	= "EFuRvsLnhPTVTrF5";
$database	= "mytreedb";
$iddb			= mysqli_connect($host,$user,$password,$database);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
mysqli_set_charset($iddb,'utf8');
?>