<?php
session_start();

if (isset($_POST['msg'])) {
  require_once ('../chatbot.php');
  $userId = (int) $_SESSION['id'];
  $user2Id = (int) $_SESSION['id2'];
  $name = $_SESSION['name'];
  $msg = htmlentities($_POST['msg'],  ENT_NOQUOTES);
  
  $chat = new Chatbot();
  $result = $chat->addMessage($userId, $user2Id,$name, $msg);
}
?>