<?php

 include ('navbar.php');

 session_start();

 if(isset ($_SESSION['email']))
 {
    header('location:profile.php');
}
 if(isset($_POST['submit']))
 {
      $name  = $_POST['name'];
      $email  = $_POST['email'];
      $password  = $_POST['password'];
      $conpassword  = $_POST['conpassword'];
      $contact  = $_POST['contact'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $error_message ="Invalid Email!!! ";    
             }  
     else if (!filter_var($contact, FILTER_VALIDATE_INT) || strlen($contact) >10 || strlen($contact)<10) {
        $error_message ="Invalid Contact!!! ";
    } 
 
    else if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{6,20}$/', $password)) {
        $error_message ="Invalid Password!!! Password should Contain letter, number and a special character";
    }
    else if($conpassword!=$password){
        $error_message ="Password Not Match";
    }
    else
    {
        $fetchdata=new DB_con();
        $email= $_POST['email'];
        $result=$fetchdata->fetchChatData($email);
        $numResults = mysqli_num_rows($result);
        if($numResults>=1){
        $error_message ="Email Already Exists!!";
        }
        else{
            $res=$fetchdata->insertData($name,$email,md5($password) ,$contact);

           if($res==TRUE){
            $success_message ="User Registered "; 
           }
           else{
            $error_message ="Something Went Wrong!!";   
           }
        }
    }
}
?>
<div class="container">
<div class="main">
<?php if(!empty($error_message)) { ?>
    <div class="alert alert-danger">
    <?php echo $error_message;?>
    </div>
    <?php } ?>
       <?php if(!empty($success_message)) { ?>
        <script>
           window.location.href='upload-image.php?email=<?php echo  $email  ?>';
        </script>
        <?php } ?>
        <?php if(empty($success_message)) { ?>

    <form class="form" role="form" method ="post" action="signup.php" enctype="multipart/form-data">
    <div class="img"></div>
      <div class="topbar">
     <div class="active">Signup</div>
      </div>
      <div class="formelements">
      <input  type="text" name="name" class="form-control" id="name" placeholder="Name" required>
      <input type="text" name="email" class="form-control" id="email" placeholder="Email" required>
      <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
       <input type="password" name="conpassword" class="form-control" placeholder="Confirm Password" required>
      <input type="text" name="contact" class="form-control" id="contact"    placeholder="Contact" required>
     </div>
      <div class="bottombar">
    <p>By signing up, you agree to the License Agreement & The Privacy Policy</p>
     <button type="submit" name="submit"><i class="fa fa-user-plus"></i> Register</button>

      </div>    
    </form>
    </div>
    <?php } ?>
</div>
