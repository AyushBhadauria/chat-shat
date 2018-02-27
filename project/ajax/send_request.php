<?php
 session_start();
if (isset($_POST['id'])) {
$mainId=$_SESSION['id'];
$_SESSION['id3']=$userId=$_POST['id'];
require_once ('../chatbot.php');
$chat = new Chatbot();

$result = $chat->sendRequest($mainId, $userId);
}
else{
    echo 'No id is sent';
}
?>
