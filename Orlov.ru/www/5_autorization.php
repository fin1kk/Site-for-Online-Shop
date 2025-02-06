<?php
session_start();
echo session_id();

// initialize session variables 
$_SESSION['logged_in_user_id'] = '1';
$_SESSION['logged_in_user_name'] = 'Tutsplus';

$count_page = str_replace("что меняем","на что меняем", URI этой страницы);
getenv("REQUEST_URI") - URI этой страницы

// access session variables 
echo $_SESSION['logged_in_user_id'];
echo $_SESSION['logged_in_user_name'];

// unset a session variable 
unset($_SESSION['logged_in_user_id']);

// destroy everything in this session 
session_destroy();

setcookie ("student", "pupkin");
echo $student;
echo $_COOKIE["student"];
$stud=$_GET['student'];


if (!isset($_SERVER['PHP_AUTH_USER']))  
{
    header('WWW-Authenticate: Basic realm="http://my.server.ru"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Пользователь нажал кнопку Cancel';
    exit();
}
else  
{
    echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}.</p>";
    echo "<p>Вы ввели пароль {$_SERVER['PHP_AUTH_PW']}.</p>";
}
?>