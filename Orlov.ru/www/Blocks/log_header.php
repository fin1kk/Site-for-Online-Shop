
<div id="header">
            <div id="logo"><img src="photos/cactus.png" width="130px" height="130px" /></div>
            <div id="title">Топ магазин</div> 
            <?php if ($_SESSION['is_admin'] == 0)
            {
                echo "<button id=\"ShopCart\" type=\"button\" onclick=\"window.location.href='Shopping_cart.php';\"><img src=\"photos/card.png\" width=\"100%\" height=\"100%\" margin= \"0 auto\" position= \"relative\" />";
                echo "</button>";
            } ?>
            <button id="login" type="button" onclick="window.location.href='start_non_log_page.php';">Выйти</button>
            <?php if ($_SESSION['is_admin'] == 0)
            {
                echo '<div id="username_" style="color: white;"></div>';
            } ?>
            
            <?php if ($_SESSION['is_admin'] == 1)
            {
                echo "<button id=\"login\" type=\"button\" onclick=\"window.location.href='add_item.php';\">Создать товар</button>";
            } ?>
            <div id="username_"><?php print "Привет, ".$_SESSION['username']."!";?></div>
</div>
