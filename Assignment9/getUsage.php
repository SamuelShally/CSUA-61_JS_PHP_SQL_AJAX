<?php
     // connect to database!
  include('config.php');

  // grab all messages from db
  $sql = "SELECT * FROM user";
  $results = $db->query($sql);

  $return_array = array();

  while ($row = $results->fetchArray()) 
  {
      
    array_push($return_array, $row["log"]);

  }

  print json_encode($return_array);
  exit();
?>