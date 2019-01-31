<?php
$host='localhost';
$user='root';
$pass='';
$db='shopkeeper';
$con=mysqli_connect($host,$user,$pass,$db);
if (mysqli_connect_error()) {
        
                die ("There was an error connecting to the database");
        
            } 
?>