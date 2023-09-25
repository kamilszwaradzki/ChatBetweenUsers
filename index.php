<?php
$request = $_SERVER['REQUEST_URI'];
$viewDir = '/Views/';

switch ($request) {
    case '':
    case '/':
        require __DIR__ . $viewDir . 'home.php';
        break;
    case '/register':
        require __DIR__ . $viewDir . 'register.php';
        break;
    case '/login':
        require __DIR__ . $viewDir . 'login.php';
        break;
    case '/chat':
        require __DIR__ . $viewDir . 'chat.php';
        break;
    default :
        if (str_starts_with($request, '/message')) {
            require 'Classes/Message.php';
            $message = new Message();
            $data = explode('/', $request);
            if ($data[2] === 'add') {
                list($sender, $recipient)= [$data[3], $data[4]];
                $message->addMessage($sender, $recipient, $_POST['messageBody']);
                echo json_encode(['message'=>'Added Successfuly']);
            } else {
                list($sender, $recipient)= [$data[2], $data[3]];
                echo json_encode($message->getAllMessagesByUsersId($sender, $recipient));
            }
            break;
        }
        exit('de hell??');
}
?>
