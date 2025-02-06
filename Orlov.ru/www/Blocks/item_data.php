<div style="border: 5px solid #292e32; background-color: #f5bb60; padding: 10px; display: flex; flex-direction: column; align-items: center; margin: 10px; width: 40%; ">
        <img src="{$food['image_link']}" alt="{$food['name']}" style="width: 130px; height: 130px;"><br>
        <h4>{$food['name']}</h4>
        <h4>{$food['price']} руб </h4>
        <div style="display: flex;justify-content: space-around; width: 100%;">
        <button onclick="button_in_basket( $food['id'] )">В корзину</button>
        <button onclick="button_to_description( $food['id'] )">О предмете</button>
        </div>
</div>';
