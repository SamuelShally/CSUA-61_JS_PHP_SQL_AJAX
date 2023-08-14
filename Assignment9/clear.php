<?php
    // connect to database!
    include('config.php');

    $query = "delete from chats;";
    $result = $db->query($query);

    print "success";
    exit();
 ?>