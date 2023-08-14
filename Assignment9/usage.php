<?php
    // connect to database!
    include('config.php');

   $line = date('Y-m-d H:i:s') . " - $_SERVER[REMOTE_ADDR]";

    $query = "insert into user (log) values ('$line');";
    $result = $db->query($query);

    print "success";
    exit();
 ?>
