<?php
 include ('navbar.php');

 $id2=$_SESSION['id'];
 echo $id;
  if(!isset ($_SESSION['email']))
  {
     header('location:login.php');
 }
 require_once ('chatbot.php');
$chat = new Chatbot();
if (isset($_REQUEST['id'])) {
$_SESSION['id3']=$id=$_REQUEST['id'];
$user = $chat->getUserById($id);
$name=$user['name'];
$email=$user['email'];
$gender=$user['gender'];
$contact=$user['contact'];
$about=$user['about'];
$hobbies=$user['hobbies'];
$interests=$user['interests'];
$image=$user['image'];
$following = $chat->getRequest();
foreach ($following as $value)
{ 
if($value['user_id']==$id2 && $value['following']==$id){   
$result=true;
}}
$followers = $chat->getUserFollowing();
?>
<div class="container">
    <div class="row my-2">
        <div class="col-lg-8 order-lg-2">
            <div class="tab-content py-4">
                <div class="tab-pane active" id="profile">
                <h2><?php echo $name ?> </h2>
                    <h5 class="mb-3">User Profile</h5>
                    <div class="row">
                        <div class="col-md-6">
                        <?php
                         if($result==true){ ?>
                           <h6><strong>Email</strong></h6>
                           <p><?php echo $email ?></p>
                           <h6><strong>Contact</strong></h6>
                           <p><?php echo $contact ?></p>
                           <?php }
                            else {   ?>
                                <div class="alert alert-info">Follow the user to see his Info</div>
                                <?php
                            
                            }?>
                         <h6><strong>About</strong></h6>
                            <p>
                            <p><?php echo $about ?></p>
                            </p>
                            <h6><strong>Hobbies</strong></h6>
                            <p><?php $hobbies = explode(',', $hobbies);
                            $len=1;
                            foreach ($hobbies as $value)
                                
                             { echo $len.'.' .$value;
                               echo '<br>';
                               $len++; 
                             } ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6><b>Interests</b></h6>
                            <?php $interests = explode(',', $interests);
                            $len=1;
                            foreach ($interests as $value)
                            {     
                                ?>
                            <a href="#" class="badge badge-dark badge-pill">
                         
                              <?php  echo $value; } ?>
                            </a>
                
                        </div>
                        <div class="col-md-6">
                            <h6><b>Followers</b></h6>
                            <?php
                            foreach ($following as $value)
                            {
                           if($value['user_id']==$id2 && $value['following']==$id)
                            {     
                                   ?>
                            <a href="#" class="badge badge-dark badge-pill">
                              <?php  echo $value['name']; }} ?>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <h6><b>Following</b></h6>
                            <?php
                            foreach ($followers as $value)
                            {
                           if($value['user_id']==$id)
                            {     
                                ?>
                            <a href="#" class="badge badge-dark badge-pill">
                              <?php  echo $value['name']; }} ?>
                            </a>
                        </div>
                        
                    </div>
    
                </div>
             </div>
  
        </div> 

        <div class="col-lg-4 order-lg-1 text-center">
            <img src="<?php echo $image ?>" class="mx-auto img-fluid img-circle d-block" alt="avatar">
            <h6 class="mt-2"><strong>
            <?php echo $name ?></strong></h6>
            <h6 class="mt-2">
            <?php echo $gender ?></h6>
            <input id="follow" hidden name="id" class="form-control" value= <?php echo $id  ?> >
            <?php
          
                  if($result==true){ ?>
                  <button id="following" class="btn btn-secondary" name="follow"> Following </button>
                  <button id="unfollow" type="submit" onclick=unfollow_user() class="btn btn-danger" name="unfollow"> <span class="unfollow">UnFollow</span></button>
            <?php } else
             { ?>
            <button type="submit" onclick=follow_user() class="btn btn-success" name="follow"> <span class="follow">Follow</span></button>
            <?php }
             ?>
        </div>
   </div>

</div>
<?php
}
                        
else{
    header('location:users.php');
}
?>
<script type="text/javascript" src="/blogsPro/project/script/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/blogsPro/project/script/script.js"></script>