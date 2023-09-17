<?php
function dbconnect()
{
    $host = 'mysql-ysite.alwaysdata.net';
    $db_user = 'ysite_lucas';
    $db_password = 'lucasysite';
    $db_name = 'ysite_allbd';

    $conn = new mysqli(
        $host,
        $db_user,
        $db_password,
        $db_name
    );

        if ($conn->connect_error){
            die("Connection failed .$conn->connect_error");

        }
}
