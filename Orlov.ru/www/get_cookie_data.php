<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");
$cookie_name='cart_'.$_SESSION['username'];
if(isset($_COOKIE[$cookie_name])) {
    $cart = json_decode($_COOKIE[$cookie_name], true);
    if(is_array($cart)) {
        $count_in_cart = 0;
        foreach($cart as $item) {
            //echo "Товар с ID {$item['id']} в корзине, количество: {$item['quantity']}<br>";
            $count_in_cart += $item['quantity'];
        }
        //echo $count_in_cart;
        print "В корзине: ".$count_in_cart;
    //$count = count($cookie_data);
    //echo $count;
} else {
    echo "0";
}
}
?>


