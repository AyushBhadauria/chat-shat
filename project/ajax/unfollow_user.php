<?php
 session_start();
if (isset($_POST['id'])) {
$mainId=$_SESSION['id'];
$userId=$_POST['id'];
require_once ('../chatbot.php');
$chat = new Chatbot();

$result = $chat->sendUnfollowRequest($mainId, $userId);
}
else{
    echo 'No id is sent';
}
?>
