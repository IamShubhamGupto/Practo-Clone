<?php
    $myfile = fopen("key.txt", "r") or die("Unable to open file!");
    $key = fgets($myfile);
    echo $key;
    fclose($myfile);
?>