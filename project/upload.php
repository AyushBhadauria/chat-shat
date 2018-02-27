<?php
 include ('navbar.php');
 $fetchdata=new DB_con();

 if(isset ($_SESSION['email']))
 {
    $email= $_SESSION['email'];
    $result=$fetchdata->fetchChatData($email);
    $numrows = mysqli_num_rows($result);
 
    if($numrows != 0 ){
        echo "done";
        echo $email;
       $imagePath = "./../upload/cropped/";
       $uniquesavename=time().uniqid(rand());
       $croppedImage=$_FILES['croppedImage'];
      
       $to_upload=$croppedImage['tmp_name'];
       $destFile = $imagePath . $uniquesavename . '.jpg';
       if(move_uploaded_file($to_upload, $destFile)){
        $res=$fetchdata->updateImage($destFile,$email);
        $_SESSION['image']= $destFile;
        if($res==TRUE){
         echo 1;
         echo $destFile;
          $_SESSION['image']= $destFile;
        }
       else{
           echo 0;
       }
   }
   else{
       echo 0;
   }
    }
   
 }

 else{
    header('location:signup.php');
}
