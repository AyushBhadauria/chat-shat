<?php

require_once ('../chatbot.php');

$chat = new Chatbot();
$messages = $chat->getMessages();
$chat_converstaion = array();
$id2= $_SESSION['id2'];
$id= $_SESSION['id'];
if (!empty($messages)) {
  $chat_converstaion[] = '<table>';
  foreach ($messages as $message) {
    if($message['user_id']== $id && $message['user2_id']==$id2 || $message['user2_id']== $id && $message['user_id']==$id2){
    $msg = htmlentities($message['message'], ENT_NOQUOTES);
    $user_name = ucfirst($message['name']);
     $image = ($message['image']);
    $sent = date('F j, Y, g:i a', $message['sent_on']);
    $chat_converstaion[] = <<<MSG
      <tr class="msg-row-container">
        <td>
          <div class="msg-row">
            <div class="avatar">
            <img src="{$image}" style="width:30px;height:30px;">
            </div>
            <div class="message">
              <span class="user-label"><a href="#" style="color: #6D84B4;">{$user_name}</a> <span class="msg-time" >{$sent}</span></span><br/>{$msg}
            </div>
          </div>
        </td>
      </tr>
MSG;
  }

}
  $chat_converstaion[] = '</table>';
} else {
  echo '<span style="margin-left: 25px;">No chat messages available!</span>';
}

echo implode('', $chat_converstaion);
?>