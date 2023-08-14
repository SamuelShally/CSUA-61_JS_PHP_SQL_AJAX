<?php

 // connect to database!
 include('config.php');

  // get post variables
  $name = $_POST['name'];
  $message = $_POST['message'];

  //Find out if there's any banned words in the message
  $test == FALSE; 

  //Create array of banned words
  $query = "select * from banned;";

  $result = $db->query($query);
  $banned = array();

  while ($row = $result->fetchArray()) 
  {
    array_push($banned, $row[1]);
  }

  //check message for banned words
  for ($x = 0; $x<count($banned); $x++)
  {
     $pos = stripos($message, $banned[$x]);

     if ($pos === FALSE)
     {
         continue;
     }
     else
     {
        print "banned";
        exit();
     } 
  }

  // make sure there's a message && no banned words
  if (strlen($message) > 0 || $test) {

    // add to database
    $message = $db->escapeString(addslashes(htmlspecialchars($message)));

    $sql = "INSERT INTO chats (name, message) VALUES ('$name', '$message')";
    $db->query($sql);

    print "success";
    exit();
  }

  print "fail";
  exit();

 ?>