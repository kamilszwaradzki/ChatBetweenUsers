<html>
    <head>
        <meta charset="UTF-8">
        <title>Czat</title>
        <style>
            #header-chat {
                height: 10%;
                width: 90%;
                background: gray;
            }
            #name {
                padding: 1em;
            }
            #chat-body {
                height: 80%;
                width: 90%;
                background: lightgray;
                display: grid;
                grid-template-rows: max-content;
                overflow-y: scroll;
            }
            .message_sender {
                padding: 1em;
                width: auto;
                max-width: 60%;
                background: aliceblue;
                margin-right: auto;
                margin-bottom: auto;
                border-bottom-right-radius: 1em;
            }
            .message_recipient {
                padding: 1em;
                width: auto;
                max-width: 60%;
                text-align: end;
                background: beige;
                margin-left: auto;
                margin-bottom: auto;
                border-bottom-left-radius: 1em;
            }
            #message-body {
                background: darkgray;
                width: 90%;
                align-items: baseline;
                display: flex;
            }
            #text-id {
                width: inherit;
                margin: 1em;
            }
            #send-btn {
                margin: auto 0 auto 0;
                padding: 0.5em;
                font-size: initial;
            }
            #users-list {
                float:left;
                width: auto;
                list-style: none;
            }
            li.user:hover {
                font-size: large;
                cursor: pointer;
            }
            #logout-id {
                position: fixed;
                right: 10%;
                top: 5%;
            }
        </style>
    </head>
    <body>
        <?php
        session_start();
        if (isset($_POST['logout'])) {
            session_unset();
        }
        if ($_SESSION['authenticated'] === true) {
            require_once 'Classes/User.php';
            $users = new User();
            echo '<h1>Użytkownicy</h1>';
            echo '<input type="hidden" id="current-user-id" value="' . $_SESSION['current_user'] . '"/>';
            echo '<ul id="users-list">';
            foreach ($users->getAllUsers() as $user){
                echo '<li class="user">' . $user['email'] . '<input type="hidden" value="' . $user['id'] . '"/></li>';
            }
            echo '</ul>';
        } else {
            header('Location: /login');
            return;
        }
        ?>
        <div style="float:right; width:88%; height: 80%;">
            <div id="header-chat">
                <div id="name">Nazwa odbiorcy</div>
            </div>
            <div id="chat-body">
                <div class="message_sender">Wiadomość Nadawcy</div>
                <div class="message_recipient">Wiadomość Odbiorcy</div>
            </div>
            <div id="message-body">
                <textarea id="text-id"></textarea>
                <input type="hidden" id="selected-recipient-id" value=""/>
                <button id="send-btn">Send</button>
            </div>
        </div>
        <form method='POST'><input type='submit' value="Wyloguj się" name='logout' id='logout-id' /></form>
        <script>
            async function postJSON() {
                try {
                  let sender = document.getElementById('current-user-id').value;
                  let recipient = document.getElementById('selected-recipient-id').value;
                  let message = document.getElementById('text-id').value;
                  const response = await fetch("/message/add/" + sender + "/" + recipient, {
                    method: "POST",
                    headers: {
                      "Content-Type": "application/x-www-form-urlencoded;charset=UTF-8"
                    },
                    body: [encodeURIComponent('messageBody') + "=" + encodeURIComponent(message)]
                  });
                  const result = await response.json();
                  console.log("Success:", result);
                  let messages_content = '';
                  messages_content += '<div class="message_sender">' + message + '</div>';
                  document.getElementById('chat-body').innerHTML += messages_content;
                } catch (error) {
                  console.error("Error:", error);
                }
            }
            async function getJSON(e) {
                try {
                  let sender = document.getElementById('current-user-id').value;
                  let recipient = e.target.children.item(0).value;
                  document.getElementById('name').innerText =  e.target.innerText;
                  document.getElementById('selected-recipient-id').value = recipient;
                  const response = await fetch("/message/" + sender + "/" + recipient, {
                    method: "GET",
                    headers: {
                      "Content-Type": "application/json",
                    },
                  });

                  const result = await response.json();
                  console.log("Success:", result);
                  let messages_content = '';
                  result.forEach((item)=> {
                      messages_content += '<div class="' + ( item.sender == sender ? 'message_sender' : 'message_recipient') + '">';
                      messages_content += item.message + '</div>';
                  });
                  document.getElementById('chat-body').innerHTML = messages_content;
                } catch (error) {
                  console.error("Error:", error);
                }
            }
            for (let item of document.getElementsByClassName('user')) {
                item.addEventListener('click', (e) => {
                    if (localStorage.getItem('myInterval')) {
                        var myI = localStorage.getItem('myInterval');
                        clearInterval(myI);
                    }
                    getJSON(e);
                    const myInterval = setInterval(async () => getJSON(e), 5000);
                    localStorage.setItem("myInterval", myInterval);
                });
            }
            document.getElementById('send-btn').addEventListener('click', () => {
                postJSON();
            });
        </script>
    </body>
</html>