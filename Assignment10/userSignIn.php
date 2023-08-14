<?php
  $username = $_POST['username'];
  $password = $_POST['password'];

  $salt = '12345';

  $hashed_password = md5($password . $salt);

  include('config.php');
  $sql = "SELECT * FROM users WHERE (username = '$username' AND password = '$hashed_password')";
  $result = $db->query($sql)->fetchArray();


  //If name and password exists result will have some value
    if ($result) 
    {
        session_start();

        // generate a new PHPSESSID cookie name
        session_regenerate_id();

        //Session variables - accesable accross all webpages
        $_SESSION['loggedin'] = 'yes';
        $_SESSION['username'] = $username;    

        print "success";
    }

    else 
    {
        print "error";
    }

    exit();
?>