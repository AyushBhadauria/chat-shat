<?php
 session_start();
 include ('../design/design.php');
 include ('conn.php');

?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
<div class="container">
<a class="navbar-brand" href="index.php">Chat Shat</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
 <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarResponsive">
<ul class="navbar-nav ml-auto">
<?php 
 if(!isset ($_SESSION['email']))
 { ?>
  <li style="padding:5px;" class="nav-item">
    <a class="btn btn-primary" href="login.php">Login</a>
  </li>
  <li style="padding:5px;"  class="nav-item">
    <a class="btn btn-success" href="signup.php">SignUp</a>
  </li>
  <?php } 
 if(isset ($_SESSION['email']))
 { ?>

  <div class="dropdown">
  <?php
   require_once ('chatbot.php');
   $chat = new Chatbot();
   $messages = $chat->getUserMessages();
   ?>
  <div class="buttons">
    <i class="fa fa-comments"></i>
    <?php
    if (!empty($messages)) {
   
      ?>
    <span class="button__badge"><?php echo sizeof($messages) ?></span>
<?php
    
  }
    ?>
  </div>
    <div class="dropdown-content">
    <table>
      <?php
      if (!empty($messages)) {
       
       
        foreach ($messages as $message) {
         
          $msg = htmlentities($message['message'], ENT_NOQUOTES);
          $user_name = ucfirst($message['name']);
          $image = ($message['image']);
          $email = ($message['email']);
          $sent = date('F j, Y, g:i a', $message['sent_on']);
          echo <<<MSG
          <tr class="msg-row-container">
            <td>
              <div class="msg-row">
                <div class="avatar">
                <img src="{$image}" style="width:30px;height:30px;">
                </div>
                <div class="message">
                  <span class="user-label"><a href="chats.php?email={$email}&seen=1&submit=true" style="color: #6D84B4;">{$user_name}</a> <span class="msg-time">{$sent}</span></span><br/>{$msg}
                </div>
              </div>
            </td>
          </tr>
MSG;
         
         
        }
      } else {
        echo '<span style="margin-left: 25px;">No chat messages available!</span>';
      }
      ?>
    </table>


</div>

 
</ul>
<ul class="navbar-nav ml-auto">
    <li class="nav-item">
    <button onclick=profile() class="btn btn-outline-warning my-2 my-sm-0" type="submit"><?php echo   $_SESSION['name']; ?></button>
  </li>
    <li class="nav-item">
    <button  id="logout" onclick=logout() class="btn btn-outline-danger my-2 my-sm-0" type="submit">Log Out</button>
    </li>
    <?php } ?>
  </ul>
  </div>
  </div>
</nav>
<script>
    function logout (){
      window.location.href='logout.php';
    }

</script>
<script>
    function profile (){
   
      window.location.href='profile.php';
    }

</script>
<script type="text/javascript" src="/blogsPro/project/script/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/blogsPro/project/script/script.js"></script>