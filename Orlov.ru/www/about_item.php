<?php
session_start();

include_once '3_dataBase.php';

if (!isset($_SESSION['about_id']))
{
    header("Location: start_non_log_page.php");
}

$cookie_name='cart_'.$_SESSION['username'];
$flag =false;

$product;
$connect = connect_db("NewDataBase1");
$cart = json_decode($_COOKIE[$cookie_name], true);
$index = $_SESSION['about_id'];
$query = "SELECT * FROM ITEMS WHERE id = '$index'";
$result = mysqli_query($connect, $query);

if ($product = mysqli_fetch_assoc($result)) {
    $flag =true;
}

if(isset($_POST['to_cart'])) {
    $item_id = $_POST['product_id'];
    //echo "Товар с ID $item_id в корзине, количество: {$item['quantity']}<br>";

    
    // Проверяем, есть ли уже такой товар в корзине
    $item_exists = false;
    foreach($cart as $key => $item) {
        if($item['id'] == $item_id) {
            $item_exists = true;
            $cart[$key]['quantity'] += 1; // Увеличиваем количество товара
            break;
        }
    }

    if(!$item_exists) {
        // Если товара еще нет в корзине, добавляем его
        $new_item = array('id' => $item_id, 'quantity' => 1);
        $cart[] = $new_item;
    }

    // Кодируем корзину обратно в JSON и устанавливаем куки
    setcookie($cookie_name, json_encode($cart), time() + (86400 * 30), "/"); // Куки хранятся 30 дней
}

/*if(isset($_COOKIE[$cookie_name])) {
    //echo "{Точка 1}";
    if(is_array($cart)) {
        foreach($cart as $item) {
            //echo "Товар с ID {$item['id']} в корзине, количество: {$item['quantity']}<br>";
        }
    } else {
        echo "Ошибка в данных корзины";
    }
} */

?>

<!DOCTYPE html>
<head>
    <title>Shop</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="active_zone">
        <?php
        if (isset($_SESSION['username']))
        {
            include 'Blocks/log_header.php';
        }
        else
            include 'Blocks/non_log_header.php';
        ?>
        <div id="content">
            <button type="button" id="back_to_catalog" onclick="window.location.href='log_page.php';">Вернуться к каталогу</button>
            <?php
            if ($flag) {
                echo '<div style="border: 5px solid #292e32; background-color: #f5bb60; padding: 10px; display: flex; flex-direction: column; align-items: center; margin: 10px; margin-left: 165px; width: 60%; ">';
                echo "<img src='{$product['image_link']}' alt='{$product['name']}' style='width: 350px; '>";
                echo "<h1>{$product['name']}</h1>";
                echo "<p>{$product['description']}</p>";
                echo "<h3>{$product['price']} руб </h3>";
                echo '<form method="POST">';
                    if (isset($_SESSION['username']) and $_SESSION['is_admin'] == 0)
                    {
                        echo '<input type="hidden" name="product_id" value="' . $product['id'] . '">';
                        echo '<div id="incrementButton" style="font-size: 16px; color: black; background-color: #e4e5e4; border: none; padding: 10px 20px; cursor: pointer; display: inline-block;" onclick="updateValue('.$product['id'].')">В корзину</div>';
                    }
                echo '</form>';
                echo '</div>';
            }
            ?>
        </div>
        <script>
            function updateValue(productId) {
                if(productId != null)
                {
                    let allCookies = document.cookie;
                    let cookieArray = allCookies.split(";");
                    let cookies = {};

                    for (let i = 0; i < cookieArray.length; i++) {
                        let cookie = cookieArray[i].trim().split("=");
                        cookies[cookie[0]] = cookie[1];
                    }

                    let username = "<?php echo $_SESSION['username']; ?>";
                    let cookie_name = "cart_" + username;
                    //console.log(cookie_name);
                    let cartCookie = cookies[cookie_name];
                    let cart_js = JSON.parse(decodeURIComponent(cartCookie)); 
                    let itemExists = false;

                    for (let i = 0; i < cart_js.length; i++) {
                        if (cart_js[i].id === productId) {
                            itemExists = true;
                            cart_js[i].quantity += 1;
                        }
                    }

                    if (!itemExists) {
                        let newItem = { id: productId, quantity: 1 };
                        cart_js.push(newItem);
                    }

                    let cartJson = JSON.stringify(cart_js);

                    document.cookie = cookie_name + "=" + cartJson + "; expires=" + new Date(new Date().getTime() + 30 * 24 * 60 * 60 * 1000).toUTCString() + "; path=/";
                }

                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) 
                        {
                            document.getElementById('username_').innerHTML = xhr.responseText;
                        } 
                        else 
                        {
                            console.error('Ошибка при выполнении запроса:', xhr.status, xhr.statusText);
                        }
                    }
                };

                xhr.open('GET', 'get_cookie_data.php', true); // Путь к вашему PHP-скрипту
                xhr.send();
            }
            updateValue();
        </script>
        <?php include 'Blocks/footer.php';?> 
    </div>
    
</body>
</html>
