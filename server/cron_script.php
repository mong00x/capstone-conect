<?php
    date_default_timezone_set('Australia/Darwin');
    echo "hello";
    // create file if not found 

    $file = fopen("001_test.txt", "a") or die("Unable to open file!");

    // append current time to file


    fwrite($file, date("Y-m-d H:i:s\n"));
    fwrite($file, "hello world\n");
    fclose($file);

    

?>