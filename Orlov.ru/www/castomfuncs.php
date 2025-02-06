<?php
session_start();
include_once '3_dataBase.php';
include_once '2_otstupi.php';
//header("Content-Type: text/html; charset=UTF-8");

function castom_pagging($notesOnPage = 4)
{
    global $product;
    global $connect;
    $result = mysqli_query($connect, "SELECT * FROM ITEMS") or die(mysqli_error($connect));
    
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $start = ($page - 1) * $notesOnPage;
    $query = "SELECT * FROM ITEMS LIMIT $start, $notesOnPage";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));

    echo '<div style="display: flex; justify-content: center;flex-wrap: wrap;">';
    while ($product = mysqli_fetch_assoc($result)) {
        // Создаем блок для каждой записи
        
        echo '<div style="border: 5px solid #292e32; background-color: #f5bb60; padding: 10px; display: flex; flex-direction: column; align-items: center; margin: 10px; width: 40%; ">';
        echo "<img src='{$product['image_link']}' alt='{$product['name']}' style='width: 195px; height: 195px;'>";
        echo "<h3>{$product['name']}</h3>";
        echo "<div>{$product['price']} руб </div><br>";
            echo '<div id = content_div; style="display: flex;justify-content: space-around; width: 100%;">';
                echo '<form method="POST">';
                    echo '<input type="hidden" name="product_id" value="' . $product['id'] . '">';
                    echo '<input name="about_item" style="font-size: 16px; color: black; background-color: #e4e5e4; border: none; padding: 10px 20px; cursor: pointer; display: inline-block;" type="submit" value="О товаре">';
                    /*if (isset($_SESSION['username']) and $_SESSION['is_admin'] == 0)
                    {
                        echo '<input name="to_cart" type=\'button\' value="В корзину">';
                    }*/
                echo '</form>';
                if (isset($_SESSION['username']) and $_SESSION['is_admin'] == 0)
                    {
                        $user_name = $_SESSION['username'];
                        //echo '<div id="to_cart" onclick="updateValue(\'$product[\'id\']\')">В корзину</div>';
                        echo '<div id="incrementButton" style="font-size: 16px; color: black; background-color: #e4e5e4; border: none; padding: 10px 20px; cursor: pointer; display: inline-block;" onclick="updateValue('.$product['id'].')">В корзину</div>';
                        //echo '<div id="to_cart">В корзину</div>';
                    }
            echo '</div>'; 
        echo '</div>';
    }
    echo '</div>';
    echo "<br>";

    $total_records = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM ITEMS"));
    $total_pages = ceil($total_records / $notesOnPage);
    echo "<br>";
    
    // Генерируем пагинацию
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a style=\"color: #ffffff;\" href='?page=$i'>$i</a> ";
    }


}
castom_pagging(4);

?>