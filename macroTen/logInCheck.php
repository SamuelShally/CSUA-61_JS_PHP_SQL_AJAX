<?php
    session_start();

    if ($_SESSION['loggedin'] == "yes")
    {
        print  $_SESSION['username'];
    }
    else
    {
        print "error";
    }
    
    exit();
?>