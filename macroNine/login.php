<?php
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username == "samuel" && $password=="shally")
    {
        print "success";
        exit();
    }
    else
    {
        print "fail";
        exit();
    }
?>