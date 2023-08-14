<!doctype html>
<html>
  <head>
    <style>
      textarea {
        resize: none;
        width: 300px;
        height: 100px;
      }

      .hidden{
        display: none;
      }
      .search
      {
        position: absolute;
         right: 0;
        display: inline;
      }
    </style>
  </head>
  <body>
        <!-- Search Box -->
        <div class="search"> 
      <form method="post" action="search.php">
        <input type="text" name="phrase"> 
        <input type="submit" id="submit" value="Search">
      </form>
    </div>

    <?php

    include('config.php');  
    date_default_timezone_set('America/New_York');

    // grab the ID of the question
    $id = $_GET['id'];

     // run a query against the database that grabs this post
     $sql = "SELECT * FROM posts WHERE id = $id";
     $result = $db->query($sql);
     $row = $result->fetchArray();
 
     // do something with it!
     $title = $row['title']; 
     print "<h1>$title</h1>";
    ?>

    <button id="return">Return Home</button>
    
    <!-- comment form -->
    <button id="new">Comment</button> <br>

    <!-- Comment save status -->
    <?php
        $status = $_GET['status'];
        
        if ($status == "invalid")
        {
          print ("<br><div style=width:100%;height:20px;background-color:red;text-align:center;padding:10px;color:white>INVALID DATA</div>");
        }
        else if($status == "valid")
        {
          print ("<br><div style=width:100%;height:20px;background-color:green;text-align:center;padding:10px;color:white>POSTED</div>");
        }

      ?>
      
    <div id="newComment" class="hidden">
      <br>
      <form method="post" action="saveComment.php">
        Username:
        <br>
        <input type="text" name="username">
        <br>
        Comment:
        <br>
        <textarea name="question"></textarea>
        <br>
        <input type="hidden" name="id" value='<?php echo "$id";?>'/>
        <input type="submit" id="submit">
      </form>
    </div>
    
    <?php
    $msg = $row["body"];

    print "<hr><p style=color:blue;>$msg</p>";

    $pretty_time = date("F j, Y, g:i a", $row['time']);
    print "<em>Posted by " . $row['name'] . " on " . $pretty_time . "<hr></em>";
    ?>

    <br><h3>Comments:</h3>
    <button style=disply:inline; id="sortNew">Sort By: Newest</button> 
    <button id="sortOld">Sort By: Oldest</button>
    <!-- display comments -->
    <?php

      date_default_timezone_set('America/New_York');

      $status = $_GET['status'];

      if ($status == "old")
      {
        $sql = "SELECT * FROM comments where post_id = $id ORDER BY time ASC";
      }
      else
      {
        $sql = "SELECT * FROM comments where post_id = $id ORDER BY time DESC";
      }

      $result = $db->query($sql);

      // iterate over comments and display
      while ($row = $result->fetchArray()) 
      {
        ?>
          <div>
            <p><?php

            $comment = $row['body'];
            $pretty_time = date("F j, Y, g:i a", $row['time']);
            print "<hr><p style=color:red;>$comment</p>";
            print "<em>Posted by " . $row['name'] . " on " . $pretty_time ."</em>";

            ?></p>

          </div>
          <hr>
        <?php
      }
    ?>

    <script>
      let ret = document.getElementById("return");
      let npButton = document.getElementById("new");
      let newPost = document.getElementById("newComment");
      let sortNew = document.getElementById("sortNew");
      let sortOld = document.getElementById("sortOld");
      let post_id = <?php echo "$id";?>;

      ret.onclick = function()
      {
        window.location.href = "index.php"; 
      }

      //hide and show comment box depending on click 
      npButton.onclick = function(event)
      {
        if (newPost.classList.contains("hidden"))
        {
          newPost.classList.remove("hidden");
        }
        else
        {
          newPost.classList.add("hidden");
        }
      }

      //sort by newest
      sortNew.onclick = function()
      {
          window.location.href = "view.php?status=new&id="+post_id; 
      }

      //sort by oldest
      sortOld.onclick = function()
      {
        window.location.href = "view.php?status=old&id="+post_id; 
      }

    </script>
  </body>
</html>
