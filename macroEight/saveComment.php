<?php
  //Data from the form
  $username = $_POST['username'];
  $body = $_POST['question'];
  $post_id = $_POST['id'];

  //Data validation
  if ($username == "" || $body == "" || $post_id == "")
  {
     // for has some issue, send back - do not save - status = invalid
      header("Location: view.php?id=$post_id&status=invalid");
      exit();
  }

  // connect to database!
  include('config.php');

  //get current time
  $now = time();

  //inset into database
  $sql = "INSERT INTO comments (post_id, body, name, time) VALUES ('$post_id', '$body', '$username', $now)";
  $db->query($sql);

  //Data has been saved, send back - status = valid
  header("Location: view.php?id=$post_id&status=valid");
  exit();
 ?>


 