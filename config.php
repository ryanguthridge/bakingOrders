<?php
########## MySql details (Replace with yours) #############
$username = "freshbakes"; //mysql username
$password = "Twenty4Seconds%"; //mysql password
$hostname = "freshbakes.db.6593167.hostedresource.com"; //hostname
$databasename = 'freshbakes'; //databasename
//connect to database
$mysqli = new mysqli($hostname, $username, $password, $databasename);
?>