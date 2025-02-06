<?php
header("Content-Type: text/html; charset=UTF-8");

function modific_var_dump($var, $indent = 0)
{
    $indent_str = str_repeat("\t", $indent);

    if (is_array($var))
    {
        echo "Array(" , count($var) , ") {\n";
        foreach ($var as $key => $value)
        {
            echo $indent_str . "\t'$key' => ";
            modific_var_dump($value, $indent + 1);
            echo ",\n";
        }
        echo $indent_str , "}";
    }
    else
    {
        echo $var;
    }
}

function var_dump_Module($var)
{
    echo "<pre>";
    modific_var_dump($var);
    echo "</pre>";
}

?>