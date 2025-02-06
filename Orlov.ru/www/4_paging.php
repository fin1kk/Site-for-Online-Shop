<?php

include_once '2_otstupi.php';
include_once '3_dataBase.php';

function paging_Module($zapros, $connect)
{
    $notesOnPage = 2;
    $result;

    if(isset($_GET['page']))
    {
        $page = intval($_GET['page']);
    }
    else
    {
        $page = 1;
    }
    $start_pos = ($page - 1) * $notesOnPage;
    
    $res_sql = SQL_Module("$zapros LIMIT $start_pos, $notesOnPage",$connect);
    var_dump_Module($res_sql);

    
    $total_records = mysqli_num_rows(mysqli_query($connect, $zapros));
    $total_pages = ceil($total_records / $notesOnPage);

    for ($i = 1; $i <= $total_pages; $i++)
    {
        echo "<a href='?page=$i'>$i</a> ";
    }
}

//Tests:
/*$connect = connect_db();
$res_sql = paging_Module("SELECT * FROM Users", $connect);*/

?>