<?php

session_start();
include_once '3_dataBase.php';

$connect==connect_db("NewDataBase1");

if (isset($_SESSION['username']))
{
    //print "Привет, ".$_SESSION['username'].". Всё работает!";
}
else
{
    //print "Что то пошло не так";
    header("Location: login.php");
}

if(isset($_POST['submit']))
{
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
    <head>
        <title>Ура вы вошли!</title>
        <link rel="stylesheet" href="styles_for_site.css">
    </head>
    <body>
        <form method="POST">
        <input name="submit" type="submit" value="Выйти">
        </form>
    </body>
</html>