<?php

require_once ('../chatbot.php');

$chat = new Chatbot();
$messages = $chat->getUserMessages();

if (!empty($messages)) {
    $length= sizeof($messages);

    echo <<<MSG
    $length
MSG;

}
else {
  echo 0;
  
}
?>