<!doctype html>
<html>
  <head>
    <title>Discussion!</title>
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
        <input type="submit" id="submit">
      </form>
    </div>

    <h1>Discussion Forum</h1>

    <hr> 
      <?php
        $status = $_GET['status'];
        
        if ($status == "invalid")
        {
          print ("<div style=width:100%;height:20px;background-color:red;text-align:center;padding:10px;color:white>INVALID DATA</div><br>");
        }
        else if($status == "valid")
        {
          print ("<div style=width:100%;height:20px;background-color:green;text-align:center;padding:10px;color:white>POSTED</div><br>");
        }

      ?>

       <button id="new"> New Post</button> <br>
      
      <div id="newPost" class="hidden">
        <br>
        <form method="post" action="save.php">
          Username:
          <br>
          <input type="text" name="username">
          <br>
          Title:
          <br>
          <input type="text" name="title">
          <br>
          Question:
          <br>
          <textarea name="question"></textarea>
          <br>
          <input type="submit" id="submit">
        </form>
       </div>

    <hr>

    <!--Sort By-->
    <button style=disply:inline; id="sortNew">Sort By: Newest</button> 
    <button id="sortOld">Sort By: Oldest</button>

    <!-- Get & display posts from the server -->
    <?php

      // connect to databases
      include('config.php');

      date_default_timezone_set('America/New_York');

      $status = $_GET['status'];
      
      if ($status == "old")
      {
        $sql = "SELECT * FROM posts ORDER BY time ASC";
      }
      else
      {
        $sql = "SELECT * FROM posts ORDER BY time DESC";
      }
    
      $result = $db->query($sql);

      // iterate over posts and display
      while ($row = $result->fetchArray()) 
      {
        ?>
          <div>
            <p><?php

            $title = $row['title']; 
            $pretty_time = date("F j, Y, g:i a", $row['time']);
            print "Posted by " . $row['name'] . " on " . $pretty_time;

            print "<br><br><strong>$title</strong> - <a href=view.php?id=" . $row['id'] . ">expand</a>";

            ?></p>

          </div>
          <hr>
        <?php
      }
     ?>

    <script>
      let npButton = document.getElementById("new");
      let newPost = document.getElementById("newPost");
      let sortNew = document.getElementById("sortNew");
      let sortOld = document.getElementById("sortOld");

      //hide and show addpost button depending on click 
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
          window.location.href = "index.php?status=new"; 
      }

      //sort by oldest
      sortOld.onclick = function()
      {
        window.location.href = "index.php?status=old"; 
      }

    </script>

  </body>
</html>
