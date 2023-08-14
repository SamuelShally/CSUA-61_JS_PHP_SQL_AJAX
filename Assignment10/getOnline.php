<?php
    // TODO: FIGURE OUT WHAT IS WRONG HERE!

    include('config.php');

    $time = time();
    $lastMinute = $time-30;

    $sql = "select username from lastAccessed where time > '$lastMinute';";
    $results = $db->query($sql);

    $users = array();

    if($results)
    {
        while ($row = $results->fetchArray())
        {
            array_push($users, $row['username']);
        }
    }

    print json_encode($users);
    exit();
?>