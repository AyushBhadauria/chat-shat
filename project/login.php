<?php
 include ('navbar.php');
 if(isset ($_SESSION['email']))
 {
    header('location:profile.php');
}
 if(isset($_POST['submit']))
{

   $_SESSION['password']= $_POST['password'];
    $fetchdata=new DB_con();
    $email= $_POST['email'];
    $result=$fetchdata->fetchChatData($email);
    $numrows = mysqli_num_rows($result);
    $mypass= md5($_SESSION['password']);
    if($numrows != 0 ){
    while( $row = mysqli_fetch_assoc($result)){
        $dbpassword= $row['password'];
        if($dbpassword==$mypass){
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['name'] = $name=$row['name'];
        $_SESSION['id'] = $row['id'];
        $_SESSION['image']=  $image=$row['image'];
        $_SESSION['contact']=  $row['contact'];
        header('location:profile.php');
   
}
else{
    $error_message ="Invalid PAssword!!! "; 
}
        }
      
}
    else
    {
        $error_message ="Invalid Email!!! "; 
      
    }        
}

 ?>
<div class="container py-5">
<div class="main">
<?php if(!empty($error_message)) { ?>
    <div class="alert alert-danger">
    <?php echo $error_message;?>
    </div>
    <?php } ?>
       <?php if(!empty($success_message)) { ?>
        <div class="alert alert-success">
        <?php echo $success_message;
        
        ?>
        </div>
        <script>  setTimeout(() => {
       
         window.location.href='profile.php';
        }, 2000);</script>
        <?php } ?>


    <form class="form" role="form" method ="post" action="login.php">
    <div class="img"></div>
      <div class="topbar">
     <div class="active">Login</div>
      </div>
      <div class="formelements">
    
      <input type="text" name="email" class="form-control" id="email" placeholder="Email" required>
      <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
     </div>
      <div class="bottombar">
    <p>By signing up, you agree to the License Agreement & The Privacy Policy</p>
     <button type="submit" name="submit"> Login</button>

      </div>    
    </form>
    </div>
    </div>