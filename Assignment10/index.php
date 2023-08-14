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
      #signout
      {
        position: absolute;
        right: 50px;
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
    <button id=signout>Sign Out</button>
    <h1>Chat Room</h1>

      <!-- login system -->
    <div id="start"> 
      <!-- Show register or login windows -->
      <div> Register For an account: <button id="show_register_window">Register</button></div>
      <div> Already Registered: <button id="show_login_window">Log In</button></div>
      
      <br>
      <div style="color: red;" id="signin_msg" class="hidden"></div>

      <!-- log in window -->
      <div id="login_window" class="hidden">
        <br>
        username: <input type="text" id="user">
        <br>
        password: <input type="password" id="password">
        <br>
        <button id="signin">SIGN IN</button>
      </div>

      <!-- register window -->
      <div id="create_window" class="hidden">
      <br>
        username: <input type="text" id="newUser">
        <br>
        password: <input type="password" id="newPassword">
        <br>
        <button id="create_account">CREATE</button>
       </div>
    </div>
  

    <!-- Chat Box -->
    <div id="panel_chat" class="hidden">
      <div id="postError" style="color:red;" class="hidden">Message too short</div>
      <textarea readonly id="chat_log"></textarea>
      <input type="text" id="message">
      <button id="button_send">Send Message</button>
    </div>

    <!-- users currently online -->
    <br>
    <div id="online" class="hidden" style="width: 50%; background-color: white;color: black; padding: 10px; border: 1px solid black;">
      Online:
    </div>

    <script>
      let selectedName = 'samuel';
      let mouseOverTest = false;

         $(document).ready(function() {
             // Chat-Box Refferences
        let panel_chat = document.getElementById('panel_chat');
        let chat_log = document.getElementById('chat_log');
        let message = document.getElementById('message');
        let button_send = document.getElementById('button_send');
        let postError = document.getElementById("postError");
        

                /* ***PASSWORD SYSTEM*** */
        activateAccount();

        let start = document.getElementById("start");
        let show_register_window = document.getElementById("show_register_window");
        let show_login_window = document.getElementById("show_login_window");

        //login window
        let login_window = document.getElementById("login_window");
        let user = document.getElementById("user");
        let password = document.getElementById("password");
        let signin = document.getElementById("signin");

        //create account window
        let create_window = document.getElementById("create_window");
        let newUser = document.getElementById('newUser');
        let newPassword = document.getElementById("newPassword");
        let create_account = document.getElementById("create_account");

        //error message for bad log-ins or account registrations
        let signin_msg = document.getElementById("signin_msg");

        //sign out button
        let signout = document.getElementById("signout");

        //currently online box
        let onlineBox = document.getElementById("online");
        
        show_login_window.onclick = function()
        {
          login_window.classList.remove("hidden");
          create_window.classList.add("hidden");
        }

        show_register_window.onclick = function()
        {
          login_window.classList.add("hidden");
          create_window.classList.remove("hidden");
        }

        //sign in button
        signin.onclick = function()
        {
          signIn(user.value, password.value);
        }

        //Create account button
        create_account.onclick = function()
        {
          createAccount(newUser.value, newPassword.value);
        }

        signout.onclick = function()
        {
          $.ajax
          ({
              url: 'signout.php',
              type: 'get',
              data: 
              {},
              success: function(data, status) 
              {
                //refresh page
                window.location.href = "index.php"; 
              }
            });
        }

        function signIn(username, password)
        {
          $.ajax
          ({
              url: 'userSignIn.php',
              type: 'post',
              data: 
              {
                username: username,
                password: password
              },
              success: function(data, status) 
              {
                if (data == "error")
                {
                  signin_msg.innerHTML = "User does not exist...";
                  signin_msg.classList.remove("hidden");
                }
                else
                {
                  signin_msg.classList.add("hidden");
                }
              }
            });

            activateAccount();
        }

        function createAccount(username, password)
        {
          $.ajax
          ({
              url: 'create.php',
              type: 'post',
              data: 
              {
                  username: username,
                  password: password
              },
              success: function(data, status) 
              {
                  if (data == "exists")
                  {
                      signin_msg.innerHTML = "User already exitst";
                      signin_msg.classList.remove("hidden");
                  }
                  else
                  {
                      signin_msg.innerHTML = "Account Created!";
                      signin_msg.classList.remove("hidden");
                  }
              }
          });
        }

        function activateAccount()
        {
          //check if logged in - set username 
          $.ajax
          ({
              url: 'logInCheck.php',
              type: 'get',
              data: 
              {},
              success: function(data, status) 
              {
                  //set username if logged in
                  if (data != "error")
                  {
                    selectedName = data;
                    activateChat();
                  }
              }
          });
        }

        function activateChat()
        {
            signin_msg.classList.add("hidden");
            start.classList.add("hidden");
            login_window.classList.add("hidden");
            create_window.classList.add("hidden");

            //show the chat box
            panel_chat.classList.remove('hidden');    
            onlineBox.classList.remove("hidden");
        }

        // END OF PASSWORD SYSTEM...

        //know when mouse is over the chat room element
        chat_log.addEventListener("mouseover", function(event)
        {
             mouseOverTest = true;
        })

        chat_log.addEventListener("mouseleave", function(event)
        {    
            mouseOverTest = false;
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

              setTimeout( getData, 2000 );
            }
          })
        }

        function ping()
        {
          accessed();
          getOnline();
          setTimeout( ping, 2000 );
        }

        //update the last accessed time
        function accessed()
        {
          $.ajax
          ({
            type: "GET",
            url: 'accessTime.php',
            success: function(data, status){
              console.log(data);
            }
          }) 
        }

        //get all the users who are currently online
        function getOnline()
        {
          let onlineBox = document.getElementById("online");

          $.ajax({
            type:"GET", 
            url: "getOnline.php",
            success: function(data, status)
            {
              //array of all users that are currently online 
              let online = JSON.parse(data);
              let temp = "online: <br>";

              console.log(online);
              
              for (let x = 0; x<online.length; x++) 
              {
                temp = temp + online[x] + "<br>";
              } 
              onlineBox.innerHTML = temp;
            }
          })
        }

        //start the sequence
        getData();
        ping();
      });
    </script>
    </div>
  </body>
</html>
