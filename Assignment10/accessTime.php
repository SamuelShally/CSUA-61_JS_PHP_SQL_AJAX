<?php
    include('config.php');
    session_start();

    $time = time();

    $logged = $_SESSION['loggedin'];
    $username = $_SESSION['username'];

    if ($logged == "yes")
    {
        //Get the last access time for the user 
        $time = time();
        $sql = "update lastAccessed set time = '$time' where username = '$username';";
        $run = $db->query($sql);

        print $time;
    }
    else
    {
        print "error";
    }

    exit();
?>