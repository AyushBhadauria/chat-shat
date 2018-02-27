<?php
 include ('navbar.php');
 $id=$_SESSION['id'];
$fetchdata=new DB_con();
 if(!isset ($_SESSION['email']))
 {
    header('location:login.php');
}
$name=$_SESSION['name'];
$email=$_SESSION['email'];
$image=$_SESSION['image'];
$contact=$_SESSION['contact'];
$sql=$fetchdata->fetchdata();

while( $row=mysqli_fetch_array($sql)){
    $interests=$row['interests'];
    $gender=$row['gender'];
    $hobbies=$row['hobbies'];
    $about=$row['about'];
    if(empty($hobbies) || empty($about) || empty($interests)){
     $message=true;
    }
    else{
        $message=false;
    }
}
require_once ('chatbot.php');
$chat = new Chatbot();
$followers = $chat->getUserFollowing();
$following = $chat->getRequest();
if(isset($_POST['submit']))
{
    $interests  = $_POST['interests'];
    $name  = $_POST['name'];
    $gender  = $_POST['gender'];
    $contact  = $_POST['contact'];
    $about  = $_POST['about'];
    $hobbies  = $_POST['hobbies'];
    $hobbies=implode(',',$hobbies);
    $hobbies = rtrim($hobbies,',');
    $interests=implode(',',$interests);
    $interests = rtrim($interests,',');
    $res=$fetchdata->updateUser($name,$contact,$gender,$hobbies, $interests,$email);
    if($res==TRUE){
        $success_message = "User Upadted";
    }
    else{
        $error_message = "Some Thing Went Wrong!!!";
    }
}
if(isset($_POST['onChange']))
{
    $oldpass  = $_POST['oldpassword'];
    $newpass  = $_POST['newpassword'];
    $conpass  = $_POST['conpassword'];
    if($conpass==$newpass){
        while( $row=mysqli_fetch_array($sql)){
            $dbpass=$row['password'];
            $newpass=md5($newpass);
            $oldpass=md5($oldpass);
            if($dbpass==$oldpass){
            $res=$fetchdata->updatePassword($newpass,$email);
              if($res==TRUE){
                 $success_message = 'User Password Updated';
                }
                else{
                 $error_message ="Something Went Wrong!!";   
                }
            }
            else{
                $error_message ="Invalid Old Password!!"; 
            }
        }   
    }
    else{
        $error_message ="Password Not Match!!"; 
    }
}
?>
    <header class="mastheads">
      <div class="overlay">
      <div class="container">
>
          <section class="section1 clearfix  " style="margin-top:100px">
              <div>
                  <div class="row grid clearfix">
                      <div class="col2 first">
                      <img src="<?php echo $image ?>" class="mx-auto img-fluid img-circle d-block" alt="avatar">
                          <h1><?php echo $name ?>   <p><i class="fa fa-envelope"></i> <b><?php echo $email ?></b></p>
                          <p><i class="fa fa-phone"></i> <b><?php echo $contact ?></b></p>
                        </h1>
                       
                       
                          <p><?php echo $about ?></p>
                          
                          <span >  <a style="color:white" href="users.php">Find Friends</a></span>
                      </div>
                      <div class="col2 last">
                          <div class="grid clearfix">
                              <div class="col3 last">
                                  <h1>694</h1>
                                  <span>Followers</span>
                           
                      </div>
                      <div class="col3 last">
                                  <h1>694</h1>
                                  <span>Following</span>
                           
                      </div>
                              
                           
                     
                  </div>
      
              </div>
              <span class="smalltri">
                  
              <i class="fa fa-star"></i>
              </span>
          </section>
  
  </div>	
      </div>
    </header>
<div class="container">
    <div class="row my-2">
        <div class="col-lg-8 order-lg-2">
        <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a onclick=profile() class="nav-link">Profile</a>
                </li>
                <li class="nav-item">
                    <a onclick=edit() data-toggle="tab" class="nav-link">Edit</a>
                </li>
            </ul>
            <div class="tab-content py-4">
                <div class="tab-pane active" id="profile">
                <?php if(!empty($error_message)) { ?>
                <div class="alert alert-danger">
                  <?php echo $error_message;?>
                  </div>
                    <?php } ?><?php echo $email ?>
                    <?php if(!empty($success_message)) { ?>
                    <div class="alert alert-success">
                    <?php echo $success_message;?>
                    </div>
                    <?php } ?>
                <?php if($message) { ?>
                <div class="alert alert-info alert-dismissable">
               
                     <a class="panel-close close" data-dismiss="alert">×</a> Your Profile is not complete. Complete your profile <strong><span  onclick=edit() >Here</span></strong>.
                    </div>
                <?php } ?>
                    <h5 class="mb-3">User Profile</h5>
                    <div class="row">
                        <div class="col-md-6">
                           <h6><strong>Email</strong></h6>
                           <p><?php echo $email ?></p>
                           <h6><strong>Contact</strong></h6>
                           <p><?php echo $contact ?></p>
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
                            <h6>Interests</h6>
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
                           if( $value['following']==$id)
                            {     
                                require_once ('chatbot.php');         ?>
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
                <div class="tab-pane" id="edit">
    

                    <form role="form"  method ="post" action="profile.php">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Full Name</label>
                            <div class="col-lg-9">
                                <input class="form-control" name =name type="text" value="<?php echo $name ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Email</label>
                            <div class="col-lg-9">
                                <input class="form-control"  name =email type="email" disabled value="<?php echo $email ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Contact</label>
                            <div class="col-lg-9">
                                <input class="form-control"  name =contact type="text" value="<?php echo $contact ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Gender</label>
                           
                            <div class="col-lg-9">
                        
                            <input type="radio" name="gender" value="Male"> Male
                            <input type="radio" name="gender" value="Female" > Female
                          
                            
                            </div>
                      
                           
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">About</label>
                            <div class="col-lg-9">
                                <input class="form-control"  name =about type="text"  value="<?php echo $about ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Hobbies</label>
                            <div class="col-lg-9">
                                <?php
                                $len=1;
                                 foreach ($hobbies as $value)
                                  {?>
                                    <div id="fields">
                                    <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                     <span class="input-group-text" id="basic-addon1"><?php echo $len ?> </span>
                                    </div>
                                    <input type="text" class="form-control" name="hobbies[]" placeholder="Your Hobby" value="<?php echo $value ?>" aria-describedby="basic-addon1">
                                    <div class="input-group-prepend">
                                     <span class="input-group-text" id="basic-addon1"> X</span>
                                    </div>
                                    </div>
                                    </div>
                                    <?php
                                  $len++; 
                                  
                                  } ?>
                
                                <input id="more_fields" onclick="add_fields();"  class="btn btn-info" value="Add More Hobbies">
                                 <hr/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Interests</label>
                            <div class="col-lg-9">
                            <div id="inter">
                                <?php
                                $len=1;
                                 foreach ($interests as $value)
                                  {?>
                                  
                                    <div class="input-group mb-3">
                                    <div class="input-group-prepend">$id
                                     <span class="input-group-text" id="basic-addon1"><?php echo $len ?> </span>
                                    </div>
                                    <input type="text" class="form-control" name="interests[]" placeholder="Your Interest" value="<?php echo $value ?>" aria-describedby="basic-addon1">
                                    </div>
                                   
                                    <?php
                                  $len++; 
                                  
                                  } ?>
                                 </div>
                                <input id="more_interest" onclick="add_interest();"  class="btn btn-info" value="Add More Interests">
                                 <hr/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label"></label>
                            <div class="col-lg-9">
                                <input type="submit" name="submit" class="btn $idbtn-primary" value="Save Changes">
                            </div>
                        </div>
                    </form>
                        <div class="form-group row" id="pass">
                            <label class="col-lg-3 col-form-label form-control-label">Password</label>
                            <div class="col-lg-9">
                            <div class="input-group mb-3">
                        
                                <input class="form-control" type="password" disabled value="11111122333">
                                <div class="input-group-prepend">
                                     <span class="input-group-text"  onclick=changePass() id="basic-addon1" > <i class="fa fa-repeat"></i> </span>
                                    </div>
                           </div>
                            </div>
                        </div>
                        <div id=changePass style="display:none;">
                        <form class="form-horizontal" role="form" method ="post" action="profile.php">
                        <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-lab$idel">Old Password</label>
                        <div class="col-lg-9">
                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"> <i class="fa fa-key"></i> </span>
                            </div>
                            <input class="form-control"  name="oldpassword" type="password">
                            
                       </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">New Password</label>
                        <div class="col-lg-9">
                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"> <i class="fa fa-key"></i> </span>
                            </div>
                            <input class="form-control"  name="newpassword" $idtype="password">
                           
                       </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Confirm Password</label>
                        <div class="col-lg-9">
                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"> <i class="fa fa-key"></i> </span>
                        </div>
                            <input class="form-control" name="conpassword" type="password" >
                            
                       </div>
                        </div>
                       
                        
                    </div>
                    <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label"></label>
                            <div class="col-lg-9">
                                <input type="submit" name="onChange" class="btn btn-warning" value="Change Password">
                            </div>
                        </div>
                        </form>
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
            <a class="btn btn-primary" href="users.php">Find Friends</a>
        </div>
    </div>
</div>
<script>
function edit()
{
    var hide=document.getElementById('profile')
    var show=document.getElementById('edit')
    if (show.style.display === "none") {
        show.style.display = "block";
        hide.style.display = "none";
    } else {
        show.style.display = "none";
        hide.style.display = "block";
    }
}
function changePass()
{
  
    var show=document.getElementById('changePass')
    if (show.style.display === "none") {
        show.style.display = "block";
       
    } else {
        show.style.display = "none";
      
    }
}
function profile()
{
    var hide=document.getElementById('edit')
    var show=document.getElementById('profile')
    if (show.style.display === "none") {
        show.style.display = "block";
        hide.style.display = "none";
    } 

    else {
        show.style.display = "none";
        hide.style.display = "block";
    }
}

    var hobby = <?php echo sizeof($hobbies); ?>;
    function add_fields() {
    hobby++;
    var objTo = document.getElementById('fields')
    var divtest = document.createElement("div");
    divtest.innerHTML ='<div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">'+ hobby +'</span></div><input type="text" class="form-control" name="hobbies[]" placeholder="Your Hobby " aria-label="Username" aria-describedby="basic-addon"> </div>';

    objTo.appendChild(divtest)
}
var interest = <?php echo sizeof($interests); ?>;
    function add_interest() {
    interest++;
    var objTo = document.getElementById('inter')
    var divtest = document.createElement("div");
    divtest.innerHTML ='<div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">'+ interest +'</span></div><input type="text" class="form-control" name="interests[]" placeholder="Your Interests " aria-label="Username" aria-describedby="basic-addon"> </div>';

    objTo.appendChild(divtest)
}

</script>

