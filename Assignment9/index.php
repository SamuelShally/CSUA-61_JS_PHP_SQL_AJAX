<!doctype html>
<html>
  <head>
    <title>Let's Chat</title>

    <!-- bring in the jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <!-- custom styles -->
    <style>
      #chat_log {
        display: block;
        width: 500px;
        height: 300px;
      }
      .hidden {
        display: none;
      }
      #admin
      {
        position: absolute;
         right: 0;
        display: inline;
      }
      body
      {
        font-family: 'Open Sans', sans-serif;
         background-color: #DEE2E6;
      }
     

    </style>
  </head>
  <body>
      <div id="main">
  <button id=admin>Admin</button>
    <h1>Chat Room</h1>
    
    <div id="nameError" class="hidden" style="color:red;">Invalid username, try again </div> 

    <div id="panel_name">
      <div> select a username (5 or more alpha-numeric characters):</div>
      <br>
      Name: <input type="text" id="username">
      <button id="button_save">Let's Chat!</button>
    </div>

    <div id="panel_chat" class="hidden">
       <button id="changeName">Change Name</button> 
      <div id="postError" style="color:red;" class="hidden">Message too short</div>
      <textarea readonly id="chat_log"></textarea>
      <input type="text" id="message">
      <button id="button_send">Send Message</button>
    </div>

    <script>
      let selectedName;

         $(document).ready(function() {

        // DOM refs
        let panel_name = document.getElementById('panel_name');
        let username = document.getElementById('username');
        let button_save = document.getElementById('button_save');
        let panel_chat = document.getElementById('panel_chat');
        let chat_log = document.getElementById('chat_log');
        let message = document.getElementById('message');
        let button_send = document.getElementById('button_send');
        let nameError = document.getElementById("nameError");
        let postError = document.getElementById("postError");
        let changeName = document.getElementById("changeName");
        let admin = document.getElementById("admin");

        let mouseOverTest = false;

        //admin log in
        admin.onclick = function()
        {   
            window.location.replace("admin.php");
        }
        
        //check if user has a name saved as a cookie
        if (window.localStorage.getItem("userName"))
        {
            //set the name to the entered value 
            selectedName = window.localStorage.getItem("userName");

            //hide the name pannel & error msg
            panel_name.classList.add('hidden');
            nameError.classList.add("hidden");

            //show the chat box
            panel_chat.classList.remove('hidden');
            changeName.classList.remove("hidden");
        }

        //know when mouse is over the chat room element
        chat_log.addEventListener("mouseover", function(event)
        {
             mouseOverTest = true;
        })

        chat_log.addEventListener("mouseleave", function(event)
        {    
            mouseOverTest = false;
        })

        //show username pannel
        changeName.onclick = function(event)
        {
            panel_name.classList.remove("hidden");
            changeName.classList.add("hidden");

        }
        
        button_save.addEventListener('click', function() {

          // validate the user's name using an AJAX call to the server
          $.ajax({
            url: 'validate_name.php',
            type: 'post',
            data: {
              name: username.value
            },
            success: function(data, status) {
              if (data == 'valid') 
              {
                 
                //set the name to the entered value 
                selectedName = username.value;

                //hide the name pannel & error msg
                panel_name.classList.add('hidden');
                nameError.classList.add("hidden");

                //show the chat box
                panel_chat.classList.remove('hidden');
                changeName.classList.remove("hidden");

                //drop a cookie to save the name
                window.localStorage.setItem("userName",selectedName);
              }
              else
              {
                nameError.classList.remove("hidden");
              }
            }
          });

        })

        button_send.addEventListener('click', function() {
          console.log(selectedName);
          // make an ajax call to the server to save the message
          $.ajax({
            url: 'save_message.php',
            type: 'post',
            data: {
              name: selectedName,
              message: message.value
            },

            //add the chat message to the chat box
            success: function(data, status) 
            {
                if(data == "success")
                {  
                    chat_log.value += selectedName + ': ' + message.value + "\n";
                    postError.classList.add("hidden");

                    //clear the input box
                    message.value = "";

                    //push textbox to bottom if not mouse over
                    if (mouseOverTest)
                    {

                    }
                    else
                    {
                        chat_log.scrollTop = chat_log.scrollHeight;
                    }
                }
                else
                {
                    postError.classList.remove("hidden");

                    if (data == "banned")
                    {
                        postError.innerHTML = "CONTAINS BANNED WORD!";
                    }
                    else
                    {
                        postError.innerHTML = "Message too short!";
                    }
                    console.log(data);
                }
            }
          });

        });

        function getData() {

        //real time update the chat box, every 3000ms
          $.ajax({
            url: 'get_messages.php',
            success: function(data, status) {
              let parsed = JSON.parse(data);

              let newChatroom = '';
              for (let i = 0; i < parsed.length; i++) {
                newChatroom += parsed[i].name + ': ' + parsed[i].message + "\n";
              }
              chat_log.value = newChatroom;

              if (mouseOverTest)
              {

              }
              else
              {
                chat_log.scrollTop = chat_log.scrollHeight;
              }

              setTimeout( getData, 3000 );
            }

            
          })

        }
        getData();
      });

    </script>

    <script>
        $(document).ready(function() 
        {
            //generate user logs
            $.ajax({
                url: 'usage.php',
                type: 'GET',
                data: { 
                },
                success: function(data, status) 
                {
                 
             
                }
            })   
        })
    </script>
    </div>
  </body>
</html>
