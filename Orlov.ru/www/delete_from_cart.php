<?php
include_once '3_dataBase.php';
session_start();
$cookie_name='cart_'.$_SESSION['username'];
$connect==connect_db("NewDataBase1");

if(isset($_COOKIE[$cookie_name])) {
    $cart = json_decode($_COOKIE[$cookie_name], true);
    echo "<button type=\"button\" id=\"back_to_catalog\" onclick=\"window.location.href='log_page.php';\">Вернуться к каталогу</button>";
    
    if(count($cart)>0) {
        echo "<p style=\" margin-left: 370px; color: white;\">|  Кол-во: | Стоимость: | Сумма:  |</p>";
        foreach($cart as $item) {
            $item_id = $item['id'];
            $query = "SELECT * FROM ITEMS WHERE id = '$item_id'";
            $result = mysqli_query($connect, $query);
            $product = mysqli_fetch_assoc($result);
            
            echo "<div id=\"sidebar\">"; 
            echo "<div class=\"card_item\">";
            echo "<div class=\"item_name\" width= \"90px\">{$product['name']}</div>";
            echo "<div class=\"parametres\">{$item['quantity']}</div>";
            echo "<div class=\"parametres\">{$product['price']}</div>";
            $total_price = $item['quantity'] * $product['price'];
            echo "<div class=\"parametres\">{$total_price}</div>"; 
            echo '<form method="POST">';
                echo '<input type="hidden" name="product_id" value="' . $item['id'] . '">';
                echo '<div id="incrementButton" style="font-size: 16px; text-align: center; width: 45px; height: 30px; color: black; background-color: #e4e5e4; border: none; padding: 10px 20px; cursor: pointer; display: inline-block;" onclick="updateValue('.$product['id'].'); updateValue2('.$product['id'].')">Удалить 1шт</div>';
            echo '</form>';
            echo '</div>';
        }
    } 
    else 
    {
        echo "<p style=\"font-size: 25px; color: white;\">В корзине нет товаров</p>";
    }
}
?>


