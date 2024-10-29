<?php
$config = parse_ini_file('../../privado-toolkit/config.ini'); 
// Try and connect to the database
$mysqli = mysqli_connect($config['servername'],$config['username'],$config['password'],$config['dbname']);
mysqli_query($mysqli , "SET SESSION sql_mode = ''");
$mysqli->set_charset("utf8");
// If connection was not successful, handle the error
if($mysqli === false) {
            // Handle error - notify administrator, log to a file, show an error screen, etc.
        }
?>