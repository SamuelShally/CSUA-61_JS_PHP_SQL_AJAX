<!doctype html>
<html>
  <head>
    <title>Let's Chat</title>

    <!-- bring in the jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <style>
        #home
      {
        position: absolute;
         right: 0;
        display: inline;
      }
      .hidden {
        display: none;
      }
      body
      {
        font-family: 'Open Sans', sans-serif;
         background-color: #DEE2E6;
      }
    </style>
  </head>
  <body>
        <button id="home">Return</button>

        <h1> Admin Controls </h1>

      <!-- Add log in system.... -->
        <div id="incorrect" style="color:red;" class="hidden">Username or password are wrong...</div>
        <br>
         <div id="login">
            Username: <input type="text" id="username"> 
            <br><br>
            Password: <input type="password" id="password">
            <br><br>
           <button id="submit">Log-in</button>
        </div>
    
            <div id="adminControls" class="hidden">
            <hr>
            
            <h4> Clear Chat </h4>
            <div id="cleared" style="color:red" class="hidden">CHAT CLEARED!</div>
            <button id="clear">Clear Chat</button>

            <hr>
            
            <h4> Add restricted words </h4>
            <p style="color:red;" id="word_restricted"></p>
            <div id="panel_restrict" class="">
            Word: <input type="text" id="word">
            <button id="restrict">Restrict</button>
            </div>

            <hr>

            <h2> Usage Logs </h2>
            <div id="usageLogs">
            
            </div> 

            <hr>
        </div>

    <script>
        $(document).ready(function() 
        {
            let clear = document.getElementById("clear");
            let restrict = document.getElementById("restrict");
            let home = document.getElementById("home");
            let cleared = document.getElementById("cleared");
            let panel_restrict = document.getElementById("panel_restrict");
            let word = document.getElementById("word");
            let word_restricted = document.getElementById("word_restricted");
            let usageLogs = document.getElementById("usageLogs");
            let adminControls = document.getElementById("adminControls");
            let submit = document.getElementById("submit");
            let username = document.getElementById("username");
            let password = document.getElementById("password");
            let incorrect = document.getElementById("incorrect");

            //Super insecure login system
            //Username: samuel
            //Password: shally
            submit.onclick = function()
            {
                $.ajax({
                    url: 'login.php',
                    type: 'POST',
                    data: { 
                        password: password.value, 
                        username: username.value
                    },
                    success: function(data, status) 
                    {
                        if (data == "success")
                        {
                            login.classList.add("hidden");
                            incorrect.classList.add("hidden");
                        
                            adminControls.classList.remove("hidden");
                        }
                        else
                        {
                            incorrect.classList.remove("hidden");
                        }
                    }
                })
            }

            clear.onclick = function()
            {
                cleared.classList.add("hidden");
                $.ajax({
                    url: 'clear.php',
                    type: 'GET',
                    data: { },
                    success: function(data, status) 
                    {
                        if (data == "success")
                        {
                            cleared.classList.remove("hidden");
                        }
                        else
                        {
                            cleared.classList.add("hidden");
                        }
                    }
                })
            }

            restrict.onclick = function()
            {
                cleared.classList.add("hidden");

                $.ajax({
                    url: 'restrict.php',
                    type: 'POST',
                    data: { 
                        word: word.value
                    },
                    success: function(data, status) 
                    {
                        word_restricted.innerHTML = "The word " + "'" + data + "'"+ " has been restricted!";
                    }
                })   
            }

            //Generate full usage logs
            $.ajax({
                    url: 'getUsage.php',
                    type: 'GET',
                    data: { 

                    },
                    success: function(data, status) 
                    {
                        let parsed = JSON.parse(data);
                        
                        let usageText = '';
                        for (let i = 0; i < parsed.length; i++) {
                            usageText +=  parsed[i] + "<br>";
                        }
                        usageLogs.innerHTML = usageText;
                    }
                })   

            home.onclick = function()
            {
                window.location.replace("index.php");
            }
        })
    </script>
  </body>
</html>
