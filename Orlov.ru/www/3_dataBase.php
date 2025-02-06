<?php

include_once 'config.php';
include_once '2_otstupi.php';

function connect_db($db_name)
{
    global $connect;
    //$connect=mysqli_connect($ip,$name,$p,$cdbName);
    $connect=mysqli_connect("Orlov.ru","root","",$db_name);
    if ($connect->connect_error)
        die("Connection failed: " . $connect->connect_error);
    return $connect;
}

function SQL_Module($zapros,$connect)
{
    $result=mysqli_query($connect,$zapros);
    $res_arr=array();
    if($result)
    {
        while($data=mysqli_fetch_assoc($result))
        {
            //print_r($data);
            $res_arr[]=$data;
            //var_dump_Module($data);
        }
    }
    else
    {
        echo("Incorrect request!");
    }
    return $res_arr;
}

//Tests:

/*$connect = connect_db("shopbase");
$res_sql = SQL_Module("SELECT * FROM Users",$connect);
var_dump_Module($res_sql);*/

?>