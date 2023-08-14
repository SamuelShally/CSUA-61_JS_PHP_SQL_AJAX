<?php
  //Data from the form
  $username = $_POST['username'];
  $title = $_POST['title'];
  $question = $_POST['question'];

  //Data validation
  if ($username == "" || $title == "" || $question == "")
  {
     // for has some issue, send back - do not save - status = invalid
      header("Location: index.php?status=invalid");
      exit();
  }

  // connect to database!
  include('config.php');

  //get current time
  $now = time();

  //inset into database
  $sql = "INSERT INTO posts (title, body, name, time) VALUES ('$title', '$question', '$username', $now)";
  $db->query($sql);

  //Data has been saved, send back - status = vali
  header("Location: index.html?status=valid");
  exit();
 ?>


 