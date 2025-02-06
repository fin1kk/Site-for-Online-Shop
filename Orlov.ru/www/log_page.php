<?php
session_start();

include_once '3_dataBase.php';

if (!isset($_SESSION['username']))
{
    header("Location: start_non_log_page.php");
}

$cookie_name='cart_'.$_SESSION['username'];
if(!isset($_COOKIE[$cookie_name]) and $_SESSION['is_admin'] == 0) {
    //echo $cookie_name;
    setcookie($cookie_name, json_encode(array()));
}

$product;
$connect = connect_db("NewDataBase1");
$cart = json_decode($_COOKIE[$cookie_name], true);

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

if(isset($_POST['about_item']))
{
    $_SESSION['about_id'] = $_POST['product_id'];
    header("Location: about_item.php");
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
        <?php include 'Blocks/log_header.php';?>
        <div id="content">
            <?php include 'castomfuncs.php';?>
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
