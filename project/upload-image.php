<?php
 include ('navbar.php');


 $fetchdata=new DB_con();
 $email= $_REQUEST['email'];
 $result=$fetchdata->fetchChatData($email);
 $numrows = mysqli_num_rows($result);
 $imagePath = "./../upload/";
 if($numrows != 0 ){
   
   
  while( $row = mysqli_fetch_assoc($result)){
      $_SESSION['email']=  $email=$row['email'];
      $_SESSION['name'] = $name=$row['name'];
      $_SESSION['id'] =$row['id'];
      $image=$row['image'];
      $_SESSION['contact']=  $row['contact'];
}
 if(isset($_POST['submit']))
 {
 
      $uniquesavename=time().uniqid(rand());
      $destFile = $imagePath . $uniquesavename . '.jpg';
      $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
      $filename = $_FILES["image"]["name"];
      $filetype = $_FILES["image"]["type"];
      $filesize = $_FILES["image"]["size"];
      $ext = pathinfo($filename, PATHINFO_EXTENSION);
      if(!array_key_exists($ext, $allowed)) {
          $error_message="Error: Please select a valid file format.";
      }
     
      $maxsize = 5 * 1024 * 1024;
      if($filesize > $maxsize) {
          $error_message="Error: File size is larger than the allowed limit.";
      }
      if(in_array($filetype, $allowed)){
          if(file_exists("upload/" . $_FILES["image"]["name"])){
              $error_message= $_FILES["image"]["name"] . " is already exists.";
          } 
          else{
            
            if( move_uploaded_file($_FILES["image"]["tmp_name"], $destFile)){

                $res=$fetchdata->updateImage($destFile,$email);
              
                if($res==TRUE){
                    $success_message = 'Received image ' . $_FILES['image']['name'] . ' with size ' . $_FILES['image']['size'];
                }
                else{
                 $error_message ="Something Went Wrong!!";   
                }
              
            }
            else{
              $error_message= "Error: There was a problem uploading your file. Please try again. So Sorry"; 
            }
           
          } 
      } 
  
      else{
          $error_message= "Error: There was a problem uploading your file. Please try again."; 
      }
    }
 }
//  else{
//     $error_message="User Not Registered";
//     header('location:signup.php');
//  }
 ?>
 <div class="container">

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
        <?php } ?>
 <?php 
    if(!empty($destFile)) { 
     ?>

        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h3>Edit Your Image!!!</h3>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive">
                
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                    <img id="newImage" src="<?php echo $destFile ?>" alt="Image">
                    </div>
                </div>
            </div>
        </div>
     
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <button  class="btn btn-success" onclick=crop()><i class="fa fa-image"></i> Edit</button>
            </div>
        </div>
  

     <?php
    }
   

 ?>
  <?php if(empty($destFile)) {  ?>
    <form class="form-horizontal" role="form" method ="post" action="upload-image.php" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h2>Hey!! <?php echo $name?></h2> <br>
                <h3>Please Set Your Profile Photo!!</h3>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive">
                
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <div class="input-group-addon" style="width: 2.6rem">
                            <i class="fa fa-image"></i>
                        </div>
                        <input type="hidden" name="email" id="email"  class="form-control" value= <?php echo $email  ?> >
                        <input type="file" name="image" class="form-control"
                          id="image"   required>
                          <p><strong>Note:</strong> Only .jpg, .jpeg, .gif, .png formats allowed to a max size of 5 MB.</p>
                    </div>
                </div>
            </div>
        </div>
     
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-success" name="submit"><i class="fa fa-image"></i> Upload</button>
            </div>
        </div>
    </form>
  <?php } ?>
</div>

<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<link  href="https://cdn.rawgit.com/fengyuanchen/cropper/v2.0.1/dist/cropper.min.css" rel="stylesheet">
<script src="https://cdn.rawgit.com/fengyuanchen/cropper/v2.0.1/dist/cropper.min.js"></script>
<script>
    var $ele = $("#newImage");
    $ele.cropper();
        function crop (){
            $("#newImage").cropper('getCroppedCanvas').toBlob(function (blob) {
                var formData = new FormData();
                 formData.append('croppedImage', blob);
                   $.ajax({
                   type: "POST",
                    url: "upload.php",
                    data:formData,
                    processData:false,
                    contentType:false,
                    success:function(data){
                     window.location.href='profile.php';
                   },
                   error:function(data){
                    console.log(data)
                   }
                })
            });
        }
   

</script>