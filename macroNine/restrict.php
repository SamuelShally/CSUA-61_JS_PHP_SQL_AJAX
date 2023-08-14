<?php
    // connect to database!
    include('config.php');

    $word = $_POST['word'];
    
    $query = "insert into banned (word) values ('$word');";
    $result = $db->query($query);

    print "$word";
    exit();
 ?>