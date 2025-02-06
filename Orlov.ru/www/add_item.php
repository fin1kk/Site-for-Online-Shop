<?php
session_start();

include_once '3_dataBase.php';

$connect==connect_db("NewDataBase1");

if(isset($_SESSION["username"]) && $_SESSION["is_admin"]==1) {
    //echo "Вы админ!";
} else {
    header("Location: log_page.php");
}

function get_max_id($table = "USERS")
{
    global $connect;
    $table = mysqli_real_escape_string($connect, $table);
    $result = SQL_Module("SELECT MAX(id) AS max_id FROM $table;",$connect);
    $row = $result[0];
    return $row['max_id'];
}

function add_item($name, $description, $price, $img) {
    global $connect;
    $name = mysqli_real_escape_string($connect, $name);
    $description = mysqli_real_escape_string($connect, $description);
    $img = mysqli_real_escape_string($connect, $img);

    $query = "SELECT * FROM ITEMS WHERE name='$name'";
    $result = SQL_Module($query,$connect);
    
    if (!empty($result) && count($result) > 0) {
        return false;
    }
    else{
        $newid = get_max_id("ITEMS")+1;
        mysqli_query($connect, "INSERT INTO ITEMS (id, name, description, price, image_link) VALUES ($newid, '$name', '$description', $price, '$img')");

        return true;
    }
    return false;
}

if(isset($_POST['submit']))
{
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = intval($_POST['price']);
    $img = $_POST['img'];

    $flag =false;
    $err = array();

    if($price=="" or $price=="" or $price=="" or $price=="")
    {
        $err[] = "Имеются пустые поля!";
    }
    elseif(!is_int($price))
    {
        $err[] = "Поле стоимость не является числом";
    }

    elseif (add_item($name, $description, $price, $img)) {
        $err[] = "Товар успешно добвлен!";
        //header("Location: log_page.php"); 
    } 
    else {
        $err[] = "Товар с таким названием уже существует!";
    }
    $flag =true;
}
?>

<!DOCTYPE html>
    <head>
        <title>Создание нового товара</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div id="active_zone">
            <?php include 'Blocks/log_header.php';?>
            <div id="content">
                <button type="button" id="back_to_catalog" onclick="window.location.href='log_page.php';">Вернуться к каталогу</button>
                <div id="input_block">
                    <div id="errblock">
                        <?php 
                            if($flag){
                                foreach($err AS $error)
                                {
                                    echo '<p style="text-align: center">' . $error."<br>";
                                }
                            }
                        ?>
                    </div>
                    <form method="POST">
                        Назвние: <input type="text" name="name" required><br>
                        Описание: <input type="text" name="description" required><br>
                        Стоимость(руб): <input type="text" name="price" pattern="\d+" title="Пожалуйста, введите только числа" required><br>
                        Ссылка на изображение: <input type="text" name="img" required><br>
                        <input name="submit" type="submit" value="Добавить">
                    </form>
                </div>
            </div>
            <?php include 'Blocks/footer.php';?>
        </div>
    </body>
</html>
