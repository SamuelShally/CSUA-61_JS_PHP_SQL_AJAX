<!doctype html>
<html>
  <head>
    <title>Discussion!</title>
    <style>
   
    </style>
  </head>
  <body>
    <?php 
        //get the phrase sent 
        $phrase = $_POST['phrase'];
    ?>

    <h1>Search For: <div style="color:blue; display:inline;"><?php echo "$phrase";?></div></h1>

   <!-- return button -->
    <button id="return">Return Home</button>

    <h2><em>Posts</em></h2>
    <?php
        //connect to db
        include('config.php');  
        date_default_timezone_set('America/New_York');

        //create the sql query for posts
        $sqlp = "select * from posts where body like '%$phrase%' or name like '%$phrase%' or title like '%$phrase%'";

        //create the sql query for comments
        $sqlc = "select * from comments where body like '%$phrase%' or name like '%$phrase%'"; 
        
        //get the results - utilise twice for the check, reset the pointer
        $postResults = $db->query($sqlp);
        $postTest = $postResults->fetchArray();

        $postResults = $db->query($sqlp);
        

        if (!$postTest)
        {
            print "<p><em>Nothing to see here...</em></p>";
        }
        else
        {
            //output the posts
            while ($row = $postResults->fetchArray()) 
            {
            ?>
                <div>
                <hr>
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
        }

    ?>
    <h2><em>Comments</em></h2>
    <?php

    //get the results - utilise twice for the check, reset the pointer
    $commentsResults = $db->query($sqlc);
    $comTest = $commentsResults->fetchArray();

    $commentsResults = $db->query($sqlc);

    if (! $comTest)
    {
        print "<p>Nothing to see here...</p>";
    }
    else
    {
      // iterate over comments and display
      while ($row = $commentsResults->fetchArray()) 
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
    }
    ?>

    <script>
        let ret = document.getElementById("return");

        ret.onclick = function()
      {
        window.location.href = "index.php"; 
      }

    </script>

  </body>
</html>
