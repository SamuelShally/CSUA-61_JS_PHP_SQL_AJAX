<?php

    //stored inside the public_html folder
    // $path = getcwd() . '/dataBase';

    $path = "/home/ss13104/databases" ;
    $db = new SQLite3($path.'/data.db');

 ?>