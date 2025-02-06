<?php
session_start();

include_once '3_dataBase.php';

$connect==connect_db("NewDataBase1");

if(isset($_POST['submit']))
{
    $falg=false;
    $query = "SELECT user_id, user_password, is_admin FROM users_data WHERE user_login='".mysqli_real_escape_string($connect,$_POST['login'])."' LIMIT 1";
    $data = SQL_Module($query,$connect);

    $salt = 'khgffgrgerte'; 
    $hash_pass = hash('sha256', $_POST['password'] . $salt);
    //echo $hash_pass;
    //echo "<br>";
    //echo $_POST['password']. $salt;

    if($data[0]['user_password'] === $hash_pass)
    {
        $_SESSION['username'] = $_POST['login'];
        $_SESSION['is_admin'] = $data[0]['is_admin'];
        header("Location: log_page.php"); 
        exit();
    }
    else
    {
        //echo "Вы ввели неправильный логин/пароль";
        $flag=true;
    }
}
?>

<!DOCTYPE html>
    <head>
        <title>Авторизация</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div id="active_zone">
            <?php include 'Blocks/reg_header.php';?>
            <div id="content">
                <div id="input_block">
                    <div id="errblock"><?php if($flag)  echo '<p style="text-align: center">' .  "Вы ввели неправильный логин/пароль";?></div>
                    <form method="POST">
                        Логин <input name="login" type="text" required><br>
                        Пароль <input name="password" type="password" required><br>
                        <input name="submit" type="submit" value="Войти">
                    </form>
                </div>
            </div>
            <?php include 'Blocks/footer.php';?>
        </div>
    </body>
</html>
