<?php
session_start();
session_unset();

include_once '3_dataBase.php';
$product;
$connect = connect_db("NewDataBase1");

if(isset($_POST['about_item']))
{
    $_SESSION['about_id'] = $_POST['product_id'];
    header("Location: about_item.php");
}

?>

<!DOCTYPE html>
<head>
    <title>Shop</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="active_zone">
        <?php include 'Blocks/non_log_header.php';?>
        <div id="content">
            <?php include 'castomfuncs.php';?>
        </div>
        <?php include 'Blocks/footer.php';?> 
    </div>
    
</body>
</html>
