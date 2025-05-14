<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Czat</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
        <style>
            body {
                background: linear-gradient(0.75turn, #9aced9, #addbd1, #d9ccc4);
            }
            #header-chat {
                min-height: 10%;
                width: 90%;
                background: gray;
            }
            #chat-body {
                max-height: 65%;
                width: 90%;
                background: lightgray;
                overflow-y: scroll;
                min-height: 30%;
            }
            .message_sender {
                padding: 1em;
                width: fit-content;
                max-width: 60%;
                background: aliceblue;
                margin-right: auto;
                margin-bottom: auto;
                border-bottom-right-radius: 1em;
                margin-top: 1em;
            }
            .message_recipient {
                padding: 1em;
                width: fit-content;
                max-width: 60%;
                text-align: end;
                background: beige;
                margin-top: 1em;
                margin-bottom: 1em;
                margin-left: auto;
                margin-bottom: auto;
                border-bottom-left-radius: 1em;
            }
            #message-body {
                background: darkgray;
                width: 90%;
                align-items: center;
                display: flex;
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
        </style>
    </head>
    <body>
    <?php
        session_start();
        if (isset($_POST['logout'])) {
            session_unset();
        }
        if (empty($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
            header('Location: /login');
            return;
        }
    ?>
        <div class="container-fluid text-center">
            <div class="row mb-3">
                <div class="col text-start d-none d-md-block">
                    <span class="badge my-2 fs-2 text-bg-secondary">ChatBetweenUsers</span>
                </div>
                <div class="col text-center">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="badge fs-3 text-reset fw-normal">Zalogowany jako:</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div id="current-user-name" class="badge text-reset fw-normal bg-light fs-4 p-3 rounded-pill"><?php echo $_SESSION['current_user_name']; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col text-end">
                    <input type="hidden" id="current-user-id" value="<?php echo $_SESSION['current_user']; ?>"/>
                    <form method='POST' class="my-2"><input type='submit' value="Wyloguj się" name='logout' id='logout-id' class="btn btn-lg btn-secondary"/></form>
                </div>
            </div>
            <div class="row h-75">
                <div class="col-3">
                    <?php
                        require_once 'Classes/User.php';
                        $users = new User();
                        echo '<div class="list-group">';
                        echo '<div class="list-group-item dropdown-header fs-4">Użytkownicy</div>';
                        foreach ($users->getAllUsers() as $user){
                            echo '<a class="list-group-item list-group-item-action user text-break fs-5">' . $user['email'] . '<input type="hidden" value="' . $user['id'] . '"/></a>';
                        }
                        echo '</div>';
                    ?>
                </div>
                <div class="col-9">
                    <div class="row justify-content-center rounded-top-3" id="header-chat">
                        <ul class="nav nav-tabs" id="chatRoomTabs">
                            <li class="nav-item">
                                <a class="nav-link active fs-5" aria-current="page" href="#" id="name">Nazwa odbiorcy</a>
                            </li>
                        </ul>
                    </div>
                    <div class="row" id="chat-body">
                        <div class="col">
                            <div class="row">
                                <div class="col-4 message_sender fs-5">Wiadomość Nadawcy</div>
                                <div class="col-8"></div>
                            </div>
                            <div class="row">
                                <div class="col-8"></div>
                                <div class="col-4 message_recipient fs-5">Wiadomość Odbiorcy</div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="message-body">
                        <div class="col">
                            <div class="input-group my-3">
                                <input type="text" id="text-id" class="form-control">
                                <div class="input-group-text">
                                    <input type="hidden" id="selected-recipient-id" value=""/>
                                    <button id="send-btn" class="btn">Wyślij</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                  let messages_content = '<div class="row">';
                  messages_content += '<div class="col-4 message_sender fs-5">' + message + '</div>';
                  messages_content += '<div class="col-8"></div>';
                  messages_content += '</div>';
                  document.getElementById('chat-body').innerHTML += messages_content;
                } catch (error) {
                  console.error("Error:", error);
                }
            }
            async function getJSON(e) {
                try {
                  let sender = document.getElementById('current-user-id').value;
                  
                  let recipient = '';
                  if(e.target.children.length > 0) {
                    recipient = e.target.children.item(0).value;
                  } else if(e.target.hasAttribute('href')) {
                    recipient = e.target.attributes['href'].value.replace('#','');
                  }
                  let userIdElems = document.getElementsByClassName('userIdClass');
                  let userIds = new Array();
                  for(const x of Array(userIdElems.length).keys()) {
                    userIds.push(userIdElems.item(x).value);
                  }
                  if(!userIds.includes(recipient)) {
                    const liNavItemUser = document.createElement("li");
                    liNavItemUser.className = 'nav-item';
                    const aNavLink = document.createElement("a");
                    aNavLink.className = 'nav-link text-light fs-5';
                    aNavLink.setAttribute('aria-current', 'page');
                    aNavLink.setAttribute('href', '#' + recipient);
                    aNavLink.innerText = e.target.innerText;
                    const inputUserId = document.createElement("input");
                    inputUserId.className = 'userIdClass';
                    inputUserId.setAttribute('type', 'hidden');
                    inputUserId.setAttribute('value', recipient);
                    inputUserId.setAttribute('name', "recipientId[" + recipient + "]");
                    liNavItemUser.appendChild(aNavLink);
                    liNavItemUser.appendChild(inputUserId);
                    document.getElementById('chatRoomTabs').appendChild(liNavItemUser);
                  }
                  if(document.getElementById('name') != null) {
                    document.getElementById('name').closest("li").remove();
                  }
                  document.getElementById('selected-recipient-id').value = recipient;
                  const response = await fetch("/message/" + sender + "/" + recipient, {
                    method: "GET",
                    headers: {
                      "Content-Type": "application/json",
                    },
                  });

                  const result = await response.json();
                  console.log("Success:", result);
                  let messages_content = '<div class="col">';
                  result.forEach((item)=> {
                    messages_content += '<div class="row">';
                    if (item.sender_id == sender) {
                        messages_content += '<div class="col-4 message_sender fs-5">' + item.message + '</div>';
                        messages_content += '<div class="col-8"></div>';
                    } else {
                        messages_content += '<div class="col-8"></div>';
                        messages_content += '<div class="col-4 message_recipient fs-5">' + item.message + '</div>';
                    }
                    messages_content += '</div>';
                  });
                  messages_content += '</div>';
                  document.getElementById('chat-body').innerHTML = messages_content;
                  const tabs = document.querySelectorAll('.nav-link');
                  for(let tab of tabs) {
                    var uIdCl = tab.closest('li').querySelector('.userIdClass');
                    if (uIdCl.value == recipient) { tab.className = 'nav-link active fs-5'; }
                    else { tab.className = 'nav-link text-light fs-5'; }
                  }
                } catch (error) {
                  console.error("Error:", error);
                }
            }

            const observer = new MutationObserver(() => {
                for(let tab of document.querySelectorAll('.nav-link')) {
                    tab.addEventListener('click', (e) => {
                        if (localStorage.getItem('myInterval')) {
                            var myI = localStorage.getItem('myInterval');
                            clearInterval(myI);
                        }
                        getJSON(e);
                        const myInterval = setInterval(async () => getJSON(e), 5000);
                        localStorage.setItem("myInterval", myInterval);
                    });
                }
            });

            observer.observe(document.querySelector("#chatRoomTabs"), {
                subtree: true,
                childList: true,
            });

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