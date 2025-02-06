<?php
session_start();
include_once '3_dataBase.php';

$cookie_name='cart_'.$_SESSION['username'];
$cart;
$connect = connect_db("NewDataBase1");

if (!isset($_SESSION['username']))
{
    header("Location: start_non_log_page.php");
}

if(isset($_COOKIE[$cookie_name])) {
    //echo "{Точка 1}";
    //echo $_COOKIE[$cookie_name];
    $cart = json_decode($_COOKIE[$cookie_name], true);
    if(is_array($cart)) {
        foreach($cart as $item) {
            //echo "Товар с ID {$item['id']} в корзине, количество: {$item['quantity']}<br>";
        }
    } else {
        echo "Ошибка в данных корзины";
    }
}

if(isset($_POST['delete_from_card'])) {

    $item_id = $_POST['product_id'];

    // Проверяем, есть ли уже такой товар в корзине
    $item_exists = false;
    foreach($cart as $key => $item) {
        if($item['id'] == $item_id) {
            if($item['quantity']>1)
            {
            $cart[$key]['quantity'] -= 1; 
            break;
            }
            else 
            unset($cart[$key]);
            break;
        }
    }

    // Кодируем корзину обратно в JSON и устанавливаем куки
    setcookie($cookie_name, json_encode($cart), time() + (86400 * 30), "/"); // Куки хранятся 30 дней
}


?>

<!DOCTYPE html>
<head>
    <title>Shop-Cart</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        form {
            text-align: center;+

            line-height: 2.1; 
        }
    </style>
</head>
<body>
    <div id="active_zone"> 
        <?php include 'Blocks/log_header.php';?>
            <script>
                function updateValue2(productId) 
                {
                    xhr = new XMLHttpRequest();
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
                updateValue2();
            </script>
        <div id="content">
            <button type="button" id="back_to_catalog" onclick="window.location.href='log_page.php';">Вернуться к каталогу</button>    
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

                    for (let i = 0; i < cart_js.length; i++) {
                        if (cart_js[i].id === productId) {
                            if(cart_js[i].quantity>1)
                            {
                                cart_js[i].quantity -=1;
                                break;
                            }
                            else
                            cart_js.splice(i, 1);
                            break;
                        }
                    }

                    let cartJson = JSON.stringify(cart_js);

                    document.cookie = cookie_name + "=" + cartJson + "; expires=" + new Date(new Date().getTime() + 30 * 24 * 60 * 60 * 1000).toUTCString() + "; path=/";
                }

                var xhr = new XMLHttpRequest();

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            document.getElementById('content').innerHTML = xhr.responseText;
                        } else {
                            console.error('Ошибка при выполнении запроса:', xhr.status, xhr.statusText);
                        }
                    }
                };

                xhr.open('GET', 'delete_from_cart.php', true); // Путь к вашему PHP-скрипту
                xhr.send();

                
            }
            updateValue();

            function updateValue2(productId) {
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
            updateValue2();
        </script>   
        
        <?php include 'Blocks/footer.php';?>
    </div>
    
</body>
</html>