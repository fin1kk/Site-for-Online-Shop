<?php
function castom_get_connect()
{
    $servername = "Orlov.ru";
    $username = "root";
    $password = "";
    $dbname = "NewDataBase1";

    $connect = mysqli_connect($servername, $username, $password, $dbname);
    if (mysqli_connect_error()) {
        die("Connection failed: " . mysqli_connect_error());
    }
    else return $connect;
}



?>