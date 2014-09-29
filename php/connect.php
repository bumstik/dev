<?php
$host = "localhost";
$db_name = "dev";
$login = "admin";
$password = "admin";
@$connect = mysql_connect("$host", "$login", "$password");
if (!$connect)
{
    exit(mysql_error());
}
else
{
    mysql_select_db("$db_name", $connect );
    echo "Connect to the server!<br>";
}
mysql_query("SET NAMES 'utf-8'")
?>