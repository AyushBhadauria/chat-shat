<?php
 include ('navbar.php');
 $main= $_SESSION['id'];
 $email=$_SESSION['email'];
 $fetchdata=new DB_con();
 if(!isset ($_SESSION['email']))
 {
    header('location:login.php');
}
$seen=$_REQUEST['seen'];

if(isset($_REQUEST['submit']))
{
    $userEmail=$_REQUEST['email'];
    $user=$fetchdata->fetchChatData($userEmail);
    $numrows = mysqli_num_rows($user);
    if($numrows != 0 ){
    while( $row = mysqli_fetch_assoc($user)){
        $id=$row['id'];
        $name=$row['name'];
        $_SESSION['name2']=$name;
        $_SESSION['id2']=$id;
        $email=$row['email'];
        $gender=$row['gender'];
        $image=$row['image'];
}
  }
}
if($seen==1)
{
  $res=$fetchdata->seenMsg($seen,$main, $id);
}
require_once ('chatbot.php');
$chat = new Chatbot();
$messages = $chat->getMessages();
$id2= $_SESSION['id2'];
$id= $_SESSION['id'];
?>
<div class="container" style="border: 1px solid lightgray;">
  <div class="msg-wgt-header">
    <a href="#"><?php echo $name ?></a>
  </div>
  <div class="msg-wgt-body">
    <table>
      <?php
      if (!empty($messages)) {
        foreach ($messages as $message) {
          if($message['user_id']== $id && $message['user2_id']==$id2 || $message['user2_id']== $id && $message['user_id']==$id2){
          $msg = htmlentities($message['message'], ENT_NOQUOTES);
          $user_name = ucfirst($message['name']);
          $image = ($message['image']);
          $sent = date('F j, Y, g:i a', $message['sent_on']);
          echo <<<MSG
          <tr class="msg-row-container">
            <td>
              <div class="msg-row">
                <div class="avatar">
                <img src="{$image}" style="width:30px;height:30px;">
                </div>
                <div class="message">
                  <span class="user-label"><a href="#" style="color: #6D84B4;">{$user_name}</a> <span class="msg-time">{$sent}</span></span><br/>{$msg}
                </div>
              </div>
            </td>
          </tr>
MSG;
        }
      }
    
    }
      else {
        echo '<span style="margin-left: 25px;">No chat messages available!</span>';
      }
      ?>
    </table>
  </div>
  <div class="msg-wgt-footer">
    <textarea id="chatMsg" placeholder="Type your message. Press Shift + Enter for newline"></textarea>
    <button id="exit" class="btn btn-primary"  onclick=exit()>Exit Chat Room</button>
  </div>
</div>
<script type="text/javascript" src="/blogsPro/project/script/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/blogsPro/project/script/script.js"></script>
<script>
    function exit (){
  
 
      window.location.href='users.php';
 }
</script>