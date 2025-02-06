<?php
session_start();
include_once '3_dataBase.php';

$connect=connect_db("NewDataBase1");

if(isset($_POST['submit']))
{
    $flag =false;
    $err = array();

    if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
    {
        $err[] = "Логин может состоять только из букв английского алфавита и цифр";
    }

    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
    {
        $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
    }

    $query = mysqli_query($connect, "SELECT user_id FROM users_data WHERE user_login='".mysqli_real_escape_string($connect, $_POST['login'])."'");
    if(mysqli_num_rows($query) > 0)
    {
        $err[] = "Пользователь с таким логином уже существует";
    }

    if(!($_POST['password'] === $_POST['password_confirmed']))
    {
        $err[] = "Пароли не совпадают";
    }


    if(count($err) == 0)
    {
        $login = $_POST['login'];

        $salt = 'khgffgrgerte'; 
        $hash_pass = hash('sha256', $_POST['password'] . $salt);

        mysqli_query($connect,"INSERT INTO users_data SET user_login='".$login."', user_password='".$hash_pass."', is_admin='0'");
        $_SESSION['username'] = $login;
        $_SESSION['is_admin'] = 0;
        header("Location: log_page.php"); 
        exit();
    }
    else
    {
        $flag = true;
        /*print "<b>При регистрации произошли следующие ошибки:</b><br>";
        foreach($err AS $error)
        {
            echo '<p style="text-align: center">' . $error."<br>";    
        }*/
    }
}
?>

<!DOCTYPE html>
    <head>
        <title>Регистрация</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div id="active_zone">
            <?php include 'Blocks/reg_header.php';?>
            <div id="content">
                <div id="input_block">
                    <div id="errblock">
                        <?php 
                            if($flag){
                                foreach($err AS $error)
                                {
                                    echo '<p style="text-align: center">' . $error."<br>";
                                }
                            }
                        ?></div>
                    <form method="POST">
                    Логин <input name="login" type="text" required><br>
                    Пароль <input name="password" type="password" required><br>
                    Подтвердите пароль: <input name="password_confirmed" type="password"><br>
                    <input name="submit" type="submit" value="Зарегистрироваться">
                    </form>
                </div>
            </div>
            <?php include 'Blocks/footer.php';?>
        </div>
    </body>
</html>
