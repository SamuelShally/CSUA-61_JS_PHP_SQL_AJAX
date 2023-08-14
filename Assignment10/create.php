<?php
    $username = $_POST['username'];
    $password = $_POST['password'];

    include('config.php');

    //check if username exists
    $sql = "SELECT * FROM users WHERE (username = '$username')";
    $result = $db->query($sql)->fetchArray();

    if($result)
    {
        print "exists";
    }
    //create account
    else
    {
        $salt = 12345;
        $hashed = md5($password . $salt);

        $sql = "insert into users (username, password) values ('$username', '$hashed')";
        $result = $db->query($sql);

        //create first the last accessed ping
        $time = time();
        $sql = "insert into lastAccessed (username, time) values ('$username', '$time');";
        $run = $db->query($sql);

        print "created";
    }

    exit();
?>